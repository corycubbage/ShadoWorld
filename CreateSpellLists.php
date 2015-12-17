<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    
    if ($spell_type == "Bard") {                            
            
        if($level == 0){
            $spells_array[] = "Dancing Lights";    
            $spells_array[] = "Daze";    
            $spells_array[] = "Detect Magic";
            $spells_array[] = "Flare";
            $spells_array[] = "Ghost Sound";
            $spells_array[] = "Know Direction";
            $spells_array[] = "Light";
            $spells_array[] = "Lullaby";
            $spells_array[] = "Mage Hand";
            $spells_array[] = "Mending";
            $spells_array[] = "Message";
            $spells_array[] = "Open/Close";
            $spells_array[] = "Prestidigitation";
            $spells_array[] = "Read Magic";
            $spells_array[] = "Summon Instrument";                
        }               //CVC - 12/05/15  - Complete
        if($level == 1){
            $spells_array[] = "Alarm";
            $spells_array[] = "Animate Rope";    
            $spells_array[] = "Cause Fear";
            $spells_array[] = "Charm Person";
            $spells_array[] = "Comprehend Languages";
            $spells_array[] = "Confusion, Lesser";
            $spells_array[] = "Cure Light Wounds";
            $spells_array[] = "Detect Secret Doors";
            $spells_array[] = "Disguise Self";
            $spells_array[] = "Erase";
            $spells_array[] = "Expeditious Retreat";
            $spells_array[] = "Feather Fall";
            $spells_array[] = "Grease";
            $spells_array[] = "Hideous Laughter";
            $spells_array[] = "Hypnotism";
            $spells_array[] = "Identify";
            $spells_array[] = "Magic Aura";
            $spells_array[] = "Magic Mouth";
            $spells_array[] = "Obscure Object";
            $spells_array[] = "Remove Fear";
            $spells_array[] = "Silent Image";
            $spells_array[] = "Sleep";
            $spells_array[] = "Summon Monster I";
            $spells_array[] = "Undetectable Alignment";
            $spells_array[] = "Unseen Servant";
            $spells_array[] = "Ventriloquism";     
        }               //CVC - 12/05/15  - Complete
        if($level == 2){
            $spells_array[] = "Alter Self";
            $spells_array[] = "Animal Messenger";
            $spells_array[] = "Animal Trance";
            $spells_array[] = "Blindness/Deafness";
            $spells_array[] = "Blur";
            $spells_array[] = "Calm Emotions";
            $spells_array[] = "Cats Grace";
            $spells_array[] = "Cure Moderate Wounds";
            $spells_array[] = "Darkness";
            $spells_array[] = "Daze Monster";
            $spells_array[] = "Delay Poison";
            $spells_array[] = "Detect Thoughts";
            $spells_array[] = "Eagles Splendor";
            $spells_array[] = "Enthrall";
            $spells_array[] = "Foxs Cunning";
            $spells_array[] = "Glitterdust";
            $spells_array[] = "Heroism";
            $spells_array[] = "Hold Person";
            $spells_array[] = "Hypnotic Pattern";
            $spells_array[] = "Invisibility";
            $spells_array[] = "Locate Object";
            $spells_array[] = "Minor Image";
            $spells_array[] = "Mirror Image";
            $spells_array[] = "Misdirection";
            $spells_array[] = "Pyrotechnics";
            $spells_array[] = "Rage";
            $spells_array[] = "Scare";
            $spells_array[] = "Shatter";
            $spells_array[] = "Silence";
            $spells_array[] = "Sound Burst";
            $spells_array[] = "Suggestion";
            $spells_array[] = "Summon Monster II";
            $spells_array[] = "Summon Swarm";
            $spells_array[] = "Tongues";
            $spells_array[] = "Whispering Wind";
           }               //CVC - 12/05/15  - Complete
      
            } // End BARD
    if ($spell_type == "Cleric") {                          
        
        if($level == 0){
                $spells_array[] = "Bleed";
                $spells_array[] = "Create Water";
                $spells_array[] = "Detect Magic";
                $spells_array[] = "Detect Poison";
                $spells_array[] = "Guidance";
                $spells_array[] = "Light";
                $spells_array[] = "Mending";
                $spells_array[] = "Purify Food and Drink";
                $spells_array[] = "Read Magic";
                $spells_array[] = "Resistance";
                $spells_array[] = "Stabilize";
                $spells_array[] = "Virtue";
                $spells_array[] = "Light";                
        }               //CVC - 12/05/15  - Complete
        if($level == 1){
		$spells_array[] = 'Bane';
                $spells_array[] = 'Bless';
                $spells_array[] = 'Bless Water';
                $spells_array[] = 'Cause Fear';
                $spells_array[] = 'Command';
                $spells_array[] = 'Comprehend Languages';
                $spells_array[] = 'Cure Light Wounds';
                $spells_array[] = 'Curse Water';
                $spells_array[] = 'Deathwatch';
                $spells_array[] = 'Detect Chaos/Evil/Good/Law';
                $spells_array[] = 'Detect Undead';
                $spells_array[] = 'Divine Favor';
                $spells_array[] = 'Doom';
                $spells_array[] = 'Endure Elements';
                $spells_array[] = 'Entropic Shield';
                $spells_array[] = 'Hide from Undead';
                $spells_array[] = 'Inflict Light Wounds';
                $spells_array[] = 'Magic Stone';
                $spells_array[] = 'Obscuring Mist';
                $spells_array[] = 'Protection from Chaos';
                $spells_array[] = 'Protection from Evil';
                $spells_array[] = 'Protection from Good';
                $spells_array[] = 'Protection from Law';
                $spells_array[] = 'Remove Fear';
                $spells_array[] = 'Sanctuary';
                $spells_array[] = 'Shield of Faith';
                $spells_array[] = 'Summon Monster I';
	}               //CVC - 12/05/15  - Complete
	if($level == 2){
		$spells_array[] = 'Aid';
                $spells_array[] = 'Align Weapon';
                $spells_array[] = 'Augury';
                $spells_array[] = 'Bears Endurance';
                $spells_array[] = 'Bulls Strength';
                $spells_array[] = 'Calm Emotions';
                $spells_array[] = 'Consecrate';
                $spells_array[] = 'Cure Moderate Wounds';
                $spells_array[] = 'Darkness';
                $spells_array[] = 'Death Knell';
                $spells_array[] = 'Delay Poison';
                $spells_array[] = 'Desecrate';
                $spells_array[] = 'Eagles Splendor';
                $spells_array[] = 'Enthrall';
                $spells_array[] = 'Find Traps';
		$spells_array[] = 'Gentle Repose';
                $spells_array[] = 'Hold Person';
                $spells_array[] = 'Inflict Moderate Wounds';
                $spells_array[] = 'Make Whole';
                $spells_array[] = 'Owls Wisdom';
                $spells_array[] = 'Remove Paralysis';
                $spells_array[] = 'Resist Energy';
                $spells_array[] = 'Restoration, Lesser';
                $spells_array[] = 'Shatter';
                $spells_array[] = 'Shield Other';
                $spells_array[] = 'Silence';
                $spells_array[] = 'Sound Burst';
                $spells_array[] = 'Spiritual Weapon';
                $spells_array[] = 'Status';
                $spells_array[] = 'Summon Monster II';
		$spells_array[] = 'Undetectable Alignment';
                $spells_array[] = 'Zone of Truth';
	}               //CVC - 12/05/15  - Complete
	if($level == 3){
		$spells_array[] = 'NA';
	}
	if($level == 4){
		$spells_array[] = 'NA';
	}
	if($level == 5){
		$spells_array[] = 'NA';
	}
	if($level == 6){
		$spells_array[] = 'NA';
	}
	if($level == 7){
		$spells_array[] = 'NA';
	}
	if($level == 8){
		$spells_array[] = 'NA';
	}
	if($level == 9){
		$spells_array[] = 'NA';
	}
    }
    if ($spell_type == "Druid") {                 
        if($level == 0){
                $spells_array[] = "Create Water";
                $spells_array[] = "Detect Magic";
                $spells_array[] = "Detect Poison";
                $spells_array[] = "Flare";
                $spells_array[] = "Guidance";
                $spells_array[] = "Know Direction";
                $spells_array[] = "Light";
                $spells_array[] = "Mending";
                $spells_array[] = "Purify Food and Drink";
                $spells_array[] = "Read Magic";
                $spells_array[] = "Resistance";
                $spells_array[] = "Stabilize";
                $spells_array[] = "Light";                
        }               //CVC - 12/05/15  - Complete
        if($level == 1){
		$spells_array[] = 'NA';
	}                
	if($level == 2){
		$spells_array[] = 'NA';

	}
	if($level == 3){
		$spells_array[] = 'NA';
	}
	if($level == 4){
		$spells_array[] = 'NA';
	}
	if($level == 5){
		$spells_array[] = 'NA';
	}
	if($level == 6){
		$spells_array[] = 'NA';
	}
	if($level == 7){
		$spells_array[] = 'NA';
	}
	if($level == 8){
		$spells_array[] = 'NA';
	}
	if($level == 9){
		$spells_array[] = 'NA';
	}
       
            }
    if ($spell_type == "Wizard") {        
        
        if($level == 0){
                $spells_array[] = "Acid Splash";
                $spells_array[] = "Arcane Mark";       
                $spells_array[] = "Bleed";
                $spells_array[] = "Dancing Lights";
                $spells_array[] = "Daze";
                $spells_array[] = "Detect Magic";
                $spells_array[] = "Detect Poison";
                $spells_array[] = "Disrupt Undead";       
                $spells_array[] = "Flare";
                $spells_array[] = "Guidance";                
                $spells_array[] = "Light";
                $spells_array[] = "Read Magic";
                $spells_array[] = "Resistance";
                $spells_array[] = "Ray of Frost";
                $spells_array[] = "Ghost Sound";                
                $spells_array[] = "Prestidigitation";       
                $spells_array[] = "Open/Close";       
                $spells_array[] = "Message";       
                $spells_array[] = "Mage Hand:";       
                $spells_array[] = "Touch of Fatigue";       
                
        }               //CVC - 12/05/15  - Complete                    
        if($level == 1){
		$spells_array[] = 'Alarm';
                $spells_array[] = 'Animate Rope';
                $spells_array[] = 'Burning Hands';
                $spells_array[] = 'Cause Fear';
                $spells_array[] = 'Charm Person';
                $spells_array[] = 'Chill Touch';
                $spells_array[] = 'Color Spray';
                $spells_array[] = 'Comprehend Languages';
                $spells_array[] = 'Detect Secret Doors';
                $spells_array[] = 'Detect Undead';
                $spells_array[] = 'Disguise Self';
                $spells_array[] = 'Endure Elements';
                $spells_array[] = 'Enlarge Person';
                $spells_array[] = 'Erase';
                $spells_array[] = 'Expeditious Retreat';
                $spells_array[] = 'Feather Fall';
                $spells_array[] = 'Floating Disk';
                $spells_array[] = 'Grease';
                $spells_array[] = 'Hold Portal';
                $spells_array[] = 'Hypnotism';
                $spells_array[] = 'Identify';
                $spells_array[] = 'Jump';
                $spells_array[] = 'Mage Armor';
                $spells_array[] = 'Magic Aura';
                $spells_array[] = 'Magic Missile';
                $spells_array[] = 'Magic Weapon';
                $spells_array[] = 'Mount';
                $spells_array[] = 'Obscuring Mist';
                $spells_array[] = 'Protection from Chaos';
                $spells_array[] = 'Protection from Evil';
                $spells_array[] = 'Protection from Good';
                $spells_array[] = 'Protection from Law';
                $spells_array[] = 'Ray of Enfeeblement';
                $spells_array[] = 'Reduce Person';
                $spells_array[] = 'Shield';
                $spells_array[] = 'Shocking Grasp';
                $spells_array[] = 'Silent Image';
                $spells_array[] = 'Sleep';
                $spells_array[] = 'Summon Monster I';
                $spells_array[] = 'True Strike';
                $spells_array[] = 'Unseen Servant';
                $spells_array[] = 'Ventriloquism';
                
        }               //CVC - 12/05/15  - Complete
	if($level == 2){
		$spells_array[] = 'NA';

	}
	if($level == 3){
		$spells_array[] = 'NA';
	}
	if($level == 4){
		$spells_array[] = 'NA';
	}
	if($level == 5){
		$spells_array[] = 'NA';
	}
	if($level == 6){
		$spells_array[] = 'NA';
	}
	if($level == 7){
		$spells_array[] = 'NA';
	}
	if($level == 8){
		$spells_array[] = 'NA';
	}
	if($level == 9){
		$spells_array[] = 'NA';
	}      
    }
	