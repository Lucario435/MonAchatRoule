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
    <div class="col-1" style="border-left: 1px solid;">&nbsp;</div>
    <div class="col-6" style="word-wrap:break-word;">
        {{ $signalement->mcontent }}fqweqewewrwr weqwdqweqweqweqwe
    </div>
    @if ($signalement->status == 0)
        <div class="col-3 text-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary">Traiter</button>
            <span class="col-1 fas fa-clock"
                style="
                        width: fit-content;
                        font-size:18px;
                        color:rgb(255, 111, 0);
                        padding-left:5px;">
            </span>
        </div>
    @elseif($signalement->status == 1)
        <div class="col-3 text-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary inactive" disabled>Traiter</button>
            <span class="fas fa-check"
                style="
                    width: fit-content;
                    font-size:18px;
                    color:green;
                    padding-left:5px;
                    "
                ddata-bs-toggle="tooltip" data-bs-title="Default tooltip">
            </span>
        </div>
    @endif
</div>