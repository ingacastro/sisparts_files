<?php

namespace IParts\Http\Controllers;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use IParts\Document;
use IParts\NumberOfAutomaticEmail;
use IParts\Binnacle;
use IParts\Http\Helper;

class PCTsController extends Controller
{
    private $minutos_query = 30;
    private $fecha_actual  = NULL;
    private $nro_max_envio = NULL;
    public $palabras = [];
    private $id_tipo_de_seguimiento = NULL;
    private $ref = 18885;
    public function __construct(){
        $this->nro_max_envio = NumberOfAutomaticEmail::find(1)->quantity;
        $this->fecha_actual = Carbon::now();
        $this->id_tipo_de_seguimiento = DB::table('selectlist_edit')
                                            ->select('id')
                                            ->where('name', 'email automático')
                                            ->first();
    }

    public function traduccionDeTemplate($lenguaje){
        if($lenguaje == 1 or $lenguaje == null){
            $this->palabras = [
                'titulo'        => 'Solicitud de cotización',
                'nro_de_partes' => 'Número de parte',
                'descripcion'   => 'Descripción',
                'fabricante'    => 'Fabricante',
                'cantidad'      => 'Cantidad',
                'cotizador'     => 'Cotizador',
                'correo_cotizador'  => 'Correo de cotizador',
                'telefono_de_cotizador' => 'Teléfono de cotizador'
            ];
        } elseif ( $lenguaje == 2) {
            $this->palabras = [
                'titulo'        => 'Request for quotation',
                'nro_de_partes' => 'Part number',
                'descripcion'   => 'Description',
                'fabricante'    => 'manufacturer',
                'cantidad'      => 'Quantity',
                'cotizador'     => 'Quote',
                'correo_cotizador'  => 'Quote Mail',
                'telefono_de_cotizador' => 'Quote phone'
            ];

        } elseif ($lenguaje == 3) {
            $this->palabras = [
                'titulo'        => 'Solicitação de cotação',
                'nro_de_partes' => 'Número de parte',
                'descripcion'   => 'Descrição do produto',
                'fabricante'    => 'Fabricante',
                'cantidad'      => 'Quantidade',
                'cotizador'     => 'Citação',
                'correo_cotizador'  => 'Quote Mail',
                'telefono_de_cotizador' => 'Citar telefone'
            ];
        }
    }

    private function pctsRecientes(){
        $tiempo_a_consultar = $this->fecha_actual->subMinutes($this->minutos_query);
        return  Document::select('documents.*', 'users.email As email', 'sync_connections.display_name AS empresa')
                        ->where('documents.type', 'PCT')
                        ->where('documents.state', '<>', 'C')
                        ->where('documents.status', 1)
                        ->where('documents.created_at', '>', $tiempo_a_consultar)
                        ->leftJoin('users', 'users.id', '=', 'documents.employees_users_id')
                        ->leftJoin('sync_connections', 'sync_connections.id', '=', 'documents.sync_connections_id')
                        ->take(2)
                        ->get();   
    }

    private function obtenerLosNumerosDePartesRelacionadosConUnaPCT($pct_id){
        return Document::select('documents_supplies.id', 'documents_supplies.set', 'supplies.manufacturers_id',
        'documents_supplies.products_amount', 'supplies.number', 'supplies.large_description', 'suppliers.trade_name as supplier', 'supplies.measurement_unit', 'currencies.name as currency', 'documents_supplies.unit_price', 'documents_supplies.documents_id', 'documents_supplies.supplies_id', 'manufacturers.name as manufacturer')
        ->where('documents_supplies.status', 1)
        ->where('documents_supplies.documents_id', $pct_id)
        ->leftJoin('documents_supplies', 'documents.id', 'documents_supplies.documents_id')
        ->leftJoin('supplies', 'documents_supplies.supplies_id', 'supplies.id')
        ->leftJoin('manufacturers', 'manufacturers.id', 'supplies.manufacturers_id')
        ->leftjoin('suppliers', 'suppliers.id', 'documents_supplies.suppliers_id')
        ->leftJoin('currencies', 'currencies.id', 'documents_supplies.currencies_id')
        ->get();
    }

    public function obtenerPCTsYSusNumerosDeParte(){
        
        // Obtener las PCTs recientes
        $pcts = $this->pctsRecientes();
        $numeros_de_partes = [];
        $cantidad_de_proveedores = [];
        $proveedores = [];
        $contador = 0;

       //dd($pcts);

        foreach ($pcts as $pct) {

            $numeros_de_partes[$pct->id] = $this->obtenerLosNumerosDePartesRelacionadosConUnaPCT($pct->id);
            
            /**
             *  Obtener los proveedores del
             *  Nro de Parte
             */

            foreach ($numeros_de_partes[$pct->id] as $numero_de_parte) {

                /**
                 * Si la cantidad de proveedores por este Nro de Parte 
                 * es 0 que siga con el siguiente
                 */

                if(! $this->contarProveedoresPorNumeroDeParte($numero_de_parte->manufacturers_id))
                    continue;

                /**
                 * Guardar los proveedores 
                 * En el array
                 */
                $proveedores[$numero_de_parte->manufacturers_id] = $this->obtenerProveedoresPorMarca        ($numero_de_parte->manufacturers_id);

                /**
                 * Enviar correo a proveedores
                 */

                foreach ( $proveedores[$numero_de_parte->manufacturers_id] as $proveedor) {
                    if($proveedor->email){  
            
                        $this->traduccionDeTemplate($proveedor->languages_id);

                        try {
                            
                            Helper::sendMail($proveedor->email, $this->palabras['titulo'], $this->templateEmail($numero_de_parte, $pct), $pct->email, null);

                            Binnacle::create([
                                'entity'        => 1,
                                'comments'      => "Se envío un correo automático a {$proveedor->proveedor} por el número de parte {$numero_de_parte->number} al correo {$proveedor->email}",
                                'type'          => $this->id_tipo_de_seguimiento->id,
                                'documents_id'   => $pct->id,
                                'pct_status'    => 1,
                                'users_id'      => $pct->employees_users_id     
                            ]);
                            
                            DB::table('documents_supplies')
                                ->where('id', $numero_de_parte->id)
                                ->update(['status' =>  2]);

                        } catch (\Throwable $th) {
                            echo $th->getMessage() . '<br><br>';
                        }
                        
                    }
                }
            }
        }
    }

    private function obtenerProveedoresPorMarca($fabricante){
        return  DB::table('suppliers_manufacturers')
                    ->select('manufacturers.name AS fabricante' ,'suppliers.trade_name AS proveedor', 'suppliers.email AS email', 'suppliers.languages_id')
                    ->where('manufacturers_id', $fabricante)
                    ->where('email', '<>', '')
                    ->leftJoin('suppliers', 'suppliers.id', '=', 'suppliers_manufacturers.suppliers_id')
                    ->leftJoin('manufacturers', 'manufacturers.id', '=', 'suppliers_manufacturers.manufacturers_id')
                    ->get();
    }

    private function contarProveedoresPorNumeroDeParte($fabricante){
        return DB::table('suppliers_manufacturers')
                    ->select('manufacturers.name AS fabricante' ,'suppliers.trade_name AS proveedor', 'suppliers.email AS email')
                    ->where('manufacturers_id', $fabricante)
                    ->where('email', '<>', '')
                    ->leftJoin('suppliers', 'suppliers.id', '=', 'suppliers_manufacturers.suppliers_id')
                    ->leftJoin('manufacturers', 'manufacturers.id', '=', 'suppliers_manufacturers.manufacturers_id')
                    ->count();       
    }

    public function templateEmail($nro_de_parte, $pct){

        $titulo         = $this->palabras['titulo'];
        $nro_de_partes  = $this->palabras['nro_de_partes'];
        $descripcion    = $this->palabras['descripcion'];
        $fabricante     = $this->palabras['fabricante'];
        $cantidad       = $this->palabras['cantidad'];
        $cotizador      = $this->palabras['cotizador'];
        $correo_cotizador = $this->palabras['correo_cotizador'];

        return "<div>
            <h3>$titulo</h3>
            <p><strong>$nro_de_partes: </strong>$nro_de_parte->number</p>
            <p><strong>$descripcion</strong>$nro_de_parte->large_description</p>
            <p><strong>$fabricante:</strong>$nro_de_parte->manufacturer</p>
            <p><strong>$cantidad:</strong>$nro_de_parte->products_amount</p>
            <hr>
            <p><strong>$cotizador:</strong>$pct->buyer_name</p>
            <p><strong>$correo_cotizador:</strong>$pct->email</p>
        </div>";
    }
}
