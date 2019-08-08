@if(Auth::user()->hasRole('Cotizador') && $set->status == 7)
<strong style="color: red">Motivo de rechazo: </strong>{{ $set->rejections->last()->title }}
@endif
<div class="row modal-content-border" style="background: #f1f4f7;">
    <div class="col-md-12 checklist-container">                            
        <h4 class="form-section">Checklist</h4>
        <form id="checklist_form">
            <div class="form-group">
                <div class="radio-list">
                    <label>
                        <input class="set-checklist material-specifications" data-set_id="{{$checklist->id}}" data-field="material_specifications" type="checkbox" name="material_specifications" value="checked" {{ $checklist->material_specifications }}> Revisar especificaciones del material
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Revisar a detalle las especificaciones del material y revisar la descripción que nos ofrece el proveedor coincida con lo que estamos ofreciendo al cliente."></span>
                    </label>
                    <label>
                        <input class="set-checklist quoted-amounts" data-set_id="{{$checklist->id}}" data-field="quoted_amounts" type="checkbox" name="quoted_amounts" value="checked" {{ $checklist->quoted_amounts }}> Revisar cantidades cotizadas
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Se deberán revisar las cantidades cotizadas y las que requiere el cliente."></span>
                    </label>
                    <label>
                        <input class="set-checklist quotation-currency" data-set_id="{{$checklist->id}}" data-field="quotation_currency" type="checkbox" name="quotation_currency" value="checked" {{ $checklist->quotation_currency }}> Revisar moneda de la cotización
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Se deberá revisar a detalle la moneda de la cotización del proveedor, revisar que está seleccionada correctamente en el Sistema International Parts (SISPARTS), y además que esté correctamente seleccionada el SIAVCOM, o en su defecto el
                        precio de venta esté convertido al tipo de cambio correcto (En caso de cotizar con otra moneda)."></span>
                    </label>
                    <label>
                        <input class="set-checklist unit-price"  data-set_id="{{$checklist->id}}" data-field="unit_price"type="checkbox" name="unit_price" value="checked" {{ $checklist->unit_price }}> Revisar el precio unitario
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá revisar que sea correcto el precio unitario que se agregó al catálogo virtual."></span>
                    </label>
                    <label>
                        <input class="set-checklist delivery-time" data-set_id="{{$checklist->id}}" data-field="delivery_time" type="checkbox" name="delivery_time" value="checked" {{ $checklist->delivery_time }}> Revisar el tiempo de entrega
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá revisar que se esté considerando una semana más del entrega para productos nacionales, de 2 a 3 semanas
                        más para productos de importación."></span>
                    </label>
                    <label>
                        <input class="set-checklist delivery-conditions" data-set_id="{{$checklist->id}}" data-field="delivery_conditions" type="checkbox" name="delivery_conditions" value="checked" {{ $checklist->delivery_conditions }}> Revisar las condiciones de entrega
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                    </label>
                    <label>
                        <input class="set-checklist product-condition" data-set_id="{{$checklist->id}}" data-field="product_condition" type="checkbox" name="product_condition" value="checked" {{ $checklist->product_condition }}> Revisar la condición del producto
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá revisar la condición del producto, en caso de ofrecer un producto en estado diferente a NUEVO se deberá
                               indicar en las notas de la cotización Por ejemplo: ***PRODUCTO USADO***"></span>
                    </label>
                    <label>
                        <input class="set-checklist entrance-shipment_costs" data-set_id="{{$checklist->id}}" data-field="entrance_shipment_costs" type="checkbox" name="entrance_shipment_costs" value="checked" {{ $checklist->entrance_shipment_costs }}> Revisar costos de flete entrada
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá revisar si el proveedor nos anexó cotización del flete a nuestro almacén, o si será por su cuenta o en su defecto calcular el costo del flete a nuestro almacén."></span>
                    </label>
                    <label>
                        <input class="set-checklist weight-calculation" data-set_id="{{$checklist->id}}" data-field="weight_calculation" type="checkbox" name="weight_calculation" value="checked" {{ $checklist->weight_calculation }}> Revisar cálculo del peso
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá considerar el peso del material x cantidad para cálculo del flete del proveedor a nosotros y utilizar la
                        tabla de pesos de FedEx, además del cálculo de nuestro almacén al cliente."></span>
                    </label>
                    <label>
                        <input class="set-checklist material-origin" data-set_id="{{$checklist->id}}" data-field="material_origin" type="checkbox" name="material_origin" value="checked" {{ $checklist->material_origin }}> Revisar procedencia del material
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark" 
                        title="Se deberá considerar la procedencia del material, esto para calcular el profit ya sea NACIONAL o EXTRANJERO."></span>
                    </label>
                    <label>
                        <input class="set-checklist incoterm"  data-set_id="{{$checklist->id}}" data-field="incoterm" type="checkbox" name="incoterm" value="checked" {{ $checklist->incoterm }}> Revisar incoterm
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Son normas que determinan quién paga el flete de la mercancía, su punto de entrega, y quién debe hacer el seguro, entre otras cosas."></span>
                    </label>
                    <label>
                        <input class="set-checklist minimum-purchase" data-set_id="{{$checklist->id}}" data-field="minimum_purchase" type="checkbox" name="minimum_purchase" value="checked" {{ $checklist->minimum_purchase }}> Revisar mínimo de compra
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberá considerar el pedido mínimo del proveedor en caso de existir, para ello se considera el MOQ (Por sus siglas en inglés: Cantidad mínima de compra) también en nuestra cotización."></span>
                    </label>
                    <label>
                        <input class="set-checklist extra-charges" data-set_id="{{$checklist->id}}" data-field="extra_charges" type="checkbox" name="extra_charges" value="checked" {{ $checklist->extra_charges }}> Revisar gastos extra
                        <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"
                        title="Se deberán revisar las condiciones de la cotización, en caso de existir gastos extra (POR EJEMPLO: EMBALAJE) habrá que considerar el gasto en el campo de gastos extra."></span>
                    </label>
                </div>
            </div>
        </form>
        <div class="checklist-buttons-container">
            <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change"
            data-set_id="{{$set->id}}" data-document_id="{{ $doc_id }}" data-status="6" id="in_authorization_btn"
            style="display: {{ Auth::user()->hasRole('Cotizador') && ($set->status == 5 || $set->status == 7) ? 'inline-block' : 'none' }}">Enviar a autorización</button>

            @role('Administrador')
            <div id="authorization_btns_container" style="display: {{ $set->status == 6 ? 'block' : 'none' }}">
                <button type="submit" class="btn btn-circle btn-sm green-meadow set-status-change" data-set_id="{{$set->id}}" 
                    data-status="8" data-document_id="{{ $doc_id }}">Autorizar</button>
                <button type="button" class="btn btn-circle btn-sm yellow set-rejection" data-set_id="{{$set->id}}" 
                    data-status="7" data-document_id="{{ $doc_id }}" data-target="#set_rejection_modal" data-toggle="modal">Rechazar</button>
            </div>
            @endrole
        </div>
    </div>                          
</div>