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

//if (request_var('increment_variable_spell','')) {
//if ($TotalSpellLevels > 0) {

    $level = array();
    $spell_class_type = array();                //CVC - 12/05/15 - Added
    $level_min = array();
    $level_max = array();
    $spell = array();

    for ($i = 0; $i < 10; $i++) {
        
        if ((request_var('select_level' . $i . '',''))!='') {            
            
                $decodedST = (request_var('select_type' . $i . '',''));

                switch ($decodedST) {
                    case "Bard": 
                        $decodedST ="0";
                        break;
                    case "Cleric": 
                        $decodedST ="1";
                        break;
                    case "Druid": 
                        $decodedST ="2";
                        break;
                    case "Paladin": 
                        $decodedST ="3";
                        break;
                    case "Ranger": 
                        $decodedST ="4";
                        break;                   
                    case "Wizard": 
                        $decodedST ="6";
                        break;                                
                    case "Sorcerer": 
                        $decodedST ="6";
                        break;                                          
                    }      
        $spell_class_type[] = $decodedST;
               
        $level[] = request_var('select_level' . $i . '','');
        print_r("Level: " . (request_var('select_level' . $i . '','')));
        $level_min[] = request_var('select_level_min' . $i . '','');
        $level_max[] = request_var('select_level_max' . $i . '','');    
        
         }
}   
    
        //$lmin = "{\"0\":\"1\",\"1\":\"2\",\"2\":\"7\"}";    //{"0":"4","1":"6","2":"8"}
        //$lmax = "{\"0\":\"4\",\"1\":\"6\",\"2\":\"5\"}";    //{"0":"1","1":"2","2":"4"}
        //$l = "{\"0\":\"0\",\"1\":\"1\",\"2\":\"2\"}";       //{"0":"0","1":"1","2":"2"}
        //$sct = "{\"0\":\"1\",\"1\":\"1\",\"0\":\"1\"}";     //{"0":"0","1":"1","2":"0"}
        //$spell_variable1 = "{\"0\":{\"0\":\"Detect Magic\",\"1\":\"Message\",\"2\":\"Read Magic\"},\"1\":{\"0\":\"Bane\", \"1\":\"Cure Light Wounds\",\"2\":\"Command\"},\"2\":{\"0\":\"Alter Self\",\"1\":\"Animal Trance\",\"2\":\"Blur\"}}"; //{"0":{"0":"Detect Magic","1":"Message","2":"Read Magic"},"1":{"0":"Bane", "1":"Cure Light Wounds","2":"Command"},"2":{"0":"Alter Self","1":"Animal Trance","2":"Blur"}}
        
        $spell_desc1 = "TBD";
        $l = json_encode($level, JSON_FORCE_OBJECT);    
        $sct = json_encode($spell_class_type, JSON_FORCE_OBJECT);
        $lmin = json_encode($level_min, JSON_FORCE_OBJECT);
        $lmax = json_encode($level_max, JSON_FORCE_OBJECT);
        
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