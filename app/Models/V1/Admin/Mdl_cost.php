<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;


class Mdl_cost extends Model
{
    protected $server_tz = "Asia/Singapore";

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    public function get_single($bank_id,$currency){
        $sql="SELECT a.id, a.bank_id, a.currency, a.topup, a.wallet, (a.walletbank_circuit+b.transfer_cf) as walletbank_circuit, (a.walletbank_outside+b.transfer_ocf) as walletbank_outside, a.swap, a.date_created, a.last_update FROM trackless_fee a INNER JOIN wise_cost b ON a.currency=b.currency WHERE a.bank_id=? AND a.currency=?";
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