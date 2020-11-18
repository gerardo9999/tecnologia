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
              <h3 class="title-d">Mi Pedido</h3>
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
            <h3 class="title-d">Mi Pedido</h3>
          </div>
        </div>
      @endauth

      

      <span class="close-box-collapse right-boxed ion-ios-close"></span>

      <div class="box-collapse-wrap form">
        

        <div id="reservacion" style="display: none;" >
          <livewire:reservacion>
        </div>

        @include('modules.pedido')
      </div>
      
  @yield('contenido')


  <!--/ Footer End /-->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  {{-- @include('page.footer') --}}

  @include('page.scripts')
  <script>    
    this.arrayProducto = [];
    function agregar(idProducto) {
      console.log(idProducto);
    }

    var cont      = 0;
        total     = 0;
        subtotal  = [];

    function validar(producto){
      var sw = false;
      for (let index = 0; index < arrayProducto.length; index++) {
          const element = arrayProducto[index];
          console.log(element);
          if(element == producto.idProducto){
           sw = true;
          }
        }
        return sw;
    }
    function  agregarAlDetalle(producto) {

        if(validar(producto)){
         alert("El producto ya fue añadido");
        }else{
          arrayProducto.push(producto.idProducto);

          

          console.log(producto);
          var productoCantidad = document.getElementById('cantidad'+producto.idProducto).value;
          subtotal[cont] = (productoCantidad * producto.precio);
                  total = total + subtotal[cont];


          console.log(producto);
          console.log(subtotal);
          console.log(total);
          console.log(productoCantidad);
          var fila = `<tr class="selected" id="fila${cont}">
                                  <td><button type="button" class="btn btn-danger" onclick="eliminar(${cont});"><i class="fa fa-trush"></i></button></td>
                                  <td>${producto.nombre}</td>

                                  <td><input readonly type="number" id="${cont}" name="cantidad[]" value="${productoCantidad}"  class="form-control"></td>
                                  <td><input type="number" readonly name="precio[]" value="${producto.precio}"  class="form-control"></td>
                                  <td>${subtotal[cont]}</td>
                              </tr>
                              <input type="hidden" name="idproducto[]" value="${producto.idProducto}">
                      `;
                      // readonly
          cont++;
          evaluar(cont)
          
            var montoTotal = `<input type="hidden" name="montoTotal" value="${total}">`;

          $("#detalles").append(fila);
          
          $("#total").html("Bs/. " + total);

          $("#montoTotal").append(montoTotal)


        }
    }   

    function evaluar(cont){
        if(cont > 0){
          document.getElementById('btnPedido').style.display         = 'block';
        }else{
          document.getElementById('btnPedido').style.display         = 'none';
        }
    }

    function fechaPedido(val){
      console.log(val);
      var fechaActual =  new Date();


      var hoy = new Date();
      var dd = hoy.getDate();
      var mm = hoy.getMonth()+1;
      var yyyy = hoy.getFullYear();

      if(dd<10) {
        dd='0'+dd;
      } 

      if(mm<10) {
          mm='0'+mm;
      } 

      fechaP = yyyy + '-'+ mm +'-'+ dd;
      if (val==fechaP) {
        var horaEntregaPedido = document.getElementById('inputHora').style.display = "none";
      }else{
        var horaEntregaPedido = document.getElementById('inputHora').style.display = "block";
      }
    }

    function setearHora(val){
       
    }

    function eliminar(index){
      total = total - subtotal[index];
            $("#total").html("Bs/. " + total);
            $("#fila" + index).remove();
            evaluar();
            arrayProducto.splice(index); 
    }

    function reservacion(){
      document.getElementById('reservacion').style.display        = 'block' ;
      document.getElementById('title-reservacion').style.display  = 'block' ;
      document.getElementById('title-pedido').style.display       = 'none'  ;
      document.getElementById('pedido').style.display             = 'none'  ;
    }

    function  verPedido() {
      document.getElementById('reservacion').style.display        = 'none'  ;
      document.getElementById('title-reservacion').style.display  = 'none'  ;
      document.getElementById('title-pedido').style.display       = 'block'  ;
      document.getElementById('pedido').style.display             = 'block' ;


    }

    function mostrarDatos(){
      alert("Correcto");
    }
  </script>
</body>
</html>