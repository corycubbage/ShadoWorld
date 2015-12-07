    <?php

while ($row = $db->sql_fetchrow($result_post_data)) { //Retrieve all variables from the post data`

    $PLAYERINFO = $row['PLAYERINFO'];
    $CLASS_INFO = $row['CLASS_INFO'];
    $ACS = $row['AC'];
    $SAVES = $row['SAVES'];
    $RESISTIMMUNITY = $row['RESISTIMMUNITY'];
    $selected_current_hit = $row['selected_current_hit'];
    $selected_maximum_hit = $row['selected_maximum_hit'];
    $seleted_non_lethal = $row['seleted_non_lethal'];
    $seleted_bad_condition = $row['seleted_bad_condition'];
    $seleted_good_condition = $row['seleted_good_condition'];

    $spellclasstype = $row['spell_class_type'];
    $levels = $row['level'];
    $levels_min = $row['level_min'];
    $levels_max = $row['level_max'];

    $ability_namey = $row['ability_name'];
    $ability_desy = $row['abilities_description'];
    $min_abilityy = $row['min_ability'];
    $max_abilityy = $row['max_ability'];

    $seleted_gear = $row['gear'];
    $heropoint = $row['hero_point'];
    $quick_stats = $row['quick_stats'];
    $quick_skill = $row['quick_skill'];

    $attack = $row['attack'];
    $damage = $row['damage'];
    $critical_multiplier = $row['critical_multiplier'];
    $off_range = $row['off_range'];
    $type = $row['type'];
    $weapon_name = $row['weapon_name'];
    $user_spell = $row['spell'];                                                //CVC - 12/05/15 - Appears to be the list of spells the user has
	}
        
$select_hit = "SELECT * from " . VARIABLES_TABLE;
$result1 = $db->sql_query($select_hit);
$variables = array();

//Load all user variable information from the database
while ($row = $db->sql_fetchrow($result1)) {
	
    $hit_current = $row['current'];                                             //CVC - 11/28/15 - Builds current HP dropdown selection criteria, between -20 to 99
    $hit_maximum = $row['maximum'];                                             //CVC - 11/28/15 - Builds maximum HP dropdown selection criteria, between -20 to 99
                       
    $negative_condition = $row['negative_condition'];                           //CVC - 11/28/15 - Builds negative condition select box, loading all negative conditions
    $positive_condition = $row['positive_condition'];                           //CVC - 11/28/15 - Builds positive condition select box, loading all negative conditions

    $level = $row['level'];                                                     //CVC - 11/28/15 - Builds current spell level dropdown selection criteria, {"0":"0","1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":"8","9":"9"}
    $level_min = $row['level_min'];                                             //CVC - 11/28/15 - Builds spell level current value dropdown selection criteria, between 0 - 99
    $level_max = $row['level_max'];                                             //CVC - 11/28/15 - Builds spell level maximum value dropdown selection criteria, between 0 - 99

    $min_ability = $row['min_ability'];
    $max_ability = $row['max_ability'];

    $gear = $row['gear'];

    $non_lethal = $row['non_lethal'];

    $hero_points = $row['hero_point'];

    $quick_skill1 = $row['quick_skill'];

    $spells = $row['spell'];
}
//Seperate information loaded from database into key pairs
$hit_current_data = json_decode($hit_current, true);
$hit_maximum_data = json_decode($hit_maximum, true);
sort($hit_current_data);
sort($hit_maximum_data);

$hit_current_data_count = count($hit_current_data);
$hit_maximum_data_count = count($hit_maximum_data);

$negative_condition_data1 = json_decode($negative_condition, true);
$positive_condition_data1 = json_decode($positive_condition, true);
$negative_condition_data = array_map('ucfirst', $negative_condition_data1);
$positive_condition_data = array_map('ucfirst', $positive_condition_data1);

sort($negative_condition_data);
sort($positive_condition_data);

$negative_condition_data_count = count($negative_condition_data);
$positive_condition_data_count = count($positive_condition_data);

$static_spell_level_list = json_decode($level, true);                                        //CVC - 11/28/15 - $static_spell_level_list is the decoded array of possible spell levels: [0] => 0 [1] => 1 [2] => 2 [3] => 3 [4] => 4 [5] => 5 [6] => 6 [7] => 7 [8] => 8 [9] => 9
sort($static_spell_level_list);                                                              //CVC - 11/28/15 - Sort them alphanumerically 
$level_count = count($static_spell_level_list);                                              //CVC - 11/28/15 - Should be ten, 0-9.

$static_spell_current_data = json_decode($level_min, true);                                //CVC - 11/28/15 - $static_spell_level_list is the decoded array of possible spells per levels: [0] => 0 [1] => 1 [2] => 2 ... [99] => 99
sort($static_spell_current_data);                                                          //CVC - 11/28/15 - Sort them alphanumerically 
$static_spell_current_data_count = count($static_spell_current_data);                                 //CVC - 11/28/15 - Should be 99, 0-99.

$static_spell_max_data = json_decode($level_max, true);
sort($static_spell_max_data);
$static_spell_max_data_count = count($static_spell_max_data);

$min_ability_data = json_decode($min_ability, true);
sort($min_ability_data);
$min_ability_data_count = count($min_ability_data);

$max_ability_data = json_decode($max_ability, true);
sort($max_ability_data);
$max_ability_data_count = count($max_ability_data);

$gear_data1 = json_decode($gear, true);
$gear_data = array_map('ucfirst', $gear_data1);
sort($gear_data);

$gear_data_count = count($gear_data);

$non_lethal_data = json_decode($non_lethal, true);
sort($non_lethal_data);
$non_lethal_data_count = count($non_lethal_data);

$quick_s1 = json_decode($quick_skill1, true);
$quick_skill_data = array_map('ucfirst', $quick_s1);
sort($quick_skill_data);

$quick_skill_data_count = count($quick_skill_data);
$selected;
$s_hit_current_data = '';

//Build HTML to populate the dropdown menu & find current HP value and mark it as the selected value for dropdown
for ($i = 0; $i < $hit_current_data_count; $i++) {
    if ($hit_current_data[$i] == $selected_current_hit) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }

    $s_hit_current_data .= "<option value=\"$hit_current_data[$i]\" $selected >$hit_current_data[$i]</option>";
}

$s_hit_maximum_data = '';

for ($i = 0; $i < $hit_maximum_data_count; $i++) {

    if ($hit_maximum_data[$i] == $selected_maximum_hit) {
        $selected = ' selected="selected"';
        //$s_hit_maximum_data .= "<option value=\"$hit_maximum_data[$i]\"$selected>$hit_maximum_data[$i]</option>";
    } else {
        $selected = '';
        //$s_hit_maximum_data .= "<option value=\"$hit_maximum_data[$i]\"$selected>$hit_maximum_data[$i]</option>";
    }
    $s_hit_maximum_data .= "<option value=\"$hit_maximum_data[$i]\"$selected>$hit_maximum_data[$i]</option>";
}

$s_non_lethal_data = '';
for ($i = 0; $i < $non_lethal_data_count; $i++) {

    if ($non_lethal_data[$i] == $seleted_non_lethal) {
        $selected = ' selected="selected"';
    } else {
        $selected = '';
    }
    $s_non_lethal_data .= "<option value=\"$non_lethal_data[$i]\"$selected>$non_lethal_data[$i]</option>";
}

$bad_condition = json_decode($seleted_bad_condition, true);
$s_negative_condition_data = '';

for ($i = 0; $i < $negative_condition_data_count; $i++) {

    if ($bad_condition) {
        foreach ($bad_condition as $key => $val) {
            if ($negative_condition_data[$i] == $val) {
                $selected = 'selected="selected"';
                break;
            } else {
                $selected = '';
            }
        }
    }	
    
if(request_var('mode','') == 'post')
	
{ 
	$s_negative_condition_data .= "<option value=\"$negative_condition_data[$i]\" $selected>$negative_condition_data[$i]</option>";
}else{
   
	$s_negative_condition_data .= "<option value=\"$negative_condition_data[$i]\" $selected >$negative_condition_data[$i]</option>";
}
    
}

$good_condition = json_decode($seleted_good_condition, true);
$s_positive_condition_data = '';

for ($i = 0; $i < $positive_condition_data_count; $i++) {


    if ($good_condition) {
        foreach ($good_condition as $key => $val) {
            if ($positive_condition_data[$i] == $val) {
                $selected = 'selected="selected"';
                break;
            } else {
                $selected = '';
            }
        }
    }
//if($_REQUEST['mode'] == 'post')
if(request_var('mode','') == 'post')
	
{

	$s_positive_condition_data .= "<option value=\"$positive_condition_data[$i]\">$positive_condition_data[$i]</option>";
}else{
	$s_positive_condition_data .= "<option value=\"$positive_condition_data[$i]\"$selected>$positive_condition_data[$i]</option>";
}
    
}
                               
/*
//CVC - 11/28/15 - Determine if there are any spell levels defined on this character.  If so, set $variable_level to true and select that level, if not move on.
$decoded_user_levels = json_decode($levels, true);                              //CVC - 11/28/15 - $levels = Array of decoded spell levels the selected user has, ( [0] => 0 [1] => 1 )
$s_level_data = '';                                                             //Clear out selected level data
if ($decoded_user_levels[0] != '') {                                           
    for ($i = 0; $i < $level_count; $i++) {                                     //Iterate all ten levels of spells
        if (count($decoded_user_levels) == 1) {                                            
            $variable_level = 'yes';                                            
            if ($static_spell_level_list[$i] == $decoded_user_levels[0]) {                               
                $selected = ' selected="selected"';
                $s_level_data .= "<option value=\"$static_spell_level_list[$i]\"$selected>$static_spell_level_list[$i]</option>";
            } else {
                $selected = '';
                $s_level_data .= "<option value=\"$static_spell_level_list[$i]\"$selected>$static_spell_level_list[$i]</option>";
            }
        }
    }
}

//echo nl2br ("User spells: " . $user_spell . "\n");

$decoded_user_spell_list = json_decode($user_spell, true);
//echo "decoded_user_spell_list: ";
//print_r ($decoded_user_spell_list);

$splct = count($decoded_user_spell_list);
//echo nl2br ("\nSpell count: " . $splct);
$spell_class_type = json_decode($levels, true);                                          //CVC - Array of all spell levels the current user has.
//echo nl2br ("\nspell_class_type: ");
//print_R ($spell_class_type);
//echo nl2br ("\nspells: ");
//print_R ($spells);
$spells1 = json_decode($spells, true);                                          //CVC - Array of all spells
//echo nl2br ("\nSpells1 decoded: ");
//print_R ($spells1);

$spl_count = 0;
$spell_options = array();
$arr = @array_unique($spell_class_type);                                                           //Array ( [0] => 0 [1] => 1 )
$sel = array();
if ($arr) {
    foreach ($arr as $key => $val) {
        $spell_options_create = '';
        //echo "-*-: ";
        //print_r($decoded_user_spell_list[0]['name']);
        //echo "-*-: ";
        //print_r($spells1);
        if (@key_exists($val, $decoded_user_spell_list)) {
            $all_spell = @array_values(array_unique(array_merge($decoded_user_spell_list[$val]['name'], $spells1)));
            for ($spl = 0; $spl < count($all_spell); $spl++) {
                foreach ($decoded_user_spell_list[$val]['name'] as $k => $v) {
                    if ($all_spell[$spl] == $v) {
                        $selected = 'selected="selected"';
                        break;
                    } else {
                        $selected = '';
                    }
                }

                $spell_options_create .= "<option " . $selected . ">" . $all_spell[$spl] . "</option>";
            }
            if ($spl_count == 0) {
                $sel[$val] = "<select name='spell_level[]' multiple id=spell_level>" . $spell_options_create . "</select>";
            } else {
                $sel[$val] = "<select name='spell_level" . $spl_count . "[]' multiple id='spell_level" . $spl_count . "'>" . $spell_options_create . "</select>";
            }
			$spl_count ++;
		} else {
            for ($spl = 0; $spl < count($spells1); $spl++) {
                $spell_options_create .= "<option>" . $spells1[$spl] . "</option>";
            }
            if ($spl_count == 0) {
                $sel[$val] = "<select name='spell_level[]' multiple id=spell_level>" . $spell_options_create . "</select>";
            } else {
                $sel[$val] = "<select name='spell_level" . $spl_count . "[]' multiple id='spell_level" . $spl_count . "'>" . $spell_options_create . "</select>";
            }
            $spl_count ++;
        }
    }
}
//debug_to_console($spell_options_create);

$selectbox_level = '';

if (count($decoded_user_levels) > 1) {
    $increment_variable_spell = '<input type="hidden" name="increment_variable_spell" id="increment_variable_spell" value="' . count($decoded_user_levels) . '">';
    $variable_level = 'no';
    for ($j = 0; $j < count($decoded_user_levels); $j++) {

        $selectstart = '';
        $selectends = '';
        $select = '';
        $s_level_data_all_options = '';

        if ($j == 0) {
            $lvl = '';
        } else {
            $lvl = $j;
        }
        
        
        //$selectstart .= 'Level : <select name="select_level' . $lvl . '" id="select_level' . $lvl . '" style="width:5em;" onchange="levelfunction(this)" level="' . $lvl . '" disabled>';
        $selectstart .= 'Level : <select name="select_level' . $lvl . '" id="select_level' . $lvl . '" style="width:5em;" onchange="levelfunction(this)">';

        for ($i = 0; $i < $level_count; $i++) {
            if ($static_spell_level_list[$i] == $decoded_user_levels[$j]) {

                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $s_level_data_all_options .= "<option value=\"$static_spell_level_list[$i]\" $selected >$static_spell_level_list[$i]</option>";
        }

        $selectends .= '</select>';
        if ($j != (count($decoded_user_levels) - 1)) {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "<br><br>";
        } else {
            $select .= $selectstart . $s_level_data_all_options . $selectends;
        }
        //if ($user_spell != null) {
        foreach ($sel as $kespel => $valspell) {

            if ($decoded_user_levels[$j] == $kespel) {
                $box = $valspell;
                break;
            } else {
                $box = '';
            }
        }
        //}
        $selectbox_level .= "&nbsp;&nbsp;" . $box . "&nbsp;&nbsp;" . $select;
    }
}
//debug_to_console($select);
//debug_to_console($selectbox_level);

$sel_count = count($sel);
if ($sel_count > 1) {
    $spell_variable = 'no';
} elseif ($sel_count == 1) {
    $spell_variable = 'yes';
    $spell_one = $sel[0];
}
$levelss_min = json_decode($levels_min, true);
$s_level_min_select_box = '';
for ($i = 0; $i < $static_spell_current_data_count; $i++) {
    if (count($levelss_min) == 1) {
        if ($static_spell_current_data[$i] == $levelss_min[0]) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
    }
    $s_level_min_data .= "<option value=\"$static_spell_current_data[$i]\"$selected>$static_spell_current_data[$i]</option>";
}
$selectbox_level_min = '';
if (count($levelss_min) > 1) {

    for ($j = 0; $j < count($levelss_min); $j++) {
        $selectstart = '';
        $selectends = '';
        $select = '';
        $s_level_data_all_options = '';
        if ($j == 0) {
            $lvl = '';
        } else {
            $lvl = $j;
        }

        $selectstart .= '&nbsp&nbsp Current/Max  : <select name="select_level_min' . $lvl . '" id="select_level_min' . $lvl . '" style="width:5em;;">';

        for ($i = 0; $i < $static_spell_current_data_count; $i++) {
            if ($static_spell_current_data[$i] == $levelss_min[$j]) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $s_level_data_all_options .= "<option value=\"$static_spell_current_data[$i]\" $selected >$static_spell_current_data[$i]</option>";
        }
        $selectends .= '</select>';
        if ($j != (count($levelss_min) - 1)) {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "/" . "<br><br><br><br>";
        } else {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "/";
        }

        $selectbox_level_min .= $select;
    }
}

$levelss_max = json_decode($levels_max, true);
$s_level_max_data = '';
for ($i = 0; $i < $static_spell_max_data_count; $i++) {
    if (count($levelss_max) == 1) {
        if ($static_spell_max_data[$i] == $levelss_max[0]) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
    }

    $s_level_max_data .= "<option value=\"$static_spell_max_data[$i]\"$selected>$static_spell_max_data[$i]</option>";
}
$delete_last_level_ability = $post_id . '_' . $user->data["user_id"] . '_' . '0';


$selectbox_level_max = '';
$button_level = '';
if (count($levelss_max) > 1) {

    for ($j = 0; $j < count($levelss_max); $j++) {
        $selectstart = '';
        $selectends = '';
        $select = '';

        $s_level_data_all_options = '';
        if ($j == 0) {
            $lvl = '';
        } else {
            $lvl = $j;
        }

        $selectstart .= '<select name="select_level_max' . $lvl . '" id="select_level_max' . $lvl . '" style="width:5em;;">';

        for ($i = 0; $i < $static_spell_max_data_count; $i++) {
            if ($static_spell_max_data[$i] == $levelss_max[$j]) {
                $value = $static_spell_max_data[$i];
                $ivalue = $j;
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            $s_level_data_all_options .= "<option value=\"$static_spell_max_data[$i]\" $selected >$static_spell_max_data[$i]</option>";
        }

        $name = $post_id . '_' . $user->data["user_id"] . '_' . $ivalue;
        $selectends .= '</select>';

        
        ///if ($_REQUEST['mode'] == 'edit') {
		if (request_var('mode','') == 'edit') {
            if ($j < (count($levelss_max) - 1)) {

                //$style = 'style="height: 53px;"';
                $style = 'style="height: 100px;"';
            } else {
                $style = '';
            }
        }
        //if ($_REQUEST['mode'] == 'post') {
		if (request_var('mode','') == 'post') {
            if ($j < (count($levelss_max) - 1)) {
                //$style = 'style="height: 51px;"';
                $style = 'style="height: 100px;"';
            } else {
                $style = '';
            }
        }
        $button_level .= '<div ' . $style . '><input type="button" name=' . $name . ' id=' . $value . ' value="-" class="btn btn-info-red" onclick="return remove_level(this);"></div>';
        if ($j != (count($levelss_max) - 1)) {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "<br><br><br><br>";
        } else {
            $select .= $selectstart . $s_level_data_all_options . $selectends;
        }

        $selectbox_level_max .= $select;
    }
}
 

/*
$s_level_data = '';
for ($i = 0; $i < $level_count; $i++) {
    //$selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_data .= "<option value=\"$static_spell_level_list[$i]\">$static_spell_level_list[$i]</option>";
}

$s_level_min_data = '';
for ($i = 0; $i < $level_count; $i++) {
    //  $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_min_data .= "<option value=\"$static_spell_current_data[$i]\">$static_spell_current_data[$i]</option>";
}

$s_level_max_data = '';
for ($i = 0; $i < $level_count; $i++) {
    // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
    $s_level_max_data .= "<option value=\"$static_spell_max_data[$i]\">$static_spell_max_data[$i]</option>";
}

$s_spell1_data = '';
for ($i = 0; $i < $spell1_count; $i++) {
    // $selected = ($i == $data['positive_condition']) ? ' selected="selected"' : '';
   // $s_spell1_data .= "<option value=\"$spell_data[$i]\">$spell_data[$i]</option>";
   $s_spell1_data .= "<option value=''></option>";
}

$starting_spells = '<table><tr><td><input id="5" class="btn btn-info-red" type="button" name="' . request_var('post_id','') . '_' . request_var('user_id','') . '_' . request_var('Id','') . '" value="-" addaditinal="" onclick="return remove_extra_level(this);"></td><td>&nbsp;&nbsp;&nbsp;<select name="spell_level'.$id.'[]" id="spell_level' . $id . '" class="spell_level" multiple>'.$s_spell1_data.'</select>&nbsp;&nbsp;</td><td>';
$starting_spells = $starting_spells . '<label for="select_lvl' . $id . '">Level: <select name="select_level' . $id . '" id="select_level' . $id . '" style="width:3em;">' . $s_level_data . '</select></label>';
$starting_spells = $starting_spells . '<label for="select_lvl_ct' . $id . '">&nbsp;&nbsp;Current/Max : <select name="select_level_min' . $id . '" id="select_level_min' . $id . '" style="width:3em;">' . $s_level_min_data . '</select>/ <select name="select_level_max' . $id . '" id="select_level_max' . $id . '" style="width:3em;">' . $s_level_min_data . '</select></label> <br><br></td>';
$starting_spells = $starting_spells . '</tr></table><br>';
// Cory's cut end
*/



$ability_names = json_decode($ability_namey, true);
$ability_descs = json_decode($ability_desy, true);

if ($ability_names[0] != '') {
    $edit_ability_namey = '';
    if (count($ability_names) != 0) {
        for ($j = 0; $j < count($ability_names); $j++) {
            $selectstart = '';
            $selectends = '';
            $select = '';
            if ($j == 0) {
                $lvl = '';
                $nl = '<br>';
            } else {
                $lvl = $j;
                $nl = '';
            }
            $name = $ability_names[$j];
            $selectstart .= '' . $nl . 'Name : <input type="text" name=ability' . $lvl . ' value=' . str_replace(" ", "&nbsp;", $name) . ' ><br>';
            foreach($ability_descs as $key=>$data1){
	
	if($name == $key){
		
              $selectstart .= '' . $nl . '<div style="position:absolute;margin-top:-2px"><label style="float:left">Description : </label><input type="text" name=abilities_description' . $lvl . ' value=' . str_replace(" ", "&nbsp;", $data1) . ' ></div><br>';
             } 
             }
            //if($_REQUEST['mode'] == 'post')
			if(request_var('mode','') == 'post')
            {
				$edit_ability_namey = '';
			}else{
				$edit_ability_namey .= $selectstart;	
			}
            
        }
    }
}
$min_abilityyy = json_decode($min_abilityy, true);
$s_min_ability = '';
if ($min_abilityyy[0] != '') {
    for ($i = 0; $i < $min_ability_data_count; $i++) {
        if (count($min_abilityyy) == 1) {
            $variable_ability = 'yes';
            if ($min_ability_data[$i] == $min_abilityyy[0]) {
                $selected = ' selected="selected"';
            } else {
                $selected = '';
            }
        }
        //if($_REQUEST['mode'] == 'post')
		if(request_var('mode','') == 'post')
        {
			$s_min_ability .= "<option value=\"$min_ability_data[$i]\">$min_ability_data[$i]</option>";
			break;
		}else{
			$s_min_ability .= "<option value=\"$min_ability_data[$i]\"$selected>$min_ability_data[$i]</option>";
		}
    }
}
$selectbox_min_ability = '';
if (count($min_abilityyy) > 1) {
    $increment_variable_ability = '<input type="hidden" name="increment_variable_ability" id="increment_variable_ability" value="' . count($min_abilityyy) . '">';
    $variable_ability = 'no';
    for ($j = 0; $j < count($min_abilityyy); $j++) {
        $selectstart = '';
        $select = '';
        $s_level_data_all_options = '';
        if ($j == 0) {
            $lvl = '';
        } else {
            $lvl = $j;
        }

        $selectstart .= '&nbsp;Current/Max : <select name="min_ability' . $lvl . '" id="min_ability' . $lvl . '" style="width:5em;;">';

        for ($i = 0; $i < $min_ability_data_count; $i++) {
            if ($min_ability_data[$i] == $min_abilityyy[$j]) {
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            
            
		//if($_REQUEST['mode'] == 'post')
		if(request_var('mode','') == 'post')
		{
			$s_level_data_all_options .= "<option value=\"$min_ability_data[$i]\"  >$min_ability_data[$i]</option>";
			break;
		}else{
			$s_level_data_all_options .= "<option value=\"$min_ability_data[$i]\" $selected >$min_ability_data[$i]</option>";
		}
            
        }
        $selectends .= '</select>';
        if ($j != (count($min_abilityyy) - 1)) {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "/" . "<br>";
        } else {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "/";
        }
        
        $selectbox_min_ability .= $select;
    }
}


$max_abilityyy = json_decode($max_abilityy, true);

$s_max_ability = '';
for ($i = 0; $i < $max_ability_data_count; $i++) {
    if (count($max_abilityyy) == 1) {
        if ($max_ability_data[$i] == $max_abilityyy[0]) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
    }
    //if($_REQUEST['mode'] == 'post')
	if(request_var('mode','') == 'post')
	{
		$s_max_ability .= "<option value=\"$max_ability_data[$i]\">$max_ability_data[$i]</option>";
		break;
	}else{
		$s_max_ability .= "<option value=\"$max_ability_data[$i]\"$selected>$max_ability_data[$i]</option>";
	}
}
$selectbox_max_ability = '';
$button_ability = '<br>';
if (count($max_abilityyy) > 1) {
    for ($j = 0; $j < count($max_abilityyy); $j++) {
        $selectstart = '';
        $selectends = '';
        $select = '';
        $s_level_data_all_options = '';
        if ($j == 0) {
            $lvl = '';
        } else {
            $lvl = $j;
        }

		
        $selectstart .= '<select name="max_ability' . $lvl . '" id="max_ability' . $lvl . '" style="width:5em;;">';

        for ($i = 0; $i < $max_ability_data_count; $i++) {
            if ($max_ability_data[$i] == $max_abilityyy[$j]) {
                $value = $max_ability_data[$i];
                $ivalue = $j;
                $selected = 'selected="selected"';
            } else {
                $selected = '';
            }
            
            //if($_REQUEST['mode'] == 'post')
			if(request_var('mode','') == 'post')
			{
				$s_level_data_all_options .= "<option value=\"$max_ability_data[$i]\" >$max_ability_data[$i]</option>";
				break;
			}else{
				$s_level_data_all_options .= "<option value=\"$max_ability_data[$i]\" $selected >$max_ability_data[$i]</option>";
			}
            
        }
        $name = $post_id . '_' . $user->data["user_id"] . '_' . $ivalue;
        $selectends .= '</select>';
        $button_ability .='&nbsp<input type="button" name=' . $name . ' id=' . $value . ' value="-" class="btn btn-info-red" onclick="return remove_ability(this);"><br><br>';
        if ($j != (count($max_abilityyy) - 1)) {
            $select .= $selectstart . $s_level_data_all_options . $selectends . "<br>";
        } else {
            $select .= $selectstart . $s_level_data_all_options . $selectends;
        }

        $selectbox_max_ability .= $select;
    }
}
$seleted_gears = json_decode($seleted_gear, true);
$s_gear_data = '';
$sel_gear = array();
$sel_val = array();
for ($g = 0; $g < count($seleted_gears); $g++) {
    $exp = explode('(', $seleted_gears[$g]);
    $sel_gear[] = $exp[0];
    $sel_val[] = $exp[1];
}
$increment = 0;
$arr_merge = array_merge($gear_data, $sel_gear);
$unique = array_unique($arr_merge);
$values = array_values($unique);
$ar = array();
$ar = array_diff($values, $sel_gear);
//if($_REQUEST['mode'] == 'post'){

if(request_var('mode','') == 'post'){
	//$s_gear_data .= "<option value=''></option>";
	for ($gg = 0; $gg < count($values); $gg++) {
    if ($ar) {
        foreach ($ar as $key => $val) {
            if ($values[$gg] == $val) {
                $selected = 'deselected="deselected"';
                break;
            }
        }
    }
    foreach ($sel_gear as $key => $val) {
        if ($val == $values[$gg]) {
            if ($sel_val[$increment] != '') {
                $value1 = $val . '(' . $sel_val[$increment];
            } else {
                $value1 = $val;
            }
            $increment++;
            $values[$gg] = $value1;
            $selected = 'selected="selected"';
            break;
        }
    }
    $s_gear_data .= "<option value=\"$values[$gg]\" $selected >$values[$gg]</option>";
    unset($value1);
}
}else{
for ($gg = 0; $gg < count($values); $gg++) {
    if ($ar) {
        foreach ($ar as $key => $val) {
            if ($values[$gg] == $val) {
                $selected = 'deselected="deselected"';
                break;
            }
        }
    }
    foreach ($sel_gear as $key => $val) {
        if ($val == $values[$gg]) {
            if ($sel_val[$increment] != '') {
                $value1 = $val . '(' . $sel_val[$increment];
            } else {
                $value1 = $val;
            }
            $increment++;
            $values[$gg] = $value1;
            $selected = 'selected="selected"';
            break;
        }
    }
    $s_gear_data .= "<option value=\"$values[$gg]\" $selected >$values[$gg]</option>";
    unset($value1);
}
}

// quick skill ends

$quick_skill_varr = json_decode($quick_skill, true);
$quick_skill_var = @array_map('ucfirst', $quick_skill_varr);

$s_quick_skill_data = '';
$sel_skill = array();
$sel_skill1 = array();
$sel_skill_val = array();
$quick_sel_skill = array();
for ($ss = 0; $ss < count($quick_skill_var); $ss++) {
    $exp = explode('(', $quick_skill_var[$ss]);
    $sel_skill1[] = $exp[0];
}
for ($ss = 0; $ss < count($sel_skill1); $ss++) {
    $exp = explode('[', $sel_skill1[$ss]);
    $sel_skill[] = $exp[0];
}

//$increment = 0;
for ($qs = 0; $qs < count($quick_skill_data); $qs++) {
    $exp = explode('[', $quick_skill_data[$qs]);
    $quick_sel_skill[] = $exp[0];
    $quick_skill_val[] = $exp[1];
}
$ar = array_diff($quick_sel_skill, $sel_skill);
$values = array_values($ar);

for ($gg = 0; $gg < count($values); $gg++) {

    $values[$gg] = $values[$gg] . '[0]';
}

if ($quick_skill_var) {
    $arr_merge = array_merge($values, $quick_skill_var);
    sort($arr_merge);
$arr_merge = array_unique($arr_merge);
    if ($arr_merge) {
        for ($gg = 0; $gg < count($arr_merge); $gg++) {

            $selected = 'deselected="deselected"';
$quick_skill_var = array_unique($quick_skill_var);
            foreach ($quick_skill_var as $key => $val) {
                if ($val == $arr_merge[$gg]) {
                    $selected = 'selected="selected"';
                    break;
                }
            }
            //if($_REQUEST['mode'] == 'post')
			if(request_var('mode','') == 'post')	
            {
                if($arr_merge[$gg] == ''){
                      $s_quick_skill_data .= "";
                }
                else{
                    $s_quick_skill_data .= "<option value=\"$arr_merge[$gg]\"$selected >$arr_merge[$gg]</option>";
                }
            }
            
            else{
                if($arr_merge[$gg] == ''){
                      $s_quick_skill_data .= "";
                }
                else{
                    $s_quick_skill_data .= "<option value=\"$arr_merge[$gg]\"$selected >$arr_merge[$gg]</option>";
                }
            }

                        
            unset($selected);
        }
    }
} else {

    for ($gg = 0; $gg < $quick_skill_data_count; $gg++) {

        $s_quick_skill_data .= "<option value=\"$quick_skill_data[$gg]\">$quick_skill_data[$gg]</option>";
    }
}
// quick skill ends

$hero_points_data = json_decode($hero_points, true);
sort($hero_points_data);

$s_hero_points_data = '';
for ($hr = 0; $hr < count($hero_points_data); $hr++) {
    if ($hero_points_data[$hr] == $heropoint) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }

    $s_hero_points_data .= "<option value=\"$hero_points_data[$hr]\" $selected >$hero_points_data[$hr]</option>";
}

$s_critical_multiplier = "<select name='critical_multiplier'  id='critical_multiplier'>";

for ($hr = 1; $hr <= 5; $hr++) {
    if ($hr == $critical_multiplier) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }
    $s_critical_multiplier .= '<option value="' . $hr . '"  ' . $selected . '>' . $hr . '</option>';
}
$s_critical_multiplier .="</select>";

$array_type = array('B', 'P', 'S', 'M');
$types = json_decode($type, true);
if ($types != '') {
    sort($types);

    $s_type = '';

    for ($tp = 0; $tp < count($array_type); $tp++) {
        $selected = '';

        foreach ($types as $key => $val) {
            if ($val == $array_type[$tp]) {
                $selected = 'selected="selected"';
                break;
            } else {
                $selected = '';
            }
        }
        $s_type .= "<option value=\"$array_type[$tp]\" $selected >$array_type[$tp]</option>";
    }
}

$s_weapon_name = '';
$weapon_names = json_decode($weapon_name, true);
//if($_REQUEST['mode'] == 'post'){
if(request_var('mode','') == 'post'){
for ($wp = 0; $wp < count($weapon_names); $wp++) {
	    $s_weapon_name .= '<option value="' . $weapon_names[$wp] . '"  ' . $selected . '>' . $weapon_names[$wp] . '</option>';
	}
}
else{	
	for ($wp = 0; $wp < count($weapon_names); $wp++) {
	    $s_weapon_name .= '<option value="' . $weapon_names[$wp] . '"  ' . $selected . '>' . $weapon_names[$wp] . '</option>';
	}
}

// abbcode code starts archi11
$sbc = json_decode($seleted_bad_condition, true);
if (count($sbc) > 1) {
    $seleted_bad_condition1 = '';
    for ($j = 0; $j < count($sbc); $j++) {
        if ($j != (count($sbc) - 1)) {
        	$query1 = "SELECT * FROM `phpbb_condition`";
			$result1 = mysql_query($query1);
			while($rows1 = mysql_fetch_assoc($result1)){
				
        	if($rows1['bad_condition'] == $sbc[$j])
				{
            $seleted_bad_condition1 .="<label id='hover1' for='" . $sbc[$j] . "' title='" . $rows1['bad_desc'] . "' >".$sbc[$j] ."," . "</label>" . "&nbsp;";
        
    }   
       } 
       }
        
        else {
        	$query1 = "SELECT * FROM `phpbb_condition`";
			 $result1 = mysql_query($query1);
			while($rows1 = mysql_fetch_assoc($result1))
			{
				if($rows1['bad_condition'] == $sbc[$j])
				{
            $seleted_bad_condition1 .="<label id='hover1' for='" . $sbc[$j] . "' title='" . $rows1['bad_desc'] . "' >".$sbc[$j]."" . "</label>";
       }} }
    }
} elseif (count($sbc) == 1) {
    $seleted_bad_condition1 .=$sbc[0];
} elseif ($sbc == null) {
    $seleted_bad_condition1 = '';
}

//select good condition       
$sgc = json_decode($seleted_good_condition, true);
if (count($sgc) > 1) {
    $seleted_good_condition1 = '';
    for ($k = 0; $k < count($sgc); $k++) {
        if ($k != (count($sgc) - 1)) {
            $seleted_good_condition1 .=$sgc[$k] . ",&nbsp;";
        } else {
            $seleted_good_condition1 .=$sgc[$k];
        }
    }
} elseif (count($sgc) == 1) {
    $seleted_good_condition1 .=$sgc[0];
} elseif ($sbc == null) {
    $seleted_good_condition1 = '';
}

//CVC - 11/28/15 - Cycles through all spell levels, current and maximum spells for each level and builds the $spell_class_type string to hold that information, example: L0: 1/3, L1: 2/2, L2: 1/1
$level = json_decode($levels, true);
$level_min = json_decode($levels_min, true);
$level_max = json_decode($levels_max, true);

$l = 'L';
if (count($level) > 1 && ($level != null )) {
    $spell_class_type = '';
    for ($m = 0; $m < count($level); $m++) {
        if ($m != (count($level) - 1)) {
            $spell_class_type .=$l . "" . $level[$m] . ": " . $level_min[$m] . "/" . $level_max[$m] . ",&nbsp";
        } else {
            $spell_class_type .=$l . $level[$m] . ": " . $level_min[$m] . "/" . $level_max[$m];
        }
    }
  //echo nl2br ($spell_class_type . "\n");  
} elseif (($level != null) && (count($level) == 1)) {
    $spell_class_type = $l . $level[0] . ": " . $level_min[0] . "/" . $level_max[0];
} else {
    $spell_class_type = '';
}
if ($spell_class_type == 'L: /') {
    $spell_class_type = '';
}
//seleted ability or abilities
$ability_name = json_decode($ability_namey, true);
$min_ability = json_decode($min_abilityy, true);
$max_ability = json_decode($max_abilityy, true);


if (count($ability_name) > 1 && ($ability_name != null)) {
    $ability1 = '';
    for ($a = 0; $a < count($ability_name); $a++) {
        if ($a != (count($ability_name) - 1)) {
            $ability1 .=$ability_name[$a] . ": " . $min_ability[$a] . "/" . $max_ability[$a] . ",&nbsp";
        } else {
            $ability1 .=$ability_name[$a] . ": " . $min_ability[$a] . "/" . $max_ability[$a];
        }
    }
} elseif (($ability_name[0] != "") && (count($ability_name) == 1)) {
    $ability1 .=$ability_name[0] . ": " . $min_ability[0] . "/" . $max_ability[0];
} else {
    $ability1 = '';
}

//code for of Offense button display at abbcode starts archi11
$offense_buttons = '';
//if($_REQUEST['useraccount'] != ""){
if(request_var('useraccount','') != ""){
for ($of = 0; $of < count($weapon_names); $of++) {

    if ($of == (count($weapon_names) - 1)) {
        $offense_buttons .= '<input type=button name="' . $weapon_names[$of] . '" value="' . $weapon_names[$of] . '"  id="' . $user->data['user_id'] . '" style="background-color:pink" onclick="getoffense(this)">&nbsp;';
    } else {
        $offense_buttons .= '<input type=button name="' . $weapon_names[$of] . '" value="' . $weapon_names[$of] . '"  id="' . $user->data['user_id'] . '" style="background-color:pink" onclick="getoffense(this)">';
    }
}
}
//code for skill button display 

$skill_buttons = '';
$e = json_decode($quick_skill, true);
@$skill_names = array_unique(@$e);
//if($_REQUEST['useraccount'] != ""){
if(request_var('useraccount','') != ""){	
for ($sk = 0; $sk < count($skill_names); $sk++) {
    $a = explode("[", $skill_names[$sk]);
    $b = explode("(", $a[0]);
    if ($sk == (count($skill_names) - 1)) {
        $skill_buttons .= '<input type=button name="' . $skill_names[$sk] . '" value="' . $b[0] . '"  id="' . $user->data['user_id'] . '" style="background-color:#C0C0C0" onclick="getquickskill(this)">&nbsp;';
    } else {
        $skill_buttons .= '<input type=button name="' . $skill_names[$sk] . '" value="' . $b[0] . '"  id="' . $user->data['user_id'] . '" style="background-color:#C0C0C0" onclick="getquickskill(this)">';
    }
}}


// Decode AC & Saves
// CVC - 12/04/15

$DecodedAC = json_decode($ACS, true);
$Decoded_AC_count = count($DecodedAC);
 
    if ($DecodedAC) {
        $AC = $DecodedAC[0];          //AC
        $TAC = $DecodedAC[1];         //Touch AC
        $FFAC = $DecodedAC[2];        //Flat Footed AC
    
    }	
    else    {
        $AC = 0;
        $TAC = 0;
        $FFAC = 0;
    }
   
$DecodedSAVES = json_decode($SAVES, true);
$Decoded_SAVES_count = count($DecodedSAVES);

    if ($DecodedSAVES) {
        $FORT = $DecodedSAVES[0];          //AC
        $REFLEX = $DecodedSAVES[1];         //Touch AC
        $WILL = $DecodedSAVES[2];        //Flat Footed AC
            }
    else {
        $FORT = 0;
        $REFLEX = 0;
        $WILL = 0;
    }

$DecodedRESISTIMMUNITY = json_decode($RESISTIMMUNITY, true);
$Decoded_RESISTIMMUNITY_count = count($DecodedRESISTIMMUNITY);

    if ($DecodedRESISTIMMUNITY) {
        $RESIST = $DecodedRESISTIMMUNITY[0];          //AC
        $IMMUNITY = $DecodedRESISTIMMUNITY[1];         //Touch AC
            }
    else {
        $RESIST = 0;
        $IMMUNITY = 0;
        
    }
    
//code for of Offense display at abbcode starts archi11
/* $query = "SELECT " . USER_GROUP_TABLE . ".user_id
FROM " . USER_GROUP_TABLE . "
INNER JOIN " . GROUPS_TABLE . " ON " . USER_GROUP_TABLE . ".group_id = " . GROUPS_TABLE . ".group_id
WHERE " . GROUPS_TABLE . ".group_name =  'GLOBAL_MODERATORS'
OR " . GROUPS_TABLE . ".group_name =  'ADMINISTRATORS'
GROUP BY " . USER_GROUP_TABLE . ".user_id";
$results = $db->sql_query($query);
$alias_data1 = getAlias($user->data['user_id']);
$alias_count1 = count($alias_data1);

while ($row = $db->sql_fetchrow($results)) {
	
    $id[] = $row['user_id'];
}

if (in_array($user->data["user_id"], $id)) {
    $fetch_img = 'SELECT * FROM ' . MOD_IMG_LINK . ' WHERE moderator_id=' . $user->data["user_id"] . ' and post_id=' . $post_id;
    $img_que = $db->sql_query($fetch_img);
    $images1 = '';
    while ($row1 = $db->sql_fetchrow($img_que)) {
        $images1 .= '<h4>' . $row1["img_title"] . '</h4><br/><img src = "' . $row1["link_path"] . '"  style="width:690px;height:500px;margin-left:195px"><input type="button" name=' . $row1['moderator_link_id'] . ' onclick="delete_image(this.value)" value="Delete_'.$row1['moderator_link_id'].'" class="button1" style="margin-left: 17px; margin-top: -30px;"><input type="button" name=' . $row1['moderator_link_id'] . ' onclick=editimage(this.value) value="Edit_'.$row1['moderator_link_id'].'" class="button1" style="margin-left: 17px;margin-top: -30px;"><br/><br/>';
    }
	$images1 .= '<span id="update_form" style="margin-left:300px"></span>';
} else {
    $fetch_img = 'SELECT * FROM ' . MOD_IMG_LINK;
    $img_que = $db->sql_query($fetch_img);
    $images1 = '';
    while ($row1 = $db->sql_fetchrow($img_que)) {
        $images1 .= '<h4>' . $row1["img_title"] . '</h4><br/><img src = "' . $row1["link_path"] . '"  style="width:690px;height:500px" style="margin-left: 17px; margin-top: -30px;"><input type="button" name=' . $row1['moderator_link_id'] . ' onclick=editimage(this.value) value="Edit_'.$row1['moderator_link_id'].'" class="button1"><br/><br/>';
    }
}

//abbcode ends archi11
//process for the Central log of all changes groups

$select_group_id = "SELECT group_id FROM " . USERS_TABLE . " where user_id=" . $user->data['user_id'];
$result_user_table = $db->sql_query($select_group_id);
$id = $db->sql_fetchrow($result_user_table);
$user_groupid = $id['group_id'];

$select_group = "SELECT user_id FROM " . USER_GROUP_TABLE . " where group_id=" . $user_groupid;
$result_group_table = $db->sql_query($select_group);

$table = '<br><br><table class="table1"><tr><th class="th1">Player Name</th><th class="th1">Player Information</th></tr>';
$tableend = '</table><br><br>';
$coyu = 0;
//CSHELLY:  somewhere here it seems like it is grabbing the details for the character stats.


// CVC -- 11/24/15 - Moved group code below into LoadGroupInformation because it seems to currently be overwriting the loaded user variables to null and I don't need this to work yet
//include ($phpbb_root_path . 'includes/LoadGroupInformation.' . $phpEx);

while ($rows = $db->sql_fetchrowset($result)) {
    for ($i = 0; $i <= count($rows); $i++) {
        $user_id = $rows[$i]['user_id'];
        if ($user_id == $user->data['user_id']) {
            $status_value = 'block';
        }
    }
}

//code for the spell boxxes starts...
//code for the spell boxxes endss...
//archi11 code end

*/