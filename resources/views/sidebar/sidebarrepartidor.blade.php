<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            
                {{-- Escritorio --}}
                <li  @click="menu=0" class="nav-item">
                    <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                </li>
                
                {{-- Menu --}}
                <li class="nav-title">
                    Menú
                </li>
                
                {{-- Pedidos --}}
                <li @click="menu=1" class="nav-item">
                    <a class="nav-link" href="#"><i class="icon-book-open"></i> Pedidos</span></a>
                </li>



                
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>