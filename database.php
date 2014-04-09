<?php 
$config = array(
	'host'		=> '127.0.0.1',
	'username'	=> 'monopoly',
	'password'	=> '',
	'dbname' 	=> 'mono'
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