<?php
namespace App\Controllers\V1\Member;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Wallet extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->wallet   = model('App\Models\V1\Mdl_wallet');
        $this->fee      = model('App\Models\V1\Mdl_fee');
        $this->cost     = model('App\Models\V1\Mdl_cost');        
        $this->member   = model('App\Models\V1\Mdl_member');
	}
	
	public function getBalance(){
	    $currency   = $this->request->getGet('currency', FILTER_SANITIZE_STRING);
	    $userid     = $this->request->getGet('userid', FILTER_SANITIZE_STRING);

    	$result = $this->wallet->get_balance($userid,$currency);
    	$response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => [
	                    "balance"   => $result
	                ]
	        ];
        return $this->respond($response);
	    
	}
	
	public function bankSummary(){
	    $validation = $this->validation;
        $validation->setRules([
					'userid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'User ID is required',
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount is required',
					        'greater_than'  => 'Amount can not be negative',
					    ]
					],
					'currency' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'transfer_type' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Transfer type is required',
					    ]
					]					
				]);
				
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();
	    $filters = array(
            'userid'        => FILTER_SANITIZE_STRING, 
            'amount'        => FILTER_VALIDATE_FLOAT, 
            'currency'      => FILTER_SANITIZE_STRING, 
            'transfer_type' => FILTER_SANITIZE_STRING, 
        );

	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered;
        
        $balance = $this->wallet->get_balance($data->userid,$data->currency);

        $fee = $this->getFee($data->currency);
        $fees=0;
        $deduct=0;
        if ($data->transfer_type=="circuit"){
            $deduct = $data->amount + $fee['cost_circuit'] + $fee['fee_circuit'] + $fee['referral_send'];
            $fees=$fee['cost_circuit'] + $fee['fee_circuit'] + $fee['referral_send'];
        }elseif($data->transfer_type="outside"){
            $deduct = $data->amount + $fee['cost_outside'] + $fee['fee_outside'] + $fee['referral_send'];
            $fees=$fee['cost_outside'] + $fee['fee_outside'] + $fee['referral_send'];
        }

        if ($balance<$deduct){
            $response=[
	            "code"     => "5056",
	            "error"    => "21",
	            "message"  => "Insufficient Fund"
	        ];
            return $this->respond($response);
        }
        $response=[
            "code"     => "200",
            "error"    => null,
            "message"  => [
                "transfer_type" => $data->transfer_type,
                "amount"    => $data->amount,
                "deduct"    => $deduct,
                "fee"       => $fees
            ]
        ];
        return $this->respond($response);        
    }
    
    private function dataUSD($data=NULL){
        if ($data->transfer_type=="circuit"){
            $recipient=array(
              "currency"    => "USD", 
              "type"        => "ABA", 
              "profile"     => sandbox()->profile, 
              "accountHolderName"   => $data->bank_detail->recipient,
              "legalType"           => "PRIVATE",
              "details"             => array ( 
                "abartn"            => $data->bank_detail->swift,
                "accountNumber"     => $data->bank_detail->account_number,
                "accountType"       => strtoupper($data->bank_detail->account_type),
                "address"       => array (
                    "countryCode"   => "US",
                    "firstLine"     => $data->bank_detail->address,
                    "postCode"      => $data->bank_detail->postalcode,
                    "city"          => $data->bank_detail->city,
                    "state"         => $data->bank_detail->state,
                ),
              )
            );                
        }else{
            $recipient=array(
                "currency"    => "USD", 
                "type"        => "SWIFT_CODE", 
                "profile"     => sandbox()->profile, 
                "accountHolderName"   => $data->bank_detail->recipient,
                "legalType"           => "PRIVATE",
                "details"    => array (
                    "address"   => array (
                        "countryCode"   => "US",
                        "firstLine"     => $data->bank_detail->address,
                        "postCode"      => $data->bank_detail->postalcode,
                        "state"         => $data->bank_detail->state,
                        "city"          => $data->bank_detail->city,
                    ),
                    "swiftCode"    => $data->bank_detail->swift,
                    "accountNumber"=> $data->bank_detail->account_number
              )
            );                
        }
        return $recipient;
    }
    
    private function dataEUR($data=NULL){
        if ($data->transfer_type=="circuit"){
            $recipient=array(
                "currency"    => "EUR", 
                "type"        => "IBAN", 
                "profile"     => sandbox()->profile, 
                "accountHolderName"   => $data->bank_detail->recipient,
                "legalType"           => "PRIVATE",
                "details"    => array ( 
                    "iban"    => $data->bank_detail->account_number
                )
            ); 
        }else{
            $recipient=array(
                "currency"    => "EUR", 
                "type"        => "SWIFT_CODE", 
                "profile"     => sandbox()->profile, 
                "accountHolderName"   => $data->bank_detail->recipient,
                "legalType"           => "PRIVATE",
                "details"    => array (
                    "swiftCode"    => $data->bank_detail->swift,
                    "accountNumber"=> $data->bank_detail->account_number
                )
            );         
        }
        return $recipient;        
    }

    private function dataAED($data=NULL){
        //only local bank account
        if ($data->transfer_type=="circuit"){
            $recipient=array(
                "currency"    => "AED", 
                "type"        => "emirates", 
                "profile"     => sandbox()->profile, 
                "accountHolderName"   => $data->bank_detail->recipient,
                "legalType"           => "PRIVATE",
                "details"    => array ( 
                    "iban"    => $data->bank_detail->account_number
                )
            ); 
        }
        return $recipient;        
    }
    
    public function bankTransfer(){
        $validation = $this->validation;
        $validation->setRules([
					'userid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'User ID is required',
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount is required',
					        'greater_than'  => 'Amount can not be negative',
					    ]
					],
					'currency' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'transfer_type' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Transfer type is required',
					    ]
					],
					'bank_detail' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Bank detail is required',
					    ]
					]
				]);
				
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();

	    $filters = array(
            'userid'        => FILTER_SANITIZE_STRING, 
            'amount'        => FILTER_VALIDATE_FLOAT, 
            'currency'      => FILTER_SANITIZE_STRING, 
            'transfer_type' => FILTER_SANITIZE_STRING, 
            'bank_detail'   => FILTER_DEFAULT
        );

	    $filtered = array();
        foreach($data as $key=>$value) {
            if ($key!="bank_detail"){
                $filtered[$key] = filter_var($value, $filters[$key]);
            }else{
                $filtered[$key] = $value;
            }
        }
        
        $data=(object) $filtered;
        $balance = $this->wallet->get_balance($data->userid,$data->currency);

        $fee = $this->getFee($data->currency);
        $fee["fee"]=0;
        $fee["cost"]=0;
        if ($data->transfer_type=="circuit"){
            $fee["fee"]=$fee["fee_circuit"];
            $fee["cost"]=$fee["cost_circuit"];
            $deduct = $data->amount + $fee['cost_circuit'] + $fee['fee_circuit'] + $fee['referral_send'];
        }elseif($data->transfer_type="outside"){
            $fee["fee"]=$fee["fee_outside"];
            $fee["cost"]=$fee["cost_outside"];
            $deduct = $data->amount + $fee['cost_outside'] + $fee['fee_outside'] + $fee['referral_send'];
        }

        if ($balance<$deduct){
            $response=[
	            "code"     => "5056",
	            "error"    => "21",
	            "message"  => "Insufficient Fund"
	        ];
            return $this->respond($response);
        }
        
        $dataquote=array(
        	"sourceCurrency"    => $data->currency,
        	"targetCurrency"    => $data->currency,
        	"sourceAmount"      => null,
        	"targetAmount"      => $data->amount,
            "profile"           => sandbox()->profile
            );

        $jsonquote=json_encode($dataquote);
        $resultquote=apiwise(sandbox()->quote,$jsonquote,sandbox()->token);

        if ($data->currency=="USD"){
            $data_recipient=$this->dataUSD($data);
        }elseif ($data->currency=="EUR"){
            $data_recipient=$this->dataEUR($data);
        }elseif ($data->currency=="AED"){
            $data_recipient=$this->dataAED($data);
        }

        $jsonrecipient=json_encode($data_recipient);
        $resultrecipient=apiwise(sandbox()->recipient,$jsonrecipient,sandbox()->token);
        if (!empty($resultrecipient->error)){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => "Something wrong, please try again later!"
    	        ];
    	    return $this->respond($response);
        }
        
        if (empty($resultrecipient->id) && ($resultquote->id)){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => "Something wrong, please try again later!"
    	        ];
    	    return $this->respond($response);
        }
        //transfer
        $data_transfer=array(
            "targetAccount" => $resultrecipient->id,
            "quoteUuid"     => $resultquote->id,
            "customerTransactionId" => $resultquote->id,
            "details" => array (
                "reference" => $data->bank_detail->causal,
                "transferPurpose"   => "verification.source.of.funds.other",
                "sourceOfFunds"     => "Trust funds"
            )
        );
        $jsontransfer=json_encode($data_transfer);
        $resulttransfer=apiwise(sandbox()->transfer,$jsontransfer,sandbox()->token);

        if (!empty($resulttransfer->error)){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => "Something wrong, please try again later!"
    	        ];
    	    return $this->respond($response);
        }

        $data_fund=array(
            "type"  => "BALANCE"
        );
        $jsonfund=json_encode($data_fund);
        $resultfund=apiwise(sandbox(NULL,$resulttransfer->id)->payment,$jsonfund,sandbox()->token);
        if ($resultfund->status!="COMPLETED"){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => $resultfund->errorMessage
    	        ];
    	    return $this->respond($response);
        }
        
        
        $mdata = array(
            'sender_id'         => $data->userid,
            'currency'          => $data->currency,
            'type'              => $data->transfer_type,
            'receiver_name'     => $data->bank_detail->recipient,
            'iban'              => $data->bank_detail->account_number,
            'bic'               => $data->bank_detail->swift,
            'amount'            => $data->amount,
            'bank_name'         => $data->bank_detail->bank_name,
            'receiver_address'  => $data->bank_detail->address,
            'causal'            => $data->bank_detail->causal,
            'pbs_cost'          => $fee['cost'],
            'fee'               => $fee['fee'],
            'referral_fee'      => $fee['referral_send'],
        );
        
        $result = $this->wallet->wallet2bank($mdata);
	    $response=[
	            "code"     => "200",
	            "error"    => NULL,
	            "message"  => "Transfer completed"
	        ];
	    return $this->respond($response);
    }
    
    private function getFee($currency) {
        $bank       = getBankId(apache_request_headers()["Authorization"]);

        $feedb  = $this->fee->get_single($currency,$bank->id);
        $costdb = $this->cost->get_single($currency,$bank->id);

        $data=array(
                "fee_circuit"       => $feedb->walletbank_circuit,
                "fee_outside"       => $feedb->walletbank_outside,
                "fee_sender"        => $feedb->wallet_sender,
                "fee_receiver"      => $feedb->wallet_receiver,
                "referral_send"     => $feedb->referral_send,
                "referral_receive"  => $feedb->referral_receive,
                "cost_circuit"      => $costdb->walletbank_circuit,
                "cost_outside"      => $costdb->walletbank_outside,
                "cost_sender"       => $costdb->wallet_sender,
                "cost_receiver"     => $costdb->wallet_receiver
                );
        return $data;
    }	    
    
    public function getSummary(){
	    $validation = $this->validation;
        $validation->setRules([
					'userid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'User ID is required',
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount is required',
					        'greater_than'  => 'Amount can not be negative',
					    ]
					],
					'currency' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'ucode' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Recipient Unique Code is required',
					    ]
					]					
				]);
				
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();
	    $filters = array(
            'userid'        => FILTER_SANITIZE_STRING, 
            'amount'        => FILTER_VALIDATE_FLOAT, 
            'currency'      => FILTER_SANITIZE_STRING, 
            'ucode'         => FILTER_SANITIZE_STRING, 
        );

	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered; 
        
        $recipient_id=$this->member->getby_ucode($data->ucode,$data->userid);
        if (@$recipient_id->code=="5051"){
    	    return $this->respond($recipient_id);
        }

    	$balance = $this->wallet->get_balance($data->userid,$data->currency);
        $fee = $this->getFee($data->currency);
        $deduct = $data->amount + $fee['cost_sender'] + $fee['fee_sender'] + $fee['referral_send'];

        if ($balance<$deduct){
            $response=[
	            "code"     => "5056",
	            "error"    => "21",
	            "message"  => "Insufficient Fund"
	        ];
            return $this->respond($response);
        }

        $response=[
            "code"     => "200",
            "error"    => NULL,
            "message"  => [
                    "amount"    => $data->amount,
                    "deduct"    => $deduct,
                    "fee"       => $fee["cost_sender"]+$fee["fee_sender"]+$fee["referral_send"]
                ]
        ];
        return $this->respond($response);

    }
    
    public function walletTransfer(){
	    $validation = $this->validation;
        $validation->setRules([
					'userid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'User ID is required',
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount is required',
					        'greater_than'  => 'Amount can not be negative',
					    ]
					],
					'currency' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'ucode' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Recipient Unique Code is required',
					    ]
					]					
				]);
				
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();
	    $filters = array(
            'userid'        => FILTER_SANITIZE_STRING, 
            'amount'        => FILTER_VALIDATE_FLOAT, 
            'currency'      => FILTER_SANITIZE_STRING, 
            'ucode'         => FILTER_SANITIZE_STRING, 
        );

	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered; 
        
        $recipient_id=$this->member->getby_ucode($data->ucode,$data->userid);
        if (@$recipient_id->code=="5051"){
    	    return $this->respond($recipient_id);
        }

    	$balance = $this->wallet->get_balance($data->userid,$data->currency);
        $fee = $this->getFee($data->currency);
        $deduct = $data->amount + $fee['cost_sender'] + $fee['fee_sender'] + $fee['referral_send'];

        if ($balance<$deduct){
            $response=[
	            "code"     => "5056",
	            "error"    => "21",
	            "message"  => "Insufficient Fund"
	        ];
            return $this->respond($response);
        }
        
        $mdata=array(
                "sender_id"         => $data->userid,
                "receiver_id"       => $recipient_id->id,
                "amount"            => $data->amount,
                "currency"          => $data->currency,
                "pbs_sender_cost"   => $fee["cost_sender"],
                "pbs_receiver_cost" => $fee["cost_receiver"],
                "sender_fee"        => $fee["fee_sender"],
                "receiver_fee"      => $fee["fee_receiver"],
                "referral_sender_fee"   => $fee["referral_send"],
                "referral_receiver_fee" => $fee["referral_receive"],
            );

        $result=$this->wallet->wallet2wallet($mdata);
        $response=[
            "code"     => "200",
            "error"    => NULL,
            "message"  => $result
        ];
        return $this->respond($response);

        if ($result->code=="5055"){
            $this->respond($result);
        }

        $response=[
            "code"     => "200",
            "error"    => NULL,
            "message"  => "Wallet Transfer is completed"
        ];
        return $this->respond($response);

    }
    
}
