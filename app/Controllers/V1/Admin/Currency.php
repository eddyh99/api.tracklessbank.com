<?php
namespace App\Controllers\V1\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Currency extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->currency = model('App\Models\V1\Mdl_currency');
	}
	
	public function getAllCurrency(){
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $this->currency->get_all()
	        ];
	   return $this->respond($response);
	}
	
	public function currencyStatus(){
	    $validation = $this->validation;
        $validation->setRules([
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
        
	    $data   = $this->request->getGet('currency', FILTER_SANITIZE_STRING);
        $status = $this->request->getGet('status', FILTER_SANITIZE_STRING);

        if (($status!="active") && ($status!='disabled')){
            $response=[
                    "code"       => "5052",
                    "error"      => "09",
                    "message"    => "Invalid currency status"
                ];
            return $this->respond($response);
        }

    	if ($status=='active'){
        	$result=$this->currency->enable($data);
        	if (@$result->code==5052){
	            return $this->respond(@$result);
    	    }
        	$response=[
    	            "code"     => "200",
    	            "error"    => null,
    	            "message"  => "Currency is successfully activated"
    	        ];
        }elseif ($status=='disabled'){
        	$result=$this->currency->disable($data);
            if (@$result->code==5052){
    	        return $this->respond(@$result);
    	    }
            $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => "Currency is successfully disabled"
	        ];
        }
    	   return $this->respond($response);
	}
}
