<?php

header('Content-type: application/json');

$feed = simplexml_load_file('http://www.ign.es/ign/RssTools/sismologia.xml');

$array = [];


$namespaces = $feed->getNamespaces(true);

foreach ($feed->channel->item as $item) {

    preg_match("/\d+\/\d+\/\d{4}/", $item->title, $date);
    preg_match("/\d+\:\d+\:\d+/", $item->title, $time);
    preg_match("/magnitud \d.\d/", $item->description, $magnitude);
    preg_match("/Info.terremoto/", $item->title, $title);

    $magnitude = substr((string)$magnitude[0], 9);

    $namespace = $item->children($namespaces["geo"]);

    
    array_push($array, [
        'title' => (string)$title[0],
        'link' => (string)$item->link[0],
        'date' => (string)$date[0],
        'time' => (string)$time[0],
        'magnitude' => $magnitude,
        'lat' => (string)$namespace->lat,
        'long' => (string)$namespace->long
    ]);
}

echo json_encode($array);