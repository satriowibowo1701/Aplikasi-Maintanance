<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Perbaikan_model extends CI_Model
{


    public function Get_all_perbaikan(){

        return $this->db->query('SELECT * FROM perbaikan')->result();

    }

    Public function Insert_new_perbaikan($data = array())
    
    {
        return $this->db->insert('perbaikan',$data);
    }


    public function Delete_perbaikan($id){

    $this->db->query("DELETE FROM perbaikan WHERE id = '$id'");
    }


    public function Get_data_id($id){
        return $this->db->get_where('perbaikan',array('id'=> $id))->result();
    }

    public function Exist_perbaikan($id){
        $query = $this->db->query("SELECT * FROM perbaikan WHERE id = '$id'");
        return $query->num_rows();
    }


    public function Update_perbaikan($id, $data = array())
    {
        $this->db->where('id', $id);
        return $this->db->update('perbaikan', $data);
    }

    public function change_status($id,$status,$jam) {
        $this->db->where('id', $id);
        return $this->db->update('perbaikan', array('status'=>$status, 'tanggal_selesai'=>$jam));
    }

    public function Get_all_notif(){
        return $this->db->query("SELECT * FROM notif_admin ORDER BY id DESC LIMIT 5")->result();;
    }
    public function Change_notif($id){
        $this->db->where('id', $id);
        return $this->db->update('notif_admin', array('status' => 2));
    }
    public function Get_notread_notif(){
      return  count($this->db->query("SELECT * FROM notif_admin where status=1 ORDER BY id DESC LIMIT 5")->result());
    }

public function Get_notfinish(){
    return $this->db->query("SELECT * FROM perbaikan where NOT status=3")->result();
}
public function Get_finish(){
    return $this->db->query("SELECT * FROM perbaikan where status=3")->result();
}

public function Get_finishtoday(){
    return $this->db->query("SELECT * FROM perbaikan where status=3")->result();
}

public function Get_all_perbaikan_today($date){
    return $this->db->query("SELECT * FROM perbaikan WHERE tanggal='$date'")->result();;
}
public function Get_all_sukses_today($date){
    return $this->db->query("SELECT * FROM perbaikan WHERE  status=3 AND tanggal='$date'")->result();;
}
public function Get_all_belum_today($date){
    return $this->db->query("SELECT * FROM perbaikan WHERE  tanggal='$date' AND NOT status=3")->result();;
}

public function Get_all_perbaikan_todayy($date){
    return $this->db->query("SELECT count(id) as jumlah, mesin FROM perbaikan WHERE  tanggal='$date' GROUP BY mesin")->result();;
}
}