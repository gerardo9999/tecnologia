    <section id="menu" class="intro-single">
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-lg-12">
              <div class="title-single-box">

                <h1 class="title-single">Nuestros Productos</h1>
              
                <div class="title-single-box p-4 text-center">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="grid-option">
                                <select wire:model='categoria' class="custom-select">
                                @foreach (@menuCategoria() as $item)
                                    <option selected>{{ $item->nombre }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="buscarpor" placeholder="Buscar Producto" wire:model='searchText'>
                         </div>
                        
                            

                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    
    @guest
        <section class="property-grid grid">
            <div class="container">

                <div class="row">
                    @foreach (@listaMenu() as $lista)
                        <div class="col-md-6">

                                <div class="col-md-12">
                                    <div class="card-box-a card-shadow">
                                        <div class="img-box-a">
                                            <img src="{{ asset($lista->foto) }}" alt="" class="img-a img-fluid">
                                        </div>
                                        <div class="card-overlay">
                                            <div class="card-overlay-a-content">
                                                <div class="card-header-a">
                                                    <h2 class="card-title-a">
                                                    </h2>
                                                </div>
                                                <div class="card-body-a">
                                                    <div class="price-box d-flex">
                                                        <span class="price-a">{{ $lista->precio }} .Bs</span>
                                                    </div>
                                                    <a href="#producto" data-toggle="modal" data-target="#ejemplo{{ $lista->idProducto }}" class="link-a">{{ $lista->nombre }}
                                                        <span class="ion-ios-arrow-forward"></span>
                                                    </a>
                                                </div>
                                                <div class="card-footer-a">
                                                    <ul class="card-info d-flex justify-content-around">
                                                        <li>
                                                        <h4 class="card-info-title">Categoria</h4>
                                                        <span>{{ $lista->categoria}}
                                                        </span>
                                                        </li>
                                                        <li>
                                                        <h4 class="card-info-title">Precio</h4>
                                                        <span>{{ $lista->precio }} .Bs</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div wire:ignore.self id="ejemplo{{ $lista->idProducto }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header alert-default-info">
                                                <h5 class="modal-title" id="my-modal-title">
                                                    <div class="img-avatar align-items-center text-center">
                                                        <img height="200px" width="100%"  class="img-fluid" src="{{ $lista->foto }}" alt="">
                                                    </div>
                                                    
                                                </h5>

                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="card-header text-center">
                                                <p>
                                                    <strong>{{ $lista->nombre }}</strong>
                                                </p>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="">Cuantos Desea Ordenar?</label>
                                                    <input id='cantidad{{$lista->idProducto}}' type="number" class="form-control" >
                                                    @error('cantidad')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button onclick='agregarAlDetalle({{ $lista }})' 
                                                    class="close" data-dismiss="modal" aria-label="Close" type="submit" class="btn btn-info btn-sm">Agregar al Pedido</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                        </div>
            
                    @endforeach
                </div>
            </div>
        </section>
    @else
        @role('cliente')
            <section class="property-grid grid">
                    <div class="container">

                        <div class="row">
                            @foreach (@listaMenu() as $lista)
                                <div class="col-md-6">

                                        <div class="col-md-12">
                                            <div class="card-box-a card-shadow">
                                                <div class="img-box-a">
                                                    <img src="{{ asset($lista->foto) }}" alt="" class="img-a img-fluid">
                                                </div>
                                                <div class="card-overlay">
                                                    <div class="card-overlay-a-content">
                                                        <div class="card-header-a">
                                                            <h2 class="card-title-a">
                                                            </h2>
                                                        </div>
                                                        <div class="card-body-a">
                                                            <div class="price-box d-flex">
                                                                <span class="price-a">{{ $lista->precio }} .Bs</span>
                                                            </div>
                                                            <a href="#producto" data-toggle="modal" data-target="#ejemplo{{ $lista->idProducto }}" class="link-a">{{ $lista->nombre }}
                                                                <span class="ion-ios-arrow-forward"></span>
                                                            </a>
                                                        </div>
                                                        <div class="card-footer-a">
                                                            <ul class="card-info d-flex justify-content-around">
                                                                <li>
                                                                <h4 class="card-info-title">Categoria</h4>
                                                                <span>{{ $lista->categoria}}
                                                                </span>
                                                                </li>
                                                                <li>
                                                                <h4 class="card-info-title">Precio</h4>
                                                                <span>{{ $lista->precio }} .Bs</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div wire:ignore.self id="ejemplo{{ $lista->idProducto }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header alert-default-info">
                                                        <h5 class="modal-title" id="my-modal-title">
                                                            <div class="img-avatar align-items-center text-center">
                                                                <img height="200px" width="100%"  class="img-fluid" src="{{ $lista->foto }}" alt="">
                                                            </div>
                                                            
                                                        </h5>

                                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="card-header text-center">
                                                        <p>
                                                            <strong>{{ $lista->nombre }}</strong>
                                                        </p>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="">Cuantos Desea Ordenar?</label>
                                                            <input id='cantidad{{$lista->idProducto}}' type="number" class="form-control" >
                                                            @error('cantidad')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer text-center">
                                                        <button onclick='agregarAlDetalle({{ $lista }})' 
                                                            class="close" data-dismiss="modal" aria-label="Close" type="submit" class="btn btn-info btn-sm">Agregar al Pedido</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                </div>
                    
                            @endforeach
                        </div>
                    </div>
            </section>
        @endrole
        
    @endguest
    
       
    <!-- Modal -->
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
                <button  style=" border-radius: 6px !important; font-size: 16px; width:220px;"  
                type="button" name="confir_ubv" id="confir_ubv" 
                Onclick="addUbicacion(longitud.value,latitud.value,txtDir.value); " 
                class="btn btn-success btn-lg verde" data-dismiss="modal"  >ACEPTAR</button>
            </div>
        </div>
        
        </div>
    </div>