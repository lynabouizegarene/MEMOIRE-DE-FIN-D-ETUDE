var autocomplete_depart, autocomplete_arrivee;

function initialize() {
    var options = { types: ['(cities)'] , componentRestrictions: {country: 'dz'}};
    autocomplete_depart = new google.maps.places.Autocomplete((document.getElementById('autocomplete_d')), options);
    autocomplete_arrivee = new google.maps.places.Autocomplete((document.getElementById('autocomplete_a')), options);
    google.maps.event.addListener(autocomplete_depart, 'place_changed', function() {fillInAddress_d();});
    google.maps.event.addListener(autocomplete_arrivee, 'place_changed', function() {fillInAddress_a();});
}

function fillInAddress_d() {
    var place = autocomplete_depart.getPlace();

    document.getElementById('ville_d').value = '';
    document.getElementById('wilaya_d').value = '';
    document.getElementById('geoloc_d').value = '';

    if (place.geometry.location);
    document.getElementById('geoloc_d').value = place.geometry.location;

    for(var i=0;i<place.address_components.length; i++){
        if(place.address_components[i].types[0]=='locality'|| place.address_components[i].types[0]=='administrative_area3')
        {
            document.getElementById('ville_d').value = place.address_components[i].long_name;
        }
        if(place.address_components[i].types[0]=='administrative_area_level_1'   )
        {
            document.getElementById('wilaya_d').value = place.address_components[i].long_name;
        }
    }
}
function fillInAddress_a() {
    var place = autocomplete_arrivee.getPlace();

    document.getElementById('ville_a').value = '';
    document.getElementById('wilaya_a').value = '';
    document.getElementById('geoloc_a').value = '';

    if (place.geometry.location);
    document.getElementById('geoloc_a').value = place.geometry.location;

    for(var i=0;i<place.address_components.length; i++){
        if(place.address_components[i].types[0]=='locality'|| place.address_components[i].types[0]=='administrative_area3')
        {
            document.getElementById('ville_a').value = place.address_components[i].long_name;
        }
        if(place.address_components[i].types[0]=='administrative_area_level_1'   )
        {
            document.getElementById('wilaya_a').value = place.address_components[i].long_name;
        }
    }
}