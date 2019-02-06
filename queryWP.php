<?php 
 // Connects to your Wordpress MySQL Database (login works if this file is on the same server)

//Setup: enter wordpress details here:

$username = "";
$password = "";
$hostname = "IP:port"; 


/*

 --------------------------
 Database backups
 --------------------------
 
  Note for future reference that
  In MySQL one of the engines allows you to store the data in CSV:

  http://dev.mysql.com/doc/refman/5.6/en/csv-storage-engine.html
  
  Setup with innoDB (default) engine for now.   
  OR: use temp table with CSV for an import.
*/

/*
 --------------------------
 connection to the database
  --------------------------

The following function call will work if the requesting php file is on the same server as the database. i.e. it is residing on the server, so it is making a local file request. 
At present, this requires that file to use the main username and password, which is not so secure.
It may be best to create another user for this, which can be deleted if required.  TO DO

In any case, it is still safer to do this than to connect remotely from another machine via UNIX sockets? 
see http://www.cyberciti.biz/tips/how-do-i-enable-remote-access-to-mysql-database-server.html

One of the reasons for this is that otherwise, the local client accessing the browswe must connect to the remote MySQL.  What are the options?
If TCP/IP is used (rather than local UNIX socket)

A better option is to grant access to only specified remote IP addresses (if you know it is static), with password authentication and secure connection.
    Set this from within MySQL.   Bots look for open MySQL connections so be careful.
  Maybe use a combination of mysqli_init() and mysql_real_connect - See http://dev.mysql.com/doc/apis-php/en/apis-php-mysqli.real-connect.html
  Here is an explanation of the command and its options, including port, socket, secure connection etc http://www.w3schools.com/php/func_mysqli_real_connect.asp
  
*/

$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL"); 
  
echo "Connected to MySQL<br>";
//DB name

/*
  --------------------------
  SELECT DATABASE (NAME) TO WORK WITH
   --------------------------
 
This will need to be the database name given to you by the ISP, if it sets everything up.
Otherwise, use your own on a local server.
 
 */  
 
$selected = mysql_select_db("databasename",$dbhandle)
  or die("Could not select database");
  
  /*
  --------------------------
  RETURN DESIRED RECORDS USING A MYSQL QUERY
   --------------------------
 
execute the SQL query and return records (the ID is the default ref that Wordpress uses to refer to posts in URL)

write this up as a function that accepts post number etc as parameter passed to function.  Maybe have a listbox to choose from on a form
 
 */ 
 
 
 $result = mysql_query("SELECT post_title, post_content, post_date FROM wp_posts WHERE ID='800'");

/*
   --------------------------
  FETCH DATA FROM THE DATABASE
   --------------------------
 
 */


//let's try and create an RTF
include('makeRTFfun.php');
$RTFdata; //This variable holds the string data for the RTF document to be created
initRTFdoc ();
addRTFpara('The following is my WordPress post text',1);
//loop through the query file
while ($row = mysql_fetch_array($result)) {
	$paragraph=$row{'post_content'};  //This is the main content of a Wordpress post
   echo "Title:".$row{'post_title'}." Content:".$row{'post_content'}."
   ".$row{'post_date'}."<br>";
   addRTFpara($paragraph,2);
}
echo $RTFdata;

/*
   --------------------------
  CALL THE FUNCTION THAT CREATES AN RTF FILE FROM YOUR RESULTS
   --------------------------
 
 */

writeRTFdoc($RTFdata);   

/* 

Above function currently writes to physical file.

An option is to write it as an entry to DB table etc
*/

echo "done";
//close the connection
mysql_close($dbhandle);
?>
