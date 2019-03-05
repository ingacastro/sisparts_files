<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="name">Nombre</label>
                {!! Form::text('user[name]', $user->name, ['class' => 'form-control', 'id' => 'name'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="number">Numero Empleado</label>
                {!! Form::text('employee[number]', $employee->name, ['class' => 'form-control', 'id' => 'name'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="role">Rol</label>
                {!! Form::select('role', [1 => 'admin', 2 => 'cotizador'], null, 
                ['placeholder' => 'Seleccionar...', 'class' => 'form-control', 'id' => 'role']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="buyer_number">Numero comprador</label>
                {!! Form::text('employee[buyer_number]', $employee->buyer_number, ['class' => 'form-control', 'id' => 'buyer_number'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="seller_number">Numero vendedor</label>
                {!! Form::text('employee[seller_number]', $employee->seller_number, ['class' => 'form-control', 'id' => 'seller_number'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="email">Correl electrónico</label>
                {!! Form::text('user[email]', $user->email, ['class' => 'form-control', 'id' => 'email'])!!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="password">Contraseña</label>
                {!! Form::password('user[password]', ['class' => 'form-control', 'id' => 'password'])!!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="password_confirm">Confirmar contraseña</label>
                {!! Form::password('user[password_confirmation]', ['class' => 'form-control', 'id' => 'password_confirm'])!!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions right">
    <button type="button" class="btn btn-circle default">Cancelar</button>
    <button type="submit" class="btn btn-circle blue">
        <i class="fa fa-check"></i> Guardar</button>
</div>