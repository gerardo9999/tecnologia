<div class="modal fade" id="dato" role="dialog">
    <div class="modal-dialog modal-lg">    
    <!-- Modal content-->
    <div class="modal-content" id="" >
        <div class="modal-header" >         
            <h3 align="center" style="width:100%; padding: 0px;">Envianos tus datos personales 
            <!--
                <img src="../Resources/img/grido-logo.png" alt="Logo" style="width:80px;">
            -->
            </h3>
        </div>
        <div class="modal-body">

            <div id="cliente">
                <div class="row">
                  <div class="col-md-12 mb-2">
                      <div class="form-group">
                      {{-- <label for="Type">Nombre</label> --}}
                      <input id='nombre' type="text" 
                      class=" form-control form-control-sm form-control" placeholder="Escriba su nombre">
                      @error('nombre')
                          <span class="error">{{ $message }}</span>
                      @enderror
                      </div>

                  </div>

                  <div class="col-md-12 mb-2">
                      <div class="form-group">
                      {{-- <label for="Type">Apellidos</label> --}}
                      <input id='apellidos' type="text" class="form-control form-control-sm form-control" placeholder="Escriba sus apellidos">
                      
                      </div>
                  </div>

                  <div class="col-md-12 mb-2">
                      <div class="form-group">
                          {{-- <label for="Type">Empresa</label> --}}
                          <input id='empresa' type="text" class="form-control form-control-sm form-control" placeholder="Escriba su empresa">
                      </div>
                  </div>
                  <div class="col-md-12 mb-2">
                      <div class="form-group">
                      {{-- <label for="Type">Telefono</label> --}}
                      <input id='telefono' type="text" class="form-control form-control-sm form-control" placeholder="Digite su numero de telefono">
                      </div>
                  </div>
                  
                  <div class="col-md-12 mb-2">
                      <div class="form-group">
                          {{-- <label for="Type">Direccion</label> --}}
                          <input id='direccion' type="text" class="form-control form-control-sm form-control" placeholder="Escibe tu direccion">

                      </div>
                  </div>



                </div>
            </div>
            <div id="usuario">
                <div class="row">

                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                        {{-- <label for="Type">Usuario</label> --}}
                        <input id='login' type="text" 
                        class=" form-control form-control-sm form-control" placeholder="Escriba su nombre de usuario">
                        @error('login')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                        {{-- <label for="Type">Correo</label> --}}
                        <input id='email' type="email" class="form-control form-control-sm form-control" placeholder="Escriba su email">
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            {{-- <label for="Type">Contraseña</label> --}}
                            <input id='password' type="password" class="form-control form-control-sm form-control" placeholder="Escriba su password">
                            @error('password')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> 
                </div>
            </div>    

       

        <div class="modal-footer" stye="text-align: center !important;">
            <button  style=" border-radius: 6px !important; font-size: 16px; width:220px;"  
            type="button" name="confir_ubv" id="confir_ubv" 
            Onclick="addCliente(); " 
            class="btn btn-success btn-lg verde" data-dismiss="modal"  >GUARDAR</button>
        </div>
    </div>
    
    </div>
</div>