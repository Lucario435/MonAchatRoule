@if(count($users) == 0)
    <div class="text-center mt-5" style="font-size: 18px">Aucun utilisateur</div>
@endif
@foreach ($users as $user)
    @include('admin.user-card')
@endforeach