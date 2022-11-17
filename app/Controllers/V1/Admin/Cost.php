<?php
namespace App\Controllers\V1\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Cost extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->cost      = model('App\Models\V1\Admin\Mdl_cost');
	}
	
	public function getCost(){
	    $bank  = getBankId(apache_request_headers()["Authorization"]);
	    $currency   = $this->request->getGet('currency', FILTER_SANITIZE_STRING);
	    $result=$this->cost->get_single($bank->id,$currency);
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
}
