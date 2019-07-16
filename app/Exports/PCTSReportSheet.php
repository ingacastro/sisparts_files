<?php

namespace IParts\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PCTSReportSheet implements FromArray, WithHeadings, WithTitle
{
	private $pcts;

    public function __construct(array $pcts)
    {
        $this->pcts = $pcts;
    }

    public function array(): array
    {
        return $this->pcts;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
   public function headings(): array
    {
        return [
			"Fecha recibida", 
			"Fecha enviada", 
			"Tiempo respuesta", 
			"Empresa", 
			"Folio" , 
        	"Referencia", 
        	"Cotizador", 
        	"Cliente", 
        	"Items cotizados", 
        	"Estatus",
            "No. CTZ"
        ];
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Reporte';
    }
}
