<?php

namespace App\Exports;

use App\Models\Driver;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DriverExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, ShouldAutoSize
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        return new Collection($this->getDriverData());
    }

    /**
     * @inheritDoc
     */
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'F' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
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

    private function getDriverData()
    {
        $results = [];
        $drivers = Driver::with(['user', 'car_type'])
            ->get();
        foreach ($drivers as $key => $driver) {
            $tmp = [
                ($key + 1),
                $driver->user->email,
                $driver->car_type->name,
                $driver->name,
                $driver->vehicle_id,
                strval($driver->phone),
                $driver->bank,
                $driver->account_number,
                $driver->on_broadcast ? 'Aktif' : 'Tidak Aktif',
                $driver->broadcast_name,
            ];
            array_push($results, $tmp);
        }
        return $results;
    }
}
