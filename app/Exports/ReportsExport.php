<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Report::select(
            'id',
            'nama_pelapor',
            'departemen',
            'jenis_masalah',
            'deskripsi',
            'status',
            'tanggal_laporan',
            'tanggal_selesai',
            'catatan_teknisi',
            'foto'
        )->get()->map(function ($item) {

            // Jika ada foto → ubah menjadi URL lengkap
            $item->foto = $item->foto 
                ? asset('uploads/laporan/' . $item->foto)
                : '-';

            return $item;
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelapor',
            'Departemen',
            'Jenis Masalah',
            'Deskripsi',
            'Status',
            'Tanggal Laporan',
            'Tanggal Selesai',
            'Catatan Teknisi',
            'Foto (URL)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Bold header
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        // Border semua cell
        $sheet->getStyle('A1:J' . $sheet->getHighestRow())
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Wrap untuk kolom panjang
        $sheet->getStyle('D:J')->getAlignment()->setWrapText(true);

        return [];
    }
}
