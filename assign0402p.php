<?php

// include 'assign0402config.php';


// id, name, category, length, rented
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbname = 'ofarreld-db';
$dbuser = 'ofarreld-db';
$dbpass = 'cfll9z41YEI1fBfb';
$dbase = 'cs290as0402movies';



$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbase);
if ($mysqli->connection_error) {
  echo "Connection error";
}

function init() {
  global $mysqli, $table;
  // initializing table data from the db
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $result = $all->get_result();
 
  var_dump($result);
  var_dump($all);
 
  buildTable($result);  
  $all->close(); 
  
  echo '<p>alert()</p>';
}

if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
}
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
    echo '<input type="text" class="team" value="'.$row['rented'].'"></td>';
    echo '<td class="update">Update</td>';
    echo '<td class="remove">Remove</td>';
    echo '</tr>';
  }
  echo '</table>';  
}

?>