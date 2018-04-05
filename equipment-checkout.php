<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css?v=04012018b">
	</head>
	<body>
		<?php include 'navbar.php'; ?>
		Who are you?
		<form action="checkout.php" method="POST">
			<?php

				include '/etc/phpstuff/salesselector.php';

				$db = new mysqli('127.0.0.1', $sqlUser, $sqlPass,
	'thrashca_salesselector');
				$query = "SELECT * FROM people;";
				$result = $db->query($query);

				/*while (2 < 5) {
					$line = $result->fetch_array();
					if ($line == NULL) {break;}
					echo '<p><input type="radio" name="who"
	value="'.$line['name'].'">';
					echo ' '.$line['name']."</p>";
				}*/
				echo '<select name="who">';
				while (2 < 5) {
					$line = $result->fetch_array();
					if ($line == NULL) {break;}
					echo '<option value="'.$line['name'].'">'.$line['name'].'</option>';
				}
				echo "</select>";
			?>
		<p>And what are you taking with you?</p>
		<table style="width:80%; border: 1px solid black;">
			<tr>
				<th>Tag Number</th>
				<th>Description</th>
				<th>Checked Out By</th>
				<th>Check Out</th>
			</tr>
			<?php
				$query = "SELECT * FROM equipment";
				$query = $query." LEFT OUTER JOIN people ON equipment.who_has = people.id";
				$query = $query." ORDER BY `description`;";

				$result = $db->query($query);
				while (2 < 5) {
					$line = $result->fetch_array();
					if ($line == NULL) {break;}
					$tag_num = $line['tag_num'];
					$description = $line['description'];
					$checked_out_by = $line['name'];

					/*if the equipment is already checked out, say by who.
					otherwise, offer a check box to check it out */
					if ($checked_out_by === NULL) {
						echo "<tr><td>".$tag_num."</td><td>".$description;
						echo "</td><td></td><td>";
						echo '<input type="checkbox" name="checkout[]" value="'.$tag_num.'"></td></tr>';
					}
					else {
						echo '<tr><td>'.$tag_num.'</td><td>'.$description.'</td>';
						echo '<td>'.$checked_out_by.'</td><td></td></tr>';
					}
				}

				$db->close();
			?>
		</table>
		<input type="submit" value="Submit">
		</form>
	</body>
</html>
