<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model
{


    public function Get_all_user(){

        return $this->db->query('SELECT * FROM user')->result();

    }

    Public function Insert_new_user($data = array())
    
    {
        return $this->db->insert('user',$data);
    }


    public function Delete_user($id){

    $this->db->query("DELETE FROM user WHERE id = '$id'");
    }


    public function Get_data_id($id){
        return $this->db->get_where('user',array('id'=> $id))->result();
    }

    public function Exist_user($id){
        $query = $this->db->query("SELECT * FROM user WHERE id = '$id'");
        return $query->num_rows();
    }


    public function Update_user($id, $data = array())
    {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

}