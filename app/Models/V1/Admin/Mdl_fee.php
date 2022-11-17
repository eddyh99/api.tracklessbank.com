<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;


class Mdl_fee extends Model
{
    protected $server_tz = "Asia/Singapore";

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function setfee($mdata=array()){
        $currencyfee=$this->db->table("tbl_defaultfee");
        if (!$currencyfee->replace($mdata)){
            $error=[
	            "code"       => "5052",
	            "error"      => "17",
	            "message"    => "Invalid Currency / Bank ID"
	        ];
            return (object) $error;
        }
    }
    
    public function get_single($bank_id,$currency){
        $sql="SELECT `bank_id`, `currency`, `topup`, `wallet_sender`, `wallet_receiver`, `walletbank_circuit`, `walletbank_outside`, `swap`, `referral_send`, `referral_receive WHERE bank_id=? AND currency=?";
        $query=$this->db->query($sql,[$bank_id,$currency])->getRow();
        if (!$query){
            $error=[
	            "code"       => "5052",
	            "error"      => "17",
	            "message"    => "Invalid Currency / Bank ID"
	        ];
            return (object) $error;
        }
        return $query;
    }
    

}