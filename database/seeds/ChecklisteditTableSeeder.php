<?php

use IParts\Checklistauth;
use Illuminate\Database\Seeder;

class ChecklisteditTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = new Checklistauth();
        $check->name = 'Revisar especificaciones del material';
        $check->checklist_column = 'material_specifications';
        $check->status = 'Visible';
        $check->help = 'Revisar a detalle las especificaciones del material y revisar la descripción que nos ofrece el proveedor coincida con lo que estamos ofreciendo al cliente.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar cantidades cotizadas';
        $check->checklist_column = 'quoted_amounts';
        $check->status = 'Visible';
        $check->help = 'Se deberán revisar las cantidades cotizadas y las que requiere el cliente.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar moneda de la cotización';
        $check->checklist_column = 'quotation_currency';
        $check->status = 'Visible';
        $check->help = 'Se deberá revisar a detalle la moneda de la cotización del proveedor, revisar que está seleccionada en el Sistema International Parts (SISPARTS), y además que esté correctamente seleccionada el SIAVCOM, o en su defecto el precio de venta esté convertido al tipo de cambio correcto (En caso de cotizar con otra moneda).';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar el precio unitario';
        $check->checklist_column = 'unit_price';
        $check->status = 'Visible';
        $check->help = 'Se deberá revisar que sea correcto el precio unitario que se agregó al catálogo virtual.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar el tiempo de entrega';
        $check->checklist_column = 'delivery_time';
        $check->status = 'Visible';
        $check->help = 'Se deberá revisar que se esté considerando una semana más del entrega para productos nacionales, de 2 a 3 semanas más para productos de importación.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar las condiciones de entrega';
        $check->checklist_column = 'delivery_conditions';
        $check->status = 'Visible';
        $check->help = '';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar la condición del producto';
        $check->checklist_column = 'product_condition';
        $check->status = 'Visible';
        $check->help = 'Se deberá revisar la condición del producto, en caso de ofrecer un producto en estado diferente a NUEVO se deberá indicar en las notas de la cotización Por ejemplo: ***PRODUCTO USADO***';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar costos de flete entrada';
        $check->checklist_column = 'entrance_shipment_costs';
        $check->status = 'Visible';
        $check->help = 'Se deberá revisar si el proveedor nos anexó cotización del flete a nuestro almacén, o si será por su cuenta o en su defecto calcular el costo del flete a nuestro almacén.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar cálculo del peso';
        $check->checklist_column = 'weight_calculation';
        $check->status = 'Visible';
        $check->help = 'Se deberá considerar el peso del material x cantidad para cálculo del flete del proveedor a nosotros y utilizar la tabla de pesos de FedEx, además del cálculo de nuestro almacén al cliente.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar procedencia del material';
        $check->checklist_column = 'material_origin';
        $check->status = 'Visible';
        $check->help = 'Se deberá considerar la procedencia del material, esto para calcular el profit ya sea NACIONAL o EXTRANJERO.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar incoterm';
        $check->checklist_column = 'incoterm';
        $check->status = 'Visible';
        $check->help = 'Son normas que determinan quién paga el flete de la mercancía, su punto de entrega, y quién debe hacer el seguro, entre otras cosas.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar mínimo de compra';
        $check->checklist_column = 'minimum_purchase';
        $check->status = 'Visible';
        $check->help = 'Se deberá considerar el pedido mínimo del proveedor en caso de existir, para ello se considera el MOQ (Por sus siglas en inglés: Cantidad mínima de compra) también en nuestra cotización.';
        $check->save();

        $check = new Checklistauth();
        $check->name = 'Revisar gastos extra';
        $check->checklist_column = 'extra_charges';
        $check->status = 'Visible';
        $check->help = 'Se deberán revisar las condiciones de la cotización, en caso de existir gastos extra (POR EJEMPLO: EMBALAJE) habrá que considerar el gasto en el campo de gastos extra.';
        $check->save();
    }
}
