<?php 
$config = array(
	'host'		=> '127.0.0.1',
	'username'	=> 'root',
	'password'	=> '',
	'dbname' 	=> 'mono'
);
//connecting to the database by supplying required parameters
try{
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
} catch (PDOException $e){
    die($e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>