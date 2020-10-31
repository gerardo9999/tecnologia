<section id="bienvenido">
    <div class="intro intro-carousel">
      <div id="carousel" class="owl-carousel owl-theme">
        <div class="carousel-item-a intro-item bg-image" style="background-image: url(imagenes/bienvenido.jpg)">
          <div class="overlay overlay-a"></div>
          <div class="intro-content display-table">
            <div class="table-cell">
              <div class="container">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="intro-body">
                      @auth
                        @role('cliente')
                          <p class="intro-title-top">Direccion, Montero, Av. Circunvalacion esquina Roberto Paz, Montero, Bolivia
                            <br></p>
                        @endrole
                        @role('repartidor')
                          <p class="intro-title-top">Bienvenido ...Repartidor : {{ Auth::user()->name }} 
                            <br> </p>
                        @endrole
                        @role('administrador')
                          <p class="intro-title-top">Bienvenido ... Administrador {{ Auth::user()->name }}
                            <br></p>
                        @endrole
                      @else
                        <p class="intro-title-top">Direccion, Montero, Av. Circunvalacion esquina Roberto Paz, Montero, Bolivia
                          <br> N#</p>
                      @endauth
                      
                      <h1 class="intro-title mb-4">
                        <span class="color-b"> </span> 
                        @auth
                          
                          @role('cliente')
                            <br> Estamos esperandote</h1>
                              <p class="intro-subtitle intro-price">
                                <a href="#" onclick='reservacion()' class="btn navbar-toggle-box-collapse" data-toggle="collapse"
                                data-target="#navbarTogglerDemo01" aria-expanded="false" ><span class="price-a">Realice su Reservacion</span></a>
                              </p>
                          @endrole
                          
                          @role('repartidor')
                            <br></h1>
                            {{-- <p class="intro-subtitle intro-price">
                              <a href="#" onclick='reservacion()' class="btn navbar-toggle-box-collapse" data-toggle="collapse"
                              data-target="#navbarTogglerDemo01" aria-expanded="false" ><span class="price-a">
                                Pedidos Solicitados
                              </span></a>
                            </p> --}}
                          @endrole

                          @role('administrador')
                            <br></h1>
                            <p class="intro-subtitle intro-price">
                              <a href="#" onclick='reservacion()' class="btn navbar-toggle-box-collapse" data-toggle="collapse"
                              data-target="#navbarTogglerDemo01" aria-expanded="false" ><span class="price-a">
                                Reservas Solicitadas 
                              </span></a>
                            </p>
                          @endrole


                        @else
                          <br> Estamos esperandote</h1>
                          <p class="intro-subtitle intro-price">
                            <a href="#" onclick='reservacion()' class="btn navbar-toggle-box-collapse" data-toggle="collapse"
                            data-target="#navbarTogglerDemo01" aria-expanded="false" ><span class="price-a">Realice su Reservacion</span></a>
                          </p>
                        @endauth
                      

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item-a intro-item bg-image" style="background-image: url(imagenes/bienvenido.jpg)">
          <div class="overlay overlay-a"></div>
          <div class="intro-content display-table">
            <div class="table-cell">
              <div class="container">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="intro-body">
                      @guest
                            {{-- <p class="intro-title-top">Doral, Florida
                              <br># 78345</p> --}}
                              <h1 class="intro-title mb-4">
                              <span class="color-b"> </span> 
                              <br> Llevamos el sabor a su hogar</h1>
                            <p class="intro-subtitle intro-price">
                            <a href="#menu" ><span class="price-a">Realice su Pedido</span></a>
                      @else
                        @role('cliente')
                            {{-- <p class="intro-title-top">Doral, Florida
                              <br># 78345</p> --}}
                              <h1 class="intro-title mb-4">
                              <span class="color-b"> </span> 
                              <br> Llevamos el sabor a su hogar</h1>
                            <p class="intro-subtitle intro-price">
                            <a href="#menu" ><span class="price-a">Realice su Pedido</span></a>
                        @endrole
                        @role('repartidor')
                          <p class="intro-title-top">{{ Auth::user()->name }} Revisa tu lista de pedidos asignados
                          <h1 class="intro-title mb-4">
                            <span class="color-b"> </span> 
                          <p class="intro-subtitle intro-price">
                            <a href="#menu" ><span class="price-a">Ver Pedidos</span></a>
                        @endrole
                        @role('administrador')
                            <p class="intro-title-top">{{ Auth::user()->name }} Revisa la lista de pedidos solicitados
                              <h1 class="intro-title mb-4">
                              <span class="color-b"> </span> 
                            <p class="intro-subtitle intro-price">
                            <a href="#menu" ><span class="price-a">Ver Pedidos</span></a>
                        @endrole
                      @endguest
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    
      </div>
    </div> 
</section>
