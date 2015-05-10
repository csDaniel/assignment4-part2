<?php

// include 'assign0402config.php';
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbuser = 'ofarreld-db';
$dbpass = 'cfll9z41YEI1fBfb';
$dbname = 'ofarreld-db';
$table = 'backup';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if (!$mysqli || $mysqli->connection_errno) {
  echo "Connection error" . $mysqli->connection_errno . " " . $mysqli->connect_error;
 

function init() {
  global $table;
  global $mysqli;  
  
  echo "test";
  /*
  // initializing table data from the db
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $result = $all->get_result();
  
  echo "<br> Whatever <br>";
  var_dump($result);
  
  buildTable($result);  
  $all->close(); 
*/
}

// sort the requests sent from javascript
if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  if ($action == 'init') {
    init();
  }
}



// id, name, category, length, rented
function buildTable($res) {
  echo '<table>';
  echo '<tr>';
  echo '<td>Movie Title</td>';
  echo '<td>Length</td>';
  echo '<td>Category</td>';
  echo '<td>Status</td>';
  echo '</tr>';
  while($row = $res->fetch_assoc())
  {
    echo '<tr id="'.$row['id'].'">';
    echo '<td>'.$row['name'].'</td>';
    echo '<td>'.$row['length'].'</td>';
    echo '<td class="position">'.$row['category'].'</td>';
    echo '<td>';
    echo '</tr>';
  }
  echo '</table>';  
}*/

?>