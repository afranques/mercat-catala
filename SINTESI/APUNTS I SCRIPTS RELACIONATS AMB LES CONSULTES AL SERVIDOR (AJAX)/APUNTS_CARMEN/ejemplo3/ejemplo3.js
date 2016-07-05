function process()
{
// Crear el texto que aparece primero
oHello = document.createTextNode
("Hola! Puedes escoger entre estos colores:");
// crear el elemento UL
oUl = document.createElement("ul");
// Crear la primera entrada de la lista
oLiBlack = document.createElement("li");
oBlack = document.createTextNode("Negro");
oLiBlack.appendChild(oBlack);
// Crear la segunda entrada de la lista
oLiOrange = document.createElement("li");
oOrange = document.createTextNode("Naranja");
oLiOrange.appendChild(oOrange);
// Crear la tercera entrada de la lista
oLiPink = document.createElement("li");
oPink = document.createTextNode("Rosa");
oLiPink.appendChild(oPink);
// Añadimos las entradas en la lista
oUl.appendChild(oLiBlack);
oUl.appendChild(oLiOrange);
oUl.appendChild(oLiPink);
// obtenemos una referencia al elemento DIV
myDiv = document.getElementById("elementoDIV");
// añadimos el contenido al DIV
myDiv.appendChild(oHello);
myDiv.appendChild(oUl);
}

function process()
{
// Crear el texto que aparece primero
oHello = document.createTextNode
("Hola! Puedes escoger entre estos colores:");
// crear el elemento UL
oUl = document.createElement("ul");
// Crear la primera entrada de la lista
oLiBlack = document.createElement("li");
oBlack = document.createTextNode("Negro");
oLiBlack.appendChild(oBlack);
// Crear la segunda entrada de la lista
oLiOrange = document.createElement("li");
oOrange = document.createTextNode("Naranja");
oLiOrange.appendChild(oOrange);
// Crear la tercera entrada de la lista
oLiPink = document.createElement("li");
oPink = document.createTextNode("Rosa");
oLiPink.appendChild(oPink);
// Añadimos las entradas en la lista
oUl.appendChild(oLiBlack);
oUl.appendChild(oLiOrange);
oUl.appendChild(oLiPink);
// obtenemos una referencia al elemento DIV
myDiv = document.getElementById("elementoDIV");
// añadimos el contenido al DIV
myDiv.appendChild(oHello);
myDiv.appendChild(oUl);
}

