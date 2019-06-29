<?php
// This is the last time the database was updated with new information on races, etc
//TODO: automate this to pull from database last edit date on relevant tables.
$date = "2/22/2019";
/*
$lNameMax = "SELECT COUNT(*) FROM tblLName";
$raceMax = "SELECT COUNT(*) FROM tblrace";
$townMax = "SELECT COUNT(*) FROM tbltown";
$background = "SELECT COUNT(*) FROM tblBackground";
$teperamentMax = "SELECT COUNT(*) FROM tblTemperament";
$adjectiveMax = "SELECT COUNT(*) FROM tblAdjective";
*/

function getRandomResult($table, $field){
    $date = "2/13/2019";
    $servername = "localhost";
    $username = "admin_browser";
    $password = "BrowserPw";
    $dbname = "admin_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT COUNT(" . $field . ") FROM $table";
    //echo $sql;
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    //print_r($row);
    $max = $row['COUNT(' . $field . ')'];
    //echo("max number is " . $max);
    $random = rand(1, $max);
    //echo("random number is " . $max);
    $sql = "SELECT "  . $field . " FROM " . $table ." WHERE id = ". $random;
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        //echo("RESULTS ARE IN!");
        
        while($row = mysqli_fetch_assoc($result)) {          
            return $row["$field"];
        }
    }
    mysqli_close($conn);
}

function getTotalCombinations(){
    $servername = "localhost";
    $username = "admin_browser";
    $password = "BrowserPw";
    $dbname = "admin_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $tables = array("tblAdjectives", "tblAlignment", "tblBackground", "tblClass", "tblFName", "tblLName", "tblRace", "tblValue");
    $combinations = 1;
    foreach($tables as $value){
        $sql = "SELECT COUNT(id) FROM $value";
        //echo $sql;
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        //print_r($row);
        $max = $row['COUNT(id)'];
        $combinations *= $max;
    }
    mysqli_close($conn);
    return $combinations;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<link rel="stylesheet" href="style.css">
<script async defer src="https://buttons.github.io/buttons.js"></script>
<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAD/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEQEQAAAAAAERAREAAAAAAAAAAAAAAAABEBARAAAAAREQEBERAAABEQERAREAABARAREBEBAAEBARERAQEAAQAAAAAAAQAAAQEREQEAAAABEBEQEQAAAAARAQEQAAAAAAEQEQAAAAAAAAAAAAAAAAAAAAAAAAD4PwAA8B8AAOAPAADABwAAgAMAAAABAAAAAQAAAAEAAAABAAAAAQAAgAMAAMAHAADgDwAA8B8AAPg/AAD//wAA" 
    rel="icon" type="image/x-icon" />
<title>Fifth Edition Character Generator</title>
</head>
<body>
    <div id="bg">
    </div>
    <div class="header">
        <h1>Fifth Edition</h1>
        <h1>Character Generator</h1>
        <h5>Current as of: <?php echo($date);?></h5>
        <h5><?php echo("Current number of combinations: " . number_format(getTotalCombinations()));  ?></h5>
        <!-- Place this tag where you want the button to render. -->
        <a class="github-button" href="https://github.com/kdiablo/CharacterGenerator/fork" data-icon="octicon-repo-forked" data-size="large" data-show-count="true" aria-label="Fork kdiablo/CharacterGenerator on GitHub">Fork</a>
        <!-- Place this tag where you want the button to render. -->
<a class="github-button" href="https://github.com/kdiablo/CharacterGenerator/issues" data-icon="octicon-issue-opened" data-size="large" aria-label="Issue kdiablo/CharacterGenerator on GitHub">Issue</a>
        <div class="maincontent container-fluid">
            <p>Welcome to the most up-to-date Fifth Edition character creator online!</p>
            <p>This is a passion project and will be updated for every new module that is released, along with new functionality.<br />
            <b>My next endeavor is to allow users to filter results by module.</b></p>
            <p>If you have any suggestions or questions, please send them to 
                <a href="mailto:feedback@5echaractergenerator.com" class="text-danger"><b>kylediablo@5echaractergenerator.tk</b></a>.
                <br /><br /><br />
                <div id="results">
                    <h4>Your next character is...</h4>
                    <p>
                        <?php 
                            $vowelArr = array('a', 'e', 'i', 'o', 'u');
                            $fName = getRandomResult("tblFName", "name");
                            $values = [];
                            for($x = 0; $x <= 2; $x++){
                                array_push($values, strtolower(getRandomResult("tblValue", "value")));
                            }
                            echo($fName . " " . getRandomResult("tblLName", "name") . ", the " . getRandomResult("tblAlignment", "alignment") . " " . 
                            getRandomResult("tblRace", "race") . " " . getRandomResult("tblBackground", "background") . ". <br />");
                            $adj = strtolower(getRandomResult("tblAdjectives", "adjective"));
                            if(in_array(substr($adj, 0, 1), $vowelArr)){
                                //if the first letter of the adjective is a consonant, then use "an"
                                echo("They are an " . $adj . " " . getRandomResult("tblClass", "class") . ". ");
                            } else {
                                echo("They are a " . $adj . " " . getRandomResult("tblClass", "class") . ". ");
                            }
                            echo("<br />" . $fName . " values " . $values[0] . ", " . $values[1] . ", and " . $values[2] . 
                            " but tends to dislike " . strtolower(getRandomResult("tblAdjectives", "adjective")) . " beings.");
                        ?>
                    </p>

                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="location.reload();"> Give It Another Spin!</button>

            </p>
            <br />
            <br />
            <!-- AddToAny BEGIN -->
            <div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="margin:auto;">
            <p style="font-size:14pt; text-align:left">Like it? Share it!</p>
            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
            <a class="a2a_button_facebook"></a>
            <a class="a2a_button_twitter"></a>
            <a class="a2a_button_reddit"></a>
            <a class="a2a_button_linkedin"></a>
            <a class="a2a_button_tumblr"></a>
            </div>
            <script async src="https://static.addtoany.com/menu/page.js"></script>
            <!-- AddToAny END -->
            
        </div>
    </div>
    
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>