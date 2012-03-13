<?php

require_once '../includes/db.php';

$places_xml = simplexml_load_file('splash_pads.kml');

$sql = $db->prepare('
	INSERT INTO locations (name, longitude, latitude)
	VALUES (:name, :longitude, :latitude)
');

foreach ($places_xml->Document->Folder[0]->Placemark as $place) {
	$coords = explode(',', trim($place->Point->coordinates));
	$sql->bindValue(':name', $place->name, PDO::PARAM_STR);
	$sql->bindValue(':longitude', $coords[0], PDO::PARAM_STR);
	$sql->bindValue(':latitude', $coords[1], PDO::PARAM_STR);
	$sql->execute();
}

//var_dump($sql->errorInfo());


?>