<?PHP
session_start();
session_destroy();
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
      <li><a href="Login.php">Login</a></li>
      <li><a href="RegisterForm.php">Register</a></li>
      <li><a href="about.html">About</a></li>
   </ul>
   
   <div id="content">    

<center><h2>You are logged out</h2></center>
</BODY>
</HTML>