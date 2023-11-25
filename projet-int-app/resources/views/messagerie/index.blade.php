{{-- @extends('partials.xlayout')

@section('title', "Messagerie")

@section('content')
    <div class="contacts-list">
        @foreach ($contacts as $contact)
            <a href="#" class="contact-link" data-userid="{{ $contact->id }}">{{ $contact->name }}</a><br>
        @endforeach
    </div>

    <div id="msgrie" class="msgrieWidth">
        <!-- Messages will be displayed here -->
    </div>

    <style>
        .contacts-list {
            width: 20%;
            float: left;
            padding: 10px;
            background: rgb(220, 220, 220);
            height: 400px;
            overflow-y: auto;
        }

        .msgrieWidth {
            width: 70%;
            float: left;
            background: rgb(244, 244, 244);
            height: 400px;
            overflow-y: auto;
        }

        @media (orientation: portrait) {
            .msgrieWidth, .contacts-list {
                width: 90%;
            }
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to load messages based on user ID
            function loadMessages(userId) {
                // Make an AJAX request to get messages for the specified user
                $.ajax({
                    url: '/messages/get/' + userId, // Update the URL to match your route
                    method: 'GET',
                    success: function(response) {
                        // Clear previous messages
                        $('#msgrie').empty();

                        // Append new messages to the chat window
                        response.forEach(function(message) {
                            $('#msgrie').append('<div>' + message.content + '</div>');
                            // Adjust the above line based on your message object structure
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching messages:', error);
                    }
                });
            }

            // Attach click event to contact links
            $('.contact-link').on('click', function(event) {
                event.preventDefault();

                // Get the user ID from data attribute
                var userId = $(this).data('userid');

                // Load messages for the selected user
                loadMessages(userId);
            });
        });
    </script>
@endsection --}}
@extends('partials.xlayout')


@section('title')
    <h1 id="xtitle">Messagerie</h1>
@endsection
{{-- @section('title', "Vos messages") --}}

@section("content")
<div class="container body-content wholeMessages">
    <div style="display:grid; grid-template-columns: 3rem auto; align-items:center">
        <!-- Assurez-vous d'ajouter le code pour déterminer si l'utilisateur est administrateur ou non -->

    </div>


    <div class="main">
        <div class="bigPanel">
            <div class="friendsListContainer" id="friendsListContainer" title="Cliquez sur un de vos amis pour clavarder avec lui...">
                <!-- Le contenu de la liste d'amis sera chargé ici par JavaScript -->
            </div>
            <div class="bigPanelHeightCopy">
                <div class="messagesPanel" id="messagesPanel">
                    <div class="messagesHeader">
                        <h4>Chargement</h4>
                    </div>
                    <!-- Le contenu des messages sera chargé ici par JavaScript -->
                </div>
                <div class="sendMessageLayout">
                    <input id="message" class="form-control" style="width:100% !important;" placeholder="Tapez votre message ici ..." title="Tapez">
                    <span id="send" class="icon fa fa-paper-plane" title="Envoyer" data-placement="bottom"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    :root{
        --bigPanelHeight: 26rem;
    }
    .bigPanel{
        height: 20rem;
        display:grid;
        grid-template-columns:4rem auto;
        /* column-gap:10px; */
    } .bigPanelHeightCopy{height: var(--bigPanelHeight)}
    @media screen and (orientation: portrait){
        .bigPanel{
            /* display: flex !important; */
            /* align-items: middle; */
            /* background: red; */
            grid-template-columns: auto;
            grid-template-rows: auto auto;
        }
        .friendsListContainer{
            height: 4rem !important;
            width: 100% !important;
            display: flex;
            align-items: middle;
            padding: .65rem !important;
        }
        :root{
        --bigPanelHeight: 20rem;
    }
    }
    .friendsListContainer {
        /* Styles pour la liste d'amis */
        width: 4rem;
        height: var(--bigPanelHeight);
        overflow-y: auto;
        background-color: #f2f2f2;
        padding: .5rem;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    }

    .messagesPanel {
        /* Styles pour le panneau des messages */
        height: 100%;
        overflow-y: auto;
        background-color: #ffffff;
        border: 1px solid #ccc;
        padding: 10px;
        box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    }
    ::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.sendMessageLayout {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 0px; /* Add padding for spacing around the input and button */
}

#message {
    flex: 1; /* Let the input take up remaining space */
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
    max-width: calc(100% - 36px); /* Set maximum width for the input */
    margin-right: 10px; /* Add spacing between input and button */
}

#send {
    width: 4rem; /* Set a fixed width for the send button */
    height: auto; /* Set a fixed height for the send button */
    cursor: pointer;
    color: var(--blueheader);
    text-align: center;
    font-size: 1.5rem;
    transition: .1s;
    /* border-bottom: solid 0px cornflowerblue; */
}
#send:hover{
    color: black;
    transition: .2s;
    font-size: 1.7rem;
    /* border-bottom: solid 1px cornflowerblue; */
}

    .bleuTileContact{
        width: 100%;
        height: 6rem;
        background: var(--blueheader);
        opacity: .9;
        color: white;
        font-size: 1.5rem;
        box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;
        border-radius: 10px;
    }
    .bleuTileContact>.espaced{
        padding-left: .5rem;
    }
</style>


<script defer="">
    function ajaxActionCall(actionLink, callback = null) {
    // Ajax Action Call to actionLink
    $.ajax({
        url: actionLink,
        method: 'GET',
        success: (x) => {
            if (callback != null) callback(x);
        }
    });
}
    $friendPanel = $("#friendsListContainer");
    $msgPanel = $("#messagesPanel")
    let friendsPanelUpdater = new PartialRefresh("/Chat/GetFriendsList", "friendsListContainer", 5, UpdateFriendsCallback, {"lastContent": true});
    let messagesPanelUpdater = new PartialRefresh("/Chat/GetMessages", "messagesPanel", 2, UpdateMessagesCallback, {"lastContent": true});

    function UpdateFriendsCallback() {
        messagesPanelUpdater.refresh(true);
        $(".unselectedTarget").click(function () {
            var userId = $(this).attr("userid");
            ajaxActionCall("/Chat/SetCurrentTarget?userid=" + userId, () => { friendsPanelUpdater.refresh(true); messagesPanelUpdater.refresh(true); });
        })
    }
    let editing = false;
    let targetTyping = false;

    function setEditing(value) {
        editing = value;
        if (editing)
            messagesPanelUpdater.pause();
        else
            messagesPanelUpdater.restart();
    }
    function sendMessage() {
        var message = $('#message').val();
        $('#message').val("");
        if (message != "") {
            messagesPanelUpdater.command("/Chat/Send?message=" + message, UpdateMessagesCallback);
        }
    }
    $('#message').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            sendMessage();
        }
    });
    $('#message').focus(function (event) {
        //ajaxActionCall("/chat/IsTyping");
    });
    $('#message').blur(function (event) {
        //ajaxActionCall("/chat/StopTyping");
    });
    $(document).on('keyup', function (event) {
        if (event.key == "Escape") {
            $("#message").val("");
        }
    });

    function UpdateMessagesCallback() {
        $("#typing").hide();
        $(".editMessage").hide();
        $("#messagesPanel").scrollTop($("#messagesPanel")[0].scrollHeight + 100);
        //  $(".convList").scrollTop($(".convList")[0].scrollHeight + 100);
        $(".contentImage").click(function (event) {
            event.stopPropagation();
        })
        $("a").click(function (event) {
            event.stopPropagation();
        })
        $(".sent").click(function () {
            if (!editing) {
                setEditing(true);
                var message_id = $(this).attr("id").split("_")[1];
                $("#edit_" + message_id).show();
                $("#sent_" + message_id).hide();
                $("#delete_" + message_id).click(function () {
                    setEditing(false);
                    messagesPanelUpdater.confirmedCommand("Effacer ce message", "/Chat/Delete?messageid=" + message_id);
                })
                $("#update_" + message_id).click(function () {
                    setEditing(false);
                    var message = $("#" + message_id).val();
                    messagesPanelUpdater.command("/Chat/Update?id=" + message_id + "&message=" + message);
                })
                $('#' + message_id).keypress(function (event) {
                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    if (keycode == '13') {
                        setEditing(false);
                        var message = $("#" + message_id).val();
                        messagesPanelUpdater.command("/Chat/Update?id=" + message_id + "&message=" + message);
                    }
                });
                $(document).on('keyup', function (event) {
                    if (event.key == "Escape") {
                        $("#edit_" + message_id).hide();
                        $("#sent_" + message_id).show();
                        setEditing(false);
                    }
                });
            }
        });
    }

    // setInterval(() => { ajaxActionCall("/Chat/IsTargetTyping", UpdateTyping); }, 3000);

    function UpdateTyping(show) {
        //console.log(show);
        if (show)
            $("#typing").show();
        else
            $("#typing").hide();
    }

    $("#send").click(function () {
        sendMessage();
    })
    </script>

@endsection
