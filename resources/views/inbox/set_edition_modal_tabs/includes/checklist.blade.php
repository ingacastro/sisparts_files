<div class="row modal-content-border" style="background: #f1f4f7;">
    <div class="col-md-12 checklist-container">                            
        <h4 class="form-section">Checklist</h4>
        <div class="form-group">
            <div class="radio-list">
                <label>
                    <input class="material-specifications" type="checkbox" name="material_specifications" value="checked" {{ $checklist->material_specifications }}> Revisar especificaciones del material
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist quoted-amounts" type="checkbox" name="quoted_amounts" value="checked" {{ $checklist->quoted_amounts }}> Revisar cantidades cotizadas
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist quotation-currency" type="checkbox" name="quotation_currency" value="checked" {{ $checklist->quotation_currency }}> Revisar moneda de la cotización
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist unit-price" type="checkbox" name="unit_price" value="checked" {{ $checklist->unit_price }}> Revisar el precio unitario
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist delivery-time" type="checkbox" name="delivery_time" value="checked" {{ $checklist->delivery_time }}> Revisar el tiempo de entrega
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist delivery-conditions" type="checkbox" name="delivery_conditions" value="checked" {{ $checklist->delivery_conditions }}> Revisar las condiciones de entrega
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist product-condition" type="checkbox" name="product_condition" value="checked" {{ $checklist->product_condition }}> Revisar la condición del producto
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist entrance-shipment_costs" type="checkbox" name="entrance_shipment_costs" value="checked" {{ $checklist->entrance_shipment_costs }}> Revisar costos de flete entrada
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist weight-calculation" type="checkbox" name="weight_calculation" value="checked" {{ $checklist->weight_calculation }}> Revisar cálculo del peso
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist material-origin" type="checkbox" name="material_origin" value="checked" {{ $checklist->material_origin }}> Revisar procedencia del material
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist incoterm" type="checkbox" name="incoterm" value="checked" {{ $checklist->incoterm }}> Revisar incoterm
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist minimum-purchase" type="checkbox" name="minimum_purchase" value="checked" {{ $checklist->minimum_purchase }}> Revisar mínimo de compra
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
                <label>
                    <input class="set-checklist extra-charges" type="checkbox" name="extra_charges" value="checked" {{ $checklist->extra_charges }}> Revisar gastos extra
                    <span aria-hidden="true" class="icon-question pull-right checklist-question-mark"></span>
                </label>
            </div>
        </div>
        <div class="checklist-buttons-container">
            <button type="submit" class="btn btn-circle btn-sm green-meadow">Aprobar</button>
            <button type="button" class="btn btn-circle btn-sm yellow">Rechazar</button>
        </div>
    </div>                          
</div>