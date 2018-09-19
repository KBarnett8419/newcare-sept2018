<?php

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['superv_action'] ) && $_POST['superv_action'] == 'superv' ) {

$message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demystifying Email Design</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="5" style="font-size: 16px;" cellspacing="0" width="600">
<tr>
<td><h3>SUPERVISOR PROGRESS NOTES</h3></td>
</tr>
<tr>
<td><b>Your Email Address:</b> '.$_POST['sp-email'].'</td>
</tr>
<tr>
<td><b>Youth Name:</b> '.$_POST['sp-youthname'].'</td>
</tr>
<tr>
<td><b>Supervisor Name:</b> '.$_POST['sp-supname'].'</td>
</tr>
<tr>
<td><b>Tech Name:</b> '.$_POST['sp-techname'].'</td>
</tr>
<tr>
<td><b>Authorization Date:</b> '.$_POST['sp-authdate'].'</td>
</tr>
<tr>
<td><b>Case Manager:</b> '.$_POST['sp-casemg'].'</td>
</tr>
<tr>
<td><b>Visit Date:</b> '.$_POST['sp-visitdate'].'</td>
</tr>
<tr>
<td><b>Session Time:</b> '.$_POST['sp-sessiontime'].'</td>
</tr>
<tr>
<td><b>Diagnosis:</b> '.$_POST['sp-diagnosis'].'</td>
</tr>
<tr>
<td><b><u>Progress Notes</u></b></td>
</tr>
<tr>
<td><b>Youth progress since services start:</b><br> '.$_POST['sp-youthprog'].'</td>
</tr>
<tr>
<td><b>Changes on the medication:</b> <br>'.$_POST['sp-changemed'].'</td>
</tr>
<tr>
<td><b>Goals worked this week:</b><br> '.$_POST['sp-goalwrk'].'</td>
</tr>
<tr>
<td><b>Strategies and techniques being used by TECH during this week:</b> <br>'.$_POST['sp-strattech'].'</td>
</tr>
<tr>
<td><b>Any crisis/incident situation that happened and how was handled:</b><br> '.$_POST['sp-crisis'].'</td>
</tr>
<tr>
<td><h3>TIME SHEET REPORT</h3></td>
</tr>
<tr>
<td><b>Staff Worker Name:</b> '.$_POST['staff_name'].'</td>
</tr>
<tr>
<td><b>Youth Name:</b> '.$_POST['client_name'].'</td>
</tr>
<tr>
<td><b>Authorization Period:</b> '.$_POST['auth_per_start'].' - '.$_POST['auth_per_end'].'</td>
</tr>
<tr>
<td><b>Service Provided:</b> '.$_POST['service_provided'].'</td>
</tr>
<tr>
<td><b>Pay Period Start Date:</b> '.get_option('pay_period_start').'</td>
</tr>
<tr>
<td><b>Pay Period End Date:</b> '.get_option('pay_period_end').'</td>
</tr>
<tr>
<td><b>Weekly Hours:</b> '.get_option('hr_per_wk').'</td>
</tr>
<tr>
<td><b>Employee Phone:</b> '.$_POST['employee_phone'].'</td>
</tr>
<tr>
<td><b>Employee Email:</b> '.$_POST['employee_email'].'</td>
</tr>
<tr>
<td><b>Note:</b><br> '.$_POST['note'].'</td>
</tr>
</table>
    
        <table border="1" cellpadding="5" style="font-size: 16px; margin: 50px 0 0 0;" cellspacing="0" width="600">
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
            <td colspan="4" style="border: 1px solid #ddd;  width: 20%; text-align: right;"><b>Total Hours</b></td>
            <td style="border: 1px solid #ddd;  width: 20%;">'.$_POST['tothrs_totalhour'].'</td>
          </tr>

        </table>';


$message .= '</body></html>';

$staff_name = $_POST["staff_name"];
$employee_email = $_POST['sp-email'];


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
$mail->Subject = "Supervisor Progress Notes and Time Sheet Report from $staff_name";
$mail->Body = $message;
$mail->AddAddress("documents@newcarenj.org");
$mail->AddAddress($employee_email);

 if(!$mail->Send())
    {
    echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
  header("Location: https://newcarenj.org/supervisor-progress-notes/?results=success");
  die();
    }

} else {
  
  header("Location: https://newcarenj.org/supervisor-progress-notes/?results=fail");
  die();
  }

