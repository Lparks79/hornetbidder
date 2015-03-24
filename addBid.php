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
<?php
UpdateStatus();//reduntant time checks
$queryPrice="SELECT Price FROM Item WHERE Id=$1";
$resultPrice=pg_query_params($queryPrice, array($_POST["ItemId"]));
$rowPrice=pg_fetch_array($resultPrice, NULL, PGSQL_ASSOC);
if($rowPrice["price"] < $_POST["bidvalue"]){//checks to see if bidder enter high enough number
	$queryBid="SELECT NOW() > Endtime AS current FROM Item WHERE Id=$1";
	$resultBid=pg_query_params($queryBid, array($_POST["ItemId"]));
	$CurrentAuction=pg_fetch_array($resultBid, NULL, PGSQL_ASSOC);

	if($CurrentAuction['current'] == TRUE){ //checks to see if time has run out
		$queryInsert="INSERT INTO Bids (AuctionNum, Bidder, Amount, bidTime) Values ($1, $2, $3, now())";
		$resultInsert = pg_query_params($queryInsert, array($_POST["ItemId"], $_SESSION['UserId'], $_POST["bidvalue"]));

		$query="SELECT b.bidTime, i.EndTime 
				FROM Bids b JOIN Item i ON (b.AuctionNum=i.Id) 
				WHERE b.AuctionNum=$1 AND b.Bidder=$2 AND b.Amount=$3";
		$result = pg_query_params($query, array($_POST["ItemId"], $_SESSION['UserId'], $_POST["bidvalue"]));
		$rowTime = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		if($rowTime["bidtime"] < $rowTime["endtime"]){//recheck to see if actually in database as a valid time.
			$query2="UPDATE Item set Price=$1 WHERE Id=$2";
			$result2 = pg_query_params($query2, array($_POST["bidvalue"],$_POST["ItemId"]));
			echo '<center><h2>Bid successful!<br /><a href="Main.php">
				Home</a></h2></center>';
		}
		else { //deletes record if didn't update database in time.
			echo '<center><h2>Bid was not in time.<br /><a href="Main.php">
				Home</a></h2></center>';
			$queryDelete="DELETE FROM Bids WHERE AuctionNum=$1 AND Bidder=$2 AND Amount=$3";
			$resultDelete = pg_query_params($queryDelete, array($_POST["ItemId"], $_SESSION['UserId'], $_POST["bidvalue"]));
		}
	}
	else {
		echo '<center><h2>Bid was not in time.<br /><a href="Main.php">
				Home</a></h2></center>';
	}
}
else {
	echo '<center><h2>Invalid Bid amount.</h2></center>';
}
?>
</BODY>
</HTML>