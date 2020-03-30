<div class="row modal-content-row">
  <div class="col-md-12">


<div id="pct_edit_modal_error_messages1" style="display: none;">
  <div class="custom-alerts alert alert-danger fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul id="error_text_proveedor">
    </ul>
  </div>
</div>

<div id="pct_edit_modal_success_messages2" style="display: none;">
  <div class="custom-alerts alert alert-success fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul id="espera_text_proveedor">
    </ul>
  </div>
</div>

<div id="pct_edit_modal_success_messages1" style="display: none;">
  <div class="custom-alerts alert alert-success fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul id="success_text_proveedor">
    </ul>
  </div>
</div>

<p id="set_id_id" style="display: none;"></p>


    <div class="tabbable-line boxless tabbable-reversed">
      <ul class="nav nav-tabs" id="supplier_tabs">
        <li class="active">
          <a href="#tab_0_content" id="tab_0" data-toggle="tab" aria-expanded="true"> Datos Básicos </a>
        </li>
        <li>
          <a href="#tab_5_content" id="tab_5" data-toggle="tab"> Datos Fiscales </a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane  active" id="tab_0_content">
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption">
                <i class=""></i>Datos Básicos
              </div>
            </div>
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form action="" id="basic_form" class="horizontal-form">
                <div class="form-body">
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="trade_name">
                          <span class="required">* </span>Nombre comercial
                        </label>
                        <input class="form-control" id="trade_name" autocomplete="off" name="trade_name" type="text">
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="country">
                          <span class="required">* </span>País
                        </label>
                        <select class="form-control drop-down" id="countries_id" name="countries_id">
                          <option selected="selected" value="">Seleccionar...</option>
                          @foreach($countries2 as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="email">
                          <span class="required">* </span>Correo electrónico
                        </label>
                        <input class="form-control" id="email" autocomplete="off" name="email" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="language">
                          <span class="required">* </span>Idioma
                        </label>
                        <select class="form-control drop-down" id="languages_id" name="languages_id">
                          <option selected="selected" value="">Seleccionar...</option>
                          @foreach($languages2 as $lag)
                            <option value="{{ $lag->id }}">{{ $lag->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="landline">
                          <span class="required">* </span>Teléfono fijo
                        </label>
                        <input class="form-control" id="landline" autocomplete="off" name="landline" type="text">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="currency">Moneda</label>
                        <select class="form-control drop-down" id="currencies_id" id="currencies_id">
                          <option selected="selected" value="">Seleccionar...</option>
                          @foreach($currencies2 as $cur)
                            <option value="{{ $cur->id }}">{{ $cur->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="mobile">Teléfono móvil</label>
                        <input class="form-control" id="mobile" autocomplete="off" name="mobile" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group" style="margin: 15px 0 0 0">
                        <input type="checkbox" value="1" name="marketplace" id="marketplace">
                        <label style="margin: 20px 0 0 0">Marketplace</label>
                        <span aria-hidden="true" class="icon-question " style="font-size: 18px" title="Solo obligatorio capturar nombre, país, idioma."></span>
                      </div>
                    </div>
                  </div>
                
                </div>

                <div class="form-actions right">
                  <button type="button" class="btn btn-circle blue" onclick="$('#tab_5').trigger('click')">
                    <i class="fa fa-check"></i> Continuar
                  </button>

                </div>
              </form>
              <!-- END FORM-->
            
            </div>
          </div>
        </div>
        
        <div class="tab-pane " id="tab_5_content">
          <div class="portlet box blue">
            <div class="portlet-title">
              <div class="caption">
                <i class=""></i>Datos Fiscales
              </div>
            </div>
            
            <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <!-- Create -->
              <form method="POST" action="http://sisparts.local/supplier" accept-charset="UTF-8" class="horizontal-form" id="fiscal_form">
                <input type="hidden" name="tabs_config" value="">
                
                <div class="form-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="business_name">Razón social</label>
                        <input class="form-control" id="business_name" autocomplete="off" name="business_name" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="">
                          <span class="required">* </span>Tipo de proveedor
                        </label>
                        <select class="form-control" id="type" name="type">
                          <option selected="selected" value="">Seleccionar...</option>
                          <option value="1">Persona física</option>
                          <option value="2">Persona moral</option>
                          <option value="3">Extranjero</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Estado</label>
                        <select class="form-control" id="states_id" style="display: none" disabled="" name="states_id">
                          <option selected="selected" value="">Seleccionar...</option>
                        </select>
                        <input class="form-control" style="display: none" id="state_name" autocomplete="off" disabled="" name="state" type="text">
            </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="rfc">RFC</label>
                        <input class="form-control" id="rfc" maxlength="13" style="text-transform: uppercase" autocomplete="off" name="rfc" type="text">
                      </div>
                    </div>
                  </div>
  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="city">Ciudad</label>
                        <input class="form-control" id="city" autocomplete="off" name="city" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="post_code">
                          <span class="required">* </span>Código postal
                        </label>
                        <input class="form-control integer-mask" id="post_code" maxlength="5" autocomplete="off" name="post_code" type="text">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="street">Calle</label>
                        <input class="form-control" id="street" autocomplete="off" name="street" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="contact_name">Contacto</label>
                        <input class="form-control" id="contact_name" autocomplete="off" name="contact_name" type="text">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="street_number">Número exterior</label>
                            <input class="form-control" id="street_number" autocomplete="off" name="street_number" type="text">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="control-label" for="unit_number">Número interior</label>
                            <input class="form-control" id="unit_number" autocomplete="off" name="unit_number" type="text">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="credit_days">Días de crédito</label>
                        <input class="form-control integer-mask" id="credit_days" autocomplete="off" name="credit_days" type="text">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="suburb">Colonia</label>
                        <input class="form-control" id="suburb" autocomplete="off" name="suburb" type="text">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label" for="credit_amount">Monto de credito</label>
                        <input class="form-control currency-mask" id="credit_amount" autocomplete="off" name="credit_amount" type="text">
                      </div>
                    </div>
                  </div>
                
                </div>
                
                <div class="form-actions right">
                  <button type="button" class="btn btn-circle blue" onclick="createProveedor()" id="buttonCreate">
                    <i class="fa fa-check"></i> Guardar
                  </button>
                  <div id="manufacturers_id" style="display: none;"></div>
                </div>
              </form>
              <!-- END FORM-->
            
            </div>
          </div>
        </div>
      </div>
    </div>





  </div>
</div>

@include('utils.form_masks')
<script type="text/javascript">
    var root_url = $('#root_url').attr('content');
    $(document).ready(function(){
        $('#sidebar_supplier').addClass('active');
    });

    //Set active tab from local storage
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('supplier_active_tab', $(e.target).attr('href'));
        localStorage.setItem('from_supplier_index', false);
    });
    
    //We copy every select selected option value into a hidden input
    $('.drop-down').change(function(){
        let select_val = $(this).val();
        $('#' + $(this).attr('id') + '_hidden').val(select_val);
    });

    $('#countries_id').change(function(){
        loadStates();
    });

    /*Loads states based on country id*/
    function loadStates()
    {
        let country_id = $('#countries_id').val();

        $.ajax({
            url: root_url + '/country-states',
            method: 'get',
            dataType: 'json',
            data: {'country_id': country_id},
            success: function(response) {

                //Enable/Disable state select/state_name input based in selected country
                let state_select = $('#states_id');
                let state_name = $('#state_name');
                state_select.prop('disabled', response.disabled);
                state_name.prop('disabled', !response.disabled);

                if(response.disabled) { 
                    $('#states_id').hide();
                    $('#state_name').show(); 
                }
                else { 
                    $('#states_id').show();
                    $('#state_name').hide(); 
                }

                $.each(response.states, function(id, name) {
                    state_select.append('<option value="' + id +'" >' + name + '</option>');
                });

            }
        });
    }

function createProveedor() {
  let textError = [];
  let error = 0;
  let trade_name = $('#trade_name').val();
  let countries_id = $('#countries_id').val();
  let email = $('#email').val();
  let languages_id = $('#languages_id').val();
  let landline = $('#landline').val();
  let mobile = $('#mobile').val();
  let currencies_id = $('#currencies_id').val();
  let marketplace = $('#marketplace').val();
  let type = $('#type').val();
  let business_name = $('#business_name').val();
  let states_id = $('#states_id').val();
  let rfc = $('#rfc').val();
  let city = $('#city').val();
  let post_code = $('#post_code').val();
  let street = $('#street').val();
  let contact_name = $('#contact_name').val();
  let street_number = $('#street_number').val();
  let unit_number = $('#unit_number').val();
  let credit_days = $('#credit_days').val();
  let suburb = $('#suburb').val();
  let credit_amount = $('#credit_amount').val();
  let state = $('#states_id').find('option:selected').text();
  let set_id_id = $('#set_id_id').html();
  let manufacturer = $('#manufacturers_id').html();


  
  if (trade_name == '') {
    error = 1;
    textError.push('Nombre comercial es requerido');
  }
  if (countries_id == '') {
    error = 1;
    textError.push('Pais es requerido');
  }
  if (email == '') {
    error = 1;
    textError.push('Correo electrónico es requerido');
  }
  if (email == '') {
    error = 1;
    textError.push('Idioma es requerido');
  }
  if (landline == '') {
    error = 1;
    textError.push('Teléfono fijo es requerido');
  }
  if (type == '') {
    error = 1;
    textError.push('Tipo de proveedor es requerido');
  }
  if (post_code == '') {
    error = 1;
    textError.push('Código postal es requerido');
  }

  if (error != 1) {
    let token = $('input[name=_token]').val();
    
    $.ajax({
        url: root_url + '/supplier/ajaxstore',
        method: 'post',
        dataType: 'json',
        data: {
          'trade_name'    :trade_name,
          'countries_id'  :countries_id,
          'email'         :email,
          'languages_id'  :languages_id,
          'landline'      :landline,
          'mobile'        :mobile,
          'currencies_id' :currencies_id,
          'marketplace'   :marketplace,
          'type'          :type,
          'business_name' :business_name,
          'states_id'     :states_id,
          'rfc'           :rfc,
          'city'          :city,
          'post_code'     :post_code,
          'street'        :street,
          'contact_name'  :contact_name,
          'street_number' :street_number,
          'unit_number'   :unit_number,
          'credit_days'   :credit_days,
          'suburb'        :suburb,
          'credit_amount' :credit_amount,
          'state'         :state,
          'manufacturer'  :manufacturer,
        },
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
          if (response.errors == false) {
            var html = '<li>'+response.message+'</li>';
            $('#pct_edit_modal_success_messages1').css("display", "");
            $('#success_text_proveedor').html( html );

            $('#pct_edit_modal_success_messages2').css("display", "");
            $('#espera_text_proveedor').html( '<li>Se estan actualizando los proveedores, espere un momento</li>' );
            
            $('#buttonCreate').prop('disabled', true);
            
            
            $('#tab_0').attr("href", '');
    
            //Set tabs
            $.ajax({
              url: root_url + '/inbox/get-set-tabs/' + set_id_id,
              method: 'get',
              dataType: 'json',
              success: function(response) {
                
                $('#tab_budget_content').html(response.budget_tab);
                $('#budget_tab_suppliers_select').select2({
                  dropdownParent: $('#edit_set_modal')
                }).on('change', function() {
                  $.ajax({
                    url: root_url + '/supplier/checksupplier',
                    method: 'get',
                    dataType: 'json',
                    data: {
                      'id': $('#budget_tab_suppliers_select').val(),
                      'document': set_id_id
                    },
                    success: function(response) {
                      if (response.message != 1) {
                        $('#pct_edit_modal_error_messages').html('<div class="custom-alerts alert alert-danger fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>El proveedor seleccionado no esta asociado a la marca del articulo.</div>');
                        $('#in_authorization_btn').prop('disabled', true);
                        $('#buttonBudgetSave').prop('disabled', true);
                      } else{
                        $('#pct_edit_modal_error_messages').html('');
                        $('#in_authorization_btn').prop('disabled', false);
                        $('#buttonBudgetSave').prop('disabled', false);
                      }
                    }
                  });
                });

                $('#espera_text_proveedor').html( '<li>Ya puede seguir trabajando en la parte</li>' );
            
                $('#tab_0').attr("href", '#tab_budget_content');

              }
            });
          } else {
            var html = '<li>'+response.message+'</li>';
            $('#pct_edit_modal_error_messages1').css("display", "");
            $('#error_text_proveedor').html( html );
          }
        }
    });
  } else {
    let html = '';
    textError.forEach(function(text) {
      html += '<li>'+text+'</li>';
    });
    $('#pct_edit_modal_error_messages1').css("display", "");
    $('#error_text_proveedor').html( html );
  }
}

</script>
