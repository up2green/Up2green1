var moveToMarker = function(lat, lng){
	var marker = new google.maps.LatLng(lat, lng);
	map.setCenter(marker);
}

google.maps.Map.prototype.markers = new Array();

google.maps.Map.prototype.getMarkers = function() {
	return this.markers
};

google.maps.Map.prototype.clearMarkers = function() {
	for(var i=0; i<this.markers.length; i++){
			this.markers[i].setMap(null);
	}
	this.markers = new Array();
};

google.maps.Marker.prototype._setMap = google.maps.Marker.prototype.setMap;

google.maps.Marker.prototype.setMap = function(map) {
	if (map) {
			map.markers[map.markers.length] = this;
	}
	this._setMap(map);
}

$(document).ready(function(){
	
	$("ul:first", "#form_programme_plantation").scrollTo( 0 ); 
	size = 5 * $("ul:first > li", "#form_programme_plantation").height();
	
	$("#slideUp").click(function(){
		$("ul:first", "#form_programme_plantation").scrollTo(
			'-=' + size + 'px', 
			{speed:1000, axis:'y', queued:true}
		);
	});
	
	$("#slideDown").click(function(){
		$("ul:first", "#form_programme_plantation").scrollTo(
			'+=' + size + 'px', 
			{speed:1000, axis:'y', queued:true}
		);
	});

});
