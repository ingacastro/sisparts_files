<?php 
$model_exist = isset($model);
$first_row_cols = $model_exist ? [3, 5, 1, 3] : [1, 9, 1, 1];
$second_row_cols = $model_exist ? [3, 6, 3] : [1, 10, 1];
?>
<div class="form-body">
    <div class="row">
    	<div class="col-md-{{$first_row_cols[0]}}"></div>
	    <div class="col-md-{{$first_row_cols[1]}}">
	        <label for="brands_select2" class="control-label">Marca</label>
	        {!! Form::select(null, [], null, 
                ['class' => 'form-control input-sm select2-multiple', 'id' => 'brands_select2',
                'style' => 'width: 100%']) !!}
	    </div>
	    <div class="col-md-{{$first_row_cols[2]}}">
	        <button id="add_brand" type="button" class="btn btn-circle green" style="margin-top: 25px">
				<i class="fa fa-plus"></i> Agregar</button>
		</div>
		<div class="col-md-{{$first_row_cols[3]}}"></div>
    </div>
    <div class="row" style="margin-top: 20px">
    	<div class="col-md-{{$second_row_cols[0]}}"></div>
    	<div class="col-md-{{$second_row_cols[1]}}">
		    <table class="table table-striped table-hover table-bordered" id="brands_table" style="width: 100%">
				<thead>
				    <tr>
				    	<th>Id</th>
				        <th>Nombre</th>
				        <th>Acciones</th>
				    </tr>
				</thead>
				<tbody>
					@if($model_exist)
					@foreach($model->brands as $brand)
					<tr id="row_{{ $brand->id }}">
						<td>{{ $brand->id }}</td>
						<td>{{ $brand->name }}</td>
						<td><a class="remove-brand" id="{{ $brand->id }}">Eliminar</a></td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<div class="col-md-{{$second_row_cols[2]}}"></div>
    </div>
</div>
@if($model_exist)
<div class="form-actions right">
    <a href="{{ route('supplier.index') }}" class="btn btn-circle default">{{ isset($cancel_btn) ? $cancel_btn : 'Cancelar' }}</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>
@endif
