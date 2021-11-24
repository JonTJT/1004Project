<?php
require '../database_function.php';

//need to get userID to replace the first parameter
$errorMsg = saveScore(7, "Tetris", 20000);
console_log($errorMsg);
?>

<html lang="en">

    <head>
<?php include "../head.inc.php"; ?>
        <link href="../css/tetris.css" rel="stylesheet" type="text/css">
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
        <script defer src="../js/tetris.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <link href="../css/tetris.css" rel="stylesheet" type="text/css">
    </head>

    <body class="body_bg text-white" onload="init()">
<?php include "../nav.inc.php"; ?>

        <main class="container">
            <div class="wrap">
                <div id="windows">
                    <div id="score">
                        <span>SCORE</span>
                        <div class="score-info">0</div>
                    </div>
                    <div id="hold">
                        <span>HOLD</span>
                        <canvas width="160" height="160"></canvas>
                    </div>
                    <div id="linfo">
                        <span>LEVEL</span>
                        <div class="level-info">1</div>
                        <span>LINES</span>
                        <div class="lines-info">0</div>
                    </div>
                    <div id="game">
                        <canvas width="320" height="640"></canvas>
                    </div>
                    <div id="next"><span>NEXT</span>
                        <canvas width="160" height="480"></canvas>
                    </div>
                </div>

                <div class="buttons">
                    <div id="soundtoggle" onclick="toggleSound()">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M10 35 h20 l20 -20 v70 l-20 -20 h-20z"/>
                        <path id="soundON" style="display:none" d="M68 50 h22 M65 25 l20 -10 M65 75 l20 10"/>  
                        <path id="soundOFF" style="" d="M65 40 l20 20 M65 60 l20 -20"/>
                        </g>
                        </svg>
                    </div>
                    <div id="pausetoggle" onclick="togglePause()">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M20 20 h15 v60 h-15z M80 20 h-15 v60 h15z"/>
                        </g>
                        </svg>		
                    </div>
                </div>

                <div class="buttons" id="screenkeys">
                    <div id="keyLRot">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M50 10 l40 40 h-25 v40 h-30 v-40 h-25z"/>
                        </g>
                        </svg>		
                    </div>
                    <div id="keyRRot">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M50 10 l40 40 h-25 v40 h-30 v-40 h-25z"/>
                        </g>
                        </svg>
                    </div>
                    <div id="keyLeft">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M10 50 l40 40 v-25 h40 v-30 h-40 v-25z"/>
                        </g>
                        </svg>				
                    </div>
                    <div id="keyRight">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M90 50 l-40 40 v-25 h-40 v-30 h40 v-25z"/>
                        </g>
                        </svg>
                    </div>
                    <div id="keyDown">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M50 90 l40 -40 h-25 v-40 h-30 v40 h-25z"/>
                        </g>
                        </svg>						
                    </div>
                    <div id="keyDDown">
                        <svg viewBox="0 0 100 100">
                        <g fill="#cde" stroke-width="10" stroke="#cde" stroke-linejoin="round" stroke-linecap="round">
                        <path d="M50 90 l40 -40 h-80z M50 50 l40 -40 h-80z"/>
                        </g>
                        </svg>						
                    </div>
                </div>



                <input type="radio" name="menupick" id="mp-none" class="killafter"/>
                <div id="menus">
                    <!--menus before starting the game: -->
                    <input type="radio" name="menupick" id="mp-main" checked/>
                    <div>
                        <span>MAIN MENU</span>
                        <label for="mp-none" onclick="startNewGame(0)">Play</label>
                        <label for="mp-options">Options</label>
                        <label for="mp-help">Controls</label>
                    </div>
                    <input type="radio" name="menupick" id="mp-options"/>
                    <div>
                        <span>OPTIONS</span>
                        <label for="mp-sound">Sound options</label>
                        <label onclick="toggleScreenkeys()">Screen keys <span class="spanON" id="skspan">ON</span></label>
                        <label onclick="toggleFullscreen()">Fullscreen <span class="spanOFF fullscreentoggle">OFF</span></label>
                        <hr/>
                        <label for="mp-main" id="back2menu" style="">Back</label>
                        <label for="mp-pause" id="back2pause" style="display:none">Back</label>
                    </div>
                    <input type="radio" name="menupick" id="mp-sound"/>
                    <div>
                        <span>SOUND</span>
                        <label onclick="toggleSound()">Toggle sound <span class="spanOFF" id="soundspan">OFF</span></label>
                        <p>Master volume: <span id="masterVolumeSpan"></span></p>
                        <input type="range" id="masterVolume" min="0" max="10" value="2" oninput="setGains()"/>
                        <p>SFX volume: <span id="sfxVolumeSpan"></span></p>
                        <input type="range" id="sfxVolume" min="0" max="10" value="8" oninput="setGains()"/>
                        <p>Music volume: <span id="musicVolumeSpan"></span></p>
                        <input type="range" id="musicVolume" min="0" max="10" value="4" oninput="setGains()"/>
                        <hr/>
                        <label for="mp-options">Back</label>
                    </div>
                    <input type="radio" name="menupick" id="mp-gameoptions"/>
                    <div>
                        <span>GAME OPTIONS</span>
                        <p>Speed of a chill game (applies only when starting a new game): <span id="chillSpeedSpan"></span></p>
                        <input type="range" id="chillSpeed" min="1" max="11" value="1"/>
                        <hr/>
                        <label for="mp-options">Back</label>
                    </div>
                    <input type="radio" name="menupick" id="mp-help"/>
                    <div>
                        <span>CONTROLS</span>
                        <p>Left/Right/Down - move<br/>Up - rotate<br/>Space - slam down<br/>C - hold<br/>P/Esc - Pause</p>
                        <hr/>
                        <label for="mp-main">Back</label>
                    </div>

                    <!--in-game (pause) menus: -->
                    <input type="radio" name="menupick" id="mp-pause"/>
                    <div>
                        <span>PAUSE</span>
                        <label for="mp-none" onclick="togglePause()">Return</label>
                        <label for="mp-options">Options</label>
                        <label for="mp-end">End game!</label>
                    </div>
                    <input type="radio" name="menupick" id="mp-end"/>
                    <div>
                        <span>SURE TO END?!</span>
                        <label for="mp-main" onclick="endGame()">Yes</label>
                        <label for="mp-pause">No</label>
                    </div>

                    <!--game over (only from script): -->
                    <input type="radio" name="menupick" id="mp-over"/>
                    <div>
                        <span>GAME OVER! :(</span>
                        <p>Score: <span class="score-info">0</span></p>
                        <label for="mp-main">OK</label>
                    </div>
                </div>	
            </div>

        </main>

<?php include "../footer.inc.php"; ?>
    </body>
</html>

