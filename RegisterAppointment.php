<?php

include "dbconfig.php";

$sname = $_POST["sname"];
$sID = $_POST["sID"];
$reason = $_POST["reason"];
$counselor = $_POST["counselor"];
$location = $_POST["location"];
$date = date("Y/m/d");

$query = "INSERT into seds2017db.Students_Appointments VALUES (id, \"$sID\", \"$counselor\" , \"$location\" , \"$reason\", \"$date\" , 1 , 0 , 0 , null , null )";

				$result = mysqli_query($conn, $query);


				if($result)
				{
					echo "<BR>Input succesful<BR>";
				}
				else
				{
					echo "<BR><br>Error" . mysqli_error($conn);
				}

?>