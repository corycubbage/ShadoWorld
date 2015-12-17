<?php

include('./config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE', $table_prefix . 'user_variable');
if(isset($_GET['ajax']) && $_GET['ajax'] == 'spell')
{
	/*$query  = "select spell from ".USER_VARIABLES_TABLE." WHERE user_id = '".$_GET['user_id']."'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	$level = $_GET['level'];
	$spell = json_decode($row['spell']);
	$spells = $spell->$level->name;
	foreach($spells as $value)
	{
		$spells_array[] = $value;
	}*/
	
        $spell_type = $_GET['spell_type'];
        $level = $_GET['level'];

        include('./CreateSpellLists.php');	
        
        echo json_encode($spells_array, JSON_FORCE_OBJECT);
        //echo json_encode($spells_array);
}

if(isset($_GET['ajax']) && $_GET['ajax'] == 'skilldesc')
{
	$query  = "select abilities_description from ".USER_VARIABLES_TABLE." WHERE user_id = '".$_GET['user_id']."'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	echo '<pre>';
	$abilities = json_decode($row['abilities_description']);
	foreach($abilities as $key=>$value)
	{
		$ability[$key] = $value;
	}
	$abilityname = $_GET['ability'];
	$ability[$abilityname] = $_GET['input'];
	$ability = json_encode($ability,JSON_FORCE_OBJECT);
	$query = "update ".USER_VARIABLES_TABLE." set abilities_description = '".$ability."' where user_id = '".$_GET['user_id']."'";
	$res = mysql_query($query);
}

if(isset($_GET['ajax']) && $_GET['ajax'] == 'image')
{
	$user_id = $_GET['user_id'];
	$image_name = $_GET['image_name'];
	$image_url = $_GET['image_url'];
	$post_id = $_GET['post_id'];
	$query = "INSERT into phpbb_moderator_img set moderator_id = ".$user_id.", post_id = $post_id, img_title = '$image_name', link_path = '$image_url'";
	$result = mysql_query($query);
	echo 'Inserted';
}

if(isset($_GET['ajax']) && $_GET['ajax'] == 'delete_image')
{
	$user_id = $_GET['user_id'];
	$unique_id = $_GET['unique_id'];
	$id = explode('_',$unique_id);
	$query = "delete from phpbb_moderator_img where moderator_link_id = ".$id[1]."";
	$result = mysql_query($query);
	echo 'Deleted';
}

if(isset($_GET['ajax']) && $_GET['ajax'] == 'update_image')
{
	$unique_id = $_GET['unique_id'];
	$id = explode('_',$unique_id);
	$image_name = $_GET['image_name'];
	$image_url = $_GET['image_url'];
	$query = "update phpbb_moderator_img set img_title='".$image_name."', link_path = '".$image_url."' where moderator_link_id = ".$id[1]."";
	$result = mysql_query($query);
	echo 'Updated';
}
?>
