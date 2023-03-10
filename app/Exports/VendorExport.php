<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vendor::all();
    }

    public function map($row): array
    {
        return [
            $row->vendor_code,
            $row->name,
            $row->address,
            $row->office_phone,
            $row->office_email,
            $row->bin,
            $row->tin,
            $row->trade_licence,
            $row->bank_account_name,
            $row->bank_account_number,
            $row->bank_routing_number,
            $row->bank_name,
            $row->bank_branch,
            implode(',', $row->contacts->pluck('contact_person')->toArray()),
        ];
    }

    public function headings(): array
    {
        return [
            'Vendor Code',
            'Name',
            'Address',
            'Office Phone',
            'Office Email',
            'Bin',
            'Tin',
            'Trade License',
            'Bank Account Name',
            'Bank Account Number',
            'Bank Routing Number',
            'Bank Name',
            'Branch Name',
            'contract',
        ];
    }
}
