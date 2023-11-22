<div class="row align-items-center"
    style="
    background-color:gainsboro;
    margin:15px 5px 0px 5px;
    padding:10px;
    min-height:70px;
    font-size:16px;
    border-radius:10px;">
    {{-- <div class="col-2" style="word-wrap:break-word;">
        {{ $signalement->formatted_time }}
    </div> --}}
    <div class="col-2" style="word-wrap:break-word;">
        {{ $signalement->target->username }}
    </div>
    <div class="col-1 p-0" style="border-left: 1px solid; width:10px;">&nbsp;</div>
    <div class="col-6" style="word-wrap:break-word;">
        {{ $signalement->mcontent }}
    </div>
    @if ($signalement->status == 0)
        <div class="col-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button id="{{ $signalement->id }}" type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#signalerModal">Traiter</button>
            <span title="en attente : {{ $signalement->formatted_time }}" class="fas fa-clock"
                style="
                width: fit-content;
                font-size:18px;
                color:rgb(255, 111, 0);
                margin-left:10px;">
            </span>
        </div>
    @elseif($signalement->status == 1)
        <div class="col-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary inactive" disabled
                id="{{ $signalement->id }}">Traiter</button>
            <span title="traité par {{ $signalement->resolvedByUser->username }}" class="fas fa-check"
                style="
                width: fit-content;
                font-size:18px;
                color:green;
                margin-left:10px;
                ">
            </span>
        </div>
    @endif
</div>
