<?php
namespace App\Controllers\V1\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Member extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->member = model('App\Models\V1\Admin\Mdl_member');
	}
	
	public function getAll(){
	    $bank       = getBankId(apache_request_headers()["Authorization"]);
        
        $validation = $this->validation;
        $validation->setRules([
					'timezone' => [
						'rules'  => 'required',
						'errors' => [
							'required'      => 'Timezone is required',
						]
					],
				]);
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        
	    $data   = $this->request->getJSON();	    
        $all    = $this->member->get_all($bank->id,$data->timezone);
	    $mdata = array();
	    foreach($all as $member) {
	       $m = array(
	           "id"        =>  $member->id,
	           "email"     =>  $member->email,
	           "ucode"     =>  $member->ucode,
	           "referral"  =>  $member->referral,
	           "status"    =>  $member->status,
	           "last_login"=>  $member->last_accessed==NULL?"-":$member->last_accessed,
	           );
	       $mdata[] = $m;
	    }
	    
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $mdata
	        ];
	   return $this->respond($response);
	}

    public function setMember(){
	    $userid   = $this->request->getGet('userid', FILTER_SANITIZE_STRING);
        $status = $this->request->getGet('status', FILTER_SANITIZE_STRING);

        if (($status!="enabled") && ($status!='disabled') && ($status!='activate')){
            $response=[
                    "code"       => "5053",
                    "error"      => "13",
                    "message"    => "Invalid member status"
                ];
            return $this->respond($response);
        }

    	if ($status=='enabled'){
        	$result=$this->member->enable_member($userid);
        	if (@$result->code==5053){
	            return $this->respond(@$result);
    	    }
        	$response=[
    	            "code"     => "200",
    	            "error"    => null,
    	            "message"  => "Member is successfully activated"
    	        ];
        }elseif ($status=='disabled'){
        	$result=$this->member->disable_member($userid);
            if (@$result->code==5053){
    	        return $this->respond(@$result);
    	    }
            $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => "Member is successfully disabled"
	        ];
        }elseif ($status=='activate'){
        	$result=$this->member->activate($userid);
            if (@$result->code==5053){
    	        return $this->respond(@$result);
    	    }
            $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => "Member is successfully activate"
	        ];
        }
	   return $this->respond($response);
	}
	
	public function updatepassword(){
	    $validation = $this->validation;
        $validation->setRules([
					'password' => [
						'rules'  => 'required',
						'errors' => [
							'required'      => 'Password is required',
						]
					],
				]);
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
        
	    $data   = $this->request->getJSON();
    	$result=$this->member->change_password($data->userid,$data->password);
        if (@$result->code==5053){
	        return $this->respond(@$result);
	    }
        $response=[
            "code"     => "200",
            "error"    => null,
            "message"  => "Password is successfully changed"
        ];
	    return $this->respond($response);
    }
}
