<?php
//archi11
include('../../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE', $table_prefix . 'user_variable');
define('USERS_TABLE', $table_prefix . 'users');
if (@$_REQUEST['user_id'] != "" && @$_REQUEST['offense_name'] && @$_REQUEST['offense_name']) {

    $select = 'SELECT weapon_field,weapon_name FROM ' . USER_VARIABLES_TABLE . ' WHERE user_id =' . $_REQUEST['user_id'];
    $result1 = mysql_query($select);
    while ($row = mysql_fetch_assoc($result1)) {
        $weapon_field = $row['weapon_field'];
        $weapon_name = $row['weapon_name'];
    }
    $weapon_field1 = json_decode($weapon_field, true);
    $weapon_name1 = json_decode($weapon_name, true);

    $select2 = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id =' . $_REQUEST['user_id'];
    $result2 = mysql_query($select2);
    while ($row1 = mysql_fetch_assoc($result2)) {
        $username = $row1['username'];
    }
    $of = $_REQUEST['offense_name'];

    $display1 = '';
    echo $display1 = <<<EOL

[spoiler="$username attack with $of"]
[dice="$of"]
EOL;

    $display = '';

    if (count($weapon_name1) > 1) {
        for ($i = 0; $i < count($weapon_name1); $i++) {

            if ($weapon_field1[$i][0] == $_REQUEST['offense_name']) {
       
                $wv1 = $weapon_field1[$i][1][0];
                $wv2 = $weapon_field1[$i][1][1]."[/dice]";

                if (count($weapon_field1[$i][1][4]) >= 2) {
                    $wv3 = '';
                    for ($j = 0; $j < count($weapon_field1[$i][1][4]); $j++) {
                        if($j<(count($weapon_field1[$i][1][4]) -1))
                        {
                        $wv3 .= $weapon_field1[$i][1][4][$j] . ",";
                        }
                        else
                        {
                         $wv3 .= $weapon_field1[$i][1][4][$j]."[/i]";
                        }
                    }
                } else{
                    $wv3 = $weapon_field1[$i][1][4][0]."[/i]";
                }
              
                $wv4 = $weapon_field1[$i][1][3]."[/i]";
                $wv5 = $weapon_field1[$i][1][2]."[/i]";
                $display .=<<<EOL
$wv1 [/dice]
[dice="Damage :$of"]$wv2 
[b]Additional Details:[/b] Type: [i]$wv3, Range: [i]$wv4, Critical Multiplier: [i]$wv5 
[/spoiler]                        
EOL;
            }
        }

        echo $display;
    } else {

        $wv1 = $weapon_field1[0][1][0];
        $wv2 = $weapon_field1[0][1][1]."[/dice]";
        if (count($weapon_field1[0][1][4]) > 2) {
                    $wv3 = '';
                    for ($j = 0; $j < count($weapon_field1[0][1][4]); $j++) {
                        if($j<(count($weapon_field1[0][1][4]) -1))
                        {
                        $wv3 .= $weapon_field1[0][1][4][$j] . ",";
                        }
                        else
                        {
                            $wv3 .= $weapon_field1[0][1][4][$j]."[/i]";
                        }
                    }
                } else {
                    $wv3 = $weapon_field1[0][1][4][0]."[/i]";
                }
        $wv4 = $weapon_field1[0][1][3]."[/i]";
        $wv5 = $weapon_field1[0][1][2]."[/i]";

        $display .=<<<EOL
$wv1 [/dice]
[dice="Damage :$of]$wv2
[b]Additional Details:[/b] Type: [i]$wv3, Range: [i]$wv4, Critical Multiplier: [i]$wv5
[/spoiler]
EOL;

        echo $display;
    }
}
?>