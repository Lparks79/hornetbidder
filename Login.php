<?php session_start(); ?>
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
   
   /* page styling */
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
<CENTER>
<?php 
include("connect.php");

if (!isset($_POST['submit'])) {//Display plain Form for fist visit.
?>
	<FORM name="Login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	Username: <input type="text" name="user" /> <br /><br />  
	Password: <input type="password" name="pwd" /> <br /><br />
	<input type="submit" value="submit" name="submit"/>
<?php
}
else {
	$User=$_POST["user"];
	$Password=$_POST["pwd"];


	$query="SELECT Id, Username, Password from Users WHERE Username=$1 AND Password=md5($2)";
	$result = pg_query_params($query, array($User, $Password));
	
	
	if (pg_numrows($result) == 0){ //User not found
		echo "<CENTER><H1>Invalid Username and/or Password.<br />";
		echo '<a href="Login.php">Login</a>';
		echo "</H1></CENTER>";
		}
	elseif (pg_numrows($result) == 1){ // User found, store session User id
		$row = pg_fetch_array($result, 0);
		$_SESSION['UserId'] = $row['id'];
		echo "<H2><CENTER>Login Success</CENTER><H2>";
		echo '<meta http-equiv="REFRESH" content="3;url=Main.php">';
		}
	else {
		echo "<CENTER><H1>Login error has occured.<br />";
		echo '<a href="Login.php">Login</a>';
		echo "</H1></CENTER>";
		}
	}
?>

</CENTER>
</FORM>
</BODY>
</HTML>