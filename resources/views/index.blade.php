<!DOCTYPE html>
<html lang="es">
@include('sistema.head')
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <div id="app" >
 
        @include('sistema.header')
        <div class="app-body">
            @auth
                
                @role('administrador')
                    @include('sidebar.sidebarAdministrador')
                @else
                   @role('repartidor')
                        @include('sidebar.sidebarRepartidor')
                    @else   
                        @include('sidebar.sidebarCliente')                   
                   @endrole
                @endrole

                @yield('contenido')
            @else
                <div class=" border p-3 m-2 text-center">
                    <h6 class="title">Sin acceso al sistema</h6>
                </div>
            @endauth
        </div>
    </div>

    @include('sistema.scripts')
</body>
</html>