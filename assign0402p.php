<?php
include 'assign0402config.php';

// id, name, category, length, rented
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if (!$mysqli || $mysqli->connection_errno) {
  echo "Failed to conbnect to MySQL: (" . $mysqli->connection_errno . ") " . $mysqli->connect_error;
} else {
  echo "Current Inventory:";
}

function makeTable($results) {
  
  $catMenu = array();
  array_push($catMenu, "Default");
  
  // actual table
  echo '<table id="movieTable">';
  echo '<tr>';
  echo '<td>Title</td>';
  echo '<td>Category</td>';
  echo '<td>Length</td>';
  echo '<td>Status</td>';
  echo '</tr>';
  while ($row = $results->fetch_assoc()) {
    echo '<tr id="'.$row['id'].'">';
    echo '<td>' .$row['name']. '</td>';
    echo '<td>' .$row['category']. '</td>';    
    echo '<td>' .$row['length']. '</td>';    
    echo '<td> <div class="status">';
      if ($row['rented']) { 
        echo "Checked Out";
      } else {
        echo "Available";
      }
    echo '</div></td>';
    echo '<td> <div class="removeVid">Remove</div></td>';
    echo '</tr>';
    array_push($catMenu, $row['category']);
  }
  echo '</table>';
 
  //table filter options
  $cat = array_unique($catMenu, SORT_REGULAR);
  echo '<div>';
  echo '<span>Filter Films by Category</span></br>';
  echo '<select id ="dropdownMenu">';
  foreach ($cat as $value) {
    $temp++;    
    echo '<option class = "dropdown" value = '.$temp.'>'.$value.'</option>';
  }
  echo '<option class="none" value="none">none</option>';
  echo '</select>';
  echo '</div>';

  
}

function sortTable() {
  // default case for filterBy none/Default
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
  if ($nLength < 0) {
    echo '<p>Error: Films cannot have length less than 0</p>';
  } else {
  $add = $mysqli->prepare("INSERT INTO $table (name, category, length, rented) VALUES (?,?,?,?)");
  $add->bind_param('ssii', $nName, $nCat, $nLength, $rented);
  $add->execute();
  $add->close();
  }
}

function removeMovie($id) {
  global $mysqli;
  global $table;
  $remove = $mysqli->prepare("DELETE from $table WHERE id = ?");
  $remove->bind_param('i', $id);
  $remove->execute();
  $remove->close();
}

function updateMovie($id, $rented) {
  global $mysqli;
  global $table;
  $update = $mysqli->prepare("UPDATE $table SET rented = ? WHERE id = ?");
  $update->bind_param('ii', $rented, $id);
  $update->execute();
  $update->close();
}

function deleteAllMovies() {
  global $mysqli;
  global $table;
  $delAll = $mysqli->prepare("TRUNCATE TABLE $table");
  $delAll->execute();
  $delAll->close();  
}

function filterTable($filterType) {
  global $mysqli;
  global $table;
  $filtered = $mysqli->prepare("SELECT * FROM $table WHERE category= '$filterType'");
  $filtered->execute();
 
  $res = $filtered->get_result();
  
  makeTable($res);
  
  $res->close(); 
}
 
// sort the requests sent from javascript
if(isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  $filterType = $_REQUEST['filterBy'];
  
  if ($action == 'init') {
    //init();
  } else if ($action == 'add') {
    $nName = $_REQUEST['nameInput'];
    $nLength = $_REQUEST['lengthInput'];
    $nCat = $_REQUEST['categoryInput'];
    addMovie($nName, $nLength, $nCat);
  } else if ($action == 'remove') {
    $id = $_REQUEST['id'];
    removeMovie($id);
  } else if ($action == 'update') {
    $id = $_REQUEST['id'];
    $rented = $_REQUEST['rented'];
    updateMovie($id, $rented);    
  } else if ($action == 'deleteAll') {
    deleteAllMovies();    
  }
  // default case + sorted cases are handled at the end
  if ($filterType != 'Default' && $filterType != 'none') {  
      filterTable($filterType);
  } else {
    sortTable();
  }
}


?>