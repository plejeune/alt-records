function horloge() {
	var div = document.getElementById("horloge");
	var heure = new Date();
	var hours = (heure.getHours()<10)?"0"+heure.getHours():heure.getHours();
	var minutes = (heure.getMinutes()<10)?"0"+heure.getMinutes():heure.getMinutes();
	var seconds = (heure.getSeconds()<10)?"0"+heure.getSeconds():heure.getSeconds();
	div.innerHTML = "il est <b>" + hours + ":" + minutes + ":" + seconds + "</b>";
	window.setTimeout("horloge()",1000);
}

horloge();