var fecha = new Date();
	var hora = fecha.getHours();
	if (hora>=22 || hora<=6)
		document.write("A dormir!");
	else
		document.write("Bienvenido!");