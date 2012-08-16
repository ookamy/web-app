<?php

// opens a connection to the MySQL database
// Shared between all the PHP files in our application

// Our username and password are kept in Environment variables, in .htaccess
// This is for security, so they are never publicly visible in Github

$user = getenv('MYSQL_USERNAME');
$pass = getenv('MYSQL_PASSWORD');
$name= getenv('MYSQL_DB_NAME');
$host= getenv('MYSQL_DB_HOST');


$data_source = sprintf('mysql:host=%s;dbname=%s', $host, $name );

//PDO -> php data objects
$db = new PDO($data_source, $user, $pass);
$db->exec('SET NAMES utf8');


