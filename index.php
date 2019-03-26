<?php

	$host = "localhost";
	$user = "postgres";
	$pass = "root";
	$port = "5432";
	$dbname = "or7_gis";
	$conn = pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$pass) or die("Gagal");

ini_set('memory_limit', '128000M');
$sql  = "SELECT  
			ST_AsGeoJSON(geom) AS geometry,
			propinsi
		FROM indonesia_prop
		";
		$geojson = array(
			'type'      => 'FeatureCollection',
			'features'  => array()
		);
		$query = pg_query($sql);
		if(pg_num_rows($query)==0) return 0;
		while($rows=pg_fetch_assoc($query)){
			$feature = array(
				"type" => 'Feature',
				'geometry' => json_decode($rows['geometry'], true),
				'properties' => array(
					'propinsi' => $rows['propinsi']
				)
			);
			array_push($geojson['features'], $feature);
		}
		echo json_encode($geojson);