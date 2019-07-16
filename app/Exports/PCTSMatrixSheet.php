<?php

namespace IParts\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
/*use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;*/

class PCTSMatrixSheet implements WithTitle, FromArray, WithHeadings
{
	private $matrix;

    public function __construct(array $matrix)
    {
        $this->matrix = $matrix;
    }

    public function array(): array
    {
        return $this->matrix;
    }

	public function headings(): array
	{
	    return [
			"Cotizador", 
			"Empresa", 
			"Cotizaciones"
	    ];
	}
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Cotizadores';
    }
}
