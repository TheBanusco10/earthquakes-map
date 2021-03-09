<?php

header('Content-type: application/json');

$feed = simplexml_load_file('http://www.ign.es/ign/RssTools/sismologia.xml');

$array = [];

// echo json_encode($feed);

$namespaces = $feed->getNamespaces(true);

foreach ($feed->channel->item as $item) {

    preg_match("/\d+\/\d+\/\d{4}/", $item->title, $date);
    preg_match("/\d+\:\d+\:\d+/", $item->title, $time);

    $namespace = $item->children($namespaces["geo"]);
    
    array_push($array, [
        'title' => (string)$item->title,
        'description' => (string)$item->description,
        'date' => (string)$date[0],
        'time' => (string)$time[0],
        'lat' => (string)$namespace->lat,
        'long' => (string)$namespace->long
    ]);
}

echo json_encode($array);