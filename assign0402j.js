// this is for js
window.onload = function() {
  localStorage.setItem('filterBy', 'none');
  localStorage.setItem('filter', 'none');
  localStorage.setItem('sortBy', 'none');
  makeRequest('action=init');
  
};

function makeRequest (statement) {
  var xmlhttp;
  if (window.XMLHttpRequest) {
    xmlhttp = new XMLHttpRequest();
  } else {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
 
  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    var response = xmlhttp.responseText;
    var elem = document.getElementById('outputTable');
    elem.innerHTML = response;
    localStorage.setItem('localPlayers', response );
    // addListenerts();
  }
  /*
  if (statement == 'action=add') {
    
  }
  var filter = 'filter=' + localStorage.getItem('filter');
  var filterBy = 'filterBy=' + localStorage.getItem('filterBy');
  var sortBy = 'sortBy=' + localStorage.getItem('sortBy');
  statement += '&' + filter + '&' + filterBy + '&' + sortBy;
  */
  
  xmlhttp.open("GET",'assign0402p.php?' + statement,true);
  xmlhttp.send();
  
  
  
}