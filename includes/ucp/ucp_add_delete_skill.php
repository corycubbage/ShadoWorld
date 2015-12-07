
<?php

include('../../config.php');
$con = mysql_connect($dbhost, $dbuser, $dbpasswd, $dbname);
mysql_select_db($dbname);
//define('POSTS_TABLE',$table_prefix . 'posts');
define('USER_VARIABLES_TABLE', $table_prefix . 'user_variable');
if (@$_REQUEST['seleted'] != "" && @$_REQUEST['seleted'] && @$_REQUEST['addtext']) 
{
	$rq = '';
	$seleted = '';
    $rq = $_REQUEST['seleted'];
    $seleted = explode(",", $rq);

    echo '<div style="margin-left:3px;" id="div_skill_value"><br>';
    echo '<table id="tableid">';
    for ($i = 0; $i < count($seleted); $i++) {
        // only the four custom skills should have type field (Craft, KNowledge, Perform, Profession)
        $skill = '';
        $skill1 = '';
        $skill = explode("[", $seleted[$i]);
        $skill1 = explode("(", $skill[0]);
        echo '<tr>';
        echo '<td id="skill_name">';
        if ($skill1[0]) {
            echo $skill1[0];
        } elseif ($skill[0]) {
            echo $skill[0];
        }
        echo '</td>';

        if ($skill[0] == 'Craft' or $skill[0] == 'Knowledge' or $skill[0] == 'Perform' or $skill[0] == 'Profession' or $skill1[0] == 'Craft' or $skill1[0] == 'Knowledge' or $skill1[0] == 'Perform' or $skill1[0] == 'Profession') {
            echo '<td>';
            echo "&nbsp;&nbsp;&nbsp;Type :<input type='text' name='type[]' value='' id='" . $seleted[$i] . "' class='type_id'><br>";
            echo '</td>';

            echo '</tr>';
            echo '<tr>';
            echo '<td>';
            echo '</td>';
        }

        echo '<td>';
        echo "&nbsp;&nbsp;&nbsp;Value:<input type='text' name='value[]' value='' id='" . $seleted[$i] . "' class='text_class'><input type='hidden' name='hidden_text' value='".$seleted[$i]."' id='hidden_text'><br>";
        echo '</td>';
        echo '<td>';
        if ($skill1[0]) {
            echo "&nbsp;&nbsp;&nbsp;<input type='button' name='" . $seleted[$i] . "' value='Add additional " . $skill1[0] . " skills' id='addmore' class='button1' onclick='addcusotmeskill1(this);' count='0'><br>";
        } elseif ($skill[0]) {
            echo "&nbsp;&nbsp;&nbsp;<input type='button' name='" . $seleted[$i] . "' value='Add additional " . $skill[0] . " skills' id='addmore' class='button1'  onclick='addcusotmeskill1(this);' count='0'><br>";
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type="button" name="custome_skill" value="Add Custom Skill" id="custome_skill" class="button1" >';
    echo '</div>';
}
if (@$_REQUEST['seleted'] != "" && @$_REQUEST['seleted'] && @$_REQUEST['Edittext']) {

	$rq ='';
	$seleted ='';
    $rq = $_REQUEST['seleted'];
    //echo "<pre>";print_r($rq);
    $seleted = explode(",",$rq);
	//echo "<pre>";print_r($seleted);echo "</pre>";
    echo '<div style="margin-left:3px;" id="div_skill_value"><br>';
    echo '<table id="tableid">';
    for ($i = 0; $i < count($seleted); $i++) {
        // only the four custom skills should have type field (Craft, KNowledge, Perform, Profession)
        $skill ='';
        $skill1 = '';
        $skill = explode("[", $seleted[$i]);
        $skill1 = explode("(", $skill[0]);
        echo '<tr>';
        echo '<td id="skill_name">';
        if ($skill1[0]) {
            echo $skill1[0];
        } elseif ($skill[0]) {
            echo $skill[0];
        }
        echo '</td>';

        if ($skill[0] == 'Craft' or $skill[0] == 'Knowledge' or $skill[0] == 'Perform' or $skill[0] == 'Profession' or $skill1[0] == 'Craft' or $skill1[0] == 'Knowledge' or $skill1[0] == 'Perform' or $skill1[0] == 'Profession') 
        {
            echo '<td>';
            echo "&nbsp;&nbsp;&nbsp;Type :<input type='text' name='type[]' value='' id='" . $seleted[$i] . "' class='type_id'><br>";
            echo '</td>';

            echo '</tr>';
            echo '<tr>';
            echo '<td>';
            echo '</td>';
        }

        echo '<td>';
        echo "&nbsp;&nbsp;&nbsp;Value:<input type='text' name='value[]' value='' id='" . $seleted[$i] . "' class='text_class'><input type='hidden' name='hidden_text' value='".$seleted[$i]."' id='hidden_text'><br>";
        echo '</td>';
        echo '<td>';
        /*if ($skill1[0]) {
            echo "&nbsp;&nbsp;&nbsp;<input type='button' name='" . $seleted[$i] . "' value='Add additional " . $skill1[0] . " skills' id='addmore' class='button1' onclick='addcusotmeskill1(this);' count='0'><br>";
        } elseif ($skill[0]) {
            echo "&nbsp;&nbsp;&nbsp;<input type='button' name='" . $seleted[$i] . "' value='Add additional " . $skill[0] . " skills' id='addmore' class='button1'  onclick='addcusotmeskill1(this);' count='0'><br>";
        }*/
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '<input type="button" name="custome_skill" value="Update Skill Value" id="custome_skill" onclick="addcusotmeskill();"  class="button1" >';
    echo '</div>';
}
if (@!empty($_REQUEST['Delete']) and ( @!empty($_REQUEST['user_id']))) {

	$select_level ='';
	$result1 ='';
	$quick_skill ='';
	$quick_skill1 ='';
	$deleteval = $_REQUEST['Delete'];
    $select_level = "SELECT * from " . USER_VARIABLES_TABLE . " WHERE user_id =" . $_REQUEST['user_id'];
    $result1 = mysql_query($select_level);
    $levels = array();

    while ($row = mysql_fetch_assoc($result1)) 
    {
        $quick_skill = $row['quick_skill'];
    }
    $gear1 = array();
    $quick_skill1 = json_decode($quick_skill, true);

    $quick_skill_result = array();
    $update='';
    $quick_skill_result = array_values(array_diff($quick_skill1, $exp));
    $update = "UPDATE " . USER_VARIABLES_TABLE . " SET quick_skill = '" . json_encode($quick_skill_result, JSON_FORCE_OBJECT) . "' WHERE user_id =" . $_REQUEST['user_id'];
    mysql_query($update);
}
?>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
var skill       = Array();
var skill_name  = Array();
var skill_array = Array();
var mySkill     = Array();
var mainArray   = Array();
$(document).ready(function(){
	$(".text_class").focus();
	$(".text_class").keypress(function(event){
		if(event.which == 13){
			$("#tableid tbody tr").each(function(index,element){
				skill_name.push($(element).find('#skill_name').html());			
				skill.push($(element).find('input.text_class').val());			
			});	
			for(var key in skill)
			{
				if(skill[key])
				{
					skill_array.push(skill[key]);
				}
			}		
			for(var i=0;i<skill_name.length;i++)
			{
				mySkill[skill_name[i]] = skill_array[i];
			}
			for(var key in mySkill)
			{
				mainArray.push(key+'['+mySkill[key]+']');
			}
			//var text_string = mainArray.join('%');
			var user_id = $("#post_as").val();
			console.log(user_id);
			$.ajax({
				url:"./ajax_skill.php?selected="+mainArray+"&user_id=<?php echo $_REQUEST['phpbb3_qpjb1_u']; ?>",
				dataType:"json"
			}).success(function(data){
				console.log(data);
			});
			console.log("You Pressed Enter");
			setTimeout('refresh()',3000)
		}
		
		function refresh(){
			return true;
		}
	});
	$(".button1").click(function()
	{		
		$("#tableid tbody tr").each(function(index,element){
			skill_name.push($(element).find('#skill_name').html());			
			skill.push($(element).find('input.text_class').val());			
		});	
		
		for(var key in skill)
		{
			if(skill[key])
			{
				skill_array.push(skill[key]);				
			}
		}
		if(skill_array.length > 0)
		{
			for(var i=0;i<skill_name.length;i++)
			{
				if(skill_array[i] == undefined)
				{}
				else
				{mySkill[skill_name[i]] = skill_array[i];}
			}	
			console.log("myskill :"+mySkill);	
			for(var key in mySkill)
			{mainArray.push(key+'['+mySkill[key]+']');}
			//var text_string = mainArray.join('%');
			var user_id = $("#post_as").val();
			$.ajax({
				url:"./ajax_skill.php?selected="+mainArray+"&user_id="+user_id,
				dataType:"json"
			}).success(function(data){
				console.log(data);
			});
		}
	});
});
</script>