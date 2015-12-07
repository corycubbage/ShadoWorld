<?php
$con=mysql_connect('localhost','thecscom_phpb717','0f6m8PS1at');
// test
mysql_select_db('thecscom_phpb923',$con);
$id = $_GET['id'];
$input = $_GET['input'];
$min_ab = $_GET['min_ab'];
$max_ab = $_GET['max_ab'];
$query = "SELECT * from phpbb_user_variable where user_id = $id";
//echo $select_hit;
//$result1 = mysql_query($select_hit);
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$ability = json_decode($row['ability_name']);

$min_abiliti = json_decode($row['min_ability']);
$max_abiliti = json_decode($row['max_ability']);

foreach($min_abiliti as $value)
{
	$min_ability[] =$value;
}
$min_ability[] = $min_ab;
$min_ability = json_encode($min_ability,JSON_FORCE_OBJECT);

foreach($max_abiliti as $value)
{
	$max_ability[] =$value;
}
$max_ability[] = $max_ab;
$max_ability = json_encode($max_ability,JSON_FORCE_OBJECT);

foreach($ability as $value)
{
	$abilities[] =$value ;
}
$abilities[] = $input;
$all_ability = json_encode($abilities,JSON_FORCE_OBJECT);
print_r($all_ability);
$query = "update phpbb_user_variable set ability_name = '$all_ability', min_ability='$min_ability',max_ability='$max_ability' where user_id = $id";
$res = mysql_query($query);

?>
