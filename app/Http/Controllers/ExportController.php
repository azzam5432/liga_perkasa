<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportController extends Controller
{
    public function exportRanking()
    {
        // Ambil data ranking (diurutkan berdasarkan total nilai tertinggi)
        $rekapTim = Tim::with(['pesertas', 'dosenPembimbing', 'kakakPembimbing', 'nilai'])
            ->get()
            ->map(function($tim) {
                $totalNilai = $tim->nilai->sum('nilai');
                $jmlMenang = $tim->nilai->count();
                
                return [
                    'tim' => $tim,
                    'total_nilai' => $totalNilai,
                    'jml_menang' => $jmlMenang,
                ];
            })
            ->sortByDesc('total_nilai')
            ->values();

        // Buat Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Ranking Lomba');

        // ================= TAMPILAN UNTUK SETIAP TIM =================
        $currentRow = 1;

        foreach ($rekapTim as $index => $item) {
            $tim = $item['tim'];
            
            // 1. Judul Besar (Header Utama)
            $sheet->setCellValue('A' . $currentRow, 'RANKING LOMBA LIGA PERKASA');
            $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $currentRow++;

            // 2. Sub Judul (Peringkat Tim)
            $sheet->setCellValue('A' . $currentRow, 'Peringkat ' . ($index + 1) . ' - ' . $tim->nama_tim);
            $sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
            $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true)->setSize(12)->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1a365d');
            $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $currentRow++;

            // 3. Info Tim (Nama Tim, Ketua, Dosen, Mentor)
            // Ambil ketua dari peserta yang memiliki ketua_peserta = true
            $ketua = $tim->pesertas->where('ketua_peserta', true)->first();
            $namaKetua = $ketua ? $ketua->nama_peserta : '-';

            $infoData = [
                'Nama Tim' => $tim->nama_tim,
                'Ketua Tim' => $namaKetua,
                'Dosen Pembimbing' => $tim->dosenPembimbing->isNotEmpty() ? $tim->dosenPembimbing->pluck('nama_dosen')->implode(', ') : '-',
                'Kakak Mentor' => $tim->kakakPembimbing->isNotEmpty() ? $tim->kakakPembimbing->pluck('nama_kakak')->implode(', ') : '-',
            ];

            foreach ($infoData as $label => $value) {
                $sheet->setCellValue('A' . $currentRow, $label);
                $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
                $sheet->getStyle('A' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFf2f2f2');
                
                $sheet->setCellValue('B' . $currentRow, $value);
                $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
                $currentRow++;
            }

            $currentRow++; // Spasi kosong sebelum tabel

            // 4. Tabel Anggota
            $sheet->setCellValue('A' . $currentRow, 'No');
            $sheet->setCellValue('B' . $currentRow, 'Nama Lengkap');
            $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
            
            // Style Header Tabel
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFe2e8f0');
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $currentRow++;

            // Data Anggota (Jika ada)
            if ($tim->pesertas->isNotEmpty()) {
                $no = 1;
                foreach ($tim->pesertas as $peserta) {
                    $sheet->setCellValue('A' . $currentRow, $no);
                    $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    
                    $sheet->setCellValue('B' . $currentRow, $peserta->nama_peserta);
                    $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
                    
                    $currentRow++;
                    $no++;
                }
            } else {
                $sheet->setCellValue('A' . $currentRow, '-');
                $sheet->setCellValue('B' . $currentRow, 'Tidak ada anggota');
                $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
                $currentRow++;
            }

            $currentRow++; // Spasi kosong

            // 5. Total Nilai & Jumlah Menang
            $sheet->setCellValue('A' . $currentRow, 'Total Nilai');
            $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFfff3cd');

            $sheet->setCellValue('B' . $currentRow, number_format($item['total_nilai'], 1, ',', '.'));
            $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
            $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
            $currentRow++;

            $sheet->setCellValue('A' . $currentRow, 'Jumlah Menang');
            $sheet->getStyle('A' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFd1ecf1');

            $sheet->setCellValue('B' . $currentRow, $item['jml_menang']);
            $sheet->mergeCells('B' . $currentRow . ':F' . $currentRow);
            $sheet->getStyle('B' . $currentRow)->getFont()->setBold(true);
            $currentRow += 3; // Spasi kosong 3 baris sebelum tim berikutnya
        }

        // ================= STYLE GLOBAL =================
        // Border untuk semua sel yang terisi
        $lastRow = $currentRow - 1;
        $sheet->getStyle('A1:F' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Auto Size Kolom A dan B
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        foreach (range('C', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setWidth(10);
        }

        // Download
        $writer = new Xlsx($spreadsheet);
        $fileName = 'ranking-liga-perkasa.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}