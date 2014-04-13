<?php

/*
 * Copyright (C) 2014 Pedro Maia (pedro@pedromm.com)
 *
 * This file is part of Cidadão Atento.
 * 
 * Cidadão Atento is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Cidadão Atento is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Cidadão Atento.  If not, see <http://www.gnu.org/licenses/>.
 */

?>
<script type="text/javascript">
	$(document).ready(function(){
		var map, pointarray, heatmap, denuncias = [];
		
		$.getJSON('/denuncias/heatmap', function(data){
			$.each(data, function(key, val){
				denuncias.push(new google.maps.LatLng(val.lat, val.lng));
			});
		}).complete(function(){
			initialize();
		});
		
		function initialize() {
			var opt = {
				zoom: 5,
				maxZoom: 17,
				minZoom: 5,
				mapTypeControl: false,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				disableDefaultUI: true
			};
			
			map = new google.maps.Map(document.getElementById("mapa"), opt);
			
			pointArray = new google.maps.MVCArray(denuncias);
			
			heatmap = new google.maps.visualization.HeatmapLayer({
				data: pointArray
			});
		
			heatmap.setMap(map);
		
			var geocoder = new google.maps.Geocoder();
	
			geocoder.geocode( {'address' : 'brazil'}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK)
					map.setCenter(results[0].geometry.location);
			});
		}
	})	
</script>

<div class="span11" id="mapa" style="height: 500px;">
	
</div>