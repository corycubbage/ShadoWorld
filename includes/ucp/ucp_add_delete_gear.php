<?php 
include('../../config.php');
$con=mysql_connect($dbhost,$dbuser,$dbpasswd,$dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE',$table_prefix . 'user_variable');
if(@$_REQUEST['seleted'] !="" && @$_REQUEST['seleted'])
{
 
    $rq = $_REQUEST['seleted'];
    $seleted = explode(",",$rq);
    
    echo '<div style="margin-left:3px;" id="div_gear_quantity"><br>';
    echo '<table>';
    for($i=0;$i<count($seleted);$i++)
    {
        echo '<tr>';
        echo '<td>';
        //echo stripslashes($seleted[$i]);
        echo $seleted[$i];
        echo '</td>';
        echo '<td>';
        //echo "&nbsp;&nbsp;<input type='text' name='quality[]' value='' id='".stripslashes($seleted[$i])."'><br>";
        echo "&nbsp;&nbsp;: <input type='text' name='quality[]' value='' id='".$seleted[$i]."'><br>";
        echo '</td>';
        echo '<td>';
        echo "&nbsp;&nbsp;Description : <input type='text' name='description[]' value='' id='".$seleted[$i]."'><br>";
        echo '</td>';
        echo '</tr>';
    }
    echo '<tr><td><br/></td></tr>';
    echo '<tr><td><input type="button" name="add_seleted_quantity" value="Change Quantity" id="add_seleted_quantity" onclick="addquantity();"  class="button1" ></td></tr>';
    echo '</table>';
    
    echo '</div>';
}

if(@$_REQUEST['addtext'])
{
    echo "<div id='div_gear_name'><br>";
    echo "<table><tr><td>Gear name  </td><td>:<input type='text' name='new_gear' id='new_gear'></td></tr>";
    echo "<tr><td>Quantity </td><td>:<input type='text' name='new_quality' id='new_quality'></td></tr>";
    echo "<tr><td>Description</td><td>:<input type='text' name='description' id='description'></td></tr></table><br />";
    echo "<input type='button' name='add_new_gear' id='add_new_gear' class=button1 value='Add' onclick='addgear();'>";    
    echo "</div>";
    
    
}
if(@!empty($_REQUEST['Delete']) and (@!empty($_REQUEST['user_id'])))
{
        
        $variable =  $_REQUEST['Delete'];
        $exp = explode(',',$variable);
      
        $select_level = "SELECT * from ".USER_VARIABLES_TABLE." WHERE user_id =".$_REQUEST['user_id'];
        $result1 = mysql_query($select_level);
        $levels = array();

        while ($row = mysql_fetch_assoc($result1))
        {
        $gear =$row['gear'] ;
        }
        $gear1 = array();
        $gear1     = json_decode($gear,true);
        
        $gear_result = array();
        $gear_result = array_values(array_diff($gear1,$exp));   
        $update_level = "UPDATE ".USER_VARIABLES_TABLE." SET gear = '".json_encode($gear_result,JSON_FORCE_OBJECT)."' WHERE user_id =".$_REQUEST['user_id'];
        mysql_query($update_level);
}
?>