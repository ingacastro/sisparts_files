@extends('layouts.auth.master')
@section('content')
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="/metronic-assets/pages/img/logo-big.png" alt="" />
    </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <h3 class="font-green">Recuperar contraseña</h3>
        <p> Ingresa to correo electrónico para restablecer tu contraseña. </p>
        <div class="form-group">
            <input type="email" autocomplete="off" placeholder="Correo electrónico" 
            name="email" class="placeholder-no-fix form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required/> 
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <a href="{{ route('login') }}" id="back-btn" class="btn green btn-outline">Regresar</a>
            <button type="submit" class="btn btn-success uppercase pull-right">Enviar</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
@endsection

