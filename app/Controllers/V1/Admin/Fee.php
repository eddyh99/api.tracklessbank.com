<?php
namespace App\Controllers\V1\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Fee extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->fee      = model('App\Models\V1\Admin\Mdl_fee');
	}
	
	public function getFee(){
	    $bank  = getBankId(apache_request_headers()["Authorization"]);
	    $currency   = $this->request->getGet('currency', FILTER_SANITIZE_STRING);
	    $result=$this->fee->get_single($bank->id,$currency);
	    if (@$result->code==5052){
	            return $this->respond(@$result);
    	    }
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $result
	        ];
	   return $this->respond($response);
	}
	
	public function setfee(){
	    $bank       = getBankId(apache_request_headers()["Authorization"]);
	    $validation = $this->validation;
        $validation->setRules([
					'topup' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Topup fee is required',
					        'decimal'       => 'Topup fee should in decimal',
					        'greater_than'  => 'Topup fee should greater than zero'
					    ]
					],
					'walletbank_circuit' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Wallet to Bank Circuit fee is required',
					        'decimal'       => 'Wallet to Bank Circuit fee should in decimal',
					        'greater_than'  => 'Wallet to Bank Circuit fee should greater than zero'
					    ]
					],
					'walletbank_outside' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Wallet to Bank Outside fee Circuit is required',
					        'decimal'       => 'Wallet to Bank Outside fee Circuit should in decimal',
					        'greater_than'  => 'Wallet to Bank Outside fee Circuit should greater than zero'
					    ]
					],
					'wallet_send' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Wallet to Wallet Sender fee is required',
					        'decimal'       => 'Wallet to Wallet Sender should in decimal',
					        'greater_than'  => 'Wallet to Wallet Sender should greater than zero'
					    ]
					],
					'wallet_receive' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Wallet to Wallet Receiver fee is required',
					        'decimal'       => 'Wallet to Wallet Receiver fee should in decimal',
					        'greater_than'  => 'Wallet to Wallet Receiver fee should greater than zero'
					    ]
					],
					'swap' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Swap fee is required',
					        'decimal'       => 'Swap fee should in decimal',
					        'greater_than'  => 'Swap fee should greater than zero'
					    ]
					],
					'referral_send' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Referral Sender fee is required',
					        'decimal'       => 'Referral Sender fee should in decimal',
					        'greater_than'  => 'Referral Sender fee should greater than zero'
					    ]
					],
					'referral_receive' => [
					    'rules'  => 'required|decimal|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Referral Recipient fee is required',
					        'decimal'       => 'Referral Recipient fee should in decimal',
					        'greater_than'  => 'Referral Recipient fee should greater than zero'
					    ]
					],
					'currency' => [
					    'rules'  => 'required|min_length[3]|max_length[3]',
					    'errors' =>  [
					        'required'      => 'Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
            ]);
        
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        
        $data           = $this->request->getJSON();
        
        $filters = array(
            'topup'                 => FILTER_VALIDATE_FLOAT, 
            'walletbank_circuit'    => FILTER_VALIDATE_FLOAT, 
            'walletbank_outside'    => FILTER_VALIDATE_FLOAT, 
            'wallet_send'           => FILTER_VALIDATE_FLOAT, 
            'wallet_receive'        => FILTER_VALIDATE_FLOAT, 
            'swap'                  => FILTER_VALIDATE_FLOAT, 
            'referral_send'         => FILTER_VALIDATE_FLOAT, 
            'referral_receive'      => FILTER_VALIDATE_FLOAT, 
            'currency'              => FILTER_SANITIZE_STRING, 
        );
	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered;  
        $mdata = array(
                "bank_id"               => $bank->id,
    	        "topup"                 => $data->topup,
    	        "walletbank_circuit"    => $data->walletbank_circuit,
    	        "walletbank_outside"    => $data->walletbank_outside,
    	        "wallet_send"           => $data->wallet_send,
    	        "wallet_receive"        => $data->wallet_receive,
    	        "swap"                  => $data->swap,
    	        "referral_send"         => $data->referral_send,
    	        "referral_receive"      => $data->referral_receive,
    	        "currency"              => $data->currency,
    	);

    	$result=$this->fee->setfee($mdata);
    	if (@$result->code==5052){
            return $this->respond(@$result);
	    }
    	$response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => "Default fee successfully set"
	        ];
	   return $this->respond($response);
	}	
}
