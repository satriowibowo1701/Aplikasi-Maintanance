<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Direktur extends CI_Controller
{

public function __construct(){
    parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        verify_session('Direktur');
        $this->load->library('Pdf');
        $this->load->model(array("Mesin_model" => "mesin", "Jadwal_model" => "jadwal" , "Perbaikan_model"=>"perbaikan"));
}


public function index() {
$this->load->view('header');
$this->load->view('dashboard');

$this->load->view('footer');
}

/// Jadwal

public function transaksi()
{
    $params["jadwal"] = $this->jadwal->Get_all_jadwal();
    $this->load->view('header');
    $this->load->view('jadwal',$params);
    $this->load->view('footer');
}

public function tambah_jadwalq() {

    $data = [];

    for($i=0; $i<10 ; $i++) {
        array_push($data, array(
            "id_perbaikan" => "m".$i,
            "tanggal" =>"2022-09-0".$i,
            "user" =>"ucup".$i,
            "mesin"=> "apa".$i,
            "judul" => "Oli".$i,
            "keterangan" => "2022-09-0".$i,
            "status" => ($i%2 !=0) ? 2:1
        ));
    }
    $this->db->insert_batch('perbaikan',$data);
}




// Perbaikan

public function perbaikan($id=null){
    if ($id != null){
$this->perbaikan->Change_notif($id);
    }
    $params["perbaikan"] = $this->perbaikan->Get_all_perbaikan();
    
    
    $this->load->view('header');
    $this->load->view('perbaikan' ,$params);
    $this->load->view('footer');
}





public function myCell($w,$h,$x,$t,$pdf){
    $height = $h/3;
    $first = $height+2;
    $second= ($height*3)+3;
    $len = strlen($t);
    if($len > 20){
        $txt = str_split($t, 20);
        for ($i = 0; $i < count($txt); $i++){
            if($i=0){
                $pdf->SetX($x);
                $pdf->Cell($w,$first,$txt[$i],'','','');
            }
            if($i > 0){
                $pdf->SetX($x);
                $pdf->Cell($w,$second,$txt[$i],'','','');
            }
        }
        $pdf->SetX($x);
        $pdf->Cell($w,$h,$t,'LTRB',0,'L',0);
    }else{
        $pdf->SetX($x);
        $pdf->Cell($w,$h,$t,'LTRB',0,'L',0);
    }


}

public function perbaikancetak(){
    
    
    $this->load->view('header');
    $this->load->view('cetakperbaikan');
    $this->load->view('footer');
}

public function cetak($mesin=null) {
    $first = $this->input->post('first');
    $end = $this->input->post('end');
    error_reporting(0);
    $pdf = new Tcetak('L', 'mm',"A3");
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,7,'Laporan Perbaikan Mesin',0,1,'C');
    if($mesin != null){
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,7,'Mesin : '.$mesin,0,1,'C');
    }
    $pdf->SetAuthor("satrio");
    if ($first){
    $pdf->SetFont('Arial','',13);
    $pdf->Cell(10,7,'Laporan Tanggal ' . $first. ' - '.$end ,0,1);
    }else{
        $pdf->Ln();
    }
    $pdf->SetFont('Courier','B',12);
    $pdf->Cell(10,6,'No',1,0,'C'); 
    $pdf->Cell(40,6,'ID Perbaikan',1,0,'C');
    $pdf->Cell(40,6,'Tanggal',1,0,'C');
    $pdf->Cell(40,6,'Nama Pembuat',1,0,'C');
    $pdf->Cell(40,6,'Nama Mesin',1,0,'C');
    $pdf->Cell(40,6,'Judul',1,0,'C');
    $pdf->Cell(75,6,'Keterangan',1,0,'C');
    $pdf->Cell(40,6,'Status',1,0,'C');
    $pdf->Cell(40,6,'Jenis Tindakan',1,0,'C');
    $pdf->Cell(40,6,'Tanggal Selesai',1,1,'C');
    $pdf->SetWidths(array(10,40,40,40,40,40,75,40,40,40));
    $pdf->SetLineHeight(5);
    $pdf->SetFont('Arial','',12);
    $pdf->SetAligns("C");
    if($mesin == null){
        $query= $this->db->query("SELECT * FROM perbaikan WHERE tanggal BETWEEN '$first' AND '$end'");
    }else{
        $query = $this->db->query("SELECT * FROM perbaikan WHERE mesin = '$mesin'");
    }
    $pegawai = $query->result();
    $no=1;
    foreach ($pegawai as $data){
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
    if($mesin == null){
        $pdf->Output('','laporan perbaikan tanggal '.$first .' s.d ' .$end .'.pdf');
    }else{
        $pdf->Output('','Kartu Riwayat Mesin '.$mesin  .'.pdf');
    }
}


public function cetakjadwal() {
    
        
        $this->load->view('header');
    $this->load->view('cetakjadwal');
    $this->load->view('footer');
}

public function cetak_jadwal($mesin=null) {
    $first = $this->input->post('first');
    $end = $this->input->post('end');
    error_reporting(0);
    $pdf = new Tcetak('L', 'mm',"A4");
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,7,'Laporan Jadwal Mesin',0,1,'C');
    if($mesin != null){
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,7,'Mesin : '.$mesin,0,1,'C');
    }
    $pdf->SetAuthor("satrio");
    if ($first){
    $pdf->SetFont('Arial','',13);
    $pdf->Cell(10,7,'Laporan Tanggal ' . $first. ' - '.$end ,0,1);
    }else{
        $pdf->Ln();
    }
    $pdf->SetFont('Courier','B',12);
    $pdf->Cell(10,6,'No',1,0,'C'); 
    $pdf->Cell(30,6,'ID Jadwal',1,0,'C');
    $pdf->Cell(30,6,'Tanggal',1,0,'C');
    $pdf->Cell(30,6,'Nama Mesin',1,0,'C');
    $pdf->Cell(40,6,'Point Check',1,0,'C');
    $pdf->Cell(40,6,'Tanggal Jadwal',1,0,'C');
    $pdf->Cell(30,6,'Status',1,0,'C');
    $pdf->Cell(40,6,'Tanggal Selesai',1,1,'C');
    $pdf->SetWidths(array(10,30,30,30,40,40,30,40));
    $pdf->SetLineHeight(5);
    $pdf->SetFont('Arial','',10);
    $pdf->SetAligns("C");
    if($mesin == null){
        $query= $this->db->query("SELECT * FROM jadwal WHERE tanggal BETWEEN '$first' AND '$end'");
    }else{
        $query = $this->db->query("SELECT * FROM jadwal WHERE nama_mesin = '$mesin'");
    }
    $pegawai = $query->result();
    $no=1;
    foreach ($pegawai as $data){
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
    if($mesin == null){
        $pdf->Output('','laporan jadwal tanggal '.$first .' s.d ' .$end .'.pdf');
    }else{
        $pdf->Output('','Kartu Riwayat Mesin '.$mesin  .'.pdf');
    }
}

public function cetakmesin(){
    $params["mesin"]= $this->mesin->Get_all_namemesin();    
    $this->load->view('header');
    $this->load->view('cetakmesin',$params);
    $this->load->view('footer');
}

public function cetak_mesin(){
    $mesin = $this->input->post('mesin');
    $opsi = $this->input->post('opsi');
    if ($opsi == 'Perbaikan'){
        $this->cetak($mesin);
    }else {
        $this->cetak_jadwal($mesin);
    }
}





}