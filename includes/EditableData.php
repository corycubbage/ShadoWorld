<?php

?>

<script type="text/javascript">
$(document).ready(function() {    

    $.fn.editable.defaults.mode = 'popup';                     //toggle `popup` / `inline` mode
    $.fn.editable.defaults.url = 'PostEditData.php';           //Default processing file

   $('#enable').click(function() {
       //$('#GroupUserData .editable').editable('toggleDisabled');
       $('#GroupUserData').editable('option', 'disabled', true);
   });  
    
    $('#GroupResistance0').editable();
          
    $('#GroupSpeed0').editable();        
    
    $('#GroupBuffs0').editable();  
    
    $('#GroupDebuffs0').editable();  
   
    $('#GroupCurrentHP0').editable();
    $('#GroupMaXHP0').editable();
    
    var my_javascript_variable = <?php echo $_POST['GROUPCOUNT'] ?>;

    alert(GroupMembers);
    
    //var first = getUrlVars()["SELECTED_ALIAS"];
    //alert(first);
});
</script

