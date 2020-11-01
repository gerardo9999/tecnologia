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
                                <td v-text="pedido.fechaEntrega"></td>
                                <td v-text="pedido.hora"></td>
                                <td v-text="pedido.horaEntrega"></td>
                                <td v-text="pedido.tiempoEntrega"></td>
                                <td v-text="pedido.referencia"></td>
                                <td v-text="pedido.montoTotal"></td>
                                <template v-if="pedido.estado==0">
                                    <td><span class="badge badge-warning">Pendiente</span></td>
                                    <button @click="pedidoEntregado(pedido.id)" type="button" class="btn btn-info btn-sm">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    &nbsp;
                                        <button type="button" @click="verProducto(menu.id)" class="btn btn-primary btn-sm">
                                                 <i class="icon-eye"></i>
                                        </button>

                                </template>
                                <template v-if="pedido.estado==1">
                                    <td><span class="badge badge-success">Entregado</span></td>
                                        <td></td>
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
                idPedido : 0,

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

                var url ='/pedidoRepartidor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

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
                            }
                        }
                }
                
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