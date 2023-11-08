@extends('partials.xlayout')

@section('title', 'Centre de notification')

@include('partials.xhelper')

@section('content')

    <div id="notifcenter" class="notifcenterWidth">
        <form method="POST" action="{{ route('notifications.multidelete') }}">
            @if (count($nlist) <= 0)
                {{-- <button id="mdelselection" class="btn btn-primary" type="button" disabled style="background: #787777; font-style: italic;">Sélectionner</button> --}}
            @else
                <button id="mdelselection" class="btn btn-primary" type="button">Sélectionner</button>
            @endif

        <button id="mdelsubmit" class="btn btn-primary reddishbtn" type="submit">Supprimer</button>

        <br><a id="mdelselectall" href="javascript:void(0);">Tout sélectionner<br></a><br>

            @csrf
            @foreach ($nlist as $n)
                <a href="{{ route('notifications.click', ['nid' => $n->id]) }}">
                    <div class="notf">
                        <span>{{ $n->title() }}</span>
                        <input style="margin-right: .5rem; margin-left: .1rem;" type="checkbox" class="nidbox" name="nidtable[]" value="{{ $n->id }}">
                        <a class="ndelindiv" style="margin-left: 1rem;" href="{{ route('notifications.delete', ['nid' => $n->id]) }}">
                            <i class="fas fa-trash-alt"></i> <!-- Font Awesome delete icon -->
                        </a>
                        <span style="float: right;" title="{{ $n->created_at }}">
                            <i class="fas fa-clock"></i> {{ dateFr($n->created_at) }}
                        </span>
                        <br>
                        @if ($n->clicked)
                            <span style="float: right">Déjà vu <i class="fas fa-eye"></i></span>
                        @endif
                        <a href="{{ route('notifications.click', ['nid' => $n->id]) }}"><p>{!! $n->msg() !!}</p></a>


                    </div>
                </a>
            @endforeach
        </form>
        @if (isset($nlist) != true || count($nlist) == 0)
            <h4 style="text-align: center; padding-top: 3rem; color: rgb(178, 178, 178);"><i>Aucune notification!</i></h4>
        @endif

    </div>
    <style>
        .notifcenterWidth {
            width: 70%;
        }

        @media screen and (max-width: 768px) {
            .notifcenterWidth {
                width: 90%;
            }
        }
        .reddishbtn{
            background: rgb(200, 0, 0);
            border: rgb(221, 0, 0) 1px solid;
            &:hover{
                background: rgb(150, 0, 0) !important;
                border: rgb(221, 0, 0) 1px solid !important;
            }
        }
        .reddishbtn:active{
                background: rgb(130, 0, 0) !important;
        }
        #notifcenter {
            /* background: rgba(219, 219, 219, 0.278); */
            margin: auto;
            height: 30rem;
        }

        .notf {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .notf:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .notf p {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .notf .timestamp {
            font-size: 14px;
            color: #888;
            margin-top: 10px;
        }

        .notf a {
            text-decoration: none;
            color: #007bff;
        }

        .notf a:hover {
            text-decoration: underline;
        }
    </style>


    <script defer>
        let mdel = $("#mdelselection")
        let mdelsubmit = $("#mdelsubmit");
        let mdelselectall = $("#mdelselectall");

        let mdelbool = false;
        function refreshmdel(){
            $(".nidbox").css("display", mdelbool? "" : "none");
            if(mdelbool == false)
                $(".nidbox").prop("checked",false);

            mdel.text(mdelbool ? "Arrêter la sélection" : "Sélectionner");
            mdelsubmit.css("display",mdelbool?"" : "none");
            mdelselectall.css("display",mdelbool?"" : "none");
            $(".ndelindiv").css("display",!mdelbool?"" : "none");
        }
        mdel.on("click", function() {
            mdelbool = !mdelbool;
            refreshmdel();
        });
        mdelselectall.on("click",function(){
            $(".nidbox").prop("checked",true);
        })
        refreshmdel();
    </script>
@endsection
