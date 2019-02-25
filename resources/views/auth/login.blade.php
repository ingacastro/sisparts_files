@extends('layouts.auth.master')
@section('content')
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="/metronic-assets/pages/img/logo-big.png" alt="" /></a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{ route('login') }}" method="post">
        @csrf
        <h3 class="form-title font-green">Login</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Ingresa usuario y contraseña. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Email</label>
            <input class="form-control-solid placeholder-no-fix form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
            type="email" placeholder="Correo elctrónico" name="email" value="{{ old('email') }}" required autofocus /> 
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Contraseña</label>
            <input class="form-control-solid placeholder-no-fix form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
            type="password" autocomplete="off" placeholder="Contraseña" name="password" required /> 
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Entrar</button>
            <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" 
                {{ old('remember') ? 'checked' : '' }}/>Recordar
                <span></span>
            </label>
            <a href="{{ route('password.request') }}" id="forget-password" class="forget-password">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="{{ route('password.email') }}" method="post">
        @csrf
        <h3 class="font-green">Recuperar contraseña</h3>
        <p> Ingresa to correo electrónico para restablecer tu contraseña. </p>
        <div class="form-group">
            <input type="email" autocomplete="off" placeholder="Correo electrónico" 
            name="email" id="email" class="placeholder-no-fix form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required/> 
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">Regresar</button>
            <button type="submit" class="btn btn-success uppercase pull-right btn-primary">Enviar</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
</div>
<!-- END LOGIN -->
@endsection
