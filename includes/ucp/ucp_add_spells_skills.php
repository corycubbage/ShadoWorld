<?php
//archi11 code
include('../../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_SPELL_ABILITY', $table_prefix . 'user_spell_ability');
define('VARIABLES_TABLE', $table_prefix . 'variables');

if ($_REQUEST['add'] == 'adspellname') {
    ?>
    <table>
        <tr>
            <td><br>
                Spell name : <input type=text name='spellname' value='' id='aspellname'>
            </td>
        </tr>
        <tr>
            <td>
                <input type=button name='Add Spell' value='Add' id='addspell' class="btn btn-info" onclick="addspellname()"> 
            </td>
        </tr>

    </table>
    <?php
}
//if ($_REQUEST['add'] == 'insertspellname' && $_REQUEST['spellname'] != '' && $_REQUEST['account_id'] != '') {
//
//    $select_level = "SELECT spell from " . USER_SPELL_ABILITY . " WHERE user_id =" . $_REQUEST['account_id'];
//    $result1 = mysql_query($select_level);
//    $num_rows = mysql_num_rows($result1);
//    if ($num_rows >= 1) {
//        while ($row = mysql_fetch_assoc($result1)) {
//            $spell = $row['spell'];
//        }
//        $spell1 = json_decode($spell, true);
//
//        if (in_array($_REQUEST['spellname'], $spell1)) {
//            
//        } else {
//            $r = array_merge($spell1, array($_REQUEST['spellname']));
//            $spell = json_encode($r, JSON_FORCE_OBJECT);
//            $update = "UPDATE " . USER_SPELL_ABILITY . " SET spell = '" . $spell . "' WHERE user_id =" . $_REQUEST['account_id'];
//            mysql_query($update);
//        }
//    } else {
//        $spell = json_encode(array($_REQUEST['spellname']), JSON_FORCE_OBJECT);
//        $insert = "INSERT INTO " . USER_SKILL . " values(''," . $_REQUEST['account_id'] . ",'" . $spell . "','')";
//        mysql_query($insert);
//    }
//}

if ($_REQUEST['add'] == 'AddDescription') {
    ?>
    <table cellspacing="5">
       
            <tr><td>
                    Name
                </td><td><input type="text" name="skillname" value="<?php echo $_REQUEST['selected']; ?>" id="<?php echo $_REQUEST['selected']; ?>"></td></tr>
            <tr><td>
                    Description
                </td><td><textarea name="description" id="description"  style="width:420px"></textarea></td></tr>
        </tr><tr><td><br></td></tr>
    
    <tr><td>

        </td><td><input type="button" name="submit_description"  id="submit_description" value="Add" class="btn btn-info" onclick="submitdescription();"></td></tr>
    </table>
    <?php
}
if ($_REQUEST['add'] == 'Addskilltouserskill') {

    $select_level = "SELECT user_spell from " . USER_SPELL_ABILITY . " WHERE user_id =" . $_REQUEST['account_id'];
    $result1 = mysql_query($select_level);
    $num_rows = mysql_num_rows($result1);
    if ($num_rows >= 1) {
        while ($row = mysql_fetch_assoc($result1)) {
            $user_spell = $row['user_spell'];
        }
        $user_spell1 = json_decode($user_spell, true);
        if ($user_spell1 != null) {

            $level = $_REQUEST['level'];

            foreach ($user_spell1 as $key => $val) {
                if ($key == $level) {
                    
                   $user_spell1[$key]['name'] = $_REQUEST['spell'];
                   $user_spell1[$key]['description'] = $_REQUEST['description'];
                    
                    $spell = json_encode($user_spell1, JSON_FORCE_OBJECT);
                    $update = "UPDATE " . USER_SPELL_ABILITY . " SET user_spell = '" . $spell . "' WHERE user_id =" . $_REQUEST['account_id'];
                    mysql_query($update);
                   
                } else {

                    $level = $_REQUEST['level'];
                    $array = array("$level" => array('name' => $_REQUEST['spell'], 'description' => $_REQUEST['description']));
                    $user_spell1pp = $user_spell1 + $array;

                    $spell = json_encode($user_spell1pp, JSON_FORCE_OBJECT);
                    $update = "UPDATE " . USER_SPELL_ABILITY . " SET user_spell = '" . $spell . "' WHERE user_id =" . $_REQUEST['account_id'];
                    mysql_query($update);
                }
            }
        } else {

            $level = $_REQUEST['level'];
            $array = json_encode(array("$level" => array('name' => $_REQUEST['spell'], 'description' => $_REQUEST['description'])), JSON_FORCE_OBJECT);
            $update = "UPDATE " . USER_SPELL_ABILITY . " SET user_spell = '" . $array . "' WHERE user_id =" . $_REQUEST['account_id'];
            mysql_query($update);
        }
    } else {

        $level = $_REQUEST['level'];
        $array = json_encode(array("$level" => array('name' => $_REQUEST['spell'], 'description' => $_REQUEST['description'])), JSON_FORCE_OBJECT);

        $insert = "INSERT INTO " . USER_SPELL_ABILITY . " values(''," . $_REQUEST['account_id'] . ",'" . $array . "')";
        mysql_query($insert);
    }
}

if ($_REQUEST['add'] == 'Editspelldata') {
    $select = "SELECT * from " . USER_SPELL_ABILITY . " WHERE user_id =" . $_REQUEST['account_id'];
    $result1 = mysql_query($select);
    $num_rows = mysql_num_rows($result1);

    $select_level = "SELECT level from " . VARIABLES_TABLE;
    $result = mysql_query($select_level);
    $lvl = mysql_fetch_array($result);
    $rows = mysql_num_rows($result);

    if ($_REQUEST['mode'] == 'edit') {
        $link = 'mode=' . $_REQUEST['mode'] . '&f=' . $_REQUEST['forum'] . '&p=' . $_REQUEST['post_spell_id'] . '&t=' . $_REQUEST['tvarible'];
    } else {
        $link = 'mode=' . $_REQUEST['mode'] . '&f=' . $_REQUEST['forum'];
    }

    if ($num_rows) {
        while ($row = mysql_fetch_assoc($result1)) {

            $user_spell = $row['user_spell'];
        }
    }

    if ($user_spell != null && $lvl['level'] != null) {
        $levels = json_decode($lvl['level'], true);
        $spell = json_decode($user_spell, true);
        $spell_count = count($spell);
        $levels_count = count($levels);
        $sel = '';
        $spell_options_create = '';
        $tablestart = '<form action="posting.php?' . $link . '" name="edir_spell" method="post" id="editform"><table cellspacing="5">';
        $tablesends = '</table></form>';
        $level = '';
        $name = '';
        foreach ($spell as $k => $v) {


            for ($j = 0; $j < $levels_count; $j++) {
                if ($levels[$j] == $k) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $spell_options_create .= "<option " . $selected . ">" . $levels[$j] . "</option>";
            }
            $sel = "<select id='level_" . $k . "' name='level_" . $k . "'>" . $spell_options_create . "</select>";
            unset($spell_options_create);

            $level = "<tr><td><font color='red'>Level</font></td> <td>" . $sel . "<br></td></tr>";
            //for ($ki = 0; $ki < count($spell[$k]['name']); $ki++) {
                $name .="<tr><td> Name </td><td><input type='hidden' name='account_id' value=" . $_REQUEST['account_id'] . "><input type='hidden' name='skillname_" . $k . "' value='" . $spell[$k]['name']. "' id='lvl_" . $k . "_" . $spell[$k]['name']. "'><input type='text' name='skillname' value='" . $spell[$k]['name']. "' id='lvl_" . $k . "_" . $spell[$k]['name']. "' disabled></td></tr><tr><td style='vertical-align:top'>Description &nbsp&nbsp </td><td><textarea name='description_" . $k . "' id='description_level_" . $k . "_" . $spell[$k]['name'] . "'  style='width:420px'>" . $spell[$k]['description']. "</textarea><br><br></td></tr>";
            //}

            $tablestart .=$level . $name;
            unset($name);
        }
        $tablestart .="<tr><td><br></td></tr><tr><td></td><td><input type='submit' name='submit_description'  id='submit_description' value='Edit' class='btn btn-info' onclick='editdescription();'></td></tr>";
        echo $tablestart . $tablesends;
    }
}
?>