<?php $is_create = !isset($user->id) ?>
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="name"><span class="required">*</span>Nombre</label>
                {!! Form::text('user[name]', $user->name, ['class' => 'form-control', 'id' => 'name',
                'autocomplete' => 'off'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="number"><span class="required">* </span>Numero Empleado</label>
                {!! Form::text('employee[number]', $employee->number, ['class' => 'form-control', 
                'id' => 'name', 'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="role"><span class="required">* </span>Rol</label>
                {!! Form::select('role_id', $selects_data['roles'], $role_id, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'role']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="buyer_number">Numero comprador</label>
                {!! Form::text('employee[buyer_number]', $employee->buyer_number, ['class' => 'form-control integer-mask', 'id' => 'buyer_number', 'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="seller_number">Numero vendedor</label>
                {!! Form::text('employee[seller_number]', $employee->seller_number, ['class' => 'form-control integer-mask', 'id' => 'seller_number', 'autocomplete' => 'off'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email"><span class="required">* </span>Correo electrónico</label>
                {!! Form::text('user[email]', $user->email, ['class' => 'form-control', 'id' => 'email',
                'autocomplete' => 'off'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="password">
                    @if($is_create)<span class="required">* </span>@endif Contraseña</label>
                {!! Form::password('user[password]', ['class' => 'form-control', 'id' => 'password'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="password_confirm">
                    @if($is_create)<span class="required">* </span>@endif Confirmar contraseña</label>
                {!! Form::password('user[password_confirmation]', ['class' => 'form-control', 'id' => 'password_confirm'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="ext">Extensión</label>
                {!! Form::text('employee[ext]', $employee->ext, ['class' => 'form-control integer-mask', 'id' => 'ext', 'autocomplete' => 'off']) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <a href="{{ route('user.index') }}" class="btn btn-circle default">Cancelar</a>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>