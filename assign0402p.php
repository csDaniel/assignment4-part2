<?php

// include 'assign0402config.php';
$dbhost = 'oniddb.cws.oregonstate.edu';
$dbuser = 'ofarreld-db';
$dbpass = 'cfll9z41YEI1fBfb';
$dbname = 'ofarreld-db';
$table = 'cs290as0402movies';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if (!$mysqli || $mysqli->connection_errno) {
  echo "Connection error" . $mysqli->connection_errno . " " . $mysqli->connect_error;
} 

function init() {
  global $table, $mysqli;
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $res = $all->get_results();
  while($row = $res->fetch_assoc()) {
    echo $row['id'];
  }

  
}

// sort the requests sent from javascript
if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  if ($action == 'init') {
    init();
    
    
  }
}



/*
function init() {
  global $mysqli, $table;

  var_dump($mysqli);
}
  /*
  // initializing table data from the db
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $result = $all->get_result();
  
  echo "<br> Whatever <br>";
  var_dump($result);
  
  buildTable($result);  
  $all->close(); 

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