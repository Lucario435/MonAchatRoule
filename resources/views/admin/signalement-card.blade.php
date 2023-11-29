<div class="row align-items-center signalement-card"
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
    <div class="col-sm-2 center-text-sm" style="word-wrap:break-word;">
        {{ $signalement->sender->username }}
    </div>
    @php
        $sigData = json_decode($signalement->mcontent,true);
    @endphp
    <div class="col-sm-1 p-0 separator"></div>
    <div class="col-sm-6 description center-text-sm"
        style="white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-heigth: 50px;">
        {{ $sigData["msg"] }}
    </div>

    <div class="meta" style="display: none;">{{ $sigData["hideText"] != null ? $sigData["hideText"] : "Aucune" }}</div>

    @if ($signalement->user_target != null)
        <span class="signaled" style="display:none;">{{$signalement->target->username}}</span>
        <span class="target-id" style="display:none;">{{$signalement->target->id}}</span>
    @endif

    @if ($signalement->status == 0)
        <div class="col-sm-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button id="{{$signalement->id}}" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signalerModal">Consulter</button>
            <span title="en attente : {{ $signalement->formatted_time }}" class="fas fa-clock"
                style="
                width: fit-content;
                font-size:18px;
                color:rgb(255, 111, 0);
                margin-left:10px;">
            </span>
        </div>
    @elseif($signalement->status == 1)
        <div class="col-sm-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary inactive" disabled id="{{$signalement->id}}">Consulter</button>
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
