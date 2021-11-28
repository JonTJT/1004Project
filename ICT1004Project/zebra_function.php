<?php

class Zebra_Session {

    private $flash_data;
    private $flash_data_var;
    private $link;
    private $lock_timeout;
    private $lock_to_ip;
    private $lock_to_user_agent;
    private $session_lifetime;
    private $table_name;
    private $read_only = false;

    public function __construct(
        &$link,
        $security_code,
        $session_lifetime = '',
        $lock_to_user_agent = true,
        $lock_to_ip = false,
        $gc_probability = '',
        $gc_divisor = '',
        $table_name = 'SessionData',
        $lock_timeout = 60,
        $start_session = true,
        $read_only = false
    ) {

        // continue if the provided link is valid
        if (($link instanceof MySQLi && $link->connect_error === null) || $link instanceof PDO) {

            // store the connection link
            $this->link = $link;

            // make sure session cookies never expire so that session lifetime
            // will depend only on the value of $session_lifetime
            ini_set('session.cookie_lifetime', 0);

            // tell the browser not to expose the cookie to client side scripting
            // this makes it harder for an attacker to hijack the session ID
            ini_set('session.cookie_httponly', 1);

            // make sure that PHP only uses cookies for sessions and disallow session ID passing as a GET parameter
            ini_set('session.use_only_cookies', 1);

            // instruct the session module to only accepts valid session IDs generated by the session module and rejects
            // any session ID supplied by users
            ini_set('session.use_strict_mode', 1);

            // if on HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')

                // allows access to the session ID cookie only when the protocol is HTTPS
                ini_set('session.cookie_secure', 1);

            // if $session_lifetime is specified and is an integer number
            if ($session_lifetime != '' && is_integer($session_lifetime))

                // set the new value
                ini_set('session.gc_maxlifetime', (int)$session_lifetime);

            // if $gc_probability is specified and is an integer number
            if ($gc_probability != '' && is_integer($gc_probability))

                // set the new value
                ini_set('session.gc_probability', $gc_probability);

            // if $gc_divisor is specified and is an integer number
            if ($gc_divisor != '' && is_integer($gc_divisor))

                // set the new value
                ini_set('session.gc_divisor', $gc_divisor);

            // get session lifetime
            $this->session_lifetime = ini_get('session.gc_maxlifetime');

            // we'll use this later on in order to try to prevent HTTP_USER_AGENT spoofing
            $this->security_code = $security_code;

            // some other defaults
            $this->lock_to_user_agent = $lock_to_user_agent;
            $this->lock_to_ip = $lock_to_ip;

            // the table to be used by the class
            $this->table_name = '`' . trim($table_name, '`') . '`';

            // the maximum amount of time (in seconds) for which a process can lock the session
            $this->lock_timeout = $lock_timeout;

            // set read-only flag
            $this->read_only = $read_only;

            // register the new handler
            session_set_save_handler(
                array(&$this, 'open'),
                array(&$this, 'close'),
                array(&$this, 'read'),
                array(&$this, 'write'),
                array(&$this, 'destroy'),
                array(&$this, 'gc')
            );

            // if a session is already started, destroy it first
            if (session_id() !== '') session_destroy();

            // start session if required
            if ($start_session) session_start();

            // the name for the session variable that will be used for
            // holding information about flash data session variables
            $this->flash_data_var = '_zebra_session_flash_data_ec3asbuiad';

            // assume no flash data
            $this->flash_data = array();

            // if any flash data exists
            if (isset($_SESSION[$this->flash_data_var])) {

                // retrieve flash data
                $this->flash_data = unserialize($_SESSION[$this->flash_data_var]);

                // destroy the temporary session variable
                unset($_SESSION[$this->flash_data_var]);

            }

            // handle flash data after script execution
            register_shutdown_function(array($this, '_manage_flash_data'));

        // if no MySQL connection
        } else throw new Exception('Zebra_Session: No MySQL connection');

    }

    /**
     *  Custom close() function
     *
     *  @access private
     */
    function close() {

        // release the lock associated with the current session
        return $this->query('

            SELECT
                RELEASE_LOCK(?)

        ', $this->session_lock) !== false;

    }

    /**
     *  Custom destroy() function
     *
     *  @access private
     */
    function destroy($session_id) {

        // delete the current session from the database
        return $this->query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_id = ?

        ', $session_id) !== false;

    }

    /**
     *  Custom gc() function (garbage collector)
     *
     *  @access private
     */
    function gc() {

        // delete expired sessions from database
        $this->query('

            DELETE FROM
                ' . $this->table_name . '
            WHERE
                session_expire < ?

        ', time());

    }

    /**
     *  Gets the number of active (not expired) sessions.
     *
     *  <i>The returned value does not represent the exact number of active users as some sessions may be unused
     *  although they haven't expired.</i>
     *
     *  <code>
     *  // get the number of active sessions
     *  $active_sessions = $session->get_active_sessions();
     *  </code>
     *
     *  @return integer     Returns the number of active (not expired) sessions.
     */
    public function get_active_sessions() {

        // call the garbage collector
        $this->gc();

        // count the rows from the database
        $result = $this->query('

            SELECT
                COUNT(session_id) as count
            FROM
                ' . $this->table_name . '

        ');

        // return the number of found rows
        return $result['data']['count'];

    }

    public function get_settings() {

        // get the settings
        $gc_maxlifetime = ini_get('session.gc_maxlifetime');
        $gc_probability = ini_get('session.gc_probability');
        $gc_divisor     = ini_get('session.gc_divisor');

        // return them as an array
        return array(
            'session.gc_maxlifetime'    =>  $gc_maxlifetime . ' seconds (' . round($gc_maxlifetime / 60) . ' minutes)',
            'session.gc_probability'    =>  $gc_probability,
            'session.gc_divisor'        =>  $gc_divisor,
            'probability'               =>  $gc_probability / $gc_divisor * 100 . '%',
        );

    }

    /**
     *  Custom open() function
     *
     *  @access private
     */
    function open() {

        return true;

    }

    /**
     *  Custom read() function
     *
     *  @access private
     */
    function read($session_id) {

        $this->session_lock = 'session_' . sha1($session_id);

        // if we are *not* in read-only mode
        // read-only sessions do not need a lock
        if (!$this->read_only) {

            // try to obtain a lock with the given name and timeout
            $result = $this->query('SELECT GET_LOCK(?, ?)', $this->session_lock, $this->lock_timeout);

            // stop if there was an error
            if ($result['num_rows'] != 1) throw new Exception('Zebra_Session: Could not obtain session lock');

        }

        $hash = '';

        // if the sessions is locked to an user agent
        if ($this->lock_to_user_agent && isset($_SERVER['HTTP_USER_AGENT']))

            $hash .= $_SERVER['HTTP_USER_AGENT'];

        // if session is locked to an IP address
        if ($this->lock_to_ip && isset($_SERVER['REMOTE_ADDR']))

            $hash .= $_SERVER['REMOTE_ADDR'];

        // append this to the end
        $hash .= $this->security_code;

        // get the active (not expired) result associated with the session id and hash
        $result = $this->query('

            SELECT
                session_data
            FROM
                ' . $this->table_name . '
            WHERE
                session_id = ?
                AND session_expire > ?
                AND hash = ?
            LIMIT
                1

        ', $session_id, time(), md5($hash));

        // if there were no errors and data was found
        if ($result !== false && $result['num_rows'] > 0)

            // return session data
            // don't bother with the unserialization - PHP handles this automatically
            return $result['data']['session_data'];

        // if hash has changed or the session expired
        $this->destroy($session_id);

        // on error return an empty string - this HAS to be an empty string
        return '';

    }

    public function regenerate_id() {

        // regenerates the id (create a new session with a new id and containing the data from the old session)
        // also, delete the old session
        session_regenerate_id(true);

    }

    public function set_flashdata($name, $value) {

        // set session variable
        $_SESSION[$name] = $value;

        // initialize the counter for this flash data
        $this->flash_data[$name] = 0;

    }

    public function stop() {

        // if a cookie is used to pass the session id
        if (ini_get('session.use_cookies')) {

            // get session cookie's properties
            $params = session_get_cookie_params();

            // unset the cookie
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);

        }

        // destroy the session
        session_unset();
        session_destroy();

    }

    /**
     *  Custom write() function
     *
     *  @access private
     */
    function write($session_id, $session_data) {

        // we don't write session variable when in read-only mode
        if ($this->read_only) return true;

        // insert OR update session's data - this is how it works:
        // first it tries to insert a new row in the database BUT if session_id is already in the database then just
        // update session_data and session_expire for that specific session_id
        // read more here https://dev.mysql.com/doc/refman/8.0/en/insert-on-duplicate.html
        return $this->query('

            INSERT INTO
                ' . $this->table_name . '
                (
                    session_id,
                    hash,
                    session_data,
                    session_expire
                )
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                session_data = VALUES(session_data),
                session_expire = VALUES(session_expire)

        ',

            $session_id,
            md5(
                ($this->lock_to_user_agent && isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '') .
                ($this->lock_to_ip && isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '') .
                $this->security_code
            ),
            $session_data,
            time() + $this->session_lifetime

        ) !== false;

    }

    /**
     *  Manages flash data behind the scenes
     *
     *  @access private
     */
    function _manage_flash_data() {

        // if there is flash data to be handled
        if (!empty($this->flash_data)) {

            // iterate through all the entries
            foreach ($this->flash_data as $variable => $counter) {

                // increment counter representing server requests
                $this->flash_data[$variable]++;

                // if this is not the first server request
                if ($this->flash_data[$variable] > 1) {

                    // unset the session variable
                    unset($_SESSION[$variable]);

                    // stop tracking
                    unset($this->flash_data[$variable]);

                }

            }

            // if there is any flash data left to be handled
            if (!empty($this->flash_data))

                // store data in a temporary session variable
                $_SESSION[$this->flash_data_var] = serialize($this->flash_data);

        }

    }

    /**
     *  Mini-wrapper for running MySQL queries with parameter binding with or without PDO
     *
     *  @access private
     */
    private function query($query) {

        // if the provided connection link is a PDO instance
        if ($this->link instanceof PDO) {

            // if executing the query was a success
            if (($stmt = $this->link->prepare($query)) && $stmt->execute(array_slice(func_get_args(), 1))) {

                // prepare a standardized return value
                $result = array(
                    'num_rows'  =>  $stmt->rowCount(),
                    'data'      =>  $stmt->columnCount() == 0 ? array() : $stmt->fetch(PDO::FETCH_ASSOC),
                );

                // close the statement
                $stmt->closeCursor();

                // return result
                return $result;

            }

        // if link connection is a regular mysqli connection object
        } else {

            $stmt = mysqli_stmt_init($this->link);

            // if query is valid
            if ($stmt->prepare($query)) {

                // the arguments minus the first one (the SQL statement)
                $arguments = array_slice(func_get_args(), 1);

                // if there are any arguments
                if (!empty($arguments)) {

                    // prepare the data for "bind_param"
                    $bind_types = '';
                    $bind_data = array();
                    foreach ($arguments as $key => $value) {
                        $bind_types .= is_numeric($value) ? 'i' : 's';
                        $bind_data[] = &$arguments[$key];
                    }
                    array_unshift($bind_data, $bind_types);

                    // call "bind_param" with the prepared arguments
                    call_user_func_array(array($stmt, 'bind_param'), $bind_data);

                }

                // if the query was successfully executed
                if ($stmt->execute()) {

                    // get some information about the results
                    $results = $stmt->get_result();

                    // prepare a standardized return value
                    $result = array(
                        'num_rows'  =>  is_bool($results) ? $stmt->affected_rows : $results->num_rows,
                        'data'      =>  is_bool($results) ? array() : $results->fetch_assoc(),
                    );

                    // close the statement
                    $stmt->close();

                    // return result
                    return $result;

                }

            }
            throw new Exception($stmt->error);

        }

    }

}