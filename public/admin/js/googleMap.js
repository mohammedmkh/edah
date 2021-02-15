$( document ).ready(function() {


    var lat = $('.shop-detail #latitude').val();
    var lang = $('.shop-detail #longitude').val();
    var radius = $('.shop-detail #radius').val();
    var shop_name = $('.shop-detail #shop_name').val();
    var latlng = new google.maps.LatLng(lat, lang);
    var mapOptions = {
    zoom: 8,
    center: latlng
    }

    shop_map = new google.maps.Map(document.getElementById('shop_map'), mapOptions);

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lang),
        title: shop_name,
        map: shop_map,
        icon:"http://192.168.0.116:10/images/shop.png",
        draggable: false
    }); 

    var circle = new google.maps.Circle({
        center: latlng,
        map: shop_map,
        radius: radius*1000,         
        fillColor: '#29aa30',
        fillOpacity: 0.3,
        strokeColor: "#29aa30",
        strokeWeight: 1       
    });

});