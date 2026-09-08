<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class Element extends CI_Controller
{   

    private $reportTitle      = 'Kartimans Barbershop';
    private $reportAddress    = 'Karangkobar, Purwanegara, Purwokerto Timur, Banyumas Regency, Central Java 53116';
    private $ownerName        = 'Bagus Pamungkas';
    private $ownerSignature   = 'assets/img/ttd.png';
    private $logoPath         = 'assets/img/kartimans1.png';
    private $fontRegular      = 'assets/font/Intermedium.ttf';
    private $fontBold         = 'assets/font/Intersemibold.ttf'; // fallback to regular if missing

    // Canvas size (A4 landscape-ish in px). Increase for sharper PNGs.
    private $W = 2000;
    private $H = 1400;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Layanan');
        // load db if not already
        if (!isset($this->db)) { $this->load->database(); }
        // turn off notices for missing fonts in shared hosting
        error_reporting(E_ALL & ~E_NOTICE);
    }

    /**
     * Optional landing page (you can wire this to your dashboard)
     */
    public function monthly()
    {
        $month = $this->input->get('month');
        if (!$month) { $month = date('Y-m'); }
        $data = ['month' => $month];
        $this->load->view('reports/monthly', $data);
    }

    /**
     * Export Monthly PNG in the style of the provided mockup.
     * GET params:
     *   month=YYYY-MM   (defaults to current year-month)
     */
    public function export_monthly_png()
{
    // --- DB & bulan ---
    if (!isset($this->db)) { $this->load->database(); }
    $month     = $this->input->get('month') ?: date('Y-m');
    $bulanText = $this->_formatMonthIndo($month);

    // --- Ambil data (fallback contoh untuk tes) ---
    $rows = $this->_buildRowsFromDB($month);
    if (!$rows) {
        $rows = [
            ['tanggal'=> $month.'-01','layanan'=>'Cukur','harga'=>25000,'pendapatan'=>25000],
            ['tanggal'=> $month.'-03','layanan'=>'Cukur + Cuci','harga'=>35000,'pendapatan'=>35000],
            ['tanggal'=> $month.'-05','layanan'=>'Hair Color','harga'=>90000,'pendapatan'=>90000],
        ];
    }

    // --- Kanvas putih ---
    $im = imagecreatetruecolor($this->W, $this->H);
    imagealphablending($im, true);
    imagesavealpha($im, false);
    $white  = imagecolorallocate($im, 255,255,255);
    imagefilledrectangle($im, 0, 0, $this->W-1, $this->H-1, $white);

    // --- Warna & font ---
    $black  = imagecolorallocate($im, 20,20,20);
    $gray   = imagecolorallocate($im,110,110,110);
    $light  = imagecolorallocate($im,230,230,230);
    $border = imagecolorallocate($im, 60,60,60);

    $fontR = FCPATH.$this->fontRegular;
    $fontB = file_exists(FCPATH.$this->fontBold) ? FCPATH.$this->fontBold : $fontR;

    // --- Header atas ---
    $pad = 60; $y = $pad;

    // logo tengah
    $logoP = FCPATH.$this->logoPath;
    if (file_exists($logoP)) {
        $logo = imagecreatefrompng($logoP);
        imagealphablending($logo, true); imagesavealpha($logo, true);
        $logo = imagescale($logo, 100, 100);
        imagecopy($im, $logo, (int)($this->W/2-50), (int)$y, 0,0, imagesx($logo), imagesy($logo));
        imagedestroy($logo);
    }
    $y += 150;

    // judul, alamat, (Dalam Rp)
    $this->_ttfCenter($im, 25, $this->W/2, $y, $black, $fontB, $this->reportTitle); $y += 50;
    $this->_ttfCenter($im, 25, $this->W/2, $y, $gray,  $fontR, $this->reportAddress); $y += 40;
    $this->_ttfCenter($im, 25, $this->W/2, $y, $black, $fontB, '(Dalam Rp)');

    // ================= TABEL =================
    $y += 40;
    $left   = 100;
    $right  = $this->W - 100;
    $top    = $y + 20;
    $bottom = $this->H - 170;
    $rowH   = 70;

    $cols = [
        ['label'=>'No',           'w'=> 90],
        ['label'=>'Tanggal',      'w'=>220],
        ['label'=>'Nama layanan', 'w'=>520],
        ['label'=>'Harga',        'w'=>220],
        ['label'=>'Pendapatan',   'w'=> ($right-$left)-(90+220+520+220)],
    ];

    // teks "Bulan" diletakkan sedikit di atas tabel (kanan)
    $monthY = $top - 12;
    if ($monthY < 20) { $monthY = 20; }
    $this->_ttfRight($im, 25, $right - 14, $monthY, $black, $fontB, 'Bulan: '.$bulanText);

    // header bg + border luar
    imagefilledrectangle($im, $left, $top, $right, $top+60, imagecolorallocate($im, 252,252,252));
    imagesetthickness($im, 2);
    imagerectangle($im, $left, $top, $right, $bottom, $border);
    imagesetthickness($im, 1);

    // --- area baris "Jumlah" ---
    $SUM_ROW_H = 80;                     // tinggi baris jumlah (boleh 76–84)
    $jTop      = $bottom - $SUM_ROW_H;   // batas atas baris jumlah
    $sumLeft   = $cols[0]['w'] + $cols[1]['w'] + $cols[2]['w'] + $cols[3]['w'];

    // garis vertikal kolom:
    // 4 kolom kiri berhenti di jTop (agar tidak menabrak teks "Jumlah")
    $x = $left;
    for ($i=0; $i<count($cols); $i++) {
        $lineBottom = ($i < 4) ? $jTop : $bottom;   // kolom 0..3 stop di jTop
        imageline($im, $x, $top, $x, $lineBottom, $border);
        $x += $cols[$i]['w'];
    }
    // sisi kanan tabel penuh
    imageline($im, $right, $top, $right, $bottom, $border);
    // pemisah ke kolom terakhir dari jTop sampai bawah
    imageline($im, $left + $sumLeft, $jTop, $left + $sumLeft, $bottom, $border);

    // teks header kolom
    $x = $left; $headerY = $top + 40;
    foreach ($cols as $c) {
        $this->_ttf($im, 25, $x + 14, $headerY, $black, $fontB, $c['label']);
        $x += $c['w'];
    }
    // garis bawah header + garis atas baris "Jumlah"
    imageline($im, $left, $top + 60, $right, $top + 60, $border);
    imageline($im, $left, $jTop,      $right, $jTop,      $border);

    // ---------- rows ----------
    $y  = $top + 60;
    $no = 1; 
    $total = 0;

    foreach ($rows as $r) {
        $y += $rowH;
        $x = $left + 14;

        $this->_ttf($im,22,$x,$y-20,$black,$fontR,(string)$no);               $x += $cols[0]['w'];
        $this->_ttf($im,22,$x,$y-20,$black,$fontR,$r['tanggal']);             $x += $cols[1]['w'];
        $this->_ttf($im,22,$x,$y-20,$black,$fontR,$r['layanan']);             $x += $cols[2]['w'];
        $this->_ttfRight($im,22,$left+$sumLeft-14,$y-20,$black,$fontR,$this->_num($r['harga']));
        $this->_ttfRight($im,22,$right-14,$y-20,$black,$fontR,$this->_num($r['pendapatan']));

        // garis pemisah baris hanya jika masih di atas area "Jumlah"
        if ($y < $jTop) {
            imageline($im, $left, $y, $right, $y, $light);
        }

        $no++;
        $total += (float)$r['pendapatan'];

        if ($y > $jTop - 4) { break; }
    }

    // ---------- baris JUMLAH (anti nabrak) ----------
    // (garis bawah tabel sudah ada dari border luar)
    $padBottom = 18;                             // jarak aman dari garis bawah
    $sumY      = $jTop + $SUM_ROW_H - $padBottom;

    $this->_ttf($im,      24, $left + 14,  $sumY, $black, $fontB, 'Jumlah');
    $this->_ttfRight($im, 26, $right - 14, $sumY, $black, $fontB, $this->_num($total));

    // ---------- tanda tangan (nama di atas, ttd di bawah) ----------
    $nameFontSize  = 20;
    $gap           = 25;         // jarak dari tabel ke nama
    $namePadding   = 100;        // jarak nama -> gambar ttd
    $sigMaxW       = 220;
    $sigMaxH       = 100;
    $rightMargin   = 12;

    $nameBaseY = $bottom + $gap + $nameFontSize;
    $this->_ttfRight($im, $nameFontSize, $right - $rightMargin, $nameBaseY, $black, $fontB, $this->ownerName);

    $sigP = FCPATH.$this->ownerSignature;
    if (file_exists($sigP)) {
        $sig = imagecreatefrompng($sigP);
        imagealphablending($sig, true); imagesavealpha($sig, true);
        $sig = imagescale($sig, $sigMaxW, $sigMaxH);
        $sigTop  = $nameBaseY + $namePadding;
        if ($sigTop + $sigMaxH > $this->H - 15) { $sigTop = $this->H - 15 - $sigMaxH; }
        $sigLeft = $right - $rightMargin - $sigMaxW;
        imagecopy($im, $sig, $sigLeft, $sigTop, 0,0, imagesx($sig), imagesy($sig));
        imagedestroy($sig);
    }

    // --- output PNG ---
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="Laporan_Bulanan_'.str_replace('-','_',$month).'.png"');
    imagepng($im);
    imagedestroy($im);
    exit;

    // tanda tangan kanan bawah
    $tableBottom   = $this->H - 170; // batas bawah kotak tabel
$gap           = 25;             // jarak dari tabel ke nama
$nameFontSize  = 20;             // ukuran font nama
$namePadding   = 100;             // jarak antara nama dan gambar tanda tangan
$sigMaxW       = 220;            // lebar maksimum tanda tangan
$sigMaxH       = 100;            // tinggi maksimum tanda tangan
$rightMargin   = 12;             // margin kanan

// 1) Tulis NAMA (rata kanan), baseline = bawah tabel + gap + tinggi font
$nameBaseY = $tableBottom + $gap + $nameFontSize;
$this->_ttfRight($im, $nameFontSize, $right - $rightMargin, $nameBaseY, $black, $fontB, $this->ownerName);

// 2) Gambar tanda tangan DI BAWAH nama, tetap rata kanan
$sigP = FCPATH . $this->ownerSignature;
if (file_exists($sigP)) {
    $sig = imagecreatefrompng($sigP);
    imagealphablending($sig, true);
    imagesavealpha($sig, true);

    // scale ke batas max
    $sig = imagescale($sig, $sigMaxW, $sigMaxH);

    // posisikan: top-nya di bawah baseline nama + padding
    $sigTop = $nameBaseY + $namePadding;
    // jangan melewati kanvas
    if ($sigTop + $sigMaxH > $this->H - 15) {
        $sigTop = $this->H - 15 - $sigMaxH;
    }

    // rata kanan dengan margin
    $sigLeft = $right - $rightMargin - $sigMaxW;

    imagecopy($im, $sig, $sigLeft, $sigTop, 0, 0, imagesx($sig), imagesy($sig));
    imagedestroy($sig);
}

    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="Laporan_Bulanan_'.str_replace('-','_',$month).'.png"');
    imagepng($im); imagedestroy($im); exit;
}

// ===== helper untuk DB & teks =====
private function _buildRowsFromDB($ym)
{
    $rows = [];
    try {
        // Contoh 1: tabel transactions
        if ($this->db->table_exists('transactions')) {
            $q = $this->db->select('DATE(created_at) AS tanggal, service_name AS layanan, price AS harga, revenue AS pendapatan', false)
                          ->like('created_at', $ym, 'after')
                          ->order_by('created_at','ASC')
                          ->get('transactions');
            if ($q && $q->num_rows() > 0) $rows = $q->result_array();
        }
        // Contoh 2: order_items join services
        if (!$rows && $this->db->table_exists('order_items')) {
            $q = $this->db->query("
                SELECT DATE(oi.created_at) AS tanggal,
                       COALESCE(s.name, oi.service_name) AS layanan,
                       oi.price AS harga,
                       (oi.price * oi.qty) AS pendapatan
                FROM order_items oi
                LEFT JOIN services s ON s.id = oi.service_id
                WHERE DATE_FORMAT(oi.created_at, '%Y-%m') = ?
                ORDER BY oi.created_at ASC
            ", [$ym]);
            $rows = $q->result_array();
        }
    } catch (\Throwable $e) {}
    return $rows;
}
private function _num($n){ return number_format((float)$n, 0, ',', '.'); }
private function _formatMonthIndo($ym){
    $m=['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
    return ($m[substr($ym,5,2)]??substr($ym,5,2)).' '.substr($ym,0,4);
}
private function _ttf($im,$size,$x,$y,$color,$font,$text){
    if (file_exists($font)) imagettftext($im,$size,0,(int)$x,(int)$y,$color,$font,$text);
    else imagestring($im,5,(int)$x,(int)$y-18,$text,$color);
}
private function _ttfCenter($im,$size,$cx,$y,$color,$font,$text){
    if (file_exists($font)) { $b=imagettfbbox($size,0,$font,$text); $w=$b[2]-$b[0]; $x=(int)($cx-$w/2); imagettftext($im,$size,0,$x,(int)$y,$color,$font,$text);}
    else { $w=imagefontwidth(5)*strlen($text); $x=(int)($cx-$w/2); imagestring($im,5,$x,(int)$y-18,$text,$color); }
}
private function _ttfRight($im,$size,$rx,$y,$color,$font,$text){
    if (file_exists($font)) { $b=imagettfbbox($size,0,$font,$text); $w=$b[2]-$b[0]; $x=(int)($rx-$w); imagettftext($im,$size,0,$x,(int)$y,$color,$font,$text);}
    else { $w=imagefontwidth(5)*strlen($text); $x=(int)($rx-$w); imagestring($im,5,$x,(int)$y-18,$text,$color); }
}
    
    public function alert()
    {
        $data['title'] = 'Alerts';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/alert', $data);
        $this->load->view('_layout/footer');
    }

    public function button()
    {
        $data['title'] = 'Buttons';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/button', $data);
        $this->load->view('_layout/footer');
    }

    public function dropdown()
    {
        $data['title'] = 'Dropdowns';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/dropdown', $data);
        $this->load->view('_layout/footer');
    }

    public function modal()
    {
        $data['title'] = 'Modals';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/modal', $data);
        $this->load->view('_layout/footer');
    }

    public function popovers()
    {
        $data['title'] = 'Popovers';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/popovers', $data);
        $this->load->view('_layout/footer');
    }

    public function progressbar()
    {
        $data['title'] = 'Progress Bar';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/bootstrapui/progressbar', $data);
        $this->load->view('_layout/footer');
    }

    public function form()
    {
        $data['title'] = 'Form';
        $total = 0;
        date_default_timezone_set('Asia/Jakarta');
        $status = 'LANGSUNG';
        $data['tgl'] = date('Y-m-d');
        $data['kode'] = $this->getName(6);
        $data2 = array(
            'listdata' => $this->Layanan->view_harga(),
            'pending' => $this->Layanan->pendinge()
        );
        $test = $this->Layanan->view_harga();
        $data = array_merge($data, $data2);
        if($this->input->post('jenis'))
        {
            $count = count($_POST['jenis']);
            for($n=0; $n<$count; $n++){
                if($n==0)
                {
                    $checkbox = $_POST['jenis'][$n];
                    foreach ($test as $value) {
                        if($_POST['jenis'][$n]==$value->jenis){
                        $total += $value->data_harga;
                        }
                    }
                }
                else{
                $checkbox = $checkbox .','. $_POST['jenis'][$n];
                foreach ($test as $value) {
                    if($_POST['jenis'][$n]==$value->jenis){
                    $total += $value->data_harga;
                    }
                }
                }
                }
        }
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/form', $data);
            $this->load->view('_layout/footer');
        } else {
            $cek = array(
                'tanggal' => $this->input->post('tgl'),
                'kode' => $this->input->post('kode'),
                'nama' => $this->input->post('nama'),
                'jenis' => $checkbox,
                'status' => $status,
                'harga' => $total,
                'username'=> $this->input->post('username'),
            );
            $this->Layanan->insert_layanan($cek);
            $this->session->set_flashdata('success', 'Data Layanan Berhasil Ditambahkan!');
            redirect('element/simpletable');
        }

    }

    public function pesan()
    {
        $total = 0;
        date_default_timezone_set('Asia/Jakarta');
        $status = 'PESAN';
        $data['tgl'] = date('Y-m-d');
        $data['kode'] = $this->getName(6);
        $data2 = array(
            'listdata' => $this->Layanan->view_harga()
        );
        $test = $this->Layanan->view_harga();
        $data = array_merge($data, $data2);
        if($this->input->post('jenis'))
        {
            $count = count($_POST['jenis']);
            for($n=0; $n<$count; $n++){
                if($n==0)
                {
                    $checkbox = $_POST['jenis'][$n];
                    foreach ($test as $value) {
                        if($_POST['jenis'][$n]==$value->jenis){
                        $total += $value->data_harga;
                        }
                    }
                }
                else{
                $checkbox = $checkbox .','. $_POST['jenis'][$n];
                foreach ($test as $value) {
                    if($_POST['jenis'][$n]==$value->jenis){
                    $total += $value->data_harga;
                    }
                }
                }
                }
        }
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/pesan', $data);
            $this->load->view('_layout/footer');
        } else {
            $cek = array(
                'tanggal_pesan' => $this->input->post('tgl'),
                'kode' => $this->input->post('kode'),
                'nama' => $this->input->post('nama'),
                'waktu_booking' => $this->input->post('waktu'),
                'jenis' => $checkbox,
                'status' => $status,
                'harga' => $total,
                'username'=> $this->input->post('username'),
            );
            $this->Layanan->insert_layanan($cek);
            $this->session->set_flashdata('success', 'Pesanan berhasil dibuat.');
            redirect('dashboard');
        }

    }

    public function simpletable()
    {
        $data = array(
            'listdata' => $this->Layanan->view_layanan(),
            'title' => 'Data Transaksi',
        );

        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/simple-tables', $data);
        $this->load->view('_layout/footer');
        $this->load->view('_layout/foot');
    }

    public function databerhasil()
    {
        $data = array(
            'listdata' => $this->Layanan->view_berhasil(),
            'title' => 'Data Berhasil',
        );

        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/databerhasil', $data);
        $this->load->view('_layout/footer');
        $this->load->view('_layout/foot');
    }

    public function datacancel()
    {
        $data = array(
            'listdata' => $this->Layanan->view_cancel(),
            'title' => 'Data Cancel',
        );

        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/datacancel', $data);
        $this->load->view('_layout/footer');
        $this->load->view('_layout/foot');
    }

    public function datauser()
    {
        $data = array(
            'listdata' => $this->Layanan->select_user(),
            'title' => 'Data User',
        );

        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/datauser', $data);
        $this->load->view('_layout/footer');
        $this->load->view('_layout/foot');
    }

    public function dataharga()
    {
        $data = array(
            'listdata' => $this->Layanan->view_harga(),
            'title' => 'Data Harga',
        );

        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/dataharga', $data);
        $this->load->view('_layout/footer');
    }

    public function datatable()
    {
        $data['title'] = 'Data Table';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/table/data-tables', $data);
        $this->load->view('_layout/footer');
    }

    public function uicolors()
    {
        $data['title'] = 'UI Colors';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/ui-colors', $data);
        $this->load->view('_layout/footer');
    }

    public function register()
    {
        $data['title'] = 'Register';


        $this->load->view('_layout/auth-header', $data);
        $this->load->view('element/page/register', $data);
        $this->load->view('_layout/auth-footers', $data);
    }

    public function login()
    {
        $data['title'] = 'Login';


        $this->load->view('_layout/auth-header', $data);
        $this->load->view('element/page/login', $data);
        $this->load->view('_layout/auth-footers', $data);
    }

    public function blank()
    {
        $data['title'] = 'Blank';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/page/blank', $data);
        $this->load->view('_layout/footer');
    }

    public function error_page()
    {
        $data['title'] = '404 Page';


        $this->load->view('_layout/header', $data);
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/page/404', $data);
        $this->load->view('_layout/footer');
    }

    public function charts()
    {
        $data = array(
            'monthly_data' => $this->Layanan->get_monthly(),
            'title' => 'Laporan',
        );

        $this->load->view('_layout/header');
        $this->load->view('_layout/sidebar', $data);
        $this->load->view('_layout/topbar', $data);
        $this->load->view('element/charts', $data);
        $this->load->view('_layout/footer');
        //echo json_encode($data);
    }



    public function canceldata($id)
    {
        $cancel = 'CANCEL';
        $cek = array(
            'status' => $cancel,
        );
        $this->db->where('kode', $id);
        $this->db->update('jasa', $cek);
        $this->session->set_flashdata('success', 'Transaksi Berhasil Dicancel!');

        redirect('element/simpletable');
    }

    public function berhasildata($id)
    {
        $cancel = 'BERHASIL';
        $cek = array(
            'status' => $cancel,
            'tanggal' => date('Y-m-d'),
        );
        $this->db->where('kode', $id);
        $this->db->update('jasa', $cek);
        $this->session->set_flashdata('success', 'Transaksi Berhasil Dicancel!');

        redirect('element/simpletable');
    }

    public function hapususer($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('user');
        $this->session->set_flashdata('success', 'Data Berhasil Dihapus!');

        redirect('element/datauser');
    }

    function getName($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }

    public function detail_transaksi($id)
    {
            $data = array(
                'brg_masuk' => $this->Layanan->view_detail($id)
            );
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/detail', $data);
            $this->load->view('_layout/footer');
    }

    public function detail_user($id)
    {
            $data = array(
                'brg_masuk' => $this->Layanan->view_user($id)
            );
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/detailuser', $data);
            $this->load->view('_layout/footer');
    }
    
    public function edit_harga($id)
    {
        $this->form_validation->set_rules('harga', 'Harga', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'brg_masuk' => $this->Layanan->view_harganya($id)
            );
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/editharga', $data);
            $this->load->view('_layout/footer');
        } else {
            $data = array(
                'harga' => $this->input->post('label_harga'),
                'data_harga' => $this->input->post('harga'),
            );
            $this->db->where('id', $id);
            $this->db->update('harga', $data);
            $this->session->set_flashdata('success', 'Data Harga Berhasil Diperbarui!');
            redirect('element/dataharga');
        }
    }


    public function edit_user($id)
    {
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data = array(
                'brg_masuk' => $this->Layanan->view_user($id)
            );
            $this->load->view('_layout/header', $data);
            $this->load->view('_layout/sidebar', $data);
            $this->load->view('_layout/topbar', $data);
            $this->load->view('element/edituser', $data);
            $this->load->view('_layout/footer');
        } else {
            $data = array(
                'password' => $this->input->post('password'),
                'status' => $this->input->post('status'),
                'level_user' => $this->input->post('level'),
            );
            $this->db->where('id_user', $id);
            $this->db->update('user', $data);
            $this->session->set_flashdata('success', 'Data User Berhasil Diperbarui!');
            redirect('element/datauser');
        }
    }

    function januari() {
        $query = $this->db->query('SELECT SUM(harga) FROM jasa WHERE MONTH(tanggal) = 3 AND YEAR(tanggal) = 2024');
        return $query->result();
    }

    public function simpan()
    {
        // Tambah data harga dari modal "Tambah Data"
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama', 'Jenis Layanan', 'required|trim');
        $this->form_validation->set_rules('harga_hidden', 'Harga', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            return redirect('element/dataharga');
        }

        $nama  = $this->input->post('nama', TRUE);
        $nilai = (int)$this->input->post('harga_hidden');

        // label disamakan dulu dengan nama; bisa diedit di Edit Harga
        $label_str = $nama;
        $label_harga_str = 'Rp ' . number_format($nilai, 0, ',', '.');

        $data = array(
            'jenis'      => $nama,
            'label'      => $label_str,
            'harga'      => $label_harga_str,
            'data_harga' => $nilai,
        );

        $ok = $this->db->insert('harga', $data);

        if ($ok) {
            $this->session->set_flashdata('success', 'Data harga berhasil ditambahkan.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan data harga.');
        }
        return redirect('element/dataharga');
    }
    
    public function hapus_harga($id) {
    $id = (int)$id;
    $this->db->where('id', $id);
    $ok = $this->db->delete('harga');
    if ($ok) {
        $this->session->set_flashdata('success', 'Data harga berhasil dihapus.');
    } else {
        $this->session->set_flashdata('error', 'Gagal menghapus data harga.');
    }
    return redirect('element/dataharga');
}



}
