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
    {id: 'Grappled',text: 'Grappled', description: 'test description'},
    {id: 'Helpless',text: 'Helpless'},    
    {id: 'Incorporeal',text: 'Incorporeal'},
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
    {id: 'Staggered',text: 'Staggered'},
    {id: 'Stunned',text: 'Stunned'},       
    {id: 'Unconscious',text: 'Unconscious'},           
    
    // Buffs    
    {id: 'Bit of Luck',text: 'Bit of Luck'},
    {id: 'Blessed',text: 'Blessed'},
    {id: 'Guidance',text: 'Guidance'},
    {id: 'Inspire Courage',text: 'Inspire Courage'},
    {id: 'Invisible',text: 'Invisible'},
    {id: 'Raging',text: 'Raging'},
    {id: 'Stable',text: 'Stable'},       
    
];

    $('#GroupUserData').DataTable({
        //"sDom": '<"top"i>rt<"bottom"flp><"clear">' 
        "sDom": '<"#wrapper"rflp>t'        
  } );
     
    var GroupMembers = document.getElementById("GROUPCOUNTVAL").value;

    $.fn.editable.defaults.mode = 'popup';                      
    $.fn.editable.defaults.url = 'PostEditData.php';            
    $.fn.editable.defaults.responseTime = 200;                  

$('.tags').editable({
    placement: 'right',
    source: taskAssignedConditionDataArray,
    name: 'buffs_debuffs', 
    select2: {
        multiple: true,
        width: "200px",
        placeholder: 'Select Condition'
    },
    display: function(value, params) {
        var output = [];
        //console.log(value);
        
        if (value == null || value == "") {
            output.push("<span class='ConditionLabelEmpty'><p></p></span>");
            $(this).html(output.join(" "));
        }
        
        if (value!=null && value!="") {
            var commatestregex = /,/;
            if (commatestregex.test(value)) {
                  //
                } else {
                  //
                }
            
            ConditionDescription='';
            BuffConditionDescription='';
            $.each(value,function(i){  // value[i] needs to have its HTML stripped, as every time it's read, it contains the HTML markup. If we don't strip it first, markup will recursively be added every time we open the edit widget and submit new values.                               
                ConditionDescription = GetConditionDescription(value[i]);
                if (ConditionDescription) {
                    output.push("<span class='ConditionLabel' title='" +  ConditionDescription + "'>" + $('<p>' + value[i] + '</p>').text() + "</span>");
                }
                else {
                     BuffConditionDescription = GetBuffDescription(value[i]);
                    output.push("<span class='BuffConditionLabel' title='" +  BuffConditionDescription + "'>" + $('<p>' + value[i] + '</p>').text() + "</span>");
                }
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
            $('#GroupClassInfo' + i).editable({
                name: 'CLASS_INFO'     
            });          
            
           $('#GroupCurrentHP'+i).on('save', function(e, params) {      
               ProgresBarName = "#HPProgressBar" + ($(this).attr("idval"));
               MaxHPName = "#GroupMaXHP" + ($(this).attr("idval"));
               //alert(JSON.stringify(params, null, 4));
               //CurrentHP = ($(this).text());  // JGL - this value here is pulling old data from page instead of entry from popup
               CurrentHP = params["newValue"];
               MaxHP = ($(MaxHPName).text());
               HPPercentage = ((CurrentHP/MaxHP)*100);          
               updateColor(ProgresBarName, HPPercentage, "HP");                    
            });
            
            $('#GroupMaXHP'+i).on('save', function(e, params) {                             
               ProgresBarName = "#HPProgressBar" + ($(this).attr("idval"));
               CurrentHP = "#GroupCurrentHP" + ($(this).attr("idval"));
               //MaxHP = ($(this).text());
               MaxHP = params["newValue"];
               HPPercentage = ((CurrentHP/MaxHP)*100);
               updateColor(ProgresBarName, HPPercentage, "HP");
            });
            
            $('#GroupNLHP'+i).on('save', function(e, params) {   
                
               ProgresBarName = "#NLProgressBar" + ($(this).attr("idval"));
               MaxHPName = "#GroupMaXHP" + ($(this).attr("idval"));
               CurrentHP = "#GroupCurrentHP" + ($(this).attr("idval"));
               CurrentHPValue = ($(CurrentHP).text());
               //NLHP = ($(this).text());
               NLHP = params["newValue"];
               NLPercentage = ((NLHP/CurrentHPValue)*100);               
               updateColor(ProgresBarName, NLPercentage, "NLHP");
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

    $('#ToggleEdit').click(function () {
        $('#wrapper').toggle();
        $('#wrapper2').toggle();
        //$('#datawrapperbottom').toggle();

        if (GroupMembers>0) {                
        for (i = 0; i < GroupMembers; i++) { 
            $('#GroupMaXHP'+ i).editable('toggleDisabled');
            $('#GroupNLHP'+ i).editable('toggleDisabled');
            $('#GroupHeroPoints' + i).editable('toggleDisabled');
            $('#GroupClassInfo' + i).editable('toggleDisabled');
        }
      }
    });  

    function updateColor(progressBar, value, type){

        //alert ("Value: " + value)
        if (type  === "HP") {
            
            if (value > 100) {$(progressBar).css({
                                                'background': "rgb(30,87,153)", /* Old browsers */
                                                'background': "-moz-linear-gradient(top,  rgba(30,87,153,1) 0%, rgba(41,137,216,1) 50%, rgba(32,124,202,1) 51%, rgba(125,185,232,1) 100%)", /* FF3.6-15 */
                                                'background': "-webkit-linear-gradient(top,  rgba(30,87,153,1) 0%,rgba(41,137,216,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%)", /* Chrome10-25,Safari5.1-6 */
                                                'background': "linear-gradient(to bottom,  rgba(30,87,153,1) 0%,rgba(41,137,216,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%)", /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                                                'filter': "progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 )"})}
            if (value === 100) {$(progressBar).css({
                    //'background-color': "#006600",
                    //'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    //'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    //'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                    //'-webkit-background-size': "40px 40px",
                    //'background-size': "40px 40px:"
                    'background': "rgb(180,221,180", /* Old browsers */
                    'background': "-moz-linear-gradient(top,  rgba(180,221,180,1) 0%, rgba(131,199,131,1) 17%, rgba(82,177,82,1) 33%, rgba(0,138,0,1) 67%, rgba(0,87,0,1) 83%, rgba(0,36,0,1) 100%)", /* FF3.6-15 */
                    'background': "-webkit-linear-gradient(top,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 17%,rgba(82,177,82,1) 33%,rgba(0,138,0,1) 67%,rgba(0,87,0,1) 83%,rgba(0,36,0,1) 100%)", /* Chrome10-25,Safari5.1-6 */
                    'background': "linear-gradient(to bottom,  rgba(180,221,180,1) 0%,rgba(131,199,131,1) 17%,rgba(82,177,82,1) 33%,rgba(0,138,0,1) 67%,rgba(0,87,0,1) 83%,rgba(0,36,0,1) 100%)", /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                    'filter': "progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4ddb4', endColorstr='#002400',GradientType=0 )", /* IE6-9 */  
                    })}
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
                                                 'background-image':"none"})}
                             //$(staggered).css({'display':"none"})
                             //$(unconscious).css({'display':"none"})}  
            if (value > 0 && value < 100) {$(progressBar).css({'background-color': "#ff6500",
                                                'background-image': "-webkit-linear-gradient(35deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(35deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(35deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}

                                           //$(staggered).css({'display':"none"})
                                           //$(unconscious).css({'display':"none"})}   
            if (value === 100) {$(progressBar).css({'background-color': "#CF6363",
                                                'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}
                                //$(staggered).css({'display':"block"})
                                //$(unconscious).css({'display':"none"})}                                         
            if (value > 100) {$(progressBar).css({'background-color': "#CF6363",
                                                'background-image': "-webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "-o-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                'background-image': "linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent)",
                                                '-webkit-background-size': "40px 40px",
                                                'background-size': "40px 40px:"})}
                                //$(staggered).css({'display':"none"})
                                //$(unconscious).css({'display':"block"})}  
        }   //end NLHP
        
    }  //end updateColor

});

function GetConditionDescription(ConditionName){

    if (ConditionName == "Blinded") {return "The creature cannot see. It takes a –2 penalty to Armor Class, loses its Dexterity bonus to AC (if any), and takes a –4 penalty on most Strength- and Dexterity-based skill checks and on opposed Perception skill checks. All checks and activities that rely on vision (such as reading and Perception checks based on sight) automatically fail. All opponents are considered to have total concealment (50% miss chance) against the blinded character. Blind creatures must make a DC 10 Acrobatics skill check to move faster than half speed. Creatures that fail this check fall prone. Characters who remain blinded for a long time grow accustomed to these drawbacks and can overcome some of them.";}
    if (ConditionName == "Bleed") {return "A creature that is taking bleed damage takes the listed amount of damage at the beginning of its turn. Bleeding can be stopped by a DC 15 Heal check or through the application of any spell that cures hit point damage (even if the bleed is ability damage). Some bleed effects cause ability damage or even ability drain. Bleed effects do not stack with each other unless they deal different kinds of damage. When two or more bleed effects deal the same kind of damage, take the worse effect. In this case, ability drain is worse than ability damage.";}
    if (ConditionName == "Broken") {return "Items that have taken damage in excess of half their total hit points gain the broken condition, meaning they are less effective at their designated task. The broken condition has the following effects, depending upon the item.  \n\nIf the item is a weapon, any attacks made with the item suffer a –2 penalty on attack and damage rolls. Such weapons only score a critical hit on a natural 20 and only deal ×2 damage on a confirmed critical hit.  \nIf the item is a suit of armor or a shield, the bonus it grants to AC is halved, rounding down. Broken armor doubles its armor check penalty on skills.  \nIf the item is a tool needed for a skill, any skill check made with the item takes a –2 penalty.  \nIf the item is a wand or staff, it uses up twice as many charges when used.  \nIf the item does not fit into any of these categories, the broken condition has no effect on its use. Items with the broken condition, regardless of type, are worth 75% of their normal value. If the item is magical, it can only be repaired with a mending or make whole spell cast by a character with a caster level equal to or higher than the item's. Items lose the broken condition if the spell restores the object to half its original hit points or higher. Non-magical items can be repaired in a similar fashion, or through the Craft skill used to create it. Generally speaking, this requires a DC 20 Craft check and 1 hour of work per point of damage to be repaired. Most craftsmen charge one-tenth the item's total cost to repair such damage (more if the item is badly damaged or ruined).  \n\nSpecial Note on Ships: Ships, and sometimes their means of propulsion—are objects, and like any other object, when they take damage in excess of half their hit points, they gain the broken condition. When a ship gains the broken condition, it takes a –2 penalty to AC, on sailing checks, saving throws, and on combat maneuver checks. If a ship or its means of propulsion becomes broken, the ship's maximum speed is halved and the ship can no longer gain the upper hand until repaired. If the ship is in motion and traveling faster than its new maximum speed, it automatically decelerates to its new maximum speed (from Advanced Naval Combat.)";}
    if (ConditionName == "Confused") {return "A confused creature is mentally befuddled and cannot act normally. A confused creature cannot tell the difference between ally and foe, treating all creatures as enemies. Allies wishing to cast a beneficial spell that requires a touch on a confused creature must succeed on a melee touch attack. If a confused creature is attacked, it attacks the creature that last attacked it until that creature is dead or out of sight.\n\nRoll on the following table at the beginning of each confused subject's turn each round to see what the subject does in that round.";}
    if (ConditionName == "Cowering") {return "The character is frozen in fear and can take no actions. A cowering character takes a –2 penalty to Armor Class and loses his Dexterity bonus (if any).";}
    if (ConditionName == "Dazed") {return "The creature is unable to act normally. A dazed creature can take no actions, but has no penalty to AC.\n\nA dazed condition typically lasts 1 round.";}
    if (ConditionName == "Dazzled") {return "The creature is unable to see well because of over-stimulation of the eyes. A dazzled creature takes a –1 penalty on attack rolls and sight-based Perception checks.";}
    if (ConditionName == "Dead") {return "The character's hit points are reduced to a negative amount equal to his Constitution score, his Constitution drops to 0, or he is killed outright by a spell or effect. The character's soul leaves his body. Dead characters cannot benefit from normal or magical healing, but they can be restored to life via magic. A dead body decays normally unless magically preserved, but magic that restores a dead character to life also restores the body either to full health or to its condition at the time of death (depending on the spell or device). Either way, resurrected characters need not worry about rigor mortis, decomposition, and other conditions that affect dead bodies.";}
    if (ConditionName == "Deafened") {return "A deafened character cannot hear. He takes a –4 penalty on initiative checks, automatically fails Perception checks based on sound, takes a –4 penalty on opposed Perception checks, and has a 20% chance of spell failure when casting spells with verbal components. Characters who remain deafened for a long time grow accustomed to these drawbacks and can overcome some of them.";}
    if (ConditionName == "Disabled") {return "A character with 0 hit points, or one who has negative hit points but has become stable and conscious, is disabled. A disabled character may take a single move action or standard action each round (but not both, nor can he take full-round actions, but he can still take swift, immediate, and free actions). He moves at half speed. Taking move actions doesn't risk further injury, but performing any standard action (or any other action the GM deems strenuous, including some free actions such as casting a Quicken Spell spell) deals 1 point of damage after the completion of the act. Unless the action increased the disabled character's hit points, he is now in negative hit points and dying.\n\nA disabled character with negative hit points recovers hit points naturally if he is being helped. Otherwise, each day he can attempt a DC 10 Constitution check after resting for 8 hours, to begin recovering hit points naturally. The character takes a penalty on this roll equal to his negative hit point total. Failing this check causes the character to lose 1 hit point, but this does not cause the character to become unconscious. Once a character makes this check, he continues to heal naturally and is no longer in danger of losing hit points naturally.";}
    if (ConditionName == "Dying") {return "A dying creature is unconscious and near death. Creatures that have negative hit points and have not stabilized are dying. A dying creature can take no actions. On the character's next turn, after being reduced to negative hit points (but not dead), and on all subsequent turns, the character must make a DC 10 Constitution check to become stable. The character takes a penalty on this roll equal to his negative hit point total. A character that is stable does not need to make this check. A natural 20 on this check is an automatic success. If the character fails this check, he loses 1 hit point. If a dying creature has an amount of negative hit points equal to its Constitution score, it dies.";}
    if (ConditionName == "Energy Drained") {return "The character gains one or more negative levels, which might become permanent. If the subject has at least as many negative levels as Hit Dice, he dies. See Energy Drain and Negative Levels and FAQ at right for additional information.";}
    if (ConditionName == "Entangled") {return "The character is ensnared. Being entangled impedes movement, but does not entirely prevent it unless the bonds are anchored to an immobile object or tethered by an opposing force. An entangled creature moves at half speed, cannot run or charge, and takes a –2 penalty on all attack rolls and a –4 penalty to Dexterity. An entangled character who attempts to cast a spell must make a concentration check (DC 15 + spell level) or lose the spell.";}
    if (ConditionName == "Exhausted") {return "An exhausted character moves at half speed, cannot run or charge, and takes a –6 penalty to Strength and Dexterity. After 1 hour of complete rest, an exhausted character becomes fatigued. A fatigued character becomes exhausted by doing something else that would normally cause fatigue.";}
    if (ConditionName == "Fascinated") {return "A fascinated creature is entranced by a supernatural or spell effect. The creature stands or sits quietly, taking no actions other than to pay attention to the fascinating effect, for as long as the effect lasts. It takes a –4 penalty on skill checks made as reactions, such as Perception checks. Any potential threat, such as a hostile creature approaching, allows the fascinated creature a new saving throw against the fascinating effect. Any obvious threat, such as someone drawing a weapon, casting a spell, or aiming a ranged weapon at the fascinated creature, automatically breaks the effect. A fascinated creature's ally may shake it free of the spell as a standard action.";}
    if (ConditionName == "Flat-Footed") {return "A character who has not yet acted during a combat is flat-footed, unable to react normally to the situation. A flat-footed character loses his Dexterity bonus to AC and Combat Maneuver Defense (CMD) (if any) and cannot make attacks of opportunity, unless he has the Combat Reflexes feat or Uncanny Dodge class ability.\n\nCharacters with Uncanny Dodge retain their Dexterity bonus to their AC and can make attacks of opportunity before they have acted in the first round of combat.";}
    if (ConditionName == "Frightened") {return "A frightened creature flees from the source of its fear as best it can. If unable to flee, it may fight. A frightened creature takes a –2 penalty on all attack rolls, saving throws, skill checks, and ability checks. A frightened creature can use special abilities, including spells, to flee; indeed, the creature must use such means if they are the only way to escape.\n\nFrightened is like shaken, except that the creature must flee if possible. Panicked is a more extreme state of fear.";}
    if (ConditionName == "Grappled") {return "A grappled creature is restrained by a creature, trap, or effect. Grappled creatures cannot move and take a –4 penalty to Dexterity. A grappled creature takes a –2 penalty on all attack rolls and combat maneuver checks, except those made to grapple or escape a grapple. In addition, grappled creatures can take no action that requires two hands to perform. A grappled character who attempts to cast a spell or use a spell-like ability must make a concentration check (DC 10 + grappler's CMB + spell level), or lose the spell. Grappled creatures cannot make attacks of opportunity.";}
    if (ConditionName == "Helpless") {return "A helpless character is paralyzed, held, bound, sleeping, unconscious, or otherwise completely at an opponent's mercy. A helpless target is treated as having a Dexterity of 0 (–5 modifier). Melee attacks against a helpless target get a +4 bonus (equivalent to attacking a prone target). Ranged attacks get no special bonus against helpless targets. Rogues can sneak attack helpless targets.\n\nAs a full-round action, an enemy can use a melee weapon to deliver a coup de grace to a helpless foe. An enemy can also use a bow or crossbow, provided he is adjacent to the target. The attacker automatically hits and scores a critical hit. (A rogue also gets his sneak attack damage bonus against a helpless foe when delivering a coup de grace.) If the defender survives, he must make a Fortitude save (DC 10 + damage dealt) or die. Delivering a coup de grace provokes attacks of opportunity.\n\nCreatures that are immune to critical hits do not take critical damage, nor do they need to make Fortitude saves to avoid being killed by a coup de grace.";}
    if (ConditionName == "Incorporeal") {return "Creatures with the incorporeal condition do not have a physical body. Incorporeal creatures are immune to all nonmagical attack forms. Incorporeal creatures take half damage (50%) from magic weapons, spells, spell-like effects, and supernatural effects. Incorporeal creatures take full damage from other incorporeal creatures and effects, as well as all force effects. See here for additional information.";}    
    if (ConditionName == "Nauseated") {return "Creatures with the nauseated condition experience stomach distress. Nauseated creatures are unable to attack, cast spells, concentrate on spells, or do anything else requiring attention. The only action such a character can take is a single move action per turn.";}
    if (ConditionName == "Panicked") {return "A panicked creature must drop anything it holds and flee at top speed from the source of its fear, as well as any other dangers it encounters, along a random path. It can't take any other actions. In addition, the creature takes a –2 penalty on all saving throws, skill checks, and ability checks. If cornered, a panicked creature cowers and does not attack, typically using the total defense action in combat. A panicked creature can use special abilities, including spells, to flee; indeed, the creature must use such means if they are the only way to escape.\n\nPanicked is a more extreme state of fear than shaken or frightened.";}
    if (ConditionName == "Paralyzed") {return "A paralyzed character is frozen in place and unable to move or act. A paralyzed character has effective Dexterity and Strength scores of 0 and is helpless, but can take purely mental actions. A winged creature flying in the air at the time that it becomes paralyzed cannot flap its wings and falls. A paralyzed swimmer can't swim and may drown. A creature can move through a space occupied by a paralyzed creature—ally or not. Each square occupied by a paralyzed creature, however, counts as 2 squares to move through.";}
    if (ConditionName == "Petrified") {return "A petrified character has been turned to stone and is considered unconscious. If a petrified character cracks or breaks, but the broken pieces are joined with the body as he returns to flesh, he is unharmed. If the character's petrified body is incomplete when it returns to flesh, the body is likewise incomplete and there is some amount of permanent hit point loss and/or debilitation.";}
    if (ConditionName == "Pinned") {return "A pinned creature is tightly bound and can take few actions. A pinned creature cannot move and is denied its Dexterity bonus. A pinned character also takes an additional –4 penalty to his Armor Class. A pinned creature is limited in the actions that it can take. A pinned creature can always attempt to free itself, usually through a combat maneuver check or Escape Artist check. A pinned creature can take verbal and mental actions, but cannot cast any spells that require a somatic or material component. A pinned character who attempts to cast a spell or use a spell-like ability must make a concentration check (DC 10 + grappler's CMB + spell level) or lose the spell. Pinned is a more severe version of grappled, and their effects do not stack.\n\nCasting Spells while Pinned: The only spells which can be cast while grappling or pinned are those without somatic components and whose material components (if any) you have in hand. Even so, you must make a concentration check (DC 10 + the grappler's CMB + the level of the spell you're casting) or lose the spell.";}
    if (ConditionName == "Prone") {return "The character is lying on the ground. A prone attacker has a –4 penalty on melee attack rolls and cannot use a ranged weapon (except for a crossbow). A prone defender gains a +4 bonus to Armor Class against ranged attacks, but takes a –4 penalty to AC against melee attacks.\n\nStanding up is a move-equivalent action that provokes an attack of opportunity.";}
    if (ConditionName == "Shaken") {return "A shaken character takes a –2 penalty on attack rolls, saving throws, skill checks, and ability checks. Shaken is a less severe state of fear than frightened or panicked.";}
    if (ConditionName == "Sickened") {return "The character takes a –2 penalty on all attack rolls, weapon damage rolls, saving throws, skill checks, and ability checks.";}
    if (ConditionName == "Sinking") {return "A ship that is reduced to 0 or fewer hit points gains the sinking condition. A sinking ship cannot move or attack, and it sinks completely 10 rounds after it gains the sinking condition. Each additional hit on a sinking ship that deals more than 25 points of damage reduces the remaining time for it to sink by 1 round. A ship that sinks completely drops to the bottom of the body of water and is considered destroyed. A destroyed ship cannot be repaired—it is so significantly damaged it cannot even be used for scrap material. Magic (such as make whole) can repair a sinking ship if the ship's hit points are raised above 0, at which point the ship loses the sinking condition. Generally, non-magical repairs take too long to save a ship from sinking once it begins to go down.";}
    if (ConditionName == "Staggered") {return "A staggered creature may take a single move action or standard action each round (but not both, nor can he take full-round actions). A staggered creature can still take free, swift, and immediate actions. A creature with nonlethal damage exactly equal to its current hit points gains the staggered condition.";}
    if (ConditionName == "Stunned") {return "A stunned creature drops everything held, can't take actions, takes a –2 penalty to AC, and loses its Dexterity bonus to AC (if any).\n\nAttackers receive a +4 bonus on attack rolls to perform combat maneuvers against a stunned opponent.";}
    if (ConditionName == "Unconscious") {return "Unconscious creatures are knocked out and helpless. Unconsciousness can result from having negative hit points (but not more than the creature's Constitution score), or from nonlethal damage in excess of current hit points.";}

}

function GetBuffDescription(BuffName){

if (BuffName == "Bit of Luck") {return "You can touch a willing creature as a standard action, giving it a bit of luck. For the next round, any time the target rolls a d20, he may roll twice and take the more favorable result. You can use this ability a number of times per day equal to 3 + your Wisdom modifier.";}
if (BuffName == "Blessed") {return "Bless fills your allies with courage. Each ally gains a +1 morale bonus on attack rolls and on saving throws against fear effects.\n\nBless counters and dispels bane.";}
if (BuffName == "Guidance") {return "This spell imbues the subject with a touch of divine guidance.\n\nThe creature gets a +1 competence bonus on a single attack roll, saving throw, or skill check. It must choose to use the bonus before making the roll to which it applies.";}
if (BuffName == "Inspire Courage") {return "Inspire Courage (Su): A 1st level bard can use his performance to inspire courage in his allies (including himself), bolstering them against fear and improving their combat abilities. To be affected, an ally must be able to perceive the bard’s performance. An affected ally receives a +1 morale bonus on saving throws against charm and fear effects and a +1 competence bonus on attack and weapon damage rolls. At 5th level, and every six bard levels thereafter, this bonus increases by +1, to a maximum of +4 at 17th level. Inspire courage is a mind-affecting ability. inspire courage can use audible or visual components. The bard must choose which component to use when starting his performance.";}
if (BuffName == "Invisible") {return "Invisible creatures are visually undetectable. An invisible creature gains a +2 bonus on attack rolls against sighted opponents, and ignores its opponents' Dexterity bonuses to AC (if any). See the invisibility special ability.";}
if (BuffName == "Raging") {return "A barbarian can call upon inner reserves of strength and ferocity, granting her additional combat prowess. Starting at 1st level, a barbarian can rage for a number of rounds per day equal to 4 + her Constitution modifier. At each level after 1st, she can rage for 2 additional rounds. Temporary increases to Constitution, such as those gained from rage and spells like bear's endurance, do not increase the total number of rounds that a barbarian can rage per day. A barbarian can enter rage as a free action. The total number of rounds of rage per day is renewed after resting for 8 hours, although these hours do not need to be consecutive.\n\nWhile in rage, a barbarian gains a +4 morale bonus to her Strength and Constitution, as well as a +2 morale bonus on Will saves. In addition, she takes a –2 penalty to Armor Class. The increase to Constitution grants the barbarian 2 hit points per Hit Dice, but these disappear when the rage ends and are not lost first like temporary hit points. While in rage, a barbarian cannot use any Charisma-, Dexterity-, or Intelligence-based skills (except Acrobatics, Fly, Intimidate, and Ride) or any ability that requires patience or concentration.\n\nA barbarian can end her rage as a free action and is fatigued after rage for a number of rounds equal to 2 times the number of rounds spent in the rage. A barbarian cannot enter a new rage while fatigued or exhausted but can otherwise enter rage multiple times during a single encounter or combat. If a barbarian falls unconscious, her rage immediately ends, placing her in peril of death.";}
if (BuffName == "Stable") {return "A character who was dying but who has stopped losing hit points each round and still has negative hit points is stable. The character is no longer dying, but is still unconscious. If the character has become stable because of aid from another character (such as a Heal check or magical healing), then the character no longer loses hit points. The character can make a DC 10 Constitution check each hour to become conscious and disabled (even though his hit points are still negative). The character takes a penalty on this roll equal to his negative hit point total.\n\nIf a character has become stable on his own and hasn't had help, he is still at risk of losing hit points. Each hour he can make a Constitution check to become stable (as a character that has received aid), but each failed check causes him to lose 1 hit point.";}
}

