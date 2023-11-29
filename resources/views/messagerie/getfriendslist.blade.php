@php
    use App\Models\User;
@endphp

@foreach ($flist as $contact)
    @if ($contact == Auth::user())
        @continue
    @endif
    @if ($contact != $selected)
            <div class="cdiv unselectedTarget" userid={{ $contact->id }}>
        @else
            <div class="cdiv selectedTarget" userid={{ $contact->id }}>
    @endif
    <img src="{{ $contact->getImage() }}" alt="" title="{{ $contact->getDisplayName() }}">
    </div>
@endforeach

<style>
    .cdiv {

        height: 2rem;
        width: 2rem;
        margin-bottom: 10px;
        margin-left: .5rem;

    }
    .cdiv:hover{
        cursor:pointer;
    }
    .selectedTarget>img{
        outline: solid 3px var(--blueForms) !important;
        /* transition: .2s; */
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    }
    .cdiv>img {
        object-fit: cover;
        height: 100%;
        width: 100%;
        border-radius: 100%;
        outline: solid 1px rgb(192, 192, 192);
        transition: .1s;
    }
    .cdiv>img:hover{
        outline: solid 1px rgb(126, 126, 126);
        transition: .1s;
    }
</style>
