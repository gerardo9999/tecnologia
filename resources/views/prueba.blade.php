@extends('welcome')
@section('contenido')
                                    <div class="form-group">
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
                                    <input type="text" id="textTiempo">
                                    </div>
                                        <button type="button" class="btn btn-sm btn-success" data-target="#maps" data-toggle="modal">Envianos tu Ubicacion</button>


<div class="modal fade" id="maps" role="dialog">
    <div class="modal-dialog modal-lg">    
    <!-- Modal content-->
    <div class="modal-content" id="modalcon" >
        <div class="modal-header" >         
        <h3 align="center" style="width:100%; padding: 0px;">Indica tu dirección 
        <!--
            <img src="../Resources/img/grido-logo.png" alt="Logo" style="width:80px;">
        -->
        </h3>
        </div>
        <div class="modal-body">
        <div id="div_maps" >
            <!--  GOOGLE MAPS-->
            <div id="map"></div>

            <div style="display:none">
                Nueva Ubiv.<input type="text" id="coords" />
                <br>
                Latitud <input class="xy" type="text"  id="longitud" name="longitud" />
                <br>
                Longitud <input class="xy" type="text" id="latitud" name="latitud" />
                <br>
                <br>
            </div>
            <div class="clearfix"></div>

            <div id="ayuda" align="center">

            <p id="nomDir">
            <!--<b>No es tu ubicacion ? </b><small style="font-size: 10px;" >Recuerda que puedes modificar tu ubicación moviendo el icono que indica donde estas ahora. </small>
            -->
            </p> 

            </div>
            <input  type="text" id="txtDir" name="txtDir" style="display:none">        
            <!-- END ,MAPS -->
        </div>

        <div class="clearfix"></div>
            <div class="alert alert-info" style="padding: 5px; margin-bottom: 0px;" align="center" >
            <b> Verifique su ubicación exacta para recibir su pedido</b>
            </div> 
        </div>

        <div class="modal-footer" stye="text-align: center !important;">
            <button  type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
            <button  style=" border-radius: 6px !important; font-size: 16px; width:220px;"  type="button" name="confir_ubv" id="confir_ubv" Onclick="addUbicacion(longitud.value,latitud.value,txtDir.value); " class="btn btn-success btn-lg verde" data-dismiss="modal"  >ACEPTAR</button>
        </div>
    </div>
    
    </div>

</div>
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
@endsection

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
                    lng: '-17.34981426967225',
                    lat: '-63.262442186041355'
                };
                document.getElementById("longitud").value = '-17.34981426967225';
                document.getElementById("latitud").value =  '-63.262442186041355';
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
        function addUbicacion(x,y,dir)
    {
        document.getElementById("textlatitud").value=x+"";

        document.getElementById("textlongitud").value=y+"";

        //document.getElementById("textdescripcion").value=dir+"";

        document.getElementById("textlink").value="https://maps.google.com/?q="+y+","+x;

        let latitud1=-63.262442186041355;//latitud del resturante
        let longitud1=-17.34981426967225;//longitud del restaurante

        // let latitud2=x; //latitud del destino
        // let longitud2=y;//longitud del destino

        let latitud2=-64.262442186041355;
        let longitud2=-18.34981426967225;
    
        (calculateDistance(latitud1,longitud1,latitud2,longitud2));//funcion para calcular la distancia en kilometro

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
            $('#textTiempo').val(resultado);//tiempo aproximdao
            
        }
    </script>
@endsection