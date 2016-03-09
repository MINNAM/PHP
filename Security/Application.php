<?php
$dateid = '';
$date = getdate();
$dateid .= chr(($date["year"] - 2016) + 65);
$dateid .= chr(($date["mon"] - 1) + 65);
if($date["mday"] < 10) {
    $dateid .= ($date["mday"] - 1) . '.';
} else {
    $dateid .= chr(($date["mday"] - 10) + 65) . '.';
}
$ms = ($date["hours"] * 360000) + ($date["minutes"] * 60000) + ($date["seconds"] * 1000) + random_int(0, 999);
$dateid .= strtoupper(substr_replace(dechex($ms), '.', 3, 0));

var_dump($_POST);
$clean = [];

foreach($_POST as $key => $value) {
	if(strcmp($value, '') != 0 && strcmp($key, 'estimate') != 0 && strcmp($key, 'next') != 0) {
		$clean[$key] = strip_tags(trim($value));
	}
}

$link = '<a href="https://secure.vec.ca/apply/?';
$link .= http_build_query($clean);
$link .= '" target="_blank" style="font-size: 14px; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; text-decoration: none; text-decoration: none; padding: 10px 14px; display: inline-block;">Complete your application</a>';

$useremail = '';
$userrecipients = [];
$usersubject = '';
$userheaders = [];
$userheaders[] = 'Content-Type: text/html; charset=UTF-8';
$userheaders[] = 'From: VEC Admissions <apply@vec.ca>';
$userheaders[] = 'Reply-To: apply@vec.ca';

$trelloemail = '';
$trellosubject = '';
$trellomembers = '';
$trelloheaders = [];
$trellorecipients = [];

$staffsubject = '';
$staffemail = '';
$staffrecipients = [];
$staffrecipients[] = "registrar1@vec.ca";
$staffrecipients[] = "m.estrada@vec.ca";
$staffrecipients[] = "marketing@vec.ca";
$staffrecipients[] = "tech2@vec.ca";

if(isset($_POST['next'])) {
    $thankyoulink = '';

	if($_POST['next'] == "1") {
        $thankyoulink = 'http://vec.ca/quote-confirmation/';
		$usersubject = 'Your VEC Quote - Quote #' . $dateid;
		$trellosubject .= "Potential: " . $clean['email'];
		$trellorecipients[] = 'tech3vec+vx25ki90cx75zeyurg1k@boards.trello.com';
        $useremail = '<!DOCTYPE html>
                                    <html>
                                    <head>
                                    <meta name="viewport" content="width=device-width">
                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                    <title>Your Quote</title>
                                    </head>
                                    <body style="background-color: #fff;-webkit-font-smoothing: antialiased;height: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 0;width: 100%!important;">
                                    <!-- body -->
                                    <table class="body-wrap" style="background-color: #fff;width: 100%;margin: 0;padding: 0;"> 
                                    <tr>
                                    <td class="container" style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0px;background-color: #fff;clear: both!important;display: block!important;max-width: 600px!important;">
                                    <!-- content -->
                                    <div class="content" style="display: block;margin: 0 auto;padding: 0;">
                                    <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;margin: 0;">Hi,<br><br>Thank you for your interest in Vancouver English Centre. Below is a quote based on your selection.</p>
                                    <br>
                                    <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                                    <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                                    <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                                    <tr><td colspan="3" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;">
                                    </td></tr><h2>Quote #' . $dateid . '</h2>';
        if(!isset($clean['eff_program'])) {
            $useremail .= stripslashes($_POST['estimate']);
        }
        $useremail .= '<tr>
                <td colspan="3" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"><br>
                <p style="font-size: 100%;font-style: italic;font-weight: normal;margin: 0;">Please note that this Quote is subject to change.<br>All prices in Canadian Dollars (CAD) and include tax where applicable.<br>Application, Placement and Transportation fees are Non-Refundable.</p>
                </td>
                </tr>
                <br>
                <br>
                <p style="font-weight: 600; color:#000; font-size:150%; margin: 0;">Next Step:</p>
                <ul>
                    <li>' . $link . '</li>
                </ul>
                </table>
                </table>
                </table>
                <br>
                <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;font-weight: normal;color: #000;margin: 0;">Or <a href="https://secure.vec.ca/apply/" target="_blank">request another Quote</a>
                </p>
                <br>
                <br>
                <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;font-weight: normal;margin: 0;">If you have any questions about this Quote or any of our programs, please email us at apply@vec.ca.  For faster service please refer to <strong>Quote #' . $dateid . '</strong> when speaking to one of our representatives.</p> <br>
                <p style="font-weight: normal; font-size:120%; margin: 0;">Thank you,</p>
                <br><br>
                <div><img src="https://secure.vec.ca/wp-content/uploads/2015/11/vec_logo_web.png" alt="VEC Logo"></div>
                <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px"><span style="font-size:9pt;font-family:Arial"><font color="#000000"><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px"><span style="font-size:9pt;font-family:Arial;color:gray"><font color="#000000"><br></font></span></b></font></span></b></div>
                <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px"><span style="font-size:9pt;font-family:Arial;color:gray">Admissions </span></b><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px"><span style="font-size:9pt;font-family:Arial;color:silver">|<span> </span></span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px"><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0)">Vancouver</span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px"><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0)"> English Centre<br>
                </span></b><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(31,73,125);text-transform:none;font-size:8px;white-space:normal;font-family:Arial;word-spacing:0px"></span><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px"><span style="font-size:8pt;font-family:Arial;color:gray">250 Smithe Street, Vancouver, BC V6B 1E7 Canada</span></span>
                <p><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px"><span style="font-size:8pt;font-family:Arial;color:gray"></span></span><span style="font-size:8pt;font-family:Arial;color:gray"></span></p>
                <table style="color:#222222;font-size:13px;font-family:Verdana,Arial,Helvetica,sans-serif;width:230px" border="0" cellpadding="0" cellspacing="1"><tbody><tr style="font-family:Arial"><td style="text-align:left" valign="top" width="105px">
                <span style="color:gray;font-size:9pt">Tel:<br>Email:<br>Main site:</span></td><td style="text-align:right" valign="top" width="115px"><div><div style= "margin: 0;padding: 0px 30px 0px 30px;text-align:left"><div style="text-align:right"></div></div><span style="color:gray"><div><a href="tel:%2B1%20604%20687%201600" value="+16046871600" target="_blank">+1 604 687 1600</a></div><div><a href="mailto:marketing@vec.ca" style="color:rgb(42,93,176);font-size:9pt" target="_blank">apply@vec.ca</a></div><div><a href="http://vec.ca/" style="color:rgb(42,93,176);font-size:9pt" target="_blank">vec.ca</a><br style="color:rgb(34,34,34)"></div><div></div></span></div></td></tr></tbody></table></div>
                <br>
                </div>
                      <!-- /content -->
                    </td>
                    <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"></td>
                  </tr></table>
                <!-- /body -->
                <!-- footer -->
                <table class="footer-wrap" style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; width: 100%; margin: 0; padding: 0;">
                <tr style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"></td>
                <td class="container" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;clear: both !important;display: block !important;max-width: 600px !important;margin: 0 auto;padding: 20px;background-color: #ffffff;border: 1px solid #f0f0f0;">
                <!-- content -->
                <div class="content" style="font-family:\'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;display: block;max-width: 600px;margin: 0 auto;padding: 0;">
                <table style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
                <tr style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
                <td align="left" style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;">
                <p style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 12px;line-height: 1.6em;color: #666666;font-weight: normal;margin: 0 0 10px;padding: 0;">Copyright © 2015 Vancouver English Centre. All rights reserved.</p>
                </td>
                </tr>
                </table>
                </div>
                <!-- /content -->
                </td>
                <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"></td>
                </tr></table>
                <!-- /footer -->
                </body>
                </html>';
    } else if($_POST['next'] == "0") {
        $thankyoulink = 'http://vec.ca/thank-you/';
		$usersubject = 'Your VEC Application';
		$trellosubject .= "Complete: " . $clean['firstname'] . ' ' . $clean['lastname'];
		$trellorecipients[] = 'tech2vec+tq2ijrnqps7f2utcppmf@boards.trello.com';
        if(isset($clean['agent'])) {
            $useremail = '<!DOCTYPE html>
                <html>
                <head>
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Confirmation Email</title>
                </head>
                <body style="background-color: #fff;-webkit-font-smoothing: antialiased;height: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 0;width: 100%!important;">
                    <!-- body -->
                    <table class="body-wrap" style="background-color: #fff;width: 100%;margin: 0;padding: 0;">
                        <tr>
                            <td class="container" style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0 auto;padding: 0px;background-color: #fff;clear: both!important;display: block!important;max-width: 600px!important;">
                                <!-- content -->
                                <div class="content" style="display: block;margin: 0 auto;padding: 0;">
                                    <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;margin: 0;">Hello ' . $clean['agentname'] . ',
                                        <br>
                                        <br>Your <strong>Application #' . $dateid . '</strong> with Vancouver English Centre has been received. We are excited to welcome your client to our campus. Below is a quote based on your selection.</p>
                                        <br>
                                        <br>
                <table class="body-wrap" style="background-color: #fff;width: 100%;margin: 0;padding: 0;"> 
                <tr>
                <td class="container" style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0 auto;padding: 0px;background-color: #fff;clear: both!important;display: block!important;max-width: 600px!important;">
                <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                <table cellspacing="0" style="background="#fff; width:100% border-collapse:collapse; font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0;">
                <tr><td colspan="3" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;">
                </td></tr>';
        } else {
            $useremail = '<!DOCTYPE html>
                            <html>
                                <head>
                                    <meta name="viewport" content="width=device-width">
                                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                                    <title>Confirmation Email</title>
                                </head>
                                <body style="background-color: #fff;-webkit-font-smoothing: antialiased;height: 100%;-webkit-text-size-adjust: none;margin: 0;padding: 0;width: 100%!important;">
                                    <!-- body -->
                                    <table class="body-wrap" style="background-color: #fff;width: 100%;margin: 0;padding: 0;">
                                        <tr>
                                            <td class="container" style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0px;background-color: #fff;clear: both!important;display: block!important;max-width: 600px!important;">
                                                <!-- content -->
                                                <div class="content" style="display: block;margin: 0 auto;padding: 0;">
                                                    <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;margin: 0;"><p>Dear ' . $clean['firstname'] . ',
                                                        <br>
                                                        <br>Thank you! Your application with Vancouver English Centre has been received. We are excited to welcome you to our campus.</p><h2>Application #' . $dateid . '</h2>';
		}
        if(!isset($clean['eff_program'])) {
            $useremail .= stripslashes($_POST['estimate']);
        }
        if(isset($clean['agent'])) {
            $useremail .= '<br>
                            <tr>
                            <td colspan="3" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"><br>
                            <p style="font-size: 100%;font-style: italic;font-weight: normal;margin: 0;">Please note that this Quote is subject to change.<br>All prices in Canadian Dollars (CAD) and include tax where applicable.<br>Application, Placement and Transportation fees are Non-Refundable.</p>
                            </td>
                            </tr>
                            <br>
                            <br>
                            </table>
                            </table>
                            </table>
                                                <p style="font-weight: 600; color:#000; font-size:150%; margin: 0; ">Next Steps:</p><br>
                                                <ol style="font-weight: color:#000; normal; margin: 0;"><li><strong>Pay the Application Fee.</strong></li><li>Receive your Letter of Acceptance</li><li>Apply for a Visa and/or Study Permit</li><li>Receive your Homestay and Airport Pick-up confirmation.</li></ol>
                               <br><br>
                                                <p style="font-weight: 700; color:#000; font-size:120%; margin: 0; ">Did you know?</p><br>
                                                <p style="font-weight: normal; font-size:120%; margin: 0;">VEC has partnered with Flywire to offer an innovative, fast, simple and cost effective way to make international payments. <a href="https://www.peertransfer.com/school/vec" target="_blank ">Try it today!</a></p>
                                                <br>
                                                <br>
                                                <p style="font-weight: 600; color:#000; font-size:100%; margin: 0; ">Things to remember:</p>
                                                <ul style="font-weight: color:#000; normal; margin: 0;"><li>If you need a Visa to enter Canada, don’t forget to let us know once it’s approved.</li><li>Make sure you’re familiar with our Refund Policy.</li><li>Let us know if you will take time-off during your studies at VEC.</li><li>We require flight confirmation (not reservation) in order to issue your Homestay confirmation.</li><li>Vancouver is a multicultural city, and our homestay families reflect that diversity.</li></ul>
                                             <br>
                                              <br>
                                                <p style="font-weight: normal; font-size:120%; margin: 0;">If you have any questions about this application, payments or programs, please contact our Marketing Team and refer to <strong>Application #'. $dateid . '</strong> for faster service.</p><br>
                                               <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;font-weight: normal;margin: 0;">
                            <br><strong>Japan:</strong> japanese@vec.ca
                            <br><strong>China + Taiwan:</strong> chinese@vec.ca
                            <br><strong>Southeast Asia:</strong> thai@vec.ca
                            <br><strong>Brasil:</strong> brasil@vec.ca
                            <br><strong>Latin America + Spain:</strong> estudiar@vec.ca
                            <br><strong>Korea:</strong> korean@vec.ca
                            <br><strong>Middle East:</strong> mena@vec.ca
                            <br><strong>Other:</strong> info@vec.ca</p>
                                                <br>
                                                <p style="font-weight: normal; font-size:120%; margin: 0; ">Thank you,</p>
                                                <br>
                                                <br>
                            <div><img src="https://secure.vec.ca/wp-content/uploads/2015/11/vec_logo_web.png" alt="VEC Logo"></div>
                            <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial "><font color="#000000 "><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:gray "><font color="#000000 "><br></font></span></b></font></span></b></div>
                            <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:gray ">Admissions </span></b><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:silver ">|<span> </span></span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0) ">Vancouver</span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0) "> English Centre<br>
                            </span></b><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(31,73,125);text-transform:none;font-size:8px;white-space:normal;font-family:Arial;word-spacing:0px "></span><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:8pt;font-family:Arial;color:gray ">250 Smithe Street, Vancouver, BC V6B 1E7 Canada</span></span>
                            <p><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:8pt;font-family:Arial;color:gray "></span></span><span style="font-size:8pt;font-family:Arial;color:gray "></span></p>
                            <table style="color:#222222;font-size:13px;font-family:Verdana,Arial,Helvetica,sans-serif;width:230px " border="0 " cellpadding="0 " cellspacing="1 "><tbody><tr style="font-family:Arial "><td style="text-align:left " valign="top " width="105px ">
                            <span style="color:gray;font-size:9pt ">Tel:<br>Email:<br>Main site:</span></td><td style="text-align:right " valign="top " width="115px "><div><div style= "margin: 0;padding: 0px 30px 0px 30px;text-align:left "><div style="text-align:right "></div></div><span style="color:gray "><div><a href="tel:%2B1%20604%20687%201600 " value="+16046871600 " target="_blank ">+1 604 687 1600</a></div><div><a href="mailto:marketing@vec.ca " style="color:rgb(42,93,176);font-size:9pt " target="_blank ">apply@vec.ca</a></div><div><a href="http://vec.ca/ " style="color:rgb(42,93,176);font-size:9pt " target="_blank ">vec.ca</a><br style="color:rgb(34,34,34) "></div>
                                                <br>
                                            </div>
                                            <!-- /content -->
                                        </td>
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                    </tr>
                                </table>
                                <!-- /body -->
                                <!-- footer -->
                                <table class="footer-wrap " style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; width: 100%; margin: 0; padding: 0; ">
                                    <tr style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0; ">
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                        <td class="container " style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;clear: both !important;display: block !important;max-width: 600px !important;margin: 0 auto;padding: 20px;background-color: #ffffff;border: 1px solid #f0f0f0; ">
                                            <!-- content -->
                                            <div class="content " style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;display: block;max-width: 600px;margin: 0 auto;padding: 0; ">
                                                <table style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0; ">
                                                    <tr style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0; ">
                                                        <td align="left " style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; ">

                                                            <p style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 12px;line-height: 1.6em;color: #666666;font-weight: normal;margin: 0 0 10px;padding: 0; ">Copyright © 2015 Vancouver English Centre. All rights reserved.</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <!-- /content -->
                                        </td>
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                    </tr>
                                </table>
                                <!-- /footer -->
                            </body>
                            </html>';
        } else {
            $useremail .= '<tr>
                            <td colspan="3" style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0;"><br>
                            <p style="font-size: 100%;font-style: italic;font-weight: normal;margin: 0;">Please note that this Quote is subject to change.<br>All prices in Canadian Dollars (CAD) and include tax where applicable.<br>Application, Placement and Transportation fees are Non-Refundable.</p>
                            </td>
                            </tr>
                            <br>
                            <br>
                            </table>
                            </table>
                            </table>
                                                <p style="font-weight: 600; color:#000; font-size:150%; margin: 0; ">Next Steps:</p><br>
                                                <ol style="font-weight: color:#000; normal; margin: 0;"><li><strong>Pay the Application Fee.</strong></li><li>Receive your Letter of Acceptance.</li><li>Apply for a Visa and/or Study Permit.</li><li>Receive your Homestay and Airport Pick-up confirmation.</li></ol><br><br>
                                              <p style="font-weight: 700; color:#000; font-size:120%; margin: 0; ">Did you know?</p><br>
                                                <p style="font-weight: normal; font-size:120%; margin: 0;">VEC has partnered with Flywire to offer an innovative, fast, simple and cost effective way to make international payments. <a href="https://www.peertransfer.com/school/vec" target="_blank ">Try it today!</a></p>
                             <br><br>
                                                <p style="font-weight: 600; color:#000; font-size:100%; margin: 0; ">Things to remember:</p>
                                                <ul style="font-weight: color:#000; normal; margin: 0;"><li>If you need a Visa to enter Canada, don’t forget to let us know once it’s approved.</li><li>Make sure you’re familiar with our Refund Policy.</li><li>Let us know if you will take time-off during your studies at VEC.</li><li>We require flight confirmation (not reservation) in order to issue your Homestay confirmation.</li><li>Vancouver is a multicultural city, and our homestay families reflect that diversity.</li></ul>
                                 <br><br>
                            <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;font-weight: normal;margin: 0;"><strong>We are here to help!</strong></p><br>
                            <p style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 120%;line-height: 1.6em;font-weight: normal;margin: 0;">If you have any questions about  application or our programs please <a href="http://vec.ca/contact-us/" target="_blank">contact us.</a> For faster service please refer to <strong>Application #' . $dateid . '</strong> when speaking to one of our representatives.</p> <br>
                            <p style="font-weight: normal; font-size:120%; margin: 0;">Thank you, we look forward to meeting you,</p><br><br><br><br>
                            <div><img src="https://secure.vec.ca/wp-content/uploads/2015/11/vec_logo_web.png" alt="VEC Logo"></div>
                            <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial "><font color="#000000 "><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:gray "><font color="#000000 "><br></font></span></b></font></span></b></div>
                            <div><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:gray ">Admissions </span></b><b style="color:rgb(34,34,34);font-family:arial,sans-serif;font-size:13px;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:normal;text-align:start;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:silver ">|<span> </span></span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0) ">Vancouver</span></b><b style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:9pt;font-family:Arial;color:rgb(192,5,0) "> English Centre<br>
                            </span></b><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(31,73,125);text-transform:none;font-size:8px;white-space:normal;font-family:Arial;word-spacing:0px "></span><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:8pt;font-family:Arial;color:gray ">250 Smithe Street, Vancouver, BC V6B 1E7 Canada</span></span>
                            <p><span style="text-indent:0px;letter-spacing:normal;font-variant:normal;text-align:start;font-style:normal;font-weight:normal;line-height:normal;color:rgb(34,34,34);text-transform:none;font-size:13px;white-space:normal;font-family:arial,sans-serif;word-spacing:0px "><span style="font-size:8pt;font-family:Arial;color:gray "></span></span><span style="font-size:8pt;font-family:Arial;color:gray "></span></p>
                            <table style="color:#222222;font-size:13px;font-family:Verdana,Arial,Helvetica,sans-serif;width:230px " border="0 " cellpadding="0 " cellspacing="1 "><tbody><tr style="font-family:Arial "><td style="text-align:left " valign="top " width="105px ">
                            <span style="color:gray;font-size:9pt ">Tel:<br>Email:<br>Main site:</span></td><td style="text-align:right " valign="top " width="115px "><div><div style= "margin: 0;padding: 0px 30px 0px 30px;text-align:left "><div style="text-align:right "></div></div><span style="color:gray "><div><a href="tel:%2B1%20604%20687%201600 " value="+16046871600 " target="_blank ">+1 604 687 1600</a></div><div><a href="mailto:marketing@vec.ca " style="color:rgb(42,93,176);font-size:9pt " target="_blank ">apply@vec.ca</a></div><div><a href="http://vec.ca/ " style="color:rgb(42,93,176);font-size:9pt " target="_blank ">vec.ca</a><br style="color:rgb(34,34,34) "></div>
                                                <br>
                                            </div>
                                            <!-- /content -->
                                        </td>
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                    </tr>
                                </table>
                                <!-- /body -->
                                <!-- footer -->
                                <table class="footer-wrap " style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; width: 100%; margin: 0; padding: 0; ">
                                    <tr style="font-family: \'Open Sans\',Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0; ">
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                        <td class="container " style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;clear: both !important;display: block !important;max-width: 600px !important;margin: 0 auto;padding: 20px;background-color: #ffffff;border: 1px solid #f0f0f0; ">
                                            <!-- content -->
                                            <div class="content " style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;display: block;max-width: 600px;margin: 0 auto;padding: 0; ">
                                                <table style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0; ">
                                                    <tr style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0; ">
                                                        <td align="left " style="font-family: \'Open Sans\', \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; ">
                                                            <p style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 12px;line-height: 1.6em;color: #666666;font-weight: normal;margin: 0 0 10px;padding: 0; ">Copyright © 2015 Vancouver English Centre. All rights reserved.</p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <!-- /content -->
                                        </td>
                                        <td style="font-family: \'Open Sans\', Open Sans, Arial, sans-serif;font-size: 100%;line-height: 1.6em;margin: 0;padding: 0; "></td>
                                    </tr>
                                </table>
                                <!-- /footer -->
                            </body>
                            </html>';
        }
    }
        
    if(isset($dateid)) {
		$trelloemail .= '**ID:** ' . $dateid . "\n";
	}
    
	if(isset($clean['language'])) {
		if(isset($clean['languagename'])) {
			$trelloemail .= '**Language:** ' . $clean['languagename'] . "\n";
			$trellomembers = explode(',', $clean['language']);
			for($i = 0; $i < count($trellomembers); $i++) {
				$trellosubject .= ' @' . $trellomembers[$i];
			}
            $staffmembers = explode(',', $clean['marketeremail']);
            for($i = 0; $i < count($staffmembers); $i++) {
				$staffrecipients[] = $staffmembers[$i];
			}
		}
	}
	
	$staffemail .= '<!DOCTYPE html>
						<html>
							<head>
								<meta name="viewport" content="width=device-width">
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
								<title>Registrar Email</title>
							</head>
							<body>';
	$staffemail .= '<h3>Student Info:</h3>' . "<br>";
	$staffsubject .= 'Application #' . $dateid;
	
	if(isset($clean['firstname']) && isset($clean['lastname'])) {
		$staffemail .= '<b>Name:</b> ' . $clean['firstname'] . ' ' . $clean['lastname'] . "<br>";
		$staffsubject .= ': ' . $clean['firstname'] . ' ' . $clean['lastname'];
	}
    
    if(isset($clean['gender'])) {
        $staffemail .= '<b>Gender:</b> ' . $clean['gender'] . "<br>";
    }
	
	if(isset($clean['studentemail'])) {
		$staffemail .= "<b>Student's Email:</b> " . $clean['studentemail'] . "<br>";
	}
	
	if(isset($clean['dob'])) {
		$staffemail .= "<b>Date of Birth:</b> " . $clean['dob'] . "<br>";
	}
	   
	if(isset($clean['address'])) {
		$staffemail .= "<b>Address:</b> " . $clean['address'] . "<br>";
	}
	   
	if(isset($clean['country'])) {
		$staffemail .= "<b>Country:</b> " . $clean['country'] . "<br>";
	}
	   
	if(isset($clean['state'])) {
		$staffemail .= "<b>Province/State:</b> " . $clean['state'] . "<br>";
	}
	 
	if(isset($clean['city'])) {
		$staffemail .= "<b>City:</b> " . $clean['city'] . "<br>";
	}
	   
	if(isset($clean['postal'])) {
		$staffemail .= "<b>Postal Code:</b> " . $clean['postal'] . "<br>";
	}
	  
	if(isset($clean['descallergy'])) {
		$staffemail .= "<b>Medical Condition/Allergy:</b> " . $clean['descallergy'] . "<br>";
	}
	   
	if(isset($clean['languagename'])) {
		$staffemail .= "<b>Language:</b> " . $clean['languagename'] . "<br>";   
	}
    
    if(isset($clean['promo'])) {
        $staffemail .= "<b>Promo/Comments:</b> " . $clean['promo'] . "<br>";
    }
    
    if(isset($clean['agent'])) {
        $staffemail .= "<h3>Agent Info:</h3><br>";
        if(isset($clean['agentname'])) {
            $staffemail .= "<b>Agent Company Name:</b> " . $clean['agentname'] . "<br>";
        }
        if(isset($clean['agentemail'])) {
            $staffemail .= "<b>Agent Email:</b> " . $clean['agentemail'] . "<br>";
        }
        if(isset($clean['agentid'])) {
            $staffemail .= "<b>Agent ID:</b> " . $clean['agentid'] . "<br>";
        }
    }
    
    $userrecipients[] = $clean['email'];
    
    if(isset($clean['program'])) {
        $staffemail .= "<h3>Program Info:</h3><br>";
        
        if(isset($clean['eff_program'])) {
            $staffemail .= "<b>Program Name:</b> " . $clean['eff_program'] . "<br>";
        } else {
            $staffemail .= "<b>Program Name:</b> " . $clean['program'] . "<br>";
        }
        
        if(isset($clean['adults'])) {
            $staffemail .= "<b>Adults: </b> " . $clean['adults'] . "<br>";	
        }
        
        if(isset($clean['children'])) {
            $staffemail .= "<b>Children: </b> " . $clean['children'] . "<br>";	
        }
        
        if(isset($clean['startdate'])) {
            $staffemail .= "<b>Start Date:</b> " . $clean['startdate'] . "<br>";	
        }
        
        if(isset($clean['arrivaldate'])) {
            $staffemail .= "<b>Arrival Date:</b> " . $clean['arrivaldate'] . "<br>";	
        }
        
        if(isset($clean['departuredate'])) {
            $staffemail .= "<b>Departure Date:</b> " . $clean['departuredate'] . "<br>";	
        }
}
	
	if(isset($_POST['estimate']) && !isset($clean['eff_program'])) {
        $staffemail .= "<br><br><h2>Application #" . $dateid . "</h2><br>";
		$staffemail .= '<div style="width: 600px;">' . stripslashes($_POST['estimate']) . '</div>';   
	}
	
	$staffemail .= '</body></html>';
    
	if(isset($clean['country'])) {
		$trelloemail .= '**Country:** ' . $clean['country'] . "\n";
	}
	
	if(isset($clean['email'])) {
		$trelloemail .= '**Email:** ' . $clean['email'] . "\n";
	}
	
	if(isset($clean['dob'])) {
		$trelloemail .= '**Date of Birth:** ' . $clean['dob'] . "\n";
	}
	
	if(isset($clean['agentname'])) {
		$trelloemail .= '**Agent Company:** ' . $clean['agentname'] . ', **Email:** ' . $clean['agentemail'] . "\n";
	}
	
	if(isset($clean['accommodation'])) {
		$trelloemail .= '**Homestay:** ' . $clean['accommodation'] . "\n";
	}
	
	if(isset($clean['startdate'])) {
		$trelloemail .= '**Start Date:** ' . $clean['startdate'];
	} else if(isset($clean['specialstartdate'])) {
		$trelloemail .= '**Start Date:** ' . $clean['specialstartdate'];	
	}
	
	wp_mail($userrecipients, $usersubject, $useremail, $userheaders);
	wp_mail($trellorecipients, $trellosubject, $trelloemail, $trelloheaders);
    if($_POST['next'] == "0") {
        wp_mail($staffrecipients, $staffsubject, $staffemail, 'Content-Type: text/html; charset=UTF-8');
    }
	echo($staffemail);
}

header("Location: " . $thankyoulink);
die();
?>