<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_payment extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function get($params = array()){
		foreach($params as $key => $value){
			$this->db->where($key,$value);
		}
		$res = $this->db->get('user_payment');
		return $res->result();
	}
	
	function update($data=array(),$params=array()){
		if(empty($params)) return false;
		
		foreach($params as $key => $value){
			$this->db->where($key,$value);
		}
		foreach($data as $key => $value){
			$this->db->set($key,$value);
		}
		$res = $this->db->update('user_payment');
		return $this->db->affected_rows();
	}
	function savePayment($params){
		/*
		Array(
			[TOKEN] => EC-81B8603585382292G
			[SUCCESSPAGEREDIRECTREQUESTED] => false
			[TIMESTAMP] => 2012-06-26T03:20:21Z
			[CORRELATIONID] => eca29c8a20b0d
			[ACK] => Success
			[VERSION] => 64
			[BUILD] => 3067390
			[INSURANCEOPTIONSELECTED] => false
			[SHIPPINGOPTIONISDEFAULT] => false
			[PAYMENTINFO_0_TRANSACTIONID] => 5MK508597G7845258
			[PAYMENTINFO_0_TRANSACTIONTYPE] => expresscheckout
			[PAYMENTINFO_0_PAYMENTTYPE] => instant
			[PAYMENTINFO_0_ORDERTIME] => 2012-06-26T03:20:19Z
			[PAYMENTINFO_0_AMT] => 1000.00
			[PAYMENTINFO_0_FEEAMT] => 29.30
			[PAYMENTINFO_0_TAXAMT] => 0.00
			[PAYMENTINFO_0_CURRENCYCODE] => USD
			[PAYMENTINFO_0_PAYMENTSTATUS] => Completed
			[PAYMENTINFO_0_PENDINGREASON] => None
			[PAYMENTINFO_0_REASONCODE] => None
			[PAYMENTINFO_0_PROTECTIONELIGIBILITY] => Eligible
			[PAYMENTINFO_0_ERRORCODE] => 0
			[PAYMENTINFO_0_ACK] => Success
		)
		*/


		//$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
		//$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
		//$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
		//$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
		//$amt				= $resArray["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
		//$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
		//$feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  //' PayPal fee amount charged for the transaction
		//$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
		//$taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  //' Tax charged on the transaction.
		//$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.
		
		/*
		' Status of the payment: 
				'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
				'Pending: The payment is pending. See the PendingReason element for more information. 
		*/
		
		//$paymentStatus	= $resArray["PAYMENTINFO_0_PAYMENTSTATUS"]; 

		/*
		'The reason the payment is pending:
		'  none: No pending reason 
		'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile. 
		'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared. 
		'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview. 		
		'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment. 
		'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment. 
		'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service. 
		*/
		
		//$pendingReason	= $resArray["PAYMENTINFO_0_PENDINGREASON"];  

		/*
		'The reason for a reversal if TransactionType is reversal:
		'  none: No reason code 
		'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer. 
		'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee. 
		'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer. 
		'  refund: A reversal has occurred on this transaction because you have given the customer a refund. 
		'  other: A reversal has occurred on this transaction due to a reason not listed above. 
		*/
		
		//$reasonCode		= $resArray["PAYMENTINFO_0_REASONCODE"];
		
		$data = array('status'=>false);
		if(empty($params['payer_id'])||empty($params['details'])){
			return $data;
		}
		if(empty($params['cdate'])){
			$params['cdate'] = date("Y-m-d h:i:s");
		}
		if(empty($params['status'])){
			$params['status'] = 'Pending';
		}

		$data['status'] = $this->db->insert('user_payment',$params);
		$data['id'] = $this->db->insert_id();
		
		return $data;
	}
}
?>