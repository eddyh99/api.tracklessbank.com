<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;


class Mdl_member extends Model
{
    protected $server_tz = "Asia/Singapore";

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    
    public function get_all($bank_id,$timezone) {
        $smwallet="SELECT ucode_mwallet FROM bankmember WHERE id=?";
        $mwallet=$this->db->query($smwallet,$bank_id)->getRow()->ucode_mwallet;
        
        $user_tz = $timezone;
        $sql = "SELECT m1.`id`, m1.`ucode`, m1.`refcode`, m1.`email`, m1.`passwd`, m1.`status`, m1.`token`, m1.`id_referral`, convert_tz(m1.`date_created`, '".$this->server_tz."', ?) AS date_created, convert_tz(m1.`last_accessed`, '".$this->server_tz."', ?) AS last_accessed, m1.`location`, IFNULL(m2.ucode, ?) AS referral FROM `tbl_member` m1 LEFT JOIN `tbl_member` m2 ON m1.`id_referral`=m2.`id` WHERE m1.bank_id=?";
        $query = $this->db->query($sql, array($user_tz, $user_tz,$mwallet, $bank_id))->getResult();
        if (!$query) {
	        $error=[
	            "code"       => "5053",
	            "error"      => "04",
	            "message"    => "Failed to get data"
	        ];
            return (object) $error;
        }
        
        return $query;
    }
    
    public function activate($id) {
        $member=$this->db->table("tbl_member");
        $mdata = array(
            "token" => NULL,
            "status" => "active",
            );
        $member->where("id", $id);
        $member->where("status", "new");
        $member->update($mdata);
        if ($this->db->affectedRows()==0){
	        $error=[
	            "code"       => "5053",
	            "error"      => "15",
	            "message"    => "Failed to activate member"
	        ];
            return (object) $error;
        }
    }
    
    public function change_password($id, $new_pass) {
        $member=$this->db->table("tbl_member");
        $mdata = array(
            "passwd" => $new_pass,
            );
        $member->where("id", $id);
        $member->update($mdata);
        if ($this->db->affectedRows()==0){
	        $error=[
	            "code"       => "5053",
	            "error"      => "16",
	            "message"    => "Failed change member's password/Use same password"
	        ];
            return (object) $error;
        }
    }
    
    public function enable_member($id) {
        $member=$this->db->table("tbl_member");
        $mdata = array(
            "token" => NULL,
            "status" => "active",
        );
        $member->where("id", $id);
        $member->update($mdata);
        if ($this->db->affectedRows()==0){
	        $error=[
	            "code"       => "5053",
	            "error"      => "14",
	            "message"    => "Failed to disabled/reenable member"
	        ];
            return (object) $error;
        }
    }
    
    public function disable_member($id) {
        $member=$this->db->table("tbl_member");
        $mdata = array(
            "token" => NULL,
            "status" => "disabled",
        );
        $member->where("id", $id);
        $member->update($mdata);
         if ($this->db->affectedRows()==0){
	        $error=[
	            "code"       => "5053",
	            "error"      => "14",
	            "message"    => "Failed to disabled/reenable member"
	        ];
            return (object) $error;
        }
   }
}