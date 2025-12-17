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
    protected $from, $to, $status, $search;

    public function __construct($from, $to, $status, $search)
    {
        $this->from   = $from;
        $this->to     = $to;
        $this->status = $status;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Report::query();

        // Filter tanggal
        if ($this->from && $this->to) {
            $query->whereBetween('tanggal_laporan', [$this->from, $this->to]);
        }

        // Filter status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filter search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_pelapor', 'like', "%{$this->search}%")
                  ->orWhere('departemen', 'like', "%{$this->search}%")
                  ->orWhere('jenis_masalah', 'like', "%{$this->search}%")
                  ->orWhere('deskripsi', 'like', "%{$this->search}%");
            });
        }

        return $query->select(
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
            )
            ->get()
            ->map(function ($item) {

                // Convert foto → URL supaya bisa diklik
                $item->foto = $item->foto
                    ? asset('uploads/laporan/' . $item->foto)
                    : '-';

                return $item;
            });
    }

    // ========================
    //      HEADER EXCEL
    // ========================
    public function headings(): array
    {
        // Tentukan periode berdasarkan filter
        $periode = "Semua Data";
        if ($this->from && $this->to) {
            $periode = "Periode: {$this->from} s/d {$this->to}";
        }

        return [
            ['HELPDESK SURABRAJA – LAPORAN TICKETING IT'], // A1
            ['Tanggal Export : ' . now()->format('d-m-Y')], // A2
            [$periode],                                     // A3
            [''],                                           // A4 kosong
            [
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
            ]
        ];
    }

    // ========================
    //      STYLING EXCEL
    // ========================
    public function styles(Worksheet $sheet)
    {
        // Merge header laporan (judul dan info)
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');

        // Style judul utama
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16
            ],
            'alignment' => [
                'horizontal' => 'center'
            ]
        ]);

        // Style A2 & A3
        $sheet->getStyle('A2:A3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11
            ],
            'alignment' => [
                'horizontal' => 'left'
            ]
        ]);

        // Header tabel
        $sheet->getStyle('A5:J5')->getFont()->setBold(true);

        // Border semua cell mulai dari baris 5 sampai data terakhir
        $sheet->getStyle('A5:J' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Wrap text kolom panjang
        $sheet->getStyle('D:J')->getAlignment()->setWrapText(true);

        return [];
    }
}
