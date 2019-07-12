<?php
namespace IParts\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PCTSExport implements FromArray, WithHeadings
{
    protected $pcts;

    public function __construct(array $pcts)
    {
        $this->pcts = $pcts;
    }

    public function array(): array
    {
        return $this->pcts;
    }

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
}