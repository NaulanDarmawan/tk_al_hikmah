<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Laporan extends Controller {

    public function index() {
        $data['judul'] = 'Laporan Perkembangan';
        // Mengambil semua siswa untuk dropdown filter
        $data['siswa'] = $this->model('Siswa_model')->getAllSiswa();

        $this->view('templates/header', $data);
        $this->view('laporan/index', $data);
        $this->view('templates/footer');
    }

// ... (previous code)

    public function harian_pdf() {
        // Suppress warnings that break PDF output
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

        // Ambil data filter dari form POST
        $id_siswa = $_POST['id_siswa'];
        $kelompok = $_POST['kelompok'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        // Ambil data siswa dan data jurnal dari model
        $data['siswa'] = $this->model('Siswa_model')->getSiswaById($id_siswa);
        $data['jurnal'] = $this->model('Penilaian_model')->getRekapHarian($id_siswa, $kelompok, $tgl_mulai, $tgl_selesai);
        $data['range'] = ['mulai' => $tgl_mulai, 'selesai' => $tgl_selesai];

        // --- LOGIKA CHART (QuickChart) ---
        $mapNilai = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
        $chartData = [];
        
        foreach ($data['jurnal'] as $j) {
            $tgl = date('d-m-Y', strtotime($j['tanggal']));
            $score = $mapNilai[strtoupper($j['nilai'])] ?? 0;
            
            if (!isset($chartData[$tgl])) {
                $chartData[$tgl] = ['sum' => 0, 'count' => 0];
            }
            if ($score > 0) {
                $chartData[$tgl]['sum'] += $score;
                $chartData[$tgl]['count']++;
            }
        }

        // Sort Data by Date
        uksort($chartData, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        $labels = [];
        $values = [];
        foreach ($chartData as $tgl => $d) {
            $labels[] = $tgl;
            $values[] = ($d['count'] > 0) ? round($d['sum'] / $d['count'], 2) : 0;
        }

        // Generate QuickChart URL
        $qcConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Rata-rata Nilai Harian',
                    'data' => $values,
                    'borderColor' => 'rgb(54, 162, 235)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4
                ]]
            ],
            'options' => [
                'title' => [
                    'display' => true,
                    'text' => 'Grafik Perkembangan Harian'
                ],
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 4,
                            'stepSize' => 1
                        ]
                    ]]
                ]
            ]
        ];
        
        $data['chartUrl'] = 'https://quickchart.io/chart?c=' . urlencode(json_encode($qcConfig)) . '&w=600&h=300';

        // Pengaturan Dompdf agar bisa membaca foto dari folder public & URL luar
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

    public function harian_excel() {
        // 1. Ambil Data
        $id_siswa = $_POST['id_siswa'];
        $kelompok = $_POST['kelompok'];
        $tgl_mulai = $_POST['tgl_mulai'];
        $tgl_selesai = $_POST['tgl_selesai'];

        $siswa = $this->model('Siswa_model')->getSiswaById($id_siswa);
        $jurnal = $this->model('Penilaian_model')->getRekapHarian($id_siswa, $kelompok, $tgl_mulai, $tgl_selesai);

        // 2. Init Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data'); // Nama Sheet Simple

        // --- HEADER ---
        $sheet->setCellValue('A1', 'JURNAL HARIAN PERKEMBANGAN ANAK');
        $sheet->setCellValue('A2', 'Nama: ' . $siswa['nama_lengkap']);
        $sheet->setCellValue('A3', 'Periode: ' . $tgl_mulai . ' s/d ' . $tgl_selesai);
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);

        // --- TABLE DETAILS (Row 5+) ---
        $row = 5;
        $sheet->setCellValue('A'.$row, 'Tanggal');
        $sheet->setCellValue('B'.$row, 'Kategori');
        $sheet->setCellValue('C'.$row, 'Sub Elemen');
        $sheet->setCellValue('D'.$row, 'Deskripsi');
        $sheet->setCellValue('E'.$row, 'Nilai Text');
        $sheet->setCellValue('F'.$row, 'Nilai Angka');
        $sheet->setCellValue('G'.$row, 'Foto Kegiatan'); // Kolom Baru
        $sheet->getStyle("A$row:G$row")->getFont()->setBold(true);
        $sheet->getStyle("A$row:G$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFEEEEEE');

        // Mapping Nilai
        $mapNilai = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
        
        // Data Processing for Chart
        $chartData = []; // [Date => [sum, count]]
        
        $row++;
        foreach ($jurnal as $j) {
            $tgl = date('d-m-Y', strtotime($j['tanggal']));
            $nilaiC = strtoupper($j['nilai']);
            $score = $mapNilai[$nilaiC] ?? 0;

            // Isi Table
            $sheet->setCellValue('A'.$row, $tgl); 
            $sheet->setCellValue('B'.$row, $j['kategori']);
            $sheet->setCellValue('C'.$row, $j['sub_elemen']);
            $sheet->setCellValue('D'.$row, $j['deskripsi']);
            $sheet->setCellValue('E'.$row, $nilaiC);
            $sheet->setCellValue('F'.$row, $score); 
            
            // --- LOGIKA FOTO ---
            if (!empty($j['foto'])) {
                $pathFoto = dirname(__DIR__, 2) . '/public/img/penilaian/' . $j['foto'];
                
                if (file_exists($pathFoto)) {
                    $drawing = new Drawing();
                    $drawing->setName('Foto Kegiatan');
                    $drawing->setDescription($j['foto']);
                    $drawing->setPath($pathFoto);
                    $drawing->setHeight(60); // Tinggi 60px data cukup kecil
                    $drawing->setCoordinates('G' . $row);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setWorksheet($sheet);
                    
                    // Set Tinggi Baris agar foto muat
                    $sheet->getRowDimension($row)->setRowHeight(50);
                } else {
                    $sheet->setCellValue('G'.$row, '(File Tidak Ditemukan)');
                }
            } else {
                 $sheet->setCellValue('G'.$row, '-');
            }

            // Collect Chart Data
            if (!isset($chartData[$tgl])) {
                $chartData[$tgl] = ['sum' => 0, 'count' => 0];
            }
            if ($score > 0) {
                $chartData[$tgl]['sum'] += $score;
                $chartData[$tgl]['count']++;
            }

            $row++;
        }

        // Auto Size Columns A-F
        foreach (range('A','F') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);
        // Set lebar manual untuk kolom Foto (G)
        $sheet->getColumnDimension('G')->setWidth(15); 

        // --- CHART DATA PREPARATION (Saved in Hidden Columns usually, or side) ---
        // Let's put Summary Data at Column I, J (shifted by 1 because G is used)
        $chartRowStart = 5;
        $sheet->setCellValue('I'.$chartRowStart, 'Tanggal Summary');
        $sheet->setCellValue('J'.$chartRowStart, 'Rata-Rata Nilai');
        
        $currentRow = $chartRowStart + 1;
        $categories = []; // Dates
        $values = []; // Averages

        // Sort Data by Date
        uksort($chartData, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        
        $firstDataRow = $currentRow;
        foreach ($chartData as $tgl => $d) {
            $avg = ($d['count'] > 0) ? round($d['sum'] / $d['count'], 2) : 0;
            
            $sheet->setCellValueExplicit('I'.$currentRow, $tgl, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('J'.$currentRow, $avg);
            
            $categories[] = $tgl;
            $values[] = $avg;
            
            $currentRow++;
        }
        $lastDataRow = $currentRow - 1;

        if ($lastDataRow >= $firstDataRow) {
            // --- CREATE CHART ---
            // 1. Data Series Labels (Legend) -> "Rata-Rata Nilai" (Cell J5)
            $dataseriesLabels = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Data!$J$5', null, 1),
            ];
            
            // 2. X-Axis Categories (Dates) -> Column I
            $xAxisTickValues = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "Data!\$I\$$firstDataRow:\$I\$$lastDataRow", null, count($categories)),
            ];
            
            // 3. Y-Axis Values (Scores) -> Column J
            $dataSeriesValues = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "Data!\$J\$$firstDataRow:\$J\$$lastDataRow", null, count($values)),
            ];

            // Build Series
            $series = new DataSeries(
                DataSeries::TYPE_LINECHART, // Plot Type
                DataSeries::GROUPING_STANDARD, // Plot Grouping
                range(0, count($dataSeriesValues) - 1), // Plot Order
                $dataseriesLabels, // Labels
                $xAxisTickValues, // X categories
                $dataSeriesValues // Y values
            );

            // Set Plot Area
            $plotArea = new PlotArea(null, [$series]);
            
            // Set Legend
            $legend = new Legend(Legend::POSITION_BOTTOM, null, false);
            
            // Set Title
            $title = new Title('Grafik Perkembangan Harian (Rata-rata)');
            
            // Create Chart
            $chart = new Chart(
                'chart1', // name
                $title, // title
                $legend, // legend
                $plotArea, // plotArea
                true, // plotVisibleOnly
                0, // displayBlanksAs
                null, // xAxisLabel
                null // yAxisLabel
            );

            // Set Chart Position in Sheet (e.g., next to table)
            // Geser sedikit ke kanan karena kolom G sekarang ada foto
            $chart->setTopLeftPosition('L5');
            $chart->setBottomRightPosition('T20');

            // Add Chart to Worksheet
            $sheet->addChart($chart);
        }

        // --- OUTPUT ---
        $filename = 'Jurnal_Grafik_' . str_replace(' ', '_', $siswa['nama_lengkap']) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true); // PENTING!
        $writer->save('php://output');
        exit;
    }
}