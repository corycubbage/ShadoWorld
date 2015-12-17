<?php

//archi11
include('../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
define('VARIABLES_TABLE', $table_prefix . 'variables');

$id = $_REQUEST['Id'];

$select_hit = "SELECT * from " . VARIABLES_TABLE;
$result1 = mysql_query($select_hit);
$variables = array();

while ($row = mysql_fetch_assoc($result1)) {
    $level = $row['level'];
    $level_min = $row['level_min'];
    $level_max = $row['level_max'];

    $spell = $row['spell'];
}

$level_data = json_decode($level, true);
$level_count = count($level_data);

$level_min_data = json_decode($level_min, true);
$level_min_data_count = count($level_min_data);

$level_max_data = json_decode($level_max, true);
$level_max_data_count = count($level_max_data);

$spell_data = json_decode($spell, true);
$spell1_count = count($spell_data);

$s_level_data = '';
for ($i = 0; $i < $level_count; $i++) {
    //$selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_data .= "<option value=\"$level_data[$i]\">$level_data[$i]</option>";
}

$s_level_min_data = '';
for ($i = 0; $i < $level_count; $i++) {
    //  $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_min_data .= "<option value=\"$level_min_data[$i]\">$level_min_data[$i]</option>";
}

$s_level_max_data = '';
for ($i = 0; $i < $level_count; $i++) {
    // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_max_data .= "<option value=\"$level_max_data[$i]\">$level_max_data[$i]</option>";
}

$s_spell1_data = '';
for ($i = 0; $i < $spell1_count; $i++) {
    // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
   // $s_spell1_data .= "<option value=\"$spell_data[$i]\">$spell_data[$i]</option>";
   $s_spell1_data .= "<option value=''></option>";
}

$s_level_type_data = "<option value='Bard'>Bard</option>";
$s_level_type_data .= "<option value='Cleric'>Cleric</option>";
$s_level_type_data .= "<option value='Druid'>Druid</option>";
$s_level_type_data .= "<option value='Paladin'>Paladin</option>";
$s_level_type_data .= "<option value='Ranger'>Ranger</option>";
$s_level_type_data .= "<option value='Sorcerer'>Wizard</option>";
$s_level_type_data .= "<option value='Wizard'>Wizard</option>";

$user_id = $_REQUEST['user_id'];
$id = $_SESSION["SpellLevel"];

  $id=$id++;
 
echo '<table><td>' . $id . '</td></table>';
echo '<table><tr><td><input id="5" class="btn btn-info-red" type="button" name="' . $_REQUEST['post_id'] . '_' . $_REQUEST['user_id'] . '_' . $id . '" value="-" addaditinal="" onclick="return remove_extra_level(this);"></td>';
echo '<td><label for="select_type' . $id . '">Type: <select name="select_type' . $id . '" id="select_type' . $id . '" style="width:3em;">' . $s_level_type_data . '</select></label></td>';
echo '<td>&nbsp;&nbsp;&nbsp;<select name="spell_level'.$id.'[]" id="spell_level' . $id . '" class="spell_level" multiple>'.$s_spell1_data.'</select>&nbsp;&nbsp;</td><td>';
echo '<label for="select_lvl' . $id . '">Level: <select name="select_level' . $id . '" id="select_level' . $id . '" style="width:3em;">' . $s_level_data . '</select></label>';
echo '<label for="select_lvl_ct' . $id . '">&nbsp;&nbsp;Current/Max : <select name="select_level_min' . $id . '" id="select_level_min' . $id . '" style="width:3em;">' . $s_level_min_data . '</select>/ <select name="select_level_max' . $id . '" id="select_level_max' . $id . '" style="width:3em;">' . $s_level_min_data . '</select></label> <br><br></td>';
echo '</tr></table><br>';
?>

<script>
$(document).ready(function(){
    
        $("#select_type<?php echo $id;?>").change(function(){
                        $("#spell_level<?php echo $id;?>").empty();
                        
                        var level = $("#select_level<?php echo $id;?>").val();
                        var spell_type = $("#select_type<?php echo $id;?>").val();
                        var user_id = <?php echo $user_id;?>;
                        
                        $.ajax({
				url:"./ajax_spell.php?level="+level+"&user_id="+user_id+"&ajax=spell"+"&spell_type="+spell_type,
				dataType:"json"
			}).success(function(data){
				console.log(data);
                                $.each(data, function(key, value) {
                                    $("<option>", {value:value, html:value}).appendTo("#spell_level<?php echo $id;?>")
                                })
			});
			
	});
                           
                           
        $("#select_level<?php echo $id;?>").change(function(){
		
			//var x = document.getElementsByName("#select_level<?php echo $id;?>");        
                        //var s = document.getElementsByName("#select_type<?php echo $id;?>");
                        $("#spell_level<?php echo $id;?>").empty();
                        
                        var level = $("#select_level<?php echo $id;?>").val();
                        var spell_type = $("#select_type<?php echo $id;?>").val();
                        var user_id = <?php echo $user_id;?>;
                        
                        $.ajax({
				url:"./ajax_spell.php?level="+level+"&user_id="+user_id+"&ajax=spell"+"&spell_type="+spell_type,
				dataType:"json"
			}).success(function(data){
				console.log(data);
                                $.each(data, function(key, value) {
                                    $("<option>", {value:value, html:value}).appendTo("#spell_level<?php echo $id;?>")
                                })
			});
			
	});
        

});
</script>