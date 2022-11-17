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
    
    public function get_single($currency = NULL, $bank_id=NULL) {
        $sql="SELECT topup, walletbank_circuit, walletbank_outside, wallet_sender, wallet_receiver, swap
            FROM trackless_fee
            WHERE currency = ? AND bank_id=?
        ";
        $query = $this->db->query($sql, [$currency,$bank_id])->getRow();
        
        if ($query) {
            return $query;
        } else {
            return (object) array("topup"=>0,"walletbank_circuit"=>0,"walletbank_outside"=>0,"wallet_sender"=>0,"wallet_receiver"=>0,"swap"=>0);
        }
    }
}