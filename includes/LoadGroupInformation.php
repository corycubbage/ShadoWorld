<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

while ($row1 = $db->sql_fetchrow($result_group_table)) {

    $select_variables = "SELECT * from " . USER_VARIABLES_TABLE . " INNER JOIN " . USERS_TABLE . " ON " . USER_VARIABLES_TABLE . ".user_id = " . USERS_TABLE . ".user_id WHERE " . USERS_TABLE . ".user_id=" . $row1['user_id'] . "  GROUP BY phpbb_user_variable.user_id";
    $result1 = $db->sql_query($select_variables);

    $count = 0;


    while ($row = $db->sql_fetchrow($result1)) {
        $id = $row['id'];
        $player_id = $row['user_id'];
        $player_name = $row['username'];
        $image = $row['user_avatar'];

        $img = '';
        if ($image) {
            $img = "<img src='./download/file.php?avatar=" . $image . "' height=34px>";
        }

		
		//$PLAYERINFO = $row['PLAYERINFO'];  CSHELLY TEST
		//$CLASS_INFO = $row['CLASS_INFO'];
		//$AC = $row['AC'];
		
        $selected_current_hit = $row['selected_current_hit'];
        $selected_maximum_hit = $row['selected_maximum_hit'];
        $seleted_non_lethal = $row['seleted_non_lethal'];


        if ((($selected_current_hit == 0) or ! ($selected_current_hit == '')) && (($selected_maximum_hit == 0) or ! ($selected_maximum_hit == '')) && (($seleted_non_lethal == 0) or ! ($seleted_non_lethal == ''))) {

            $brh = '[<font color="#138600">';

            if (($selected_current_hit == 0)or ! ($selected_current_hit == '')) {
                if (!($selected_current_hit == '')) {
                    $brh .= 'HP:&nbsp;' . $selected_current_hit . '/' . $selected_maximum_hit;
                }
            }
            if (( $seleted_non_lethal == 0) or ! ($seleted_non_lethal == '')) {

                if (!($seleted_non_lethal == '')) {
                    $brh .=', NL:&nbsp;';
                }
                $brh.= $seleted_non_lethal;
            }
            if (!($seleted_non_lethal == '') or ! ($selected_current_hit == '')) {
                $brh .='</font>]';
            }
        }
        //bad good condition
        $good_condition = $row['seleted_good_condition'];
        $bad_condition = $row['seleted_bad_condition'];
        $sgc = json_decode($good_condition, true);
        $sbc = json_decode($bad_condition, true);


        $seleted_bad_condition2 = '';
        if (count($sbc) > 1) {

            for ($bc = 0; $bc < count($sbc); $bc++) {
                if ($bc != (count($sbc) - 1)) {
                    $seleted_bad_condition2 .=$sbc[$bc] . ",&nbsp;";
                } else {
                    $seleted_bad_condition2 .=$sbc[$bc];
                }
            }
        } elseif (count($sbc) == 1) {
            $seleted_bad_condition2 .=$sbc[0];
        } elseif ($sbc == null) {
            $seleted_bad_condition2 = '';
        }
        $seleted_good_condition2 = '';
        //seleted good condition       
        if (count($sgc) > 1) {

            for ($gc = 0; $gc < count($sgc); $gc++) {
                if ($gc != (count($sgc) - 1)) {
                    $seleted_good_condition2 .=$sgc[$gc] . ",&nbsp;";
                } else {
                    $seleted_good_condition2 .=$sgc[$gc];
                }
            }
        } elseif (count($sgc) == 1) {
            $seleted_good_condition2 .=$sgc[0];
        } elseif ($sgc == null) {
            $seleted_good_condition2 = '';
        }

        if ($seleted_good_condition2 or ( $seleted_good_condition2 == '') or $seleted_bad_condition2 or ( $seleted_bad_condition2 == '')) {
            if (!($seleted_good_condition2 == '') or ! ($seleted_bad_condition2 == ''))
                $con = '[';
            if ($seleted_good_condition2 or ( $seleted_good_condition2 == '')) {
                $con .='<font color="#0070CA ">' . $seleted_good_condition2 . '</font>';
            }
            if (!($seleted_good_condition2 == '') and ! ($seleted_bad_condition2 == '')) {
                $con .=',&nbsp;';
            }
            if ($seleted_bad_condition2 or ( $seleted_bad_condition2 == '')) 
            {
            	/* Sanket Change */
            	$bad_conditions = explode(',',$seleted_bad_condition2);
            	$total_bad = count($bad_conditions);
            	for($i=0;$i<$total_bad;$i++)
            	{
            		$bad_conditionnew  =  str_replace("&nbsp;","",$bad_conditions[$i]);
					$s = "SELECT `bad_desc` FROM `phpbb_condition` WHERE `bad_condition`='".$bad_conditionnew."'";
	            	$desdata = mysql_query($s);
	            	$t = mysql_num_rows($desdata);
	            	if($t>0)
	            	{
		            	$rr = mysql_fetch_array($desdata,MYSQL_ASSOC);
			           	$description = $rr['bad_desc'];
		               	$con.="<lable id='hover1' title='".$description."' for='".$bad_conditions[$i]."'><font color='#FF0000 '>" . $bad_conditions[$i] . "</font></lable>";
		               	$con .=',&nbsp;';
		            }
		            else
		            {
						$con.="<lable id='hover1' title='&nbsp;' for='".$bad_conditions[$i]."'><font color='#FF0000 '>" . $bad_conditions[$i] . "</font></lable>";
		               	$con .=',&nbsp;';
					}
               	}
                /* ------------- */
                if (!($seleted_good_condition2 == '') or ! ($seleted_bad_condition2 == ''))
                    $con .= ']';
                
            }
        }

        //sleted level or levels
        $level = json_decode($row['level'], true);
        $level_min = json_decode($row['level_min'], true);
        $level_max = json_decode($row['level_max'], true);

        $l = 'L';
        if (count($level) > 1 && ($level != null )) {
            $levels = '';
            for ($lvs = 0; $lvs < count($level); $lvs++) {
                if ($lvs != (count($level) - 1)) {
                    $levels .=$l . "" . $level[$lvs] . ": " . $level_min[$lvs] . "/" . $level_max[$lvs] . ",&nbsp";
                } else {
                    $levels .=$l . $level[$lvs] . ": " . $level_min[$lvs] . "/" . $level_max[$lvs];
                }
            }
        } elseif (($level != null) && (count($level) == 1)) {
            $levels = $l . $level[0] . ": " . $level_min[0] . "/" . $level_max[0];
        } else {
            $levels = '';
        }

        $lvls = '';
        if ($levels and $levels != 'L : /') {
            $lvls .='[<font color="#5F497A ">' . $levels . '</font>]';
        }

        if ($levels == 'L: /') {
            $lvls .='';
        }
        //seleted ability or abilities
        $ability_name = json_decode($row['ability_name'], true);
        $min_ability = json_decode($row['min_ability'], true);
        $max_ability = json_decode($row['max_ability'], true);


        if (count($ability_name) > 1 && ($ability_name != null)) {
            $ability = '';
            for ($a = 0; $a < count($ability_name); $a++) {
                if ($a != (count($ability_name) - 1)) {
                    $ability .=$ability_name[$a] . ": " . $min_ability[$a] . "/" . $max_ability[$a] . ",&nbsp";
                } else {
                    $ability .=$ability_name[$a] . ": " . $min_ability[$a] . "/" . $max_ability[$a];
                }
            }
        } elseif (($ability_name[0] != "") && (count($ability_name) == 1)) {
            $ability .=$ability_name[0] . ": " . $min_ability[0] . "/" . $max_ability[0];
        } else {
            $ability = '';
        }

        $ablity = '';
        if ($ability) {
            $ablity .= '[<font color="#5F497A ">' . $ability . '</font>]';
        }
        //$variable .= '<tr><td>'.$img.'</td><td><font color="#0658B0" size=3px>' . $row['username'] . '</font></td><td>: ' . $brh.$con.$lvls.$ablity.'</td></tr>';
       

        //$variable = '<tr><td class="td1"><font color="#0658B0" size=2px>' . $row['username'] . '</font></td><td class="td1"><font size=2px>: ' . $brh . $con . $lvls . $ablity . '</font></td></tr>';
        unset($ability);
        unset($con);
        unset($brh);
        unset($lvls);
    }
    //$variabls .= $table . $variable . $tableend;
    $variabls .= $variable;
    //unset($variable);
    
}
for ($al1 = 0; $al1 < $alias_count; $al1++) {
        
        $select_level = "SELECT * from phpbb_user_variable WHERE user_id =".$alias_data1[$al1]['user_id'];
        $result1 = mysql_query($select_level);
        	while ($rows1 = $db->sql_fetchrowset($result1)) {
     //ability
        	
 $ability_name1 = json_decode($rows1[0]['ability_name'], true);
 $min_ability1 = json_decode($rows1[0]['min_ability'], true);
 $max_ability1 = json_decode($rows1[0]['max_ability'], true);	
  
        if (count($ability_name1) > 1 && ($ability_name1 != null)) {
            $ability1 = '';
            for ($b = 0; $b < count($ability_name1); $b++) {
                if ($b != (count($ability_name1) - 1)) {
                    $ability1 .=$ability_name1[$b] . ": " . $min_ability1[$b] . "/" . $max_ability1[$b] . ",&nbsp";
                } else {
                    $ability1 .=$ability_name1[$b] . ": " . $min_ability1[$b] . "/" . $max_ability1[$b];
                }
            }
        } elseif (($ability_name1[0] != "") && (count($ability_name1) == 1)) {
            $ability1 .=$ability_name1[0] . ": " . $min_ability1[0] . "/" . $max_ability1[0];
        } else {
            $ability1 = '';
        }

        $ablity1 = '';
        if ($ability1) {
            $ablity1 .= '[<font color="#5F497A ">' . $ability1 . '</font>]';
        }
        	// level or levels
        $level1 = json_decode($rows1[0]['level'], true);
        $level_min1 = json_decode($rows1[0]['level_min'], true);
        $level_max1 = json_decode($rows1[0]['level_max'], true);

        $l1 = 'L';
        if (count($level1) > 1 && ($level1 != null )) {
            $levels1 = '';
            for ($lvs1 = 0; $lvs1 < count($level1); $lvs1++) {
                if ($lvs1 != (count($level1) - 1)) {
                    $levels1 .=$l1 . "" . $level1[$lvs1] . ": " . $level_min1[$lvs1] . "/" . $level_max1[$lvs1] . ",&nbsp";
                } else {
                    $levels1 .=$l1 . $level1[$lvs1] . ": " . $level_min1[$lvs1] . "/" . $level_max1[$lvs1];
                }
            }
        } elseif (($level1 != null) && (count($level1) == 1)) {
            $levels1 = $l1 . $level1[0] . ": " . $level_min1[0] . "/" . $level_max1[0];
        } else {
            $levels1 = '';
        }

        $lvls1 = '';
        if ($levels1 and $levels1 != 'L : /') {
            $lvls1 .='[<font color="#5F497A ">' . $levels1 . '</font>]';
        }

        if ($levels1 == 'L: /') {
            $lvls1 .='';
        }
        
        //Bad Cond
        
        //bad good condition
        $good_condition = $rows1[0]['seleted_good_condition'];
        $bad_condition = $rows1[0]['seleted_bad_condition'];
        $sgc = json_decode($good_condition, true);
        $sbc = json_decode($bad_condition, true);


        $seleted_bad_condition2 = '';
        if (count($sbc) > 1) {

            for ($bc = 0; $bc < count($sbc); $bc++) {
                if ($bc != (count($sbc) - 1)) {
                    $seleted_bad_condition2 .=$sbc[$bc] . ",&nbsp;";
                } else {
                    $seleted_bad_condition2 .=$sbc[$bc];
                }
            }
        } elseif (count($sbc) == 1) {
            $seleted_bad_condition2 .=$sbc[0];
        } elseif ($sbc == null) {
            $seleted_bad_condition2 = '';
        }
        $seleted_good_condition2 = '';
        //seleted good condition       
        if (count($sgc) > 1) {

            for ($gc = 0; $gc < count($sgc); $gc++) {
                if ($gc != (count($sgc) - 1)) {
                    $seleted_good_condition2 .=$sgc[$gc] . ",&nbsp;";
                } else {
                    $seleted_good_condition2 .=$sgc[$gc];
                }
            }
        } elseif (count($sgc) == 1) {
            $seleted_good_condition2 .=$sgc[0];
        } elseif ($sgc == null) {
            $seleted_good_condition2 = '';
        }

        if ($seleted_good_condition2 or ( $seleted_good_condition2 == '') or $seleted_bad_condition2 or ( $seleted_bad_condition2 == '')) {
            if (!($seleted_good_condition2 == '') or ! ($seleted_bad_condition2 == ''))
                $con = '[';
            if ($seleted_good_condition2 or ( $seleted_good_condition2 == '')) {
                $con .='<font color="#0070CA ">' . $seleted_good_condition2 . '</font>';
            }
            if (!($seleted_good_condition2 == '') and ! ($seleted_bad_condition2 == '')) {
                $con .=',&nbsp;';
            }
            if ($seleted_bad_condition2 or ( $seleted_bad_condition2 == '')) 
            {
            	/* Sanket Change */
            	$bad_conditions = explode(',',$seleted_bad_condition2);
            	$total_bad = count($bad_conditions);
            	for($i=0;$i<$total_bad;$i++)
            	{
            		$bad_conditionnew  =  str_replace("&nbsp;","",$bad_conditions[$i]);
					$s = "SELECT `bad_desc` FROM `phpbb_condition` WHERE `bad_condition`='".$bad_conditionnew."'";
	            	$desdata = mysql_query($s);
	            	$t = mysql_num_rows($desdata);
	            	if($t>0)
	            	{
		            	$rr = mysql_fetch_array($desdata,MYSQL_ASSOC);
			           	$description = $rr['bad_desc'];
		               	$con.="<lable id='hover1' title='".$description."' for='".$bad_conditions[$i]."'><font color='#FF0000 '>" . $bad_conditions[$i] . "</font></lable>";
		               	$con .=',&nbsp;';
		            }
		            else
		            {
						$con.="<lable id='hover1' title='&nbsp;' for='".$bad_conditions[$i]."'><font color='#FF0000 '>" . $bad_conditions[$i] . "</font></lable>";
		               	$con .=',&nbsp;';
					}
               	}
                /* ------------- */
                if (!($seleted_good_condition2 == '') or ! ($seleted_bad_condition2 == ''))
                    $con .= ']';
                
            }
        }
        
        //condition 
        
        
		//$PLAYERINFO = $rows1[0]['PLAYERINFO']; CSHELLY TEST
		//$CLASS_INFO = $rows1[0]['CLASS_INFO'];
		//$AC = $rows1[0]['AC'];

		$selected_current_hit = $rows1[0]['selected_current_hit'];
        $selected_maximum_hit =  $rows1[0]['selected_maximum_hit'];
        $seleted_non_lethal = $rows1[0]['seleted_non_lethal'];


        if ((($selected_current_hit == 0) or ! ($selected_current_hit == '')) && (($selected_maximum_hit == 0) or ! ($selected_maximum_hit == '')) && (($seleted_non_lethal == 0) or ! ($seleted_non_lethal == ''))) {

            $brh = '[<font color="#138600">';

            if (($selected_current_hit == 0)or ! ($selected_current_hit == '')) {
                if (!($selected_current_hit == '')) {
                    $brh .= 'HP:&nbsp;' . $selected_current_hit . '/' . $selected_maximum_hit;
                }
            }
            if (( $seleted_non_lethal == 0) or ! ($seleted_non_lethal == '')) {

                if (!($seleted_non_lethal == '')) {
                    $brh .=', NL:&nbsp;';
                }
                $brh.= $seleted_non_lethal;
            }
            if (!($seleted_non_lethal == '') or ! ($selected_current_hit == '')) {
                $brh .='</font>]';
            }
        }
        
        
        
        	
       $variable = '<tr><td class="td1"><font color="#0658B0" size=2px>' . $alias_data1[$al1][username] . '</font></td><td class="td1"><font size=2px>: ' . $brh . $con . $lvls1 . $ablity1 . '</font></td></tr>';
    
      $variabls .= $variable;
    
}
} 

$gruop_variables = $table . $variabls . $tableend;
//log view code ends
//SPELL page code starts
//if ($_GET['spellpage'] == 1) {
if (request_var('spellpage','') == 1) {
    $accout_id = $_GET['user_id'];
    $modes = $_GET['mode'];
    $forums = $_GET['f'];
    if ($modes == 'edit') {
        $post_id_spell = $_GET['p'];
        $tvariable = $_GET['t'];
    }
    $spell = 1;
    $s_spell_page_spell = '';
    $spell1 = json_decode($spells, true);
    for ($sk = 0; $sk < count($spell1); $sk++) {
        $s_spell_page_spell .= "<option value=\"$spell1[$sk]\">$spell1[$sk]</option>";
    }
} else {
    $spell = 0;

}
// admin and moderator set map code

$query = "SELECT " . USER_GROUP_TABLE . ".user_id
FROM " . USER_GROUP_TABLE . "
INNER JOIN " . GROUPS_TABLE . " ON " . USER_GROUP_TABLE . ".group_id = " . GROUPS_TABLE . ".group_id
WHERE " . GROUPS_TABLE . ".group_name =  'GLOBAL_MODERATORS'
OR " . GROUPS_TABLE . ".group_name =  'ADMINISTRATORS'
GROUP BY " . USER_GROUP_TABLE . ".user_id";

$result = $db->sql_query($query);