<?php 
$url=parse_url(getenv("CLEARDB_DATABASE_URL"));
$server = 'us-cdbr-azure-west-a.cloudapp.net';
$username = 'b1ba210c3a593d';
$password = '6a0f2926';
$db = 'as_d509adc2ea20910';
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