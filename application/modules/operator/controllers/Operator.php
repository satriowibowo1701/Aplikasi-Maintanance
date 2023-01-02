<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Operator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        verify_session('Operator');
        $this->load->library('Pdf');
        $this->load->model(array("Mesin_model" => "mesin", "Jadwal_model" => "jadwal", "Perbaikan_model" => "perbaikan"));
    }
    function index()
    {
        $mesin = get_user_mesin();
        $params["total"] = count($this->perbaikan->Get_all_perbaikan($mesin));
        $params["sukses"] = count($this->perbaikan->Get_all_sukses($mesin));
        $params["belum"] = count($this->perbaikan->Get_all_belum($mesin));
        $date = date("Y-m-d");
        $all = count($this->perbaikan->Get_all_perbaikan_today($mesin, $date));
        $sukses = count($this->perbaikan->Get_all_sukses_today($mesin, $date));
        $belum = count($this->perbaikan->Get_all_belum_today($mesin, $date));

        if ($sukses == 0 && $belum > 0) {
            $belum = '100';
        } else if ($belum == 0 && $sukses > 0) {
            $sukses = '100';
        } else if ($sukses > 0 && $belum > 0) {
            $sukses = ($sukses / $all) * 100;
            $belum = ($belum / $all) * 100;
        }
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $params['sukses_today'] = $sukses;
        $params['belum_today'] = $belum;
        $this->load->view('header', $header);
        $this->load->view('dasboard', $params);
        $this->load->view('footer');
    }

    /// Jadwal

    public function transaksi()
    {
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $params["jadwal"] = $this->jadwal->Get_all_jadwal(get_user_mesin());
        $this->load->view('header', $header);
        $this->load->view('jadwal', $params);
        $this->load->view('footer');
    }

    // Perbaikan

    public function perbaikan($id = null)
    {
        if ($id != null) {
            $this->perbaikan->Change_notif($id);
        }
        $params["perbaikan"] = $this->perbaikan->Get_all_perbaikan(get_user_mesin());
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $this->load->view('header', $header);
        $this->load->view('perbaikan', $params);
        $this->load->view('footer');
    }
    public function delete_perbaikan()
    {

        $id = $this->uri->segment(3);
        $this->perbaikan->Delete_perbaikan($id);
        $this->session->set_flashdata('sukses', 'User berhasil dihapus');
        redirect('operator/perbaikan');
    }

    public function form_edit_perbaikan()
    {
        $id = $this->uri->segment(3);

        if ($this->perbaikan->Exist_perbaikan($id)  < 1) {
            show_404();
            die;
        }
        $params["data"] = $this->perbaikan->Get_data_id($id);
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $this->load->view('header', $header);
        $this->load->view('editperbaikan', $params);
        $this->load->view('footer');
    }

    public function edit_perbaikan()
    {
        $id = $this->input->post('id');
        $id_perbaikan = $this->input->post('id_perbaikan');
        $tanggal = $this->input->post('tanggal');
        $mesin = get_user_mesin();
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
        redirect('operator/perbaikan');
    }

    public function form_tambah_perbaikan()
    {
        $count = count($this->perbaikan->Get_all_perbaikan_count());
        $params["kode"] = generate_kode("perbaikan", $count);
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $this->load->view('header', $header);
        $this->load->view('tambahperbaikan', $params);
        $this->load->view('footer');
    }
    public function tambah_perbaikan()
    {
        $id_perbaikan = $this->input->post('id_perbaikan');
        $tanggal = $this->input->post('tanggal');
        $mesin = get_user_mesin();
        $judul = $this->input->post('judul');
        $keterangan = $this->input->post('keterangan');
        $jenis = $this->input->post('jenis');
        $notif = [
            "id_perbaikan" => $id_perbaikan,
            "tipe" => $jenis,
            "tanggal" => $tanggal,
        ];
        $this->db->insert('notif_admin', $notif);
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
        redirect('operator/perbaikan');
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
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $this->load->view('header', $header);
        $this->load->view('cetakperbaikan');
        $this->load->view('footer');
    }

    public function cetak($mesin = null)
    {
        $first = $this->input->post('first');
        $end = $this->input->post('end');
        $mesin = get_user_mesin();
        error_reporting(0);
        $pdf = new Tcetak('L', 'mm', "A3");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'Laporan Perbaikan Mesin', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'Mesin : ' . $mesin, 0, 1, 'C');
        $pdf->SetAuthor("satrio");
        $pdf->SetFont('Arial', '', 13);
        $pdf->Cell(10, 7, 'Laporan Tanggal ' . $first . ' - ' . $end, 0, 1);
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
        $query = $this->db->query("SELECT * FROM perbaikan WHERE mesin='$mesin' AND tanggal BETWEEN '$first' AND '$end'");

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
        $pdf->Output('', 'laporan perbaikan tanggal ' . $first . ' s.d ' . $end . '.pdf');
    }


    public function cetakjadwal()
    {
        $mesn = get_user_mesin();
        $header['notif'] = $this->perbaikan->Get_all_notif($mesn);
        $header['notread'] = $this->perbaikan->Get_notread_notif($mesn);
        $this->load->view('header', $header);
        $this->load->view('cetakjadwal');
        $this->load->view('footer');
    }
    public function cetak_jadwal($mesin = null)
    {
        $first = $this->input->post('first');
        $end = $this->input->post('end');
        $mesin = get_user_mesin();
        error_reporting(0);
        $pdf = new Tcetak('L', 'mm', "A4");
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'Laporan Jadwal Mesin', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 7, 'Mesin : ' . $mesin, 0, 1, 'C');
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
        $query = $this->db->query("SELECT * FROM jadwal WHERE nama_mesin ='$mesin' AND tanggal BETWEEN '$first' AND '$end'");
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
        $pdf->Output('', 'laporan jadwal tanggal ' . $first . ' s.d ' . $end . '.pdf');
    }
}
