<template>
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Repartidor</a></li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>   
                    Pedido
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
                                <th>Hora Entrega</th>
                                <th>Ubicacion</th>
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
                                <td v-text="pedido.horaEntrega"></td>
                                <td>
                                    <button class="btn btn-info btn-sm"><i class=""></i>u</button>
                                </td>
                                <td v-text="pedido.referencia"></td>
                                <td v-text="pedido.montoTotal"></td>
                                    <template v-if="pedido.estado">
                                         <td> <span class="badge badge-success">Entregado</span> </td>
                                    </template>
                                    <template v-else>
                                         <td> <span class="badge badge-danger">Pendiente</span> </td>

                                    </template>
                                  <td>
                                    <template v-if="pedido.estado">
                                        <td> 
                                            <button  @click="abrirModal('producto','registrar')" type="button" class="btn btn-success btn-sm" >
                                                <i class="icon-check"></i>
                                            </button>
                                        </td>
                                    </template>
                                    <template v-else>
                                         <button type="button" class="btn btn-warning btn-sm" @click="entregarPedido(pedido.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                  </td>
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
            listarPedido(page){
                let me = this;

                var url ='/pedidoRepartidor?page=' + page;
                axios.get(url).then((response) => {
                    var respuesta    = response.data;
                    me.ArrayPedido = respuesta.pedido.data
                    me.pagination  =  respuesta.pagination;
                }).catch((value) => {
                    console.log(value);
                });
            },
                        //trae todos los menus de la fecha actual que esten activos
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
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                me.pagination.current_page = page;
                me.listarPedido(page, buscar, criterio);
            },
            entregarPedido(pedido_id){
                swal({
                title: 'Se ha entregado el pedido?',
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

                    axios.post('pedido/entregado',{
                        'id': pedido_id
                    }).then(function (response) {
                        me.listarPedido(1);
                        swal(
                        'Entregado!',
                        'Pedido Entregado.',
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
            }
        },
        mounted() {
            this.listarPedido(1,this.buscar,this.criterio);
        },
    }
</script>
