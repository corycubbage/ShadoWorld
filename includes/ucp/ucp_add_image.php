<?php
//archi11 code
include('../../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('MOD_IMG_LINK', $table_prefix . 'moderator_img');
if($_REQUEST['add']=='insertimage'){

    $img_link = $_REQUEST['image_url'];
    $fetch_img = 'SELECT * FROM ' . MOD_IMG_LINK;
    $img_que = mysql_query($fetch_img);
    $result = mysql_fetch_assoc($img_que);

    if ($result['moderator_id'] != null) {
       echo $update = "UPDATE " . MOD_IMG_LINK . " set moderator_id=" .  $_REQUEST['user_id']. " ,img_title='" . $_REQUEST['image_name'] . "',link_path='" . $_REQUEST['image_url'] . "'";
        mysql_query($update);
    } else {

      $ins_img_link = "INSERT INTO " . MOD_IMG_LINK . " values('',".$_REQUEST['user_id'].",".$_REQUEST['image_name'].",".$img_link.")";
        mysql_query($ins_img_link);
    }

}
?>