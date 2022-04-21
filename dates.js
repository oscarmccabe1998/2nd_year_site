window.onload=preparePage();

function preparePage() {
    document.getElementById("dates_button").onclick = function() {loadDoc()};
}

function loadDoc() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("dates").innerHTML =
      this.responseText;
    }
    xhttp.open("GET", "tour_info.txt");
    xhttp.send();
  }