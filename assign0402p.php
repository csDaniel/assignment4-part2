<?php

// include 'assign0402config.php';


// id, name, category, length, rented
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbuser = 'ofarreld-db';
$dbpass = 'cfll9z41YEI1fBfb';
$table = 'cs290as0402movies';



$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbuser);
if (!$mysqli || $mysqli->connection_errno) {
  echo "Connection error" . $mysqli->connection_errno . " " . $mysqli->connect_error;
} else {
  echo "connection worked!";
  
}


function init() {
  global $mysqli, $table;
  // initializing table data from the db
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $result = $all->get_result();
  
  buildTable($result);  
  $all->close(); 

}

if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}

// id, name, category, length, rented
function buildTable($res) {
  echo '<table>';
  echo '<tr>';
  echo '<td>First Name</td>';
  echo '<td>Last Name</td>';
  echo '<td>Position</td>';
  echo '<td>Team</td>';
  echo '</tr>';
  while($row = $res->fetch_assoc())
  {
    echo '<tr id="'.$row['id'].'">';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['length'].'</td>';
    echo '<td class="position">'.$row['category'].'</td>';
    echo '<td>';
    echo '<td class="update">Update</td>';
    echo '<td class="remove">Remove</td>';
    echo '</tr>';
  }
  echo '</table>';  
}

?>