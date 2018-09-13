<?php

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['actioned'] ) && $_POST['actioned'] == 'send_timesheet_form' ) {

$message = '<html><body>';

$message .= '
    <div class="timesheet_form" align="center">
        <div class="header_title" style="margin: 0 0 50px 0;">
        <h1>Time Sheet</h1>
        <h3>NEW CARE ASSOCIATES, LLC</h3>
        <p>7 GLENWOOD AVE EAST ORANGE, NJ 07017</p>
        </div>
        <div class="block1" style="width: 800px;">
        <table class="table1" style="width: 100%; margin-bottom: 30px;" cellspacing="0" cellpadding="10">
          <tr>
            <td style="width: 25%;  text-align: right;">Staff Worker Name :</td>
            <td style="width: 25%;">'.$_POST['staff_name'].'</td>
            <td style="width: 25%;  text-align: right;">Pay Period Start Date :</td>
            <td style="width: 25%; ">'.get_option('pay_period_start').'</td>
          </tr>
          <tr>
            <td style="width: 25%;  text-align: right;">Client Name :</td>
            <td style="width: 25%; ">'.$_POST['client_name'].'</td>
            <td style="width: 25%;  text-align: right;">Pay Period End Date :</td>
            <td style="width: 25%; ">'.get_option('pay_period_end').'</td>
          </tr>
          <tr>
            <td style="width: 25%;  text-align: right;">Authorization Period :</td>
            <td colspan="3">'.$_POST['auth_per_start'].' - '.$_POST['auth_per_end'].'</td>
          </tr>
          <tr>
            <td style="width: 25%;  text-align: right;">Weekly Hours :</td>
            <td style="width: 25%; ">'.get_option('hr_per_wk').'</td>
            <td style="width: 25%;  text-align: right;">Employee Phone :</td>
            <td style="width: 25%; ">'.$_POST['employee_phone'].'</td>
          </tr>
          <tr>
            <td style="width: 25%;  text-align: right;">Service Provided :</td>
            <td style="width: 25%; ">'.get_option('service_provided').'</td>
            <td style="width: 25%;  text-align: right;">Employee Email:</td>
            <td style="width: 25%; ">'.$_POST['employee_email'].'</td>
          </tr>
        </table>
        <table class="table2" style="width: 800px; margin-bottom: 30px;" cellspacing="0" cellpadding="10">
          <tr>
            <th style="border: 1px solid #ddd;  width: 20%; background: #eee;">Day</th>
            <th style="border: 1px solid #ddd;  width: 20%; background: #eee;">Date</th>
            <th style="border: 1px solid #ddd;  width: 20%; background: #eee;">START TIME</th>
            <th style="border: 1px solid #ddd;  width: 20%; background: #eee;">END TIME</th>
            <th style="border: 1px solid #ddd;  width: 20%; background: #eee;">TOTAL HOURS</th>
          </tr>';


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
          $message .= '<tr>
          <td style="border: 1px solid #ddd;  width: 20%;">'.$key->format( 'l' ).'</td>
          <td style="border: 1px solid #ddd;  width: 20%;">'.$key->format( 'm/d/Y' ).'</td>
          <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['starttime'][$dt].'</td>
          <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['endtime'][$dt].'</td>
          <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['totalhour'][$dt].'</td>
          </tr>';
                  }

        $message .='<tr>
            <td colspan="2" style="border: 1px solid #ddd;  width: 20%; text-align: right;"><b>Total Hours</b></td>
            <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['tothrs_starttime'].'</td>
            <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['tothrs_endtime'].'</td>
            <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['tothrs_totalhour'].'</td>
          </tr>

        </table>
        <p style="text-align: left;"><b>First week explanation for overage:</b> '.$_POST['explain_ftwk'].'</p>
        <p style="text-align: left;"><b>Second week explanation for overage:</b> '.$_POST['explain_snwk'].'</p>
        </div>
    </div>';


$message .= '</body></html>';
$staff_name = $_REQUEST["staff_name"];
$employee_email = $_REQUEST["employee_email"];

require_once( get_template_directory() . '/employee/php_mailer/class.phpmailer.php');

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "newcarenj.org";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "admin@newcarenj.org";
$mail->Password = "Admin@123";
$mail->SetFrom("admin@newcarenj.org");
$mail->Subject = "Time Sheet Report from $staff_name";
$mail->Body = $message;
$mail->AddAddress("documents@newcarenj.org");
$mail->AddAddress("$employee_email");
 if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
	header("Location: https://newcarenj.org/timsht/?results=success");
	die();
    }

} else {
	header("Location: https://newcarenj.org/timsht/?results=fail");
	die();
	}

?>
