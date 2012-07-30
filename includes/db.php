<?php

// opens a connection to the MySQL database
// Shared between all the PHP files in our application

// Our username and password are kept in Environment variables, in .htaccess
// This is for security, so they are never publicly visible in Github
$user = getenv('root'); // the MySQL username
$pass = getenv(''); // The MySQL password
$data_source = getenv('mysql:host=localhost; dbname=words');

// PDO: PHP Data Objects
// Allows us to connect to many different kinds of databases
$db = new PDO('mysql:host=localhost; dbname=words', 'root', '');

// Forse the connection to communicate in utf8
// and support many human languages (even klingon)
$db->exec('SET NAMES utf8');