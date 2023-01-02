<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mesin_model extends CI_Model
{


    public function Get_all_mesin(){

        return $this->db->query('SELECT * FROM mesin')->result();

    }
    public function Get_all_namemesin(){

        return $this->db->query('SELECT nama_mesin FROM mesin')->result();

    }

    Public function Insert_new_mesin($data = array())
    
    {
        return $this->db->insert('mesin',$data);
    }


    public function Delete_mesin($id){

    $this->db->query("DELETE FROM mesin WHERE id = '$id'");
    }


    public function Get_data_id($id){
        return $this->db->get_where('mesin',array('id'=> $id))->result();
    }

    public function Exist_mesin($id){
        $query = $this->db->query("SELECT * FROM mesin WHERE id = '$id'");
        return $query->num_rows();
    }


    public function Update_mesin($id, $data = array())
    {
        $this->db->where('id', $id);
        return $this->db->update('mesin', $data);
    }

}