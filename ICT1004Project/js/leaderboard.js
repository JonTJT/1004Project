$(document).ready(function () {
    var leaderboard_tables = document.getElementsByClassName("leaderboard_table");
    if (leaderboard_tables !== null) {
        createTable(leaderboard_tables);
    }
});

function createTable(leaderboard_tables) {
    for (let i = 0; i < leaderboard_tables.length; i++) {
        var tablename = leaderboard_tables[i].getAttribute('id')+"table";
        var table = document.getElementById(tablename);
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        cell1.innerHTML = "1";
        cell2.innerHTML = "Wesley";
        cell3.innerHTML = "999999";
    }




}