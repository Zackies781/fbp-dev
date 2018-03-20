<?php

 // this will avoid mysql_connect() deprecation error, 
 error_reporting( ~E_ALL & ~E_DEPRECATED &  ~E_NOTICE );
 // I strongly suggest you to use PDO or MySQLi.
 
 define('DBHOST', 'localhost');
 define('DBUSER', 'root');
 define('DBPASS', 'asdf1234');
 define('DBNAME', 'fbpkhairat');
 
 //define('DBHOST', 'localhost');
 //define('DBUSER', 'adminKK');
 //define('DBPASS', 'p@ssword123#');
 //define('DBNAME', 'fbpsbcom_KhairatKematian');

 //define('DBHOST', 'localhost:3306');
 //define('DBUSER', 'fbpsbcom_adminKK');
 //define('DBPASS', 'p@ssword123#');
 //define('DBNAME', 'fbpsbcom_KhairatKematian');
 
 $conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
 
 // Check connection
 if (mysqli_connect_errno()) {
  echo "Unable to connect to database: " . mysqli_connect_error();
 }
?>