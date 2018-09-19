<?php
// create custom plugin settings menu
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create new top-level menu
	add_menu_page('Time Sheet Settings', 'Time Sheet', 'administrator', __FILE__, 'time_sheet_settings_page' , null, 999 );

	//call register settings function
	add_action( 'admin_init', 'register_time_sheet_settings' );
}


function register_time_sheet_settings() {
	//register our settings
	register_setting( 'time-sheet-settings-group', 'pay_period_start' );
	register_setting( 'time-sheet-settings-group', 'pay_period_end' );
	/* register_setting( 'time-sheet-settings-group', 'auth_per_start' );
    register_setting( 'time-sheet-settings-group', 'auth_per_end' ); */
    register_setting( 'time-sheet-settings-group', 'hr_per_wk' );
    register_setting( 'time-sheet-settings-group', 'total_unit_allow' );
}

function time_sheet_settings_page() {
?>
<div class="wrap">
<h1>Time Sheet Setting</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'time-sheet-settings-group' ); ?>
    <?php do_settings_sections( 'time-sheet-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Pay Period Start Date</th>
        <td><input type="text" name="pay_period_start" value="<?php echo esc_attr( get_option('pay_period_start') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Pay Period Start Date</th>
        <td><input type="text" name="pay_period_end" value="<?php echo esc_attr( get_option('pay_period_end') ); ?>" /></td>
        </tr>
        
        <!--
        <tr valign="top">
        <th scope="row">Authorization Period</th>
        <td><input type="text" name="auth_per_start" value="<?php // echo esc_attr( get_option('auth_per_start') ); ?>" />
        - <input type="text" name="auth_per_end" value="<?php // echo esc_attr( get_option('auth_per_end') ); ?>" />
        </td>
        </tr>-->

        <tr valign="top">
        <th scope="row">Hours Per Week</th>
        <td><input type="text" name="hr_per_wk" value="<?php echo esc_attr( get_option('hr_per_wk') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Total Units Allowed</th>
        <td><input type="text" name="total_unit_allow" value="<?php echo esc_attr( get_option('total_unit_allow') ); ?>" /></td>
        </tr>        

    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>

<?php 

/* Add CSS Style */
function timesheet_css () {
wp_enqueue_style ('timesheet_setting', get_template_directory_uri().'/employee/css/timesheet.css', array(), rand(111,9999), 'all');
wp_enqueue_style ('jquery-ui-css', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), rand(111,9999), 'all');
wp_enqueue_style ('superv-css', get_template_directory_uri().'/employee/css/super.css', array(), rand(111,9999), 'all');
}

add_action ('wp_enqueue_scripts', 'timesheet_css');

// Add Custom JS
function timesheetjs () {
wp_enqueue_script ('timesheet_js', get_template_directory_uri().'/employee/js/timesheet.js', array('jquery'), rand(111,9999), true);
wp_enqueue_script ('jquery-ui-js', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), rand(111,9999), true);
wp_enqueue_script ('jquery.validate', get_template_directory_uri().'/employee/js/jquery.validate.js', array('jquery'), rand(111,9999), true);
}

add_action('wp_enqueue_scripts', 'timesheetjs');

/* Send Time Sheet */
    function wpse_send_time_sheet(){
    if( isset($_POST['actioned']) == 'send_timesheet_form' ) {
        require('send_timesheet.php');
        die();
    }
}
add_action('init','wpse_send_time_sheet');


/* Send Supervisor Form */
 function wpse_send_supervisor(){
    if( isset($_POST['superv_action']) == 'superv' ) {
        require('send_supervisor.php');
        die();
    }
}
add_action('init','wpse_send_supervisor');