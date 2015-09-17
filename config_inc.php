<?php
$g_hostname = 'localhost';
$g_db_type = 'mysql';
$g_database_name = 'mantisbt';
$g_db_username = 'root';
$g_db_password = 'triet2d';

/*************************
	 * MantisBT Enum Strings *
	 *************************/

$g_access_levels_enum_string		= '10:viewer, 25:reporter, 36:production, 40:updater, 48:program_manager, 55:developer, 70:manager, 90:administrator';

// $g_show_avatar = ON;
$g_show_only_custom_fields = [3,1];
/* $g_monitor_group[1]=[
						["id" => 1, "username" => administrator],
						["id" => 2, "username" => strator],
						["id" => 3, "username" => admini]
					];
$g_monitor_groups = [ $g_monitor_group[1], $g_monitor_group[2], $g_monitor_group[3] ] ;*/
 

// [99] => Array( Array ( [id] => 1, [username] => administrator ), Array ( [id] => 1, [username] => administrator ), Array ( [id] => 1, [username] => administrator ) );

# Mandatory
$g_preview_attachments_inline_max_size = 1024 * 1024;
$g_preview_max_width = 150;
$g_preview_max_height = 150;

// TODO: preview of doc, docx, xls, rtf
$g_preview_text_extensions = array( '', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'md', 'md5', 'csv', 'diff', 'patch', 'rtf' ); 

// TODO
$g_default_project_for_users = ["REPORTER"=> 1, "DEVELOPER" => 2, "PROGRAM_MANAGER" => 1];

/* function Set_default_project_for_usergroup (USERGROUP, $g_default_project_id){
	// login_select_proj_page.php
} */

/*************************
	* USER CLASSES' priveledges *
	*****************************

$g_update_bug_threshold			= UPDATER;
$g_change_view_status_threshold = UPDATER;
$g_update_bug_threshold			= UPDATER;

$g_show_avatar_threshold = DEVELOPER;
$g_private_news_threshold	= DEVELOPER;
$g_reminder_receive_threshold = DEVELOPER;
$g_handle_sponsored_bugs_threshold = DEVELOPER;
$g_delete_attachments_threshold	= DEVELOPER;
$g_monitor_add_others_bug_threshold = DEVELOPER;
$g_monitor_delete_others_bug_threshold = DEVELOPER;
$g_private_bug_threshold		= DEVELOPER;
$g_handle_bug_threshold			= DEVELOPER;
$g_private_bugnote_threshold	= DEVELOPER;
$g_bug_reminder_threshold		= DEVELOPER;
$g_update_bugnote_threshold = DEVELOPER;
$g_delete_bug_threshold = DEVELOPER;
$g_move_bug_threshold = DEVELOPER;
$g_show_monitor_list_threshold = DEVELOPER;
$g_stored_query_create_threshold = DEVELOPER;
$g_roadmap_update_threshold = DEVELOPER;
$g_update_bug_status_threshold = DEVELOPER;
$g_reopen_bug_threshold			= DEVELOPER;
$g_report_issues_for_unreleased_versions_threshold = DEVELOPER;
$g_development_team_threshold = DEVELOPER;
$g_create_permalink_threshold = DEVELOPER;
$g_tag_detach_threshold = DEVELOPER;
$g_tag_edit_threshold = DEVELOPER;
$g_time_tracking_view_threshold = DEVELOPER;
$g_time_tracking_edit_threshold = DEVELOPER;

*/