<?php
namespace App\Models;

use CodeIgniter\Model;
use Exception;


class Mdl_wallet extends Model
{
    protected $server_tz = "Asia/Singapore";

	public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    public function get_all($bankid){
        $sql="SELECT currency,symbol FROM tbl_currency WHERE status='active'";
        $cur=$this->db->query($sql)->getResult();
        $mdata=array();
        foreach($cur as $dt){
            $sql="SELECT IFNULL(sum(amount),0) as amount FROM (
                    SELECT sum(fee) as amount FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND a.currency=? 
                    UNION ALL
                    SELECT sum(fee) as amount FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND a.currency=?
                    UNION ALL
                    SELECT sum(fee) as amount FROM tbl_member_swap a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND a.currency=?
                    UNION ALL
                    SELECT sum(sender_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND a.currency=?
                    UNION ALL
                    SELECT sum(receiver_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.receiver_id=b.id WHERE b.bank_id=? AND a.currency=?
                    UNION ALL
                    SELECT sum(referral_fee) as amount FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                    UNION ALL
                    SELECT sum(referral_fee) as amount FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                    UNION ALL
                    SELECT sum(referral_sender_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                    UNION ALL
                    SELECT sum(amount)*-1 as amount FROM tbl_master_withdraw a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.currency=?
                    UNION ALL
                    SELECT sum(amount) *-1 as amount FROM tbl_master_swap a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.currency=? 
                    UNION ALL
                    SELECT sum(receive) as amount FROM tbl_master_swap a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.target_cur=?
                ) x
            ";
            
            $result=$this->db->query($sql,[
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
                $bankid,$dt->currency,
            ])->getRow()->amount;
                
            $temp["currency"]=$dt->currency;
            $temp["symbol"]=$dt->symbol;
            $temp["amount"]=$result;
            array_push($mdata,$temp);
        }
        return (object)$mdata;
    }
    
    public function balance_bycurrency($bankid,$currency){
        $sql="SELECT IFNULL(sum(amount),0) as amount FROM (
                SELECT sum(fee) as amount FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND a.currency=? 
                UNION ALL
                SELECT sum(fee) as amount FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND a.currency=?
                UNION ALL
                SELECT sum(fee) as amount FROM tbl_member_swap a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND a.currency=?
                UNION ALL
                SELECT sum(sender_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND a.currency=?
                UNION ALL
                SELECT sum(receiver_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.receiver_id=b.id WHERE b.bank_id=? AND a.currency=?
                UNION ALL
                SELECT sum(referral_fee) as amount FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                UNION ALL
                SELECT sum(referral_fee) as amount FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                UNION ALL
                SELECT sum(referral_sender_fee) as amount FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE b.bank_id=? AND ISNULL(b.id_referral) AND a.currency=?
                UNION ALL
                SELECT sum(amount)*-1 as amount FROM tbl_master_withdraw a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.currency=?
                UNION ALL
                SELECT sum(amount) *-1 as amount FROM tbl_master_swap a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.currency=? 
                UNION ALL
                SELECT sum(receive) as amount FROM tbl_master_swap a INNER JOIN tbl_user b ON a.user_id=b.id WHERE b.bank_id=? AND a.target_cur=?
            ) x
        ";
            
        $result=$this->db->query($sql,[
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
            $bankid,$currency,
        ])->getRow()->amount;
        return $result;
    }
    
    public function get_historybycurrency($currency=NULL,$awal=NULL, $akhir=NULL, $timezone=NULL){
        $sql="SELECT amount, CONCAT('topup ',ucode) as ket, fee, pbs_cost as cost, referral_fee as referral, convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ? 
              UNION ALL
              SELECT amount, CONCAT('Withdraw ',ucode) as ket, fee, pbs_cost as cost, referral_fee as referral,convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE  currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ? 
              UNION ALL
              SELECT amount, CONCAT('Transfer from ',b.ucode, ' to ', c.ucode) as ket, (sender_fee+receiver_fee) as fee, (pbs_sender_cost+pbs_receiver_cost) as cost, (referral_sender_fee+referral_receiver_fee) as referral,convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id INNER JOIN tbl_member c ON a.receiver_id=c.id WHERE currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ? 
              UNION ALL
              SELECT amount, CONCAT(ucode, ' Swap From ', currency, ' to ', target_cur) as ket, fee, pbs_cost as cost, 0 as referral,  convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_swap a INNER JOIN tbl_member b ON a.id_member=b.id WHERE currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ?
        ";
        
        $query=$this->db->query($sql,
        [
            $timezone,$currency,$timezone,$awal,$akhir,
            $timezone,$currency,$timezone,$awal,$akhir,
            $timezone,$currency,$timezone,$awal,$akhir,
            $timezone,$currency,$timezone,$awal,$akhir,
        ]);
        
        if ($query) {
            return $query->getResult();
        } else {
            return $this->db->error();            
        }
        
    }
    
    public function history_topup($currency=NULL,$awal=NULL, $akhir=NULL, $timezone=NULL){
        $sql="SELECT amount, CONCAT('topup ',ucode) as ket, fee, pbs_cost as cost, referral_fee as referral, convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_topup a INNER JOIN tbl_member b ON a.id_member=b.id WHERE currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ?";
        $query=$this->db->query($sql,[$timezone,$currency,$timezone,$awal,$akhir]);
        if ($query) {
            return $query->getResult();
        } else {
            return $this->db->error();            
        }
    }
    
    public function history_wallet($currency=NULL,$awal=NULL, $akhir=NULL, $timezone=NULL){
        $sql="SELECT amount, CONCAT('Transfer from ',b.ucode, ' to ', c.ucode) as ket, (sender_fee+receiver_fee) as fee, (pbs_sender_cost+pbs_receiver_cost) as cost, (referral_sender_fee+referral_receiver_fee) as referral,convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_towallet a INNER JOIN tbl_member b ON a.sender_id=b.id INNER JOIN tbl_member c ON a.receiver_id=c.id WHERE currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ?";
        $query=$this->db->query($sql,[$timezone,$currency,$timezone,$awal,$akhir]);
        if ($query) {
            return $query->getResult();
        } else {
            return $this->db->error();            
        }
    }
    
    public function history_tobank($currency=NULL,$awal=NULL, $akhir=NULL, $timezone=NULL){
        $sql="SELECT amount, CONCAT('Withdraw ',ucode) as ket, fee, pbs_cost as cost, referral_fee as referral,convert_tz(a.date_created, '".$this->server_tz."', ?) AS date_created FROM tbl_member_tobank a INNER JOIN tbl_member b ON a.sender_id=b.id WHERE  currency=? AND DATE(convert_tz(a.date_created, '".$this->server_tz."', ?)) BETWEEN ? AND ?";
        $query=$this->db->query($sql,[$timezone,$currency,$timezone,$awal,$akhir]);
        if ($query) {
            return $query->getResult();
        } else {
            return $this->db->error();            
        }
    }
}