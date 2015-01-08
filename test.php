<?php

	$data = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=dijon");
	$data = json_decode($data);
	$lat = $data->results[0]->geometry->location->lat;
	$lng = $data->results[0]->geometry->location->lng;

	$data2 = file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=s&types=(cities)&location=$lat,$lng&radius=10&components=country:fr&key=AIzaSyBuYcbpBiCkfdj-c8GBRDdCggFx6z4GTuc");
	$data2 = json_decode($data2);
	var_dump($data2);




 ?>