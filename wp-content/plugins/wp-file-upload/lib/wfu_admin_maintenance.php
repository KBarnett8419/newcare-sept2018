<?php

function wfu_maintenance_actions($message = '') {
	if ( !current_user_can( 'manage_options' ) ) return wfu_manage_mainmenu();

	$siteurl = site_url();
	
	$echo_str = '<div class="wrap">';
	$echo_str .= "\n\t".'<h2>Wordpress File Upload Control Panel</h2>';
	if ( $message != '' ) {
		$echo_str .= "\n\t".'<div class="updated">';
		$echo_str .= "\n\t\t".'<p>'.$message.'</p>';
		$echo_str .= "\n\t".'</div>';
	}
	$echo_str .= "\n\t".'<div style="margin-top:20px;">';
	$echo_str .= wfu_generate_dashboard_menu("\n\t\t", "Maintenance Actions");
	//maintenance actions
	$echo_str .= "\n\t\t".'<h3 style="margin-bottom: 10px;">Maintenance Actions</h3>';
	$echo_str .= "\n\t\t".'<table class="form-table">';
	$echo_str .= "\n\t\t\t".'<tbody>';
	$echo_str .= "\n\t\t\t\t".'<tr>';
	$echo_str .= "\n\t\t\t\t\t".'<th scope="row">';
	$wfu_maintenance_nonce = wp_create_nonce("wfu_maintenance_actions");
	$echo_str .= "\n\t\t\t\t\t\t".'<a href="'.$siteurl.'/wp-admin/options-general.php?page=wordpress_file_upload&amp;action=sync_db&amp;nonce='.$wfu_maintenance_nonce.'" class="button" title="Update database to reflect current status of files">Sync Database</a>';
	$echo_str .= "\n\t\t\t\t\t".'</th>';
	$echo_str .= "\n\t\t\t\t\t".'<td>';
	$echo_str .= "\n\t\t\t\t\t\t".'<label>Update database to reflect current status of files.</label>';
	$echo_str .= "\n\t\t\t\t\t".'</td>';
	$echo_str .= "\n\t\t\t\t".'</tr>';
	$echo_str .= "\n\t\t\t\t".'<tr>';
	$echo_str .= "\n\t\t\t\t\t".'<th scope="row">';
	$echo_str .= "\n\t\t\t\t\t\t".'<a href="" class="button" title="Clean database log" onclick="wfu_cleanlog_selector_toggle(true); return false;">Clean Log</a>';
	$echo_str .= "\n\t\t\t\t\t".'</th>';
	$echo_str .= "\n\t\t\t\t\t".'<td>';
	$echo_str .= "\n\t\t\t\t\t\t".'<label>Clean-up database log, either all or of specific period, including file information and user data (files will not be affected).</label>';
	$echo_str .= "\n\t\t\t\t\t".'</td>';
	$echo_str .= "\n\t\t\t\t".'</tr>';
	$echo_str .= "\n\t\t\t\t".'<tr class="wfu_cleanlog_tr">';
	$echo_str .= "\n\t\t\t\t\t".'<th scope="row"></th>';
	$echo_str .= "\n\t\t\t\t\t".'<td>';
	$echo_str .= "\n\t\t\t\t\t\t".'<div>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<label>Select Clean-Up Period</label>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<select id="wfu_cleanlog_period" onchange="wfu_cleanlog_period_changed();">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<option value="older_than_date">Clean-up log older than date</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<option value="older_than_period">Clean-up log older than period</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<option value="between_dates">Clean-up log between dates</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<option value="all">Clean-up all log</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'</select>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<div class="wfu_selectdate_container">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<label>Select date</label>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<input id="wfu_cleanlog_dateold" type="text" />';
	$echo_str .= "\n\t\t\t\t\t\t\t".'</div>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<div class="wfu_selectperiod_container">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<label>Select period</label>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<input id="wfu_cleanlog_periodold" type="number" min="1" />';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<select id="wfu_cleanlog_periodtype">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t\t".'<option value="days">days</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t\t".'<option value="months">months</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t\t".'<option value="years">years</option>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'</select>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'</div>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<div class="wfu_selectdates_container">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<label>Select period from</label>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<input id="wfu_cleanlog_datefrom" type="text" />';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<label>back to</label>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<input id="wfu_cleanlog_dateto" type="text" />';
	$echo_str .= "\n\t\t\t\t\t\t\t".'</div>';
	$echo_str .= "\n\t\t\t\t\t\t\t".'<div class="wfu_buttons_container">';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<a href="" class="button" title="Close" onclick="wfu_cleanlog_selector_toggle(false); return false;">Close</a>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<a href="" class="button wfu_cleanlog_proceed" title="Proceed to log clean-up" onclick="if (wfu_cleanlog_selector_checkproceed()) return true; else return false; ">Proceed</a>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<span class="wfu_cleanlog_error hidden">Error</span>';
	$echo_str .= "\n\t\t\t\t\t\t\t\t".'<input id="wfu_cleanlog_href" type="hidden" value="'.$siteurl.'/wp-admin/options-general.php?page=wordpress_file_upload&amp;action=clean_log_ask&amp;nonce='.$wfu_maintenance_nonce.'" />';
	$echo_str .= "\n\t\t\t\t\t\t\t".'</div>';
	$echo_str .= "\n\t\t\t\t\t\t".'</div>';
	$echo_str .= "\n\t\t\t\t\t".'</td>';
	$echo_str .= "\n\t\t\t\t".'</tr>';
	$echo_str .= "\n\t\t\t".'</tbody>';
	$echo_str .= "\n\t\t".'</table>';
	$echo_str .= "\n\t".'</div>';
	//export actions
	$echo_str .= "\n\t".'<div style="margin-top:20px;">';
	$echo_str .= "\n\t\t".'<h3 style="margin-bottom: 10px;">Export Actions</h3>';
	$echo_str .= "\n\t\t".'<table class="form-table">';
	$echo_str .= "\n\t\t\t".'<tbody>';
	$echo_str .= "\n\t\t\t\t".'<tr>';
	$echo_str .= "\n\t\t\t\t\t".'<th scope="row">';
	$echo_str .= "\n\t\t\t\t\t\t".'<a href="javascript:wfu_download_file(\'exportdata\', 1);" class="button" title="Export uploaded file data">Export Uploaded File Data</a>';
	$echo_str .= "\n\t\t\t\t\t\t".'<input id="wfu_download_file_nonce" type="hidden" value="'.wp_create_nonce('wfu_download_file_invoker').'" />';
	$echo_str .= "\n\t\t\t\t\t".'</th>';
	$echo_str .= "\n\t\t\t\t\t".'<td>';
	$echo_str .= "\n\t\t\t\t\t\t".'<label>Export uploaded valid file data, together with any userdata fields, to a comma-separated text file.</label>';
	$echo_str .= "\n\t\t\t\t\t\t".'<div id="wfu_file_download_container_1" style="display: none;"></div>';
	$echo_str .= "\n\t\t\t\t\t".'</td>';
	$echo_str .= "\n\t\t\t\t".'</tr>';
	$echo_str .= "\n\t\t\t".'</tbody>';
	$echo_str .= "\n\t\t".'</table>';
	$echo_str .= "\n\t".'</div>';
	$handler = 'function() { wfu_cleanlog_initialize_elements(); }';
	$echo_str .= "\n\t".'<script type="text/javascript">if(window.addEventListener) { window.addEventListener("load", '.$handler.', false); } else if(window.attachEvent) { window.attachEvent("onload", '.$handler.'); } else { window["onload"] = '.$handler.'; }</script>';
	$echo_str .= "\n".'</div>';
	
	echo $echo_str;
}

function wfu_sync_database_controller($nonce) {
	if ( !current_user_can( 'manage_options' ) ) return -1;
	if ( !wp_verify_nonce($nonce, 'wfu_maintenance_actions') ) return -1;
	
	return wfu_sync_database();
}

function wfu_clean_log_parse_data($data) {
	$ret = array( "result" => true );
	$data = sanitize_text_field($data);
	$data_array = explode(":", $data);
	if ( count($data_array) == 0 ) $ret["result"] = false;
	elseif ( $data_array[0] == "0" ) {
		$ret["code"] = "0";
		if ( count($data_array) != 2 || strlen($data_array[1]) != 8 ) $ret["result"] = false;
		else {
			$ret["dateold"] = strtotime(substr($data_array[1], 0, 4)."-".substr($data_array[1], 4, 2)."-".substr($data_array[1], 6, 2)." 00:00");
			if ( $ret["dateold"] > time() ) $ret["result"] = false;
		}
	}
	elseif ( $data_array[0] == "1" ) {
		$ret["code"] = "1";
		if ( count($data_array) != 3 ) $ret["result"] = false;
		else {
			$ret["periodold"] = (int)$data_array[1];
			if ( $ret["periodold"] <= 0 ) $ret["result"] = false;
			elseif ( $data_array[2] == 'd' ) $ret["periodtype"] = 'days';
			elseif ( $data_array[2] == 'm' ) $ret["periodtype"] = 'months';
			elseif ( $data_array[2] == 'y' ) $ret["periodtype"] = 'years';
			else $ret["result"] = false;
		}
	}
	elseif ( $data_array[0] == "2" ) {
		$ret["code"] = "2";
		if ( count($data_array) != 3 || strlen($data_array[1]) != 8 || strlen($data_array[2]) != 8 ) $ret["result"] = false;
		$ret["datefrom"] = strtotime(substr($data_array[1], 0, 4)."-".substr($data_array[1], 4, 2)."-".substr($data_array[1], 6, 2)." 00:00");
		if ( $ret["datefrom"] > time() ) $ret["result"] = false;
		else {
			$ret["dateto"] = strtotime(substr($data_array[2], 0, 4)."-".substr($data_array[2], 4, 2)."-".substr($data_array[2], 6, 2)." 00:00");
			if ( $ret["dateto"] > $ret["datefrom"] ) $ret["result"] = false;
		}
	}
	elseif ( $data_array[0] == "3" ) {
		$ret["code"] = "3";
		if ( count($data_array) != 1 ) $ret["result"] = false;
	}
	else $ret["result"] = false;
	
	return $ret;
}

function wfu_clean_log_prompt($nonce, $data_enc) {
	$siteurl = site_url();

	if ( !current_user_can( 'manage_options' ) || !wp_verify_nonce($nonce, 'wfu_maintenance_actions') ) return wfu_maintenance_actions();
	//parse data
	$data = wfu_clean_log_parse_data($data_enc);
	if ( $data["result"] == false ) return wfu_maintenance_actions();

	$echo_str = "\n".'<div class="wrap">';
	$echo_str .= "\n\t".'<div style="margin-top:20px;">';
	$echo_str .= "\n\t\t".'<a href="'.$siteurl.'/wp-admin/options-general.php?page=wordpress_file_upload&amp;action=maintenance_actions" class="button" title="go back">Go back</a>';
	$echo_str .= "\n\t".'</div>';
	$echo_str .= "\n\t".'<h2 style="margin-bottom: 10px;">Clean Database Log</h2>';
	$echo_str .= "\n\t".'<form enctype="multipart/form-data" name="clean_log" id="clean_log" method="post" action="'.$siteurl.'/wp-admin/options-general.php?page=wordpress_file_upload" class="validate">';
	$nonce = wp_nonce_field('wfu_clean_log', '_wpnonce', false, false);
	$nonce_ref = wp_referer_field(false);
	$echo_str .= "\n\t\t".$nonce;
	$echo_str .= "\n\t\t".$nonce_ref;
	$echo_str .= "\n\t\t".'<input type="hidden" name="action" value="clean_log">';
	$echo_str .= "\n\t\t".'<input type="hidden" name="data" value="'.$data_enc.'">';
	if ( $data["code"] == "0" )
		$echo_str .= "\n\t\t".'<label>This will erase all database records <strong>before '.date("Y-m-d", $data["dateold"]).'</strong> kept by the plugin in the database (like file metadata and userdata, however files uploaded by the plugin will be maintained). Are you sure that you want to continue?</label><br/>';
	elseif ( $data["code"] == "1" )
		$echo_str .= "\n\t\t".'<label>This will erase all database records <strong>older than '.$data["periodold"].' '.$data["periodtype"].'</strong> kept by the plugin in the database (like file metadata and userdata, however files uploaded by the plugin will be maintained). Are you sure that you want to continue?</label><br/>';
	elseif ( $data["code"] == "2" )
		$echo_str .= "\n\t\t".'<label>This will erase all database records <strong>between '.date("Y-m-d", $data["datefrom"]).' and '.date("Y-m-d", $data["dateto"]).'</strong> kept by the plugin in the database (like file metadata and userdata, however files uploaded by the plugin will be maintained). Are you sure that you want to continue?</label><br/>';
	else
		$echo_str .= "\n\t\t".'<label>This will erase <strong>ALL</strong> database records kept by the plugin in the database (like file metadata and userdata, however files uploaded by the plugin will be maintained). Are you sure that you want to continue?</label><br/>';
	$echo_str .= "\n\t\t".'<p class="submit">';
	$echo_str .= "\n\t\t\t".'<input type="submit" class="button-primary" name="submit" value="Yes">';
	$echo_str .= "\n\t\t\t".'<input type="submit" class="button-primary" name="submit" value="Cancel">';
	$echo_str .= "\n\t\t".'</p>';
	$echo_str .= "\n\t".'</form>';
	$echo_str .= "\n".'</div>';
	return $echo_str;
}

function wfu_clean_log() {
	$a = func_get_args(); $a = WFU_FUNCTION_HOOK(__FUNCTION__, $a, $out); if (isset($out['vars'])) foreach($out['vars'] as $p => $v) $$p = $v; switch($a) { case 'R': return $out['output']; break; case 'D': die($out['output']); }
	global $wpdb;

	if ( !current_user_can( 'manage_options' ) ) return -1;
	if ( !check_admin_referer('wfu_clean_log') ) return -1;
	
	$count = -1;
	if ( isset($_POST['data']) && isset($_POST['submit']) && $_POST['submit'] == "Yes" ) {
		$data = wfu_clean_log_parse_data($_POST['data']);
		if ( $data["result"] ) {
			$table_name1 = $wpdb->prefix . "wfu_log";
			$table_name2 = $wpdb->prefix . "wfu_userdata";
			//$table_name3 = $wpdb->prefix . "wfu_dbxqueue";

			$query1 = "DELETE FROM $table_name1";
			$query2 = "DELETE FROM $table_name2";
			//$query3 = "DELETE FROM $table_name3";
			if ( $data["code"] == "0" ) {
				$query1 .= " WHERE date_from < '".date('Y-m-d H:i:s', $data["dateold"])."'";
				$query2 .= " WHERE date_from < '".date('Y-m-d H:i:s', $data["dateold"])."'";
			}
			elseif ( $data["code"] == "1" ) {
				$date = strtotime(date('Y-m-d', strtotime('-'.$data["periodold"].' '.$data["periodtype"]))." 00:00");
				$query1 .= " WHERE date_from < '".date('Y-m-d H:i:s', $date)."'";
				$query2 .= " WHERE date_from < '".date('Y-m-d H:i:s', $date)."'";
			}
			elseif ( $data["code"] == "2" ) {
				$query1 .= " WHERE date_from < '".date('Y-m-d H:i:s', $data["datefrom"] + 86400)."' AND date_from >= '".date('Y-m-d H:i:s', $data["dateto"])."'";
				$query2 .= " WHERE date_from < '".date('Y-m-d H:i:s', $data["datefrom"] + 86400)."' AND date_from >= '".date('Y-m-d H:i:s', $data["dateto"])."'";
			}
			$count = $wpdb->query($query1);
			$count += $wpdb->query($query2);
			//$count += $wpdb->query($query3);
		}
	}
	
	return $count;
}


function wfu_process_all_transfers($clearfiles = false) {
	$a = func_get_args(); $a = WFU_FUNCTION_HOOK(__FUNCTION__, $a, $out); if (isset($out['vars'])) foreach($out['vars'] as $p => $v) $$p = $v; switch($a) { case 'R': return $out['output']; break; case 'D': die($out['output']); }
	global $wpdb;
	if ( $clearfiles ) {
		$table_name1 = $wpdb->prefix . "wfu_log";
		$table_name3 = $wpdb->prefix . "wfu_dbxqueue";
		$wpdb->query('DELETE FROM '.$table_name3);
	}
	wfu_schedule_transfermanager(true);
}

function wfu_reset_all_transfers_controller($nonce) {
	if ( !current_user_can( 'manage_options' ) ) return false;
	if ( !wp_verify_nonce($nonce, 'wfu_maintenance_actions') ) return false;
	
	wfu_process_all_transfers();
	
	return true;
}

function wfu_clear_all_transfers_controller($nonce) {
	if ( !current_user_can( 'manage_options' ) ) return false;
	if ( !wp_verify_nonce($nonce, 'wfu_maintenance_actions') ) return false;
	
	wfu_process_all_transfers(true);
	
	return true;
}

?>