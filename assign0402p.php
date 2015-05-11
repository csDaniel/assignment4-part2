<?php
include 'assign0402config.php';

ini_set('display_errors', 'On');


// id, name, category, length, rented
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if (!$mysqli || $mysqli->connection_errno) {
  echo "Failed to conbnect to MySQL: (" . $mysqli->connection_errno . ") " . $mysqli->connect_error;
} else {
  echo "Current Inventory:";
}


function init() {
  global $table;
  global $mysqli;  
 
  // initializing table data from the db
  $all = $mysqli->prepare("SELECT * FROM $table");
  $all->execute();
  $res = $all->get_result();
  
 
  makeTable($res);
  
  $res->close();   
}

function makeTable($results) {
  echo '<table>';
  echo '<tr>';
  echo '<td>Title</td>';
  echo '<td>Category</td>';
  echo '<td>Length</td>';
  echo '<td>Status</td>';
  echo '</tr>';
  while ($row = $results->fetch_assoc()) {
    echo '<tr id="'.$row['id'].'">';
    echo '<td>' .$row['id'].'</td>';
    echo '<td>' .$row['name']. '</td>';
    echo '<td>' .$row['category']. '</td>';    
    echo '<td>' .$row['length']. '</td>';   
    echo '<td> <div class="status">Rental Status</div></td>';
    echo '<td> <div class="removeVid">Remove</div></td>';
    echo '</tr>';
    
  }
  echo '</table>';
}

function sortTable() {
  global $mysqli;
  global $table;
  
  $revised = $mysqli->prepare("SELECT * FROM $table");
  $revised->execute();
  $res = $revised->get_result();
  
  makeTable($res);
  
  $res->close();
  
  
}

function addMovie($nName, $nLength, $nCat) {
  // nameInput, lengthInput, categoryInput, 
  global $mysqli;
  global $table;
  $rented = 0;
  $add = $mysqli->prepare("INSERT INTO $table (name, category, length, rented) VALUES (?,?,?,?)");
  $add->bind_param('ssii', $nName, $nCat, $nLength, $rented);
  $add->execute();
  $add->close();
}

function removeMovie($id) {
  global $mysqli;
  global $table;
  $remove = $mysqli->prepare("DELETE from $table WHERE id = ?");
  $remove->bind_param('i', $id);
  $remove->execute();
  $remove->close();
  
}
  
// sort the requests sent from javascript
if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  if ($action == 'init') {
    //init();
  } else if ($action == 'add') {
    $nName = $_REQUEST['nameInput'];
    $nLength = $_REQUEST['lengthInput'];
    $nCat = $_REQUEST['categoryInput'];
    addMovie($nName, $nLength, $nCat);
  } else if ($action == 'remove') {
    $id = $_REQUEST['id'];
    echo $id;
    removeMovie($id);
  }
  // default case. currently defaults when action=init
  sortTable();
}


?>