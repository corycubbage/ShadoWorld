function find_username(e){"use strict";return popup(e,760,570,"_usersearch"),!1}function popup(e,t,n,i){"use strict";return i||(i="_popup"),window.open(e.replace(/&amp;/g,"&"),i,"height="+n+",resizable=yes,scrollbars=yes, width="+t),!1}function pageJump(e){"use strict";var t=e.val(),n=e.attr("data-per-page"),i=e.attr("data-base-url"),s=e.attr("data-start-name");null!==t&&!isNaN(t)&&t==Math.floor(t)&&t>0&&(-1===i.indexOf("?")?document.location.href=i+"?"+s+"="+(t-1)*n:document.location.href=i.replace(/&amp;/g,"&")+"&"+s+"="+(t-1)*n)}function marklist(e,t,n){"use strict";jQuery("#"+e+" input[type=checkbox][name]").each(function(){var e=jQuery(this);e.attr("name").substr(0,t.length)===t&&e.prop("checked",n)})}function viewableArea(e,t){"use strict";e&&(t||(e=e.parentNode),e.vaHeight?(e.style.height=e.vaHeight+"px",e.style.overflow="auto",e.style.maxHeight=e.vaMaxHeight,e.vaHeight=!1):(e.vaHeight=e.offsetHeight,e.vaMaxHeight=e.style.maxHeight,e.style.height="auto",e.style.maxHeight="none",e.style.overflow="visible"))}function activateSubPanel(e,t){"use strict";var n,i;for("string"==typeof e&&(i=e),$('input[name="show_panel"]').val(i),"undefined"==typeof t&&(t=jQuery(".sub-panels a[data-subpanel]").map(function(){return this.getAttribute("data-subpanel")})),n=0;n<t.length;n++)jQuery("#"+t[n]).css("display",t[n]===i?"block":"none"),jQuery("#"+t[n]+"-tab").toggleClass("activetab",t[n]===i)}function selectCode(e){"use strict";var t,n,i=e.parentNode.parentNode.getElementsByTagName("CODE")[0];if(window.getSelection)if(t=window.getSelection(),t.setBaseAndExtent){var s=i.innerText.length>1?i.innerText.length-1:1;t.setBaseAndExtent(i,0,i,s)}else window.opera&&"<BR>"===i.innerHTML.substring(i.innerHTML.length-4)&&(i.innerHTML=i.innerHTML+"&nbsp;"),n=document.createRange(),n.selectNodeContents(i),t.removeAllRanges(),t.addRange(n);else document.getSelection?(t=document.getSelection(),n=document.createRange(),n.selectNodeContents(i),t.removeAllRanges(),t.addRange(n)):document.selection&&(n=document.body.createTextRange(),n.moveToElementText(i),n.select())}function play_qt_file(e){"use strict";var t,n,i=e.GetRectangle();if(i){i=i.split(",");var s=parseInt(i[0],10),a=parseInt(i[2],10),o=parseInt(i[1],10),r=parseInt(i[3],10);t=0>s?-1*s+a:a-s,n=0>o?-1*o+r:r-o}else t=200,n=0;e.width=t,e.height=n+16,e.SetControllerVisible(!0),e.Play()}function phpbbCheckKey(e){"use strict";return!e.keyCode||40!==e.keyCode&&38!==e.keyCode||(inAutocomplete=!0),!inAutocomplete||lastKeyEntered&&lastKeyEntered!==e.which?13!==e.which?(lastKeyEntered=e.which,!0):!1:(inAutocomplete=!1,!0)}function insertUser(e,t){"use strict";var n=jQuery(e),i=n.attr("data-form-name"),s=n.attr("data-field-name"),a=opener.document.forms[i][s];a.value.length&&"textarea"==a.type&&(t=a.value+"\n"+t),a.value=t}function insert_marked_users(e,t){"use strict";for(var n=0;n<t.length;n++)t[n].checked&&insertUser(e,t[n].value);window.close()}function insert_single_user(e,t){"use strict";insertUser(e,t),window.close()}function parseDocument(e){"use strict";var t=document.createElement("div"),n="undefined"==typeof t.style.borderRadius,i=$("body");e.find("input[data-reset-on-edit]").on("keyup",function(){$(this.getAttribute("data-reset-on-edit")).val("")}),e.find(".pagination .page-jump-form :button").click(function(){var e=$(this).siblings("input.inputbox");pageJump(e)}),e.find(".pagination .page-jump-form input.inputbox").on("keypress",function(e){(13===e.which||13===e.keyCode)&&(e.preventDefault(),pageJump($(this)))}),e.find(".pagination .dropdown-trigger").click(function(){var e=$(this).parent();setTimeout(function(){e.hasClass("dropdown-visible")&&e.find("input.inputbox").focus()},100)}),n&&e.find("ul.linklist.bulletin > li:first-child, ul.linklist.bulletin > li.rightside:last-child").addClass("no-bulletin"),e.find(".navlinks").each(function(){function e(){var e=0,s=n.outerWidth(!0)-n.width();i.each(function(){e+=$(this).outerWidth(!0)}),n.css("max-width",Math.floor(t.width()-e-s)+"px")}var t=$(this),n=t.children().not(".rightside"),i=t.children(".rightside");1===n.length&&i.length&&(e(),$(window).resize(e))}),e.find(".breadcrumbs:not([data-skip-responsive])").each(function(){function e(){var e=t.height(),h=i.width();if(r=parseInt(t.css("line-height")),n.each(function(){$(this).height()>0&&(r=Math.max(r,$(this).outerHeight(!0)))}),!(r>=e&&(!l||d===!1||d>=h)||(d=h,l&&(t.removeClass("wrapped").find(".crumb.wrapped").removeClass("wrapped "+a.join(" ")),t.height()<=r)||(l=!0,t.addClass("wrapped"),t.height()<=r))))for(var c=0;o>c;c++)for(var p=s-1;p>=0;p--)if(n.eq(p).addClass("wrapped "+a[c]),t.height()<=r)return}var t=$(this),n=t.find(".crumb"),s=n.length,a=["wrapped-max","wrapped-wide","wrapped-medium","wrapped-small","wrapped-tiny"],o=a.length,r=0,d=!1,l=!1;t.find("a").each(function(){var e=$(this);e.attr("title",e.text())}),e(),$(window).resize(e)}),e.find(".linklist:not(.navlinks, [data-skip-responsive]), .postbody .post-buttons:not([data-skip-responsive])").each(function(){function e(){var e=i.width();if(!(b&&g&&v>=e||(v=e,(m||b)&&(o.removeClass("hidden"),u.children(".clone").addClass("hidden"),m=b=!1),g&&(t.removeClass("compact"),g=!1),l&&f?p.removeClass("hidden"):p.addClass("hidden"),t.height()<=C||(g||(t.addClass("compact"),g=!0),t.height()<=C)))){if(g&&(t.removeClass("compact"),g=!1),!w){var n=r.clone();u.prepend(n.addClass("clone clone-first").removeClass("leftside rightside")),t.hasClass("post-buttons")&&($(".button",u).removeClass("button icon-button"),$(".responsive-menu-link",p).addClass("button icon-button").prepend("<span></span>")),w=!0}if(m||(r.addClass("hidden"),m=!0,u.children(".clone-first").removeClass("hidden"),p.removeClass("hidden")),!(t.height()<=C)&&(g||(t.addClass("compact"),g=!0),!(t.height()<=C)&&d.length)){if(g&&(t.removeClass("compact"),g=!1),!y){var s=d.clone();u.prepend(s.addClass("clone clone-last").removeClass("leftside rightside")),y=!0}b||(d.addClass("hidden"),b=!0,u.children(".clone-last").removeClass("hidden")),t.height()<=C||g||(t.addClass("compact"),g=!0)}}}var t=$(this),n=".breadcrumbs, [data-skip-responsive]",s=".edit-icon, .quote-icon, [data-last-responsive]",a=t.children(),o=a.not(n),r=o.not(s),d=o.filter(s),l="nav-main"==t.attr("id"),h='<li class="responsive-menu hidden"><a href="javascript:void(0);" class="responsive-menu-link">&nbsp;</a><div class="dropdown hidden"><div class="pointer"><div class="pointer-inner" /></div><ul class="dropdown-contents" /></div></li>',c=3;l||(o.is(".rightside")?(o.filter(".rightside:first").before(h),t.children(".responsive-menu").addClass("rightside")):t.append(h));var p=t.children(".responsive-menu"),u=p.find(".dropdown-contents"),f=u.find("li:not(.separator)").length,v=!1,g=!1,m=!1,b=!1,w=!1,y=!1,C=0;a.each(function(){$(this).height()&&(C=Math.max(C,$(this).outerHeight(!0)))}),1>C||(C+=c,l||phpbb.registerDropdown(p.find("a.responsive-menu-link"),p.find(".dropdown"),!1),a.find("img").each(function(){$(this).load(function(){e()})}),e(),$(window).resize(e))}),n||(e.find("ul.topiclist dd.mark").siblings("dt").children(".list-inner").addClass("with-mark"),e.find(".topiclist.responsive-show-all > li > dl").each(function(){var e=$(this),t=e.find("dt .responsive-show:last-child"),n=!0;t.length?n=0===$.trim(t.text()).length:(e.find("dt > .list-inner").append('<div class="responsive-show" style="display:none;" />'),t=e.find("dt .responsive-show:last-child")),e.find("dd").not(".mark").each(function(){var e=$(this),i=e.children(),s=e.html();1==i.length&&i.text()==e.text()&&(s=i.html()),t.append((n?"":"<br />")+s),n=!1})}),e.find(".topiclist.responsive-show-columns").each(function(){var e=$(this),t=[],n=0;e.prev(".topiclist").find("li.header dd").not(".mark").each(function(){t.push($(this).text()),n++}),n&&e.find("dl").each(function(){var e=$(this),i=e.find("dt .responsive-show:last-child"),s=!0;i.length?s=0===$.trim(i.text()).length:(e.find("dt > .list-inner").append('<div class="responsive-show" style="display:none;" />'),i=e.find("dt .responsive-show:last-child")),e.find("dd").not(".mark").each(function(e){var a=$(this),o=a.children(),r=a.html();1==o.length&&o.text()==a.text()&&(r=o.html()),n>e&&(r=t[e]+": <strong>"+r+"</strong>"),i.append((s?"":"<br />")+r),s=!1})})}),e.find("table.table1").not(".not-responsive").each(function(){var e,t,n=$(this),i=n.find("thead > tr > th"),s=[],a=0;return i.each(function(t){var i=$(this),o=parseInt(i.attr("colspan")),r=i.attr("data-dfn"),d=r?r:i.text();for(o=isNaN(o)||1>o?1:o,e=0;o>e;e++)s.push(d);a++,r&&!t&&n.addClass("show-header")}),t=s.length,n.addClass("responsive"),2>a?void n.addClass("show-header"):void n.find("tbody > tr").each(function(){var e=$(this),n=e.children("td"),i=0;return 1==n.length?void e.addClass("big-column"):void n.each(function(){var e=$(this),n=parseInt(e.attr("colspan")),a=$.trim(e.text());i>=t||(a.length&&"-"!==a||e.children().length?e.prepend('<dfn style="display: none;">'+s[i]+"</dfn>"):e.addClass("empty"),n=isNaN(n)||1>n?1:n,i+=n)})})}),e.find("table.responsive > tbody").not(".responsive-skip-empty").each(function(){var e=$(this).children("tr");e.length||$(this).parent("table:first").addClass("responsive-hide")}),e.find("#tabs, #minitabs").not("[data-skip-responsive]").each(function(){function e(){var n=i.width(),a=t.height();if(arguments.length||h&&!(l>=n)||!(d>=a)){if(s.show(),o.hide(),l=n,a=t.height(),d>=a)return void(o.hasClass("dropdown-visible")&&phpbb.toggleDropdown.call(o.find("a.responsive-tab-link").get(0)));h=!0,o.show(),r.html("");var c,p,u=s.filter(":not(.activetab, .responsive-tab)"),f=u.length;for(c=f-1;c>=0;c--)if(p=u.eq(c),r.prepend(p.clone(!0).removeClass("tab")),p.hide(),t.height()<=d)return void r.find("a").click(function(){e(!0)});r.find("a").click(function(){e(!0)})}}var t=$(this),n=t.children(),s=n.children().not("[data-skip-responsive]"),a=s.children("a"),o=n.append('<li class="tab responsive-tab" style="display:none;"><a href="javascript:void(0);" class="responsive-tab-link">&nbsp;</a><div class="dropdown tab-dropdown" style="display: none;"><div class="pointer"><div class="pointer-inner" /></div><ul class="dropdown-contents" /></div></li>').find("li.responsive-tab"),r=o.find(".dropdown-contents"),d=0,l=!1,h=!1;a.each(function(){var e=$(this);d=Math.max(d,Math.max(e.outerHeight(!0),e.parent().outerHeight(!0)))}),phpbb.registerDropdown(o.find("a.responsive-tab-link"),o.find(".dropdown"),{visibleClass:"activetab"}),e(!0),$(window).resize(e)}),e.find("#navigation").each(function(){var e=$(this).children("ol, ul").children("li");1===e.length&&$(this).addClass("responsive-hide")}),e.find("[data-responsive-text]").each(function(){function e(){if($(window).width()>700){if(!s)return;return t.text(n),void(s=!1)}s||(t.text(i),s=!0)}var t=$(this),n=t.text(),i=t.attr("data-responsive-text"),s=!1;e(),$(window).resize(e)}))}jQuery(function(e){"use strict";e(".sub-panels").each(function(){var t=e("a[data-subpanel]",this),n=t.map(function(){return this.getAttribute("data-subpanel")}),i=this.getAttribute("data-show-panel");n.length&&(activateSubPanel(i,n),t.click(function(){return activateSubPanel(this.getAttribute("data-subpanel"),n),!1}))})});var inAutocomplete=!1,lastKeyEntered="";jQuery(function(e){"use strict";e("form input[type=text], form input[type=password]").on("keypress",function(t){var n=e(this).parents("form").find("input[type=submit].default-submit-action");return!n||n.length<=0?!0:phpbbCheckKey(t)?!0:t.which&&13===t.which||t.keyCode&&13===t.keyCode?(n.click(),!1):!0})}),jQuery(function(e){"use strict";e("#phpbb.nojs").toggleClass("nojs hasjs"),e("#phpbb").toggleClass("hastouch",phpbb.isTouch),e("#phpbb.hastouch").removeClass("notouch"),e("form[data-focus]:first").each(function(){e("#"+this.getAttribute("data-focus")).focus()}),parseDocument(e("body"))});
function addcusotmeskill1(selected) {
    var ct = $('input[name="' + selected.name + '"]').attr('count');

    var g = selected.name.split("[");
    var gg = g[0].split("(");
    //if ($(':input[type="text"]').hasClass("type_id"))
    if (gg[0] == 'Craft' || gg[0] == 'Knowledge' || gg[0] == 'Perform' || gg[0] == 'Profession')
    {
        $('#tableid').append('<tr><td>' + selected.name + '</td><td>&nbsp;&nbsp;&nbsp;Type :<input id="' + selected.name + '_' + ct + '" class="type_id" type="text" value="" name="type[]"></td></tr><tr><td></td><td>&nbsp;&nbsp;&nbsp;Value:<input id="' + selected.name + '" type="text" value="" name="value[]"><br></td></tr>');
    }
    else
    {
        $('#tableid').append('<tr><td>' + selected.name + '</td><td>&nbsp;&nbsp;&nbsp;Value:<input id="' + selected.name + '_' + ct + '" type="text" value="" name="value[]"><br></td></tr>');
    }
    $('input[name="' + selected.name + '"]').attr('count', parseInt(ct) + 1);

}
function remove_level(variable) {
    var bool = confirm("Do you want to delete this spell level ?");
    if (bool == true)
    {
        var level = variable.id;
        var post_uid = variable.name;

        $.ajax({
            type: "POST",
            async: false,
            url: 'includes/ucp/ucp_delete_level.php?Level=' + level + '&Id=' + post_uid,
            data: '',
            success: function(result) {
                //window.location.reload();
                location.reload(true);
            }
        });
    }

}
function remove_ability(variable) {
    var bool = confirm("Do you Want to delete this Specialy Ability ?");
    if (bool == true)
    {
        var ability = variable.id;
        var post_uid = variable.name;

        $.ajax({
            type: "POST",
            url: 'includes/ucp/ucp_delete_level.php?Ability=' + ability + '&Idability=' + post_uid,
            data: '',
            success: function(result) {

                // window.location.reload();
                location.reload(true);
            }
        });
    }

}
function varibles() {

    var v = $("#post_as").val();
    if (v != '') {

        if ($('#variables').is(':visible') == false)
        {
            $("#variables").show();
            $('#change_player_info').text('- Change Player Information');
        }
        else
        {

            $("#variables").hide();
            $('#change_player_info').text('+ Change Player Information');
        }
    }
    else {
        alert("Please Select an Account");
    }
}
function hit() {

    if ($('#hit_curr').is(':visible') == false)
    {
        $("#hit_curr").show();
        $('#hit_current').text('- Hit Points');
    }
    else
    {
        $("#hit_curr").hide();
        $('#hit_current').text('+ Hit Points');
    }
}
function condition_status() {

    if ($('#condi_stat').is(':visible') == false)
    {
        $("#condi_stat").show();
        $('#condi_status').text('- Conditions and Status Effects');
    }
    else
    {
        $("#condi_stat").hide();
        $('#condi_status').text('+ Conditions and Status Effects');
    }
}
function Spells() {

    if ($('#spell').is(':visible') == false)
    {
        $("#spell").show();
        $('#spells').text('- Spells');
    }
    else
    {
        $("#spell").hide();
        $('#spells').text('+ Spells');
    }
}
function special_abilities() {

    if ($('#special_abilities').is(':visible') == false)
    {
        $("#special_abilities").show();
        $('#special_abili').text('- Special Abilities');
    }
    else
    {
        $("#special_abilities").hide();
        $('#special_abili').text('+ Special Abilities');
    }
}
function skills_fn() {

    if ($('#skills_fn').is(':visible') == false)
    {
        $("#skills_fn").show();
        $('#skill_fn').text('- Skills');
    }
    else
    {
        $("#skills_fn").hide();
        $('#skill_fn').text('+ Skills');
    }
}
function addskilldecription() {

    $("#addskilldecription").show();
    $("#addskilldecription").html("");
    var seleted = $("#skill").val();

    var i;
    var html;
    for (i = 0; i < seleted.length; i++)
    {
        $("#addskilldecription").append(seleted[i] + ': <input type=text name="skill_desc[]" id="skill" autofocus/><input type="hidden" name="hidden_skill[]" value="' + seleted[i] + '" /><br /><br />');
    }
    //$('#add_skill_description').attr('disabled',true);
}
function offense() {

    if ($('#offens').is(':visible') == false)
    {
        $("#offens").show();
        $('#offen').text('- Offense');
    }
    else
    {
        $("#offens").hide();
        $('#offen').text('+ Offense');
    }
}
function gear_fn() {

    if ($('#gear2').is(':visible') == false)
    {
        $("#gear2").show();
        $('#gear1').text('- Gear');
    }
    else
    {
        $("#gear2").hide();
        $('#gear1').text('+ Gear');
    }
}
function other() {

    if ($('#other2').is(':visible') == false)
    {
        $("#other2").show();
        $('#other1').text('- Other');
    }
    else
    {
        $("#other2").hide();
        $('#other1').text('+ Other');
    }
}
function view_map() {

    if ($('#view_map').is(':visible') == false)
    {
        $("#view_map").show();
        $('#view_map_info').text('- View Map Information');
    }
    else
    {
        $("#view_map").hide();
        $('#view_map_info').text('+ View Map Information');
    }
}
function view_game_log() {
    if ($('#view_game').is(':visible') == false)
    {
        $("#view_game").show();
        $('#view_game_log').text('- View Group Player Information');
    }
    else
    {
        $("#view_game").hide();
        $('#view_game_log').text('+ View Group Player Information');
    }
}
function gear(clicked) {

    $id = clicked.id;
    $split = $id.split("_");

    if (!$('.gear_' + $split[2]).is(':visible'))
    {
        $('.gear_' + $split[2]).show();
        $('#gear_link_' + $split[2]).html('<h4>-Gear</h4>')
    }
    else
    {
        $('.gear_' + $split[2]).hide();
        $('#gear_link_' + $split[2]).html('<h6>+Gear</h6>')
    }

}
function map() {
    if ($('#map_image').is(':visible') == false)
    {
        $("#map_image").show();
        $('#iamge_link').text('- Set Map Info');
    }
    else
    {
        $("#map_image").hide();
        $('#iamge_link').text('+ Set Map Info');
    }
}
function addquantity() {
    var quality = [];
    var qualityval = [];
    var gear = [];
    var desc_gear = [];
    var i = 0;
    var p = 0;
    var k = 0;
    $('input[name="quality[]"]').each(function() {
        qualityval[k++] = $(this).val();
        quality[i++] = $(this).attr('id');
    });

    var j = 0;
    $('#gear :selected').each(function() {
        gear[j++] = $(this).val();
    });
    var l;
    for (l = 0; l < quality.length; l++)
    {
        if (quality[l] == gear[l])
        {

            var g = gear[l].split("(");
            $('#gear option:contains("' + gear[l] + '")').val(g[0] + "(" + qualityval[l] + ")");
            $('#gear option:contains("' + gear[l] + '")').text(g[0] + "(" + qualityval[l] + ")");
        }
        else
        {
            alert('Please Enter ' + gear[l] + ' Quantity numeric');
        }
        if (l == (quality.length - 1))
        {
            $('#div_gear_quantity').hide();
        }
    }
    $('input[name="description[]"]').each(function() {
        desc_gear[p++] = $(this).val();

    });
    var gd;

    for (gd = 0; gd < desc_gear.length; gd++) {

        $('#gear_desc').append("<input type='hidden' name='gear_desc1[]' value='" + desc_gear[gd] + "'/>");
        $('#gear_desc').append("<input type='hidden' name='gear_value[]' value='" + gear[gd] + "'/>");
    }


}
function addcusotmeskill() {
    var skill = [];
    var skill1 = [];
    var skilltype = [];
    var skillval = [];
    var gear = [];
    var i = 0;
    var j = 0;
    var k = 0;

    var type = $(".type_id").val();

    $('input[name="type[]"]').each(function() {
        skilltype[i++] = $(this).val();

    });

    $('input[name="value[]"]').each(function() {
        skillval[k++] = $(this).val();
        skill[j++] = $(this).attr('id');
    });

    var m = 0;
    $('#skill :selected').each(function() {
        skill1[m++] = $(this).val();
    });
    var l;
    var ll = 0;
    for (l = 0; l < skill.length; l++)
    {
        if (skill[l] == skill1[l])
        {
            var numbers = /^[0-9]+$/;
            if (skillval[l].match(numbers))
            {
                var g = skill1[l].split("[");
                var gg = g[0].split("(");

                if (gg[0] == 'Craft' || gg[0] == 'Knowledge' || gg[0] == 'Perform' || gg[0] == 'Profession')
                {
                    if (skilltype[ll] != null)
                    {
                        $('#skill option:contains("' + skill1[l] + '")').val(gg[0] + "(" + skilltype[ll] + ")" + "[" + skillval[l] + "]");
                        $('#skill option:contains("' + skill1[l] + '")').text(gg[0] + "(" + skilltype[ll] + ")" + "[" + skillval[l] + "]");

                    }
                    else
                    {
                        alert("Enter Type of skill " + skilltype[ll]);
                    }
                    ll++;
                }
                else
                {

                    $('#skill option:contains("' + skill1[l] + '")').val(gg[0] + "[" + skillval[l] + "]");
                    $('#skill option:contains("' + skill1[l] + '")').text(gg[0] + "[" + skillval[l] + "]");

                }

            }

            else
            {
                alert('Please Enter ' + skill1[l] + ' Value numeric');
            }

            if (l == (skillval.length - 1))
            {
                $('#div_skill_value').hide();
            }
        }
        else
        {
            var g1 = skill[l].split("[");
            var gg1 = g1[0].split("(");

            if (gg1[0] == 'Craft' || gg1[0] == 'Knowledge' || gg1[0] == 'Perform' || gg1[0] == 'Profession')
            {
                $("#skill").append("<option value='" + gg1[0] + "(" + skilltype[ll] + ")" + "[" + skillval[ll] + "]'>" + gg1[0] + "(" + skilltype[ll] + ")" + "[" + skillval[ll] + "] </option>");
                ll++;
            }
            else
            {
                $("#skill").append("<option value='" + gg1[0] + "[" + skillval[ll] + "]'>" + gg1[0] + "[" + skillval[ll] + "] </option>");
            }
            if (l == (skillval.length - 1))
            {
                $('#div_skill_value').hide();
            }
        }


    }

    $("#skill").html($('#skill option').sort(function(x, y) {
        return $(x).text() < $(y).text() ? -1 : 1;
    }))
    $("#skill").get(0).selectedIndex = 0;
    //e.preventDefault();

}
function addgear() {
    var newgear = $('#new_gear').val();//alert($('#gear_description').val());
    var gear_desc = $('#gear_description').val();//alert(gear_desc);    
    $('#gear_desc').val(gear_desc);//alert($('#gear_desc').val(gear_desc));
    var gear = newgear.replace(/\//g, "&#47");
    var new_quality = $('#new_quality').val();
    var gr = gear + '(' + new_quality + ')';

    if (new_quality && newgear)
    {
        var numbers = /^[0-9]+$/;
        if (new_quality.match(numbers))
        {
            if (gr != "")
            {
                $("#gear").append("<option value='" + gr + "'>" + gr + "</option>");
                $("#div_gear_name").remove();
            }
        }
        else
        {
            alert('Please Enter Quantity numeric');
        }
    }
    else
    {
        alert("Please Enter Gear Name and Quantity");
    }
}
function remove_extra_level(clicked) {

    var name = clicked.name;
    var splits = name.split('_');
    var id = parseInt(splits[2]) + 1;
    var pid = splits[0];
    var uid = splits[1];
    var sp = splits[2];
    var val = $("#increment_variable_spell").val();
    var value = parseInt(val) - 1;
    $("#increment_variable_spell").val(value);
    $('[name="' + clicked.name + '"]').parent().parent().remove();
    var i;
    for (i = 0; i < value; i++)
    {
        $('label[for=select_current_count' + id + ']').attr('for', 'select_current_count' + sp);

        $("#select_level" + id).attr('name', 'select_level' + sp);
        $("#select_level" + id).attr('id', 'select_level' + sp);

        $("#select_level_min" + id).attr('name', 'select_level_min' + sp);
        $("#select_level_min" + id).attr('id', 'select_level_min' + sp);

        $("#select_level_max" + id).attr('name', 'select_level_max' + sp);
        $("#select_level_max" + id).attr('id', 'select_level_max' + sp);

        $('[name="' + pid + '_' + uid + '_' + id + '"]').attr('name', pid + '_' + uid + '_' + sp);
        id++;
        sp++;
    }
}
function remove_extra_ability(clicked) {

    var name = clicked.name;
    var splits = name.split('_');
    var id = parseInt(splits[2]) + 1;
    var pid = splits[0];
    var uid = splits[1];
    var sp = splits[2];
    var val = $("#increment_variable_ability").val();
    var value = parseInt(val) - 1;
    $("#increment_variable_ability").val(value);
    $('[name="' + clicked.name + '"]').parent().parent().remove();
    var i;
    for (i = 0; i < value; i++)
    {
        $('[name="ability' + id + '"]').attr('name', 'ability' + sp);
        $('label[for=minmaxability' + id + ']').attr('for', 'minmax_ability' + sp);
        $("#min_ability" + id).attr('name', 'min_ability' + sp);
        $("#min_ability" + id).attr('id', 'min_ability' + sp);
        $("#max_ability" + id).attr('name', 'max_ability' + sp);
        $("#max_ability" + id).attr('id', 'max_ability' + sp);
        $('[name="' + pid + '_' + uid + '_' + id + '"]').attr('name', pid + '_' + uid + '_' + sp);
        id++;
        sp++;
    }
}
function addname() {
    $('#addweaponnames').html('');
    //$('#addweaponnames').append("<br><br>Weapon Name : <input type='text' name='addfieldsweaponname' value='' id='addfieldsweaponname_'>&nbsp;&nbsp;Description : <input type='text' name='weapon_description' value='' id='weapon_description'>&nbsp;&nbsp;Damage : <input type='text' name='damage' value='' id='damage_'>&nbsp;&nbsp;Attack : <input type='text' name='attack' value='' id='attack_'><br/><br/>Critical Multiplier:<select name='critical_multiplier' id='critical_multiplier_'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>1</option></select><br /><br /><input type=button name=add value='Add Weapon' class='button1' onclick='addweaponfields()'>");
    $('#addweaponnames').html("<br><br>Weapon Name : <input type='text' name='weponaname' value='' id='weaponname'>&nbsp;&nbsp;Description : <input type='text' name='weapon_description' value='' id='weapon_description'><br /><br />Damage : <input type='text' name='damage' value='' id='damage_value' class='damage'><br /><br />Attack : <input type='text' name='attack' value='' id='attack__' ><br/><br/>Critical Multiplier:<select name='critical_multiplier' id='critical_multiplier__'><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option></select><br /><br />Range : <input type='text' name='range' value='' id='range__'><br/><br/>Type : <select name='type' id='type__' multiple><option value='B'>B</option><option value='P'>P</option><option value='S'>S</option><option value='M'>M</option></select><br /><br /><input type=button name=add value='Add Weapon' class='button1' onclick='add_weaponname()'>");
}
function add_weaponname() {
   
    var weponaname = $('#weaponname').val();
    var weapon_desc = $('#weapon_description').val();//alert(weapon_desc);   
    $('#weapon_desc').val(weapon_desc);//alert($('#weapon_desc').val(weapon_desc));

    $("#weapenbox").append("<option value='" + weponaname + "'>" + weponaname + "</option>");
    //$("#addweaponnames").html('');

    var user_id = $('#post_as').val();
	var damage = $('#damage_value').val();
	var attack = $('#attack__').val();
	var critical_multiplier = $('#critical_multiplier__').val();
	var range = $('#range__').val();
	var type = $('#type__').val();
    $.ajax({
        type: "POST",
        async: false,
        //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
        url: 'includes/ucp/ucp_add_weapon.php?weponaname=' + weponaname + '&user_id=' + user_id+"&damage="+damage+"&attack="+attack+"&critical_multiplier="+critical_multiplier+"&range="+range+"&type="+type,
        success: function(result) {
			console.log(result);
            //$("#weaponsfields").html('');
            //location.reload(true);

        }
    });
	//$("#addweaponnames").html('');
}
function addweaponfields() {
   // alert("hiii");
  
   
    var i;
    //addfieldsweaponname = $('#addfieldsweaponname_').val();
   // alert(addfieldsweaponname);
  //  var addfieldsweaponname = [];
 //   var attack = [];
   // var damage = [];
   // var critical_multiplier = [];
    //var range = [];
    //var type = [];
 
   /* for (i = 0; i < fields_count; i++)
    {
        addfieldsweaponname[i] = $('#addfieldsweaponname_' + i).val();
     
        attack[i] = $('#attack_' + i).val();
      //  alert(attack[i]);
        damage[i] = $('#damage_' + i).val();
        critical_multiplier[i] = $('#critical_multiplier_' + i).val();
        range[i] = $('#range_' + i).val();
        type[i] = $('#type_' + i).val();
       // alert(damage[i]);
    }*/
   addfieldsweaponname = $('#addfieldsweaponname_').val();
     damage = $('#damage_').val();
      attack = $('#attack_').val();
      critical_multiplier = $('#critical_multiplier_').val();
  //  alert(critical_multiplier);
    //var fields_count = $('#addfieldscount').val();

    //add weapens fields ajax call to database
    var user_id = $('#user_id').val();
    var add = 'Database';
    
    var p ='2';
    $.ajax({
        type: "POST",
        async: false,
        //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
        url: 'includes/ucp/ucp_add_weapon.php?Database=' + add + '&addfieldsweaponname=' + addfieldsweaponname + '&attack=' + attack + '&damage=' + damage + '&critical_multiplier=' + critical_multiplier + '&user_id=' + user_id,
        data: '',
        success: function(result) {
            // alert(addfieldsweaponname);
            $("#weapenbox").append("<option value='" + addfieldsweaponname + "'>" + addfieldsweaponname + "</option>");
            $("#addfieldsweaponname_").html('hgh');
            $("#attack_").html('');
            $("#damage_").html('');
           
           // location.reload(true);
            //$("#weaponsfields").html('<b>Weapon Fields Added</b>');
        }
    });

return false;
}
function updateweaponfields() {
    var fields_count = $('#addfieldscount').val();
    var i;

    var addfieldsweaponname = [];
    var attack = [];
    var damage = [];
    var critical_multiplier = [];
    var range = [];
    var type = [];

    for (i = 0; i < fields_count; i++)
    {
        addfieldsweaponname[i] = $('#addfieldsweaponname_' + i).val();
        attack[i] = $('#attack_' + i).val();
        damage[i] = $('#damage_' + i).val();
        critical_multiplier[i] = $('#critical_multiplier_' + i).val();
        range[i] = $('#range_' + i).val();
        type[i] = $('#type_' + i).val();
    }

    //add weapens fields ajax call to database
    var user_id = $('#user_id').val();
    var add = 'Database';
    $.ajax({
        type: "POST",
        async: false,
        //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
        url: 'includes/ucp/ucp_add_weapon.php?Database=' + add + '&addfieldsweaponname=' + addfieldsweaponname + '&attack=' + attack + '&damage=' + damage + '&critical_multiplier=' + critical_multiplier + '&range=' + range + '&type=' + type + '&fields_count=' + fields_count + '&user_id=' + user_id,
        data: '',
        success: function(result) {
            // alert(addfieldsweaponname);
			console.log(result);
            $("#weaponsfields").html('');
           // location.reload(true);
            //$("#weaponsfields").html('<b>Weapon Fields Added</b>');
        }
    });

return false;
}
function addspellname() {
    var name = $("#aspellname").val();
    var add = 'insertspellname';
    var account_id = $("#account_id").val();
    $("#spells").append("<option value='" + name + "'>" + name + "</option>");
    $("#spelldiv").html('');

    $.ajax({
        type: "POST",
        async: false,
        data: {"add": add, "spellname": name, "account_id": account_id},
        url: 'includes/ucp/ucp_add_spells_skills.php',
        success: function(result) {
        }
    });
}
function selectspellaccount(v) {
    if ($('#post_as').val() == '')
    {
        alert('Please Select one account or your parent account');
    }
    else
    {
        window.location = v.name + '&user_id=' + $('#post_as').val();
    }
}
function addspelldecription() {
    $("#addspelldescription").show();
    $("#addspelldescription").html("");
    var sp = $("#spell_level").val();//alert(sp);
    var a = $("#increment_variable_spell").val();//alert(a); 
    var ct = parseInt(a);//alert(ct);
    var i;
    var html;
    for (i = 0; i < ct; i++)
    {

        if (i == 0) {
             var sp1 = $("#spell_level").val();
             var j;
             for (j = 0; j < sp1.length; j++) {

                    $("#addspelldescription").append('Spell_level' + i + ':' + sp[j] + ': <input type=text name="spell_desc[]" value="" id="spell" /><input type="hidden" name="hidden_spell[]" value="'+sp1[j]+ '" /><br /><br />');
                }
           
        }
        else {
            var sp1 = $("#spell_level" + i).val();
            if (sp1 != null)
            {
                var j;
                for (j = 0; j < sp1.length; j++) {

                    $("#addspelldescription").append('Spell_level' + i + ':' + sp1[j] + ': <input type=text name="spell_desc'+i+'[]" value="" id="spell" /><input type="hidden" name="hidden_spell'+i+'[]" value="'+sp1[j]+'" /><br /><br />');
                }
            }
            else
            {
                continue;    
            }
        }

    }

}
function addabilitydecription() {
    $("#addabilitydescription").show();
    var a = $("#increment_variable_ability").val();// alert(a);
    //$("#addabilitydescription").append('Ability : <input type=text name=ability id=name/><br /><br />');

    var ct = parseInt(a);//alert(ct);

    var i;
    var html;
    for (i = 0; i < ct; i++)
    {
        $("#addabilitydescription").append('Ability  ' + i + ': <input type=text name="ability[]" id="name"/><input type="hidden" name="hidden_ability[]" value="ability' + i + '" /><br /><br />');
        if (i == (ct - 1))
        {
            $("#addabilitydescription").append('<br/><input type=button name=spell id=name class="button1" value="Add Ability Description"/>');
        }

    }
    $('#add_ability_description').attr('disabled', true);
}
function addgeardecription() {

    $("#addgeardecription").show();
    var seleted = $("#gear").val();
    //var a=seleted.length;alert(a);
    var i;
    var html;
    for (i = 0; i < seleted.length; i++)
    {
        $("#addgeardecription").append(seleted[i] + ': <input type=text name=ability id=name/><br /><br />');
        if (i == (seleted.length - 1))
        {
            $("#addgeardecription").append('<br/><input type="button" name="ability" id="name" class="button1" value="Add Gear Description"/>');
        }

    }
    $('#add_gear_description').attr('disabled', true);
}
function addconstatusdecription() {
    $("#addnegative_condescription").show();
    $("#addpositive_consdescription").show();
    $("#addnegative_condescription").html("");
    $("#addpositive_consdescription").html("");
    var nc = $("#negative_condition").val();
    var i;
    var html;
    for (i = 0; i < nc.length; i++)
    {

        $("#addnegative_condescription").append(nc[i] + ': <input type=text name=nc_name[] id=nc_name  value="" size=25/><input type="hidden" name="nc_name_hide[]" value=' + nc[i] + '><br /><br />');
        //$("#addnegative_condescription").append(nc[i]+': <input type=text name='+nc[i]+' id=nc_name  value="" size=5/><br /><br />');
//        if (i == (nc.length - 1))
//        {   
//            //$("#addnegative_condescription").append('<br/><input type=button name=negative_condescription id=name class="button1" value="Add" onclick="addnegative_condition();" />');
//        }     

    }

    var pc = $("#positive_condition").val();
    var j;
    for (j = 0; j < pc.length; j++)
    {
        var name = pc[j];
        $("#addpositive_consdescription").append(pc[j] + ': <input type=text name=pc_name[] id=pc_name value="" size=25/><input type="hidden" name="pc_name_hide[]" value="' + name + '"><br /><br />');
//        if (i == (pc.length - 1))
//        {   
//            //$("#addpositive_consdescription").append('<br/><input type=button name=positive_condition id=name class="button1" value="Add" onclick="addpositive_condition();" />');
//        }

    }

    //$('#add_con_status_description').attr('disabled',true);
}
function getoffense(offence) {
    var user_id = offence.id;
    var offense_name = offence.name;
    $.ajax({
        type: "POST",
        async: false,
        data: {"user_id": user_id, "offense_name": offense_name},
        //url: 'includes/ucp/ucp_offense.php?user_id=' + user_id + '&offense_name='+offense_name,
        url: 'includes/ucp/ucp_offense.php',
        success: function(result) {
            var html = $('#message').val();
            var content = html + result;
            $('#message').val(content);
        }
    });
}
function getquickskill(selected) {
    var skill = selected.name; //alert(skill);
    var split_skill = skill.split("[");//alert(split_skill[0]);
    var split_skill2 = split_skill[1].split("]");//alert(split_skill2);
    var str = '  [dice="' + selected.value + '"]1d20+' + split_skill2[0] + '[/dice]  ';//alert(str);
    var html = $('#message').val();//alert(html);
    var content = html + str;
    $('#message').val(content);
}
function submitdescription() {
    var i = 0;
    var spell = $('input[name="skillname"]').val();
    var description = $('textarea#description').val();

    var level = $('#select_level').val();
    var account_id = $('#account_id').val();
    var add = 'Addskilltouserskill';
    $.ajax({
        type: "POST",
        async: false,
        data: {"spell": spell, "description": description, "add": add, "level": level, 'account_id': account_id},
        url: 'includes/ucp/ucp_add_spells_skills.php',
        success: function(result) {
            // alert(result);
            $("#details").hide();
            $("#description").html('');
            $("#description").append('<br><br><font color="green" size="4px"> Skill name and Description Added</font>');
        }
    });
}
function deleteweapon(){
	
	
        var add = 'DeleteWeapen';
        var seleted = $("#weapenbox").val();
        var user_id = $('#user_id').val();

        if (seleted)
        {

            $.ajax({
                type: "POST",
                async: false,
                data: {"user_id": user_id, "weapon_name": seleted, "DeleteWeapen": add},
                url: 'includes/ucp/ucp_add_weapon.php',
                success: function(result) {
                	
                 location.reload(true);
                }
            });
        }
        else
        {
            alert("Please Select Weapon which you want to delete");
        }
    
	
}
function apply_onkeypress_event() {
    // A $( document ).ready() block.
    $(document).ready(function() {
        //ajax call to add  spell
        $("#variable_spells").click(function() {
            var i = $('#increment_variable_spell').val();
            var user_id = $('#user_id').val();
            var post_id = $("#post_id").val();
            $.ajax({
                type: "POST",
                async: false,
                //url: 'includes/ucp/ucp_variable_spell_create.php?Id=' + i + '&user_id=' + user_id + '&post_id=' + post_id,
                url: 'includes/create_spells.php?Id=' + i + '&user_id=' + user_id + '&post_id=' + post_id,
                data: '',
                async: true,
                success: function(result) {
                    $('#additionalspell').append(result);
                    var j;
                    if (i == '')
                    {
                        j = 1;
                    }
                    else
                    {
                        j = parseInt(i) + 1;
                    }

                    $('#increment_variable_spell').val(j);
                }
            });
        });

        //ajax call to add ability
        $("#variable_speability").click(function() {
            var i = $('#increment_variable_ability').val();
            var user_id = $('#user_id').val();
            var post_id = $("#post_id").val();
            $.ajax({
                type: "POST",
                async: false,
                url: 'includes/create_ability.php?Id=' + i + '&user_id=' + user_id + '&post_id=' + post_id,
                data: '',
                success: function(result) {
                    $('#additionalability').append(result);
                    var j;
                    if (i == '')
                    {
                        j = 1;
                    }
                    else
                    {
                        j = parseInt(i) + 1;
                    }
                    $('#increment_variable_ability').val(j);
                }
            });
        });

        //ajax call to add gear

        $("#add_quantity").click(function() {
            var seleted = $("#gear").val();
            if (seleted)
            {

                $.ajax({
                    type: "POST",
                    async: false,
                    //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                    url: 'includes/ucp/ucp_add_delete_gear.php?seleted=' + seleted,
                    data: '',
                    success: function(result) {
                        $("#div_gear_quantity").remove();
                        $("#gear_quantity").append(result);
                    }
                });
            }
            else
            {
                alert("Please Select Gear");
            }
        });

        //add skill values
        $("#add_skill_value").click(function() {
            var add = 'Addtext';
            var seleted = $("#skill").val();
            if (seleted)
            {

                $.ajax({
                    type: "POST",
                    async: false,
                    //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                    url: 'includes/ucp/ucp_add_delete_skill.php?addtext=' + add + '&seleted=' + seleted,
                    data: '',
                    success: function(result) {
                        $("#div_skill_value").remove();
                        $("#skill_value").append(result);
                    }
                });
            }
            else
            {
                alert("Please Select a Skill");
            }
        });

        //edit_skill
        $("#edit_skill").click(function() {
            var edit = 'Edittext';
            var seleted = $("#skill").val();
            if (seleted)
            {

                $.ajax({
                    type: "POST",
                    async: false,
                    //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                    url: 'includes/ucp/ucp_add_delete_skill.php?Edittext=' + edit + '&seleted=' + seleted,
                    data: '',
                    success: function(result) {
                        $("#div_skill_value").remove();
                        $("#skill_value").append(result);
                    }
                });
            }
            else
            {
                alert("Please Select Skill");
            }
        });
        //add gear  
        $("#add_gear").click(function() {

            var add = 'Addtext';
            var seleted = $("#gear").val();

            $.ajax({
                type: "POST",
                async: false,
                //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                url: 'includes/ucp/ucp_add_delete_gear.php?addtext=' + add,
                data: '',
                success: function(result) {
                    $("#div_gear_name").remove();
                    $("#gear_quantity").append(result);
                }
            });

        });

        //delete gear  
        $("#delete_gear").click(function() {
            var Delete = $("#gear").val();
            var post_id = $("#post_id").val();
            var user_id = $("#user_id").val();
            if (Delete)
            {
                var add = 'Addtext';

                $.ajax({
                    type: "POST",
                    async: false,
                    //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                    url: 'includes/ucp/ucp_add_delete_gear.php?Delete=' + Delete + '&user_id=' + user_id + '&post_id=' + post_id,
                    data: '',
                    success: function(result) {
                        // alert(result);
                        //window.location.reload();
                        location.reload(true);
                    }
                });
            }
            else
            {
                alert("Please Select Gear");
            }
        });


    });
    //delete gear  
    $("#delete_skill").click(function() {
        var Delete = $("#skill").val();
        var post_id = $("#post_id").val();
        var user_id = $("#user_id").val();
        if (Delete)
        {
            $.ajax({
                type: "POST",
                async: false,
                //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                url: 'includes/ucp/ucp_add_delete_skill.php?Delete=' + Delete + '&user_id=' + user_id + '&post_id=' + post_id,
                data: '',
                success: function(result) {
                    location.reload(true);
                }
            });
        }
        else
        {
            alert("Please Select Skill");
        }


    });

    //add weapens
    $("#addweapon").click(function() {
        var add = 'AddWaepen';
        var seleted = $("#weapenbox").val();
        if (seleted)
        {

            $.ajax({
                type: "POST",
                async: false,
                //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
                url: 'includes/ucp/ucp_add_weapon.php?AddWaepen=' + add + '&seleted=' + seleted,
                data: '',
                success: function(result) {
                    $("#weaponsfields").html('');
                    $("#weaponsfields").append(result);
                }
            });
        }
        else
        {
            alert("Please Select Weapon");
        }
    });

    //add spells
    $("#adspellname").click(function() {

        var add = 'adspellname';
        $.ajax({
            type: "POST",
            async: false,
            //data:{"user_id":user_id,"weapon_name":seleted,"add":add},
            data: {"add": add},
            url: 'includes/ucp/ucp_add_spells_skills.php',
            success: function(result) {
                $("#spelldiv").html('');
                $("#spelldiv").append(result);
            }
        });

    });

    //add gear  
    $("#add_gear").click(function() {

        var add = 'Addtext';
        var seleted = $("#gear").val();

        $.ajax({
            type: "POST",
            async: false,
            //url: 'includes/ucp/ucp_add_gear.php?Id='+i+'USER_ID'+user_id,
            url: 'includes/ucp/ucp_add_delete_gear.php?addtext=' + add,
            data: '',
            success: function(result) {
                $("#div_gear_name").remove();
                $("#gear_quantity").append(result);
            }
        });

    });
    $("#namelevel").click(function() {

        $("#details").show();
        $("#description").show();
        var add = 'AddDescription';
        var selected = $("#spells").val();
        if (selected)
        {
            $.ajax({
                type: "POST",
                async: false,
                data: {"add": add, "selected": selected},
                url: 'includes/ucp/ucp_add_spells_skills.php',
                success: function(result) {
                    //alert(result);
                    $("#description").html('');
                    $("#description").append(result);
                }
            });
        }
        else
        {
            alert("Please select spell");
        }
    });

    //changespell
    $("#changespell").click(function() {

        var add = 'Editspelldata';
        var account_id = $("#account_id").val();
        var mode = $("#mode").val();
        var forum = $("#forum").val();
        var post_spell_id = $("#post_spell_id").val();
        var tvarible = $("#tvarible").val();
        $.ajax({
            type: "POST",
            async: false,
            data: {"add": add, "account_id": account_id, "mode": mode, "forum": forum, "post_spell_id": post_spell_id, "tvarible": tvarible},
            url: 'includes/ucp/ucp_add_spells_skills.php',
            success: function(result) {
                // alert(result);
                $("#details").hide();
                $("#description").html('');
                $("#description").append(result);
                $("#description").show();
            }
        });
    });
    //add weapens
    $("#deletewapon").click(function() {
        var add = 'DeleteWeapen';
        var seleted = $("#weapenbox").val();
        var user_id = $('#user_id').val();

        if (seleted)
        {

            $.ajax({
                type: "POST",
                async: false,
                data: {"user_id": user_id, "weapon_name": seleted, "DeleteWeapen": add},
                url: 'includes/ucp/ucp_add_weapon.php',
                success: function(result) {
                    location.reload(true);
                }
            });
        }
        else
        {
            alert("Please Select Weapon which you want to delete");
        }
    });
}
function goodconditionpopup() {
    alert($('#good_con').val());
}

//function editdescription()
//{
//    alert('gggggggg');
//    var spell = [];
//    var description = [];
//    var i = 0;
//    $('input[name="skillname[]"]').each(function() {
//        spell[i] = $(this).attr('id');
//        description[i] = $("#description_" + i).val();
//        i++;
//    });
////    var level = $('#select_level').val();
////    var account_id = $('#account_id').val();
////    var add = 'Addskilltouserskill';
////    $.ajax({
////        type: "POST",
////        async: false,
////        data: {"spell": spell, "description": description, "add": add, "level": level, 'account_id': account_id},
////        url: 'includes/ucp/ucp_add_spells_skills.php',
////        success: function(result) {
////            //alert(result);
////            $("#details").hide();
////            $("#description").html('');
////            $("#description").append('<br><br><font color="green" size="4px"> Skill name and Description Added</font>');
////        }
////    });
//}
//archi11 ends