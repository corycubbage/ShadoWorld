<?php 
include('../../config.php');
$con=mysql_connect($dbhost,$dbuser,$dbpasswd,$dbname);
mysql_select_db($dbname);

define('USER_VARIABLE_TABLE',$table_prefix . 'user_variable');
if(@$_REQUEST['Level'] !="" && @$_REQUEST['Id'])
{
        $id = $_REQUEST['Id'];
        $rqlvl = $_REQUEST['Level'];
        $seleted = explode("_",$id);
        $post_id = $seleted[0];
        $user_id = $seleted[1];
        $position = $seleted[2];
        
        $select_level = "SELECT * from ".USER_VARIABLE_TABLE." WHERE user_id =".$user_id;
        $result1 = mysql_query($select_level);
        $levels = array();

        while ($row = mysql_fetch_assoc($result1))
        {
        $levl =$row['level'] ;
        $level_mn =$row['level_min'] ;
        $level_mx =$row['level_max'] ;
        }
        $level1     = json_decode($levl,true);
        $level_mn1 = json_decode($level_mn,true);
        $level_mx1 = json_decode($level_mx,true);

        unset($level1[$position]);
        unset($level_mn1[$position]);
        unset($level_mx1[$position]);
       
        $lvl1 = array();
        $lvlmn1 = array();
        $lvlmx1 = array();

        $lvl1 =array_values($level1);
        $lvlmn1 = array_values($level_mn1);
        $lvlmx1 = array_values($level_mx1);
               
       echo $update_level = "UPDATE ".USER_VARIABLE_TABLE." SET level = '".json_encode($lvl1,JSON_FORCE_OBJECT)."', level_min='".json_encode($lvlmn1,JSON_FORCE_OBJECT)."' , level_max='".json_encode($lvlmx1,JSON_FORCE_OBJECT)."' WHERE user_id =".$user_id;
        mysql_query($update_level);
}
if(@$_REQUEST['Ability'] !="" && @$_REQUEST['Idability'])
{
        $id = $_REQUEST['Idability'];
        $rqlvl = $_REQUEST['Ability'];
        $seleted = explode("_",$id);
        $post_id = $seleted[0];
        $user_id = $seleted[1];
        $position = $seleted[2];
        
       
        $select_level = "SELECT * from ".USER_VARIABLE_TABLE." WHERE user_id =".$user_id;
        $result1 = mysql_query($select_level);
        $levels = array();

        while ($row = mysql_fetch_assoc($result1))
        {
        $ability_name =$row['ability_name'] ;
        $min_ability =$row['min_ability'] ;
        $max_ability =$row['max_ability'] ;
        }
        
        $ability_name1 = json_decode($ability_name,true);
        $min_ability1 = json_decode($min_ability,true);
        $max_ability1 = json_decode($max_ability,true);

        unset($ability_name1[$position]);
        unset($min_ability1[$position]);
        unset($max_ability1[$position]);
       
        $abilitynm1 = array();
        $abilitymn1 = array();
        $abilitymx1 = array();

        $abilitynm1 =array_values($ability_name1);
        $abilitymn1 = array_values($min_ability1);
        $abilitymx1 = array_values($max_ability1);
        $ability  = str_replace("\u00a0"," ",json_encode($abilitynm1,JSON_FORCE_OBJECT)); 
          
      $update_level = "UPDATE ".USER_VARIABLE_TABLE." SET ability_name = '".$ability."', min_ability='".json_encode($abilitymn1,JSON_FORCE_OBJECT)."' , max_ability='".json_encode($abilitymx1,JSON_FORCE_OBJECT)."' WHERE user_id =".$user_id;
      
        mysql_query($update_level);
}
?>