<div class='search-bar strip'>
	<form method="GET" action="{{ url('search') }}" enctype="multipart/form-data">
        <select name='metier'>
            <optgroup label="{{ __('person') }}">
                <option value='deejay' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'deejay')) ? 'selected' : '' ?>>
                {{ __('deejay') }}</option>
                <option value='musician' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'musician')) ? 'selected' : '' ?>>
                {{ __('musician') }}</option>
                <option value='animator' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'animator')) ? 'selected' : '' ?>>
                {{ __('animator') }}</option>
                <option value='barman' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'barman')) ? 'selected' : '' ?>>{{ __('barman') }}</option>
                <option value='magician' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'magician')) ? 'selected' : '' ?>>
                {{ __('magician') }}</option>
            </optgroup>
            <optgroup label="{{ __('society') }}">
                <option value='caterer' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'caterer')) ? 'selected' : '' ?>>
                {{ __('caterer') }}</option>
                <option value='cleaning' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'cleaning')) ? 'selected' : '' ?>>
                {{ __('cleaning') }}</option>
                <option value='security' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'security')) ? 'selected' : '' ?>>
                {{ __('security') }}</option>
                <option value='provider' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'provider')) ? 'selected' : '' ?>>
                {{ __('provider') }}</option>
                <option value='communication'  <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'communication')) ? 'selected' : '' ?>>{{ __('communication') }}</option>
            </optgroup>
            <optgroup label="{{ __('place') }}">
                <option value='hall_owner' <?= (isset($_SESSION['metier']) && ($_SESSION['metier'] == 'hall_owner')) ? 'selected' : '' ?>>
                {{ __('hall_owner') }}</option>
            </optgroup>
        </select>
		<input type='text' name='city' id='city' placeholder='Ville' autocomplete="off" 
               value="<?= (isset($_SESSION['city'])) ? $_SESSION['city'] : '' ?>">
		<button type="submit" class="btn btn-primary">{{ __('to_search') }}</button>
	</form>
</div>
@include('audios.player')
<div id="map_canvas"></div>

<script type="text/javascript"  src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDr8CN8eh5O1vpwWse5FW5mjxi3ZanUjsE"></script>
<script type="text/javascript">
$(function(){
	
    function initialize() {
        var input = document.getElementById('city');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.setComponentRestrictions({'country': ['be']});
        autocomplete.setFields(['name']);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    

});

</script>