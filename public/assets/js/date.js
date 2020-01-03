function date() {
	var a = new Date().toLocaleDateString();
	var b = new Date().toLocaleTimeString();

	document.getElementById("date").innerHTML = 
		'Nous sommes le <b>' + a + '</b>, ';
}

