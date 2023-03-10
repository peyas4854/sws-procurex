<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Item::all();
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->category ? $row->category->name:'',
            $row->brand ? $row->brand->name : '',
            $row->uom ? $row->uom->name : '',
            $row->price,
            $row->price_date,
            config("constants.item_type.$row->item_type"),
            $row->is_active == 1 ? 'Yes' : 'No',
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Brand',
            'Uom',
            'Price',
            'Price Date',
            'Item Type',
            'Status',
        ];
    }
}
