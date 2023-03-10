<?php

namespace App\Exports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class BrandExport implements  FromCollection, WithHeadings, WithMapping
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Brand::all();
    }
    public function map($row): array
    {
        return [
            $row->name
        ];

    }
    public function headings(): array
    {
        return [
            'Name',
        ];
    }
}
