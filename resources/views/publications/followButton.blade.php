<div onclick="followPublication()" class="noDec button-div">
    <!--Ramener vers le controlleur pour ajouter un contact-->
    @if ($followed)
        <i class="fav-icon div-button-actions fas fa-star" style="color: orange"></i>
    @else
        <i class="fav-icon div-button-actions fa-regular fa-star"></i>
    @endif
    <label class="detail-labels div-button-actions">Suivre</label>
</div>