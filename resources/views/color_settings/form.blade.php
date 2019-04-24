<div class="mt-bootstrap-tables">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                @if($color_settings->count() == 0) 
                    No se estableció la configuración
                @else
                <div class="portlet-body">
                    <table style="width: 80%; margin: 0 auto">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Días</th>
                                <th>Correos a notificar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($color_settings as $setting)
                            <tr>
                                <td style="width: 50px !important;">
                                    <input type="hidden" value="{{ $setting->id }}" name="settings[{{ $setting->id }}][id]">
                                    <div class="form-group">
                                        <div class="form-control" style="background-color: {{ $setting->color }}; width: 34px; height: 34px"></div>
                                    </div>
                                </td>
                                <td style="width: 100px !important; padding-right: 16px">
                                    <div class="form-group">
                                        {!! Form::text('settings[' . $setting->id . '][days]', $setting->days, ['class' => 'form-control integer-mask', 'id' => 'days_' . $setting->id, 'autocomplete' => 'off'])!!}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" name="settings[{{ $setting->id }}][emails]" class="form-control input-large" 
                                        value="{{ $setting->emails }}" data-role="tagsinput">
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>