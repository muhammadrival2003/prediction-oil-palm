<?php

namespace App\Exports;

use App\Models\ManyGawanganManual;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ManyGawanganManualsExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $lastRow;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menentukan baris terakhir yang berisi data
                $this->lastRow = $event->sheet->getHighestDataRow();

                // Style untuk seluruh range data (header + isi)
                $dataRange = 'A5:AF' . $this->lastRow;
                $dataRangeTitle = 'A3:AF3';
                $dataNameCompany = 'A1';

                // CARA START MENGAMBIL CELL
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestDataRow();

                // Cari semua baris jumlah
                for ($row = 1; $row <= $highestRow; $row++) {
                    $cellValue = $sheet->getCell('C' . $row)->getValue();

                    if (str_contains($cellValue, 'JUMLAH')) {

                        // Style baris jumlah
                        $event->sheet->getStyle('C' . $row . ':AF' . $row)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '0000000'],
                            ],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => 'a9dfbf'] // Warna biru
                            ],
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_MEDIUM,
                                    'color' => ['rgb' => '000000'],
                                ],
                            ],
                        ]);
                    }

                    // Format angka
                    $event->sheet->getStyle('E' . $row . ':F' . $row)
                        ->getNumberFormat()
                        ->setFormatCode('#,##');
                }

                // END CARA MENGAMBIL CELL

                // Style untuk Nama Perusahaan
                $event->sheet->getStyle($dataNameCompany)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'bold' => true,
                        'size' => 10,
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Style untuk Title
                $event->sheet->getStyle($dataRangeTitle)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 15,
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Style dasar untuk semua sel
                $event->sheet->getStyle($dataRange)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'size' => 10,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Style khusus untuk header
                // $event->sheet->getStyle('A4:G4')->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //         'color' => ['rgb' => '000000'],
                //     ],
                //     'fill' => [
                //         'fillType' => Fill::FILL_SOLID,
                //         'color' => ['rgb' => 'FFFFFF']
                //     ],
                //     'alignment' => [
                //         'horizontal' => Alignment::HORIZONTAL_CENTER,
                //     ],
                // ]);

                // Style untuk kolom angka (rencana, realisasi, selisih)
                // $numberColumns = ['E', 'F', 'G'];
                // foreach ($numberColumns as $col) {
                //     $event->sheet->getStyle($col . '5:' . $col . $this->lastRow)
                //         ->getNumberFormat()
                //         ->setFormatCode('#,##0.00');
                // }

                // Style untuk selisih (kolom G)
                // $selisihRange = 'G5:G' . $this->lastRow;
                // $event->sheet->getStyle($selisihRange)->applyFromArray([
                //     'font' => [
                //         'bold' => true,
                //     ],
                // ]);

                // Conditional formatting untuk selisih negatif/positif
                // $conditionalStyles = new \PhpOffice\PhpSpreadsheet\Style\Style(false, true);
                // $conditionalStyles->applyFromArray([
                //     'font' => [
                //         'color' => ['rgb' => 'FF0000'],
                //     ],
                // ]);

                // $conditional = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                // $conditional->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CELLIS);
                // $conditional->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_LESSTHAN);
                // $conditional->addCondition(0);
                // $conditional->setStyle($conditionalStyles);

                // $event->sheet->getStyle($selisihRange)
                //     ->setConditionalStyles([$conditional]);

                // Auto size semua kolom
                $columns = [
                    'A',
                    'B',
                    'C',
                    'D',
                    'E',
                    'F',
                    'G',
                    'H',
                    'I',
                    'J',
                    'K',
                    'L',
                    'M',
                    'N',
                    'O',
                    'P',
                    'Q',
                    'R',
                    'S',
                    'T',
                    'U',
                    'V',
                    'W',
                    'X',
                    'Y',
                    'Z',
                    'AA',
                    'AB',
                    'AC',
                    'AD'
                ];

                foreach ($columns as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }

                // $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(false);

                // Zebra stripe untuk baris data
                // for ($row = 5; $row <= $this->lastRow; $row++) {
                //     if ($row % 2 == 0) {
                //         $event->sheet->getStyle('A' . $row . ':G' . $row)
                //             ->getFill()
                //             ->setFillType(Fill::FILL_SOLID)
                //             ->getStartColor()
                //             ->setRGB('F8F9FA');
                //     }
                // }

                // Style untuk total row jika ada
                // if ($this->lastRow > 4) {
                //     $totalRow = $this->lastRow + 1;
                //     $event->sheet->setCellValue('D' . $totalRow, 'TOTAL');
                //     $event->sheet->getStyle('D' . $totalRow . ':G' . $totalRow)->applyFromArray([
                //         'font' => [
                //             'bold' => true,
                //         ],
                //         'fill' => [
                //             'fillType' => Fill::FILL_SOLID,
                //             'color' => ['rgb' => 'E9ECEF']
                //         ],
                //     ]);

                //     // Formula untuk total
                //     $event->sheet->setCellValue('E' . $totalRow, '=SUM(E5:E' . $this->lastRow . ')');
                //     $event->sheet->setCellValue('F' . $totalRow, '=SUM(F5:F' . $this->lastRow . ')');
                //     $event->sheet->setCellValue('G' . $totalRow, '=SUM(G5:G' . $this->lastRow . ')');

                //     // Format angka untuk total
                //     $event->sheet->getStyle('E' . $totalRow . ':G' . $totalRow)
                //         ->getNumberFormat()
                //         ->setFormatCode('#,##0.00');
                // }

            }
        ];
    }



    public function view(): View
    {
        $query = ManyGawanganManual::with(['blok', 'blok.tahunTanam'])
            ->orderBy('tanggal', 'desc');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        $data = $query->get();

        return view('exports.many-gawangan-manual', [
            'gawangans' => $data,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}
