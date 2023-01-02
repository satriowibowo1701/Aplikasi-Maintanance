<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        verify_session('Admin');
        $this->load->library('Pdf');
        $this->load->model(array("User_model" => "user", "Mesin_model" => "mesin", "Jadwal_model" => "jadwal", "Perbaikan_model" => "perbaikan"));
    }
    public function index()
    {

        $finish = count($this->perbaikan->Get_finish());
        $notfinish = count($this->perbaikan->Get_notfinish());
        $total_perbaikan = count($this->perbaikan->Get_all_perbaikan());
        $total_jadwal = count($this->jadwal->Get_all_jadwal());
        $date = date("Y-m-d");
        $total_perbaikan_today = $this->perbaikan->Get_all_perbaikan_todayy($date);
        $total_perbaikan_today_count = count($this->perbaikan->Get_all_perbaikan_today($date));
        $total_perbaikan_sukses_count = count($this->perbaikan->Get_all_sukses_today($date));
        $total_perbaikan_belum_count = count($this->perbaikan->Get_all_belum_today($date));
        if ($total_perbaikan_sukses_count == 0 && $total_perbaikan_belum_count > 0) {
            $total_perbaikan_belum_count = '100';
        } else if ($total_perbaikan_belum_count == 0 && $total_perbaikan_sukses_count > 0) {
            $total_perbaikan_sukses_count = '100';
        } else if ($total_perbaikan_sukses_count > 0 && $total_perbaikan_belum_count > 0) {
            $total_perbaikan_sukses_count = ($total_perbaikan_sukses_count / $total_perbaikan_today_count) * 100;
            $total_perbaikan_belum_count = ($total_perbaikan_belum_count / $total_perbaikan_today_count) * 100;
        }

        $warna = ["red", "green", "yellow", "white", "black", "blue", "cyan", "brown", "chartreuse", "purple", "Crimson", "#8B008B"];

        $newwarna = [];
        for ($i = 0; $i < count($total_perbaikan_today); $i++) {
            array_push($newwarna, $warna[$i]);
        }



        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();

        $params["finish"] = $finish;
        $params["notfinish"] = $notfinish;
        $params["perbaikan"] = $total_perbaikan;
        $params["jadwal"] = $total_jadwal;
        $params["warna"] =  $newwarna;
        $params["perbaikan_today"] = $total_perbaikan_today;
        $params["perbaikan_belum"] = $total_perbaikan_belum_count;
        $params["perbaikan_sukses"] = $total_perbaikan_sukses_count;
        $this->load->view('header', $header);
        $this->load->view('overview', $params);
        $this->load->view('footer');
    }

    public function user()
    {
        $params["user"] = $this->user->Get_all_user();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('user', $params);
        $this->load->view('footer');
    }

    public function form_tambah()
    {
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $params["mesin"] = $this->mesin->Get_all_mesin();
        $this->load->view('header', $header);
        $this->load->view('tambahuser', $params);
        $this->load->view('footer');
    }
    public function delete()
    {

        $id = $this->uri->segment(3);
        $this->user->Delete_user($id);
        $this->session->set_flashdata('sukses', 'User berhasil dihapus');
        redirect('admin/user');
    }


    public function tambah_user()
    {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $role = $this->input->post('role');

        $data = array(
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        );
        if ($role == "") {
            $this->session->set_flashdata('warning', 'Role Belum Dipilih');
            redirect('admin/user');
        }
        if ($this->user->Insert_new_user($data)) {
            $this->session->set_flashdata('sukses', 'Data telah ditambahkan');
            redirect('admin/user');
        }
    }

    public function form_edit_user()
    {
        $id = $this->uri->segment(3);
        if ($this->user->Exist_user($id)  < 1) {
            show_404();
            die;
        }
        $params["mesin"] = $this->mesin->Get_all_mesin();
        $params["data"] = $this->user->Get_data_id($id);
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('edituser', $params);
        $this->load->view('footer');
    }

    public function edit_user()
    {
        $id = $this->input->post('id');

        $old_data = $this->user->Get_data_id($id);
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = ($this->input->post('password') != '') ? password_hash($this->input->post('password'), PASSWORD_BCRYPT) : $old_data[0]->password;
        $role = $this->input->post('role');
        $data = array(
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        );

        if ($this->user->Update_user($id, $data)) {
            $this->session->set_flashdata('sukses', 'Data telah berhasil diupdate');
            redirect('admin/user');
        }
    }

    ///Mesin 

    public function mesin()
    {

        $params["mesin"] = $this->mesin->Get_all_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('mesin', $params);
        $this->load->view('footer');
    }


    public function form_tambah_mesin()
    {
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('tambahmesin');
        $this->load->view('footer');
    }


    public function delete_mesin()
    {

        $id = $this->uri->segment(3);
        $this->mesin->Delete_mesin($id);
        $this->session->set_flashdata('sukses', 'Mesin berhasil dihapus');
        redirect('admin/mesin');
    }


    public function tambah_mesin()
    {
        $nama = $this->input->post('nama');
        $merk = $this->input->post('merk');
        $idmesin = $this->input->post('id_mesin');
        $buat = $this->input->post('tanggal_buat');
        $periode = $this->input->post('tanggal_pakai');

        $data = array(
            'id_mesin' => $idmesin,
            'nama_mesin' => $nama,
            'merk_mesin' => $merk,
            'tahun_pembuatan' => $buat,
            'tahun_pakai' => $periode,
        );
        if ($this->mesin->Insert_new_mesin($data)) {
            $this->session->set_flashdata('sukses', 'Data telah ditambahkan');
            redirect('admin/mesin');
        }
    }

    public function form_edit_mesin()
    {
        $id = $this->uri->segment(3);
        if ($this->mesin->Exist_mesin($id) < 1) {
            show_404();
            die;
        }
        $params["data"] = $this->mesin->Get_data_id($id);
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('editmesin', $params);
        $this->load->view('footer');
    }

    public function edit_mesin()
    {
        $id = $this->input->post('id');

        $nama = $this->input->post('nama');
        $merk = $this->input->post('merk');
        $idmesin = $this->input->post('id_mesin');
        $buat = $this->input->post('tanggal_buat');
        $periode = $this->input->post('tanggal_pakai');

        $data = array(
            'id_mesin' => $idmesin,
            'nama_mesin' => $nama,
            'merk_mesin' => $merk,
            'tahun_pembuatan' => $buat,
            'tahun_pakai' => $periode,
        );

        if ($this->mesin->Update_mesin($id, $data)) {
            $this->session->set_flashdata('sukses', 'Data telah berhasil diupdate');
            redirect('admin/mesin');
        }
    }


    /// Jadwal

    public function transaksi()
    {
        $params["jadwal"] = $this->jadwal->Get_all_jadwal();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('jadwal', $params);
        $this->load->view('footer');
    }

    public function tambah_jadwalq()
    {

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            array_push($data, array(
                "id_perbaikan" => "m" . $i,
                "tanggal" => "2022-09-0" . $i,
                "user" => "ucup" . $i,
                "mesin" => "apa" . $i,
                "judul" => "Oli" . $i,
                "keterangan" => "2022-09-0" . $i,
                "status" => ($i % 2 != 0) ? 2 : 1
            ));
        }
        $this->db->insert_batch('perbaikan', $data);
    }

    public function change_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $jam = date("Y-m-d H:i:s");
        $mesin = $this->input->post('mesin');

        $this->jadwal->change_status($id, $status, $jam);
        return status($status, $id, $mesin);
    }

    public function form_tambah_jadwal()
    {
        $params['mesin'] = $this->mesin->Get_all_mesin();
        $count = count($this->jadwal->Get_all_jadwal());
        $params["kode"] = generate_kode("jadwal", $count);
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('tambahjadwal', $params);
        $this->load->view('footer');
    }

    public function tambah_jadwal()
    {
        $id = $this->input->post('id_jadwal');
        $tanggal = $this->input->post('tanggal');
        $mesin =  $this->input->post('mesin');
        $point = $this->input->post('point');
        $jadwal = $this->input->post('tanggal_jadwal');
        $data = array(
            'id_jadwal' => $id,
            'tanggal' => $tanggal,
            'nama_mesin' => $mesin,
            'point_check' => $point,
            'tanggal_jadwal' => $jadwal,
            'status' => 1
        );
        $this->jadwal->Insert_new_jadwal($data);
        $this->session->set_flashdata('sukses', 'Berhasil Menambahkan Jadwal Maintenance');
        redirect('admin/transaksi');
    }

    // Perbaikan

    public function perbaikan($id = null)
    {
        if ($id != null) {
            $this->perbaikan->Change_notif($id);
        }
        $params["perbaikan"] = $this->perbaikan->Get_all_perbaikan();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('perbaikan', $params);
        $this->load->view('footer');
    }


    public function change_status_perbaikan()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $mesin = $this->input->post('mesin');
        $jam = date("Y-m-d H:i:s");
        $perbaikan = $this->perbaikan->Get_data_id($id);

        $data = [
            "id_perbaikan" => $perbaikan[0]->id_perbaikan,
            "selesai" => $jam,
            "nama_mesin" => $mesin,
        ];
        if ($status == 3) {
            $this->db->insert('notif_operator', $data);
        }
        $this->perbaikan->change_status($id, $status, $jam);

        return status($status, $id, $mesin);
    }

    public function delete_perbaikan()
    {

        $id = $this->uri->segment(3);
        $this->perbaikan->Delete_perbaikan($id);
        $this->session->set_flashdata('sukses', 'User berhasil dihapus');
        redirect('admin/perbaikan');
    }

    public function form_edit_perbaikan()
    {
        $id = $this->uri->segment(3);

        if ($this->perbaikan->Exist_perbaikan($id)  < 1) {
            show_404();
            die;
        }
        $params["data"] = $this->perbaikan->Get_data_id($id);
        $params["mesin"] = $this->mesin->Get_all_namemesin();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('editperbaikan', $params);
        $this->load->view('footer');
    }

    public function edit_perbaikan()
    {
        $id = $this->input->post('id');
        $id_perbaikan = $this->input->post('id_perbaikan');
        $tanggal = $this->input->post('tanggal');
        $mesin = $this->input->post('mesin');
        $judul = $this->input->post('judul');
        $keterangan = $this->input->post('keterangan');
        $jenis = $this->input->post('jenis');
        $data = array(
            "id_perbaikan" => $id_perbaikan,
            "tanggal" => $tanggal,
            "mesin" => $mesin,
            "judul" => $judul,
            "keterangan" => $keterangan,
            "tindakan" => $jenis,
        );
        $this->perbaikan->Update_perbaikan($id, $data);
        $this->session->set_flashdata('sukses', 'Data Perbaikan Telah Berhasil Diupdate');
        redirect('admin/perbaikan');
    }

    public function form_tambah_perbaikan()
    {
        $params["mesin"] = $this->mesin->Get_all_namemesin();
        $count = count($this->perbaikan->Get_all_perbaikan());
        $params["kode"] = generate_kode("jadwal", $count);
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('tambahperbaikan', $params);
        $this->load->view('footer');
    }
    public function tambah_perbaikan()
    {
        $id_perbaikan = $this->input->post('id_perbaikan');
        $tanggal = $this->input->post('tanggal');
        $mesin = $this->input->post('mesin');
        $judul = $this->input->post('judul');
        $keterangan = $this->input->post('keterangan');
        $jenis = $this->input->post('jenis');
        $data = array(
            "id_perbaikan" => $id_perbaikan,
            "tanggal" => $tanggal,
            "mesin" => $mesin,
            "judul" => $judul,
            "keterangan" => $keterangan,
            "user" => get_user_name(),
            "status" => 1,
            "tindakan" => $jenis,
        );
        $this->perbaikan->Insert_new_perbaikan($data);
        $this->session->set_flashdata('sukses', 'Data Perbaikan Telah Berhasil Ditambahkan');
        redirect('admin/perbaikan');
    }

    public function myCell($w, $h, $x, $t, $pdf)
    {
        $height = $h / 3;
        $first = $height + 2;
        $second = ($height * 3) + 3;
        $len = strlen($t);
        if ($len > 20) {
            $txt = str_split($t, 20);
            for ($i = 0; $i < count($txt); $i++) {
                if ($i = 0) {
                    $pdf->SetX($x);
                    $pdf->Cell($w, $first, $txt[$i], '', '', '');
                }
                if ($i > 0) {
                    $pdf->SetX($x);
                    $pdf->Cell($w, $second, $txt[$i], '', '', '');
                }
            }
            $pdf->SetX($x);
            $pdf->Cell($w, $h, $t, 'LTRB', 0, 'L', 0);
        } else {
            $pdf->SetX($x);
            $pdf->Cell($w, $h, $t, 'LTRB', 0, 'L', 0);
        }
    }

    public function perbaikancetak()
    {
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('cetakperbaikan');
        $this->load->view('footer');
    }

    public function cetak($mesin = null)
    {
        $first = $this->input->post('first');
        $end = $this->input->post('end');
        error_reporting(0);
        $pdf = new Tcetak('L', 'mm', "A3");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'Laporan Perbaikan Mesin', 0, 1, 'C');
        if ($mesin != null) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 7, 'Mesin : ' . $mesin, 0, 1, 'C');
        }
        $pdf->SetAuthor("satrio");
        if ($first) {
            $pdf->SetFont('Arial', '', 13);
            $pdf->Cell(10, 7, 'Laporan Tanggal ' . $first . ' - ' . $end, 0, 1);
        } else {
            $pdf->Ln();
        }
        $pdf->SetFont('Courier', 'B', 12);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(40, 6, 'ID Perbaikan', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Pembuat', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Nama Mesin', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Judul', 1, 0, 'C');
        $pdf->Cell(75, 6, 'Keterangan', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Status', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Jenis Tindakan', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal Selesai', 1, 1, 'C');
        $pdf->SetWidths(array(10, 40, 40, 40, 40, 40, 75, 40, 40, 40));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetAligns("C");
        if ($mesin == null) {
            $query = $this->db->query("SELECT * FROM perbaikan WHERE tanggal BETWEEN '$first' AND '$end'");
        } else {
            $query = $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$mesin'");
        }
        $pegawai = $query->result();
        $no = 1;
        foreach ($pegawai as $data) {
            $pdf->Row(array(
                $no++,
                $data->id_perbaikan,
                $data->tanggal,
                $data->user,
                $data->mesin,
                $data->judul,
                $data->keterangan,
                status_mt($data->status),
                $data->tindakan,
                status_selesai($data->tanggal_selesai),
            ));
        }
        if ($mesin == null) {
            $pdf->Output('', 'laporan perbaikan tanggal ' . $first . ' s.d ' . $end . '.pdf');
        } else {
            $pdf->Output('', 'Kartu Riwayat Mesin ' . $mesin  . '.pdf');
        }
    }


    public function cetakjadwal()
    {
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('cetakjadwal');
        $this->load->view('footer');
    }

    public function cetak_jadwal($mesin = null)
    {
        $first = $this->input->post('first');
        $end = $this->input->post('end');
        error_reporting(0);
        $pdf = new Tcetak('L', 'mm', "A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'Laporan Jadwal Mesin', 0, 1, 'C');
        if ($mesin != null) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 7, 'Mesin : ' . $mesin, 0, 1, 'C');
        }
        $pdf->SetAuthor("satrio");
        if ($first) {
            $pdf->SetFont('Arial', '', 13);
            $pdf->Cell(10, 7, 'Laporan Tanggal ' . $first . ' - ' . $end, 0, 1);
        } else {
            $pdf->Ln();
        }
        $pdf->SetFont('Courier', 'B', 12);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(30, 6, 'ID Jadwal', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Nama Mesin', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Point Check', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal Jadwal', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Status', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Tanggal Selesai', 1, 1, 'C');
        $pdf->SetWidths(array(10, 30, 30, 30, 40, 40, 30, 40));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetAligns("C");
        if ($mesin == null) {
            $query = $this->db->query("SELECT * FROM jadwal WHERE tanggal BETWEEN '$first' AND '$end'");
        } else {
            $query = $this->db->query("SELECT * FROM jadwal WHERE nama_mesin = '$mesin'");
        }
        $pegawai = $query->result();
        $no = 1;
        foreach ($pegawai as $data) {
            $pdf->Row(array(
                $no++,
                $data->id_jadwal,
                $data->tanggal,
                $data->nama_mesin,
                $data->point_check,
                $data->tanggal_jadwal,
                status_mt($data->status),
                status_selesai($data->tanggal_selesai),
            ));
        }
        if ($mesin == null) {
            $pdf->Output('', 'laporan jadwal tanggal ' . $first . ' s.d ' . $end . '.pdf');
        } else {
            $pdf->Output('', 'Kartu Riwayat Mesin ' . $mesin  . '.pdf');
        }
    }

    public function cetakmesin()
    {
        $params["mesin"] = $this->mesin->Get_all_namemesin();
        $header['notif'] = $this->perbaikan->Get_all_notif();
        $header['notread'] = $this->perbaikan->Get_notread_notif();
        $this->load->view('header', $header);
        $this->load->view('cetakmesin', $params);
        $this->load->view('footer');
    }

    public function cetak_mesin()
    {
        $mesin = $this->input->post('mesin');
        $opsi = $this->input->post('opsi');
        if ($opsi == 'Perbaikan') {
            $this->cetak($mesin);
        } else {
            $this->cetak_jadwal($mesin);
        }
    }
}
