<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Preps an email message and sends it.
*
* @param string $from_name :the name of the person the email is coming from 
* @param string $from_email :the email address of the person sending the email
* @param string $to_email :the email address of the recipient
* @param string $subject :the subject of the email message
* @param string $message :the body of the message being sent
* @return boolean TRUE if sent FALSE if not
* @uses send_email('Some Name','fromemail@isp.com','toemail@isp.com','Some Message Subject','The Message Body')
*/
function send_email($from_name,$from_email,$to_email,$subject,$message)
{
    $ci = get_instance();
    $ci->load->library('email');

    $config['protocol'] = 'mail';
    $config['smtp_host'] = 'mail.alexgarciafineart.com';
    $config['smtp_user'] = 'alex@alexgarciafineart.com';
    $config['smtp_pass'] = 'corner927';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';

    $ci->email->initialize($config);
    $ci->email->from($from_email, $from_name);
    $ci->email->to($to_email);
	$ci->email->bcc('codersatx@gmail.com'); 
    $ci->email->subject($subject);
    $ci->email->message($message);

    if($ci->email->send())
    {
        return TRUE;
    }
}