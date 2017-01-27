function updateCase() {
	var xhttp = new XMLHttpRequest();
	var id = document.getElementById("default_case").value;

	xhttp.onreadystatechange = function() {
		if( this.readyState == 4 && this.status == 200 ) {
			document.getElementById("case").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/getDescription/" + id, true);
	xhttp.send();
}

function updateAdminCase() {
	var xhttp = new XMLHttpRequest();
	var id = document.getElementById("admin_case").value;

	xhttp.onreadystatechange = function() {
		if( this.readyState == 4 && this.status == 200 ) {
			document.getElementById("description").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/getCase/" + id, true);
	xhttp.send();
}

function updateHotspots(element) {
	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {
		if( this.readyState == 4 && this.status == 200 ) {
			var li = document.createElement("LI");
			li.innerHTML = this.responseText;

			if( li.innerHTML != '' ) {
				document.getElementById("checked").appendChild(li);
			}
		}
	};
	xhttp.open("GET", "/update/" + element.getAttribute('data-path'), true);
	xhttp.send();
}
