<!-- include function that checks if valid character length used for new hospital name -->
<?php include("validCharLength.php"); ?>

<!-- page where user can update hospital name by clicking the update but next to a hospitals name -->
<!-- also page that lists all the hospital names and the first name and last name of the head doctor of each hospital and the doctor's start date as head, in alphabetical order by hospital name. -->
<!DOCTYPE html>
<html>
<head>
    <title>HPDR</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css"/>
</head>
<body>
<?php include("templates/header.php"); ?>
<div class="content">
<h1>Hospitals</h1>
<table>
<?php

include("dbconnect.php"); // start connection

// if new name for hospital given and form submitted
if (isset($_POST["update_hospital"]) && isset($_POST["newname"])) {
    $hospital_code = $_POST["hospitalcode"];
    $new_hospital_name = $_POST["newname"];

    if (validCharLength($new_hospital_name)) { // if hospital name valid character length

        $query = "UPDATE Hospital SET Hospital_Name = '$new_hospital_name' WHERE Hospital_Code = '$hospital_code';";
        $result = mysqli_query($connection, $query); // update name
    }
}

// generate table
$query = "SELECT Hospital.Hospital_Code, Hospital_Name, First_Name, Last_Name, Head_Start_Date FROM Hospital, Doctor WHERE Head_Licence_No = Doctor.Licence_No ORDER BY Hospital_Name;";
$result = mysqli_query($connection, $query);

if (!(mysqli_num_rows($result) == 0)) {
?>
    <tr style="background-color: lightblue;">
        <th>Hospital Name</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Head Start Date</th>
        <th>Update Hospital Name</th>
    </tr>
<?php
    while($row=mysqli_fetch_assoc($result)) {
?>
	<tr>
	    <th><?php echo $row["Hospital_Name"] ?></th>
	    <th><?php echo $row["First_Name"] ?></th>
	    <th><?php echo $row["Last_Name"] ?></th>
	    <th><?php echo $row["Head_Start_Date"] ?></th>
	    <th>
	    <form action="hospitals.php" method="POST">
		    <input type="hidden" name="hospitalcode" value="<?php echo $row["Hospital_Code"] ?>">
		    <input type="text" name="newname">
		    <input type="submit" name="update_hospital" value="update">
	    </form>
	    </th>
	</tr>
<?php
    }
    mysqli_free_result($result);
}
mysqli_close($connection); // close connection

?>
</table>
</body>
</html>
