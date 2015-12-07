<?php
include('./config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE', $table_prefix . 'user_variable');
$select = mysql_query("select quick_skill from phpbb_user_variable where user_id='".$_REQUEST['user_id']."'");
$fetch = mysql_fetch_assoc($select);
//echo "SSS".$fetch['quick_skill'];
$skill_json = $_GET['selected'];
//echo "HHH".$skill_json;exit;
$skill_enc  = explode(',',$skill_json);
$skill = json_encode($skill_enc,JSON_FORCE_OBJECT);
$query = "update ".USER_VARIABLES_TABLE." set quick_skill='$skill' where user_id = ".$_REQUEST['user_id']."";
//echo json_encode($query);
$res   = mysql_query($query);
//echo json_encode($skill_enc,JSON_FORCE_OBJECT);
?>