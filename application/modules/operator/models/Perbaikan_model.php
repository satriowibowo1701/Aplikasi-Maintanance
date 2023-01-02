<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Perbaikan_model extends CI_Model
{


    public function Get_all_perbaikan($data)
    {

        return $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$data'")->result();
    }

    public function Get_all_perbaikan_count()
    {

        return $this->db->query("SELECT * FROM perbaikan")->result();
    }



    public function Get_all_sukses($data)
    {
        return $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$data' AND status = 3 ")->result();;
    }
    public function Get_all_belum($data)
    {
        return $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$data' AND NOT status=3")->result();;
    }

    public function Get_all_perbaikan_today($data, $date)
    {
        return $this->db->query("SELECT * FROM perbaikan WHERE mesin='$data' AND tanggal='$date'")->result();;
    }


    public function Get_all_sukses_today($data, $date)
    {
        return $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$data' AND status=3 AND tanggal='$date'")->result();;
    }
    public function Get_all_belum_today($data, $date)
    {
        return $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$data' AND tanggal='$date' AND NOT status=3")->result();;
    }

    public function Get_all_notif($mesin)
    {
        return $this->db->query("SELECT * FROM notif_operator WHERE nama_mesin='$mesin' ORDER BY id DESC LIMIT 5")->result();;
    }
    public function Change_notif($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('notif_operator', array('status' => 2));
    }
    public function Get_notread_notif($mesin)
    {
        return  count($this->db->query("SELECT * FROM notif_operator where status=1 AND nama_mesin= '$mesin' ORDER BY id DESC LIMIT 5")->result());
    }

    public function Insert_new_perbaikan($data = array())

    {
        return $this->db->insert('perbaikan', $data);
    }


    public function Delete_perbaikan($id)
    {

        $this->db->query("DELETE FROM perbaikan WHERE id = '$id'");
    }


    public function Get_data_id($id)
    {
        return $this->db->get_where('perbaikan', array('id' => $id))->result();
    }

    public function Exist_perbaikan($id)
    {
        $query = $this->db->query("SELECT * FROM perbaikan WHERE id = '$id'");
        return $query->num_rows();
    }


    public function Update_perbaikan($id, $data = array())
    {
        $this->db->where('id', $id);
        return $this->db->update('perbaikan', $data);
    }

    public function change_status($id, $status, $jam)
    {
        $this->db->where('id', $id);
        return $this->db->update('perbaikan', array('status' => $status, 'tanggal_selesai' => $jam));
    }
}
