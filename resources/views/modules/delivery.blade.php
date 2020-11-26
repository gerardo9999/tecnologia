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
                {{-- <a href="#">Home</a> --}}
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                {{-- Properties Grid --}}
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
                <input class="form-control form-control-sm" type="text" wire:model='searchText'>
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
      <h5 class="title"></h5>
    </div>  
  @endif
</div>
@section('detalle')
<script>
  arrayProducto = [];
  arrayId       = [];
  arrayCantidad = [];
  arrayPrecio   = [];

  total    = 0;
  subTotal = [];
  count    = 0;

  function agregarAlDetalle(producto){
    var cantidad = document.getElementById('cantidad'+producto.idProducto).value;
    var idCantidad = 'cantidad'+producto.idProducto;

    if(validarCantidad(cantidad)){
      iziToast.error({
        tittle: 'Error',
        message : 'La cantidad no esta permitida'
      })
    }else{

      if (validarProducto(producto.idProducto)) {
          iziToast.error({
            tittle: 'Error',
            message : 'el producto ya fue añadido'
          });
          borrarCantidad(producto);
      }else{
        
        arrayProducto.push(producto.idProducto);

        subTotal[count] = (cantidad * producto.precio);
        total = total + subTotal[count];
        
        
        var pedido = `
            <tr class="select" id="fila${count}">
              <td><button type="button" class="btn btn-danger" onclick="eliminarPedido(${count},${producto.idProducto});"><i class="fa fa-trash"></i></button></td>
              <td>${producto.nombre}</td>
              <td><input readonly type="number" id="${count}" name="cantidad[]" value="${cantidad}"  class="form-control"></td>
              <td><input type="number" readonly name="precio[]" value="${producto.precio}"  class="form-control"></td>
              <td>${subTotal[count]}</td>
              
            </tr>
            <input type="hidden" name="idproducto[]" value="${producto.idProducto}">
 

 
        `;

        var montoTotal = `<input type="hidden" name="montoTotal" value="${total}">`;
        
          
          $("#montoTotal").html("Bs/. " + total);
          $("#total").append(montoTotal);
  

        cantidad = parseInt(cantidad);
        arrayId.push(producto.idProducto);
        arrayPrecio.push(producto.precio);
        arrayCantidad.push(cantidad);

          console.log(total);
        

        count++ ;
        // console.log(count);
        evaluar(count)
        $("#detalles").append(pedido);
        

        

        iziToast.success({
          title: "Agregado correctamente"
        })




        borrarCantidad(producto);

      }
 
    }





    
  }

  // Muestra el mensaje al insertar los datos
  function mostrarMensaje(message){
    $("#message").append("<p>"+message+"</p>");
  }

  // Muestra el boton de pedido en el navbar
  function evaluar(count){
      if (count > 0) {
        document.getElementById('btnPedido').style.display         = 'block';
      }else{
        document.getElementById('btnPedido').style.display         = 'none';
      }
  }
  
  // Valida la cantidad de producto
  function validarCantidad(cantidad){
    var sw = false;
    if(cantidad <= 0){
      sw = true;
    }
    return sw;
  }
  
  // borra la cantidad insertada de producto
  function borrarCantidad(producto){
    var cantidad = document.getElementById('cantidad'+producto.idProducto).value = null;    
  }

  // Elimina los productos del array de validacion 
  function eliminarProducto(idProducto){
    arrayAuxiliar = [];
    arrayAuxiliar = arrayProducto;
    arrayProducto = [];

    arrayAuxiliar.forEach(element => {
      if(idProducto != element){
        arrayProducto.push(element)}
    });
  }

  function validarProducto(idProducto){
    var sw = false;
    arrayProducto.forEach(element => {
      if (idProducto == element) {
        sw = true;
      }
    });

    return sw;
  }

  function  eliminarPedido(count,pedido) {
    // console.log(count);
    // console.log(pedido);
    eliminarProducto(pedido);
    total = total - subTotal[count];
            $("#total").html("Bs/. " + total);
            $("#fila" + count).remove();
            evaluar();
            arrayProducto.splice(count); 
    

    

  }

</script>
@endsection