<HTML>
<head>
<title>Hornet Bidder</title>
<style>
   /* Bar Styling */
   #nav {
      width: 100%;
      float: left;
      margin: 0 0 3em 0;
      padding: 0;
      list-style: none;
      background-color: #008000;
      border-bottom: 1px solid #ccc; 
      border-top: 1px solid #ccc; }
   #nav li {
      float: left; }
   #nav li a {
      display: block;
      padding: 8px 15px;
      text-decoration: none;
      font-weight: bold;
      color: #FFFFFF;
      border-right: 1px solid #ccc; }
   #nav li a:hover {
      color: #008000;
      background-color: #fff; }
   /* bar styling. */
   
   /* page styling*/
   body {
      font: small/1.3 Arial, Helvetica, sans-serif; }
   #wrap {
      width: 750px;
      margin: 0 auto;
      background-color: #fff; }
   h1 {
      font-size: 1.5em;
      padding: 1em 8px;
      color: #333;
      background-color: #008000;
      margin: 0; }
   #content {
      padding: 0 50px 50px; }
</style>
</head>
<BODY>
<div id="wrap">
   <h1>Hornet Bidder</h1>
   
   <!--navigation links -->
   <ul id="nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="Login.php">Login</a></li>
      <li><a href="RegisterForm.php">Register</a></li>
      <li><a href="about.html">About</a></li>
   </ul>
   
   <div id="content">   
<?php
include("connect.php");

$User=$_POST["user"];
$Pwd=$_POST["pwd"];
$Fname=$_POST["fname"];
$Lname=$_POST["lname"];
$Street=$_POST["street"];
$City=$_POST["city"];
$State=$_POST["state"];
$Zip=$_POST["zip"];
$Email=$_POST["email"];
	

$query="SELECT * from Users WHERE Username=$1";
$result = pg_query_params($query, array($User));
if (pg_numrows($result) > 0){ //Duplicate Username in database
	echo "<CENTER><H1>Registation error, Username already exists in the database.<br />";
	echo '<a href="Login.php">Login</a>';
	echo "</H1></CENTER>";
	}
else {
	$query="INSERT INTO Users (Username, Password, Fname, Lname, Street, City, State, Zip, Email) VALUES ($1, md5($2), $3, $4, $5, $6, $7, $8, $9)";
	$result = pg_query_params($query, array($User, $Pwd, $Fname, $Lname, $Street, $City, $State, $Zip, $Email));
	if ($result) { 
		echo "<CENTER><H1>You have been registered. Login to continue.<br />";
		echo '<a href="Login.php">Login</a>';
		echo "</H1></CENTER>";
		}
	else {
		echo "<CENTER><H1>Registation error, try again. <br />";
		echo '<a href="RegisterForm.php">Register</a>';
		echo "</H1></CENTER>";
		}
	}
	
?>
</BODY>
</HTML>