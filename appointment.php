<?php 

	$page_title = 'Kean Career Services';
	include ('includes/header.html');
	include ('includes/db_config.php');
	// Check for form submission:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		// Print the results:
		echo "<h1>Appointment Result</h1>";
		// Minimal form validation:
		if (isset($_POST['student_id'], $_POST['first_name'], $_POST['email'])) {

			if ($_POST['location'] == '' || $_POST['consultant'] == '' || $_POST['reason'] == '' || 
				$_POST['student_id'] == '' || $_POST['first_name'] == '' || $_POST['last_name'] == '' || 
				$_POST['email'] == '' || $_POST['cell_phone'] == '') {
				echo "<h2>The following fields cannot be empty!</h2>";
				if ($_POST['reason'] == '') echo "<p class='error'>\"Reason\"</p>";
				if ($_POST['student_id'] == '') echo "<p class='error'>\"ID\"</p>";
				if ($_POST['first_name'] == '') echo "<p class='error'>\"First Name\"</p>";
				if ($_POST['last_name'] == '') echo "<p class='error'>\"Last Name\"</p>";
				if ($_POST['email'] == '') echo "<p class='error'>\"E-mail\"</p>";
				if ($_POST['cell_phone'] == '') echo "<p class='error'>\"Cell-Phone\"</p>";
				if ($_POST['consultant'] == '') echo "<p class='error'>\"Consultant\"</p>";
				if ($_POST['location'] == '') echo "<p class='error'>\"Location\"</p>";
				#Availability

				echo "<p><a href='appointment.php'>TRY AGAIN</a></p>";
			} else {
				echo "<p>Student ID: " . $_POST['student_id'] . "</p>";
				echo "<p>Name: " . $_POST['last_name'] . ", " . $_POST['first_name'] . "</p>";
				$query = sprintf("SELECT description FROM Reasons WHERE id = '%s'", $_POST['reason']);
				$result = mysqli_query($conex, $query);
				$row = mysqli_fetch_array($result);
				echo "<p>Reason: " . $row[0] . "</p>";
				$query = sprintf("SELECT CONCAT(last_name,', ',first_name) FROM Consultants WHERE id = '%s'", $_POST['consultant']);
				$result = mysqli_query($conex, $query);
				$row = mysqli_fetch_array($result);
				echo "<p>Consultant: " . $row[0] . "</p>";
				$query = sprintf("SELECT CONCAT(detail,' ',building_id,room) FROM Locations WHERE id = '%s'", $_POST['location']);
				$result = mysqli_query($conex, $query);
				$row = mysqli_fetch_array($result);
				echo "<p>Location: " . $row[0] . "</p>";
				#Availability

				echo "<p><h2 style='color: #6CBB3C'><i>Take a seat please.</i></h2></p>";
				mysqli_free_result($result);
				mysqli_close($conex);
			}
		} else { // Invalid submitted values.
			echo '<h1>Error!</h1>
			<p class="error">Please enter valid data.</p>';
		}
	}

?>

<div id="appointment_process"<?php if (isset($_POST['student_id'])) echo ' style="display: none;"'; ?>>
	<h1>Appointment Process</h1>
	<form action="appointment.php" method="post">	
		<script type="text/javascript">
			function goTo() {
			    var x = document.getElementById("appointment_get_info");
			    var y = document.getElementById("appointment_availability");
			    var z = document.getElementById("show_submit");
			    if (x.style.display === "block" && y.style.display === "none") {
			    	x.style.display = "none";
				    y.style.display = "block";
				    z.style.display = "block";
			    } else if (x.style.display === "none" && y.style.display === "block") {
			    	x.style.display = "block";
				    y.style.display = "none";
				    z.style.display = "none";
			    }   
			}
		</script>
		<div id="appointment_get_info" style="display: block;">
			<h2>All fields are required!</h2>
			<?php 

				include ('includes/db_config.php'); 
				#LOCATIONS.
				$query = "SELECT id, CONCAT(detail,' ',building_id,room) AS location FROM Locations ORDER BY location";
				$result = mysqli_query($conex, $query);
				if ($result) {
					if (mysqli_num_rows($result) > 0) {
						echo "<p>Location:";
						echo "<br><select name='location' style='width: 200px'>";
							while ($row = mysqli_fetch_array($result)) {
								$loc_id = $row['id'];
								$loc_location = $row['location'];
								echo "<option value='$loc_id'>$loc_location</option>\n";
							}							
						echo "</select>";
						echo "</p>";
					} else {
						echo "<p>Location:";
						echo "<br><select name='location' style='width: 200px'>";
							echo "<option value='' selected>EMPTY LIST</option>\n";
						echo "</select>";
						echo "</p>";
					}
				} else {

				}
				#CONSULTANTS.
				$query = "SELECT id, CONCAT(last_name,', ',first_name) AS consultant FROM Consultants ORDER BY consultant";
				$result = mysqli_query($conex, $query);
				if ($result) {
					if (mysqli_num_rows($result) > 0) {
						echo "<p>Consultant:";
						echo "<br><select id='consultant' name='consultant' style='width: 200px'>";
							while ($row = mysqli_fetch_array($result)) {
								$con_id = $row['id'];
								$con_consultant = $row['consultant'];
								echo "<option value='$con_id'>$con_consultant</option>\n";
							}							
						echo "</select>";
						echo "</p>";
					} else {
						echo "<p>Consultant:";
						echo "<br><select name='consultant' style='width: 200px'>";
							echo "<option value='' selected>EMPTY LIST</option>\n";
						echo "</select>";
						echo "</p>";
					}
				} else {

				}
				#REASONS.
				$query = "SELECT id, description FROM Reasons ORDER BY description";
				$result = mysqli_query($conex, $query);
				if ($result) {
					if (mysqli_num_rows($result) > 0) {
						echo "<p>Reason:";
						echo "<br><select name='reason' style='width: 200px'>";
							while ($row = mysqli_fetch_array($result)) {
								$re_id = $row['id'];
								$re_description = $row['description'];
								echo "<option value='$re_id'>$re_description</option>\n";
							}							
						echo "</select>";
						echo "</p>";
					} else {
						echo "<p>Reasons:";
						echo "<br><select name='reason' style='width: 200px'>";
							echo "<option value='' selected>EMPTY LIST</option>\n";
						echo "</select>";
						echo "</p>";
					}
				} else {

				}
				mysqli_free_result($result);
				mysqli_close($conex);

			?>

			<p>Student ID (without leading zeros):
				<br><input type="text" name="student_id" value="<?php if (isset($_POST['student_id'])) echo $_POST['student_id']; ?>" style="width: 190px" />
			</p>
			<p>First Name:
				<br><input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" style="width: 190px" />
			</p>
			<p>Last Name:
				<br><input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" style="width: 190px" />
			</p>
			<p>E-mail:
				<br><input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" style="width: 190px" />
			</p>
			<p>Cell-Phone:
				<br><input type="text" name="cell_phone" value="<?php if (isset($_POST['cell_phone'])) echo $_POST['cell_phone']; ?>" style="width: 190px" />
			</p>
			<p><button type="button" style="background-color:  #f7dc6f ; height: 30px; width: 200px" onclick="goTo()">NEXT >></button></p>
		</div>
		<div id="appointment_availability" style="display: none;">
			<h2 id="demo"></h2>
			<script type="text/javascript">
				var e = document.getElementById("consultant");
				var getConsultant = e.options[e.selectedIndex].text;
				document.getElementById("demo").innerHTML = "Availability of \"" + getConsultant + "\"";
			</script>
			<center><p><img src='pictures/under_construction.png' alt='Under Construction Error' style='width: 400px; height: 150px;'></p></center>


			<p><button type="button" style="background-color: #f7dc6f ; height: 30px; width: 200px" onclick="goTo()"><< BACK</button></p>
		</div>
		<div id="show_submit" style="display: none;">
			<p><input type="submit" name="submit" value="SET-APPOINTMENT" style="background-color: #f7dc6f; height: 30px; width: 200px" /></p>
		</div>
	</form>
</div>

<?php include ('includes/footer.html'); ?>
