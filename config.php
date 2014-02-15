<?php
require "./class/building.php";
$settings = array();
$settings["start_money"] = 1500;
$settings["round_time"] = 60;
$settings["round_money"] = 200;


//luck card point
$luckArray = array(5, 9);


//delcare all buildings
$buildingArray = array();

//buildings
$building = new building();
$building->rname = "University Station";
$building->name = "stationMarker";
$building->x = "22.41399040673042";
$building->y = "114.2097795009613";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 0;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "YIA";
$building->name = "yiaMarker";
$building->x = "22.415771970700987";
$building->y = "114.21096369626184";
$building->img = "yia.png";
$building->price = 10000;
$building->rent = 800;
$building->stopNo = 26;
array_push($buildingArray, $building);
?>