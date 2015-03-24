<?php session_start();
include ("connect.php"); 
include ("HornetBidderFunctions.php");
?>
<HTML>
<head>
<title>Hornet Bidder</title>
<style>
   /*Bar Styling */
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
      <li><a href="Logout.php">Logout</a></li>
	  <li><a href="Auction.php">Auction</a></li>
	  <li><a href="Purchase.php">Pay</a></li>
      <li><a href="TheDump.php">Table Dump</a></li>
	  <li><a href="Reports.php">Reports</a></li>
      <li><a href="about.html">About</a></li>
   </ul>
   
   <div id="content">   
 <center>
<?php
if (!isset($_POST['submit']) AND !isset($_POST['Select'])) //Display plain Form for fist visit.
{
?>
<center>
<FORM name="formAuction" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
Title: <input type="text" name="title" /><br /><br />
Description: <input type="textbox" name="description" /><br /><br />
Start price: <input type="textbox" name="price" /><br /><br />
<input type="submit" name="submit" value="submit" />
</center>
</FORM>
<?php
}
else {
	$Title = $_POST['title'];
	$Description = $_POST['description'];
	$Price = $_POST['price'];
	$eTitle = "";
	$eDescription = "";
	$ePrice = "";
	$error = 0;
	
	if($Title == "") {$eTitle="Must enter a title"; $error = 1;}
	if($Description == "") {$eDescription="Must enter a Description"; $error = 1;}
	if($Price ==  "") {$ePrice="Invalid price"; $error = 1;}
	
	if($error == 1){
		echo '<center><FORM name="formAuction" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
		echo 'Title: <input type="text" name="title" value="'.$Title.'"/>'.$eTitle.'<br /><br />';
		echo 'Description: <input type="text" name="description" value"'.$Description.'" />'.$eDescription.'<br /><br />';
		echo 'Start price: <input type="text" name="price" value"'.$Price.'" />'.$ePrice.'<br /><br />';
		echo '<input type="submit" name="submit" value="submit" /></FORM></center>';
	}
	Else {//display categories
		
		
		if (isset($_POST['Select'])){ //User has selected a category
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
			echo "</select><br /><br />";
			echo '<input type="submit" value="Select" name="Select"/><br /><br />';
			echo 'Title: '.$Title.'<input type="hidden" value="'.$Title.'" name="title"/><br /><br />';
			echo 'Description: '.$Description.'<input type="hidden" value="'.$Description.'" name="description"/><br /><br />';
			echo 'Price: '.$Price.'<input type="hidden" value="'.$Price.'" name="price"/><br /><br />';
			echo "</FORM></CENTER>";
			
		}
		else { //Enter auction
			$query="INSERT INTO Item (Seller, Title, Description, EndTime, Status, Price) VALUES ($1, $2, $3, now() + '72 hours', 'active', $4) RETURNING Id";
			$result = pg_query_params($query, array($_SESSION['UserId'], $_POST['title'], $_POST['description'], $_POST['price']));
			$rowId = pg_fetch_array($result, NULL, PGSQL_ASSOC);
			$auctionId = $rowId["id"];
			$query2="INSERT INTO ItemCategories VALUES ($1, $2)";
			$result = pg_query_params($query2, array($auctionId, $catId));
			echo "Your auction is now listed";
		}
	}
	
	
	
}

?></center>
</BODY>
</HTML>