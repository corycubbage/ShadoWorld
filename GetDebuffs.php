<?php
/*
  Script outputs data in json format suitable for 'source' option in X-editable
*/
sleep(1);   


include('../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
define('VARIABLES_TABLE', $table_prefix . 'variables');

$select_debuff = "SELECT * from " . VARIABLES_TABLE;
$result1 = mysql_query($select_debuff);
$debuff_array = array();
$ReturnDebuffs = array();

while ($row = mysql_fetch_assoc($result1)) {
    $debuffs = $row['negative_condition'];
}

echo $debuffs;  