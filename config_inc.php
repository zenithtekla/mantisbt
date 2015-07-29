<?php
$g_hostname = 'localhost';
$g_db_type = 'mysql';
$g_database_name = 'mantis-zetek';
$g_db_username = 'root';
$g_db_password = 'HRLserver8579';

$g_allow_no_category = ON;
	/*************************
	 * MantisBT Enum Strings *
	 *************************/

	/**
	 * status from $g_status_index-1 to 79 are used for the onboard customization (if enabled)
	 * directly use MantisBT to edit them.
	 * @global string $g_access_levels_enum_string
	 */
#	$g_access_levels_enum_string		= '10:viewer,25:reporter,40:updater,55:developer,70:manager,90:administrator';
	$g_access_levels_enum_string		= '10:viewer,25:reporter,40:updater,55:support_engineer,60:senior_engineer,70:manager,90:administrator';
	/**
	 *
	 * @global string $g_project_status_enum_string
	 */
#	$g_project_status_enum_string		= '10:development,30:release,50:stable,70:obsolete';

	/**
	 *
	 * @global string $g_project_view_state_enum_string
	 */
#	$g_project_view_state_enum_string	= '10:public,50:private';

	/**
	 *
	 * @global string $g_view_state_enum_string
	 */
#	$g_view_state_enum_string			= '10:public,50:private';

	/**
	 *
	 * @global string $g_priority_enum_string
	 */
#	$g_priority_enum_string				= '10:none,20:low,30:normal,40:high,50:urgent,60:immediate';
	$g_priority_enum_string				= '10:5_days,20:3_days,30:2_days,40:24_hrs,50:same_day,60:immediate';	
	/**
	 *
	 * @global string $g_severity_enum_string
	 */
#	$g_severity_enum_string				= '10:feature,20:trivial,30:text,40:tweak,50:minor,60:major,70:crash,80:block';
	$g_severity_enum_string				= '10:non_issue,20:trivial,50:minor,60:major,80:stop_production';
	/**
	 *
	 * @global string $g_reproducibility_enum_string
	 */
#	$g_reproducibility_enum_string		= '10:always,30:sometimes,50:random,70:have not tried,90:unable to duplicate,100:N/A';

	/**
	 *
	 * @global string $g_status_enum_string
	 */
#	$g_status_enum_string				= '10:new,20:feedback,30:acknowledged,40:confirmed,50:assigned,80:resolved,90:closed';

	/**
	 * @@@ for documentation, the values in this list are also used to define variables in the language files
	 *  (e.g., $s_new_bug_title referenced in bug_change_status_page.php )
	 * Embedded spaces are converted to underscores (e.g., "working on" references $s_working_on_bug_title).
	 * they are also expected to be english names for the states
	 * @global string $g_resolution_enum_string
	 */
	$g_resolution_enum_string			= '10:open,20:fixed,30:reopened,40:unable to determine,50:not fixable,60:duplicate,70:not an issue,80:suspended,90:wont fix';

	/**
	 *
	 * @global string $g_projection_enum_string
	 */
#	$g_projection_enum_string			= '10:none,30:tweak,50:minor fix,70:major rework,90:redesign';

	/**
	 *
	 * @global string $g_eta_enum_string
	 */
	$g_eta_enum_string					= '10:none,20:immediate,30:same day,40:next day,50:2 days,60:3 days,70:5 days';

	/**
	 *
	 * @global string $g_sponsorship_enum_string
	 */
#	$g_sponsorship_enum_string          = '0:Unpaid,1:Requested,2:Paid';

	/**
	 *
	 * @global string $g_custom_field_type_enum_string
	 */
	$g_custom_field_type_enum_string    = '0:string,1:numeric,2:float,3:enum,4:email,5:checkbox,6:list,7:multiselection list,8:date,9:radio';
	
	$g_default_bug_eta = 50;
	$g_enable_email_notification	= OFF;