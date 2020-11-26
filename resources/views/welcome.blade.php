<!DOCTYPE html>
<html lang="en">
@include('page.head')

<body>
  <div class="click-closed"></div>
    <!--/ Form Search Star /-->
    <div class="box-collapse">


      @auth
        @role('cliente')
              
          <div id="title-reservacion" style="display: none"; >
            <div class="title-box-d">
              <h3 class="title-d">Realice su Reservacion</h3>
            </div>
          </div>
          <div id="title-pedido" style="display: none"; >
            <div class="title-box-d">
              <h3 class="title-d">Mi Pedido </h3>
            </div>
          </div>
        @endrole
        
        @role('administrador')
          <div id="title-pedido"; >
            <div class="title-box-d">
              <h3 class="title-d">Lista de Reservaciones</h3>
            </div>
          </div>
        @endrole

        @role('repartidor')
          <div id="title-pedido" style="display: none"; >
            <div class="title-box-d">
              <h3 class="title-d">Lista de Reservaciones</h3>
            </div>
          </div>
        @endrole
        
      @else
        <div id="title-reservacion" style="display: none"; >
          <div class="title-box-d">
            <h3 class="title-d">Realice su Reservacion</h3>
          </div>
        </div>
        
        <div id="title-pedido" style="display: none"; >
          <div class="title-box-d">
            <h3 class="title-d">Mi Pedido</h3> <b></b>
          </div>
        </div>
      @endauth

      

      <span class="close-box-collapse right-boxed ion-ios-close"></span>

      <div class="box-collapse-wrap form">

        <div id="reservacion" style="display: none;" >
          <livewire:reservacion>
        </div>
        <div id="pedido" style="display: none;">
          @include('modules.pedido')
        </div>
      </div>
      
  @yield('contenido')


  <!--/ Footer End /-->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  {{-- @include('page.footer') --}}

  @include('page.scripts')

</body>
</html>