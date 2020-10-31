@extends('welcome')
@section('contenido')
      <!--/ Nav Star /-->
  @include('page.navbar')
  <!--/ Nav End /-->
  <!--/ bienvenido Star /-->
  @include('page.bienvenido')
  <!--/ bienvenido end /-->
  @if(session()->has('create'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="row">
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong></strong> {{ session('create') }}
            </div>
        </div>
    </div>
  @endif

  @guest
    @include('page.nosotros')

  @else
    @role('cliente')
      @include('page.nosotros')
    @endrole  
  @endguest

  @include('components.frmPedido')
  
@endsection