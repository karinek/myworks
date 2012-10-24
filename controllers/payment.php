<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url','html'));
		$this->load->library(array('session', 'paypal'));
		$this->load->model('m_session','',True);
		$this->load->model('M_category','',True);
		$this->load->model('M_user','',True);
		$this->load->model('M_currency','',True);
	}
	
	public function index(){
		$this->pay();
	}
	
	public function pay(){

	}
	
	public function confirm(){
		$token = $this->input->get_post('token');
		$resDetail = $this->paypal->GetShippingDetails( $token );
		if($this->paypal->payflow){
			$ack = strtoupper($resDetail["RESULT"]);
			if( $ack == "0") {
				$finalPaymentAmount =  $this->session->userdata("Payment_Amount");
				$resArray = $this->paypal->ConfirmPayment( $finalPaymentAmount );
				$ack = $resArray["RESULT"];
				if( $ack == "0") {
					$this->load->model(array('m_payment','m_user','m_session'));
	
					$params = array();
					$resDetail['L_NAME0'] = $this->session->userdata('Payment_Item');
					$params['details'] = json_encode(array_merge($resDetail,$resArray));
					$params['status'] = 'Success';//$resArray['PAYMENTINFO_0_PAYMENTSTATUS'];
					$params['amount'] = isset($resArray['AMT']) ? $resArray['AMT'] : $this->session->userdata("Payment_Amount");
					$params['transaction_id'] = $resArray['PPREF'];
					$params['fee'] = isset($resArray['FEEAMT']) ? $resArray['FEEAMT'] : 0;
					$params['tax'] = isset($resArray['TAXAMT']) ? $resArray['TAXAMT'] : 0;
					$params['status_desc'] = !isset($resArray['TAXAMT']) ? '' : $resArray['PENDINGREASON'];
//					$params['cdate'] = str_replace('Z','',str_replace('T',' ',$resArray['TIMESTAMP']));
					$params['payer_id'] = $this->m_session->getUserID();
					$params['is_duplicate'] = isset($resArray['DUPLICATE']) ? $resArray['DUPLICATE'] : 0;
					
					$res = $this->m_payment->savePayment($params);
					if($res['status']){
						redirect('payment/success/'.$res['id']);
					}
				}else{
					$this->_error($resArray);
				}
			}else{
				$this->_error($resArray);
			}
		}else{
			$ack = strtoupper($resDetail["ACK"]);
			if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") {
				$finalPaymentAmount =  $this->session->userdata("Payment_Amount");
				$resArray = $this->paypal->ConfirmPayment( $finalPaymentAmount );
				$ack = strtoupper($resArray["ACK"]);
				if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" ){
					$this->load->model(array('m_payment','m_user','m_session'));
	
					$params = array();
					$params['details'] = json_encode(array_merge($resDetail,$resArray));
					$params['status'] = $resArray['PAYMENTINFO_0_PAYMENTSTATUS'];
					$params['amount'] = $resArray['PAYMENTINFO_0_AMT'];
					$params['transaction_id'] = $resArray['PAYMENTINFO_0_TRANSACTIONID'];
					$params['fee'] = $resArray['PAYMENTINFO_0_FEEAMT'];
					$params['tax'] = $resArray['PAYMENTINFO_0_TAXAMT'];
					$params['status_desc'] = $resArray['PAYMENTINFO_0_PENDINGREASON']=='None'?'':$resArray['PAYMENTINFO_0_PENDINGREASON'];
					$params['cdate'] = str_replace('Z','',str_replace('T',' ',$resArray['TIMESTAMP']));
					$params['payer_id'] = $this->m_session->getUserID();
					
					$res = $this->m_payment->savePayment($params);
	
					if($res['status']){
						redirect('payment/success/'.$res['id']);
					}
				}else{
					$this->_error($resArray);
				}
			}else{
				$this->_error($resArray);
			}
		}
	}
	
	function _error($resArray){
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
	
	function success($payment_id = 0){
		$this->load->model(array('m_payment','m_membership','m_company','m_user','m_session'));
		
		$user_id = $this->m_session->getUserID();
		
		$payment = $this->m_payment->get(array('id'=>$payment_id,'payer_id'=>$user_id,'used'=>0));
		if(empty($payment)){
			show_404();
		}
		
		$types = $this->m_membership->getTypes();
		$template['fees'] = $types;
	
		$template['modules'] = array(
			'login' => 1,
			'category-menu' => 1,
			'top-menu' => 1
		);

		$template['user'] = $this->m_user->getUserById($user_id);
		$company_id = $this->m_user->getCompanyByUser($user_id);
		$template['company'] = $this->m_company->getCompanyById($company_id);
		$template['payment'] =& $payment[0];
		$template['payment']->details = json_decode($template['payment']->details);
		if($this->paypal->payflow){
			$membership_type = explode(';',$template['payment']->details->L_NAME0);
		}else{
			$membership_type = explode(';',$template['payment']->details->L_PAYMENTREQUEST_0_NAME0);
		}
		$data_membership = array(
			'membership'        => ucfirst($membership_type[0]),
			'fee'		        => $template['payment']->amount,
			'period'	        => $template['payment']->cdate
		);
        
		$template['chosen'] = $data_membership;
		
		$this->m_membership->upgradeTo($user_id,$data_membership['membership']);

		$this->m_payment->update(array('used'=>1),array('id'=>$payment_id,'payer_id'=>$user_id));
		
		$template['content'] = $this->load->view('modules/user/upgrade_view4',$template,true);
		$template['layout'] = 'company';
		$this->load->view('template', $template);
	}
		
	function invalid($params = array()){

	}

	public function checkout(){

		$paymentAmount = 20;//$this->session->userdata("Payment_Amount");
		
		$params['shipToName'] = 'Helman';
		$params['shipToStreet'] = 'Evaline st';
		$params['shipToCity'] = 'Sydney';
		$params['shipToState'] = 'NSW';
		$params['shipToCountryCode'] = 'AU';
		$params['shipToZip'] = '2194';
		$params['shipToStreet2'] = 'My Street 2';
		$params['phoneNum'] = '+61425601717';
		$resArray = $this->paypal->CallMarkExpressCheckout(20, $params['shipToName'], $params['shipToStreet'], $params['shipToCity'], $params['shipToState'], $params['shipToCountryCode'], $params['shipToZip'], $params['shipToStreet2'], $params['phoneNum']);
		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING"){
			$this->paypal->RedirectToPayPal ( $resArray["TOKEN"] );
		}else{
			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			echo "<pre>";
			print_r($resArray);
			$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
			$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		}
	}
	
	public function cancel(){
		$token = $this->input->get_post('token');
		$arr = $this->paypal->GetShippingDetails($token);
		
		redirect('user/upgrade?cancel=1');
	}
}
?>