
{{-- @livewire('delivery') --}}

@guest
    <livewire:delivery>
@else
    @role('cliente')
    <livewire:delivery>    
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
