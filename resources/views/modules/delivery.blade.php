<div>
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">{{ $title }}</h1>
            <span class="color-text-a">{{ $subtitle }}</span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Properties Grid
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

  @if ($listaMenu->count())
    <section class="property-grid grid">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="grid-option">
              <form>
                <input type="text" wire:model='searchText'>
              </form>
            </div>
          </div>
          @foreach ($listaMenu as $menu)
          <div class="col-md-4">

            <div class="card-box-a card-shadow" style="object-fit: scale-down">
              <div class="img-box-a caja" >
                <img src="{{ asset($menu->foto) }}" alt="" class="img-a img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-overlay-a-content">
                  <div class="card-header-a">
                    <h2 class="card-title-a">
                      <a href="#">{{ $menu->nombre }}
                        <br /> </a>
                    </h2>
                  </div>
                  <div class="card-body-a">
                    <div class="price-box d-flex">
                      <span class="price-a">Precio | {{ $menu->precio }}</span>
                    </div>
                    <a href="#producto" data-toggle="modal" data-target="#ejemplo{{ $menu->idProducto }}" class="link-a">Ordenar
                      <span class="ion-ios-arrow-forward"></span>
                    </a>
                  </div>
                  <div class="card-footer-a">
                  
                  </div>
                </div>
              </div>
            </div>
            {{-- Modal --}}
            <div wire:ignore.self id="ejemplo{{ $menu->idProducto }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
              <div class="modal-dialog modal-md" role="document">
                  <div class="modal-content">
                      <div class="modal-header alert-default-info">
                          <h5 class="modal-title" id="my-modal-title">
                              <div class="img-avatar align-items-center text-center">
                                  <img  width="100%"  class="img-fluid" src="{{ $menu->foto }}" alt="">
                              </div>
                              
                          </h5>

                          <button class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="card-header text-center">
                          <p>
                              <strong>{{ $menu->nombre }}</strong>
                          </p>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                              <label for="">Cuantos Desea Ordenar?</label>
                              <input id='cantidad{{$menu->idProducto}}' type="number" class="form-control" >
                              @error('cantidad')
                                  {{ $message }}
                              @enderror
                          </div>
                      </div>
                      <div class="modal-footer text-center">
                          <button onclick='agregarAlDetalle({{ $menu }})' 
                              class="close" data-dismiss="modal" aria-label="Close" type="submit" class="btn btn-info btn-sm">Agregar al Pedido</button>
                      </div>
                  </div>
              </div>
            </div> 
          </div>

          @endforeach
          <style>
            .caja{
              /* background-color: #000 ; */
            }
            .caja img{
              min-width: 700px;
              max-width: 750px;
              min-height: 350px;
              max-height: 350px;
              object-fit: cover;
            }
          </style>
          
        </div>
        <div class="row">
          <div class="col-sm-12">
          {{ $listaMenu->render() }}
          </div>
        </div>
      </div>
    </section>  
  @else
    <div class="border">
      <h5 class="title">Perdona las molestias aun no hemos realizado el menu del dia de hoy</h5>
    </div>  
  @endif
</div>
@section('detalle')
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

        iziToast.success({
                            title: 'Exito!',
                            message: arrayProducto,
                    });
        

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
@endsection