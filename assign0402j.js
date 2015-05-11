// this is for js
window.onload = function() {
  localStorage.setItem('filterBy', 'none');
  localStorage.setItem('filter', 'none');
  localStorage.setItem('sortBy', 'name');

  makeRequest('action=init');
  document.getElementById('buttonInput').addEventListener('click', addMovie);
  
};

function makeRequest (statement) {
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  } else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  xmlhttp.onreadystatechange = function() {
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
 
  var filter = 'filter=' + localStorage.getItem('filter');
  var filterBy = 'filterBy=' + localStorage.getItem('filterBy');
  var sortBy = 'sortBy=' + localStorage.getItem('sortBy');
  statement += '&' + filter + '&' + filterBy + '&' + sortBy;
    
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

function addListeners() {

  var removes = document.getElementsByClassName("removeVid");
  for (var i = 0; i < removes.length; i++) {
    removes[i].addEventListener('click', removeVideo);    
  }
}