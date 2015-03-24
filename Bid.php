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
   
   /* page styling  */
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
      <li><a href="Reports.php">Reports</a></li>
      <li><a href="about.html">About</a></li>
   </ul>
   
   <div id="content">   
<?php
UpdateStatus();
$ItemId=$_POST["itemId"];

$query="SELECT I.Id as id, I.Title as title, U.Username as username, I.Endtime-now() as timeleft, 
		I.Description as description, I.Price as price FROM Item I JOIN ItemCategories C ON (I.Id=C.AuctionNum)
		JOIN Users U ON (I.Seller=U.Id) WHERE I.Id=$1 AND I.Status = 'active'";
$result = pg_query_params($query, array($ItemId));

$query2="SELECT * FROM Bids WHERE AuctionNum = $1 AND Amount IN (SELECT max(Amount) FROM Bids WHERE AuctionNum = $2)";
$result2 = pg_query_params($query2, array($ItemId, $ItemId));
if(pg_numrows($result2) > 0){ //at least one bid has been made
	$rowBid = pg_fetch_array($result2, NULL, PGSQL_ASSOC);
	$highBid = $rowBid['amount'];
}
else {
	$highBid = 0;
}
if(pg_numrows($result) >0){
	$rowItem = pg_fetch_array($result, NULL, PGSQL_ASSOC);
	
	if($highBid == 0){$highBid = $rowItem["price"];}//set to start price if no bid found.
	
	echo "Auction Number: ".$rowItem["id"]."  <b>".$rowItem["title"]."</b>  Username: <i>".$rowItem["username"].
		"</i>  Remaining time:".$rowItem["timeleft"]."<br /><u>Description:<br /></u>".$rowItem["description"]."<br />";
	echo "Highest bid is: ".$highBid." <br />";
	echo '<FORM name="formBid" action="addBid.php" method="post">';
	$highBid++;
	echo '<input type="hidden" name="ItemId" value="'.$ItemId.'"/>';
	echo 'Your bid: <input type="text" name="bidvalue" value="'.$highBid.'"/><br />';
	echo '<input type="submit" value="Bid" name="submitBid"/>';
	echo '</FORM>';
}
else {
	echo "Too late, this auction has ended";
}


?>
</BODY>
</HTML>