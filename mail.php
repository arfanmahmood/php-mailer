<?php 
function containsInjectionAttempt($input){
	if (eregi("%0a", $input) || eregi("%0d", $input) ||	eregi("Content-Type:", $input) || eregi("bcc:", $input) ||	eregi("to:", $input) ||	eregi("cc:", $input)  ||	eregi("http://", $input)) {
		return true;
	}else{
		return false;
	}
}

$str_email_message ='';
$str_msg = '';

$referfrom = $_SERVER['HTTP_REFERER'];

$domainname = "www.abc.com";

$checking = strpos($referfrom,$domainname);
$useragent = $_SERVER['HTTP_USER_AGENT'];

//echo $_REQUEST['part_required'];

if($checking1 !== false){
  if(
	 !containsInjectionAttempt($_REQUEST['name']) &&
	 !containsInjectionAttempt($_REQUEST['email']) && 
	 !containsInjectionAttempt($_REQUEST['phone']) && 
	 !containsInjectionAttempt($_REQUEST['company']) && 
	 !containsInjectionAttempt($_REQUEST['fax']) && 
	 !containsInjectionAttempt($_REQUEST['notes']) 
	 ){
	  
	  $str_reciver_email = 'info@abc.com';
	  
	  $str_mail_subject = $_REQUEST['name']." sent you a query from your website($domainname)";	  
	  
	  $str_email_message .= "-------------------------------------------------------------------------------------------------<br />";
	  $str_email_message .= "<h3>".$_REQUEST['name']." sent you a query from your website<br />(".$_SERVER['HTTP_HOST'].")</h3>";
	  $str_email_message .= "-------------------------------------------------------------------------------------------------<br />";
	  $str_email_message .= "<p>Email<br />".$_REQUEST['email']."</p>";
	  $str_email_message .= "<p>Phone<br />".$_REQUEST['phone']."</p>";
	  $str_email_message .= "<p>Company<br />".$_REQUEST['company']."</p>";
	  $str_email_message .= "<p>Fax<br />".$_REQUEST['fax']."</p>";
	 
	  $str_email_message .= "<p>Part Required<br />".$custompart."</p>";
	  $str_email_message .= "<p>Notes<br />".$_REQUEST['notes']."</p>";
	  $str_email_message .= "<p>File Link<br />".$_REQUEST['flink']."</p>";
	  $str_email_message .= "<p>User Agent: <br />".$useragent."</p>";
	  $str_email_message .= "-------------------------------------------------------------------------------------------------<br />";
	  
	 // echo $str_email_message;
	  $str_mail_headers = "MIME-Version: 1.0\r\n";
	  $str_mail_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	  $str_mail_headers .= "Reply-To: ".$_REQUEST['email']."\r\n";
	  $str_mail_headers .= "X-Priority: 1\r\n";
	  $str_mail_headers .= "X-MSMail-Priority: High\r\n";
	  $str_mail_headers .= "X-Mailer: php\r\n";
	  $str_mail_headers .= "From: \"".$_REQUEST['name']."\" <".$_REQUEST['email'].">\r\n";
	  $str_mail_headers .= "Bcc: bccmail@abc.com\r\n";

	  if(mail($str_client_email, $str_mail_subject, $str_email_message, $str_mail_headers)){
		  $str_msg = "Thanks! Your query has been sent successfully. One of our representative will contact you within 24 hours.";
	  }else{
		  $str_msg = "Unable to sent your query at this time. Please retry it after sometime or send a direct email";	
	  }
  }else{
	  $str_msg = "You are using some harmful content in your information. Please review the information and send it to us again";
  }
  //echo 'hello'.$str_email_message;
}else{
	$str_msg = "Invalid source.";
}
echo $str_msg;
?>
