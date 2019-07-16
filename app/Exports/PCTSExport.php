<?php
namespace IParts\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use IParts\Exports\PCTSReportSheet;
use IParts\Exports\PCTSMatrixSheet;

class PCTSExport implements WithMultipleSheets
{
    use Exportable;

    protected $pcts;
    protected $matrix;
    
    public function __construct(array $pcts, array $matrix)
    {
        $this->pcts = $pcts;
        $this->matrix = $matrix;
    }

    public function sheets(): array
    {
        $sheets = [];
        for($i = 0; $i < 2; $i++) {
            if($i == 0)
                $sheets[] = new PCTSReportSheet($this->pcts);
            else
                $sheets[] = new PCTSMatrixSheet($this->matrix);
        }
        return $sheets;
    }
}