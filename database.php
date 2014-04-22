<?php 
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);
$config = array(
	'host'		=> $server,
	'username'	=> $username,
	'password'	=> $password,
	'dbname' 	=> $db
);
//connecting to the database by supplying required parameters
try{
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password'],
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e){
    die($e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>