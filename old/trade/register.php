<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
  ;
  die("<h2>Access Denied!</h2> This file is protected and not available to public.");
}
?>


<?php
include "../category.php";


require('code39.php');
require('class.phpmailer-lite.php');
$title = $_POST['title'];
$select2 = htmlspecialchars($_POST['select2']);
$name = htmlspecialchars($_POST['lastname']);
$designation = htmlspecialchars($_POST['designation'], ENT_QUOTES);
$organisation = htmlspecialchars($_POST['organisation'], ENT_QUOTES);
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = htmlspecialchars($_POST['address'], ENT_QUOTES);
$city = htmlspecialchars($_POST['city'], ENT_QUOTES);
$state = htmlspecialchars($_POST['state'], ENT_QUOTES);
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$website = $_POST['website'];
$category = $_POST['category'];
$city_name = 'Chennai';


echo $category;
exit();
$obj = new CategoryCheck();

if (!$obj->categorycheck($name, $category)) {
    header("Location: ../registerc.php");
    exit(); // STOP everything immediately
}

$timezone = "Asia/Calcutta";
if (function_exists('date_default_timezone_set'))
  date_default_timezone_set($timezone);


$mysqli = new mysqli("localhost", "iitminda_harish", "Harish@2024", "iitminda_iitmindia_2024");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

$mysqli->query("INSERT INTO tradev (title,select2,name,designation,organisation,email,phone,address,city,state,pincode,country,website,city_name) VALUES ( '$title','$select2', '$name','$designation', '$organisation', '$email', '$phone','$address','$city','$state','$pincode','$country','$website','$city_name')");





$visiterid = $mysqli->insert_id;

$name1 = $title . ' ' . $select2 . ' ' . $name;

$qr_data = utf8_encode('NAME : ' . $name1 . "\n" . 'Designation : ' . $designation . "\n" . 'Organisation : ' . $organisation . "\n" . 'Mobile : ' . $phone . "\n" . 'EMAIL : ' . $email);
$br_data = $visiterid;

$bd = "Dear ";
$name2 = $bd . ' ' . $name1;


include 'qrgen.php';
include 'barcode.php';
$qr = qr($qr_data);
$br = br($br_data);
$s = $visiterid;
$name1 = strtoupper($name1);
$organisation = strtoupper($organisation);
$pdf = new PDF_Code39('P', 'pt', 'A4');
$pdf->AddPage();
$pdf->SetMargins(60, 0, 50);
$pdf->Image('images/Pre-registration_Badge.jpg', -10, 0, 580, 800, 'JPG');
$y = -720;
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetY($y);
$pdf->Cell(445, 410, $name1, '0', '0', 'C');
$y = $y + 20;
$pdf->SetY($y);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(445, 405, $organisation, '0', '0', 'C');
$pdf->Code39(290, 145, $s, '', '', 0.6, 20, 'C');
$pdf->Image($qr, 310, 185, 65, 65, 'PNG');
$pdf->SetY(-800);
$path = getcwd();
$file = "$path/$phone.pdf";
$pdf->Output($file, "F");

$pdfdoc = $pdf->Output("", "S");
$attachment = $pdfdoc;




$html2 = <<<ENDH


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=utf-8" />

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>India International Travel Mart  | Chennai | 16 - 18 Jul 2026</title>
<!------ Include the above in your HEAD tag ---------->
<style>
    .register {
        background: -webkit-linear-gradient(left, #d40404, #800b03, #6e0902);
        /* margin-top: 3%; */
        padding: 3%;
    }

    .register-left {
        text-align: center;
        color: #4f3a30;
        /* color: #343567; */
        margin-top: 4%;
    }

    .register-left input {
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        width: 60%;
        background: #f8f9fa;
        font-weight: bold;
        color: #383d41;
        margin-top: 30%;
        margin-bottom: 3%;
        cursor: pointer;
    }

    .register-right {
        background: #f8f9fa;
        border-top-left-radius: 10% 50%;
        border-bottom-left-radius: 10% 50%;
    }

    .register-left img {
        margin-top: 15%;
        margin-bottom: 5%;
        width: 80%;
        -webkit-animation: mover 2s infinite alternate;
        animation: mover 1s infinite alternate;
    }

    @-webkit-keyframes mover {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-20px);
        }
    }

    @keyframes mover {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-20px);
        }
    }

    .register-left p {
        font-weight: lighter;
        padding: 12%;
        margin-top: -9%;
    }

    .register .register-form {
        padding: 5%;
        margin-top: 1%;
    }

    .btnRegister {
        float: right;
        margin-top: 1%;
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        background: #4f3a30;
        /* background: #0062cc; */
        color: #fff;
        font-weight: 600;
        width: 50%;
        cursor: pointer;
    }
    .btnRegister1 {
        float: right;
        margin-top: 10%;
        border: none;
        border-radius: 1.5rem;
        padding: 2%;
        background: #4f3a30;
        /* background: #0062cc; */
        color: #fff;
        font-weight: 600;
        width: 50%;
        cursor: pointer;
    }

    .register .nav-tabs {
        margin-top: 3%;
        border: none;
        background: #0062cc;
        border-radius: 1.5rem;
        width: 28%;
        float: right;
    }

    .register .nav-tabs .nav-link {
        padding: 2%;
        height: 34px;
        font-weight: 600;
        color: #fff;
        border-top-right-radius: 1.5rem;
        border-bottom-right-radius: 1.5rem;
    }

    .register .nav-tabs .nav-link:hover {
        border: none;
    }

    .register .nav-tabs .nav-link.active {
        width: 100px;
        color: #0062cc;
        border: 2px solid #0062cc;
        border-top-left-radius: 1.5rem;
        border-bottom-left-radius: 1.5rem;
    }

    .register-heading {
        text-align: center;
        margin-top: 8%;
        margin-bottom: -15%;
        color: #495057;
    }
</style>

<div class="container-fluid register">
    <div class="row">
        <div class="col-md-3 register-left">
         
          
        
            <!---<input type="submit" name="" value="Login" /><br /> --->
        </div>
        <div class="col-md-9 register-right">
            <!---- <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Employee</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hirer</a>
                            </li>
                        </ul>--->
<table width="800"
 border="0" cellpadding="0" cellspacing="0"
 style="background-color: rgb(225, 225, 223); width: 800px; text-align: left;  margin-left: auto; margin-right: auto;">
  <tbody>
  <tr>
      <td  style="background-color:  #09233f;">
	
   
    <tr>
      <td align="center" bgcolor="#ffffff">
      <h3><u>India International Travel Mart  | Chennai | 16 - 18 Jul 2026 | Confirmation</u>
      </h3>
      </td>
    </tr>
 
    <tr>
 <td  bgcolor="#FFFFFF" style="padding: 14px 30px 17px 36px;  font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 22px; color: #434343;">
 <p> Dear $title $select2 $name,</p>

   <p>We are delighted to inform you that your registration for the IITM Chennai event has been successfully confirmed.
<br />
This email serves as an official confirmation of your participation in the event, which will take place from 16 - 18 July 2026.
<br />
To ensure smooth access to the event, please find attached your event badge. Kindly print the badge and wear it prominently during the event to facilitate entry and identification.
<br />
We look forward to welcoming you at the IITM Chennai event. Should you have any further questions or require any additional information, please feel free to reach out to us.
</P>


<p><strong>
Please Note this is a B2B Travel and Tourism Exhibition</strong>
</p>

   <p>You may like to keep this mail safe, so you can take a printout or on mobile the badge anytime, Your reference number id <strong> $visiterid & Your Reference QRCode is </strong> </p>
   <img src="https://iitmindia.com/reg/iitm_chennai/$qr">
   <br /><br />

	Thank you for your participation, and we wish you a successful and enriching experience at the IITM Chennai event.
	 <br />
     <strong>Best Regards, <br /> 
Team IITM
</strong></p></td>
    </tr>
    
  
    </tr>
  </tbody>
</table>
    </div>

</div>

</body>
</html>



ENDH;


/*$mail   = new PHPMailerLite(); // defaults to using php "Sendmail" (or Qmail, depending on availability)

$mail->IsMail(); // telling the class to use native PHP mail()

try {
  $mail->SetFrom('info@iitmindia.com', 'India International Travel Mart  | Chennai | 04 - 06 AUG 2023');
  $mail->AddAddress($email, $email);


 $mail->AddBCC('admin@iitmindia.com', 'CC Recipient 3'); // CC recipient 3

  $mail->Subject = 'Confirmation Mail | India International Travel Mart  | Chennai | 04 - 06 AUG 2023';


  $mail->MsgHTML($html2);



  //$mail->AddStringAttachment($attachment, $filename, $encoding, $type);
  $mail->AddAttachment("$phone.pdf");
  $mail->Send();


  // echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  // echo $e->errorMessage();
  $flag = 0; //Pretty error messages from PHPMailer
} catch (Exception $e) {
  //echo $e->getMessage(); //Boring error messages from anything else!
  $flag = 0;
}

*/
$path = "https://iitmindia.com/reg/iitm_chennai/";
$filename = "$phone.pdf";
$file = $path . $filename;
$content = file_get_contents($file);
$uid = md5(uniqid(time()));
$file_name = basename($file);
$to = "$email";
$subject = "Confirmation Mail | India International Travel Mart | Chennai | 16 - 18 Jul 2026";
$message = "<b>$html2</b>";
$header = "From: events@iitmindia.com\r\n";
$header .= "Cc: harish@iitmindia.com\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: multipart/mixed; boundary=\"$uid\"\r\n";
$body = "--$uid\r\n";
$body .= "Content-type:text/html; charset=iso-8859-1\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message . "\r\n\r\n";
$body .= "--$uid\r\n";
$body .= "Content-Type: application/pdf; name=\"$file_name\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n\r\n";
$body .= chunk_split(base64_encode($pdfdoc)) . "\r\n\r\n";
$body .= "--$uid--";
$retval = mail($to, $subject, $body, $header);

/*

  $to = "$email";
         $subject = "Confirmation Mail | India International Travel Mart  | Chennai | 04 - 06 AUG 2023";

         $message = "<b>$html2</b>";
         $message .= "<h1>This is headline.</h1>";

         $header = "From:info@iitmindia.com \r\n";
         $header .= "Cc:admin@iitmindia.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";


         $retval = mail ($to,$subject,$message,$header);

         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
       /*  
         use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = new PHPMailer();
$email->SetFrom('info@iitmindia.com', 'Your Name'); //Name is optional
$email->Subject   = 'Message Subject';
$email->Body      = $html2;
$email->AddAddress( 'itsshindhumathi@gmail.com' );

$file_to_attach = 'reg/iitm_Chennai';

$email->AddAttachment( $file_to_attach , '$phone.pdf' );

return $email->Send();
*/
?>

<!doctype html>
<html lang="en-gb" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>India International Travel Mart | Chennai | 16 - 18 Jul 2026 Confirmation</title>
  <!-- Meta Pixel Code -->
  <script>
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return; n = f.fbq = function () {
        n.callMethod ?
        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
      n.queue = []; t = b.createElement(e); t.async = !0;
      t.src = v; s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
      'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1528244355229931'); // ✅ First Pixel
    fbq('init', '2163682937395443'); // ✅ Second Pixel
    fbq('init', '9300627153319564'); // ✅ Second Pixel
    fbq('init', ' 1109477967336886'); // ✅ Second Pixel

    fbq('track', 'PageView'); // ✅ Send PageView to BOTH pixels
  </script>

  <noscript>
    <img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1528244355229931&ev=PageView&noscript=1" />
    <img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=2163682937395443&ev=PageView&noscript=1" />
    <img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=9300627153319564&ev=PageView&noscript=1" />
    <img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id= 1109477967336886&ev=PageView&noscript=1" />

  </noscript>
  <!-- End Meta Pixel Code -->

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <style>
    .register {
      background: linear-gradient(to right, #e7e7e7, #a5251f);
      padding: 3%;
    }

    .register-left {
      text-align: center;
      color: #4f3a30;
      margin-top: 4%;
    }

    .register-left img {
      width: 60%;
      max-width: 200px;
      animation: mover 1s infinite alternate;
    }

    @keyframes mover {
      0% {
        transform: translateY(0);
      }

      100% {
        transform: translateY(-20px);
      }
    }

    .register-right {
      background: #f8f9fa;
      border-top-left-radius: 10% 50%;
      border-bottom-left-radius: 10% 50%;
      padding: 5%;
    }

    .btnRegister,
    .btnRegister1 {
      border: none;
      border-radius: 1.5rem;
      padding: 2%;
      background: #4f3a30;
      color: #fff;
      font-weight: 600;
      width: 100%;
      cursor: pointer;
      text-align: center;
    }

    .register-heading {
      text-align: center;
      margin-top: 8%;
      color: #495057;
    }

    @media (max-width: 768px) {
      .register-right {
        border-radius: 0;
        padding: 3%;
      }

      .register-left img {
        width: 50%;
      }
    }
  </style>
</head>

<body>
  <div class="container register">
    <div class="row">
      <div class="col-md-4 col-sm-12 register-left">
        <img src="https://iitmindia.com/reg/iitm_bangalore/logo.png" alt="IITM Logo" />
        <h3 style="color: #a42627;"><strong>Registration Confirmation Mail | India International Travel Mart | Chennai |
            16 - 18 JULY 2026</strong></h3>
      </div>
      <div class="col-md-8 col-sm-12 register-right">
        <table class="table table-responsive">
          <tbody>
            <tr>
              <td>
                <p><strong>Dear <?php echo ucwords($title); ?> <?php echo ucwords($select2); ?>
                    <?php echo ucwords($name); ?>,</strong></p>
                <p>We are delighted to inform you that your registration for the IITM Chennai event has been
                  successfully confirmed.</p>
                <p>This message serves as an official confirmation of your participation in the event, which will take
                  place from 16 - 18 July 2026.</p>
                <p>Please find attached your event badge. Kindly print and wear it during the event.</p>
                <p> Should you have any urgent questions or require immediate assistance, please feel free to contact us
                  directly mail to <strong>info@iitmindia.com</strong> or Call:<strong> +91-80-40834100. <strong></p>

                <p><strong>Please Note this is a B2B Travel and Tourism Exhibition</strong> </p>

                <p>Your reference number: <strong><?php echo $visiterid; ?></strong>. Your QR Code:</p>
                <?php echo '<img src="' . $qr . '" alt="QR Code">'; ?>
                <form id="badge_download_form" action="badge.php" method="post">
                  <input type="hidden" name="badge_download" value="<?php echo $phone ?>.pdf">
                </form>
                <p><strong>Best Regards,<br>Team IITM</strong></p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $("#badge_download_form").submit();
    });
  </script>
</body>

</html>