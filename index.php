<?php session_start();
include ("connect.php"); 
include ("HornetBidderFunctions.php");
?>
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
	  <?php 
	  if(isset($_SESSION['UserId']) AND $_SESSION['UserId'] != 0){
	    echo '<li><a href="Logout.php">Logout</a></li>';
		echo '<li><a href="Auction.php">Auction</a></li>';
		echo '<li><a href="Purchase.php">Pay</a></li>';
		echo '<li><a href="TheDump.php">Table Dumps</a></li>';
		echo '<li><a href="Reports.php">Reports</a></li>';
	  }
	  else{
		$_SESSION['UserId'] = 0;// 0=guest
        echo '<li><a href="Login.php">Login</a></li>';
        echo '<li><a href="RegisterForm.php">Register</a></li>';
	  }
	  ?>
      <li><a href="about.html">About</a></li>
   </ul>
   
   <div id="content">   
<?php
UpdateStatus();

if (isset($_POST['Search'])){ //User has selected a category
	$catId = $_POST['formSelect'];
	$query="SELECT * from Categories WHERE ParentCategory=$1";
	$result = pg_query_params($query, array($catId));
}
else { //first time on page and has not selected a category
	//$catId = 'IS NULL';
	$query="SELECT * from Categories WHERE ParentCategory IS NULL";
	$result = pg_query($query); 
}
//display categories
if (pg_numrows($result) > 0){ //Display Categories and Number of Items in Category?
	echo "<BR /><CENTER>Select a category</CENTER><BR />";
	echo '<CENTER><FORM name="formCategories" action='.$_SERVER['PHP_SELF'].' method="post">'; //repost to self.
	echo '<select name="formSelect">';
	while ($rowCat = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
		echo "<option value=".$rowCat["id"].">".$rowCat["name"]."</option>";
	}
	echo "</select>";
	echo '<input type="submit" value="Search" name="Search"/>';
	echo "</FORM></CENTER>";
}
else {
	//if (isset($_POST['formSelect'])){
	DisplayMatches($_POST['formSelect']);
}

?>
</BODY>
</HTML>