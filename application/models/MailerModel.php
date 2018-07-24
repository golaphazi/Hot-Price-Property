<?php
/**
 * Description of MailerModel
 *
 * @author Euitsols
 * Developed On 26-02-2018
 */

class MailerModel extends CI_Model {
    //put your code here..
    function sendEmail($to, $subject='Hpp', $message='', $from='sales@hotpriceproperty.com') {
        
		
        $headers = "From: Gelio Laft <". strip_tags($from) . "> " . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\nX-Mailer: PHP/" . phpversion();
		
        if(@mail($to, $subject, $message, $headers)){
                return true;
        }else{
                return false;
        }
    }
    
    public function sendContactEmail($data, $templateName)
    {
        $this->load->library('email');
        $this->email->set_mailtype('html');
        $this->email->from($data['from_address'], $data['admin_full_name']);
        $this->email->to($data['to_address']);
        //$this->email->cc($data['cc_address']);
        $this->email->subject($data['subject']);
        $body = $this->load->view('mailScripts/' . $templateName, $data, true);
        $this->email->message($body);
        $this->email->send();
        $this->email->clear();
    }
    
    
}
