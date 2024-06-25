<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class BroadcastReportExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }

    /**
     * @inheritDoc
     */
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'No.',
            'Email',
            'Tipe Mobil',
            'Nama Driver',
            'Plat Nomor',
            'No. HP',
            'BANK',
            'No. Rekening',
            'Status Iklan',
            'Iklan',
        ];
    }
}
