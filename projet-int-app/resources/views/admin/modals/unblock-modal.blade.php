<div class="modal fade" id="unBlockUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Débloquer un utilisateur</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-process-unblock">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir débloquer <b><span id="pseudo"></span></b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Oui</button>
                </div>
            </form>
        </div>
    </div>
</div>