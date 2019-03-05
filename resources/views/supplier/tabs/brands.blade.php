<div class="form-body">
    <div class="row">
    	<div class="col-md-4"></div>
	    <div class="col-md-3">
	        <label for="brands_select2" class="control-label">Marca</label>
{{-- 	        <select id="brands_select2" class="form-control input-sm select2-multiple" style="width: 100%">
	        </select> --}}
	        {!! Form::select(null, [], null, 
                ['class' => 'form-control input-sm select2-multiple', 'id' => 'brands_select2',
                'style' => 'width: 100%']) !!}
	    </div>
	    <div class="col-md-1">
	        <button id="add_brand" type="button" class="btn btn-circle green" style="margin-top: 25px">
				<i class="fa fa-plus"></i> Agregar</button>
		</div>
		<div class="col-md-4"></div>
    </div>
    <div class="row" style="margin-top: 20px">
    	<div class="col-md-4"></div>
    	<div class="col-md-4">
		    <table class="table table-striped table-hover table-bordered" id="brands_table">
				<thead>
				    <tr>
				    	<th>Id</th>
				        <th>Nombre</th>
				        <th>Acciones</th>
				    </tr>
				</thead>
				<tbody>
					@foreach($model->brands as $brand)
					<tr id="row_{{ $brand->id }}">
						<td>{{ $brand->id }}</td>
						<td>{{ $brand->name }}</td>
						<td><a class="remove-brand" id="{{ $brand->id }}">Eliminar</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-4"></div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('supplier.index') }}" class="btn btn-circle default">{{ $cancel_btn }}</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>
