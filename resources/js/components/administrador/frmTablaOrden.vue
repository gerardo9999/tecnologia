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
                    <i class="fa fa-align-justify"></i> Ordenes de Servicios

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <!--<div class="input-group">
                                <select class="form-control col-md-5" v-model="criterio">
                                <option value="capacidad">Capacidad</option>
                                <option value="ubicacion">Ubicacion</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMesa(1, buscar, criterio)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listarMesa(1, buscar, criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>-->
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Monto Total</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="orden in arrayOrdenes" :key="orden.id">
                                <td >{{orden.nombreCompleto}}</td>
                                <td>{{orden.fecha}}</td>
                                <td>{{orden.montototal}}</td>
                                <td>
                                    <button @click="abrirModal('orden','ver',orden)" class="btn btn-sm btn-info">
                                    <i class="icon-eye"></i> Ver Detalle</button>
                                        &nbsp;
                                    <button class="btn btn-sm btn-primary" @click="generarPDF(orden.id)"><i class="icon-doc"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
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
                            <div class="border text-left p-2">
                                <h6 class="title"><b>Cliente:</b >{{cliente}}</h6>
                                  <tr>
                                        <td colspan="3" align="right"><strong>Fecha :</strong></td>
                                        <td>
                                            {{ fecha }} 
                                        </td>
                                    </tr>

                            </div>
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
                                        <td >{{detalle.nombre}}</td>
                                        <td>{{detalle.precio}}</td>
                                        <td>{{detalle.cantidad}}</td>
                                        <td>{{detalle.subTotal}}</td>
                                    </tr>
                                     <!--<tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Fecha :</strong></td>
                                        <td>
                                            {{ fecha }} 
                                        </td>
                                    </tr>-->
                                     <tr style="background-color: #CEECF5;">
                                        <td colspan="3" align="right"><strong>Total :</strong></td>
                                        <td>
                                            {{ montoTotal}} .Bs
                                        </td>
                                    </tr>
                                </tbody>                                
                            </table>
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
                idOrden: 0,
                montoTotal: 0,
                arrayOrdenes: [],
                arrayDetalle : [],

                idOrden     : 0,
                cliente     : null,
                fecha       : null,




                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorMesa: 0,
                errorMostrarMsjMesa: [],
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
                buscar: ''
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
            listarOrdenes(page,buscar,criterio) {
                let me = this;

                var url ='/orden?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;

                axios.get(url).then((response) => {
                    var respuesta= response.data;
                    me.arrayOrdenes = respuesta.orden.data;
                    me.pagination= respuesta.pagination;
                    console.log(this.arrayOrdenes);
                }).catch((value) => {
                    console.log(value);
                });

            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

            },
            generarPDF(id){
                window.open('http://localhost:8000/pdf/orden/'+ id +','+'_blank');
                
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "orden":
                    {
                        switch(accion){
                  
                            case 'ver':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal    ='Ver Detalle';
                                this.tipoAccion     = 2;

                                this.idOrden        = data['id'];
                                this.cliente        = data['nombreCompleto'];
                                this.montoTotal     = data['montototal'];
                                this.fecha          = data['fecha'];
                                break;
                            }
                        }
                    }

                }
                this.detalleOrden(this.idOrden);
            },
            detalleOrden(id){
                let me = this;

                var url = '/detalle/orden?idOrden='+id;

                axios.get(url).then((response) => {
                    var respuesta   = response.data;
                    me.arrayDetalle = respuesta.detalle;
                    console.log(this.arrayDetalle);
                }).catch((value) => {
                    console.log(value);
                });
            }
        },
        mounted() {
            this.listarOrdenes(1,this.buscar,this.criterio);

        }
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