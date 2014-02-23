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
array_push($buildingArray, $building);

$building = new building();
$building->rname = "cc admin building";
$building->name = "stationMarker";
$building->x = "22.41439581682375";
$building->y = "114.20845784246922";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 1;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "wong fok yuen";
$building->name = "stationMarker";
$building->x = "22.414921484418553";
$building->y = "114.20784629881382";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 2;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "chans bldg";
$building->name = "stationMarker";
$building->x = "22.415366564624026";
$building->y = "114.20760624110699";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 3;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "Sino";
$building->name = "stationMarker";
$building->x = "22.41561947864573";
$building->y = "114.20752845704556";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 4;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "CC staff canteen";
$building->name = "stationMarker";
$building->x = "22.41627779680755";
$building->y = "114.2077524214983";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 5;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "new eng-bld";
$building->name = "stationMarker";
$building->x = "22.417300601321244";
$building->y = "114.2081319540739";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 6;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "edu research";
$building->name = "stationMarker";
$building->x = "22.417162988061555";
$building->y = "114.20722402632236";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 7;
array_push($buildingArray, $building);


$building = new building();
$building->rname = "HSB";
$building->name = "stationMarker";
$building->x = "22.418334556046702";
$building->y = "114.20744396746159";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 8;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "shaw sci";
$building->name = "stationMarker";
$building->x = "22.418633335295212";
$building->y = "114.20802064239979";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 9;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "BMSB";
$building->name = "stationMarker";
$building->x = "22.41893087415704";
$building->y = "114.20898891985416";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 10;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "sir run run";
$building->name = "stationMarker";
$building->x = "22.419840843220154";
$building->y = "114.20710198581219";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 11;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "pi chu";
$building->name = "stationMarker";
$building->x = "22.419840843220154";
$building->y = "114.20629061758518";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 12;
array_push($buildingArray, $building);



$building = new building();
$building->rname = "water tower";
$building->name = "stationMarker";
$building->x = "22.420642949970436";
$building->y = "114.20820839703083";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 13;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "14";
$building->name = "stationMarker";
$building->x = "22.421094210464293";
$building->y = "114.20756734907627";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 14;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "15";
$building->name = "stationMarker";
$building->x = "22.420602038919093";
$building->y = "114.20604787766933";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 15;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "16";
$building->name = "stationMarker";
$building->x = "22.420349133970557";
$building->y = "114.20504473149776";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 16;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "lsk";
$building->name = "stationMarker";
$building->x = "22.419964816745452";
$building->y = "114.2031229287386";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 17;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "LKK";
$building->name = "stationMarker";
$building->x = "22.419958618071814";
$building->y = "114.20292042195797";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 18;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "wys";
$building->name = "stationMarker";
$building->x = "22.42188639223504";
$building->y = "114.20258648693562";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 19;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "SHAW bldg";
$building->name = "stationMarker";
$building->x = "22.42207111002635";
$building->y = "114.20151494443417";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 20;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "Shaw hostel";
$building->name = "stationMarker";
$building->x = "22.423088913046463";
$building->y = "114.20101471245289";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 21;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "jail";
$building->name = "stationMarker";
$building->x = "22.42580632377871";
$building->y = "114.20544371008873";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 22;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "staff hostel";
$building->name = "stationMarker";
$building->x = "22.425343921419284";
$building->y = "114.20776315033436";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 23;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "park";
$building->name = "stationMarker";
$building->x = "22.41998093329562";
$building->y = "114.21285666525364";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 24;
array_push($buildingArray, $building);

$building = new building();
$building->rname = "AIT";
$building->name = "stationMarker";
$building->x = "22.416195972121077";
$building->y = "114.21140559017658";
$building->img = "station.png";
$building->price = 2000;
$building->rent = 100;
$building->stopNo = 25;
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
