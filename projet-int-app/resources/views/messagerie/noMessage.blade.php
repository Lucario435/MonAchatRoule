

<div class="bleuTileContact">
    @if (isset($u2))
        <img class="bleuTileImg" src="{{ $u2->getImage() }}" alt="">
        <span class="espaced">{{ $u2->getDisplayName() }}</span>
        <br>
    @endif
    <span class="espaced soutitre">{!! $xmsg !!}</span>
</div>

<style>
    .soutitre>i{
        border-bottom: 1px solid white;
    }
    .bleuTileImg{
        margin-top: .5rem;
        margin-left: .5rem;
        width: 3rem;
        height: 3rem;
        border-radius: 100%;
    }
</style>
