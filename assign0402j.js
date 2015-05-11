// this is for js
window.onload = function() {
  localStorage.setItem('filterBy', 'none');

  makeRequest('action=init');
  document.getElementById('buttonInput').addEventListener('click', addMovie);
  document.getElementById('deleteAll').addEventListener('click', deleteAllMovies);

};

function makeRequest (statement) {
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  } else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp.onreadystatechange = function() {
    // connection is good and status is 'okay';
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var response = xmlhttp.responseText;
      var elem = document.getElementById('outputTable');
      elem.innerHTML = response;
      addListeners();
    }
  }
  if (statement == 'action=add') {
    var elem = document.getElementById('addVideoForm');
    statement += '&nameInput=' + elem.elements['nameInput'].value;
    statement += '&lengthInput=' + elem.elements['lengthInput'].value;
    statement += '&categoryInput=' + elem.elements['categoryInput'].value;  
  }
 
  var filterBy = 'filterBy=' + localStorage.getItem('filterBy');
  statement += '&' + filterBy;
    
  var url = "assign0402p.php?";
  xmlhttp.open("GET",url + statement,true);
  xmlhttp.send();
  
}

function addMovie() {
  var statement = 'action=add';
  makeRequest(statement);  
}

function removeVideo() {
  // statement == command + id of entire movie
  console.log(this.parentNode.parentNode.id);
  var statement = 'action=remove&id=' + this.parentNode.parentNode.id;
  makeRequest(statement);
}

function updateStatus() {
  // on click, will send reverse message to update db
  // 1 = checked out, 0 = available
  if (this.innerText == "Available") {
    var status = 1;    
  } else {
    var status = 0;
  }   
  var statement = 'action=update&id=' + this.parentNode.parentNode.id + '&rented=' + status;
  makeRequest(statement);
}

function addListeners() {
  var removes = document.getElementsByClassName("removeVid");
  for (var i = 0; i < removes.length; i++) {
    removes[i].addEventListener('click', removeVideo);    
  }
  var checkOut = document.getElementsByClassName("status");
  for (var i =0; i < checkOut.length; i++) {
    checkOut[i].addEventListener('click', updateStatus);
  }
  document.getElementById("dropdownMenu").addEventListener('change', filterResults);
}

function deleteAllMovies() {
  var statement = 'action=deleteAll';
  makeRequest(statement);
}

function filterResults() {
  console.log(this.options[this.selectedIndex].text);
  var statement = 'action=filter';
  localStorage.setItem('filterBy', this.options[this.selectedIndex].text);
  makeRequest(statement);
}

  
  
  
  
  
  
  
  
  
  
  
  
