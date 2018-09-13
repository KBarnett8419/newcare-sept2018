<?php
/**
* Template Name: Time Sheet Form
*
* @package WordPress
* @subpackage Chorui
* @since Chorui 1.0
*/
get_header('custom'); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
    <div class="timesheet_form" style="margin: 0 25px; font-family: sans-serif;" align="center">
        <div class="header_title">
        <h1 style="margin: 100px 0 0 0; font-size: 25px;">Time Sheet</h1>
        <p>NEW CARE ASSOCIATES, LLC</p>
        <p>7 GLENWOOD AVE EAST ORANGE, NJ 07017</p>
        </div>
        <div class="block1">
        <?php if ($_GET['results'] == "success"): ?>
        <p style="color: green; margin-bottom: 20px;">Message sent successfully</p>
        <?php elseif ($_GET['results'] == "fail"): ?>
        <p style="color: red; margin-bottom: 20px;">Failed to send message</p>
        <?php endif; ?>

<div class="time-overflow" style="overflow-x: auto;">

  <p class="mobile-timesheet" style="color: #9b1e2d; text-align: center;">Mobile / Tablet Users: Scroll right to access entire table</p>

        <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
        <table class="table1">
          <tr>
            <td class="text">STAFF WORKER NAME</td>
            <td><input type="text" name="staff_name" required></td>
            <td class="text">Pay Period Start Date:</td>
            <td><input type="text" name="pay_period_start" value="<?php echo esc_attr( get_option('pay_period_start') ); ?>"  disabled /></td>
          </tr>
          <tr>
            <td class="text">YOUTH'S NAME</td>
            <td><input type="text" name="client_name" required></td>
            <td class="text">Pay Period End Date:</td>
            <td><input type="text" name="pay_period_end" value="<?php echo esc_attr( get_option('pay_period_end') ); ?>" disabled /></td>
          </tr>
          <tr>
            <td class="text">AUTHORIZATION PERIOD</td>
            <td colspan="3"><input type="text" name="auth_per_start" /> - <input type="text" name="auth_per_end" />
            </td>
          </tr>
          <tr>
            <td class="text">WEEKLY HOURS</td>
            <td><input type="text" name="hr_per_wk" value="<?php echo esc_attr( get_option('hr_per_wk') ); ?>" disabled /></td>
            <td class="text">Employee Phone:</td>
            <td><input type="text" name="employee_phone"/></td>
          </tr>

          <tr>
            <td class="text">SERVICE PROVIDED</td>
            <td><input type="text" name="service_provided"/></td>
            <td class="text">Employee Email:</td>
            <td><input type="email" name="employee_email" required></td>
          </tr>
        </table>
        <table class="table2">
          <tr>
            <th>Day</th>
            <th>Date</th>
            <th>START TIME</th>
            <th>END TIME</th>
            <th>TOTAL HOURS</th>
          </tr>
        <?php
        $today = date("Y-m-d");
        $begin = new DateTime( get_option('pay_period_start') );
        $end = new DateTime( get_option('pay_period_end') );

        $end1 = $end->format('Y-m-d');
        $begin1 = strtotime($begin1);
        $end1 = strtotime($end1);

       if ( $end1 < $today1 ) {
        $begin = $begin->modify( '+7 day' );
        $end = $end->modify( '+7 day' );
       }

        $end = $end->modify( '+1 day' );
        $interval =  new DateInterval('P1D');;
        $period = new DatePeriod($begin, $interval, $end);

        foreach ( $period as $dt => $key ) {
          echo "<tr>";
          echo "<td>".$key->format( "l" )."</td>";
          echo "<td>".$key->format( "m/d/Y" )."</td>";
          echo "<td><input type='text' name='starttime[]'/></td>";
          echo "<td><input type='text' name='endtime[]'/></td>";

          if ($dt == 6) {
           echo "<td><input type='text' name='totalhour[]' class='totalhour firstweek' /></td>";
          } elseif ($dt == 13) {
            echo "<td><input type='text' name='totalhour[]' class='totalhour secondweek'  /></td>";
          } else {
            echo "<td><input type='text' name='totalhour[]' class='totalhour' /></td>";
          }

          echo "</tr>";
        }
        ?>
          <tr>
            <td colspan="2" style="text-align: right;"><b>Total Hours</b></td>
            <td><input type='text' name='tothrs_starttime'/></td>
            <td><input type='text' name='tothrs_endtime'/></td>
            <td><input type='text' name='tothrs_totalhour' class="tothrs_totalhour" /></td>
          </tr>
          <tr style="display: none;">
            <td colspan="2" style="text-align: right;"><b>Total Pay</b></td>
            <td><input type='text' name='totpay_starttime'/></td>
            <td><input type='text' name='totpay_endtime'/></td>
            <td><input type='text' name='totpay_totalhour'/></td>
          </tr>
        </table>

</div><!--time-overflow-->

        <div align="center">
        <p>BY SUBMITTING, I CERTIFY THAT THE ABOVE INFORMATION IS TRUE AND CORRECT TO THE BEST OF MY KNOWLEDGE. I AM ALSO AGREEING THAT I WILL BE HELD RESPONSIBLE IF THE INFORMATION PROVIDED HAS BEEN FALSIFIED.</p>
        <input type='hidden' value="" name="explain_ftwk" class="explain_ftwk" />
        <input type='hidden' value="" name="explain_snwk" class="explain_snwk" />

      <div class="timesheet-submit" style="text-align: center;">
        <input type="hidden" name="actioned" value="send_timesheet_form">
        <input type="submit" name="send_timesheet" class="update_submit_btn" value="Send Time Sheet">
      </div>

        </div>
        </form>
        </div>
    </div>



    </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer(); ?>
