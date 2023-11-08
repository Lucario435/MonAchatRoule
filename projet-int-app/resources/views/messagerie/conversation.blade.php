{{-- conv, pid, targetUser --}}
@php
    use App\Models\User;
    $user = Auth::user();
@endphp
@include('partials.xhelper')
<div class="bleuTileContact">
    <span class="espaced gridex">
        <img class="imgProfx" src="{{ $targetUser->getImage() }}" alt="">
        <div class="aboveouterspangridex">
        <div class="outerspangridex">
            <span class="spangridex">{{ $targetUser->getDisplayName() }}</span>
            <a style="color:var(--report); margin-left: .5rem;" href="{{ route("messages.reportuser",["id" => $targetUser->id]) }}"><i class="fas fa-flag"></i></a>
            <a style="color:var(--report); margin-left: .5rem;" href="{{ route("messages.blockUserMsgs",["id" => $targetUser->id]) }}"><i class="fas fa-ban"></i></a>
        </div>
        @if (isset($targetUserPString))
        <span>{!! $targetUserPString !!}</span>
@endif
    </div>

    </span>
</div>

<br>
<div class="convList">
    @foreach ($conv as $chat)
        @php
            //$decoded = json_decode($chat->mcontent, true);
            $d = $chat->created_at;
            $msgContent = $chat->mcontent; //isset($decoded["msg"]) ? $decoded["msg"] : null;
            $isSeen = $chat->seen;
            $hidden = $chat->hidden;
        @endphp
        @if (is_null($msgContent) || $hidden)
            @continue
        @endif

        @if ($chat->sender == $user)
            <div class="divBeforemsgbulle" style="display: grid; grid-template-columns: 1rem auto;">
                <a class="delete-icon" title="Supprimer ce message?"
                    href="{{ route('messages.userdelete', ['id' => $chat->id]) }}"><i class="fas fa-trash-alt"></i>
                </a>
                <div class="msgSent msgbulle" title="{{ dateFr($d) }}">
                @else
                    <div class="msgReceived msgbulle" title="{{ dateFr($d) }}">
                        @if (!$isSeen)
                            <div class="blue-bubble"></div>
                        @else
                            {{-- <span>SEEN</span> --}}
                        @endif
        @endif
        {!! parseContent($msgContent) !!}
        @if ($chat->sender == $user)
</div>
@endif
</div>
@endforeach
</div>

<style>
    .gridex {
        display: grid;
        grid-template-columns: 6rem auto;
        height: 100%;
    }
    .aboveouterspangridex:nth-child(1n){
        display: grid;
        grid-template-columns: auto;
        grid-template-rows: auto;
    }
    .aboveouterspangridex>div:nth-child(2n){
        display: grid;
        grid-template-columns: auto;
        grid-template-rows: 50% auto;
    }
    .outerspangridex {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .gridex>.spangridex {
        height: 100%;
        text-align: left;
        vertical-align: bottom;
    }

    .contentImage {
        width: 100%;
    }

    .blue-bubble {
        width: 10px;
        height: 10px;
        background-color: cornflowerblue;
        border-radius: 50%;
        margin-right: 5px;
        position: absolute;
        top: -5px;
        right: -5px;
    }

    .imgProfx {
        vertical-align: middle;
        width: 4rem;
        height: 4rem;
        margin-top: 1rem;
        border-radius: 100%;
        /* Add other necessary styles */
    }

    .convList {
        width: 100%;
        max-width: 100%;
        display: flex;
        flex-direction: column;
        /* overflow-y: scroll; */
    }

    .divBeforemsgbulle {
        float: right;
        margin-left: auto;
    }

    .divBeforemsgbulle>a {
        margin-right: 3rem;
    }

    .divBeforemsgbulle>a>i {
        /* color: rgb(171, 0, 0); */
        color: rgb(201, 0, 0);
    }

    .delete-icon {
        /* display: none; Hide the delete icon by default */
        opacity: 0;
    }

    .divBeforemsgbulle:hover .delete-icon {
        opacity: 1;
        /* display: inline-block; Show the delete icon when .divBeforemsgbulle is being hovered on */
    }

    .msgbulle {
        padding: 5px 20px;
        margin-bottom: .1rem !important;
        width: fit-content;
        max-width: 15rem;
        border-radius: 8px;
        color: white;
        font-weight: bolder;
        overflow-wrap: break-word;

    }

    .msgReceived {
        background: cornflowerblue;
        border-bottom-left-radius: 0px;
    }

    .msgSent {
        /* text-align: right; */
        float: right;
        margin-left: auto;
        background: gray;
        border-bottom-right-radius: 0px;
    }
</style>
