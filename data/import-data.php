<?php

require_once '../includes/db.php';

$places_xml = simplexml_load_file('splash_pads.kml');

$sql = $db->prepare('
	INSERT INTO locations (name, longitude, latitude, street_address)
	VALUES (:name, :longitude, :latitude, :street_address)
');

foreach ($places_xml->Document->Placemark as $place) {
	
	$name = '';
	$street_address = '';
	
	foreach ($place->ExtendedData->Data as $civic) {
		if ($civic->attributes()->name == 'Name') {
			$name = ucwords(strtolower($civic->value));
		}
		
		if ($civic->attributes()->name == 'Address') {
		$street_address = ucwords(strtolower($civic->value));
		}

	}
	
	$coords = explode(',', trim($place->Point->coordinates));
	
	$sql->bindValue(':name', $name, PDO::PARAM_STR);
	$sql->bindValue(':street_address', $street_address, PDO::PARAM_STR);
	$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
	$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
	$sql->execute();
}

var_dump($sql->errorInfo());
