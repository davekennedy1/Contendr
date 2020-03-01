<?php
    session_start();
    if (!isset($_SESSION['13072064_contendrUnom'])) {
        header('Location: ../index.php');
    }
    $sessionUser = $_SESSION['13072064_contendrUnom'];
    $uid = $_SESSION['13072064_contenderUID'];
    include("../conn.php");
    include("TeamPlayer.php");

    $matchID = $conn->real_escape_string(trim($_GET['gameid']));

    // check if teams are set first
    $noOfPlayers = 0;
    $teamsSet = 0;
    $unevenNumbers = false;
    $playerPool = array();
    $teamA = array();
    $teamB = array();

    $playerList = "SELECT Sps_User.UserID, Sps_User.Name, Sps_Rank.RankScore, Sps_Rank.TimesRanked, Sps_User.haveAvatar, Sps_User.AvatarLocation, Sps_Match.NoOfPlayers, Sps_Match.TeamsSet, Sps_Match.MaxPlayers, Sps_Match.MinPlayers FROM Sps_Match
                   INNER JOIN Sps_PlayersMatch
                   ON Sps_Match.MatchID = Sps_PlayersMatch.MatchID
                   INNER JOIN Sps_User
                   ON Sps_PlayersMatch.UserID = Sps_User.UserID
                   INNER JOIN Sps_UserSport
                   ON Sps_User.UserID = Sps_UserSport.UserID
                   INNER JOIN Sps_Rank
                   ON Sps_UserSport.RankID = Sps_Rank.RankID
                   WHERE Sps_Match.MatchID = $matchID AND Sps_UserSport.SportID = Sps_Match.SportID AND Sps_UserSport.ProficiencyLevelID = Sps_Match.ProficiencyLevelID";

    $playerListResult = $conn->query($playerList);

    while($row = $playerListResult->fetch_assoc()) {
        $noOfPlayers++;
        $teamsSet = $row['TeamsSet'];
        $player = new TeamPlayer();
        $player->set_name($row['Name']);
        $player->set_id($row['UserID']);
        $player->set_rankScore($row['RankScore']);
        $player->set_timesRanked($row['TimesRanked']);
        $player->set_haveAvatar($row['haveAvatar']);
        $player->set_avatarLocation($row['AvatarLocation']);
        array_push($playerPool, $player);
        $player->get_name();

    }
    if($teamsSet == 0) {
        $teamSize = (int)($noOfPlayers/2);

        if($teamSize * 2 < $noOfPlayers) {                      // Might not need this
            $unevenNumbers = true;
        }
        // Set Team A
        for($loop = 0; $loop <= $teamSize; $loop++) {
            array_push($teamA, $playerPool[$loop]);
        }
        // Set Team B
        for($loop = $teamSize +1 ; $loop < $noOfPlayers; $loop++) {
            array_push($teamB, $playerPool[$loop]);
        }
    }
    foreach ($playerPool as $TeamPlayer) {
        $name = $TeamPlayer->get_name();
    }


    // if not get all players in a match and fill the list with them - two arrays

    // else query the teams and load them into two different arrays for display

    // have a button for contendr to pick teams

    // query to get team names and the teams if they're set.

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> Probably don't need this-->

    <title>Contendr</title>
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body class='indexbk'>
<?php
include('usernav.php');
?>
<div class='container '>
    <h2 class='indexStrap'>Pick Teams</h2>
    <div class="form-row align-items-center teamBody">

        <div class="col-6">
            <ul class="list-group ">
                <li class="list-group-item">
                    <input type="text" placeholder="Team Name One" size="15" maxlength="20">
                </li>
                <?php
                    foreach ($teamA as $contendr){
                        $name = $contendr->get_name();
                        $id = $contendr->get_id();
                        echo "
                            <li class='list-group-item'>
                                <table>
                                    <tbody>
                                    <tr >
                                        <td class='teamMemberText tableNameWidth swappable'>$name</td>
                                        <td><button class='button'><i class='fas fa-angle-right'></i></button></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </div>

        <div class="col-6 team2List">
            <ul class="list-group">
                <li class="list-group-item align-items-center">
                    <input class='textRight' type="text" placeholder="Team Name Two" size="15" maxlength="20">
                </li>
                <?php
                    foreach ($teamB as $contendr){
                        $name = $contendr->get_name();
                        $id = $contendr->get_id();
                        echo "
                                <li class='list-group-item'>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td><button class='button'><i class='fas fa-angle-left'></i></button></td>
                                            <td class='textRight teamMemberText tableNameWidth swappable'>$name</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </li>
                            ";
                    }
                if($unevenNumbers) {
                    echo"
                        <li class='list-group-item listVisible'>
                             '
                        </li>
                    ";
                }
                ?>
            </ul>
        </div>
    </div>

</div>


</div>
<?php
include('../footer.php');
?>
<?php
$conn->close();
?>
</body>
</html>

