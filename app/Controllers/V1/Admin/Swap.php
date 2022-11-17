<?php
namespace App\Controllers\V1\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Swap extends BaseController
{
    use ResponseTrait;
    

    public function __construct()
    {   
        $this->wallet = model('App\Models\V1\Admin\Mdl_wallet');
        $this->cost = model('App\Models\V1\Mdl_cost');
        $this->swap = model('App\Models\V1\Admin\Mdl_swap');
	}
	
	public function swap_summary(){
        $bank  = getBankId(apache_request_headers()["Authorization"]);

	    $validation = $this->validation;
        $validation->setRules([
                    'source' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Source Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'target' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Target Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount to swap is required',
					        'greater_than'  => 'Amount cannot be negative or zero'
					    ]
					]					
				]);
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();
	    $filters = array(
            'amount'    => FILTER_VALIDATE_FLOAT, 
            'source'    => FILTER_SANITIZE_STRING, 
            'target'    => FILTER_SANITIZE_STRING, 
        );
	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered;
        
        $balance = $this->wallet->balance_bycurrency($bank->id,$data->source);
        $fee = $this->getFee($data->source);
        $amount_swap = $data->amount - $fee["cost"];

	    if ($amount_swap > $balance){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "20",
    	            "message"  => "Insufficient Fund"
    	        ];
    	    return $this->respond($response);
        }
        
        $fee=0;

        $dataquote=array(
        	"sourceCurrency"    => $data->source,
        	"targetCurrency"    => $data->target,
        	"sourceAmount"      => round($amount_swap,2),
        	"targetAmount"      => null,
            "profile"           => sandbox()->profile,
            "payOut"            => "BALANCE"
        );
        $jsonquote=json_encode($dataquote);
        $resultquote=apiwise(sandbox()->quote,$jsonquote,sandbox()->token);

        if (!empty($resultquote->error)){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => "Something wrong, please contact the administrator!"
    	        ];
    	    return $this->respond($response);
        }

        $amountget=0;
        foreach ($resultquote->paymentOptions as $dt){
            if ($dt->payIn=="BALANCE"){
                $amountget=$dt->targetAmount;
                break;
            }
        }
        
        $mdata = array(
            'amount'    => $data->amount,
            'receive'   => number_format($amountget,2),
            'cost'      => $fee,
            'quoteid'   => $resultquote->id
            );
        
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $mdata
	        ];
	   return $this->respond($response);
	}
	
    private function getFee($currency) {
        $bank       = getBankId(apache_request_headers()["Authorization"]);

        $costdb = $this->cost->get_single($currency,$bank->id);

        return array("cost" => IS_NULL($costdb->swap) ? 0 : $costdb->swap);
    }	
    
    public function swapProcess(){
        $bank  = getBankId(apache_request_headers()["Authorization"]);
        
        $validation = $this->validation;
        $validation->setRules([
                    'userid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Userid is required',
					    ]
					],
					'source' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Source Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
					'target' => [
					    'rules'  => 'required|max_length[3]|min_length[3]',
					    'errors' =>  [
					        'required'      => 'Target Currency is required',
					        'min_length'    => 'Invalid Currency',
					        'max_length'    => 'Invalid Currency'
					    ]
					],
                    'amount' => [
					    'rules'  => 'required|greater_than[0]',
					    'errors' =>  [
					        'required'      => 'Amount to swap is required',
					        'greater_than'  => 'Amount cannot be negative or zero'
					    ]
					],
					'quoteid' => [
					    'rules'  => 'required',
					    'errors' =>  [
					        'required'      => 'Quoteid is required',
					    ]
					]
				]);
        if (!$validation->withRequest($this->request)->run()){
            return $this->fail($validation->getErrors());
        }
				
	    $data   = $this->request->getJSON();
	    $filters = array(
            'userid'    => FILTER_SANITIZE_STRING, 
            'amount'    => FILTER_VALIDATE_FLOAT, 
            'source'    => FILTER_SANITIZE_STRING, 
            'target'    => FILTER_SANITIZE_STRING,
            'quoteid'   => FILTER_SANITIZE_STRING,
        );
        
	    $filtered = array();
        foreach($data as $key=>$value) {
             $filtered[$key] = filter_var($value, $filters[$key]);
        }
        
        $data=(object) $filtered;
        
        $balance = $this->wallet->balance_bycurrency($bank->id,$data->source);
        $fee = $this->getFee($data->source);
        $amount_swap = $data->amount - $fee["cost"];

	    if ($amount_swap > $balance){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "20",
    	            "message"  => "Insufficient Fund"
    	        ];
    	    return $this->respond($response);
        }
        

        //read amount swap quote
        $ch     = curl_init(sandbox($data->quoteid)->readquote);
        $headers    = array(
            'Authorization: Bearer '.sandbox()->token,
            'Content-Type: application/json'
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resultquote = json_decode(curl_exec($ch));
        curl_close($ch);

        
        foreach ($resultquote->paymentOptions as $dt){
            if ($dt->payIn=="BALANCE"){
                $amountget=$dt->targetAmount;
                break;
            }    
        }


        //execute swap process
        $dataquote=array(
            "quoteId"   => $data->quoteid
        );
        $jsonquote=json_encode($dataquote);
        
        $ch     = curl_init(sandbox()->balancemove);
        $headers    = array(
            'Content-Type: application/json',
            'X-idempotence-uuid: '.$data->quoteid,
            'Authorization: Bearer '.sandbox()->token,
        );
        
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonquote); 
        $resultswap = json_decode(curl_exec($ch));
        curl_close($ch);

        if (!empty($resultswap->error)){
    	    $response=[
    	            "code"     => "5055",
    	            "error"    => "21",
    	            "message"  => "Something wrong, please contact the administrator!"
    	        ];
    	    return $this->respond($response);
        }

        
        $mdata = array(
            'user_id'       => $data->userid,
            'amount'        => $data->amount,
            'currency'      => $data->source,
            'receive'       => $amountget,
            'target_cur'    => $data->target,
            'pbs_cost'      => $fee["cost"],
            );

        $result = $this->swap->add($mdata);
        if (@$result->code==5055){
    	   return $this->respond($result);
        }
	    $response=[
	            "code"     => "200",
	            "error"    => null,
	            "message"  => $mdata
	        ];
	   return $this->respond($response);
        

    }
}
