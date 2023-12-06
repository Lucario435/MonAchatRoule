@if(count($signalements) == 0)
    <div class="text-center mt-5" style="font-size: 18px">Aucun signalement</div>
@endif
@foreach ($signalements as $signalement)
    @include('admin.signalement-card')
@endforeach
<div class="row" style="height:50px;"></div>