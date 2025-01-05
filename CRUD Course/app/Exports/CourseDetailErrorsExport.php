<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CourseDetailErrorsExport implements FromCollection, WithMapping,ShouldAutoSize,WithHeadings
{
    protected $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    public function collection()
    {
        return collect($this->errors);
    }

    public function headings(): array
    {
        return [
            'No',
            'Name Student',
            'Email',
            'Created by',
            'Error',
        ];
    }

    public function map($invoice): array
    {
        $invoice = (object)$invoice;
        return [
            $invoice->row,
            $invoice->data[0],
            $invoice->data[1],
            $invoice->data[2],
            current(current($invoice->errors))
        ];
    }
}
