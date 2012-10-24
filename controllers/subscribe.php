<?php
class Subscribe extends CI_Controller {
    
    public function index($hash = ''){
        if($hash != ''){
            $data['hash'] = $hash;
            $this->load->view('unsubscribe', $data);
        }
        else{
            redirect("/");
        }
    }
    public function subscribeMe(){
         $this->load->model('M_subscribe');
         $subscribeInput = $_POST['data1'];
         $this->load->helper('email');
         if (valid_email($subscribeInput))
            {   
             $hash = $this->M_subscribe->save($subscribeInput);
                if($hash){
                    $config = Array(
                        'protocol' => 'smtp',
                        'smtp_host' => 'ssl://smtpout.asia.secureserver.net',
                        'smtp_port' => 465,
                        'smtp_user' => 'emailtest@tradeoffice.com',
                        'smtp_pass' => '123456',
                        'mailtype'  =>  'html'
                    );
                    $this->load->library('email', $config);
                    $this->email->from('emailtest@tradeoffice.com', 'TradeOffice');
                    $this->email->to($subscribeInput); 
                    $this->email->subject('TradeOffice Subscription');
                    $this->email->message("You have been successfully subscribed to our newsletter <br /> if you want to unsubscribe go to this link <a href='".base_url()."subscribe/index/$hash'>".base_url()."subscribe/index/$hash</a> ");	
                    $this->email->send();
                }
                else {
                    echo "<p style='color:#ff0000'>Email already exists</p>";
                }
            }
         else {
             echo "<p style='color:#ff0000'>Invalid email</p>";
         }
    }
    public function unsubscribe(){
        if(isset($_POST['data1'])){
            $hash = $_POST['data1'];
            $this->load->model('M_subscribe');
            if($this->M_subscribe->unsubscribe($hash)){
                echo "<p style='color:#39B54A;'>You have been successfully unsubscribed</p>";
            }
            else 
                echo "<p style='color:#ff0000;'>There is no such email</p>";
        }
            
    } 
}