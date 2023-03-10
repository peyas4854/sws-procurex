<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoryExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::all();
    }
    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Category Code',
            'Parent Category',

        ];
    }
    public function map($row): array
    {
        return [

            $row->name,
            $row->description,
            $row->category_code,
            $row->parent ? $row->parent->name:'',
        ];
    }
}
