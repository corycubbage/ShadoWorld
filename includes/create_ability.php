<?php 
include('../config.php');
$con=mysql_connect($dbhost,$dbuser,$dbpasswd,$dbname);
mysql_select_db($dbname);
define('VARIABLES_TABLE',$table_prefix . 'variables');
$id = $_REQUEST['Id'];
$user_id = $_REQUEST['user_id'];

$select_hit = "SELECT * from ".VARIABLES_TABLE;
$result1 = mysql_query($select_hit);
$variables = array();

while ($row = mysql_fetch_assoc($result1))
{
    $min_ability =$row['min_ability'];
    $max_ability =$row['max_ability'];
}
   
    $min_ability_data =json_decode($min_ability, true);
    $min_ability_data_count = count($min_ability_data);
    
    $max_ability_data =json_decode($max_ability, true);
    $max_ability_data_count = count($max_ability_data);
    
    $s_min_ability_data = '';
    for($i = 0;$i<$min_ability_data_count;$i++)
    {
       // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
        $s_min_ability_data .= "<option value=\"$min_ability_data[$i]\">$min_ability_data[$i]</option>";
    }
    
    $s_max_ability_data = '';
    for($i = 0;$i<$max_ability_data_count;$i++)
    {
       // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
        $s_max_ability_data .= "<option value=\"$max_ability_data[$i]\">$max_ability_data[$i]</option>";
    }
    

$id = $_REQUEST['Id'];
echo '<table><tr><td><input id="5" class="btn btn-info-red" type="button" name="ab'.$_REQUEST['post_id'].'_'.$_REQUEST['user_id'].'_'.$_REQUEST['Id'].'" value="-" addaditinal="" onclick="return remove_extra_ability(this);"></td><td>';
echo 'Name:&nbsp;&nbsp;<input type="text" name="ability'.$id.'" class="ability" id="ability'.$id.'">&nbsp;&nbsp;<label for="minmaxability'.$id.'">Current/Max :&nbsp;</label>';
echo '<select name="min_ability'.$id.'" id="min_ability'.$id.'" style="width:4em;">'.$s_min_ability_data.'</select>/<select name="max_ability'.$id.'" id="max_ability'.$id.'" style="width:4em;">'.$s_max_ability_data.'</select></label>&nbsp;&nbsp;&nbsp;&nbsp;Description:&nbsp;&nbsp;<input type="text" name="abilities_description'.$id.'" id="abilities_description'.$id.'" value="" /></td>';
echo '</tr></table><br>';
?>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(document).ready(function(){
	$(".ability").blur(function(){
		var text_val = [$('.ability').val()];
		var min_ability = $('#min_ability').val();
		var max_ability = $('#max_ability').val();
		$.ajax({
			dataType:"json",
			url:"./ajax.php?id=<?php echo $user_id;?>&input="+text_val+"&min_ab="+min_ability+"&max_ab="+max_ability
		}).success(function(data){
			console.log(data);
		});
	});
	$("#abilities_description<?php echo $id;?>").blur(function(){
		var text_val = $("#abilities_description<?php echo $id;?>").val();
		var ability  = $("#ability<?php echo $id;?>").val();
		$.ajax({
			dataType:"json",
			url:"./ajax_spell.php?user_id=<?php echo $user_id;?>&input="+text_val+"&ability="+ability+"&ajax=skilldesc"
		}).success(function(data){
			console.log(data);
		});
	});
});
</script>