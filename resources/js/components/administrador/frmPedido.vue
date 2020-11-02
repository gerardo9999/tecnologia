<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Admin</a></li>
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
                                <th>Glosa</th>
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
                                <td v-text="pedido.glosa"></td>
                                <td v-text="pedido.referencia"></td>
                                <td v-text="pedido.montototal"></td>
                                
                                <template v-if="pedido.estado==0">
                                    <td><span class="badge badge-warning">Pendiente</span></td>
                                    <td>
                                     &nbsp;
                                    <button @click="pedidoEntregado(pedido.id)" type="button" class="btn btn-success btn-sm" >
                                        <i class="fa fa-check"></i> 
                                    </button>
                                      
                                    <button @click="abrirModal('pedido','repartidor',pedido)" type="button" class="btn btn-warning btn-sm" >
                                            <i class="fa fa-car"></i>
                                    </button>
            
                                    <button @click="abrirModal('pedido','glosa',pedido)" type="button" class="btn btn-info btn-sm" >
                                            <i class="fa fa-comment"></i>
                                    </button>
                                    
                                    <button @click="pedidocancelado(pedido.id)" type="button" class="btn btn-danger btn-sm">
                                            <i class="icon-trash"></i>
                                    </button>
                                    <button type="button" @click="abrirModal('pedido','ver',pedido)" class="btn btn-primary btn-sm">
                                                 <i class="icon-eye"></i>
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
        <div class="modal fade" tabindex="-1" :class="{'mostrar' :modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <template v-if="tipoAccion==1">
                        <div class="modal-body">
                        <form  method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre">
                                </div>
                            </div>
                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    </template>           
                    <template v-if="tipoAccion==2">
                                    <div class="table-responsive col-md-12 p-4"  >
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="repartidor in ArrayRepartidor" :key="repartidor.idProducto">
                                                
                                                    <td v-text="repartidor.id"></td>
                                                    <td v-text="repartidor.nombre"></td>
                                                    <td v-text="repartidor.apellidos"></td>
                                                    <td>
                                                        <template v-if="tipoAccion==2">
                                                            <button type="button" @click="agregarRepartidor(repartidor)" class="btn btn-success btn-sm">
                                                                <i class="icon-check"></i>
                                                            </button>
                                                        </template>
                                                    </td>
                                                </tr>             
                                            </tbody>
                                        </table>
                                    </div>

                    </template>

                    <template v-if="tipoAccion==3">
                        
                        <div class="border  p-2"> 
                              <div class="row">
                                   <div class="col-md-6 p-4">
                                        <h6 class="title"><b>Cliente:</b> {{cliente}} </h6>
                                        <h6 class="title"><b>Fecha:</b> {{ fecha }}  </h6> 
                                  </div>
                               </div>
                               <div class="row ">
                                    <div class="col-md-4"> 
                                        <h6 class="title"><b>Latitud:</b><br>{{ubicacion.latitud }}</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="title"><b>Longitud:</b> <br>{{ubicacion.longitud }}</h6> 
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="title"><b>Referencia:</b><br>{{ubicacion.referencia}}</h6>
                                    </div>    
                            </div>
                        </div>
                        
                        <div class="col-md-12 p-4">
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
                                     <!-- <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Fecha :</strong></td>
                                        <td>
                                            {{ fecha }} 
                                        </td>
                                    </tr> -->
                                     <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Total :</strong></td>
                                        <td>
                                            {{ montoTotal}} .Bs
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>  
                    

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="agregarRepartidor()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="agregarGlosa()">Modificar</button>
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
                cliente: null,
                montoTotal: 0,
                fecha: null,
                ubicacion: null,

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

                var url ='/pedido/admin?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

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
            agregarRepartidor(data=[]){
                let me = this;
            
                var url= 'repartidor/agregar';
                axios.post(url, {
                    'idRepartidor': data["id"],
                    'id'          : this.idPedido
                }).then(function(response) {
                    me.cerrarModal();
                    me.listarPedido(1);

                    iziToast.info({
                            title: 'Exito!',
                            message: 'Se ha agregado el repartidor',
                    });

                }).catch(function(error) {
                    console.log(error);
                });
            },
            allRepartidor(){
                let me =this;
                var url = '/pedido/repartidor';

                axios.get(url).then(function(response){
                    var respuesta    = response.data;
                    me.ArrayRepartidor     = respuesta.repartidor;
                }).catch(function(error){
                    cons
                });
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

               detallePedido(id){
                let me = this;

                var url = '/detalle/pedido/admin?idPedido='+id;

                axios.get(url).then((response) => {
                    var respuesta   = response.data;
                    me.arrayDetalle = respuesta.detalle;
                    me.ubicacion    = respuesta.ubicacion;
                    console.log(this.arrayDetalle);
                    console.log(this.ubicacion);
l             }).catch((value) => {
                    console.log(value);
                });
            },

            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "pedido":
                        {
                            switch (accion) {
                                case 'repartidor':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Agregar Repartido'
                                        this.tipoAccion = 2;
                                        this.idPedido = data["id"];
                                        break;
                                    }
                                case 'glosa':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Escribir Glosa';
                                        this.tipoAccion = 1;
                                        this.idPedido = data["id"];


                                        break;
                                    }
                                case 'ver':
                                    {
                                                //console.log(data);
                                        this.modal=1;
                                        this.tituloModal    ='Ver Detalle';
                                        this.tipoAccion     = 3;

                                        this.idPedido        = data['id'];
                                        this.cliente        = data['nombreCompleto'];
                                        this.montoTotal     = data['montototal'];
                                        this.fecha          = data['fecha'];
                                        break;
                                    }
                            }
                        }
                }
                this.allRepartidor();
                this.detallePedido(this.idPedido);
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