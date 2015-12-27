$(document).ready(function() {    

    var taskAssignedConditionDataArray = [
    {id: 'Bleed', text: 'Bleed'},
    {id: 'Blinded',text: 'Blinded'},
    {id: 'Broken',text: 'Broken'},
    {id: 'Confused',text: 'Confused'},
    {id: 'Cowering',text: 'Cowering'},
    {id: 'Dazed',text: 'Dazed'},
    {id: 'Dazzled',text: 'Dazzled'},
    {id: 'Dead',text: 'Dead'},
    {id: 'Deafened',text: 'Deafened'},
    {id: 'Disabled',text: 'Disabled'},
    {id: 'Dying',text: 'Dying'},
    {id: 'Energy Drained',text: 'Energy Drained'},
    {id: 'Entangled',text: 'Entangled'},
    {id: 'Exhausted',text: 'Exhausted'},
    {id: 'Fascinated',text: 'Fascinated'},
    {id: 'Flat-Footed',text: 'Flat-Footed'},
    {id: 'Frightened',text: 'Frightened'},
    {id: 'Grappled',text: 'Grappled'},
    {id: 'Helpless',text: 'Helpless'},    
    {id: 'Incorporeal',text: 'Incorporeal'},
    {id: 'Invisible',text: 'Invisible'},
    {id: 'Nauseated',text: 'Nauseated'},
    {id: 'Panicked',text: 'Panicked'},       
    {id: 'Paralyzed',text: 'Paralyzed'},
    {id: 'Petrified',text: 'Petrified'},
    {id: 'Pinned',text: 'Pinned'},    
    {id: 'Prone',text: 'Prone'},
    {id: 'Shaken',text: 'Shaken'},
    {id: 'Sickened',text: 'Sickened'},
    {id: 'Sinking',text: 'Sinking'},       
    {id: 'Sickened',text: 'Sickened'},
    {id: 'Stable',text: 'Stable'},       
    {id: 'Staggered',text: 'Staggered'},
    {id: 'Stunned',text: 'Stunned'},       
    {id: 'Unconscious',text: 'Unconscious'}           
];

    //$.fn.editable.defaults.mode = 'popover';
    $.fn.editable.defaults.mode = 'popup';                      //toggle `popup` / `inline` mode
    $.fn.editable.defaults.url = 'PostEditData.php';            //Default processing file
    $.fn.editable.defaults.responseTime = 200;                  //Default processing file

$('.tags').editable({
    placement: 'right',
    source: taskAssignedConditionDataArray,
    name: 'buffs_debuffs', 
    select2: {
        multiple: true,
        width: "200px",
        placeholder: 'Select Condition'
        //separator: ',',
        //url: 'PostEditData.php',            //Default processing file
        //responseTime: 200                  //Default processing file
    },
    display: function(value) {
        var output = [];
        
        if (value == null || value == "") {
            output.push("<span class='ConditionLabelEmpty'><p></p></span>");
            $(this).html(output.join(" "));
        }
        
        if (value!=null && value!="") {
            //alert(value);
            if (!$.isArray(value)) {
                value = value.split(',');
            }

            $.each(value,function(i){
               // value[i] needs to have its HTML stripped, as every time it's read, it contains
               // the HTML markup. If we don't strip it first, markup will recursively be added
               // every time we open the edit widget and submit new values.
               output.push("<span class='ConditionLabel'>" + $('<p>' + value[i] + '</p>').text() + "</span>");
            });

            $(this).html(output.join(" "));
        }
        
    }
});

$('.tag').on('shown', function() {
    console.log('tags shown');
    var editable = $(this).data('editable');
    value = editable.value;
    $.each(value,function(i){
       value[i] = $('<p>jjjjj' + value[i] + '</p>').text();
    });
});

$('[id^="tags-edit-"]').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    $('#' + $(this).data('editable') ).editable('toggle');
});

    $('#GroupUserData').DataTable(); 
     
    var GroupMembers = document.getElementById("GROUPCOUNTVAL").value;
    
    //Make fields editable
    if (GroupMembers>0) {
        for (i = 0; i < GroupMembers; i++) { 
            $('#GroupCurrentHP' + i).editable({
                name: 'selected_current_hit'                
            });
            $('#GroupMaXHP'+ i).editable({
                name: 'selected_maximum_hit'                
            });                  
            $('#GroupNLHP'+ i).editable({
                name: 'seleted_non_lethal'                
            });                              
            $('#GroupHeroPoints' + i).editable({ 
                name: 'hero_point'                  
            });              


         //$('#GroupResistance' + i).editable();
            //$('#GroupImmunity' + i).editable();            
            //$('#GroupInit' + i).editable();  
            //$('#GroupSpeed' + i).editable();       
            //$('#GroupBuffs' + i).editable();  
            
            //$('#GroupAC' + i).editable();       
            //$('#GroupTAC' + i).editable();       
            //$('#GroupFFAC' + i).editable();
            //$('#GroupFORT' + i).editable();       
            //$('#GroupREFLEX' + i).editable();       
            //$('#GroupWILL' + i).editable();       
            //$('#GroupBuffs' + i).editable();       
            //$('#GroupDebuffs' + i).editable({
            //    inputclass: 'input-large',
            //    select2: {
            //    tags: ['html', 'javascript', 'css', 'ajax'],
            //    tokenSeparators: [",", " "]
    //    }
    //});  
    
           //$('#GroupCurrentHP'+i).on('focusout', function(e, params) {                             
            //   ProgresBarName = "#HPProgressBar" + ($(this).attr("idval"));
            //  MaxHPName = "#GroupMaXHP" + ($(this).attr("idval"));
            //   CurrentHP = ($(this).text());
            //   MaxHP = ($(MaxHPName).text());
            //   HPPercentage = ((CurrentHP/MaxHP)*100);         
            //   updateColor(ProgresBarName, HPPercentage, "HP");
            //});
            
           $('#GroupCurrentHP'+i).on('save', function(e, params) {      
               ProgresBarName = "#HPProgressBar" + ($(this).attr("idval"));
               MaxHPName = "#GroupMaXHP" + ($(this).attr("idval"));
               //JGL - need to pull input value on the fly (before validation from DB?) here, else have response do the update.
               CurrentHP = ($(this).text());  // JGL - this value here is pulling old data from page instead of entry from popup

               MaxHP = ($(MaxHPName).text());
               HPPercentage = ((CurrentHP/MaxHP)*100);          
               updateColor(ProgresBarName, HPPercentage, "HP");                    
            });
            
            $('#GroupMaXHP'+i).on('save', function(e, params) {                             
               ProgresBarName = "#HPProgressBar" + ($(this).attr("idval"));
               CurrentHP = "#GroupCurrentHP" + ($(this).attr("idval"));
               MaxHP = ($(this).text());
               HPPercentage = ((CurrentHP/MaxHP)*100);
               updateColor(ProgresBarName, HPPercentage, "HP");
            });
            
            $('#GroupNLHP'+i).on('save', function(e, params) {                             
               ProgresBarName = "#NLProgressBar" + ($(this).attr("idval"));
               MaxHPName = "#GroupMaXHP" + ($(this).attr("idval"));
               CurrentHP = "#GroupCurrentHP" + ($(this).attr("idval"));
               NLHP = ($(this).text());
               updateColor(ProgresBarName, NLHP, "NLHP");
            });
            
        }
    }
    
    // Hide Init, Speed, AC, Saves, Resist, Immunities, UID by default.
        var table = $('#GroupUserData').DataTable();
        var column = table.column(8);
        column.visible( ! column.visible() );
        var column = table.column(7);
        column.visible( ! column.visible() );
        var column = table.column(6);
        column.visible( ! column.visible() );
        var column = table.column(5);
        column.visible( ! column.visible() );
	
    // Show Init, Speed, AC, Saves, Resist, Immunities 
    $('#GroupPartyVitalsHideStaticInfo').click(function () {
        var table = $('#GroupUserData').DataTable();
        var column = table.column(7);
        column.visible( ! column.visible() );
        var column = table.column(6);
        column.visible( ! column.visible() );
        var column = table.column(5);
        column.visible( ! column.visible() );
    });  //GroupPartyVitalsHideStaticInfo.click

    function updateColor(progressBar, value, type){

        //alert ("Value: " + value)
        if (type  === "HP") {
            
            if (value > 100) {$(progressBar).css({'background-color': "#499DD0",
                    'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    '-webkit-background-size': "40px 40px",
                    'background-size': "40px 40px:"})}
            if (value === 100) {$(progressBar).css({'background-color': "#006600",
                    'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    '-webkit-background-size': "40px 40px",
                    'background-size': "40px 40px:"})}
            if ((value > 75 && value < 100)) {$(progressBar).css({'background-color': "#599877",
                                                                  "background-image":"none"})}    
            if ((value > 50 && value <= 75)) {$(progressBar).css({'background-color': "#FA6539",
                                                                 "background-image":"none"})}   
            if ((value > 25 && value <= 50)) {$(progressBar).css({'background-color': "#F6A942",
                                                                 "background-image":"none"})}   
            if ((value > 0 && value <= 25)) {$(progressBar).css({'background-color': "#CF6363",
                                                                "background-image":"none"})}   
            if (value === 0) {$(progressBar).css({'background-color': "#CF6363",
                                                'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}
            
            if (value < 0) {$(progressBar).css({'background-color': "#FF0000",
                                                'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}
      } // end HP
        
        if (type  === "NLHP") {
            
            //alert("Progresbar: " + progressBar + " Value: " + value + " type: " + type);
            
            if (value <= 0) {$(progressBar).css({'background-color': "#e6e6e6",
                                                 "background-image":"none"})}   
            if (value > 0) {$(progressBar).css({'background-color': "#CF6363",
                                                'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}
        }   //end NLHP
        
    }  //end updateColor



});


