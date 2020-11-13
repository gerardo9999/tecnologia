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

        
        <div id="pedido" style="display: none;">
          

          <div class="row">
            
            <form action="{{route('pedido.store')}}" method="post" autocomplete="off">
                @csrf
               <div id="divfor" style="display: block">
                <div class="border p-2">
                    <div class="form-group">
                      <label for="" >Fecha de Entrega</label>
                      <input id="fecha_entrega" 
                      onchange="fechaPedido(this.value)" value="{{ date('Y-m-d') }}" type="date" 
                      name="fecha_entrega" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                      <label for="" >Referencia</label>
                      <input type="text" name="referencia" class="form-control form-control-sm">
                    </div>
                    <div class="form-group" id="inputHora" style='display: none;'>
                      <label for="" >Hora Entrega</label>
                      <input id="horaLlegada" 
                      onchange="setearHora(this.value)" value='' type="time" name="hora_entrega" 
                      class="form-control form-control-sm">
                    </div>
                    {{-- inputHora --}}
                </div>
               
              <div id="tabla-pedido">
                <div class="card-body">
                    <div class="row">
                        
                        <div class="table-responsive-sm">
                            <table id="detalles" class="table table-hover table-hover table-bordered">
                                <thead class="">
                                <th>Opciones</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio </th>
                                <th>Subtotal</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <h6 id="total"> Bs/. 0.00</h6>
                                </th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
              </div>

                <div id="montoTotal">

                </div>

                <!-- Ubicacion -->
                <div style="display:block;">
                  <div class="form-group" >
                    <input type="text"  class="form-control" readonly required placeholder="latitud" name="textlatitud" id="textlatitud">
                  </div>
                  <div class="form-group">
                    <input type="text"  class="form-control" readonly required placeholder="Longitud" name="textlongitud" id="textlongitud">
                  </div>
                  <div class="form-group">
                    <input type="text"  class="form-control" readonly required placeholder="Ubicación" name="textlink" id="textlink">
                  </div>
                  <div class="form-group">
                      <label for="" class="form-label">Distancia /KM</label>
                      <input  type="number" readonly class="form-control" name="textDistancia" id="textDistancia" >
                  </div>
                  <div class="form-group">
                    <label for=""  class="form-label">Tiempo</label>
                    <input name="tiempo" type="text" id="textTiempo">
                  </div>
                </div>
              </div> 



                  <div style="display:none;" class="form-group" id="guardar">

                    @auth
                      <button name="guardar" value="auth" type="submit" class="btn btn-sm  btn-outline-danger ">Realizar Pedido</button>
                    
                    
                    @else
                      
                      <div class="datoPersona">
                        <!-- Button trigger modal -->
  


                      </div>
                    

                    @endauth                  
                  </div>
            </form>

            <button id="boton-realizar-pedido" name="guardar" value="guest" type="submit" class="btn btn-sm btn-block btn-outline-danger" style="display: none">Realizar Pedido</button>
            
            {{-- <div class="border">
            </div> --}}
              @guest
              <button id="boton-datos" onclick="mostrarDatos()" style="display: none" type="button" class="btn btn-sm btn-success btn-block" >
                Envianos tus Datos Personales
              </button>
              @endguest

            <button type="button" class="btn btn-sm btn-success btn-block" data-target="#maps" data-toggle="modal">Envianos tu Ubicacion</button>
    

            <style> 
              @media(max-width: 700px){
              #div_maps {
                      
                      height: 320px;
                  
                  }
  
              }
  
              @media(min-width: 700px){
              #div_maps {
                      height: 380px;
                  
                  }
  
              }
              
              #map {
              width: 100%;
              height: 90%;
  
              }
              
              #modalcon{
                  color: #16438e;
                  line-height: 1.42857143;
                  font-family: "Frank";
              }
  
            </style>
      
            {{-- @include('page.gps-css') --}}

              @section('map')
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoW4LyeLOiPgOmChMyAacirIgO7zqriGw&callback=initMap&libraries=geometry"
                  type="text/javascript" >
                </script>
                <script> 
                
                




                  var marker;         
                  var coords = {};    
                  var x=document.getElementById("nomDir");
                  var options = {
                  enableHighAccuracy: true,
                  timeout: 6000,
                  maximumAge: 0
                  };
                  //Funcion principal
                  initMap = function () 
                  {

                      // navigator.geolocation.getCurrentPosition(viewMap,ViewError,{timeout:3000});

                      //usamos la API para geolocalizar el usuario

                          navigator.geolocation.getCurrentPosition(function (position)
                          {
                              coords =  {
                              lng: position.coords.longitude,
                              lat: position.coords.latitude,
                              };
                              document.getElementById("longitud").value = position.coords.longitude;
                              document.getElementById("latitud").value = position.coords.latitude;

                              setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
                            
                          
                          },function(error)
                          {
                          
                              // El segundo parámetro es la función de error
                              switch(error.code) 
                              {
                                  case error.PERMISSION_DENIED:
                                  // El usuario denegó el permiso para la Geolocalización.
                                  console.log(error);
                                  alert('ACTIVE SU GPS O USTED BLOQUEO EL PERMISO DE UBICACION');
                                  // initMap();
                                  break;
                                  case error.POSITION_UNAVAILABLE:
                                  // La ubicación no está disponible.
                                  console.log(error);
                                      alert('ACTIVE SU GPS Y RECARGE LA PAGINA');
                                  break;
                                  case error.TIMEOUT:
                                  // Se ha excedido el tiempo para obtener la ubicación.
                                  console.log(error);
                                      alert('ACTIVE SU GPS Y RECARGE LA PAGINA');
                                  break;
                                  case error.UNKNOWN_ERROR:
                                  // Un error desconocido.
                                  alert('INTENTE MÁS TARDE');
                                  console.log(error);
                                  break;
                              }
                              coords =  
                              {
                                  lng: '-17.334064',
                                  lat: '-63.256608'
                              };
                              document.getElementById("longitud").value = '-17.334064';
                              document.getElementById("latitud").value =  '-63.256608';
                              setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
                              
                              
                          },options);
                      
                  }
                  function setMapa (coords)
                  {   
                              //Se crea una nueva instancia del objeto mapa
                          
                          var map = new google.maps.Map(document.getElementById('map'),
                          {
                              zoom: 17,
                              center:new google.maps.LatLng(coords.lat,coords.lng),

                          });
                      
                          //Creamos el marcador en el mapa con sus propiedades
                          //para nuestro obetivo tenemos que poner el atributo draggable en true
                          //position pondremos las mismas coordenas que obtuvimos en la geolocalización
                          marker = new google.maps.Marker({
                          map: map,
                          draggable: true,
                          animation: google.maps.Animation.DROP,
                          title:"Mi ubicación actual",
                          position: new google.maps.LatLng(coords.lat,coords.lng),

                          });
                          //map.setCenter(pos);
                          //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
                          //cuando el usuario a soltado el marcador
                          marker.addListener('click', toggleBounce);
                          
                          marker.addListener( 'dragend', function (event)
                          {
                              //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                              document.getElementById("coords").value =   this.getPosition().lat()+","+ this.getPosition().lng();
                              document.getElementById("longitud").value = this.getPosition().lng();
                              document.getElementById("latitud").value =  this.getPosition().lat();




                              var long=this.getPosition().lat();
                              var lat=this.getPosition().long();

                              var locApi="https://maps.googleapis.com/maps/api/geocode/json?latlng="+long+","+lat+"&sensor=true";
                              //x.innerHTML=locApi+"<br>"+loc.loc +"<br>"+loc.city +"<br>"+loc.region +"<br>";
                              var cadena="";
                          
                              $.get({
                                  
                                  url: locApi,
                                  success:function(data)
                                  {
                                      console.log(typeof data);
                                      //console.log(data.results.length);
                                      if (data.results.length > 0) 
                                      {
                                          cadena=data.results[0].address_components[0].long_name+", ";

                                          cadena+=data.results[0].address_components[1].long_name+", ";

                                          //cadena+=data.results[0].address_components[4].long_name;
                                          x.innerHTML=cadena;
                                          document.getElementById("txtDir").value=cadena;
                                      }
                                      else
                                      {
                                          x.innerHTML="La ubicacion no se reconoce, por favor intente de nuevo";
                                      }

                                  },
                                  error:function(data)
                                  {
                                      console.log(data);
                                  }
                              });
                              
                          });
                  }
                  //callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
                  function toggleBounce() 
                      {
                          if (marker.getAnimation() !== null) 
                          {
                          marker.setAnimation(null);
                          } else 
                          {
                          marker.setAnimation(google.maps.Animation.BOUNCE);
                          }
                      }
                      function addUbicacion(x,y,dir){

                      document.getElementById('guardar').style.display="block";
                      //document.getElementById('boton-datos').style.display="block";
                      document.getElementById('divfor').style.display="block";



                      document.getElementById("textlatitud").value=x+"";
                      document.getElementById("textlongitud").value=y+"";
                      //document.getElementById("textdescripcion").value=dir+"";

                      document.getElementById("textlink").value="https://maps.google.com/?q="+y+","+x;

                      let latitud1=-63.256608;//latitud del resturante
                      let longitud1=-17.334064;//longitud del restaurante

                      let latitud2  =x; //latitud del destino
                      let longitud2 =y;//longitud del destino

                      //let latitud2=-64.262442186041355;
                      //let longitud2=-18.34981426967225;
                
                      (calculateDistance(latitud1,longitud1,latitud2,longitud2));
                      //funcion para calcular la distancia en kilometro

                  }
                  function calculateDistance(lt1,lng1,lt2,lng2) {

                      var origin = new google.maps.LatLng(lng1, lt1);

                      var destination = new google.maps.LatLng(lng2, lt2);

                      var service = new google.maps.DistanceMatrixService();
                      service.getDistanceMatrix(
                          {
                              origins: [origin],
                              destinations: [destination],
                              travelMode: google.maps.TravelMode.DRIVING,
                              //unitSystem: google.maps.UnitSystem.IMPERIAL, // millas y pies.
                              unitSystem: google.maps.UnitSystem.metric, // kilometros y metros
                              avoidHighways: false,
                              avoidTolls: false
                          }, callback);
                      }

                      function callback(response, status) 
                      {
                      if (status != google.maps.DistanceMatrixStatus.OK) 
                      {
                          console.log(origin);
                      } else 
                      {
                          var origin = response.originAddresses[0];
                          var destination = response.destinationAddresses[0];
                          if (response.rows[0].elements[0].status === "ZERO_RESULTS") 
                          {
                              $('#textTiempo').val("No hay distancia para  "  + origin + " and " + destination);
                              console.log(origin);
                          } else 
                          {
                              var distance = response.rows[0].elements[0].distance;
                              var duration = response.rows[0].elements[0].duration;
                              var distanciaKilometro = distance.value / 1000; // Kilometro
                              //var distanciaMillas = distance.value / 1609.34; // millas
                              var duracionText = duration.text; //tiempo en formato (1 hours 50 min) (1 h 6 min)
                              //aumentamos 10 minutos de preparacion que son 600 segundos 
                              var duracionValue = duration.value + 600;// tiempo en formato solo segundos 
                              
                              
                              $('#textDistancia').val(distanciaKilometro.toFixed(2));//distancia en km
                              
                              //llamamos a la funcion para calcular el precio de acuerdo a km
                              // recargoPedido(distanciaKilometro);
                              // //llamamos a la funcion para calcular el tiempo
                              convertirSegundosAhoraMinutos(duracionValue);
                                
                          }

                      }
                      }
                      function convertirSegundosAhoraMinutos(seconds) 
                      {
                          var hour = Math.floor(seconds / 3600);
                          hour = (hour < 10)? '0' + hour : hour;
                          var minute = Math.floor((seconds / 60) % 60);
                          minute = (minute < 10)? '0' + minute : minute;
                          var second = seconds % 60;
                          second = (second < 10)? '0' + second : second;
                          resultado= hour + ':' + minute + ':' + second;
                          $('#textTiempo').val(resultado);
                          //tiempo aproximdao
                          
                      }
                </script>
              @endsection  
            </div>

          </div>
        </div>
      </div>
      
  @yield('contenido')


  <!--/ Footer End /-->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="nav-footer">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#">Home</a>
              </li>
              <li class="list-inline-item">
                <a href="#">About</a>
              </li>
              <li class="list-inline-item">
                <a href="#">Property</a>
              </li>
              <li class="list-inline-item">
                <a href="#">Blog</a>
              </li>
              <li class="list-inline-item">
                <a href="#">Contact</a>
              </li>
            </ul>
          </nav>
          <div class="socials-a">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <i class="fa fa-dribbble" aria-hidden="true"></i>
                </a>
              </li>
            </ul>
          </div>
          <div class="copyright-footer">
            <p class="copyright color-text-a">
              &copy; Copyright
              <span class="color-a">EstateAgency</span> All Rights Reserved.
            </p>
          </div>
          <div class="credits">
            <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=EstateAgency
            -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div>
        </div>
      </div>
    </div>
  </footer>


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
                                  <td><button type="button" class="btn btn-outline-warning" onclick="eliminar(${cont});">X</button></td>
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