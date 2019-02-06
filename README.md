# mySQL connect notes 2015

# Local Client Machine

A local client machine (e.g. running apache and PHP) cannot connect to the remote MySQL server using TCP/IP (rather than local UNIX sockets).

MySQL defaults disable this for security reasons. Obviously this is the same if you treat MySQL as local and client machine as remote.

It is also possible that the user privileges for the MySQL server have been set up in such a way that only localhost (same machine) login is permitted.

# Local socket connections

It is safer to use only local socket connections on the MySQL server

`http://www.cyberciti.biz/tips/how-do-i-enable-remote-access-to-mysql-database-server.html`

To faciliate remote logins, some people suggest turning off the `myssql.secure_connection` in the `php.ini` but that is not secure

A better option is to grant access to only specified remote IP addresses (if you know it is static), with password authentication and secure connection.

Set this from within MySQL.   Bots look for open MySQL connections so be careful.

Maybe use a combination of `mysqli_init()` and `mysql_real_connect` - See `http://dev.mysql.com/doc/apis-php/en/apis-php-mysqli.real-connect.html`


Here is an explanation of the command and its options, including port, socket, secure connection etc:

`http://www.w3schools.com/php/func_mysqli_real_connect.asp`
  
Note for future reference that in MySQL one of the engines allows you to store the data in CSV.

`http://dev.mysql.com/doc/refman/5.6/en/csv-storage-engine.html`
