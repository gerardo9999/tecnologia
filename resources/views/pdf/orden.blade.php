<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: left;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        /* background: #2183E3; */
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        /* #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        } */

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        border:left;
        text-align: center;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

#gracias{
        text-align: center; 
        }
    </style>
    <body>
        <header>
            <div id="logo">
                 <img src="img/logo1.png" alt="incanatoIT" id="imagen"> 
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Restaurante "Pollos y Cuadriles Roca Chavez"</b>
                    <br> Av. Circunvalacion esquina Roberto Paz, Montero</b>
                    <br>Celular: +591 78538688</b>
                    <br>Correo: rocachavezoficial@gmail.com </b>
                </p>
            </div>
            <div id="fact">
            <br></br>
            <br></br>
            <h6><b>Nro. Orden: {{$orden->id}}</b></h6>
                
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <br>
                        <br>
                        <br>
                            <th><p id="cliente">Sr(a). {{ $cliente->nombres }} {{ $cliente->apellidos }}<br>
                            Dirección: {{ $cliente->direccion }}<br>
                            Teléfono: {{ $cliente->telefono }}<br>
                            Correo: {{ $cliente->email }}<br>
                            Fecha: {{$orden->fecha}}
                            </p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VENDEDOR</th>
                            
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>vendedor</td>
                            <td>fecha</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section> -->
       
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>CANTIDAD</th>
                            <th>PRODUCTO</th>
                            <th>PRECIO UNITARIO</th>
                            <th>SUB TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($detalle as $det)
                        <tr>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->nombre}}</td>
                            <td>{{$det->precio}}</td>
                            <td>{{$det->subTotal}} .Bs</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>   
                        <tr>
                            <th></th>
                            <th></th>
                            <th style:='padding:30px'>TOTAL</th>
                            <th>{{$orden->montoTotal}} .Bs</th>       
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>