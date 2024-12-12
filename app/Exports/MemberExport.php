<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Services\MemberService;

class MemberExport implements FromCollection, WithHeadings, WithEvents
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    // Define tile
    public $styleHeader = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'wrapText' => true,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => 'ededed'],
        ],
        'font' => [
            'size' => 14,
            'bold' => true,
            'name' => 'Times New Roman',
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];

    // Define style
    public $styleCell = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'wrapText' => true,
        ],
        'font' => [
            'size' => 13,
            'name' => 'Times New Roman',
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];

    // Sample data
    public function collection()
    {
        $outputArr = [];
        $universities = $this->memberService->getAllMember(); 
        foreach ($universities as $key => $value) {
            array_push($outputArr, [
                $key + 1,
                $value->name,
                $value->email,
                $value->phone,
                $value->province?->full_name ?? 'N/A', // Kiểm tra province tồn tại
                $value->district?->full_name ?? 'N/A', // Kiểm tra district tồn tại
                $value->ward?->full_name ?? 'N/A',     // Kiểm tra ward tồn tại
                $value->address,
                $value->birthday,
            ]);
        }
        return collect($outputArr);
    }    

    // Title
    public function headings(): array
    {
        return [
            "STT",
            "Họ và tên",
            "Email",
            "Số điện thoại",
            "Tỉnh",
            "Huyện",
            "Phưởng",
            "Địa chỉ",
            "Ngày sinh",
        ];
    }

    /**
     * Event edit after creating sheet
     * 
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle("A1:I1")->applyFromArray($this->styleHeader);

                $columns = ['A' => 5, 'B' => 20, 'C' => 25, 'D' => 20, 'E' => 15, 'F' => 25, 'G' => 15, 'H' => 25, 'I' => 20];
                foreach ($columns as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                $lastRow = 11;
                $sheet->getStyle("A2:I$lastRow")->applyFromArray($this->styleCell);

                for ($row = 2; $row <= $lastRow; $row++) {
                    $validation = $sheet->getCell("G$row")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1('"Admin,Giáo vụ"');
                    $validation->setErrorTitle('Lỗi nhập liệu');
                    $validation->setError('Giá trị không nằm trong danh sách.');
                    $validation->setPromptTitle('Chọn vai trò');
                    $validation->setPrompt('Vui lòng chọn giá trị từ danh sách.');
                }
            },
        ];
    }
}
