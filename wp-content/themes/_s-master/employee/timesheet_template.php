<?php
/**
* Template Name: Time Sheet Setting
*
* @package WordPress
* @subpackage Chorui
* @since Chorui 1.0
*/
get_header('custom'); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

<div class="timesheet-wrapper" style="font-family: sans-serif;">

	<h1 style="text-align: center; margin: 100px 0 0 0; font-size: 25px;">Time Sheet Setting</h1>

<?php
   /* if (!empty($_POST['pay_period_start']) && !empty($_POST['pay_period_end']) && !empty($_POST['hr_per_wk']) && !empty($_POST['total_unit_allow'])) {*/
   if (!empty($_POST['pay_period_start']) && !empty($_POST['pay_period_end']) && !empty($_POST['hr_per_wk'])) {
            update_option('pay_period_start',$_POST['pay_period_start']);
            update_option('pay_period_end',$_POST['pay_period_end']);
            /* update_option('auth_per_start',$_POST['auth_per_start']);
            update_option('auth_per_end',$_POST['auth_per_end']); */
            update_option('hr_per_wk',$_POST['hr_per_wk']);
            /*update_option('total_unit_allow',$_POST['total_unit_allow']);*/
    }
?>

<div class="time-table-wrap" style="overflow-x: auto;">

<form id="save-theme" name="save-theme" action="" method="post">
    <table class="form-table timesheet_setting_table">
        <tr valign="top">
        <th scope="row">Pay Period Start Date</th>
        <td><input type="text" name="pay_period_start" value="<?php echo esc_attr( get_option('pay_period_start') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Pay Period End Date</th>
        <td><input type="text" name="pay_period_end" value="<?php echo esc_attr( get_option('pay_period_end') ); ?>" /></td>
        </tr>


        <tr valign="top">
        <th scope="row">Weekly Hours</th>
        <td><input type="text" name="hr_per_wk" value="<?php echo esc_attr( get_option('hr_per_wk') ); ?>" /></td>
        </tr>


       <tr valign="top">
        <th scope="row">
	    <input type="hidden" name="action" value="update_theme">
		<input type="submit" name="update-options" class="update_submit_btn" value="Save">
        </th>
        <td>&nbsp;</td>
        </tr>

    </table>

</form>

</div><!--time-overflow-->

</div><!--timesheet-wrapper-->


    </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer(); ?>
