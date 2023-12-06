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
                width:180px;">
                <option value="none" selected>Tous status</option>
                <option value="1">Traitée</option>
                <option value="0">Intraitée</option>
            </select>
            <a class="col d-flex align-items-center justify-content-end" href="/admin/users" style="margin-right:10px;">Liste des utilisateurs</a>
        </div>
        <div id="container-signalements">@include('admin.list-signalements')</div>
    </div>
    <div class="modal fade" id="signalerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-height:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Traiter le signalement</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="form-process-signalement">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="modal-body">
                        <p><b>Signalé:</b> <span id="signaled"></span></p>

                        <br>
                        <p style="overflow-y: scroll; height:10em;"><b>Raison:</b> <span id="p-description"></span></p>
                        <p><b>Informations associées:</b> <span id="p-meta"></span></p>

                        <textarea rows="8" cols="50" type="text-area" id="commentaire" placeholder="commentaire (optionnel)"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Traiter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="module">
        $(() => {
            const myModal = document.getElementById('signalerModal');
            const myInput = document.getElementById('commentaire');
            const form = document.getElementById('form-process-signalement');
            const select = $("#status-selector");

            $(myModal).on('shown.bs.modal', function(event) {
                let idSignalement = event.relatedTarget.id;
                let description = $(event.relatedTarget).parent().parent().find(".description").html();
                let metad = $(event.relatedTarget).parent().parent().find(".meta").html();
                let signaled = $(event.relatedTarget).parent().parent().find(".signaled").html();
                let targetId = $(event.relatedTarget).parent().parent().find(".target-id").html();
                //console.log(description);
                $(myModal).find('button[type="submit"]').attr('id', idSignalement);
                $(myModal).find('#p-description').html(description);
                $(myModal).find('#p-meta').html(metad);
                if(signaled == undefined){
                    signaled = "Aucun utilisateur signalé";
                }
                $(myModal).find('#signaled').html(`<a href="/users/${targetId}" title="voir profil">${signaled}</a>`);
                $(myModal).find('#signaled').html(signaled);
                myInput.focus();
            });

            //https://www.digitalocean.com/community/tutorials/submitting-ajax-forms-with-jquery
            $(form).on('submit', function(event) {
                let commentaire = {
                    commentaire: $("#commentaire").val(),
                    id: $(myModal).find('button[type="submit"]').attr('id'),
                };
                //console.log(commentaire);
                let commentaireString = JSON.stringify(commentaire);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "admin",
                    contentType: "application/json",
                    data: commentaireString,
                }).done(function(data) {
                    //console.log(data);
                    if (data['status'] == 1) {
                        //console.log($(".container-sm").find(`button[id=${commentaire.id}]`),
                         //   ' bouton off...');
                        $(".container-sm").find(`button[id=${commentaire.id}]`).prop('disabled',
                            true);
                        $(".container-sm").find(`button[id=${commentaire.id}]`).next("span.fas")
                            .removeClass("fas fa-clock").addClass("fas fa-check");
                        $(".container-sm").find(`button[id=${commentaire.id}]`).next("span.fas")
                            .css("color", "green");
                    }
                });
                event.preventDefault();
            });
            $(select).on('change',function(event){
              let selectedStatus = event.target.value;
              //console.log(selectedStatus);
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
