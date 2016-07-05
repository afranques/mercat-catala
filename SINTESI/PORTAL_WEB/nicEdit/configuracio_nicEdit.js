var area2;

function addArea2()
	{
	area2 = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','hr','ol','ul','fontSize','indent','outdent','image','upload','link','unlink','forecolor']}).panelInstance('myArea2');
	document.getElementById('addeditor').disabled=true;
	document.getElementById('removeeditor').disabled=false;
	document.getElementById('canceleditor').style.display='inline';
	}

function removeArea2()
	{
	area2.removeInstance('myArea2');
	var fitxa_editable = document.getElementById("myArea2");
	document.getElementById("p1").value=fitxa_editable.innerHTML;
	document.forms["modificacions_fitxa"].submit();
	}