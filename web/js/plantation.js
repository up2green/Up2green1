var moveToMarker = function(lat, lng){
	var marker = new google.maps.LatLng(lat, lng);
	map.setCenter(marker);
}

var updateBoutonsBulle = function(id){
    alert("bubulle");
    if ($("#addArbreProgramme_"+id).hasClass('gray')){
	$("#addArbreProgrammeMap_"+id).removeClass('green');
	$("#addArbreProgrammeMap_"+id).addClass('gray');
    }
    if ($("#removeArbreProgramme_"+id).hasClass('green')){
	$("#removeArbreProgrammeMap_"+id).removeClass('gray');
	$("#removeArbreProgrammeMap_"+id).addClass('green');
    }
//    $("#addArbreProgrammeMap_"+id).attr('class', $("addArbreProgramme_"+id).attr('class'));
//    $("#removeArbreProgrammeMap_"+id).attr('class', $("removeArbreProgramme_"+id).attr('class'));
//    alert($("#addArbreProgrammeMap_"+id).attr('class'));
}

/*
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
*/

$(document).ready(function(){
	
	// list modules sccrollable	
	$(".scrollableWrapper").each(function() {
		self = $(this);
		$("ul.scrollable", self).scrollTo( 0 ); 
		var size = 120;
	
		$("span.slideUp", self).click(function(){
			$("ul.scrollable", self).scrollTo(
				'-=' + size + 'px', 
				{speed:500, axis:'y', queued:true}
			);
		});
	
		$("span.slideDown").click(function(){
			$("ul:first", self).scrollTo(
				'+=' + size + 'px', 
				{speed:500, axis:'y', queued:true}
			);
		});
	});
	
});
