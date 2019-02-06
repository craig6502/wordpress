<?php 
 //Last updated 29 November 2015
 //Use with DBform.html to get the record number 

 // Connects to your Wordpress MySQL Database (login works if this file is on the same server) 
$username = "uname";
$password = "pw";
$hostname = "IP:PORT"; //This is IP address of DATABASE server.  Maybe port number needs to be after a comma not a semi-colon?


/*

 --------------------------
 Database backups
 --------------------------
 
  Note for future reference that in MySQL one of the engines allows you to store the data in CSV, http://dev.mysql.com/doc/refman/5.6/en/csv-storage-engine.html
  it might be useful for import/export to Excel.   Setup with innoDB (default) engine for now.   Or setup a temp table with CSV for an import.
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
/* the line to override the html content in wordpress.  
Send it to the browser as an introduction!  Must appear before othr output  */ 
header('Content-Type:text/plain');
echo "Passed value for Text box:".$text_box;  //this uses post 'name' parameter, not the post field id
echo "Connected to MySQL<br>";
//DB name
// Check connection
if (!$dbhandle) {
    die("Connection failed: " . mysql_connect_error());
}

/*
  --------------------------
  SELECT DATABASE (NAME) TO WORK WITH
   --------------------------
 
This will need to be the database name given to you by the ISP, if it sets everything up.
Otherwise, use your own on a local server.
 
 */  
 
$selected = mysql_select_db("dbname",$dbhandle)
  or die("Could not select database");
  
  /*
  --------------------------
  RETURN DESIRED RECORDS USING A MYSQL QUERY
   --------------------------
 
execute the SQL query and return records (the ID is the default ref that Wordpress uses to refer to posts in URL)

write this up as a function that accepts post number etc as parameter passed to function.  Maybe have a listbox to choose from on a form
 
 */ 
 //echo phpinfo();  iinet uses php 5.2.17 so mysql_query still works


/* 

Extract single wp_posts entry based on ID, using input variable from POST form

*/

$queryme="SELECT post_title, post_content, post_date FROM wp_posts WHERE ID="."'".$number_two."'";
$result = mysql_query($queryme);
$row = mysql_fetch_array($result);
//This returns fields from $result array; it assumes only one result in array?
$paragraph=$row{'post_content'};  //This is the main content of a Wordpress post in wp_posts table
$title=$row{'post_title'};
$date=$row{'post_date'};
echo "#".$number_two." Here is the single record: ".$title.",".$paragraph.",".$data;
 //echo $number_two." hahahahah \n\r";
 
/*
FIND OUT HOW MANY ROWS IN THE TABLE
*/

$result=mysql_query("SELECT ID FROM wp_posts WHERE ID IS NOT NULL");
$count = mysql_num_rows($result);
echo $count." records in wp_posts";

/*

Return all records and output them.  The SQL order by will determine array order

*/
$queryme="SELECT * FROM wp_posts ORDER BY ID DESC";
$result = mysql_query($queryme);

while ($row = mysql_fetch_array($result)) {
	$IDthis=$row{'ID'}; 
	$paragraph=$row{'post_content'};  //This is the main content of a Wordpress post
   $title=$row{'post_title'};
   $date=$row{'post_date'};
$lp=strlen($title);
$a=50; //specify how many characters to print from title
$leftttl=substr($title,0,$a);
$lefttcont=substr($paragraph,0,$a);
echo "<----".$IDthis."---->,".$leftttl.",".$lefttcont.",".$date;
}





/*  finished */
echo "<br>--------<br>Done";
//close the connection
mysql_close($dbhandle);
?>
