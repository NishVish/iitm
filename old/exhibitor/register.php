<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
  die("<h2>Access Denied!</h2> This file is protected and not available to the public.");
}
?>

<?php
date_default_timezone_set("Asia/Calcutta");

$mysqli = new mysqli("localhost", "iitminda_harish", "Harish@2024", "iitminda_iitmindia_2024");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

require('code39.php');
require('class.phpmailer-lite.php');


$title = $_POST['title'];
$select2 = htmlspecialchars($_POST['select2']);
$name = htmlspecialchars($_POST['lastname']);
$designation = htmlspecialchars($_POST['designation'], ENT_QUOTES);
$organisation = htmlspecialchars($_POST['organisation'], ENT_QUOTES);
$email = $_POST['email'];
$country_code = $_POST['country_code'];
$phone = $_POST['phone'];
$address = htmlspecialchars($_POST['address'], ENT_QUOTES);
$city = htmlspecialchars($_POST['city'], ENT_QUOTES);
$state = htmlspecialchars($_POST['state'], ENT_QUOTES);
$pincode = $_POST['pincode'];
$country = $_POST['country'];
$website = $_POST['website'];
$bengaluru = $_POST['bengaluru'];
$chennai = $_POST['chennai'];
$delhi = $_POST['delhi'];
$mumbai = $_POST['mumbai'];
$pune = $_POST['pune'];
$hyderabad = $_POST['hyderabad'];
$kochi = $_POST['kochi'];
$kolkata = $_POST['kolkata'];
$ahmedabad = $_POST['ahmedabad'];
// Ensure the user_ip is being received correctly
$user_ip = isset($_POST['user_ip']) && !empty($_POST['user_ip']) ? $_POST['user_ip'] : 'Unknown';



$query = "INSERT INTO exhibitor2025 (title, select2, name, designation, organisation, email, country_code,phone, address, city, state, pincode, country, website, bengaluru, chennai, delhi, mumbai, pune, hydrabad, kochi, kolkata, ahmedabad,ip_address) 
          VALUES ('$title', '$select2', '$name', '$designation', '$organisation', '$email', '$country_code', '$phone', '$address', '$city', '$state', '$pincode', '$country', '$website', '$bengaluru', '$chennai', '$delhi', '$mumbai', '$pune', '$hyderabad', '$kochi', '$kolkata', '$ahmedabad','$user_ip')";
$mysqli->query($query);

$to = "harish@iitmindia.com";
$subject = "IITM Exhibitor Enquiry";


$message = "
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h1>IITM Exhibitor Enquiry</h1>

<table id='customers'>
  

  <tr>
    <td>First Name</td>
    <td>$select2</td>
  </tr>
  <tr>
   <td>Last Name</td>
    <td>$name</td>
  </tr>
  <tr>
   <td>Email</td>
    <td>$email</td>
  </tr>
  <tr>
  <td>Designation</td>
    <td>$designation</td>
  </tr>

  <tr>
   <td>Organisation</td>
    <td>$organisation</td>
  </tr>
  <tr>
   <td>Mobile</td>
    <td>$phone</td>
  </tr>
  <tr>
  <td>Address</td>
    <td>$address , $address1</td>
  </tr>
  <tr>
 <td>City</td>
    <td>$City</td>
  </tr>
   <tr>
 <td>State</td>
    <td>$State</td>
  </tr>
   <tr>
 <td>Pincode</td>
    <td>$Pincode</td>
  </tr>
   <tr>
 <td>Country</td>
    <td>$Country</td>
  </tr>
   <tr>
 <td>Website</td>
    <td>$input_27</td>
  </tr>
   <tr>
 <td>Short Company Profile</td>
    <td>$Message</td>
  </tr>
</table>

</body>
</html>

";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <noreply@iitmindia.com>' . "\r\n";


mail($to, $subject, $message, $headers, $cc);


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
$pdf->SetMargins(0, 0, 50);
$pdf->Image('images/Pre-registration_Badge.jpg', 10, 10, 600, 0, 'JPG');
$y = -720;
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetY($y);
$pdf->Cell(300, 20, $name1, '0', '0', 'C');
$y = $y + 20;
$pdf->SetY($y);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(300, 50, $organisation, '0', '0', 'C');
$pdf->Code39(95, 180, $s, '', '', 0.6, 20, 'C');
$pdf->Image($qr, 110, 230, 75, 75, 'PNG');
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
  <title>India International Travel Mart  | Exhibitor | Enquiry 2025 - 26 </title>
<!------ Include the above in your HEAD tag ---------->
<style>
    .register {
        background: -webkit-linear-gradient(left, #9e0303, #6b0303);
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
      <h3><u>India International Travel Mart  | Exhibitor | Enquiry</u>
      </h3>
      </td>
    </tr>
 
    <tr>
 <td  bgcolor="#FFFFFF" style="padding: 14px 30px 17px 36px;  font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 22px; color: #434343;">
 <p> Dear $title $select2 $name,</p>

                    <p>Hello  Thank you for your enquiry regarding India International Travel Mart (IITM 2026 - 27). We appreciate your interest in participating in the IITM Event.</p>
   <p>
Our team is currently reviewing your enquiry and will provide you with a detailed response shortly. We understand the importance of your participation and aim to address your queries and provide the necessary information as quickly as possible.</p>
<p>Should you have any urgent questions or require immediate assistance, please feel free to contact us directly at info@iitmindia.com.</p>
   <p>
                  Thank you we wish you a successful and enriching experience at the IITM event. </p>
                  <p>
                  <br />
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



$path = "https://iitmindia.com/reg/exhibitor/iitm_exhibitors/";
$filename = "$phone.pdf";
$file = $path . $filename;
$content = file_get_contents($file);
$uid = md5(uniqid(time()));
$to = "$email , harish@iitmindia.com";
$subject = "India International Travel Mart | Exhibitor Enquiry";
$message = "<b>$html2</b>";
$header = "From: events@iitmindia.com\r\n";
$header .= "Cc: Nil\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
$body = $message;
$retval = mail($to, $subject, $body, $header);


// PHP example to validate suspicious entries in backend
$suspicious_values = [
  'XbCsFsuZAlIW',
  'neDXnkjlo',
  'mecherry0720@gmail.com',
  '8629230561'
];

function isSuspicious($value, $suspicious_values)
{
  foreach ($suspicious_values as $suspicious) {
    if (strpos($value, $suspicious) !== false) {
      return true;
    }
  }
  return false;
}

if (isSuspicious($_POST['name'], $suspicious_values) || isSuspicious($_POST['email'], $suspicious_values) || isSuspicious($_POST['phone'], $suspicious_values)) {
  die('Suspicious registration detected. Please try again.');
}



?>

<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en-gb" class="no-js">
<!--<![endif]-->

<head>
  <title>India International Travel Mart | Exhibitor | Enquiry 2026-27</title>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <title>India International Travel Mart | Exhibitor | Enquiry 2026-27</title>


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

  <!------ Include the above in your HEAD tag ---------->
  <style>
    .register {
      background: -webkit-linear-gradient(left, #e7e7e7, #a5251f);
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
  <script type='text/javascript'>
    $(document).ready(function () {
      $('#how').change(function () {
        if ($(this).val() == 'Other') {
          $('#Other').css({
            'display': 'block'
          });
        }
      });
    });
  </script>
  <div class="container-fluid register">
    <div class="row">
      <div class="col-md-3 register-left">
        <img src="logo.png" width="100%" alt="" />
        <h3 style="color: #a42627;"><strong>India International Travel Mart | Exhibitor Enquiry 2026-27</strong></h3>


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
        <table width="800" border="0" cellpadding="0" cellspacing="0"
          style=" width: 800px; text-align: left;  margin-left: auto; margin-right: auto;">
          <tbody>



            <tr>
              <td background="images/letter.jpg"
                style="padding: 14px 30px 17px 36px;  font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 22px; color: #434343;">
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="62%" rowspan="2"> <strong>Dear
                        <?php echo ucwords($title); ?>
                        <?php echo ucwords($select2); ?>
                        <?php echo ucwords($name); ?>,
                      </strong></td>

                </table>

                <p>&nbsp;</p>

                <p> Hello Thank you for your enquiry regarding India International Travel Mart (IITM 2026 - 27). We
                  appreciate your interest in participating in the IITM Event.</p>
                <p>
                  Our team is currently reviewing your enquiry and will provide you with a detailed response shortly. We
                  understand the importance of your participation and aim to address your queries and provide the
                  necessary information as quickly as possible.</p>


                <p>Should you have any urgent questions or require immediate assistance, please feel free to contact us
                  directly at +91-080-40834100 or info@iitmindia.com.</p>

                Thank you we wish you a successful and enriching experience at the IITM event. </p>

                <p>
                  <br /><br />
                  <strong>Best Regards,<br />
                    Team IITM
                  </strong>
                </p>
              </td>
            </tr>



            </tr>

          </tbody>
        </table>

      </div>

    </div>

    <!--<script>
    $(document).ready(function() {
      $('#badge_download_form').submit();
    });
  </script>-->

    </body>

</html>