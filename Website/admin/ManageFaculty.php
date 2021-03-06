<?php require_once("config/Database.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php Confirm_Login() ?>
<?php

if(isset($_POST["Submit"]))
{
//check for availability of username

	$db = new Database;
	$db->query('SELECT * FROM faculty Where email=:email');
	$db->bind(':email', $_POST['Username']);
	$rows = $db->resultset();
if($rows)
{
 $Usernameavailable="NO";
}
//
if(empty($Username=$_POST["Username"])){
	$_SESSION["ErrorMessage"]="All Fields must be filled out";
	Redirect_to("ManageFaculty.php");	
}
elseif(!empty($Usernameavailable))
{
 $_SESSION["ErrorMessage"]="Faculty Name already exist.";
 Redirect_to("ManageFaculty.php");	
}
else
{
 $db->query("INSERT INTO faculty (email, password) VALUES(:email, :password)");
 $db->bind(':password', md5($Username));
 $db->bind(':email', $Username);
 $db->execute();
 if($db->lastInsertId())
{
  
	$_SESSION["SuccessMessage"]="Faculty added sussessfully.";
	Redirect_to("ManageFaculty.php");
}
 else
 {
	$_SESSION["ErrorMessage"]="Sorry something went wrong, please try again!!!";
	Redirect_to("ManageFaculty.php");
 }
}
}
?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
<title>Manage Admins</title>
                <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
                <script src="assets/js/jquery-3.2.1.min.js"></script>
                <script src="assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="assets/CSS/adminstyles.css">
<style>

</style>
</head>
<body>
<div style="height: 10px; background: #27aae1;"></div>


<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">	
	<div class="col-sm-2">
	<br><br>
	<ul id="Side_Menu" class="nav nav-pills nav-stacked">
<li>
<a href="index.php">
<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a>
</li>
<li>
<a href="ManageAdmins.php">
<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a>
</li>
<li><a href="ManageStudents.php">
<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Students</a>
</li>
<li class="active" ><a href="#">
<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Faculty</a>
</li>
<li><a href="index.php">
<span class="glyphicon glyphicon-question-sign"></span>&nbsp;Enquiries</a>
</li>
</li><li><a href="#">
<span class="glyphicon glyphicon-wrench"></span>&nbsp;Settings</a>
</li>
<li><a href="#">
<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a>
</li>		
	</ul>
	</div><!-- Ending of Side area -->
	
	
	<div class="col-sm-10"> <!--Main Area-->
	<h1>Manage Faculty Access</h1>
	<?php echo ErrorMessage();
	echo SuccessMessage();
	?>
	<div>
	<form action="ManageFaculty.php" method="POST">
	<fieldset>
	<div class="form-group">
	<label for="Username"><span class="FieldInfo">User Name:</span></label>
	<input class="form-control" type="text" name="Username" id="Username" placeholder="User name">
	</div>
	<br>
	<input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
	</fieldset>
	<br>
	</form>
	</div>
	<div class="table-responsive">
	<table class="table table-striped table-hover">
	<tr>
	<th>Sr No.</th>
	<th>Faculty Name</th>
	<th>Action</th>
	</tr>
<?php
	$SrNo=1;
	$db = new Database;
	$db->query('SELECT * FROM faculty');
	$rows = $db->resultset();
?>
<?php foreach($rows as $row) : ?>

<tr>
	<td align="center"><?php echo $SrNo;$SrNo++; ?></td>
	<td align="center"><?php echo $row['email']; ?></td>
	<td align="center"><a href="DeleteFaculty.php?id=<?php echo $row['id'];?>">
	<span class="btn btn-danger">Delete</span></a></td>
	
</tr>
		<?php endforeach; ?>
	</table><br><br>
	</div>
	</div> <!-- Ending of Main Area-->
	</div> <!-- Ending of Row-->
	</div> <!-- Ending of Container-->
	<div id="Footer">
	<hr>
	<p>Theme By | SHASHANK SIMHA M R |<br>&copy;Simha<br> All right reserved.</p>
	<hr>
	</div>
	
	<div style="height: 10px; background: #27AAE1;"></div>
	</body>
	</html>