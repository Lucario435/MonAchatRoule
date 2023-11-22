@extends('partials.xlayout')


@section('content')
<div class="container-sm mt-4" style="max-width:800px;">
    <div class="row" style="margin-left:5px;">
        <select
        id="status-selector"
        class="form-select col-6"
        aria-label="Default select example"
        style="
        margin:0;
        width:180px;
        ">
            <option value="none" selected>Tous status</option>
            <option value="1">Bloqué</option>
            <option value="0">Non-bloqué</option>
        </select>
        <a class="col d-flex align-items-center justify-content-end" href="/admin" style="margin-right:10px;">Liste des demandes</a>
    </div>
    <div id="container-signalements">@include('admin.list-users')</div>
</div>
<div class="modal fade" id="blockUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Bloquer un utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-process-block">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir bloquer <span id="pseudo"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="module">
    $(() => {
        const myModal = document.getElementById('blockUserModal');
        //const myInput = document.getElementById('commentaire');
        const form = document.getElementById('form-process-block');
        const select = $("#status-selector");
        
        $(myModal).on('shown.bs.modal', function(event) {
            let idUser = event.relatedTarget.id;
            //let description = $(event.relatedTarget).parent().parent().find(".description").html();
            let user = $(event.relatedTarget).parent().parent().find(".username").html();
            console.log(description);
            console.log($(myModal).find('button[type="submit"]').attr('id', idUser));
            $(myModal).find('#p-username').html(user);
            //$(myModal).find('#signaled').html(signaled);
            //myInput.focus();
        });
        
        //https://www.digitalocean.com/community/tutorials/submitting-ajax-forms-with-jquery
        $(form).on('submit', function(event) {
            let data = {
                id: $(myModal).find('button[type="submit"]').attr('id'),
            };
            console.log(data);
            let dataString = JSON.stringify(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "",
                contentType: "application/json",
                data: dataString,
            }).done(function(data) {
                console.log(data);
                if (data['status'] == 1) {
                    console.log($(".container-sm").find(`button[id=${data.id}]`),
                        ' bouton off...');
                    // Changer le form car mtn l'option devrait etre de debolque 
                    $(".container-sm").find(`button[id=${commentaire.id}]`).prop('disabled',
                        true);
                    $(".container-sm").find(`button[id=${commentaire.id}]`).next("span.fas")
                        .removeClass("fas fa-user-check").addClass("fas fa-user-alt-slash");
                    $(".container-sm").find(`button[id=${commentaire.id}]`).next("span.fas")
                        .css("color", "green");
                }
            });
            event.preventDefault();
        });
        $(select).on('change',function(event){
          let selectedStatus = event.target.value;
          console.log(selectedStatus);
          $.ajax({
                type: "GET",
                url: `admin?status=${selectedStatus}`,
                contentType: "application/json",
            }).done(function(data) {
                $('#container-signalements').html(data);
                
            });
        })
    })
</script>
@endsection