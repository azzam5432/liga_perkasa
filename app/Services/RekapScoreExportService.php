<?php

namespace App\Services;

use App\Models\Lomba;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapScoreExportService
{
    /**
     * Membuat objek Spreadsheet berisi rekap score Liga Perkasa.
     */
    public function generate(): Spreadsheet
    {
        $lombasRaw = Lomba::with(['nilai.tim'])->get();

        // Map data lomba
        $allLombas = $lombasRaw->map(function ($lomba) {
            $hasNilai = $lomba->nilai->isNotEmpty();
            $tgl = $hasNilai ? $lomba->nilai->min('created_at') : null;

            $j1 = $this->formatPemenang($lomba->nilai, 1);
            $j2 = $this->formatPemenang($lomba->nilai, 2);
            $j3 = $this->formatPemenang($lomba->nilai, 3);

            $statusPelaksanaan = 'Belum Dimulai';
            if ($hasNilai) {
                $statusPelaksanaan = 'Selesai';
            } elseif ($lomba->is_final_active) {
                $statusPelaksanaan = 'Sedang Dimulai';
            }

            return [
                'id_lomba' => $lomba->id_lomba,
                'nama_lomba' => $lomba->nama_lomba,
                'jenis' => ucfirst($lomba->jenis), // Langsung / Penyisihan
                'status_pelaksanaan' => $statusPelaksanaan,
                'tanggal_diumumkan' => $tgl,
                'juara_1' => $j1,
                'juara_2' => $j2,
                'juara_3' => $j3,
                'is_selesai' => $hasNilai,
            ];
        });

        // Urutkan dari lomba yang paling awal diumumkan terlebih dahulu
        // Lomba yang belum diumumkan ditaruh di urutan berikutnya
        $sortedLombas = $allLombas->sort(function ($a, $b) {
            if ($a['tanggal_diumumkan'] && $b['tanggal_diumumkan']) {
                return $a['tanggal_diumumkan']->timestamp <=> $b['tanggal_diumumkan']->timestamp;
            }
            if ($a['tanggal_diumumkan'] && !$b['tanggal_diumumkan']) {
                return -1;
            }
            if (!$a['tanggal_diumumkan'] && $b['tanggal_diumumkan']) {
                return 1;
            }
            return strcmp($a['nama_lomba'], $b['nama_lomba']);
        })->values();

        $completedLombas = $sortedLombas->where('is_selesai', true)->values();

        $spreadsheet = new Spreadsheet();

        // Sheet 1: Semua Lomba (diurutkan awal diumumkan)
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Rekap Semua Lomba');
        $this->buildSheet($sheet1, $sortedLombas, 'REKAPITULASI SKOR DAN STATUS LOMBA LIGA PERKASA', 'Seluruh 45 Lomba (Diurutkan dari yang Paling Awal Diumumkan)');

        // Sheet 2: Hanya Lomba yang Sudah Selesai / Diumumkan
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Lomba Sudah Selesai');
        $this->buildSheet($sheet2, $completedLombas, 'DAFTAR LOMBA YANG TELAH DIUMUMKAN', 'Lomba dengan Nilai & Pemenang Juara 1, 2, 3 (Diurutkan Kronologis Pengumuman)');

        // Set active sheet back to Sheet 1
        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    /**
     * Membangun tampilan tabel pada sheet yang ditentukan.
     */
    protected function buildSheet(Worksheet $sheet, $dataList, string $title, string $subtitle): void
    {
        $sheet->setShowGridlines(true);

        // 1. Header Judul Laporan
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF1E293B'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // 2. Subtitle & Tanggal Cetak
        $sheet->setCellValue('A2', $subtitle . ' • Per ' . $this->formatTanggalIndo(now()));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->getFont()->setSize(10)->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF64748B'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(2)->setRowHeight(18);

        $sheet->getRowDimension(3)->setRowHeight(10); // Spasi

        // 3. Tabel Header Baris 4 & 5
        // Baris 4
        $sheet->setCellValue('A4', 'No');
        $sheet->mergeCells('A4:A5');

        $sheet->setCellValue('B4', 'Lomba');
        $sheet->mergeCells('B4:B5');

        $sheet->setCellValue('C4', 'Pemenang');
        $sheet->mergeCells('C4:E4');

        $sheet->setCellValue('F4', "Status Lomba\n(Sistem)");
        $sheet->mergeCells('F4:F5');

        $sheet->setCellValue('G4', "Status Lomba\n(Pelaksanaan)");
        $sheet->mergeCells('G4:G5');

        $sheet->setCellValue('H4', 'Tanggal Diumumkan');
        $sheet->mergeCells('H4:H5');

        // Baris 5 (Sub-kolom Pemenang)
        $sheet->setCellValue('C5', '1 (Juara 1)');
        $sheet->setCellValue('D5', '2 (Juara 2)');
        $sheet->setCellValue('E5', '3 (Juara 3)');

        // Tinggi baris header
        $sheet->getRowDimension(4)->setRowHeight(24);
        $sheet->getRowDimension(5)->setRowHeight(24);

        // Styling Header Utama (A4:H5)
        $headerRange = 'A4:H5';
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle($headerRange)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        // Warna Background Header Umum (A4:B5, F4:H5)
        $sheet->getStyle('A4:B5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('A4:B5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));

        $sheet->getStyle('F4:H5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF1E3A8A');
        $sheet->getStyle('F4:H5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));

        // Pemenang Header (C4:E4)
        $sheet->getStyle('C4:E4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF0F172A');
        $sheet->getStyle('C4:E4')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));

        // Sub-kolom Juara:
        // Juara 1: Aksen Emas
        $sheet->getStyle('C5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEF08A');
        $sheet->getStyle('C5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF854D0E'));

        // Juara 2: Aksen Perak
        $sheet->getStyle('D5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE2E8F0');
        $sheet->getStyle('D5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF334155'));

        // Juara 3: Aksen Perunggu
        $sheet->getStyle('E5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFED7AA');
        $sheet->getStyle('E5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF9A3412'));

        // 4. Pengisian Data Rows
        $currentRow = 6;
        foreach ($dataList as $index => $item) {
            $isSelesai = $item['is_selesai'];

            // No
            $sheet->setCellValue('A' . $currentRow, $index + 1);
            $sheet->getStyle('A' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

            // Nama Lomba
            $sheet->setCellValue('B' . $currentRow, $item['nama_lomba']);
            $sheet->getStyle('B' . $currentRow)->getFont()->setBold($isSelesai);
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);

            // Juara 1
            $sheet->setCellValue('C' . $currentRow, $item['juara_1']);
            $sheet->getStyle('C' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
            if ($isSelesai && $item['juara_1'] !== '-') {
                $sheet->getStyle('C' . $currentRow)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF854D0E'));
                $sheet->getStyle('C' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEFCE8');
            } else {
                $sheet->getStyle('C' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
            }

            // Juara 2
            $sheet->setCellValue('D' . $currentRow, $item['juara_2']);
            $sheet->getStyle('D' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
            if ($isSelesai && $item['juara_2'] !== '-') {
                $sheet->getStyle('D' . $currentRow)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF334155'));
                $sheet->getStyle('D' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            } else {
                $sheet->getStyle('D' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
            }

            // Juara 3
            $sheet->setCellValue('E' . $currentRow, $item['juara_3']);
            $sheet->getStyle('E' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
            if ($isSelesai && $item['juara_3'] !== '-') {
                $sheet->getStyle('E' . $currentRow)->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF9A3412'));
                $sheet->getStyle('E' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF7ED');
            } else {
                $sheet->getStyle('E' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
            }

            // Status Sistem (Penyisihan / Langsung)
            $sheet->setCellValue('F' . $currentRow, $item['jenis']);
            $sheet->getStyle('F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

            // Status Pelaksanaan (Selesai / Belum Dimulai / Sedang Dimulai)
            $sheet->setCellValue('G' . $currentRow, $item['status_pelaksanaan']);
            $sheet->getStyle('G' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G' . $currentRow)->getFont()->setBold(true);

            if ($item['status_pelaksanaan'] === 'Selesai') {
                $sheet->getStyle('G' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCFCE7');
                $sheet->getStyle('G' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF15803D'));
            } elseif ($item['status_pelaksanaan'] === 'Sedang Dimulai') {
                $sheet->getStyle('G' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDBEAFE');
                $sheet->getStyle('G' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF1D4ED8'));
            } else {
                $sheet->getStyle('G' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');
                $sheet->getStyle('G' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF64748B'))->setBold(false);
            }

            // Tanggal Diumumkan
            $tglText = $this->formatTanggalIndo($item['tanggal_diumumkan']);
            $sheet->setCellValue('H' . $currentRow, $tglText);
            $sheet->getStyle('H' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
            if (!$isSelesai) {
                $sheet->getStyle('H' . $currentRow)->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF94A3B8'));
            }

            // Alternating Row background untuk baris yang belum selesai agar mudah dibaca
            if (!$isSelesai && ($index % 2 == 1)) {
                $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFAFAFA');
                $sheet->getStyle('F' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFAFAFA');
                $sheet->getStyle('H' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFAFAFA');
            }

            // Hitung tinggi baris dinamis agar nama tim / multi-line tidak terpotong
            $linesLomba = (int) ceil(mb_strlen($item['nama_lomba']) / 42);
            $linesJ1 = substr_count($item['juara_1'], "\n") + 1;
            $linesJ2 = substr_count($item['juara_2'], "\n") + 1;
            $linesJ3 = substr_count($item['juara_3'], "\n") + 1;
            $maxLines = max(1, $linesLomba, $linesJ1, $linesJ2, $linesJ3);

            $dynamicHeight = max(26, ($maxLines * 16) + 10);
            $sheet->getRowDimension($currentRow)->setRowHeight($dynamicHeight);
            $currentRow++;
        }

        $lastRow = $currentRow - 1;

        // 5. Border Tipis untuk Seluruh Sel Tabel
        $tableRange = 'A4:H' . $lastRow;
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');

        // Border Tebal di bawah Header
        $sheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM)->getColor()->setARGB('FF1E293B');

        // 6. Baris Ringkasan (Summary) di Bawah Tabel
        $summaryRow = $currentRow + 1;
        $totalLomba = $dataList->count();
        $totalSelesai = $dataList->where('is_selesai', true)->count();
        $totalBelum = $totalLomba - $totalSelesai;

        $sheet->setCellValue('B' . $summaryRow, "Ringkasan:");
        $sheet->setCellValue('C' . $summaryRow, "Total Lomba: {$totalLomba}");
        $sheet->setCellValue('D' . $summaryRow, "Selesai: {$totalSelesai}");
        $sheet->setCellValue('E' . $summaryRow, "Belum Dimulai: {$totalBelum}");

        $sheet->getStyle('B' . $summaryRow . ':E' . $summaryRow)->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('B' . $summaryRow . ':E' . $summaryRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');
        $sheet->getStyle('B' . $summaryRow . ':E' . $summaryRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FFCBD5E1');
        $sheet->getRowDimension($summaryRow)->setRowHeight(22);

        // 7. Pengaturan Lebar Kolom
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(48);
        $sheet->getColumnDimension('C')->setWidth(26);
        $sheet->getColumnDimension('D')->setWidth(26);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(22);
        $sheet->getColumnDimension('H')->setWidth(30);
    }

    /**
     * Format tanggal Indonesia.
     */
    protected function formatTanggalIndo($carbonDate): string
    {
        if (!$carbonDate) {
            return '-';
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $d = is_string($carbonDate) ? \Carbon\Carbon::parse($carbonDate) : $carbonDate;
        $rawStr = $d->format('Y-m-d H:i:s');
        $parts = explode(' ', $rawStr);
        $dateParts = explode('-', $parts[0]);
        $time = $parts[1] ?? '00:00:00';

        $day = (int)($dateParts[2] ?? 1);
        $monthNum = (int)($dateParts[1] ?? 1);
        $year = $dateParts[0] ?? date('Y');
        $bulan = $months[$monthNum] ?? '';

        return sprintf('%02d %s %s, %s WIB', $day, $bulan, $year, $time);
    }

    /**
     * Memformat teks nama tim pemenang per posisi juara (1, 2, atau 3).
     * Jika 1 kelompok meraih lebih dari 1 juara pada posisi tersebut (misal mengirim >1 perwakilan),
     * ditandai dengan (x2), (x3), dst.
     * Jika ada beberapa kelompok pada posisi yang sama, masing-masing ditaruh di baris baru (\n).
     */
    protected function formatPemenang($nilaiList, int $juara): string
    {
        $filtered = $nilaiList->where('juara', $juara);
        if ($filtered->isEmpty()) {
            return '-';
        }

        $formatted = [];
        foreach ($filtered as $n) {
            $namaTim = $n->tim?->nama_tim;
            if (!$namaTim) {
                continue;
            }

            $jumlah = (int) ($n->jumlah ?? 1);
            if ($jumlah > 1) {
                $formatted[] = "{$namaTim} (x{$jumlah})";
            } else {
                $formatted[] = $namaTim;
            }
        }

        return !empty($formatted) ? implode("\n", $formatted) : '-';
    }
}
