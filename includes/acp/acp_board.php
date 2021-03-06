<?php

/**
 *
 * @package acp
 * @version $Id$
 * @copyright (c) 2005 phpBB Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @todo add cron intervals to server settings? (database_gc, queue_interval, session_gc, search_gc, cache_gc, warnings_gc)
 */
/**
 * @ignore
 */
if (!defined('IN_PHPBB')) {
    exit;
}

/**
 * @package acp
 */
class acp_board {

    var $u_action;
    var $new_config = array();

    function main($id, $mode) {
        global $db, $user, $auth, $template;
        global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
        global $cache;

        $user->add_lang('acp/board');

        $action = request_var('action', '');
        $submit = (isset($_POST['submit']) || isset($_POST['allow_quick_reply_enable'])) ? true : false;

        $form_key = 'acp_board';
        add_form_key($form_key);

        /**
         * 	Validation types are:
         * 		string, int, bool,
         * 		script_path (absolute path in url - beginning with / and no trailing slash),
         * 		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
         */
        switch ($mode) {

            case 'settings':
                $display_vars = array(
                    'title' => 'ACP_BOARD_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_BOARD_SETTINGS',
                        'sitename' => array('lang' => 'SITE_NAME', 'validate' => 'string', 'type' => 'text:40:255', 'explain' => false),
                        'site_desc' => array('lang' => 'SITE_DESC', 'validate' => 'string', 'type' => 'text:40:255', 'explain' => false),
                        'board_disable' => array('lang' => 'DISABLE_BOARD', 'validate' => 'bool', 'type' => 'custom', 'method' => 'board_disable', 'explain' => true),
                        'board_disable_msg' => false,
                        'default_lang' => array('lang' => 'DEFAULT_LANGUAGE', 'validate' => 'lang', 'type' => 'select', 'function' => 'language_select', 'params' => array('{CONFIG_VALUE}'), 'explain' => false),
                        'default_dateformat' => array('lang' => 'DEFAULT_DATE_FORMAT', 'validate' => 'string', 'type' => 'custom', 'method' => 'dateformat_select', 'explain' => true),
                        'board_timezone' => array('lang' => 'SYSTEM_TIMEZONE', 'validate' => 'string', 'type' => 'select', 'function' => 'tz_select', 'params' => array('{CONFIG_VALUE}', 1), 'explain' => true),
                        'board_dst' => array('lang' => 'SYSTEM_DST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'default_style' => array('lang' => 'DEFAULT_STYLE', 'validate' => 'int', 'type' => 'select', 'function' => 'style_select', 'params' => array('{CONFIG_VALUE}', false), 'explain' => false),
                        'override_user_style' => array('lang' => 'OVERRIDE_STYLE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'legend2' => 'WARNINGS',
                        'warnings_expire_days' => array('lang' => 'WARNINGS_EXPIRE', 'validate' => 'int', 'type' => 'text:3:4', 'explain' => true, 'append' => ' ' . $user->lang['DAYS']),
                        'legend3' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'features':
                $display_vars = array(
                    'title' => 'ACP_BOARD_FEATURES',
                    'vars' => array(
                        'legend1' => 'ACP_BOARD_FEATURES',
                        'allow_privmsg' => array('lang' => 'BOARD_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_topic_notify' => array('lang' => 'ALLOW_TOPIC_NOTIFY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_forum_notify' => array('lang' => 'ALLOW_FORUM_NOTIFY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_namechange' => array('lang' => 'ALLOW_NAME_CHANGE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_attachments' => array('lang' => 'ALLOW_ATTACHMENTS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_pm_attach' => array('lang' => 'ALLOW_PM_ATTACHMENTS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_pm_report' => array('lang' => 'ALLOW_PM_REPORT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_bbcode' => array('lang' => 'ALLOW_BBCODE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_smilies' => array('lang' => 'ALLOW_SMILIES', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig' => array('lang' => 'ALLOW_SIG', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_nocensors' => array('lang' => 'ALLOW_NO_CENSORS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_bookmarks' => array('lang' => 'ALLOW_BOOKMARKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_birthdays' => array('lang' => 'ALLOW_BIRTHDAYS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_quick_reply' => array('lang' => 'ALLOW_QUICK_REPLY', 'validate' => 'bool', 'type' => 'custom', 'method' => 'quick_reply', 'explain' => true),
                        'legend2' => 'ACP_LOAD_SETTINGS',
                        'load_birthdays' => array('lang' => 'YES_BIRTHDAYS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_moderators' => array('lang' => 'YES_MODERATORS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_jumpbox' => array('lang' => 'YES_JUMPBOX', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_cpf_memberlist' => array('lang' => 'LOAD_CPF_MEMBERLIST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_cpf_viewprofile' => array('lang' => 'LOAD_CPF_VIEWPROFILE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_cpf_viewtopic' => array('lang' => 'LOAD_CPF_VIEWTOPIC', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'legend3' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'avatar':
                $display_vars = array(
                    'title' => 'ACP_AVATAR_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_AVATAR_SETTINGS',
                        'avatar_min_width' => array('lang' => 'MIN_AVATAR_SIZE', 'validate' => 'int:0', 'type' => false, 'method' => false, 'explain' => false,),
                        'avatar_min_height' => array('lang' => 'MIN_AVATAR_SIZE', 'validate' => 'int:0', 'type' => false, 'method' => false, 'explain' => false,),
                        'avatar_max_width' => array('lang' => 'MAX_AVATAR_SIZE', 'validate' => 'int:0', 'type' => false, 'method' => false, 'explain' => false,),
                        'avatar_max_height' => array('lang' => 'MAX_AVATAR_SIZE', 'validate' => 'int:0', 'type' => false, 'method' => false, 'explain' => false,),
                        'allow_avatar' => array('lang' => 'ALLOW_AVATARS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_avatar_local' => array('lang' => 'ALLOW_LOCAL', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_avatar_remote' => array('lang' => 'ALLOW_REMOTE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_avatar_upload' => array('lang' => 'ALLOW_UPLOAD', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_avatar_remote_upload' => array('lang' => 'ALLOW_REMOTE_UPLOAD', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'avatar_filesize' => array('lang' => 'MAX_FILESIZE', 'validate' => 'int:0', 'type' => 'text:4:10', 'explain' => true, 'append' => ' ' . $user->lang['BYTES']),
                        'avatar_min' => array('lang' => 'MIN_AVATAR_SIZE', 'validate' => 'int:0', 'type' => 'dimension:3:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        'avatar_max' => array('lang' => 'MAX_AVATAR_SIZE', 'validate' => 'int:0', 'type' => 'dimension:3:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        'avatar_path' => array('lang' => 'AVATAR_STORAGE_PATH', 'validate' => 'rwpath', 'type' => 'text:20:255', 'explain' => true),
                        'avatar_gallery_path' => array('lang' => 'AVATAR_GALLERY_PATH', 'validate' => 'rpath', 'type' => 'text:20:255', 'explain' => true)
                    )
                );
                break;

            case 'message':
                $display_vars = array(
                    'title' => 'ACP_MESSAGE_SETTINGS',
                    'lang' => 'ucp',
                    'vars' => array(
                        'legend1' => 'GENERAL_SETTINGS',
                        'allow_privmsg' => array('lang' => 'BOARD_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'pm_max_boxes' => array('lang' => 'BOXES_MAX', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'pm_max_msgs' => array('lang' => 'BOXES_LIMIT', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'full_folder_action' => array('lang' => 'FULL_FOLDER_ACTION', 'validate' => 'int', 'type' => 'select', 'method' => 'full_folder_select', 'explain' => true),
                        'pm_edit_time' => array('lang' => 'PM_EDIT_TIME', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['MINUTES']),
                        'pm_max_recipients' => array('lang' => 'PM_MAX_RECIPIENTS', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true),
                        'legend2' => 'GENERAL_OPTIONS',
                        'allow_mass_pm' => array('lang' => 'ALLOW_MASS_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'auth_bbcode_pm' => array('lang' => 'ALLOW_BBCODE_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'auth_smilies_pm' => array('lang' => 'ALLOW_SMILIES_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_pm_attach' => array('lang' => 'ALLOW_PM_ATTACHMENTS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_pm' => array('lang' => 'ALLOW_SIG_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'print_pm' => array('lang' => 'ALLOW_PRINT_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'forward_pm' => array('lang' => 'ALLOW_FORWARD_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'auth_img_pm' => array('lang' => 'ALLOW_IMG_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'auth_flash_pm' => array('lang' => 'ALLOW_FLASH_PM', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'enable_pm_icons' => array('lang' => 'ENABLE_PM_ICONS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'legend3' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'post':
                $display_vars = array(
                    'title' => 'ACP_POST_SETTINGS',
                    'vars' => array(
                        'legend1' => 'GENERAL_OPTIONS',
                        'allow_topic_notify' => array('lang' => 'ALLOW_TOPIC_NOTIFY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_forum_notify' => array('lang' => 'ALLOW_FORUM_NOTIFY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_bbcode' => array('lang' => 'ALLOW_BBCODE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_post_flash' => array('lang' => 'ALLOW_POST_FLASH', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_smilies' => array('lang' => 'ALLOW_SMILIES', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_post_links' => array('lang' => 'ALLOW_POST_LINKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_nocensors' => array('lang' => 'ALLOW_NO_CENSORS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_bookmarks' => array('lang' => 'ALLOW_BOOKMARKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'enable_post_confirm' => array('lang' => 'VISUAL_CONFIRM_POST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'allow_quick_reply' => array('lang' => 'ALLOW_QUICK_REPLY', 'validate' => 'bool', 'type' => 'custom', 'method' => 'quick_reply', 'explain' => true),
                        'legend2' => 'POSTING',
                        'bump_type' => false,
                        'edit_time' => array('lang' => 'EDIT_TIME', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['MINUTES']),
                        'delete_time' => array('lang' => 'DELETE_TIME', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['MINUTES']),
                        'display_last_edited' => array('lang' => 'DISPLAY_LAST_EDITED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'flood_interval' => array('lang' => 'FLOOD_INTERVAL', 'validate' => 'int:0', 'type' => 'text:3:10', 'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),
                        'bump_interval' => array('lang' => 'BUMP_INTERVAL', 'validate' => 'int:0', 'type' => 'custom', 'method' => 'bump_interval', 'explain' => true),
                        'topics_per_page' => array('lang' => 'TOPICS_PER_PAGE', 'validate' => 'int:1', 'type' => 'text:3:4', 'explain' => false),
                        'posts_per_page' => array('lang' => 'POSTS_PER_PAGE', 'validate' => 'int:1', 'type' => 'text:3:4', 'explain' => false),
                        'smilies_per_page' => array('lang' => 'SMILIES_PER_PAGE', 'validate' => 'int:1', 'type' => 'text:3:4', 'explain' => false),
                        'hot_threshold' => array('lang' => 'HOT_THRESHOLD', 'validate' => 'int:0', 'type' => 'text:3:4', 'explain' => true),
                        'max_poll_options' => array('lang' => 'MAX_POLL_OPTIONS', 'validate' => 'int:2:127', 'type' => 'text:4:4', 'explain' => false),
                        'max_post_chars' => array('lang' => 'CHAR_LIMIT', 'validate' => 'int:0', 'type' => 'text:4:6', 'explain' => true),
                        'min_post_chars' => array('lang' => 'MIN_CHAR_LIMIT', 'validate' => 'int:1', 'type' => 'text:4:6', 'explain' => true),
                        'max_post_smilies' => array('lang' => 'SMILIES_LIMIT', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'max_post_urls' => array('lang' => 'MAX_POST_URLS', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true),
                        'max_post_font_size' => array('lang' => 'MAX_POST_FONT_SIZE', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' %'),
                        'max_quote_depth' => array('lang' => 'QUOTE_DEPTH_LIMIT', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'max_post_img_width' => array('lang' => 'MAX_POST_IMG_WIDTH', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        'max_post_img_height' => array('lang' => 'MAX_POST_IMG_HEIGHT', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        'legend3' => 'ACP_SUBMIT_CHANGES',
                    )
                );
//-- MOD : AOS Who Visited a Topic - Start -----------------------------------------------//
                include($phpbb_root_path . 'includes/who_visited_a_topic.' . $phpEx);
                aos_display_acp_options($display_vars);
//-- MOD : AOS Who Visited a Topic - End -------------------------------------------------//

                break;

            case 'signature':
                $display_vars = array(
                    'title' => 'ACP_SIGNATURE_SETTINGS',
                    'vars' => array(
                        'legend1' => 'GENERAL_OPTIONS',
                        'allow_sig' => array('lang' => 'ALLOW_SIG', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_bbcode' => array('lang' => 'ALLOW_SIG_BBCODE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_img' => array('lang' => 'ALLOW_SIG_IMG', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_flash' => array('lang' => 'ALLOW_SIG_FLASH', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_smilies' => array('lang' => 'ALLOW_SIG_SMILIES', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_sig_links' => array('lang' => 'ALLOW_SIG_LINKS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'legend2' => 'GENERAL_SETTINGS',
                        'max_sig_chars' => array('lang' => 'MAX_SIG_LENGTH', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true),
                        'max_sig_urls' => array('lang' => 'MAX_SIG_URLS', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true),
                        'max_sig_font_size' => array('lang' => 'MAX_SIG_FONT_SIZE', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' %'),
                        'max_sig_smilies' => array('lang' => 'MAX_SIG_SMILIES', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true),
                        'max_sig_img_width' => array('lang' => 'MAX_SIG_IMG_WIDTH', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        'max_sig_img_height' => array('lang' => 'MAX_SIG_IMG_HEIGHT', 'validate' => 'int:0', 'type' => 'text:5:4', 'explain' => true, 'append' => ' ' . $user->lang['PIXEL']),
                        //archi11 code starts
                        'legend3' => 'EDIT_VARIABLE_SETTINGS',
                        'board_timezone'		=> array('lang' => 'SYSTEM_TIMEZONE',		'validate' => 'string',	'type' => 'select', 'function' => 'tz_select1', 'params' => array('{CONFIG_VALUE}', 1), 'explain' => true),
                        'current_hit' => array('lang' => 'MAX_SIG_VARIABLE_CURRENT_HIT', 'validate' => 'string', 'type' => 'custom', 'method' => 'current_hit', 'explain' => true),
                        'maximum_hit' => array('lang' => 'MAX_SIG_VARIABLE_MAXIMUM_HIT', 'validate' => 'string', 'type' => 'custom', 'method' => 'maximum_hit', 'explain' => true),
                        'change_good_condition' => array('lang' => 'MAX_SIG_VARIABLE_GOOD_CONDITION', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_good_condition', 'explain' => true),
                        'change_bad_condition' => array('lang' => 'MAX_SIG_VARIABLE_BAD_CONDITION', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_bad_condition', 'explain' => true),
                        'change_gear' => array('lang' => 'MAX_SIG_VARIABLE_GEAR', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_gear', 'explain' => true),
                        'change_level' => array('lang' => 'MAX_SIG_VARIABLE_LAVEL', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_level', 'explain' => true),
                        'change_min_level' => array('lang' => 'MAX_SIG_VARIABLE_LAVEL_MIN', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_min_level', 'explain' => true),
                        'change_max_level' => array('lang' => 'MAX_SIG_VARIABLE_LAVEL_MAX', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_max_level', 'explain' => true),
                        'change_min_ability' => array('lang' => 'MAX_SIG_VARIABLE_MIN_ABILITY', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_min_ability', 'explain' => true),
                        'change_max_ability' => array('lang' => 'MAX_SIG_VARIABLE_MAX_ABILITY', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_max_ability', 'explain' => true),
                        'change_gear' => array('lang' => 'MAX_SIG_VARIABLE_GEAR', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_gear', 'explain' => true),
                        'change_spell' => array('lang' => 'MAX_SIG_VARIABLE_SPELL', 'validate' => 'string', 'type' => 'custom', 'method' => 'change_spell', 'explain' => true),
                        'legend4' => 'NEW_VARIABLE_SETTINGS',
                        'new_current_hit' => array('lang' => 'MAX_SIG_NEW_VARIABLE_CURRENT_HIT', 'validate' => '', 'type' => 'text:5:4', 'explain' => true),
                        'new_maximum_hit' => array('lang' => 'MAX_SIG_NEW_VARIABLE_MAXIMUM_HIT', 'validate' => '', 'type' => 'text:5:4', 'explain' => true),
                        'new_good_condition' => array('lang' => 'MAX_SIG_NEW_VARIABLE_GOOD_CONDITION', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_bad_condition' => array('lang' => 'MAX_SIG_NEW_VARIABLE_BAD_CONDITION', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_level' => array('lang' => 'MAX_SIG_NEW_VARIABLE_NEW_LEVEL', 'validate' => '', 'type' => 'text:5:4', 'explain' => true),
                        'new_minimum_level' => array('lang' => 'MAX_SIG_NEW_VARIABLE_NEW_LEVEL_MIN', 'validate' => '', 'type' => 'text:5:4', 'explain' => true),
                        'new_maximum_level' => array('lang' => 'MAX_SIG_NEW_VARIABLE_NEW_LEVEL_MAX', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_minimum_ability' => array('lang' => 'MAX_SIG_NEW_VARIABLE_MINIMUM_ABILITY', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_maximum_ability' => array('lang' => 'MAX_SIG_NEW_VARIABLE_MAXIMUM_ABILITY', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_gear' => array('lang' => 'MAX_SIG_NEW_VARIABLE_GEAR', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
                        'new_spell' => array('lang' => 'MAX_ADD_NEW_SPELL', 'validate' => '', 'type' => 'text:5:15', 'explain' => true),
//                                                'legend5'                      =>'CHANGE_PLAYER_INFORMATION',    
//                                                'change_player_information'		=> array('lang' => 'CHANGE_PLAYER_INFO','validate' => 'string',	'type' => 'custom', 'method' => 'change_player_information', 'explain' => true),
                        'legend6' => 'ACP_SUBMIT_CHANGES',
                    //archi11 code ends
                    )
                );
                break;

            case 'registration':
                $display_vars = array(
                    'title' => 'ACP_REGISTER_SETTINGS',
                    'vars' => array(
                        'legend1' => 'GENERAL_SETTINGS',
                        'max_name_chars' => array('lang' => 'USERNAME_LENGTH', 'validate' => 'int:8:180', 'type' => false, 'method' => false, 'explain' => false,),
                        'max_pass_chars' => array('lang' => 'PASSWORD_LENGTH', 'validate' => 'int:8:255', 'type' => false, 'method' => false, 'explain' => false,),
                        'require_activation' => array('lang' => 'ACC_ACTIVATION', 'validate' => 'int', 'type' => 'select', 'method' => 'select_acc_activation', 'explain' => true),
                        'new_member_post_limit' => array('lang' => 'NEW_MEMBER_POST_LIMIT', 'validate' => 'int:0:255', 'type' => 'text:4:4', 'explain' => true, 'append' => ' ' . $user->lang['POSTS']),
                        'new_member_group_default' => array('lang' => 'NEW_MEMBER_GROUP_DEFAULT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'min_name_chars' => array('lang' => 'USERNAME_LENGTH', 'validate' => 'int:1', 'type' => 'custom:5:180', 'method' => 'username_length', 'explain' => true),
                        'min_pass_chars' => array('lang' => 'PASSWORD_LENGTH', 'validate' => 'int:1', 'type' => 'custom', 'method' => 'password_length', 'explain' => true),
                        'allow_name_chars' => array('lang' => 'USERNAME_CHARS', 'validate' => 'string', 'type' => 'select', 'method' => 'select_username_chars', 'explain' => true),
                        'pass_complex' => array('lang' => 'PASSWORD_TYPE', 'validate' => 'string', 'type' => 'select', 'method' => 'select_password_chars', 'explain' => true),
                        'chg_passforce' => array('lang' => 'FORCE_PASS_CHANGE', 'validate' => 'int:0', 'type' => 'text:3:3', 'explain' => true, 'append' => ' ' . $user->lang['DAYS']),
                        'legend2' => 'GENERAL_OPTIONS',
                        'allow_namechange' => array('lang' => 'ALLOW_NAME_CHANGE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'allow_emailreuse' => array('lang' => 'ALLOW_EMAIL_REUSE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'enable_confirm' => array('lang' => 'VISUAL_CONFIRM_REG', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'max_login_attempts' => array('lang' => 'MAX_LOGIN_ATTEMPTS', 'validate' => 'int:0', 'type' => 'text:3:3', 'explain' => true),
                        'max_reg_attempts' => array('lang' => 'REG_LIMIT', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'legend3' => 'COPPA',
                        'coppa_enable' => array('lang' => 'ENABLE_COPPA', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'coppa_mail' => array('lang' => 'COPPA_MAIL', 'validate' => 'string', 'type' => 'textarea:5:40', 'explain' => true),
                        'coppa_fax' => array('lang' => 'COPPA_FAX', 'validate' => 'string', 'type' => 'text:25:100', 'explain' => false),
                        'legend4' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'feed':
                $display_vars = array(
                    'title' => 'ACP_FEED_MANAGEMENT',
                    'vars' => array(
                        'legend1' => 'ACP_FEED_GENERAL',
                        'feed_enable' => array('lang' => 'ACP_FEED_ENABLE', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_item_statistics' => array('lang' => 'ACP_FEED_ITEM_STATISTICS', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_http_auth' => array('lang' => 'ACP_FEED_HTTP_AUTH', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'legend2' => 'ACP_FEED_POST_BASED',
                        'feed_limit_post' => array('lang' => 'ACP_FEED_LIMIT', 'validate' => 'int:5', 'type' => 'text:3:4', 'explain' => true),
                        'feed_overall' => array('lang' => 'ACP_FEED_OVERALL', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_forum' => array('lang' => 'ACP_FEED_FORUM', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_topic' => array('lang' => 'ACP_FEED_TOPIC', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'legend3' => 'ACP_FEED_TOPIC_BASED',
                        'feed_limit_topic' => array('lang' => 'ACP_FEED_LIMIT', 'validate' => 'int:5', 'type' => 'text:3:4', 'explain' => true),
                        'feed_topics_new' => array('lang' => 'ACP_FEED_TOPICS_NEW', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_topics_active' => array('lang' => 'ACP_FEED_TOPICS_ACTIVE', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_news_id' => array('lang' => 'ACP_FEED_NEWS', 'validate' => 'string', 'type' => 'custom', 'method' => 'select_news_forums', 'explain' => true),
                        'legend4' => 'ACP_FEED_SETTINGS_OTHER',
                        'feed_overall_forums' => array('lang' => 'ACP_FEED_OVERALL_FORUMS', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'feed_exclude_id' => array('lang' => 'ACP_FEED_EXCLUDE_ID', 'validate' => 'string', 'type' => 'custom', 'method' => 'select_exclude_forums', 'explain' => true),
                    )
                );
                break;

            case 'cookie':
                $display_vars = array(
                    'title' => 'ACP_COOKIE_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_COOKIE_SETTINGS',
                        'cookie_domain' => array('lang' => 'COOKIE_DOMAIN', 'validate' => 'string', 'type' => 'text::255', 'explain' => false),
                        'cookie_name' => array('lang' => 'COOKIE_NAME', 'validate' => 'string', 'type' => 'text::16', 'explain' => false),
                        'cookie_path' => array('lang' => 'COOKIE_PATH', 'validate' => 'string', 'type' => 'text::255', 'explain' => false),
                        'cookie_secure' => array('lang' => 'COOKIE_SECURE', 'validate' => 'bool', 'type' => 'radio:disabled_enabled', 'explain' => true)
                    )
                );
                break;

            case 'load':
                $display_vars = array(
                    'title' => 'ACP_LOAD_SETTINGS',
                    'vars' => array(
                        'legend1' => 'GENERAL_SETTINGS',
                        'limit_load' => array('lang' => 'LIMIT_LOAD', 'validate' => 'string', 'type' => 'text:4:4', 'explain' => true),
                        'session_length' => array('lang' => 'SESSION_LENGTH', 'validate' => 'int:60', 'type' => 'text:5:10', 'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),
                        'active_sessions' => array('lang' => 'LIMIT_SESSIONS', 'validate' => 'int:0', 'type' => 'text:4:4', 'explain' => true),
                        'load_online_time' => array('lang' => 'ONLINE_LENGTH', 'validate' => 'int:0', 'type' => 'text:4:3', 'explain' => true, 'append' => ' ' . $user->lang['MINUTES']),
                        'legend2' => 'GENERAL_OPTIONS',
                        'load_db_track' => array('lang' => 'YES_POST_MARKING', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_db_lastread' => array('lang' => 'YES_READ_MARKING', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_anon_lastread' => array('lang' => 'YES_ANON_READ_MARKING', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_online' => array('lang' => 'YES_ONLINE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_online_guests' => array('lang' => 'YES_ONLINE_GUESTS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_onlinetrack' => array('lang' => 'YES_ONLINE_TRACK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_birthdays' => array('lang' => 'YES_BIRTHDAYS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_unreads_search' => array('lang' => 'YES_UNREAD_SEARCH', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_moderators' => array('lang' => 'YES_MODERATORS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_jumpbox' => array('lang' => 'YES_JUMPBOX', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_user_activity' => array('lang' => 'LOAD_USER_ACTIVITY', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'load_tplcompile' => array('lang' => 'RECOMPILE_STYLES', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'legend3' => 'CUSTOM_PROFILE_FIELDS',
                        'load_cpf_memberlist' => array('lang' => 'LOAD_CPF_MEMBERLIST', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_cpf_viewprofile' => array('lang' => 'LOAD_CPF_VIEWPROFILE', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'load_cpf_viewtopic' => array('lang' => 'LOAD_CPF_VIEWTOPIC', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false),
                        'legend4' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'auth':
                $display_vars = array(
                    'title' => 'ACP_AUTH_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_AUTH_SETTINGS',
                        'auth_method' => array('lang' => 'AUTH_METHOD', 'validate' => 'string', 'type' => 'select', 'method' => 'select_auth_method', 'explain' => false)
                    )
                );
                break;

            case 'server':
                $display_vars = array(
                    'title' => 'ACP_SERVER_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_SERVER_SETTINGS',
                        'gzip_compress' => array('lang' => 'ENABLE_GZIP', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'legend2' => 'PATH_SETTINGS',
                        'smilies_path' => array('lang' => 'SMILIES_PATH', 'validate' => 'rpath', 'type' => 'text:20:255', 'explain' => true),
                        'icons_path' => array('lang' => 'ICONS_PATH', 'validate' => 'rpath', 'type' => 'text:20:255', 'explain' => true),
                        'upload_icons_path' => array('lang' => 'UPLOAD_ICONS_PATH', 'validate' => 'rpath', 'type' => 'text:20:255', 'explain' => true),
                        'ranks_path' => array('lang' => 'RANKS_PATH', 'validate' => 'rpath', 'type' => 'text:20:255', 'explain' => true),
                        'legend3' => 'SERVER_URL_SETTINGS',
                        'force_server_vars' => array('lang' => 'FORCE_SERVER_VARS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'server_protocol' => array('lang' => 'SERVER_PROTOCOL', 'validate' => 'string', 'type' => 'text:10:10', 'explain' => true),
                        'server_name' => array('lang' => 'SERVER_NAME', 'validate' => 'string', 'type' => 'text:40:255', 'explain' => true),
                        'server_port' => array('lang' => 'SERVER_PORT', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true),
                        'script_path' => array('lang' => 'SCRIPT_PATH', 'validate' => 'script_path', 'type' => 'text::255', 'explain' => true),
                        'legend4' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            case 'security':
                $display_vars = array(
                    'title' => 'ACP_SECURITY_SETTINGS',
                    'vars' => array(
                        'legend1' => 'ACP_SECURITY_SETTINGS',
                        'allow_autologin' => array('lang' => 'ALLOW_AUTOLOGIN', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'max_autologin_time' => array('lang' => 'AUTOLOGIN_LENGTH', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['DAYS']),
                        'ip_check' => array('lang' => 'IP_VALID', 'validate' => 'int', 'type' => 'custom', 'method' => 'select_ip_check', 'explain' => true),
                        'browser_check' => array('lang' => 'BROWSER_VALID', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'forwarded_for_check' => array('lang' => 'FORWARDED_FOR_VALID', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'referer_validation' => array('lang' => 'REFERER_VALID', 'validate' => 'int:0:3', 'type' => 'custom', 'method' => 'select_ref_check', 'explain' => true),
                        'check_dnsbl' => array('lang' => 'CHECK_DNSBL', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'email_check_mx' => array('lang' => 'EMAIL_CHECK_MX', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'max_pass_chars' => array('lang' => 'PASSWORD_LENGTH', 'validate' => 'int:8:255', 'type' => false, 'method' => false, 'explain' => false,),
                        'min_pass_chars' => array('lang' => 'PASSWORD_LENGTH', 'validate' => 'int:1', 'type' => 'custom', 'method' => 'password_length', 'explain' => true),
                        'pass_complex' => array('lang' => 'PASSWORD_TYPE', 'validate' => 'string', 'type' => 'select', 'method' => 'select_password_chars', 'explain' => true),
                        'chg_passforce' => array('lang' => 'FORCE_PASS_CHANGE', 'validate' => 'int:0', 'type' => 'text:3:3', 'explain' => true, 'append' => ' ' . $user->lang['DAYS']),
                        'max_login_attempts' => array('lang' => 'MAX_LOGIN_ATTEMPTS', 'validate' => 'int:0', 'type' => 'text:3:3', 'explain' => true),
                        'ip_login_limit_max' => array('lang' => 'IP_LOGIN_LIMIT_MAX', 'validate' => 'int:0', 'type' => 'text:3:3', 'explain' => true),
                        'ip_login_limit_time' => array('lang' => 'IP_LOGIN_LIMIT_TIME', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),
                        'ip_login_limit_use_forwarded' => array('lang' => 'IP_LOGIN_LIMIT_USE_FORWARDED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'tpl_allow_php' => array('lang' => 'TPL_ALLOW_PHP', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'form_token_lifetime' => array('lang' => 'FORM_TIME_MAX', 'validate' => 'int:-1', 'type' => 'text:5:5', 'explain' => true, 'append' => ' ' . $user->lang['SECONDS']),
                        'form_token_sid_guests' => array('lang' => 'FORM_SID_GUESTS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                    )
                );
                break;

            case 'email':
                $display_vars = array(
                    'title' => 'ACP_EMAIL_SETTINGS',
                    'vars' => array(
                        'legend1' => 'GENERAL_SETTINGS',
                        'email_enable' => array('lang' => 'ENABLE_EMAIL', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'board_email_form' => array('lang' => 'BOARD_EMAIL_FORM', 'validate' => 'bool', 'type' => 'radio:enabled_disabled', 'explain' => true),
                        'email_function_name' => array('lang' => 'EMAIL_FUNCTION_NAME', 'validate' => 'string', 'type' => 'text:20:50', 'explain' => true),
                        'email_package_size' => array('lang' => 'EMAIL_PACKAGE_SIZE', 'validate' => 'int:0', 'type' => 'text:5:5', 'explain' => true),
                        'board_contact' => array('lang' => 'CONTACT_EMAIL', 'validate' => 'email', 'type' => 'text:25:100', 'explain' => true),
                        'board_email' => array('lang' => 'ADMIN_EMAIL', 'validate' => 'email', 'type' => 'text:25:100', 'explain' => true),
                        'board_email_sig' => array('lang' => 'EMAIL_SIG', 'validate' => 'string', 'type' => 'textarea:5:30', 'explain' => true),
                        'board_hide_emails' => array('lang' => 'BOARD_HIDE_EMAILS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'legend2' => 'SMTP_SETTINGS',
                        'smtp_delivery' => array('lang' => 'USE_SMTP', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true),
                        'smtp_host' => array('lang' => 'SMTP_SERVER', 'validate' => 'string', 'type' => 'text:25:50', 'explain' => false),
                        'smtp_port' => array('lang' => 'SMTP_PORT', 'validate' => 'int:0', 'type' => 'text:4:5', 'explain' => true),
                        'smtp_auth_method' => array('lang' => 'SMTP_AUTH_METHOD', 'validate' => 'string', 'type' => 'select', 'method' => 'mail_auth_select', 'explain' => true),
                        'smtp_username' => array('lang' => 'SMTP_USERNAME', 'validate' => 'string', 'type' => 'text:25:255', 'explain' => true),
                        'smtp_password' => array('lang' => 'SMTP_PASSWORD', 'validate' => 'string', 'type' => 'password:25:255', 'explain' => true),
                        'legend3' => 'ACP_SUBMIT_CHANGES',
                    )
                );
                break;

            default:
                trigger_error('NO_MODE', E_USER_ERROR);
                break;
        }

        if (isset($display_vars['lang'])) {
            $user->add_lang($display_vars['lang']);
        }

        $this->new_config = $config;
        //$cfg_array = (isset(request_var('config',''))) ? utf8_normalize_nfc(request_var('config',''), array('' => ''), true)) : $this->new_config;
        $error = array();

        // We validate the complete config if whished
        validate_config_vars($display_vars['vars'], $cfg_array, $error);

        if ($submit && !check_form_key($form_key)) {
            $error[] = $user->lang['FORM_INVALID'];
        }
        // Do not write values if there is an error
        if (sizeof($error)) {
            $submit = false;
        }

        $cout = 1;
        // We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
        foreach ($display_vars['vars'] as $config_name => $null) {
            if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false) {
                continue;
            }

            if ($config_name == 'auth_method' || $config_name == 'feed_news_id' || $config_name == 'feed_exclude_id') {
                continue;
            }

            $this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

            if ($config_name == 'email_function_name') {
                $this->new_config['email_function_name'] = trim(str_replace(array('(', ')'), array('', ''), $this->new_config['email_function_name']));
                $this->new_config['email_function_name'] = (empty($this->new_config['email_function_name']) || !function_exists($this->new_config['email_function_name'])) ? 'mail' : $this->new_config['email_function_name'];
                $config_value = $this->new_config['email_function_name'];
            }

            if ($submit) {

                set_config($config_name, $config_value);

                if ($cout == 1) {


                    set_for_new_variables();
                    set_good_bad_new_condition();
                    set_new_level_ability();

                    set_config_for_change_variables();
                    set_chnage_good_bad_condition();
                    set_chnage_levels();
                    set_chnage_ability();
                    set_chnage_gear();
                    set_chnage_spell();

                    $cout ++;
                }
                if ($config_name == 'allow_quick_reply' && isset($_POST['allow_quick_reply_enable'])) {
                    enable_bitfield_column_flag(FORUMS_TABLE, 'forum_flags', log(FORUM_FLAG_QUICK_REPLY, 2));
                }
            }
        }

        // Store news and exclude ids
        if ($mode == 'feed' && $submit) {
            $cache->destroy('_feed_news_forum_ids');
            $cache->destroy('_feed_excluded_forum_ids');

            $this->store_feed_forums(FORUM_OPTION_FEED_NEWS, 'feed_news_id');
            $this->store_feed_forums(FORUM_OPTION_FEED_EXCLUDE, 'feed_exclude_id');
        }

        if ($mode == 'auth') {
            // Retrieve a list of auth plugins and check their config values
            $auth_plugins = array();

            $dp = @opendir($phpbb_root_path . 'includes/auth');

            if ($dp) {
                while (($file = readdir($dp)) !== false) {
                    if (preg_match('#^auth_(.*?)\.' . $phpEx . '$#', $file)) {
                        $auth_plugins[] = basename(preg_replace('#^auth_(.*?)\.' . $phpEx . '$#', '\1', $file));
                    }
                }
                closedir($dp);

                sort($auth_plugins);
            }

            $updated_auth_settings = false;
            $old_auth_config = array();
            foreach ($auth_plugins as $method) {
                if ($method && file_exists($phpbb_root_path . 'includes/auth/auth_' . $method . '.' . $phpEx)) {
                    include_once($phpbb_root_path . 'includes/auth/auth_' . $method . '.' . $phpEx);

                    $method = 'acp_' . $method;
                    if (function_exists($method)) {
                        if ($fields = $method($this->new_config)) {
                            // Check if we need to create config fields for this plugin and save config when submit was pressed
                            foreach ($fields['config'] as $field) {
                                if (!isset($config[$field])) {
                                    set_config($field, '');
                                }

                                if (!isset($cfg_array[$field]) || strpos($field, 'legend') !== false) {
                                    continue;
                                }

                                $old_auth_config[$field] = $this->new_config[$field];
                                $config_value = $cfg_array[$field];
                                $this->new_config[$field] = $config_value;

                                if ($submit) {
                                    $updated_auth_settings = true;
                                    set_config($field, $config_value);
                                }
                            }
                        }
                        unset($fields);
                    }
                }
            }

            if ($submit && (($cfg_array['auth_method'] != $this->new_config['auth_method']) || $updated_auth_settings)) {
                $method = basename($cfg_array['auth_method']);
                if ($method && in_array($method, $auth_plugins)) {
                    include_once($phpbb_root_path . 'includes/auth/auth_' . $method . '.' . $phpEx);

                    $method = 'init_' . $method;
                    if (function_exists($method)) {
                        if ($error = $method()) {
                            foreach ($old_auth_config as $config_name => $config_value) {
                                set_config($config_name, $config_value);
                            }
                            trigger_error($error . adm_back_link($this->u_action), E_USER_WARNING);
                        }
                    }
                    set_config('auth_method', basename($cfg_array['auth_method']));
                } else {
                    trigger_error('NO_AUTH_PLUGIN', E_USER_ERROR);
                }
            }
        }

        if ($submit) {
            add_log('admin', 'LOG_CONFIG_' . strtoupper($mode));

            trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
        }

        $this->tpl_name = 'acp_board';
        $this->page_title = $display_vars['title'];

        //archi11 code starts :)

        global $user;
        global $db;

        $select_variables = "SELECT * from " . USER_VARIABLES_TABLE . " INNER JOIN " . USERS_TABLE . " ON " . USER_VARIABLES_TABLE . ".user_id = " . USERS_TABLE . ".user_id GROUP BY phpbb_user_variable.user_id ";
        $result1 = $db->sql_query($select_variables);
        $variable = '';
        $count = 0;

        $table = '<table><tr><th>Player Name</th><th>Player Information</th><th>Edit</th></tr>';
        $tableend = '</table>';
        while ($row = $db->sql_fetchrow($result1)) {
            $id = $row['id'];
            $player_id = $row['user_id'];
            $player_name = $row['username'];
            $image = $row['user_avatar'];

            $img = '';
            if ($image) {
                $img = "<img src='./download/file.php?avatar=" . $image . "' height=34px>";
            }

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
            if (count($sbc) > 1) {
                $seleted_bad_condition = '';
                for ($bc = 0; $bc < count($sbc); $bc++) {
                    if ($bc != (count($sbc) - 1)) {
                        $seleted_bad_condition .=$sbc[$bc] . ",&nbsp;";
                    } else {
                        $seleted_bad_condition .=$sbc[$bc];
                    }
                }
            } elseif (count($sbc) == 1) {
                $seleted_bad_condition .=$sbc[0];
            } elseif ($sbc == null) {
                $seleted_bad_condition = '';
            }

            //seleted good condition       
            if (count($sgc) > 1) {
                $seleted_good_condition = '';
                for ($gc = 0; $gc < count($sgc); $gc++) {
                    if ($gc != (count($sgc) - 1)) {
                        $seleted_good_condition .=$sgc[$gc] . ",&nbsp;";
                    } else {
                        $seleted_good_condition .=$sgc[$gc];
                    }
                }
            } elseif (count($sgc) == 1) {
                $seleted_good_condition .=$sgc[0];
            } elseif ($sgc == null) {
                $seleted_good_condition = '';
            }
            if ($seleted_good_condition or ( $seleted_good_condition == '') or $seleted_bad_condition or ( $seleted_bad_condition == '')) {
                if (!($seleted_good_condition == '') or ! ($seleted_bad_condition == ''))
                    $con = '[';
                if ($seleted_good_condition or ( $seleted_good_condition == '')) {
                    $con .='<font color="#0070CA ">' . $seleted_good_condition . '</font>';
                }
                if (!($seleted_good_condition == '') and ! ($seleted_bad_condition == '')) {
                    $con .=',&nbsp;';
                }
                if ($seleted_bad_condition or ( $seleted_bad_condition == '')) {
                    $con.='<font color="#FF0000 ">' . $seleted_bad_condition . '</font>';
                    if (!($seleted_good_condition == '') or ! ($seleted_bad_condition == ''))
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
                $lvls = '';
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
            $variable .= '<tr><td><font color="#0658B0" size=3px>' . $row['username'] . '</font></td><td>: ' . $brh . $con . $lvls . $ablity . '</td><td><a href=./index.php?sid=' . request_var('sid','') . '&i=board&mode=signature&player=' . $player_id . '&id=' . $id . '&playername=' . $player_name . '><img title="Edit" alt="Edit" src="./images/icon_edit.gif"></a></td></tr>';
            unset($ability);
            unset($con);
            unset($brh);
            unset($lvls);
        }
        $variabls = $table . $variable . $tableend;
        $tableid = request_var('id','');
        if (request_var('player','')) {
            $players_id = request_var('player','');
            $player_name = request_var('playername','');
            $tableid = request_var('id','');

            $s = "SELECT * from " . USER_VARIABLES_TABLE . " where user_id=" . $players_id . " and id=" . $tableid;
            $result_post_data = $db->sql_query($s);

            while ($row = $db->sql_fetchrow($result_post_data)) {
                $selected_current_hit = $row['selected_current_hit'];
                $selected_maximum_hit = $row['selected_maximum_hit'];
                $seleted_non_lethal = $row['seleted_non_lethal'];
                $seleted_bad_condition = $row['seleted_bad_condition'];
                $seleted_good_condition = $row['seleted_good_condition'];
                $levels = $row['level'];
                $levels_min = $row['level_min'];
                $levels_max = $row['level_max'];
                $ability_namey = $row['ability_name'];
                $min_abilityy = $row['min_ability'];
                $max_abilityy = $row['max_ability'];
                $seleted_gear = $row['gear'];
                $heropoint = $row['hero_point'];
                $quick_stats = $row['quick_stats'];
                $quick_skill = $row['quick_skill'];

                $attack = $row['attack'];
                $damage = $row['damage'];
                $critical_multiplier = $row['critical_multiplier'];
                $off_range = $row['off_range'];
                $type = $row['type'];
                $weapon_name = $row['weapon_name'];
                $user_spell = $row['spell'];
            }

            $select_hit = "SELECT * from " . VARIABLES_TABLE;
            $result1 = $db->sql_query($select_hit);
            $variables = array();
            while ($row = $db->sql_fetchrow($result1)) {

                $hit_current = $row['current'];
                $hit_maximum = $row['maximum'];

                $negative_condition = $row['negative_condition'];
                $positive_condition = $row['positive_condition'];

                $level = $row['level'];
                $level_min = $row['level_min'];
                $level_max = $row['level_max'];


                $min_ability = $row['min_ability'];
                $max_ability = $row['max_ability'];

                $gear = $row['gear'];

                $non_lethal = $row['non_lethal'];
                $hero_points = $row['hero_point'];
                $quick_skill1 = $row['quick_skill'];
                $spells = $row['spell'];
            }
            $hit_current_data = json_decode($hit_current, true);
            $hit_maximum_data = json_decode($hit_maximum, true);
            sort($hit_current_data);
            sort($hit_maximum_data);


            $hit_current_data_count = count($hit_current_data);
            $hit_maximum_data_count = count($hit_maximum_data);

            $negative_condition_data1 = json_decode($negative_condition, true);
            $positive_condition_data1 = json_decode($positive_condition, true);
            $negative_condition_data = array_map('ucfirst', $negative_condition_data1);
            $positive_condition_data = array_map('ucfirst', $positive_condition_data1);

            sort($negative_condition_data);
            sort($positive_condition_data);

            $negative_condition_data_count = count($negative_condition_data);
            $positive_condition_data_count = count($positive_condition_data);

            $level_data = json_decode($level, true);
            sort($level_data);
            $level_count = count($level_data);

            $level_min_data = json_decode($level_min, true);
            sort($level_min_data);
            $level_min_data_count = count($level_min_data);

            $level_max_data = json_decode($level_max, true);
            sort($level_max_data);
            $level_max_data_count = count($level_max_data);


            $min_ability_data = json_decode($min_ability, true);
            sort($min_ability_data);
            $min_ability_data_count = count($min_ability_data);

            $max_ability_data = json_decode($max_ability, true);
            sort($max_ability_data);
            $max_ability_data_count = count($max_ability_data);

            $gear_data1 = json_decode($gear, true);
            $gear_data = array_map('ucfirst', $gear_data1);
            sort($gear_data);

            $gear_data_count = count($gear_data);

            $non_lethal_data = json_decode($non_lethal, true);
            sort($non_lethal_data);
            $non_lethal_data_count = count($non_lethal_data);

            $quick_s1 = json_decode($quick_skill1, true);
            $quick_skill_data = @array_map('ucfirst', $quick_s1);
            @sort($quick_skill_data);

            $quick_skill_data_count = count($quick_skill_data);

            $quick_skill_varr = json_decode($quick_skill, true);
            $quick_skill_var = @array_map('ucfirst', $quick_skill_varr);

            $s_quick_skill_data = '';
            $sel_skill = array();
            $sel_skill_val = array();
            for ($ss = 0; $ss < count($quick_skill_var); $ss++) {
                $exp = explode('(', $quick_skill_var[$ss]);
                $sel_skill[] = $exp[0];
                $sel_skill_val[] = $exp[1];
            }

            $increment = 0;

            $arr_merge = @array_merge($quick_skill_data, $sel_skill);
            $unique = @array_unique($arr_merge);
            $values = @array_values($unique);
            $ar = array();
            $ar = @array_diff($values, $sel_skill);

            for ($gg = 0; $gg < count($values); $gg++) {
                if ($ar) {
                    foreach ($ar as $key => $val) {
                        if ($values[$gg] == $val) {
                            $selected = 'deselected="deselected"';
                            break;
                        }
                    }
                }
                foreach ($sel_skill as $key => $val) {
                    if ($val == $values[$gg]) {
                        if ($sel_skill_val[$increment] != '') {
                            $value1 = $val . '(' . $sel_skill_val[$increment];
                        } else {
                            $value1 = $val;
                        }
                        $increment++;
                        $values[$gg] = $value1;
                        $selected = 'selected="selected"';
                        break;
                    }
                }

                $s_quick_skill_data .= "<option value=\"$values[$gg]\" $selected >$values[$gg]</option>";
                unset($value1);
            }



            $selected;
            $s_hit_current_data = '';
            for ($i = 0; $i < $hit_current_data_count; $i++) {

                if ($hit_current_data[$i] == $selected_current_hit) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $s_hit_current_data .= "<option value=\"$hit_current_data[$i]\" $selected >$hit_current_data[$i]</option>";
            }


            $s_hit_maximum_data = '';

            for ($i = 0; $i < $hit_maximum_data_count; $i++) {

                if ($hit_maximum_data[$i] == $selected_maximum_hit) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                $s_hit_maximum_data .= "<option value=\"$hit_maximum_data[$i]\"$selected>$hit_maximum_data[$i]</option>";
            }
            $s_non_lethal_data = '';
            for ($i = 0; $i < $non_lethal_data_count; $i++) {

                if ($non_lethal_data[$i] == $seleted_non_lethal) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                $s_non_lethal_data .= "<option value=\"$non_lethal_data[$i]\"$selected>$non_lethal_data[$i]</option>";
            }

            $hero_points_data = json_decode($hero_points, true);
            @sort($hero_points_data);

            $s_hero_points_data = '';
            for ($hr = 0; $hr < count($hero_points_data); $hr++) {
                if ($hero_points_data[$hr] == $heropoint) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }

                $s_hero_points_data .= "<option value=\"$hero_points_data[$hr]\" $selected >$hero_points_data[$hr]</option>";
            }
            $s_critical_multiplier = "<select name='critical_multiplier'  id='critical_multiplier'>";

            for ($hr = 1; $hr <= 5; $hr++) {
                if ($hr == $critical_multiplier) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
                $s_critical_multiplier .= '<option value="' . $hr . '"  ' . $selected . '>' . $hr . '</option>';
            }
            $s_critical_multiplier .="</select>";

            $array_type = array('B', 'P', 'S', 'M');
            $types = json_decode($type, true);
            if ($types != '') {
                sort($types);

                $s_type = '';

                for ($tp = 0; $tp < count($array_type); $tp++) {
                    $selected = '';

                    foreach ($types as $key => $val) {
                        if ($val == $array_type[$tp]) {
                            $selected = 'selected="selected"';
                            break;
                        } else {
                            $selected = '';
                        }
                    }
                    $s_type .= "<option value=\"$array_type[$tp]\" $selected >$array_type[$tp]</option>";
                }
            }

            $s_weapon_name = '';
            $weapon_names = json_decode($weapon_name, true);
            for ($wp = 0; $wp < count($weapon_names); $wp++) {
                $s_weapon_name .= '<option value="' . $weapon_names[$wp] . '"  ' . $selected . '>' . $weapon_names[$wp] . '</option>';
            }

            $bad_condition = json_decode($seleted_bad_condition, true);
            $s_negative_condition_data = '';

            for ($i = 0; $i < $negative_condition_data_count; $i++) {

                if ($bad_condition) {
                    foreach ($bad_condition as $key => $val) {
                        if ($negative_condition_data[$i] == $val) {
                            $selected = 'selected="selected"';
                            break;
                        } else {
                            $selected = '';
                        }
                    }
                }

                $s_negative_condition_data .= "<option value=\"$negative_condition_data[$i]\" $selected >$negative_condition_data[$i]</option>";
            }

            $good_condition = json_decode($seleted_good_condition, true);
            $s_positive_condition_data = '';

            for ($i = 0; $i < $positive_condition_data_count; $i++) {


                if ($good_condition) {
                    foreach ($good_condition as $key => $val) {
                        if ($positive_condition_data[$i] == $val) {
                            $selected = 'selected="selected"';
                            break;
                        } else {
                            $selected = '';
                        }
                    }
                }

                $s_positive_condition_data .= "<option value=\"$positive_condition_data[$i]\"$selected>$positive_condition_data[$i]</option>";
            }
            $levelss = json_decode($levels, true);
            $s_level_data = '';
            for ($i = 0; $i < $level_count; $i++) {
                //if (request_var('mode'] == 'edit') {
                if (count($levelss) == 1) {
                    $variable_level = 'yes';
                    if ($level_data[$i] == $levelss[0]) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = '';
                    }
                }
                $s_level_data .= "<option value=\"$level_data[$i]\"$selected>$level_data[$i]</option>";
            }

            $user_spell1 = json_decode($user_spell, true);
            $splct = count($user_spell1);
            $levels1 = json_decode($levels, true);
            $spells1 = json_decode($spells, true);
            $spl_count = 0;


            $spell_options = array();
            $arr = @array_unique($levels1);
            $sel = array();
            if ($arr) {
                foreach ($arr as $key => $val) {
                    $spell_options_create = '';

                    if (@key_exists($val, $user_spell1)) {
                        $all_spell = @array_values(array_unique(array_merge($user_spell1[$val]['name'], $spells1)));

                        for ($spl = 0; $spl < count($all_spell); $spl++) {

                            foreach ($user_spell1[$val]['name'] as $k => $v) {

                                if ($all_spell[$spl] == $v) {
                                    $selected = 'selected="selected"';
                                    break;
                                } else {
                                    $selected = '';
                                }
                            }

                            $spell_options_create .= "<option " . $selected . ">" . $all_spell[$spl] . "</option>";
                        }
                        if ($spl_count == 0) {
                            $sel[$val] = "<select name='spell_level[]' multiple>" . $spell_options_create . "</select>";
                        } else {
                            $sel[$val] = "<select name='spell_level" . $spl_count . "[]' multiple>" . $spell_options_create . "</select>";
                        }
                        $spl_count ++;
                    } else {
                        for ($spl = 0; $spl < count($spells1); $spl++) {
                            $spell_options_create .= "<option>" . $spells1[$spl] . "</option>";
                        }

                        if ($spl_count == 0) {
                            $sel[$val] = "<select name='spell_level[]' multiple>" . $spell_options_create . "</select>";
                        } else {
                            $sel[$val] = "<select name='spell_level" . $spl_count . "[]' multiple>" . $spell_options_create . "</select>";
                        }
                        $spl_count ++;
                    }
                }
            }



            $selectbox_level = '';
            if (count($levelss) > 1) {
                $increment_variable_spell = '<input type="hidden" name="increment_variable_spell" id="increment_variable_spell" value="' . count($levelss) . '">';
                $variable_level = 'no';
                for ($j = 0; $j < count($levelss); $j++) {

                    $selectstart = '';
                    $selectends = '';
                    $select = '';
                    $s_level_data_all_options = '';

                    if ($j == 0) {
                        $lvl = '';
                    } else {
                        $lvl = $j;
                    }
                    $selectstart .= 'Level : <select name="select_level' . $lvl . '" id="select_level' . $lvl . '" style="width:5em;">';

                    for ($i = 0; $i < $level_count; $i++) {
                        if ($level_data[$i] == $levelss[$j]) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $s_level_data_all_options .= "<option value=\"$level_data[$i]\" $selected >$level_data[$i]</option>";
                    }
                    $selectends .= '</select>';
                    if ($j != (count($levelss) - 1)) {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "<br><br>";
                    } else {
                        $select .= $selectstart . $s_level_data_all_options . $selectends;
                    }
                    //if ($user_spell != null) {
                    foreach ($sel as $kespel => $valspell) {

                        if ($levelss[$j] == $kespel) {
                            $box = $valspell;
                            break;
                        } else {
                            $box = '';
                        }
                    }
                    //}
                    $selectbox_level .= "&nbsp;&nbsp;" . $box . "&nbsp;&nbsp;" . $select;
                }
            }
            $sel_count = count($sel);
            if ($sel_count > 1) {
                $spell_variable = 'no';
            } elseif ($sel_count == 1) {
                $spell_variable = 'yes';
                $spell_one = $sel[0];
            }

            $levelss_min = json_decode($levels_min, true);
            $s_level_min_select_box = '';
            for ($i = 0; $i < $level_min_data_count; $i++) {
                //if (request_var('mode'] == 'edit') {
                if (count($levelss_min) == 1) {
                    if ($level_min_data[$i] == $levelss_min[0]) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = '';
                    }
                }
                $s_level_min_data .= "<option value=\"$level_min_data[$i]\"$selected>$level_min_data[$i]</option>";
            }
            $selectbox_level_min = '';
            if (count($levelss_min) > 1) {

                for ($j = 0; $j < count($levelss_min); $j++) {
                    $selectstart = '';
                    $selectends = '';
                    $select = '';
                    $s_level_data_all_options = '';
                    if ($j == 0) {
                        $lvl = '';
                    } else {
                        $lvl = $j;
                    }

                    $selectstart .= '&nbsp&nbsp Current/Max  : <select name="select_level_min' . $lvl . '" id="select_level_min' . $lvl . '" style="width:5em;">';

                    for ($i = 0; $i < $level_min_data_count; $i++) {
                        if ($level_min_data[$i] == $levelss_min[$j]) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $s_level_data_all_options .= "<option value=\"$level_min_data[$i]\" $selected >$level_min_data[$i]</option>";
                    }
                    $selectends .= '</select>';
                    if ($j != (count($levelss_min) - 1)) {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "/" . "<br><br><br><br><br>";
                    } else {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "/";
                    }

                    $selectbox_level_min .= $select;
                }
            }

            $levelss_max = json_decode($levels_max, true);
            $s_level_max_data = '';
            for ($i = 0; $i < $level_max_data_count; $i++) {

                if (count($levelss_max) == 1) {
                    if ($level_max_data[$i] == $levelss_max[0]) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = '';
                    }
                }
                $s_level_max_data .= "<option value=\"$level_max_data[$i]\"$selected>$level_max_data[$i]</option>";
            }
            $s_level_max_data .= "<option value=\"$level_max_data[$i]\"$selected>$level_max_data[$i]</option>";
            $delete_last_level_ability = $post_id . '_' . $user->data["user_id"] . '_' . '0';

            $selectbox_level_max = '';
            $button_level = '';
            if (count($levelss_min) > 1) {

                for ($j = 0; $j < count($levelss_max); $j++) {
                    $selectstart = '';
                    $selectends = '';
                    $select = '';

                    $s_level_data_all_options = '';
                    if ($j == 0) {
                        $lvl = '';
                    } else {
                        $lvl = $j;
                    }

                    $selectstart .= '<select name="select_level_max' . $lvl . '" id="select_level_max' . $lvl . '" style="width:5em;;">';

                    for ($i = 0; $i < $level_max_data_count; $i++) {
                        if ($level_max_data[$i] == $levelss_max[$j]) {
                            $value = $level_max_data[$i];
                            $ivalue = $j;
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $s_level_data_all_options .= "<option value=\"$level_max_data[$i]\" $selected >$level_max_data[$i]</option>";
                    }

                    $name = $post_id . '_' . $user->data["user_id"] . '_' . $ivalue;
                    $selectends .= '</select>';
                    if ($j < (count($levelss_max) - 1)) {
                        //$style = 'style="height: 53px;"';
                        $style = 'style="height: 80px;"';
                    } else {
                        $style = '';
                    }
                    $button_level .= '<div ' . $style . '><input type="button" name=' . $name . ' id=' . $value . ' value="-" class=button1 addaditinal onclick="return remove_level1(this);" style="width: 25px;height: 22px;"></div>';
                    if ($j != (count($levelss_max) - 1)) {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "<br><br><br><br><br>";
                    } else {
                        $select .= $selectstart . $s_level_data_all_options . $selectends;
                    }

                    $selectbox_level_max .= $select;
                }
            }
            $ability_names = json_decode($ability_namey, true);
            $edit_ability_namey = '';
            if (count($ability_names) != 0) {
                for ($j = 0; $j < count($ability_names); $j++) {
                    $selectstart = '';
                    $selectends = '';
                    $select = '';
                    if ($j == 0) {
                        $lvl = '';
                        $nl = '<br>';
                    } else {
                        $lvl = $j;
                        $nl = '';
                    }
                    $name = $ability_names[$j];
                    $selectstart .= '' . $nl . 'Name : <input type="text" name=ability' . $lvl . ' value=' . str_replace(" ", "&nbsp;", $name) . ' ><br><br>';
                    $edit_ability_namey .= $selectstart;
                }
            }
            $min_abilityyy = json_decode($min_abilityy, true);
            $s_min_ability = '';
            for ($i = 0; $i < $min_ability_data_count; $i++) {

                if (count($min_abilityyy) == 1) {
                    $variable_ability = 'yes';
                    if ($min_ability_data[$i] == $min_abilityyy[0]) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = '';
                    }
                }
                $s_min_ability .= "<option value=\"$min_ability_data[$i]\"$selected>$min_ability_data[$i]</option>";
            }
            $selectbox_min_ability = '';
            if (count($min_abilityyy) > 1) {
                $increment_variable_ability = '<input type="hidden" name="increment_variable_ability" id="increment_variable_ability" value="' . count($min_abilityyy) . '">';
                $variable_ability = 'no';
                for ($j = 0; $j < count($min_abilityyy); $j++) {
                    $selectstart = '';
                    $select = '';
                    $s_level_data_all_options = '';
                    if ($j == 0) {
                        $lvl = '';
                    } else {
                        $lvl = $j;
                    }

                    $selectstart .= '&nbsp;Min/Max : <select name="min_ability' . $lvl . '" id="min_ability' . $lvl . '" style="width:4em;height:21px;">';

                    for ($i = 0; $i < $min_ability_data_count; $i++) {
                        if ($min_ability_data[$i] == $min_abilityyy[$j]) {
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $s_level_data_all_options .= "<option value=\"$min_ability_data[$i]\" $selected >$min_ability_data[$i]</option>";
                    }
                    $selectends .= '</select>';
                    if ($j != (count($min_abilityyy) - 1)) {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "/" . "<br><br>";
                    } else {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "/";
                    }

                    $selectbox_min_ability .= $select;
                }
            }


            $max_abilityyy = json_decode($max_abilityy, true);

            $s_max_ability = '';
            for ($i = 0; $i < $max_ability_data_count; $i++) {
                if (count($max_abilityyy) == 1) {
                    if ($max_ability_data[$i] == $max_abilityyy[0]) {
                        $selected = ' selected="selected"';
                    } else {
                        $selected = '';
                    }
                }

                $s_max_ability .= "<option value=\"$max_ability_data[$i]\"$selected>$max_ability_data[$i]</option>";
            }


            $selectbox_max_ability = '';
            $button_ability = '<br>';
            if (count($max_abilityyy) > 1) {
                for ($j = 0; $j < count($max_abilityyy); $j++) {
                    $selectstart = '';
                    $selectends = '';
                    $select = '';
                    $s_level_data_all_options = '';
                    if ($j == 0) {
                        $lvl = '';
                    } else {
                        $lvl = $j;
                    }

                    $selectstart .= '<select name="max_ability' . $lvl . '" id="max_ability' . $lvl . '" style="width:4em;height:21px;">';

                    for ($i = 0; $i < $max_ability_data_count; $i++) {
                        if ($max_ability_data[$i] == $max_abilityyy[$j]) {
                            $value = $max_ability_data[$i];
                            $ivalue = $j;
                            $selected = 'selected="selected"';
                        } else {
                            $selected = '';
                        }
                        $s_level_data_all_options .= "<option value=\"$max_ability_data[$i]\" $selected >$max_ability_data[$i]</option>";
                    }
                    $name = $post_id . '_' . $user->data["user_id"] . '_' . $ivalue;
                    $selectends .= '</select>';
                    $button_ability .='&nbsp<input type="button" name=' . $name . ' id=' . $value . ' value="-" class=button1 addaditinal onclick="return remove_ability1(this);" style="width: 25px;height: 22px;"><br><br>';
                    if ($j != (count($max_abilityyy) - 1)) {
                        $select .= $selectstart . $s_level_data_all_options . $selectends . "<br><br>";
                    } else {
                        $select .= $selectstart . $s_level_data_all_options . $selectends;
                    }

                    $selectbox_max_ability .= $select;
                }
            }
            $seleted_gears = json_decode($seleted_gear, true);
            $s_gear_data = '';
            $sel_gear = array();
            $sel_val = array();
            for ($g = 0; $g < count($seleted_gears); $g++) {
                $exp = explode('(', $seleted_gears[$g]);
                $sel_gear[] = $exp[0];
                $sel_val[] = $exp[1];
            }
            $increment = 0;
            $arr_merge = array_merge($gear_data, $sel_gear);
            $unique = array_unique($arr_merge);
            $values = array_values($unique);
            $ar = array();
            $ar = array_diff($values, $sel_gear);
            for ($gg = 0; $gg < count($values); $gg++) {
                if ($ar) {
                    foreach ($ar as $key => $val) {
                        if ($values[$gg] == $val) {
                            $selected = 'deselected="deselected"';
                            break;
                        }
                    }
                }
                foreach ($sel_gear as $key => $val) {
                    if ($val == $values[$gg]) {
                        if ($sel_val[$increment] != '') {
                            $value1 = $val . '(' . $sel_val[$increment];
                        } else {
                            $value1 = $val;
                        }
                        $increment++;
                        $values[$gg] = $value1;
                        $selected = 'selected="selected"';
                        break;
                    }
                }

                $s_gear_data .= "<option value=\"$values[$gg]\" $selected >$values[$gg]</option>";
                unset($value1);
            }
        } else {
            $players_id = null;
            $tableid = null;
        }

        if (request_var('submit_variable','')) {
            if (request_var('increment_variable_spell','') and request_var('increment_variable_spell','') != 1) {
                $level = array();
                $level_min = array();
                $level_max = array();
                $spell = array();

                for ($i = 1; $i < request_var('increment_variable_spell',''); $i++) {
                    $level[] = request_var('select_level' . $i . '','');
                    $level_min[] = request_var('select_level_min' . $i . '','');
                    $level_max[] = request_var('select_level_max' . $i . '','');
                }
                for ($i = 1; $i < request_var('increment_variable_spell',''); $i++) {
                    $lvl = request_var('select_level' . $i . '','');
                    $spell = request_var('spell_level' . $i . '','');
                    $spell_details[$lvl] = array('name' => $spell);
                    unset($lvl);
                }
                $level1 = array_merge(array(request_var('select_level','')), $level);
                $level_min1 = array_merge(array(request_var('select_level_min','')), $level_min);
                $level_max1 = array_merge(array(request_var('select_level_max','')), $level_max);

                $l = json_encode($level1, JSON_FORCE_OBJECT);
                $lmin = json_encode($level_min1, JSON_FORCE_OBJECT);
                $lmax = json_encode($level_max1, JSON_FORCE_OBJECT);

                $fl = request_var('select_level','');
                $fs = request_var('spell_level','');

                $spell_details1 = array("$fl" => array('name' => $fs));

                $merge = $spell_details + $spell_details1;
                $spell_variable = json_encode($merge, JSON_FORCE_OBJECT);
            } else {
                $l = json_encode(array(request_var('select_level','')), JSON_FORCE_OBJECT);
                $lmin = json_encode(array(request_var('select_level_min','')), JSON_FORCE_OBJECT);
                $lmax = json_encode(array(request_var('select_level_max','')), JSON_FORCE_OBJECT);

                $fl = request_var('select_level','');
                $fs = request_var('spell_level','');
                $spell_details1 = array("$fl" => array('name' => $fs));
                $spell_variable = json_decode($spell_details1, JSON_FORCE_OBJECT);
            }

            if (request_var('increment_variable_ability','') and request_var('increment_variable_ability','') > 1) {
                $ability = array();
                $ability_min = array();
                $ability_max = array();
                for ($i = 1; $i < request_var('increment_variable_ability',''); $i++) {
                    $ability[] = request_var('ability' . $i . '', '');
                    $ability_min[] = request_var('min_ability' . $i . '','');
                    $ability_max[] = request_var('max_ability' . $i . '','');
                }

                $ability1 = array_merge(array(request_var('ability','')), $ability);
                $ability_min1 = array_merge(array(request_var('min_ability','')), $ability_min);
                $ability_max1 = array_merge(array(request_var('max_ability','')), $ability_max);

                $a = json_encode($ability1, JSON_FORCE_OBJECT);
                $amin = json_encode($ability_min1, JSON_FORCE_OBJECT);
                $amax = json_encode($ability_max1, JSON_FORCE_OBJECT);
            } else {
                $a = json_encode(array(request_var('ability','')), JSON_FORCE_OBJECT);
                $amin = json_encode(array(request_var('min_ability','')), JSON_FORCE_OBJECT);
                $amax = json_encode(array(request_var('max_ability','')), JSON_FORCE_OBJECT);
            }

            $arr_gear_quality1 = array();

            if (request_var('gear','') != '') {
                $gear_quality = json_encode(request_var('gear',''), JSON_FORCE_OBJECT);
            } else {
                $gear_quality = '';
            }
            $data_update_post = array(
                'selected_current_hit' => request_var('select_current_count',''),
                'selected_maximum_hit' => request_var('select_maximum_count',''),
                'seleted_non_lethal' => request_var('select_non_lethal',''),
                'seleted_bad_condition' => json_encode(request_var('negative_condition',''), JSON_FORCE_OBJECT),
                'seleted_good_condition' => json_encode(request_var('positive_condition',''), JSON_FORCE_OBJECT),
                'level' => $l,
                'level_min' => $lmin,
                'level_max' => $lmax,
                'ability_name' => $a,
                'min_ability' => $amin,
                'max_ability' => $amax,
                'gear' => $gear_quality,
                'spell' => $spell_variable,
            );


            $sql = 'UPDATE ' . USER_VARIABLES_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data_update_post) . ' WHERE user_id = ' . request_var('players','');
            $db->sql_query($sql);

            $submitted = 1;
            $sid = request_var('sid','');
        }


        //archi11 code ends :)


        $template->assign_vars(array(
            'L_TITLE' => $user->lang[$display_vars['title']],
            'L_TITLE_EXPLAIN' => $user->lang[$display_vars['title'] . '_EXPLAIN'],
            'S_ERROR' => (sizeof($error)) ? true : false,
            'ERROR_MSG' => implode('<br />', $error),
            'U_ACTION' => $this->u_action,
            //archi11 start
            'MODE' => $mode,
            'CHANGE_PLAYER_INFO' => 'Change Player Information',
            'TABLE' => $tablestart,
            'TABLE_START' => $variabls,
            'PLAYER_ID' => $players_id,
            "PLAYER_NAME" => $player_name,
            'S_HIT_CURRENT_COUNT' => $s_hit_current_data,
            'S_HIT_MAXIMUM_COUNT' => $s_hit_maximum_data,
            'S_NEGATIVE_CONDITION' => $s_negative_condition_data,
            'S_POSITIVE_CONDITION' => $s_positive_condition_data,
            'S_LEVEL' => $s_level_data,
            'S_LEVEL_MIN' => $s_level_min_data,
            'S_LEVEL_MAX' => $s_level_max_data,
            'S_MIN_ABILITY' => $s_min_ability,
            'S_MAX_ABILITY' => $s_max_ability,
            //'S_GEAR_EDIT' => $s_edit_gear,
            'S_GEAR' => $s_gear_data,
            'S_NON_LETHAL' => $s_non_lethal_data,
            'S_VARIABLE_LEVEL' => $variable_level,
            'S_VARIABLE_ABILITY' => $variable_ability,
            'S_EDIT_LEVEL' => $selectbox_level,
            'S_EDIT_MIN_LEVEL' => $selectbox_level_min,
            'S_EDIT_MAX_LEVEL' => $selectbox_level_max,
            'S_SPELL_COUNT' => $spell_variable,
            'S_SPELL_VARIABLE' => $spell_one,
            'S_EDIT_ABILITY_NAME' => $edit_ability_namey,
            'S_EDIT_MIN_ABILITY' => $selectbox_min_ability,
            'S_EDIT_MAX_ABILITY' => $selectbox_max_ability,
            'S_INCREMENR_SPELL' => $increment_variable_spell,
            'S_INCREMENR_ABILITY' => $increment_variable_ability,
            'S_HERO_POINT' => $s_hero_points_data,
            'S_QUICK_STATS' => $quick_stats,
            'S_QUICK_SKILL' => $s_quick_skill_data,
            'BUTTON_LEVEL' => $button_level,
            'S_WEAPON_NAME' => $s_weapon_name,
            'BUTTON_ABILITY' => $button_ability,
            'USER_ID' => $user->data["user_id"],
            'POST_ID' => $post_id,
            'LAST_LEVEL_NAME' => $delete_last_level_ability,
            'SUCCESS' => $submitted,
            'INFORMATION' => 'Information',
            'MESSAGE' => 'Configuration updated successfully.',
            'LINK' => '&lt;&lt; Back to previous page',
            'SID' => $sid,
                //archi11 start end 
                )
        );

        // Output relevant page
        foreach ($display_vars['vars'] as $config_key => $vars) {
            if (!is_array($vars) && strpos($config_key, 'legend') === false) {
                continue;
            }

            if (strpos($config_key, 'legend') !== false) {
                $template->assign_block_vars('options', array(
                    'S_LEGEND' => true,
                    'LEGEND' => (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
                );

                continue;
            }

            $type = explode(':', $vars['type']);

            $l_explain = '';
            if ($vars['explain'] && isset($vars['lang_explain'])) {
                $l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
            } else if ($vars['explain']) {
                $l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
            }

            $content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

            if (empty($content)) {
                continue;
            }

            $template->assign_block_vars('options', array(
                'KEY' => $config_key,
                'TITLE' => (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
                'S_EXPLAIN' => $vars['explain'],
                'TITLE_EXPLAIN' => $l_explain,
                'CONTENT' => $content,
                    )
            );

            unset($display_vars['vars'][$config_key]);
        }

        if ($mode == 'auth') {
            $template->assign_var('S_AUTH', true);

            foreach ($auth_plugins as $method) {
                if ($method && file_exists($phpbb_root_path . 'includes/auth/auth_' . $method . '.' . $phpEx)) {
                    $method = 'acp_' . $method;
                    if (function_exists($method)) {
                        $fields = $method($this->new_config);

                        if ($fields['tpl']) {
                            $template->assign_block_vars('auth_tpl', array(
                                'TPL' => $fields['tpl'])
                            );
                        }
                        unset($fields);
                    }
                }
            }
        }
    }

    /**
     * Select auth method
     */
    function select_auth_method($selected_method, $key = '') {
        global $phpbb_root_path, $phpEx;

        $auth_plugins = array();

        $dp = @opendir($phpbb_root_path . 'includes/auth');

        if (!$dp) {
            return '';
        }

        while (($file = readdir($dp)) !== false) {
            if (preg_match('#^auth_(.*?)\.' . $phpEx . '$#', $file)) {
                $auth_plugins[] = preg_replace('#^auth_(.*?)\.' . $phpEx . '$#', '\1', $file);
            }
        }
        closedir($dp);

        sort($auth_plugins);

        $auth_select = '';
        foreach ($auth_plugins as $method) {
            $selected = ($selected_method == $method) ? ' selected="selected"' : '';
            $auth_select .= '<option value="' . $method . '"' . $selected . '>' . ucfirst($method) . '</option>';
        }

        return $auth_select;
    }

    /**
     * Select mail authentication method
     */
    function mail_auth_select($selected_method, $key = '') {
        global $user;

        $auth_methods = array('PLAIN', 'LOGIN', 'CRAM-MD5', 'DIGEST-MD5', 'POP-BEFORE-SMTP');
        $s_smtp_auth_options = '';

        foreach ($auth_methods as $method) {
            $s_smtp_auth_options .= '<option value="' . $method . '"' . (($selected_method == $method) ? ' selected="selected"' : '') . '>' . $user->lang['SMTP_' . str_replace('-', '_', $method)] . '</option>';
        }

        return $s_smtp_auth_options;
    }

    /**
     * Select full folder action
     */
    function full_folder_select($value, $key = '') {
        global $user;

        return '<option value="1"' . (($value == 1) ? ' selected="selected"' : '') . '>' . $user->lang['DELETE_OLDEST_MESSAGES'] . '</option><option value="2"' . (($value == 2) ? ' selected="selected"' : '') . '>' . $user->lang['HOLD_NEW_MESSAGES_SHORT'] . '</option>';
    }

    /**
     * Select ip validation
     */
    function select_ip_check($value, $key = '') {
        $radio_ary = array(4 => 'ALL', 3 => 'CLASS_C', 2 => 'CLASS_B', 0 => 'NO_IP_VALIDATION');

        return h_radio('config[ip_check]', $radio_ary, $value, $key);
    }

    /**
     * Select referer validation
     */
    function select_ref_check($value, $key = '') {
        $radio_ary = array(REFERER_VALIDATE_PATH => 'REF_PATH', REFERER_VALIDATE_HOST => 'REF_HOST', REFERER_VALIDATE_NONE => 'NO_REF_VALIDATION');

        return h_radio('config[referer_validation]', $radio_ary, $value, $key);
    }

    /**
     * Select account activation method
     */
    function select_acc_activation($selected_value, $value) {
        global $user, $config;

        $act_ary = array(
            'ACC_DISABLE' => USER_ACTIVATION_DISABLE,
            'ACC_NONE' => USER_ACTIVATION_NONE,
        );
        if ($config['email_enable']) {
            $act_ary['ACC_USER'] = USER_ACTIVATION_SELF;
            $act_ary['ACC_ADMIN'] = USER_ACTIVATION_ADMIN;
        }
        $act_options = '';

        foreach ($act_ary as $key => $value) {
            $selected = ($selected_value == $value) ? ' selected="selected"' : '';
            $act_options .= '<option value="' . $value . '"' . $selected . '>' . $user->lang[$key] . '</option>';
        }

        return $act_options;
    }

    /**
     * Maximum/Minimum username length
     */
    function username_length($value, $key = '') {
        global $user;

        return '<input id="' . $key . '" type="text" size="3" maxlength="3" name="config[min_name_chars]" value="' . $value . '" /> ' . $user->lang['MIN_CHARS'] . '&nbsp;&nbsp;<input type="text" size="3" maxlength="3" name="config[max_name_chars]" value="' . $this->new_config['max_name_chars'] . '" /> ' . $user->lang['MAX_CHARS'];
    }

    /**
     * Allowed chars in usernames
     */
    function select_username_chars($selected_value, $key) {
        global $user;

        $user_char_ary = array('USERNAME_CHARS_ANY', 'USERNAME_ALPHA_ONLY', 'USERNAME_ALPHA_SPACERS', 'USERNAME_LETTER_NUM', 'USERNAME_LETTER_NUM_SPACERS', 'USERNAME_ASCII');
        $user_char_options = '';
        foreach ($user_char_ary as $user_type) {
            $selected = ($selected_value == $user_type) ? ' selected="selected"' : '';
            $user_char_options .= '<option value="' . $user_type . '"' . $selected . '>' . $user->lang[$user_type] . '</option>';
        }

        return $user_char_options;
    }

    /**
     * Maximum/Minimum password length
     */
    function password_length($value, $key) {
        global $user;

        return '<input id="' . $key . '" type="text" size="3" maxlength="3" name="config[min_pass_chars]" value="' . $value . '" /> ' . $user->lang['MIN_CHARS'] . '&nbsp;&nbsp;<input type="text" size="3" maxlength="3" name="config[max_pass_chars]" value="' . $this->new_config['max_pass_chars'] . '" /> ' . $user->lang['MAX_CHARS'];
    }

    /**
     * Required chars in passwords
     */
    function select_password_chars($selected_value, $key) {
        global $user;

        $pass_type_ary = array('PASS_TYPE_ANY', 'PASS_TYPE_CASE', 'PASS_TYPE_ALPHA', 'PASS_TYPE_SYMBOL');
        $pass_char_options = '';
        foreach ($pass_type_ary as $pass_type) {
            $selected = ($selected_value == $pass_type) ? ' selected="selected"' : '';
            $pass_char_options .= '<option value="' . $pass_type . '"' . $selected . '>' . $user->lang[$pass_type] . '</option>';
        }

        return $pass_char_options;
    }

    /**
     * Select bump interval
     */
    function bump_interval($value, $key) {
        global $user;

        $s_bump_type = '';
        $types = array('m' => 'MINUTES', 'h' => 'HOURS', 'd' => 'DAYS');
        foreach ($types as $type => $lang) {
            $selected = ($this->new_config['bump_type'] == $type) ? ' selected="selected"' : '';
            $s_bump_type .= '<option value="' . $type . '"' . $selected . '>' . $user->lang[$lang] . '</option>';
        }

        return '<input id="' . $key . '" type="text" size="3" maxlength="4" name="config[bump_interval]" value="' . $value . '" />&nbsp;<select name="config[bump_type]">' . $s_bump_type . '</select>';
    }

    /**
     * Board disable option and message
     */
    function board_disable($value, $key) {
        global $user;

        $radio_ary = array(1 => 'YES', 0 => 'NO');

        return h_radio('config[board_disable]', $radio_ary, $value) . '<br /><input id="' . $key . '" type="text" name="config[board_disable_msg]" maxlength="255" size="40" value="' . $this->new_config['board_disable_msg'] . '" />';
    }

    /**
     * Global quick reply enable/disable setting and button to enable in all forums
     */
    function quick_reply($value, $key) {
        global $user;

        $radio_ary = array(1 => 'YES', 0 => 'NO');

        return h_radio('config[allow_quick_reply]', $radio_ary, $value) .
                '<br /><br /><input class="button2" type="submit" id="' . $key . '_enable" name="' . $key . '_enable" value="' . $user->lang['ALLOW_QUICK_REPLY_BUTTON'] . '" />';
    }

    /**
     * Select default dateformat
     */
    function dateformat_select($value, $key) {
        global $user, $config;

        // Let the format_date function operate with the acp values
        $old_tz = $user->timezone;
        $old_dst = $user->dst;

        $user->timezone = $config['board_timezone'] * 3600;
        $user->dst = $config['board_dst'] * 3600;

        $dateformat_options = '';

        foreach ($user->lang['dateformats'] as $format => $null) {
            $dateformat_options .= '<option value="' . $format . '"' . (($format == $value) ? ' selected="selected"' : '') . '>';
            $dateformat_options .= $user->format_date(time(), $format, false) . ((strpos($format, '|') !== false) ? $user->lang['VARIANT_DATE_SEPARATOR'] . $user->format_date(time(), $format, true) : '');
            $dateformat_options .= '</option>';
        }

        $dateformat_options .= '<option value="custom"';
        if (!isset($user->lang['dateformats'][$value])) {
            $dateformat_options .= ' selected="selected"';
        }
        $dateformat_options .= '>' . $user->lang['CUSTOM_DATEFORMAT'] . '</option>';

        // Reset users date options
        $user->timezone = $old_tz;
        $user->dst = $old_dst;

        return "<select name=\"dateoptions\" id=\"dateoptions\" onchange=\"if (this.value == 'custom') { document.getElementById('" . addslashes($key) . "').value = '" . addslashes($value) . "'; } else { document.getElementById('" . addslashes($key) . "').value = this.value; }\">$dateformat_options</select>
		<input type=\"text\" name=\"config[$key]\" id=\"$key\" value=\"$value\" maxlength=\"30\" />";
    }

    /**
     * Select multiple forums
     */
    function select_news_forums($value, $key) {
        global $user, $config;

        $forum_list = make_forum_select(false, false, true, true, true, false, true);

        // Build forum options
        $s_forum_options = '<select id="' . $key . '" name="' . $key . '[]" multiple="multiple">';
        foreach ($forum_list as $f_id => $f_row) {
            $f_row['selected'] = phpbb_optionget(FORUM_OPTION_FEED_NEWS, $f_row['forum_options']);

            $s_forum_options .= '<option value="' . $f_id . '"' . (($f_row['selected']) ? ' selected="selected"' : '') . (($f_row['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
        }
        $s_forum_options .= '</select>';

        return $s_forum_options;
    }

    function select_exclude_forums($value, $key) {
        global $user, $config;

        $forum_list = make_forum_select(false, false, true, true, true, false, true);

        // Build forum options
        $s_forum_options = '<select id="' . $key . '" name="' . $key . '[]" multiple="multiple">';
        foreach ($forum_list as $f_id => $f_row) {
            $f_row['selected'] = phpbb_optionget(FORUM_OPTION_FEED_EXCLUDE, $f_row['forum_options']);

            $s_forum_options .= '<option value="' . $f_id . '"' . (($f_row['selected']) ? ' selected="selected"' : '') . (($f_row['disabled']) ? ' disabled="disabled" class="disabled-option"' : '') . '>' . $f_row['padding'] . $f_row['forum_name'] . '</option>';
        }
        $s_forum_options .= '</select>';

        return $s_forum_options;
    }

    function store_feed_forums($option, $key) {
        global $db, $cache;

        // Get key
        $values = request_var($key, array(0 => 0));

        // Empty option bit for all forums
        $sql = 'UPDATE ' . FORUMS_TABLE . '
			SET forum_options = forum_options - ' . (1 << $option) . '
			WHERE ' . $db->sql_bit_and('forum_options', $option, '<> 0');
        $db->sql_query($sql);

        // Already emptied for all...
        if (sizeof($values)) {
            // Set for selected forums
            $sql = 'UPDATE ' . FORUMS_TABLE . '
				SET forum_options = forum_options + ' . (1 << $option) . '
				WHERE ' . $db->sql_in_set('forum_id', $values);
            $db->sql_query($sql);
        }

        // Empty sql cache for forums table because options changed
        $cache->destroy('sql', FORUMS_TABLE);
    }

    function current_hit($value, $key = '') {
        // Determine size var and adjust the value accordingly
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $hit_current = $row['current'];
        }
        $hit_current_data = json_decode($hit_current, true);
        //usort($hit_current_data,"cmp");
        $hit_current_data_count = count($hit_current_data);

        $tz_select = '<select name="select_curren_hit" width=65px id=select_curren_hit>';
        if ($hit_current_data) {
            foreach ($hit_current_data as $id => $val) {
                $selected = ($offset == $default) ? ' selected="selected"' : '';
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
            $tz_select .= '</select>';
            return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_current_hit" size="8" maxlength="15" name="change_current_hit" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_current_hit();">';
        }
    }

    function maximum_hit($value, $key = '') {
        // Determine size var and adjust the value accordingly
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $hit_maximum = $row['maximum'];
        }
        $hit_maximum_data = json_decode($hit_maximum, true);
        sort($hit_maximum_data);
        $hit_maximum_data_count = count($hit_maximum_data);

        $tz_select = '<select name="select_maximum_hit" width=65px id=select_maximum_hit>';
        if ($hit_maximum_data) {
            foreach ($hit_maximum_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';
        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_maximum_hit" size="8" maxlength="15" name="change_maximum_hit" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_maximum_hit();">';
    }

    function change_good_condition() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $positive_condition = $row['positive_condition'];
        }
        $positive_condition_data1 = json_decode($positive_condition, true);
        $positive_condition_data = array_map('ucfirst', $positive_condition_data1);
        sort($positive_condition_data);
        $tz_select = '<select name="selected_positive_condition" width=65px id=selected_positive_condition>';
        if ($positive_condition_data) {
            foreach ($positive_condition_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_good_condition"  maxlength="15" name="change_good_condition" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_good_condition();">';
    }

    function change_bad_condition() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $negative_condition = $row['negative_condition'];
        }
        $negative_condition_data1 = json_decode($negative_condition, true);
        $negative_condition_data = array_map('ucfirst', $negative_condition_data1);
        sort($negative_condition_data);
        $tz_select = '<select name="selected_negative_condition" width=65px  id=selected_negative_condition>';
        if ($negative_condition_data) {
            foreach ($negative_condition_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';
        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_negative_condition"  maxlength="15" name="change_negative_condition" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_negative_condition();">';
    }

    function change_level() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $level = $row['level'];
        }
        $level_data = json_decode($level, true);
        sort($level_data);
        $tz_select = '<select name="selected_level" width=65px  id =selected_level>';
        if ($level_data) {
            foreach ($level_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_level"  maxlength="15" name="change_level" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_level();">';
    }

    function change_min_level() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $level_min = $row['level_min'];
        }
        $level_min_data = json_decode($level_min, true);
        sort($level_min_data);
        $tz_select = '<select name="selected_level_min" width=65px id=selected_level_min >';
        if ($level_min_data) {
            foreach ($level_min_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_level_min"  maxlength="15" name="change_level_min" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_level_min();">';
    }

    function change_max_level() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $level_max = $row['level_max'];
        }
        $level_max_data = json_decode($level_max, true);
        sort($level_max_data);
        $tz_select = '<select name="selected_level_max" width=65px id=selected_level_max >';
        if ($level_max_data) {
            foreach ($level_max_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_level_max"  maxlength="15" name="change_level_max" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_level_max();">';
    }

    function change_min_ability() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $min_ability = $row['min_ability'];
        }

        $min_ability_data = json_decode($min_ability, true);
        sort($min_ability_data);
        $tz_select = '<select name="selected_min_ability" width=65px id=selected_min_ability >';
        if ($min_ability_data) {
            foreach ($min_ability_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_min_ability"  maxlength="15" name="change_min_ability" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_min_ability();">';
    }

    function change_max_ability() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $max_ability = $row['max_ability'];
        }
        $max_ability_data = json_decode($max_ability, true);
        sort($max_ability_data);
        $tz_select = '<select name="selected_max_ability" width=65px  id=selected_max_ability>';
        if ($max_ability_data) {
            foreach ($max_ability_data as $id => $val) {
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';
        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_max_ability"  maxlength="15" name="change_max_ability" value="" />&nbsp<input type=button name=remove value=Remove onclick="return remove_max_ability();">';
    }

    function change_gear() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $gear = $row['gear'];
        }
        $gear_data1 = json_decode($gear, true);
        $gear_data = array_map('ucfirst', $gear_data1);
        sort($gear_data);
        $tz_select = '<select name="selected_gear" width=65px  id=selected_gear>';
        if ($gear_data) {
            foreach ($gear_data as $id => $val) {

                //	$selected = ($offset == $default) ? ' selected="selected"' : '';
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_gear"  maxlength="15" name="change_gear" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_gear();">';
    }

    function change_spell() {
        global $user;
        global $db;

        $select_hit = "SELECT * from " . VARIABLES_TABLE;
        $result1 = $db->sql_query($select_hit);
        while ($row = $db->sql_fetchrow($result1)) {
            $spell = $row['spell'];
        }
        $spell_data1 = json_decode($spell, true);
        $spell_data = array_map('ucfirst', $spell_data1);
        sort($spell_data);
        $tz_select = '<select name="selected_spell" width=65px  id=selected_spell>';
        if ($spell_data) {
            foreach ($spell_data as $id => $val) {

                //	$selected = ($offset == $default) ? ' selected="selected"' : '';
                $tz_select .= '<option title="' . $val . '" value="' . $id . '"' . $selected . '>' . $val . '</option>';
            }
        }
        $tz_select .= '</select>';


        return $tz_select . '&nbsp&nbsp&nbsp<input type="text" id="change_spell"  maxlength="15" name="change_spell" value="" /> &nbsp<input type=button name=remove value=Remove onclick="return remove_spell();">';
    }

    function change_player_information() {
        return '<input type=button name=Info value=Info onclick="return change_plyer_info();">';
    }

}

?>