@extends('partials.xlayout')


@section('content')
    <div class="container-sm mt-4" style="max-width:800px;">
        <div class="row" style="margin-left:5px;">
            <select id="status-selector" class="form-select col-6" aria-label="Default select example"
                style="
        margin:0;
        width:180px;
        ">
                <option value="none" selected>Tous status</option>
                <option value="1">Bloqué</option>
                <option value="0">Non-bloqué</option>
            </select>
            <a class="col d-flex align-items-center justify-content-end" href="/admin" style="margin-right:10px;">Liste des
                demandes</a>
        </div>
        <div id="container-users">@include('admin.list-users')</div>
    </div>

    @include('admin.modals.block-modal')
    @include('admin.modals.unblock-modal')

    <script type="module">
        $(() => {
            const myModal = document.getElementById('blockUserModal');
            const myModalUnblock = document.getElementById('unBlockUserModal');
            const formBlock = document.getElementById('form-process-block');
            const formUnblock = document.getElementById('form-process-unblock');
            const select = $("#status-selector");

            $(myModal).on('shown.bs.modal', function(event) {
                let idUser = event.relatedTarget.id;
                let user = $(event.relatedTarget).parent().parent().find(".username").html();

                $(myModal).find('button[type="submit"]').attr('id', idUser); // sets the user id to use it later in on submit form

                $(myModal).find('#pseudo').html(user);

            });

            $(myModalUnblock).on('shown.bs.modal', function(event) {
                let idUser = event.relatedTarget.id;
                let user = $(event.relatedTarget).parent().parent().find(".username").html();

                $(myModalUnblock).find('button[type="submit"]').attr('id', idUser); // sets the user id to use it later in on submit form

                $(myModalUnblock).find('#pseudo').html(user);

            });

            //https://www.digitalocean.com/community/tutorials/submitting-ajax-forms-with-jquery
            $(formBlock).on('submit', function(event) {
                
                let userId = $(myModal).find('button[type="submit"]').attr('id');
                let formId = $(event.currentTarget)[0].id;
               
                
                event.preventDefault();
                
                console.log(userId);
                //console.log(url, 'the form submited...');


                let url = `user/block/${userId}`;
                console.log(url);
                let token = $(event.currentTarget).find('meta[name="csrf-token"]').attr('content');
                console.log(token);
                sendAjax(url, token);

                

                
            });

            $(formUnblock).on('submit',function(event){
                let userId = $(myModalUnblock).find('button[type="submit"]').attr('id');
                let formId = $(event.currentTarget)[0].id;
               
                
                event.preventDefault();
                
                console.log(userId);
                //console.log(url, 'the form submited...');


                let url = `user/unblock/${userId}`;
                console.log(url);
                let token = $(event.currentTarget).find('meta[name="csrf-token"]').attr('content');
                console.log(token);
                sendAjax(url, token);
            })

            function sendAjax(url,token) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                $.ajax({
                    type: "POST",
                    url: url,
                }).done(function(data) {
                    console.log(data);
        
                    refreshUsersList();

                });
            }

            function refreshUsersList(){
                $.ajax({
                    type: "GET",
                    url: 'users/list',
                    contentType:'html/text',
                    async:false,
                }).done(function(data) {
                    $("#container-users").html(data);
                });
            }

            $(select).on('change', function(event) {
                let selectedStatus = event.target.value;
                console.log(selectedStatus);

                $.ajax({
                    type: "GET",
                    url: `users?is_blocked=${selectedStatus}`,
                    contentType: "application/json",
                }).done(function(data) {
                    $('#container-users').html(data);

                });
            })
        })
    </script>
@endsection
