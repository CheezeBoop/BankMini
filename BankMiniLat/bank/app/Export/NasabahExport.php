<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NasabahExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($rekening, $index) {
            return [
                'No' => $index + 1,
                'No Rekening' => $rekening->no_rekening,
                'Nama' => $rekening->nasabah->nama,
                'NIS/NIP' => $rekening->nasabah->nis_nip ?? '-',
                'Email' => $rekening->nasabah->email,
                'Saldo' => $rekening->saldo,
                'Status' => $rekening->nasabah->status,
                'Tanggal Buka' => $rekening->tanggal_buka->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No Rekening',
            'Nama',
            'NIS/NIP',
            'Email',
            'Saldo',
            'Status',
            'Tanggal Buka',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // header bold
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_IDR_SIMPLE, // Kolom Saldo pakai format Rupiah
        ];
    }
}
