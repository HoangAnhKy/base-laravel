<?php

namespace App\Exports;

use App\Models\CourseDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CourseDetailExport implements FromCollection, WithHeadings, WithCustomStartCell, ShouldAutoSize, WithMapping, WithStyles
{
    private $id_course;
    private $totalStudents;
    private $teacherName;

    public function __construct($id_course = null)
    {
        if (!empty($id_course)) {
            $this->id_course = $id_course;
        }
    }

    public function startCell(): string
    {
        return 'A5';
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $condition = ["course_id" => $this->id_course];
        $data_export = CourseDetail::selectALL($condition, ["course.teacher", "student"]);
        $this->totalStudents = $data_export->count();
        $this->teacherName = $data_export[0]->course->teacher->name_user;
        return $data_export;
    }

    public function headings(): array
    {
        return [
            'Name Student',
            'Email',
            'Created Day',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->student->name_user,
            $invoice->student->email,
            $invoice->updated_at ?? $invoice->created_at,
        ];
    }
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Ghi thông tin teacher và tổng số sinh viên
        $sheet->setCellValue('A1', "Teacher");
        $sheet->setCellValue('B1', $this->teacherName);
        $sheet->setCellValue('A2', "Total");
        $sheet->setCellValue('B2', $this->totalStudents);

        // Định dạng header
        $sheet->getStyle('A5:C5' )->getFont()->setBold(true);
        $sheet->getStyle("A5:C5")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $lastRow = $this->totalStudents + 5;
        $sheet->getStyle("A5:C{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Màu đen
                ],
            ],
        ]);

    }



}
