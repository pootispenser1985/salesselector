<?php
//get post-data where my brain doesn't hurt
$name = $_POST['who'];
$items[] = $_POST['checkout'];
$items = $items[0];
$number_of_items = count($items);

//open db connection
include '/etc/phpstuff/salesselector.php';
$db = new mysqli('127.0.0.1', $sqlUser, $sqlPass,
'thrashca_salesselector');

//find the numerical id of the sales person
$query = "SELECT `id` FROM people WHERE name='".$name."';";
$result = $db->query($query);
$line = $result->fetch_array();
$id = $line[0];

//set items unavailable and taken by the person
$i = $number_of_items;
while ($i > 0) {
  $query = "UPDATE equipment SET checked_out=1, who_has=";
  $query = $query.$id." WHERE tag_num=".$items[($i-1)].";";
  $db->query($query);
  $i--;
}


?>
<a href="http://localhost/salesselector/equipment-checkout.php">Go Back</a>
