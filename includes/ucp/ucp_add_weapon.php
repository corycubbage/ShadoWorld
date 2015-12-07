<?php 
 
//archi11 code
include('../../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE', $table_prefix . 'user_variable');
if (@$_REQUEST['seleted'] != "" && @$_REQUEST['seleted'] && @$_REQUEST['AddWaepen']) {

    $rq = $_REQUEST['seleted'];
    $seleted = explode(",", $rq);

    for ($i = 0; $i < count($seleted); $i++) {
        ?>

        <table>
            <tr>
                <td><?php echo $seleted[$i]; ?>
                    <input type=hidden name='addfieldsweaponname_<?php echo $i; ?>' value='<?php echo $seleted[$i]; ?>' id='addfieldsweaponname_<?php echo $i; ?>'>
                </td>
            </tr>
            <tr>
                <td>
                    <font class='fontface'>Attack</font>
                </td>
                <td>

                    <input type="text" name="attack[]" value="" id="attack_<?php echo $i; ?>">
                </td>
            </tr>
            <tr>
                <td>

                    <font class='fontface'>Damage<font>
                </td>
                <td>
                    <input type="text" name="damage[]" value="" id="damage_<?php echo $i; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <font class='fontface'>Critical Multiplier<font>
                </td>
                <td>

                    <select name='critical_multiplier_<?php echo $i; ?>'  id='critical_multiplier_<?php echo $i; ?>'>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <font class='fontface'>Range</font>
                </td>
                <td>
                    <input type="text" name="range[]" value="" id="range_<?php echo $i; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <font class='fontface'>Type</font>
                </td>
                <td>
                    <select name='type_<?php echo $i; ?>[]'  id='type_<?php echo $i; ?>' multiple>
                        <option value="B">B</option>
                        <option value="P">P</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                    </select>
                </td>
            </tr>

        </table>
        <?php
        if ($i < count($seleted) - 1) {
            echo "<hr style='width:342px'>";
        }
    }

    echo "<input type=hidden name=addfieldscount value='" . count($seleted) . "' id=addfieldscount>";
    echo "<input type=button name=addfields value='Update Weapon' Weapon Fields class='button1' onclick='updateweaponfields()'>";
}

if (@$_REQUEST['addfieldsweaponname'] != "" && @$_REQUEST['addfieldsweaponname'] && @$_REQUEST['Database'] && $_REQUEST['user_id']) {

    $select = 'SELECT weapon_field FROM ' . USER_VARIABLES_TABLE . ' WHERE user_id =' . $_REQUEST['user_id'];
    $result1 = mysql_query($select);
    $row = mysql_fetch_assoc($result1);
	
    $weapon_field = json_decode($row['weapon_field'], true);
    $addfieldsweaponname = explode(',', $_REQUEST['addfieldsweaponname']);
    $attack = explode(',', $_REQUEST['attack']);
    $damage = explode(',', $_REQUEST['damage']);
    $critical_multiplier = explode(',', $_REQUEST['critical_multiplier']);
    $range = explode(',', $_REQUEST['range1']);
    $fields_count = $_REQUEST['fields_count'];
	//echo $fields_count;die;
    $fields = array();
    $all_fields = array();


    if ($fields_count > 0) {
        for ($i = 0; $i < $fields_count; $i++) {

            foreach ($weapon_field as $key => $val) {
                if ($weapon_field[$key][0] == $addfieldsweaponname[$i]) {
                    $weapon_field[$key] = array($addfieldsweaponname[$i], array($attack[$i], $damage[$i], $critical_multiplier[$i], $range[$i], $_REQUEST['type1'][$i]));
                }
            }
        }
    } else {

        foreach ($weapon_field as $key => $val) {
            if ($weapon_field[$key][0] == $addfieldsweaponname[0]) {
                $weapon_field[$key] = array($addfieldsweaponname[0], array($attack[0], $damage[0], $critical_multiplier[0], $range[0], $_REQUEST['type1'][0]));
            }
        }
    }

    if ($weapon_field != null) {
        $all_fields = array_merge($weapon_field, $fields);
        $json_encoded_string = json_encode($all_fields, JSON_FORCE_OBJECT);
    } else {
        $json_encoded_string = json_encode($fields, JSON_FORCE_OBJECT);
    }
    $update = "UPDATE " . USER_VARIABLES_TABLE . " SET weapon_field='" . $json_encoded_string . "' WHERE user_id =" . $_REQUEST['user_id'];
	echo $update;
    $res = mysql_query($update);
}

if ($_REQUEST['weponaname']) 
{
    $select = 'SELECT weapon_name,weapon_field FROM ' . USER_VARIABLES_TABLE . ' WHERE user_id =' . $_REQUEST['user_id'];
    $result1 = mysql_query($select);
    $row = mysql_fetch_assoc($result1);
    $weapon_name = json_decode($row['weapon_name'], true);
	

    if ($weapon_name != '') 
    {
        $weapop_update = array_merge($weapon_name, array($_REQUEST['weponaname']));
        $string = json_encode($weapop_update, JSON_FORCE_OBJECT);
    } else 
    {
        $string = json_encode(array($_REQUEST['weponaname']), JSON_FORCE_OBJECT);
    }

	//Update Weapon Field
	$weapon_field = json_decode($row['weapon_field'], true);
	
	$attack = $_REQUEST['attack'];
    $damage = $_REQUEST['damage'];
    $critical_multiplier = $_REQUEST['critical_multiplier'];
    $range = $_REQUEST['range'];
	$type = $_REQUEST['type'];
	
	$weapon_name = $_REQUEST['weponaname'];
	$weapons = array($damage, $attack, $critical_multiplier, $range, $type);
	$weapon_field[] = array($weapon_name, $weapons);
	
	$weapon_field = json_encode($weapon_field, JSON_FORCE_OBJECT);
	
    $update = "UPDATE " . USER_VARIABLES_TABLE . " SET weapon_name='". $string ."', weapon_field = '".$weapon_field."' WHERE user_id =" . $_REQUEST['user_id'];
    
    mysql_query($update);
}
if ($_REQUEST['DeleteWeapen']) {

    echo $select = 'SELECT * FROM ' . USER_VARIABLES_TABLE . ' WHERE user_id =' . $_REQUEST['user_id']; 
    $result1 = mysql_query($select);

    while ($row = mysql_fetch_assoc($result1)) {
        $weapon_name = $row['weapon_name'];
        $weapon_field = $row['weapon_field'];
    }
    $weapon_name1 = json_decode($weapon_name, true);
    $weapon_field1 = json_decode($weapon_field, true);

    foreach ($weapon_field1 as $key => $val) {
        foreach ($_REQUEST['weapon_name'] as $k => $v) {
            if ($val[0] == $v) {
                unset($weapon_field1[$key]);
            }
        }
    }

    $update_name = json_encode(array_values(array_diff($weapon_name1, $_REQUEST['weapon_name'])), JSON_FORCE_OBJECT);
    $update_fields = json_encode(array_values($weapon_field1), JSON_FORCE_OBJECT);
    echo $update = "UPDATE " . USER_VARIABLES_TABLE . " SET weapon_name='" . $update_name . "',weapon_field='" . $update_fields . "' WHERE user_id =" . $_REQUEST['user_id'];
    mysql_query($update);
}
if ($_REQUEST['AddNewWaepen'] == 'AddNewWaepen') {
    ?>

    <table>
        <tr>
            <td>Weapon Name</td>
            <td>
                <input type=text name='new_weapen_name' value='' id='new_weapen_name'>
            </td>
        </tr>
        <tr>
            <td>
                <font class='fontface'>Attack</font>
            </td>
            <td>

                <input type="text" name="attack[]" value="" id="attack">
            </td>
        </tr>
        <tr>
            <td>

                <font class='fontface'>Damage<font>
            </td>
            <td>
                <input type="text" name="damage[]" value="" id="damage">
            </td>
        </tr>
        <tr>
            <td>
                <font class='fontface'>Critical Multiplier<font>
            </td>
            <td>

                <select name='critical_multiplier[]'  id='critical_multiplier' >
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                </select>
            </td>
        </tr>
        <tr>
            <td>
                <font class='fontface'>Range</font>
            </td>
            <td>
                <input type="text" name="range[]" value="" id="range">
            </td>
        </tr>
        <tr>
            <td>
                <font class='fontface'>Type</font>
            </td>
            <td>
                <select name='type'  id='type' multiple>
                    <option value="B">B</option>
                    <option value="P">P</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                </select>
            </td>
        </tr>

    </table>
    <input type=button name=addfields value=Add Weapon Fields class='button1' onclick='addnewweaponfields()'>
    <?php
}
if ($_REQUEST['add'] == 'Newweapon') {
    $select = 'SELECT weapon_field , weapon_name FROM ' . USER_VARIABLES_TABLE . ' WHERE user_id =' . $_REQUEST['user_id'];
    $result1 = mysql_query($select);
    while ($row = mysql_fetch_assoc($result1)) {
        $weapon_name = $row['weapon_name'];
        $weapon_field = $row['weapon_field'];
    }
    $name = $_REQUEST['new_weapen_name'];
    $attack = $_REQUEST['attack'];
    $damage = $_REQUEST['damage'];
    $critical_multiplier = $_REQUEST['critical_multiplier'];
    $range = $_REQUEST['range'];
    $type = $_REQUEST['type'];
    //UPDATE NAME
    $weapon_name1 = json_decode($weapon_name, true);
    $weapon_field1 = json_decode($weapon_field, true);
    if ($name != '' and $weapon_name1 != '') {
        if (in_array($name, $weapon_name1)) {
            
        } else {
            $result = json_encode(array_merge($weapon_name1, array($name)), JSON_FORCE_OBJECT);
            $field[] = array($name, array($attack, $damage, $critical_multiplier, $range, $type));
            $merge = array_merge($weapon_field1, $field);
            $result1 = json_encode($merge, JSON_FORCE_OBJECT);
            $update = "UPDATE " . USER_VARIABLES_TABLE . " SET weapon_name='" . $result . "' ,weapon_field='" . $result1 . "' WHERE user_id =" . $_REQUEST['user_id'];
            mysql_query($update);
        }
    } else {
        $result = json_encode(array($name), JSON_FORCE_OBJECT);
        $field[] = array($name, array($attack, $damage, $critical_multiplier, $range, $type));
        $fields = json_encode($field, JSON_FORCE_OBJECT);
        $update = "UPDATE " . USER_VARIABLES_TABLE . " SET weapon_name='" . $result . "' ,weapon_field='" . $fields . "' WHERE user_id =" . $_REQUEST['user_id'];
        mysql_query($update);
    }
}
?> 