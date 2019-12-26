function date() {
	var a = new Date().toLocaleDateString();
	var b = new Date().toLocaleTimeString();

	document.getElementById("date").innerHTML = '<b>' + a + '</b> &nbsp; | &nbsp; Dernière connexion au Dashboard à <b>' + b + '</b>';
}