@guest
    <livewire:delivery>
@else
    @role('cliente')
    <livewire:delivery>    
    @endrole
@endguest

   
@include('components.frmMapa')
@include('components.frmDato')
