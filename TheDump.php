<?php session_start();
include ("connect.php"); ?>
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
   /*bar styling. */
   
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
  
<?php
echo "<center><H2>Choose a table:</H2><br />";
echo '<FORM name="formDump" action="'.$_SERVER['PHP_SELF'].'" method="POST">';
echo '<table><tr><td><input type="radio" name="table" value="Users" CHECKED/>Users</td></tr><tr><td>';
echo '<input type="radio" name="table" value="Item" />Item</td></tr><tr><td>';
echo '<input type="radio" name="table" value="ItemCategories" />ItemCategories</td></tr><tr><td>';
echo '<input type="radio" name="table" value="Categories" />Categories</td></tr><tr><td>';
echo '<input type="radio" name="table" value="Bids" />Bids</td></tr><tr><td>';
echo '<input type="submit" name="submit" value="Display" /></td></tr>';
echo '</table></FORM></center>';

if(isset($_POST["submit"])){
	DisplayTable($_POST['table']);
}


function DisplayTable($TableName)
{
	echo "<center><b>Table: ".$TableName."</b></center>";
	$query = "SELECT * FROM $TableName";
	$result = pg_query($query);
	$n = pg_num_fields($result);
	$a = 0;//for dual use. Number of field names sets number columns for data

	echo '<center><table border="1"><tr>';
	for ($a = 0; $a < $n; $a++){//loop through column names
		$fieldName = pg_field_name($result, $a);
		echo "<th>$fieldName</th>";
	}
	echo '</tr>';
	for (;$row = pg_fetch_array($result, NULL, PGSQL_NUM);){//loop through table rows
		echo "<tr>";
		for ($b = 0; $b < $a; $b++){//loop through fields in a row
			echo "<td>$row[$b]</td>";
		}
		echo "</tr>";
	}
	echo "</table></center>";

}
?>
 </div>
</div>
</BODY>
</HTML>