<?php
/**
* Template Name: Supervisor Form
*/
get_header('custom'); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="timshtfrm" method="post">
<!-- Supervisor Form -->          

<div id="suprb" style="padding-top: 50px;">
    <div class="title">
    <h2>SUPERVISOR PROGRESS NOTES</h2>
    <p>Fill out all required fields of the Progress Notes and click NEXT to fill out and submit your Time Sheet. You will not be able to move to the next screen if information is missing.</p>

        <?php if ($_GET['results'] == "success"): ?>
        <p style="color: green; margin-bottom: 20px;">Message sent successfully</p>
        <?php elseif ($_GET['results'] == "fail"): ?>
        <p style="color: red; margin-bottom: 20px;">Failed to send message</p>
        <?php endif; ?>

    </div>
    
    <div class="content">

      <label class="intx">Your Email Address <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="email" name="sp-email" required>
      </div>

      <label class="intx">Youth Name <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-youthname" required>
      </div>

      <label class="intx">Supervisor Name <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-supname" required>
      </div>    

      <label class="intx">Tech Name <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-techname" required>
      </div>   

      <label class="intx">Authorization Date <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-authdate" id="datepicker" required>
      </div>  

      <label class="intx">Case Manager <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-casemg" required>
      </div>  

      <label class="intx">Visit Date <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-visitdate" id="datepicker1" required>
      </div> 

      <label class="intx">Session Time <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-sessiontime" required>
      </div> 

      <label class="intx">Diagnosis <span class="rqur">*</span> </label>
      <div class="infild">
        <input type="text" name="sp-diagnosis" required>
      </div> 

       <h3 style="margin: 20px 0;">Progress Notes</h3>

      <label class="intx">Youth progress since services start <span class="rqur">*</span> </label>
      <div class="infild">
        <textarea name="sp-youthprog" required></textarea>
      </div> 

      <label class="intx">Changes on the medication (if applicable) <span class="rqur">*</span> </label>
      <div class="infild">
        <textarea name="sp-changemed" required></textarea>
      </div>  
      
      <label class="intx">Goals worked this week <span class="rqur">*</span> </label>
      <div class="infild">
        <textarea name="sp-goalwrk" required></textarea>
      </div>  

      <label class="intx">Strategies and techniques being used by TECH during this week <span class="rqur">*</span> </label>
      <div class="infild">
        <textarea name="sp-strattech" required></textarea>
      </div>       

      <label class="intx">Any crisis/incident situation that happened and how was handled <span class="rqur">*</span> </label>
      <div class="infild">
        <textarea name="sp-crisis" required></textarea>
      </div> 

      <div>
          <input type="checkbox" name="agree" value="Yes" checked> BY SUBMITTING, I CERTIFY THAT ALL INFORMATION SUBMITTED IS TRUE TO THE BEST OF MY KNOWLEDGE. I UNDERSTAND THAT FALSIFYING THIS INFORMATION RESULTS IN CONSEQUENCES IN WHICH I AM SOLELY RESPONSIBLE.
      </div>

      <div align="center" class="btnnext">
        <input type="button" class="superv_next" value="NEXT">
      </div>
    </div>
  </div> <!-- Supervisor Form End -->   

    
    <!-- Time Sheet Form -->   
    <div class="timesheet_form" style="margin: 0 25px; font-family: sans-serif; display: none" align="center">
        <div class="header_title">
        <h1 style="margin: 100px 0 0 0; font-size: 25px;">Time Sheet</h1>
        <p>NEW CARE ASSOCIATES, LLC</p>
        <p>7 GLENWOOD AVE EAST ORANGE, NJ 07017</p>
        <h3 style="color:red;">Please enter the exact time you worked followed with AM or PM.</h3>
        <h3 id="visitdate" style="color: red"></h3>
        </div>
        <div class="block1">

<div class="time-overflow" style="overflow-x: auto;">

   <p class="mobile-timesheet" style="color: #9b1e2d; text-align: center; margin: 0 0 30px 0;">Mobile / Tablet Users: Scroll right to access entire table</p>

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
            <td colspan="3"><input type="text" name="auth_per_start" id="datepickertime" /> - <input type="text" id="datepickertime1" name="auth_per_end" />
            </td>
          </tr>
          <tr>
            <td class="text">WEEKLY HOURS</td>
            <td><input type="text" name="hr_per_wk" id="hr_per_wk" value="<?php echo esc_attr( get_option('hr_per_wk') ); ?>" disabled /></td>
            <td class="text">Employee Phone:</td>
            <td><input type="text" name="employee_phone"/></td>
          </tr>

          <tr>
            <td class="text">SERVICE PROVIDED</td>
            <td><input type="text" name="service_provided"/></td>
            <td class="text">Employee Email:</td>
            <td><input type="email" name="employee_email" required></td>
          </tr>
          <tr>
            <td class="text">Notes</td>
            <td colspan="3">
              <textarea name="note" rows="6" style="width: 95%;"></textarea>
            </td>
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

        $end = $end->modify( '+1 day' );
        $interval =  new DateInterval('P1D');;
        $period = new DatePeriod($begin, $interval, $end);

        foreach ( $period as $dt => $key ) {
          $sl=$dt+1;
          echo "<tr>";
          echo "<td>".$key->format( "l" )."</td>";
          echo "<td>".$key->format( "m/d/Y" )."</td>";
          echo "<td><input type='time' name='starttime[]' class='st".$sl." starttime' ></td>
                <td><input type='time' name='endtime[]' class='et".$sl." endtime'></td>
                <td><input type='text' name='totalhour[]' class='tlhr".$sl." totalhour'></td>
                </tr>";
        }
            ?>
          <tr>
            <td colspan="4" style="text-align: right;"><b>Total Hours</b></td>
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
        <input type="hidden" name="superv_action" value="superv">
        <input type="button" name="send_timesheet" class="update_submit_btn" value="Send Time Sheet">
      </div>

        </div>
        </div>
    </div>
    <!-- Time Sheet Form End --> 

</form>

    </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer(); ?>
