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
    <div class="col-2 username" style="word-wrap:break-word;">
        {{ $user->username }}
    </div>
    <div class="col-1 p-0" style="border-left: 1px solid; width:10px;">&nbsp;</div>
    <div class="col-6 description"
        style="white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-heigth: 50px;">
        {{ $user->name }},{{ $user->surname }}
    </div>
    <span class="blocked" style="display:none;">{{ $user->is_blocked }}</span>
    @if ($user->is_blocked == 0)
        <div class="col-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary inactive" id="{{ $user->id }}" data-bs-toggle="modal"
                data-bs-target="#blockUserModal" style="width:96px;">Bloquer</button>
            <span title="non-bloqué" class="fas fa-user-check"
                style="
                        width: fit-content;
                        font-size:25px;
                        color:green;
                        margin-left:15px;">
            </span>
        </div>
    @elseif($user->is_blocked == 1)
        <div class="col-3 d-flex align-items-center justify-content-center" style="word-wrap:break-word;">
            <button type="button" class="btn btn-primary inactive" data-bs-toggle="modal" data-bs-target="#unBlockUserModal" style="width:96px;">Débloquer</button>
            <span title="bloqué" class="fas fa-check"
                style="
                    width: fit-content;
                    font-size:25px;
                    color:red;
                    margin-left:15px;
                    ">
            </span>
        </div>
    @endif
</div>
