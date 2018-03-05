<?php
class Mailer
{
	public function __construct() {
		
	}
	public function sendPaymentMail($stud, $payment_info) {
		$to = $stud['email'];
		$name = $stud['fname']." ".$stud['sname'];
		$subject = "Payment Confirmation";
		$amount = number_format($payment_info['amount'],2);
		$body = "Dear ".$name.",<br><br> A payment of NGN".$amount." has been successfully received from you, being payment for '".$payment_info['payment_type']."'. See payment information below:
		 		<br> Transaction Reference: ".$payment_info['transaction_id']."<br> Matric Number: ".$stud['matric_no']
				."<br><br>For enquiries, contact payments@gulfpearlinvestment.com"
				."<br><a href='http://platgroupng.com/'>Powered by Plat Technologies Ltd (http://platgroupng.com/)</a>";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <payments@gulfpearlinvestment.com>\r\n"."X-Mailer: php";
		
		if (mail($to, $subject, $body, $headers))
			return true;
		else
			return false;
	}

}


?>