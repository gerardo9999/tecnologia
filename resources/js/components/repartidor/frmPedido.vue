<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Repartidor</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Pedido
                   
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                <option value="cliente">Cliente</option>
                              
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarPedido(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarPedido(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Fecha Entrega</th>
                                <th>Hora</th>
                                <th>Hora Entrega</th>
                                <th>Tiempo Entrega</th> 
                                <th>Referencia</th>
                                <th>Monto Total</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="pedido in ArrayPedido" :key="pedido.id">
                                <td v-text="pedido.nombreCompleto"></td>
                                <td v-text="pedido.fecha"></td>
                                <td v-text="pedido.fechaentrega"></td>
                                <td v-text="pedido.hora"></td>
                                <td v-text="pedido.horaentrega"></td>
                                <td v-text="pedido.tiempoentrega"></td>
                                <td v-text="pedido.referencia"></td>
                                <td>{{pedido.montototal}} Bs</td>

                                <template v-if="pedido.estado==0">
                                    <td><span class="badge badge-warning">Pendiente</span></td>
                                    <td>
                                     &nbsp;
                                        <button @click="pedidoEntregado(pedido.id)" type="button" class="btn btn-info btn-sm">
                                            <i class="fa fa-check"></i>
                                        </button>
                                         &nbsp;
                                        <button type="button" @click="abrirModal('pedido','ver',pedido)" class="btn btn-primary btn-sm">
                                                 <i class="icon-eye"></i>
                                        </button>
                                        &nbsp;
                                        <button class="btn btn-sm btn-warning" @click="verUbicacion(pedido.url)">
                                            <i class="icon-globe-alt"></i>
                                        </button>
                                    </td>
                                </template>
                         
                                <template v-if="pedido.estado==1">
                                    <td><span class="badge badge-success">Entregado</span></td>
                                    <td>
                                        &nbsp;
                                        <button type="button" @click="abrirModal('pedido','ver',pedido)" class="btn btn-primary btn-sm">
                                                 <i class="icon-eye"></i>
                                        </button>
                                        &nbsp;
                                        <button class="btn btn-sm btn-warning" @click="verUbicacion(pedido.url)">
                                            <i class="icon-globe-alt"></i>
                                        </button>    
                                    </td>
                                </template>

                                <template v-if="pedido.estado==2">
                                    <td><span class="badge badge-danger">Cancelado</span></td>
                                    <td></td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                   <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' :'']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page">1</a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>









        <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="border text-center p-2 m-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 style="font-size: 12px;" class="title"><b>Cliente:&nbsp;</b>{{cliente}}</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="font-size: 12px;"><b>Fecha Pedido:</b>  {{fecha}}</h6>
                                    </div>
                                </div>
                            </div>
                                    <!-- <tr>
                                        <td colspan="3" align="left"><strong>Fecha :</strong></td>
                                        <td>
                                            {{ fecha}} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="left"><strong>Latitud :</strong></td>
                                        <td>
                                            {{latitud}} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="left"><strong>Longitud : </strong></td>
                                        <td>
                                            {{longitud}} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="left"><strong>Referencia :&nbsp;</strong></td>
                                        <td>
                                            {{referencia}} 
                                        </td>
                                    </tr>                                    
                            </div> -->
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                        <td>{{detalle.nombre}}</td>
                                        <td>{{detalle.precio}}</td>
                                        <td>{{detalle.cantidad}}</td>
                                        <td>{{detalle.subTotal}}</td>
                                    </tr>
                                   
                                     <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Total :</strong></td>
                                        <td>
                                            {{ montoTotal}} .Bs
                                        </td>
                                    </tr>
                                </tbody>
                                
                            </table>

                            <div class="border m-2 p-2 text-center">
                                <i style="font-size: 15px;"><h6><b>Referencia :</b>  {{referencia}}</h6></i>



                            <div class="border p-2 text center m-2;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i><h6 style="font-size: 10px; "><b>Logitud :</b>  {{longitud}}</h6></i>
                                    </div>
                                    <div class="col-md-6">
                                        <i><h6 style="font-size: 10px;"><b>Latitud :</b>  {{latitud}}</h6></i>
                                    </div>
                                </div>
                                
                            </div>
                                
                            </div>
                  
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        <!--Fin del modal-->  
    </main>
</template>

<script>
    export default {

        data() {
            return {
                ArrayPedido : [],
                arrayDetalle : [],
                idPedido : 0,
                fecha: null,
                montoTotal : 0,
                cliente : null,
                ubicacion:null,
                latitud:null,
                longitud:null,
                referencia:null,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'cliente',
                buscar: '',

                //Variables del modal
                modal       : 0,
                tituloModal : '',
                tipoAccion  : 0,

                ArrayRepartidor : []

            }
        },
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
    
        methods: {
            listarPedido(page,buscar,criterio){
                let me = this;

                var url ='/pedido/repartidos?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then((response) => {
                    var respuesta    = response.data;
                    me.ArrayPedido = respuesta.pedido.data
                    me.pagination    =  respuesta.pagination;
                    console.log(this.ArrayPedido);
                }).catch((value) => {
                    console.log(value);
                });

            },
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarPedido(page, buscar, criterio);
            },
            cerrarModal(){
                
                this.modal=0;
                this.tituloModal='';
                document.getElementsByTagName("html")[0].style.overflow = "auto";

            },
            verUbicacion(url){
                window.open(url);
            },
            pedidoPediente(id){
                swal({
                title: 'El Pedido está Pendiente?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.post('pedido/pendiente',{
                        'id': id
                    }).then(function (response) {
                        me.listarPedido(1, '', 'fecha');
                        swal(
                        'Pedido Pendiente!',
                        'Su Pedido esta Pendiente.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            pedidoEntregado(id){
                swal({
                title: 'El Pedido ha sido Entregado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.post('pedido/entregado/admin',{
                        'id': id
                    }).then(function (response) {
                        me.listarPedido(1, '', 'fecha');
                        swal(
                        'Pedido Entregado!',
                        'Su pedido ha sido Entregado con Exito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            pedidocancelado(id){
                swal({
                title: 'El Pedido va a ser Cancelado?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.post('pedido/cancelado',{
                        'id': id
                    }).then(function (response) {
                        me.listarPedido(1, '', 'fecha');
                        swal(
                        'Pedido Cancelado!',
                        'Su pedido ha sido Cancelado con Exito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "pedido":
                    {
                        switch(accion){
                  
                            case 'ver':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal    ='Ver Detalle';
                                this.tipoAccion     = 2;

                                this.idPedido       = data['id'];
                                this.cliente        = data['nombreCompleto'];
                                this.montoTotal     = data['montototal'];
                                this.fecha          = data['fecha'];
                                break;
                            }
                        }
                    }

                }
                this.detallePedido(this.idPedido);
            },
            detallePedido(id){
                let me = this;

                var url = '/detalle/pedido/repartidor?idPedido='+id;

                axios.get(url).then((response)=>  {
                    var respuesta   = response.data;
                    me.arrayDetalle = respuesta.detalle;
                    me.ubicacion= respuesta.ubicacion;
                    me.latitud= me.ubicacion.latitud;
                    me.longitud= me.ubicacion.longitud;
                    me.referencia= me.ubicacion.referencia;
                    console.log(this.ubicacion.latitud);
                    console.log(this.ubicacion);
                }).catch((value) => {
                    console.log(value);
                });
            }
        },
        
        mounted() {
            this.listarPedido(1,this.buscar,this.criterio);
        },
    }
</script>

<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }
    
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    
    .div-error {
        display: flex;
        justify-content: center;
    }
    
    .text-error {
        color: red !important;
        font-weight: bold;
    }
</style>