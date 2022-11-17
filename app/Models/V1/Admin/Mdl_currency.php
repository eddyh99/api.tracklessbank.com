<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;


class Mdl_currency extends Model
{
    protected $server_tz = "Asia/Singapore";

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    public function get_single($currency){
        $sql="SELECT currency,symbol FROM tbl_currency WHERE status='active' AND currency=?";
        $cur=$this->db->query($sql,[$currency])->getRow();
        return $cur;
    }
}