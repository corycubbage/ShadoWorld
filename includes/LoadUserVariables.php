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
    $spell_data = $row['spell'];
    $spell_description = $row['spell_description'];

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
    
    $INIT = $row['INIT'];
    $SPEED = $row['SPEED'];
    $Vuser_id = $row['user_id'];
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

    $VariableTableSpellLevels = $row['level'];                                                     //CVC - 11/28/15 - Builds current spell level dropdown selection criteria, {"0":"0","1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":"8","9":"9"}
    $VariableTableSpellCurrent = $row['level_min'];                                             //CVC - 11/28/15 - Builds spell level current value dropdown selection criteria, between 0 - 99
    $VariableTableSpellMax = $row['level_max'];                                             //CVC - 11/28/15 - Builds spell level maximum value dropdown selection criteria, between 0 - 99

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

$static_spell_levels = json_decode($VariableTableSpellLevels, true);                          
sort($static_spell_levels);                                                                   
$TotalSpellLevelCount = count($static_spell_levels);                             

$static_spell_current = json_decode($VariableTableSpellCurrent, true);                          
sort($static_spell_current);                                                                   
$TotalSpellCurrentCount = count($static_spell_current);                             

$static_spell_max = json_decode($VariableTableSpellMax, true);                          
sort($static_spell_max);                                                                   
$TotalSpellMaxCount = count($static_spell_max);                             

$min_ability_data = json_decode($min_ability, true);
sort($min_ability_data);
$TotalAbilityCurrentCount = count($min_ability_data);

$max_ability_data = json_decode($max_ability, true);
sort($max_ability_data);
$TotalAbilityMaxCount = count($max_ability_data);

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

if(request_var('mode','') == 'post')
	
{

	$s_positive_condition_data .= "<option value=\"$positive_condition_data[$i]\">$positive_condition_data[$i]</option>";
}else{
	$s_positive_condition_data .= "<option value=\"$positive_condition_data[$i]\"$selected>$positive_condition_data[$i]</option>";
}
    
}
                               
// CVC - 12/15/15 - *** LOAD ALL SPELLS ***
// Load all spells from the database and check to see if the user has any spells saved.  If they do, mark them selected.
$decodedSpellLevels = json_decode($levels, true);                              
$decodedSpellType = json_decode($spellclasstype, true);                              
$decodedSpellCurrent = json_decode($levels_min, true);                              
$decodedSpellMax = json_decode($levels_max, true);                              
$decodedSpellList = json_decode($spell_data, true);                              
$decodedSpellDescription = json_decode($spell_description, true);                              
$TotalSpellLevelCount = count($static_spell_levels);                             
$TotalSpellCurrentCount = count($static_spell_current);                             
$TotalSpellMaxCount = count($static_spell_max);  
$TotalSpellLevels=0;
  

//print_r($decodedSpellLevels);
if ($decodedSpellLevels) {                                                     //User has spell levels
    
    $SpellTableData = '';
    $s_level_data = '';
    
    //for ($i = 0; $i < $TotalSpellLevelCount; $i++) {
    for ($i = 0; $i < 20; $i++) {
        $s_level_min_data = '';
        $s_level_max_data = '';
        $s_spell_data = '';
        $s_level_type_data = '';
        $s_selectedspells_data = '';
        
        //if ($decodedSpellLevels[$i] == $i) 
        if (isset($decodedSpellLevels[$i])) 
        {
            //echo nl2br("Level is present: " . $decodedSpellLevels[$i] . "\n");
            $s_level_data = "<option value=\"$decodedSpellLevels[$i]\" selected=\"selected\">$decodedSpellLevels[$i]</option>";
            $level =$decodedSpellLevels[$i];
            
            for ($si = 0; $si < $TotalSpellCurrentCount; $si++) {                       //Build Current dropdown and select current level
                if ($decodedSpellCurrent[$i] == $si) {
                    $s_level_min_data .= "<option value=\"$si\" selected=\"selected\">$si</option>";
                }
                else {
                    $s_level_min_data .= "<option value=\"$si\">$si</option>";
                }
            }
            for ($si = 0; $si < $TotalSpellMaxCount; $si++) {                       //Build Max dropdown and select current max level
                if ($decodedSpellMax[$i] == $si) {
                    $s_level_max_data .= "<option value=\"$si\" selected=\"selected\">$si</option>";
                }
                else {
                    $s_level_max_data .= "<option value=\"$si\">$si</option>";
                }
            }
            
            $decodedStype = $decodedSpellType[$i];
         
            switch ($decodedStype) {
                        case "0": 
                            $s_level_type_data = "<option value='Alchemist'>Alchemist</option>";
                            $spell_type = "Alchemist"; 
                            break;
                        case "1": 
                            $s_level_type_data = "<option value='Bard'>Bard</option>";
                            $spell_type = "Bard"; 
                            break;
                        case "2": 
                            $s_level_type_data = "<option value='Bloodrager'>Bloodrager</option>";
                            $spell_type = "Bloodrager"; 
                            break;
                        case "3": 
                            $s_level_type_data .= "<option value='Cleric'>Cleric</option>";
                            $spell_type = "Cleric";  
                            break;
                        case "4": 
                            $s_level_type_data .= "<option value='Druid'>Druid</option>";
                            $spell_type = "Druid"; 
                            break;                   
                        case "5": 
                            $s_level_type_data .= "<option value='Elementalist'>Elementalist</option>";
                            $spell_type = "Elementalist"; 
                            break;                                
                        case "6": 
                            $s_level_type_data .= "<option value='Inquisitor'>Inquisitor</option>";
                            $spell_type = "Inquisitor"; 
                            break;                                          
                        case "7": 
                            $s_level_type_data .= "<option value='Magus'>Magus</option>";
                            $spell_type = "Magus"; 
                            break;
                        case "8": 
                            $s_level_type_data .= "<option value='Paladin'>Paladin</option>";
                            $spell_type = "Paladin"; 
                            break;         
                        case "9": 
                            $s_level_type_data .= "<option value='Paladin'>Paladin</option>";
                            $spell_type = "Paladin"; 
                            break;                                                                  
                        case "10": 
                            $s_level_type_data .= "<option value='Ranger'>Ranger</option>";
                            $spell_type = "Ranger"; 
                            break;                                                                  
                        case "11": 
                            $s_level_type_data .= "<option value='Shaman'>Shaman</option>";
                            $spell_type = "Shaman"; 
                            break;                                                                  
                        case "12": 
                            $s_level_type_data .= "<option value='Sorcerer'>Sorcerer</option>";
                            $spell_type = "Sorcerer"; 
                            break;
                        case "13": 
                            $s_level_type_data .= "<option value='Summoner'>Summoner</option>";
                            $spell_type = "Summoner"; 
                            break;                                                                  
                        case "14": 
                            $s_level_type_data .= "<option value='Witch'>Witch</option>";
                            $spell_type = "Witch"; 
                            break;                                                                  
                        case "15": 
                            $s_level_type_data .= "<option value='Wizard'>Wizard</option>";
                            $spell_type = "Wizard"; 
                            break;                                          
                        case "16":
                            $s_level_type_data .= "<option value='Antipaladin'>Antipaladin</option>";
                            $spell_type = "Antipaladin"; 
                            break;                                                         
                        } 
           
            if ($spells_array) {
                unset($spells_array);
            }                
            include('./CreateSpellLists.php');
            $TotalSpellListCount = count($spells_array);                               //Total spells in the select box for spells of this level
            //echo "Spell level: $i has $TotalSpellListCount spells.";

            for ($si = 0; $si < $TotalSpellLevelCount; $si++) {                       //Increment through all possible spell levels (10)
                //JGL - this check was  not working as intended but unsure if this is the proper way to handle.
                //if ($decodedSpellList[$si]) {
                //echo nl2br("Si: $si\n");
                //echo nl2br("decodedSpellList[si]: $decodedSpellList[$si]\n");
                //if ($decodedSpellList[$si] && $si == $i) {                                         //Does the user have any saved spells for this level?
                 if ((isset($decodedSpellLevels[$i]) && $si == $i)) {
                    $TotalSpellListPerLevelCount = count($decodedSpellList[$si]);     //Total number of spells the user has for this level              
                    $s_selectedspells_data_count = 0;

                    for ($spellsinbookinc = 0; $spellsinbookinc < $TotalSpellListCount; $spellsinbookinc++) {           //Iterate through all spell spells in the spell list for this level                     
                        if ($s_selectedspells_data_count != $TotalSpellListPerLevelCount)  //skip check if we're done finding selected spells
                        {
                            for ($ssi = 0; $ssi < $TotalSpellListPerLevelCount; $ssi++) {                                           //Iterate through all user spells in the spell list for this level                     
                                if ($spells_array[$spellsinbookinc] == $decodedSpellList[$si][$ssi] ) {                            //Spell found in user list, mark as selected
                                     //echo nl2br ("===========> Matched spell: " . $spells_array[$spellsinbookinc] . "\n");
                                     $s_spell_data .= "<option value=\"$spells_array[$spellsinbookinc]\" selected = \"selected\">$spells_array[$spellsinbookinc]</option>";
                                     $spellfound = 1;

                                     if ($s_selectedspells_data_count ==0) {
                                         $s_selectedspells_data.= $spells_array[$spellsinbookinc];
                                     }
                                     Else {
                                             $s_selectedspells_data .= ", " . $spells_array[$spellsinbookinc];                                     
                                     }
                                     $s_selectedspells_data_count++;                             
                                }                        
                            }                
                        }
                        if (!$spellfound == 1) {                                                                                      //No matches for this spell, add as unselected.
                            //echo $si;
                            //echo nl2br ("X No matches, $spells_array[$spellsinbookinc] not selected.\n");
                            $s_spell_data .= "<option value=\"$spells_array[$spellsinbookinc]\">$spells_array[$spellsinbookinc]</option>";                        
                        } 
                        $spellfound = 0;
                    }              
                    $s_selectedspellsCount_data = "(" . $s_selectedspells_data_count . ")";
                }
                Else 
                {
                    if ($si == $i)
                    {
                        //echo nl2br("No saved spells for level: $si\n");     
                        if ($s_selectedspells_data_count < 1) {
                            for ($spellsinbookinc = 0; $spellsinbookinc < $TotalSpellListCount; $spellsinbookinc++) {           //Iterate through all spell spells in the spell list for this level                     
                                $s_spell_data .= "<option value=\"$spells_array[$spellsinbookinc]\">$spells_array[$spellsinbookinc]</option>";
                              
                            }
                        }
                    }
                }
            }
            
            
            $SpellTableData .= '<table><tr><td><input id="5" class="btn btn-info-red" type="button" name="' . $post_id . '_' . $Vuser_id . '_' . $i . '" value="-" addaditinal="" onclick="return remove_extra_level(this);"></td>';
            $SpellTableData .= '<td>&nbsp;&nbsp;&nbsp;</td><td><table><tr><td><label for="select_existing_type' . $i . '"><b>Type:</b></td><td><select name="select_existing_type' . $i . '" id="select_existing_type' . $i . '" style="width:3em;">' . $s_level_type_data . '</select></label></td><tr>';
            $SpellTableData .= '<tr><td><label for="select_existing_lvl' . $i . '"><b>Level:</b></td><td><select name="select_existing_level' . $i . '" id="select_existing_level' . $i . '" style="width:3em;">' . $s_level_data . '</select></label></td></tr>';
            $SpellTableData .= '<tr><td><b>Current:</b></td><td><select name="select_existing_level_min' . $i . '" id="select_existing_level_min' . $i . '" style="width:3em;">' . $s_level_min_data . '</select></td></tr>';
            $SpellTableData .= '<tr><td><b>Max:</b</td><td><select name="select_existing_level_max' . $i . '" id="select_existing_level_max' . $i . '" style="width:3em;">' . $s_level_max_data . '</select></td></tr></table></td>';
            $SpellTableData .= '<td>&nbsp;&nbsp;&nbsp;</td><td><table><tr><td><center><b>Spell List</b></center></td></tr><tr><td><select name="spell_existing_level'.$i.'[]" id="spell_existing_level' . $i . '" class="spell_existing_level" multiple>'.$s_spell_data.'</select>&nbsp;&nbsp;</td></tr></table></td>';
            //$SpellTableData .= '<td></td><td>' . $s_selectedspellsCount_data . '&nbsp;&nbsp</td><td><input class="form-control" type="text" name="selected_existingspells_level"' . $i . '" id="selected_existingspells_level"' . $i . '" value="'. $s_selectedspells_data .'" size="70" readonly></input></label></td>';
            //$SpellTableData .= '<td></td><td><table><tr><td><center><b>' . $s_selectedspellsCount_data . " Level " . $i . ' spells saved</b></center></td></tr><tr><td><textarea class="form-control" name="selected_existingspells_level"' . $i . '" id="selected_existingspells_level"' . $i . ' rows = "5" cols="75" readonly>' . $s_selectedspells_data .'</textarea></td></tr></table></td>';
            $SpellTableData .= '<td></td><td><table><tr><td><center><b>' . $s_selectedspellsCount_data . " Level " . $i . ' spells saved</b></center></td></tr><tr><td><input class="form-control" name="selected_existingspells_level' . $i . '" id="selected_existingspells_level' . $i . '" value="' . $s_selectedspells_data . '" size="70" readonly></input></td></tr></table></td>';
            $SpellTableData .= '</tr></table><br>';
            $TotalSpellLevels++;
        }
    }
}
//echo $SpellTableData;
unset($spells_array);

// CVC - 12/17/15 - Load Abilities
// **** ABILITIES *****

$DecodedAbilityName = json_decode($ability_namey, true);
$DecodedAbilityDesc = json_decode($ability_desy, true);
$DecodedAbilityCurrent = json_decode($min_abilityy , true);
$DecodedAbilityMax = json_decode($max_abilityy , true);    
$s_level_min_data = '';
$s_level_max_data = '';
$AbilityNameData = '';

if ($DecodedAbilityName[0] != '') {    
    if (count($DecodedAbilityName) != 0) {
        for ($i = 0; $i < count($DecodedAbilityName); $i++) {
            
            for ($si = 0; $si < $TotalAbilityCurrentCount; $si++) {                       //Build Current dropdown and select current level
                if ($DecodedAbilityCurrent[$i] == $si) {
                $s_level_min_data .= "<option value=\"$si\" selected=\"selected\">$si</option>";
                }
            else {
                $s_level_min_data .= "<option value=\"$si\">$si</option>";
                }
            }
            for ($si = 0; $si < $TotalAbilityMaxCount; $si++) {                       //Build Max dropdown and select current max level
                if ($DecodedAbilityMax[$i] == $si) {
                    $s_level_max_data .= "<option value=\"$si\" selected=\"selected\">$si</option>";
                }
                
                else {
                    $s_level_max_data .= "<option value=\"$si\">$si</option>";
                }
            }
            
            $AbilityNameData = $DecodedAbilityName[$i];
            //echo $AbilityNameData;
        $AbilityTableData .= '<br><table><tr><td><input id="5" class="btn btn-info-red" type="button" name="ab'. $post_id . '_' . $Vuser_id . '_' . $i .'" value="-" addaditinal="" onclick="return remove_extra_ability(this);"></td>';
        $AbilityTableData .= '<td>&nbsp;&nbsp;</td><td><table><td>Name:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="existing_ability'.$i.'" class="ability" id="existing_ability'.$i.'" value="' . $AbilityNameData .'" size="40"></input></td>';
        $AbilityTableData .= '<tr><td>Description:</td><td>&nbsp;&nbsp;</td><td><input type="text" name="existing_abilities_description' . $i . '" id="existing_abilities_description' . $i . '" value="' . $DecodedAbilityDesc[$i] . '" size="40"></td></tr></table></td>';
        $AbilityTableData .= '<td>&nbsp;&nbsp;</td><td><table><td>Current:</td><td>&nbsp;&nbsp;</td><td><select name="existing_min_ability'.$i.'" id="existing_min_ability'.$i.'" style="width:4em;">'.$s_level_min_data.'</select></td><tr><td>Max:</td><td>&nbsp;&nbsp;</td><td><select name="existing_max_ability'.$i.'" id="existing_max_ability'.$i.'" style="width:4em;">'.$s_level_max_data.'</select></td></tr></table>';       
        $AbilityTableData .= '</tr></table>';           
        }
    }
}

unset ($TotalAbilityMaxCount);
unset ($TotalAbilityCurrentCount);
unset ($DecodedAbilityName);
unset ($DecodedAbilityDesc);
unset ($DecodedAbilityCurrent);
unset ($DecodedAbilityMax);
unset ($ability_namey);
unset ($ability_desy);
unset ($min_abilityy);
unset ($max_abilityy);

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
// Build Init Dropdown select
$InitSelect_data = json_decode($hero_points, true);
sort($InitSelect_data);

$s_init_data = '';
for ($hr = 0; $hr < count($InitSelect_data); $hr++) {
    if ($InitSelect_data[$hr] == $INIT) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }

    $s_init_data .= "<option value=\"$InitSelect_data[$hr]\" $selected >$InitSelect_data[$hr]</option>";
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