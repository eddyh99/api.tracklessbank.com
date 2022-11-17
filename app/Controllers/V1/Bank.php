<?php
namespace App\Controllers\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Bank extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->bank     = model('App\Models\V1\Mdl_bank');
	}
	
	public function setBank(){
	    $validation = $this->validation;
        $validation->setRules([
					'number_circuit' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Account Number is required',
					    ]
					],
					'name_circuit' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Registered name is required',
					    ]
					],
					'routing_circuit' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Routing Number is required',
					    ]
					],
					'bankname_circuit' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Bank name circuit is required',
					    ]
					],
					'name_outside' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Registered name outside is required',
					    ]
					],
					'iban_outside' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'IBAN is required',
					    ]
					],
					'bic_outside' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'BIC is required',
					    ]
					],
					'bankname_outside' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Bank Name is required',
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
        
	   	$data   = $this->request->getJSON();
	   	$status = $this->request->getGet('status', FILTER_SANITIZE_STRING);
        
        $filters = array(
            'number_circuit'    => FILTER_SANITIZE_STRING, 
            'name_circuit'      => FILTER_SANITIZE_STRING, 
            'routing_circuit'   => FILTER_SANITIZE_STRING, 
            'bankname_circuit'  => FILTER_SANITIZE_STRING, 
            'address_circuit'   => FILTER_SANITIZE_STRING, 
            'name_outside'      => FILTER_SANITIZE_STRING, 
            'iban_outside'      => FILTER_SANITIZE_STRING, 
            'bic_outside'       => FILTER_SANITIZE_STRING, 
            'bankname_outside'  => FILTER_SANITIZE_STRING, 
            'address_outside'   => FILTER_SANITIZE_STRING, 
            'currency'          => FILTER_SANITIZE_STRING, 
        );
	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered;
        
        if (($status!="new") && ($status!='modified')){
            $response=[
                    "code"       => "5054",
                    "error"      => "19",
                    "message"    => "Invalid process status"
                ];
            return $this->respond($response);
        }

        $mdata = array(
            "currency"           => $data->currency,
            "c_account_number"   => $data->number_circuit,
            "c_registered_name"  => $data->name_circuit,
            "c_routing_number"   => $data->routing_circuit,
            "c_bank_name"        => $data->bankname_circuit,
            "c_bank_address"     => $data->address_circuit,
            "oc_registered_name" => $data->name_outside,
            "oc_iban"            => $data->iban_outside,
            "oc_bic"             => $data->bic_outside,
            "oc_bank_name"       => $data->bankname_outside,
            "oc_bank_address"    => $data->address_outside
        );
    	
    	$result=$this->bank->setBank($mdata);
    	if (@$result->code==5054){
            return $this->respond(@$result);
	    }
        
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => "Bank successfully saved"
	        ];
	    return $this->respond($response);
	}
	
	public function getBank(){
	   	$currency = $this->request->getGet('currency', FILTER_SANITIZE_STRING);
        if (($currency!="EUR") && ($currency!='AUD') && ($currency!='USD') && ($currency!='NZD') && ($currency!='CAD') && ($currency!='HUF') && ($currency!='SGD') && ($currency!='TRY')){
            $response=[
                    "code"       => "5054",
                    "error"      => "17",
                    "message"    => "Bank not found"
                ];
            return $this->respond($response);
        }
        
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $this->bank->getby_currency($currency)
	        ];
	   return $this->respond($response);
	    
	}
}
