<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends Controller {

    public function index() {
        $data['judul'] = 'Laporan Perkembangan';
        // Mengambil semua siswa untuk dropdown filter
        $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();

        $this->view('templates/header', $data);
        $this->view('laporan/index', $data);
        $this->view('templates/footer');
    }

    public function harian_pdf() {
        // Ambil data filter dari form POST
        $id_siswa = $_POST['id_siswa'];
        $kelompok = $_POST['kelompok'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        // Ambil data siswa dan data jurnal dari model
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id_siswa);
        $data['jurnal'] = $this->model('Penilaian_model')->getRekapHarian($id_siswa, $kelompok, $tgl_mulai, $tgl_selesai);
        $data['range'] = ['mulai' => $tgl_mulai, 'selesai' => $tgl_selesai];

        // Pengaturan Dompdf agar bisa membaca foto dari folder public
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Render View template ke dalam variabel HTML
        ob_start();
        $this->view('laporan/cetak_harian', $data);
        $html = ob_get_contents();
        ob_end_clean();

        // Proses pembuatan PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output file PDF ke browser
        $nama_file = 'Jurnal_Harian_' . str_replace(' ', '_', $data['siswa']['nama_lengkap']) . '.pdf';
        $dompdf->stream($nama_file, ['Attachment' => false]);
    }
}