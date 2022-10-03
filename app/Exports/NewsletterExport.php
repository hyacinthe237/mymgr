<?php 

namespace App\Exports;

use App\Models\Newsletter;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsletterExport implements FromCollection, WithHeadings
{
    public function collection () {
        return Newsletter::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'Role',
        ];
    }
}