<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Jadwal_model extends CI_Model
{


    public function Get_all_jadwal($data){

        return $this->db->query("SELECT * FROM jadwal WHERE nama_mesin = '$data'")->result();

    }

    Public function Insert_new_jadwal($data = array())
    
    {
        return $this->db->insert('jadwal',$data);
    }


    public function Delete_jadwal($id){

    $this->db->query("DELETE FROM jadwal WHERE id = '$id'");
    }


    public function Get_data_id($id){
        return $this->db->get_where('jadwal',array('id'=> $id))->result();
    }

    public function Exist_jadwal($id){
        $query = $this->db->query("SELECT * FROM jadwal WHERE id = '$id'");
        return $query->num_rows();
    }


    public function Update_jadwal($id, $data = array())
    {
        $this->db->where('id', $id);
        return $this->db->update('jadwal', $data);
    }

    public function change_status($id,$status,$jam) {
        
        $this->db->where('id', $id);
        return $this->db->update('jadwal', array('status'=>$status,'tanggal_selesai'=>$jam));
    }

}