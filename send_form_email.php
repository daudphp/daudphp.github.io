<?php header('Access-Control-Allow-Origin: *'); ?>
<?php 
// EDIT THE 2 LINES BELOW AS REQUIRED
$send_email_to = "XXXXXXXXXXx";
$email_subject = "Inquiry submitted through website.";
function send_email($yourName,$inquiryFor,$emailAddress,$mobile,$message)
{
  global $send_email_to;
  global $email_subject;
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
  $headers .= "From: ".$emailAddress. "\r\n";
  $mailMessage = "<strong>Email: </strong>".$emailAddress."<br>";
  $mailMessage .= "<strong>Name: </strong>".$yourName."<br>";  
  $mailMessage .= "<strong>Inquiry For: </strong>".$inquiryFor."<br>";  
  $mailMessage .= "<strong>Mobile: </strong>".$mobile."<br>";  
  $mailMessage .= "<strong>Message: </strong>".$message."<br>";
  @mail($send_email_to, $email_subject, $mailMessage,$headers);
  return true;
}

function validate($yourName,$inquiryFor,$emailAddress,$mobile,$message)
{
  $return_array = array();
  $return_array['success'] = '1';
  $return_array['name_msg'] = '';
  $return_array['email_msg'] = '';
  $return_array['message_msg'] = '';
  if($emailAddress == '')
  {
    $return_array['success'] = '0';
    $return_array['email_msg'] = 'email is required';
  }
  else
  {
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if(!preg_match($email_exp,$emailAddress)) {
      $return_array['success'] = '0';
      $return_array['email_msg'] = 'enter valid email.';  
    }
  }
  if($yourName == '')
  {
    $return_array['success'] = '0';
    $return_array['name_msg'] = 'Name is required';
  }
  else
  {
    $string_exp = "/^[A-Za-z .'-]+$/";
    if (!preg_match($string_exp, $yourName)) {
      $return_array['success'] = '0';
      $return_array['name_msg'] = 'enter valid name.';
    }
  }
		
  if($message == '')
  {
    $return_array['success'] = '0';
    $return_array['message_msg'] = 'message is required';
  }
  else
  {
    if (strlen($message) < 2) {
      $return_array['success'] = '0';
      $return_array['message_msg'] = 'enter valid message.';
    }
  }
  return $return_array;
}

$yourName = $_POST['txtName'];
$inquiryFor = $_POST['txtInquiryFor'];
$emailAddress = $_POST['txtEmailAddress'];
$mobile =  $_POST['txtMobile'];
$message = $_POST['txtMessage'];


$return_array = validate($yourName,$inquiryFor,$emailAddress,$mobile,$message);

if($return_array['success'] == '1')
{
  $sent = send_email($yourName,$inquiryFor,$emailAddress,$mobile,$message);
} 
header('Content-type: text/json');
echo json_encode($return_array);
die();
?>

