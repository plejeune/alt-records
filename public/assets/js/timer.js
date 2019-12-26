
function start_rebour() {
	var tmps = (new Date()).getTime() + 10000;
	Rebour(tmps);
}

function Rebour(TempFuture) {
	var Maintenant = new Date();
	var TempMaintenant = Maintenant.getTime();
	var DinaHeure = Math.floor((TempFuture-TempMaintenant)/1000);
		if (DinaHeure <= 0) {
			DinaHeure = 0;
		}
        document.getElementById("comptarebour").innerHTML = DinaHeure;

		if (DinaHeure > 0) {
			setTimeout(function() { Rebour(TempFuture); }, 1000);
		}
}

window.onload = start_rebour;