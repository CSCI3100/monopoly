<?php
foreach (glob("./class/*.php", GLOB_NOCHECK) as $filename) {
    require "$filename";
}

$SERVER_ADDR = $_SERVER['SERVER_NAME'];

$settings = array();
$settings["start_money"] = 1500;
$settings["round_time"] = 60;
$settings["round_money"] = 200;


//luck card point
$luckArray = array(5, 9);


//declare all buildings
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

$building = new building();
$building->rname = "UC BALL";
$building->name = "ucballMarker";
$building->x = "22.42098635438072";
$building->y = "114.20546650886536";
$building->img = "ucball.png";
$building->price = 1;
$building->rent = 2000;
$building->stopNo = 16;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "Shaw College";
$building->name = "shawMarker";
$building->x = "22.422289299852565";
$building->y = "114.20123398303986";
$building->img = "shaw.png";
$building->price = 1;
$building->rent = 15;
$building->stopNo = 20;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "NA Tower";
$building->name = "natowerMarker";
$building->x = "22.420754525503735";
$building->y = "114.20861139893532";
$building->img = "natower.png";
$building->price = 1;
$building->rent = 2000;
$building->stopNo = 13;
array_push($buildingArray, $building);
?>