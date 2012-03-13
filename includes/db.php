<?php

ini_set('display_errors', 1); 

// Gets an environment variable we created in the .htaccess file
// This is the best way to keep usernames and passwords out of public GitHub repos
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dsn = getenv('DB_DSN');

// We are using PDO to abstract away the database type we are connecting to
// PDO allows us to connect to many different database types: MySQL, SQLite, MSSQL, Oracle, etc.
// http://php.net/pdo

// Open a connection to the database and store it in a variable
$db = new PDO($dsn, $user, $pass);

// Makes sure we talk to the database in UTF-8, so we can support more than just English
$db->exec('SET NAMES utf8');
