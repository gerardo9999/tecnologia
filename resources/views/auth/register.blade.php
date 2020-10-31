@extends('layouts.app')

@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card-group mb-0">


                    <div class="card p-4">
                        <div class="card-body">
                            <h1>Registrarse</h1>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                            {{-- Nombre --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-info"></i></span>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" placeholder="Escriba su nombre">
                            </div>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            {{-- Apellidos --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-info"></i></span>
                                <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ old('apellidos') }}" required autocomplete="apellidos" placeholder="Escriba sus Apellidos">
                            
                            </div>
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            {{-- Name --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-user"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre de usuario">
                            
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                            {{-- Email --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i>@</i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Escriba su email">
                            
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Escribir password">

                            </div>
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror


                            
                                
                            {{-- Confirmar password --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="confirmar password">
                            </div>

                            {{-- Telefono --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-phone"></i></span>
                                <input id="telefono" type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" placeholder="digite su telefono">
                            </div>

                            {{-- Direccion --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-info"></i></span>
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion') }}" required autocomplete="nombre" placeholder="Escriba su direccion">
                            </div>


                            {{-- Empresa --}}
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="icon-info"></i></span>
                                <input id="empresa" type="text" class="form-control @error('empresa') is-invalid @enderror" name="empresa" value="{{ old('empresa') }}" required autocomplete="nombre" placeholder="Escriba su empresa">
                            </div>

                            


                            <div class="row">
                                <div class="col-6">
                                <button type="submit" class="btn btn-primary px-4">Acceder</button>
                                </div>
                                <div class="col-6 text-right">
                                {{-- <button type="button" class="btn btn-link px-0">Olvidaste tu password?</button> --}}
                                </div>
                            </div>


                        </div>
                    </div>
                </form>


                <div class="card text-white bg-primary py-5 d-md-down-none" style="width:22%">
                    <div class="card-body text-center">
                            <div>
                                <h2>Restaurante 
                                 <br>"Pollos y Cuadriles Roca Chavez"</h2>
                                <br>
                                <p>Tenemos de todo para todos.
                                <br> 
                                Venga y disfrute nuestra variedad de platos con el sabor de siempre…
                                <br> 
                                🕑Horario de Atención🕑
                                <br> 
                                Lunes a Sabado : 11:00 a 21:00pm 
                                <br> 
                                Domingo : 17:00 a 22:00
                                <br>
                                25 Años Compartiendo Sabores  </p>
                                <h4>Visitanos en Facebook</h4>
                                <a href="https://www.facebook.com/rocachavezoficial/" target="_blank" class="btn btn-primary active mt-3"><i class="fa fa-facebook"></i></a>
                            </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
