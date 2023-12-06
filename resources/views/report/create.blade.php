@extends('partials.xlayout')

@section('title', 'Signalements')

@section('content')
    <div class="container">
        {{-- <h1>Signaler un utilisateur</h1> --}}

        <form method="post" action="{{ route('report.post') }}">
            @csrf
            <div class="form-group">
                <label for="user_target">Utilisateur à signaler</label>
                <select class="form-control" id="user_target" name="user_target"
                    @if (request('usertarget') != null) disabled style="cursor:not-allowed;" @endif>
                    <option value="-1">Aucun</option>

                    @foreach ($users as $user)
                        @if ($user->id != Auth::id())
                            <option value="{{ $user->id }}"
                                @if (request('usertarget') != null && request('usertarget') == $user->id) selected
                        {{-- marche pas? 2023-11-28 --}}
                        >

                                {{ $user->getDisplayName() }}</option>
                            @if (request('usertarget') != null && request('usertarget') == $user->id)
                                {{-- FIX quik --}}
                                <input type="hidden" name="user_target" value="{{ $user->id }}">
                            @endif
                        @endif
                    @endforeach


                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="mcontent">Motif du signalement <span style="color:red;">*</span> </label>
                <textarea class="form-control" id="mcontent" name="mcontent" rows="3" required minlength="10"></textarea>
            </div>
            <br>
            <input type="hidden" name="hideText" value="{{ request('hideText') }}">
            <button type="submit" class="btn btn-primary">Envoyer le signalement</button>

            <a href={{ url()->previous() }}><button type="button" class="btn btn-secondary">Retour</button></a>

        </form>
    </div>
@endsection
