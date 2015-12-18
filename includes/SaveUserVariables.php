<?php
// This file was extracted from posting.php so that it would be easier to diagnose and troubleshoot issues. - 11/25/CVC

if (request_var('gear_desc1','') != '' && request_var('gear_value','') != '') {
    $ct = count(request_var('gear_desc1',''));
    // $gear_description = array();
    for ($gd = 0; $gd < $ct; $gd++) {
        //$gear_description[request_var('gear_value','')[$gd]] = request_var('gear_desc1','')[$gd];
    }
    $gear_desc = json_encode($gear_description, JSON_FORCE_OBJECT);
    $data_update_post = array('gear_description' => $gear_desc);
    //debug_to_console("SaveUserVariables - Loading gear and descriptions:" . $data_update_post);
    $sql = 'UPDATE ' . USER_VARIABLES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data_update_post) . ' WHERE user_id = ' . $poster_id;
    $db->sql_query($sql);
}

if (request_var('nc_name','') != '' && request_var('nc_name_hide','') != '') {  // negative(bad)  description
    $ct = count(request_var('nc_name',''));
    for ($gd = 0; $gd < $ct; $gd++) {
        //$nc_description[request_var('nc_name_hide','')[$gd]] = request_var('nc_name','')[$gd];
    }
    $nc_desc = json_encode($nc_description, JSON_FORCE_OBJECT);
    $data_update_post = array(
        'negative_concdition_description' => $nc_desc);
    $sql = 'UPDATE ' . USER_VARIABLES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data_update_post) . ' WHERE user_id = ' . $poster_id;
    $db->sql_query($sql);
}

if (request_var('pc_name','') != '' && request_var('pc_name_hide','') != '') { // positive(good) description
    $ct = count(request_var('pc_name',''));
    for ($gd = 0; $gd < $ct; $gd++) {
        $poscond = request_var('pc_name_hide','');
        $posname = request_var('pc_name','');
        $pc_description[$poscond][$gd] = $posname[$gd];
    }
    $pc_desc = json_encode($pc_description, JSON_FORCE_OBJECT);
    $data_update_post = array('positive_condition_description' => $pc_desc);
    $sql = 'UPDATE ' . USER_VARIABLES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data_update_post) . ' WHERE user_id = ' . $poster_id;
    $db->sql_query($sql);
} 

if (request_var('skill_desc','') != '' && request_var('hidden_skill','') != '') {
    $ct = count(request_var('skill_desc',''));
    for ($gd = 0; $gd < $ct; $gd++) {
        //$skill_description[request_var('hidden_skill','')[$gd]] = request_var('skill_desc','')[$gd];
    }
    $skill_desc = json_encode($skill_description, JSON_FORCE_OBJECT);
    $data_update_post = array(
        'skill_description' => $skill_desc);
    $sql = 'UPDATE ' . USER_VARIABLES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data_update_post) . ' WHERE user_id = ' . $poster_id;
    $db->sql_query($sql);
}// skill description


// CVC - 12/16/15 - Check for spell information and prepare it for saving to database
// *** SAVE SPELLS  ***
    $level = array();
    $spell_class_type = array();                //CVC - 12/05/15 - Added
    $level_min = array();
    $level_max = array();
    $spell = array();
    $spelldesc = array();
    $levelExisting = array();
    $level_minExisting = array();
    $level_maxExisting = array();
    $spellExisting = array();
    
    
        // Find existing and new spell levels
        for ($i = 0; $i < 20; $i++) {                                           //Hard coding to 20 levels

            if ((request_var('select_existing_level' . $i . '',''))!='') {      //Existing Spell Levels      
            
                $decodedSTExisting = (request_var('select_existing_type' . $i . '',''));
                switch ($decodedSTExisting) {
                            case "Alchemist": 
                                $decodedSTExisting ="0";
                                break;
                            case "Bard": 
                                $decodedSTExisting ="1";
                                break;
                            case "Bloodrager": 
                                $decodedSTExisting ="2";
                                break;
                            case "Cleric": 
                                $decodedSTExisting ="3";
                                break;
                            case "Druid": 
                                $decodedSTExisting ="4";
                                break;                   
                            case "Elementalist": 
                                $decodedSTExisting ="5";
                                break;                                
                            case "Inquisitor": 
                                $decodedSTExisting ="6";
                                break;                                          
                            case "Magus": 
                                $decodedSTExisting ="7";
                                break;
                            case "Oracle": 
                                $decodedSTExisting ="8";
                                break;                                                                  
                            case "Paladin": 
                                $decodedSTExisting ="9";
                                break;                                                                  
                            case "Ranger": 
                                $decodedSTExisting ="10";
                                break;                                                                  
                            case "Shaman": 
                                $decodedSTExisting ="11";
                                break;                                                                  
                            case "Sorcerer": 
                                $decodedSTExisting ="12";
                                break;
                            case "Summoner": 
                                $decodedSTExisting ="13";
                                break;                                                                  
                            case "Witch": 
                                $decodedSTExisting ="14";
                                break;                                                                  
                            case "Wizard": 
                                $decodedSTExisting ="15";
                                break;                                          
                            }      
                $spell_class_typeExisting[] = $decodedSTExisting;               
                $levelExisting[] = request_var('select_existing_level' . $i . '','');
                $level_minExisting[] = request_var('select_existing_level_min' . $i . '','');
                $level_maxExisting[] = request_var('select_existing_level_max' . $i . '','');    
                $spellExisting[] = request_var('spell_existing_level'. $i. '', array('' => ''));        
             }
            
             if ((request_var('select_level' . $i . '',''))!='') {                // Newly added spell levels      

                $decodedST = (request_var('select_type' . $i . '',''));
                switch ($decodedST) {
                        case "Alchemist": 
                            $decodedST ="0";
                            break;
                        case "Bard": 
                            $decodedST ="1";
                            break;
                        case "Bloodrager": 
                            $decodedST ="2";
                            break;
                        case "Cleric": 
                            $decodedST ="3";
                            break;
                        case "Druid": 
                            $decodedST ="4";
                            break;                   
                        case "Elementalist": 
                            $decodedST ="5";
                            break;                                
                        case "Inquisitor": 
                            $decodedST ="6";
                            break;                                          
                        case "Magus": 
                            $decodedST ="7";
                            break;
                        case "Oracle": 
                            $decodedST ="8";
                            break;                                                                  
                        case "Paladin": 
                            $decodedST ="9";
                            break;                                                                  
                        case "Ranger": 
                            $decodedST ="10";
                            break;                                                                  
                        case "Shaman": 
                            $decodedST ="11";
                            break;                                                                  
                        case "Sorcerer": 
                            $decodedST ="12";
                            break;
                        case "Summoner": 
                            $decodedST ="13";
                            break;                                                                  
                        case "Witch": 
                            $decodedST ="14";
                            break;                                                                  
                        case "Wizard": 
                            $decodedST ="15";
                            break;                                          
                        }      
                $spell_class_type[] = $decodedST;
                $level[] = request_var('select_level' . $i . '','');
                $level_min[] = request_var('select_level_min' . $i . '','');
                $level_max[] = request_var('select_level_max' . $i . '','');    
                $spell[] = request_var('spell_level' . $i . '', array('' => ''));    
            }
        }   

        // *** Testing data 
        //$lmin = "{\"0\":\"1\",\"1\":\"2\",\"2\":\"7\"}";    //{"0":"4","1":"6","2":"8"}
        //$lmax = "{\"0\":\"4\",\"1\":\"6\",\"2\":\"5\"}";    //{"0":"1","1":"2","2":"4"}
        //$l = "{\"0\":\"0\",\"1\":\"1\",\"2\":\"2\"}";       //{"0":"0","1":"1","2":"2"}
        //$sct = "{\"0\":\"1\",\"1\":\"1\",\"0\":\"1\"}";     //{"0":"0","1":"1","2":"0"}
        //$spell_variable1 = "{\"0\":{\"0\":\"Detect Magic\",\"1\":\"Message\",\"2\":\"Read Magic\"},\"1\":{\"0\":\"Bane\", \"1\":\"Cure Light Wounds\",\"2\":\"Command\"},\"2\":{\"0\":\"Alter Self\",\"1\":\"Animal Trance\",\"2\":\"Blur\"}}"; //{"0":{"0":"Detect Magic","1":"Message","2":"Read Magic"},"1":{"0":"Bane", "1":"Cure Light Wounds","2":"Command"},"2":{"0":"Alter Self","1":"Animal Trance","2":"Blur"}}

       // Check existing and new spell levels and encode the information 
       $level = array_filter($level, 'myFilter');
       $levelExisting = array_filter($levelExisting, 'myFilter'); 
       
        if ((!empty($level) && (!empty($levelExisting)))) {                       //Existing and New spell levels        
            $MergedLevels = array_merge($levelExisting, $level);
            $MergedLevelsMin = array_merge($level_minExisting, $level_min);
            $MergedLevelsMax = array_merge($level_maxExisting, $level_max);
            $MergedLevelsType = array_merge($spell_class_typeExisting, $spell_class_type);
            $MergedLevelsSpellList = array_merge($spellExisting, $spell);
            
            $l = json_encode($MergedLevels, JSON_FORCE_OBJECT);    
            $sct = json_encode($MergedLevelsType, JSON_FORCE_OBJECT);
            $lmin = json_encode($MergedLevelsMin, JSON_FORCE_OBJECT);
            $lmax = json_encode($MergedLevelsMax, JSON_FORCE_OBJECT);
            $final_spell_list = json_encode($MergedLevelsSpellList, JSON_FORCE_OBJECT);
        }

        if ((empty($level) && (!empty($levelExisting)))) {                       //Existing levels but no new levels
            $l = json_encode($levelExisting, JSON_FORCE_OBJECT);    
            $sct = json_encode($spell_class_typeExisting, JSON_FORCE_OBJECT);
            $lmin = json_encode($level_minExisting, JSON_FORCE_OBJECT);
            $lmax = json_encode($level_maxExisting, JSON_FORCE_OBJECT);
            $final_spell_list = json_encode($spellExisting, JSON_FORCE_OBJECT);
        }
        
        if ((!empty($level) && (empty($levelExisting)))) {                       //No existing levels but new levels
            ECHO "No existing levels but new levels found!";
            echo "Level";
            print_r($level);
            echo nl2br ("\nType: ");
            $l =  json_encode($level, JSON_FORCE_OBJECT);
            $sct = json_encode($spell_class_type, JSON_FORCE_OBJECT);
            $lmin = json_encode($level_min, JSON_FORCE_OBJECT);
            $lmax = json_encode($level_max, JSON_FORCE_OBJECT);
            $final_spell_list = json_encode($spell, JSON_FORCE_OBJECT);
        }        
        
        if ((empty($level) && (empty($levelExisting)))) {                       //No spells at all
            //No spell levels for this user
            $l='';
            $lmax='';
            $lmin='';
            $sct='';
            $final_spell_list=0;
        }
        
        // Cleanup
        unset ($levelExisting);
        unset ($spellExisting);
        unset ($level_minExisting);
        unset ($level_maxExisting);
        unset ($spell_class_typeExisting);
        unset ($level);
        unset ($level_min);
        unset ($level_max);
        unset ($spell_class_type);
        unset ($MergedLevels);

    // CVC - 12/17/15 - SAVE ABILITIES
    // **************************************
        
    $ExistingAbilityLevel = array();
    $ExistingAbilityDesc = array();                
    $ExistingAbilityCurrent = array();
    $ExistingAbilityMax = array();
    $NewAbilityLevel = array();
    $NewAbilityDesc = array();                
    $NewAbilityCurrent = array();
    $NewAbilityMax = array();
    
        //Existing Ability Levels
        for ($i = 0; $i <  20; $i++) {                                          //Setting hard limit of 20 abilities
            if ((request_var('existing_ability' . $i . '',''))!='') {            
                $ExistingAbilityLevel[] = request_var('existing_ability' . $i . '','');
                $ExistingAbilityCurrent[] = request_var('existing_min_ability' . $i . '','');
                $ExistingAbilityMax[] = request_var('existing_max_ability' . $i . '','');    
                $ExistingAbilityDesc[] = request_var('existing_abilities_description'. $i. '', '');        
                 }
            
            if ((request_var('ability' . $i . '',''))!='') {            
                $NewAbilityLevel[] = request_var('ability' . $i . '','');
                $NewAbilityCurrent[] = request_var('min_ability' . $i . '','');
                $NewAbilityMax[] = request_var('max_ability' . $i . '','');    
                $NewAbilityDesc[] = request_var('abilities_description'. $i. '', '');        
                 }
        } 
       
       $NewAbilityLevel = array_filter($NewAbilityLevel, 'myFilter'); 
       $ExistingAbilityLevel = array_filter($ExistingAbilityLevel, 'myFilter'); 

       
        if ((!empty($NewAbilityLevel) && (!empty($ExistingAbilityLevel)))) {                       //Existing and New spell levels
            //echo "Existing and New ability levels";
            //echo nl2br ("\nExisting - ");
            //print_r ($ExistingAbilityLevel);
            //echo nl2br ("\nAdded - ");
            //print_r ($NewAbilityLevel);
        
            $MergedLevels = array_merge($ExistingAbilityLevel, $NewAbilityLevel);
            $MergedLevelsMin = array_merge($ExistingAbilityCurrent, $NewAbilityCurrent);
            $MergedLevelsMax = array_merge($ExistingAbilityMax, $NewAbilityMax);
            $MergedLevelsDesc = array_merge($ExistingAbilityDesc, $NewAbilityDesc);

            $SavedAbilityName = json_encode($MergedLevels, JSON_FORCE_OBJECT);    
            $SavedAbilityCurrent = json_encode($MergedLevelsMin, JSON_FORCE_OBJECT);
            $SavedAbilityMax = json_encode($MergedLevelsMax, JSON_FORCE_OBJECT);
            $SavedAbilityDesc = json_encode($MergedLevelsDesc, JSON_FORCE_OBJECT);
        }

        if ((empty($NewAbilityLevel) && (!empty($ExistingAbilityLevel)))) {                       //Existing levels but no new levels
            //echo "Existing ability levels but no new ability levels";
            //echo nl2br ("\nExisting - ");
            //print_r ($ExistingAbilityLevel);
            
            $SavedAbilityName = json_encode($ExistingAbilityLevel, JSON_FORCE_OBJECT);    
            $SavedAbilityCurrent = json_encode($ExistingAbilityCurrent, JSON_FORCE_OBJECT);
            $SavedAbilityMax = json_encode($ExistingAbilityMax, JSON_FORCE_OBJECT);
            $SavedAbilityDesc = json_encode($ExistingAbilityDesc, JSON_FORCE_OBJECT);
        }
        
        if ((!empty($NewAbilityLevel) && (empty($ExistingAbilityLevel)))) {                       //No existing levels but new levels
            //echo "No existing ability levels but new ability levels";
            //echo nl2br ("\nAdded - ");
            //print_r ($level);

            $SavedAbilityName =  json_encode($NewAbilityLevel, JSON_FORCE_OBJECT);
            $SavedAbilityCurrent = json_encode($NewAbilityCurrent, JSON_FORCE_OBJECT);
            $SavedAbilityMax = json_encode($NewAbilityMax, JSON_FORCE_OBJECT);
            $SavedAbilityDesc = json_encode($NewAbilityDesc, JSON_FORCE_OBJECT);            
        }        
        
        if ((empty($NewAbilityLevel) && (empty($ExistingAbilityLevel)))) {                       //No abilites
            //echo "No existing ability levels but new ability levels";
            //echo nl2br ("\nAdded - ");
            //print_r ($level);

            $SavedAbilityName = '';
            $SavedAbilityCurrent = '';
            $SavedAbilityMax = '';
            $SavedAbilityDesc = '';
        }        
        
        // Cleanup
        unset ($ExistingAbilityLevel);
        unset ($ExistingAbilityDesc);
        unset ($ExistingAbilityCurrent);
        unset ($ExistingAbilityMax);
        unset ($NewAbilityLevel);
        unset ($NewAbilityDesc);
        unset ($NewAbilityDesc);
        unset ($NewAbilityCurrent);
        unset ($NewAbilityMax);
        
// **** END ABILITIES
// *************************************        
    
    $SPEED = request_var('SPEED','');
    $INIT = request_var('select_init_points','');
    
    $ACValues = array();     
    $ACValues[] = request_var('AC','');
    $ACValues[] = request_var('TAC','');
    $ACValues[] = request_var('FFAC','');
    $SavedAC = json_encode($ACValues, JSON_FORCE_OBJECT);            

     unset ($ACValues);
     
    $SaveValues = array();     
    $SaveValues[] = request_var('FORT','');
    $SaveValues[] = request_var('REFLEX','');
    $SaveValues[] = request_var('WILL','');
    $SavedSaves = json_encode($SaveValues, JSON_FORCE_OBJECT);            

     unset ($SaveValues);
         
    $SavedResitImmunityVales = array();     
    $SaveValues[] = request_var('RESIST','');
    $SaveValues[] = request_var('IMMUNITY','');
    $SavedResitImmunity = json_encode($SaveValues, JSON_FORCE_OBJECT); 
    
    unset ($SavedResitImmunityVales);
    
    $SavedResitImmunityVales = array();     
    $AbilityDamageValues[] = request_var('AbilityDamage','');
    $AbilityDamageValues[] = request_var('DamageType','');
    $SavedAbilityDamage = json_encode($AbilityDamageValues, JSON_FORCE_OBJECT); 
         
        //$MergedLevels = array_merge($level_minExisting, $level_min);
        //$MergedLevels = array_merge($level_maxExisting, $level_max);
        //$MergedLevels = array_merge($spell_class_typeExisting, $spell_class_type);
        
        //$spell_desc1 = "TBD";
        //$l = json_encode($level, JSON_FORCE_OBJECT);    
        //$sct = json_encode($spell_class_type, JSON_FORCE_OBJECT);
        //$lmin = json_encode($level_min, JSON_FORCE_OBJECT);
        //$lmax = json_encode($level_max, JSON_FORCE_OBJECT);
        
        //$level_min1 = array_merge(array(request_var('select_level_min','')), $level_min);
        //$spell_desc1 =  json_encode($level_min1, JSON_FORCE_OBJECT);
        //$sct = json_encode($spell_class_type, JSON_FORCE_OBJECT);
        //$lmin = json_encode($level_min, JSON_FORCE_OBJECT);
        //$lmax = json_encode($level_max, JSON_FORCE_OBJECT);
    
    /*
    $spell_desc = array();
    for ($i = 1; $i < request_var('increment_variable_spell',''); $i++) {
        $lvl = request_var('select_level' . $i . '','');
        $spell = request_var('spell_level' . $i . '','');
        $spell_details[$lvl] = array('name' => $spell);
        $spl = request_var('spell_desc' . $i . '','');
        for ($s = 0; $s < count($spl); $s++) {
            $spell_desc[$lvl][$spell[$s]] = $spl[$s];
        }
        unset($lvl);
        unset($spl);
    }
    
    $level1 = array_merge(array(request_var('select_level','')), $level);
    $spell_class_type1 = array_merge(array(request_var('select_type','')), $spell_class_type);
    $level_min1 = array_merge(array(request_var('select_level_min','')), $level_min);
    $level_max1 = array_merge(array(request_var('select_level_max','')), $level_max);

    $l = json_encode($level1, JSON_FORCE_OBJECT);
    $sct = json_encode($spell_class_type1, JSON_FORCE_OBJECT);
    $lmin = json_encode($level_min1, JSON_FORCE_OBJECT);
    $lmax = json_encode($level_max1, JSON_FORCE_OBJECT);
    $lmin = "{\"8:\",\"8:\"}";
    
    $fl = request_var('select_level','');
    $sd = request_var('spell_desc','');
    for ($s1 = 0; $s1 < count($sd); $s1++) {
        $spell_desc[$fl][$fs[$s1]] = $sd[$s1];
    }
    $spell_details1 = array("$fl" => array('name' => $fs));
    $merge = $spell_details + $spell_details1;
    $spell_variable1 = json_encode($merge, JSON_FORCE_OBJECT);
    $spell_desc1 = json_encode($spell_desc, JSON_FORCE_OBJECT);
} else {

    $l = json_encode(array(request_var('select_level','')), JSON_FORCE_OBJECT);
    $sct = json_encode(array(request_var('select_type','')), JSON_FORCE_OBJECT);
    $lmin = json_encode(array(request_var('select_level_min','')), JSON_FORCE_OBJECT);
    $lmax = json_encode(array(request_var('select_level_max','')), JSON_FORCE_OBJECT);
    $lmin = "{\"9:\",\"9:\"}";
    $fl = request_var('select_level','');
    $fs = request_var('spell_level','');
   // $spell_details1 = array("$fl" => array('name' => $fs));
    $spell_details1 = array("$fl" => array('name' => $fs));

    //$merge =   $spell_details1;
    $spell_variable1 = json_encode($spell_details1, JSON_FORCE_OBJECT);

    //$spell_variable1 = json_decode($spell_details1, JSON_FORCE_OBJECT);
    
    
}

*/
/*
if (request_var('increment_variable_ability','') and request_var('increment_variable_ability','') > 1) {
    $ability = array();
    $ability_min = array();
    $ability_max = array();
    $abilities_description = array();
    for ($i = 1; $i < request_var('increment_variable_ability',''); $i++) {
        $ability[] = stripslashes(request_var('ability' . $i . '',''));
        $ability_min[] = request_var('min_ability' . $i . '','');
        $ability_max[] = request_var('max_ability' . $i . '','');
        $abilities_description[request_var('ability' . $i . '','')] = request_var('abilities_description' . $i . '','');
    }

    $ability1 = array_merge(array(stripslashes(request_var('ability',''))), $ability);
    $ability_min1 = array_merge(array(request_var('min_ability','')), $ability_min);
    $ability_max1 = array_merge(array(request_var('max_ability','')), $ability_max);
    $desc1[request_var('ability','')] = request_var('abilities_description','');
    $abilities_description1 = array_merge($desc1, $abilities_description);

    $a = json_encode($ability1, JSON_FORCE_OBJECT);
    $amin = json_encode($ability_min1, JSON_FORCE_OBJECT);
    $amax = json_encode($ability_max1, JSON_FORCE_OBJECT);
    $abilities_desc = json_encode($abilities_description1, JSON_FORCE_OBJECT);
} else {
    $a = json_encode(array(stripslashes(request_var('ability',''))), JSON_FORCE_OBJECT);
    $amin = json_encode(array(request_var('min_ability','')), JSON_FORCE_OBJECT);
    $amax = json_encode(array(request_var('max_ability','')), JSON_FORCE_OBJECT);
    $abilities_description[request_var('ability','')] = request_var('abilities_description','');
    $abilities_desc = json_encode($abilities_description, JSON_FORCE_OBJECT);
}
(/
 * 
 */
        
if (request_var('gear','') != '') {
    $gear_quality = json_encode(request_var('gear',''), JSON_FORCE_OBJECT);
} else {
    $gear_quality = '';
}

if (request_var('skill','') != '') {
    $skill_quality = json_encode(request_var('skill',''), JSON_FORCE_OBJECT);
} else {
    $skill_quality = '';
}

if (request_var('post_as','') != '') {                                          //Selected an alias from Post As dropdown, set $poster_id accordingly
    $poster_id = request_var('post_as','');
    $message = "Requested POST_AS.  New POSTER_ID == " . $poster_id;
    //echo "<script type='text/javascript'>alert('$message');</script>";
} else {
    $poster_id = (int) $post_data['poster_id'];
        $message = "Posting as default alias.  POSTER_ID == " . $poster_id;
        //echo "<script type='text/javascript'>alert('$message');</script>";
}

if (request_var('type','') != '') {
    $type = json_encode(request_var('type',''), JSON_FORCE_OBJECT);
} else {
    $type = '';
}
//if (isset(request_var('image_name','')) && isset(request_var('image_url',''))) {
    $image_name = "NotUsed"; //$image_name = request_var('image_name','');
    $image_url = "NotUsed"; //$image_url = request_var('image_url','');
//}

    	// CVC 11/26/15
           // Look up the username and color for the poster_id that was selected in dropdown and set it to $data['poster_name']
           $presult = mysql_query("SELECT username FROM phpbb_users WHERE user_id = $poster_id LIMIT 1");
           $poster_name = mysql_fetch_array($presult);           
           $quoted_poster_name = '\'' . $poster_name[0] . '\'';
           $poster_name = $poster_name[0];
           //$data['poster_name'] = $updated_poster_name;
           mysql_free_result($presult);
           
           $presult = mysql_query("SELECT user_colour FROM phpbb_users WHERE user_id = $poster_id LIMIT 1");
           $puser_color = mysql_fetch_array($presult);           
           $updated_color = $puser_color[0];
           //$data['user_colour'] = $updated_color;
           mysql_free_result($presult);
           
           
           //print_r($postername); == HATCH
           //print_r($poster_name[0]); == HATCH
           //print_r($data['poster_name']); == 'HATCH'
           
           //debug_to_console("data[Poster_name] :" . $data['poster_name']);         
           //debug_to_console("Poster_name :" . $updated_poster_name);
           //debug_to_console("data[Poster_id] :" . $data['poster_id']);         
           //debug_to_console("Poster_id :" . $poster_id);     
        // CVC 11/26/15