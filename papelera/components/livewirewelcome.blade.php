<!DOCTYPE html>
<html lang="en">
    @include('page.head')
<body>
  <div class="click-closed"></div>
    @include('page.intro')
  <div class="box-collapse">
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
  </div>
  
    @livewire('reservacion')
    @livewire('pedido')
  </div>
  
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>
    @include('page.scripts')
</body>
</html>