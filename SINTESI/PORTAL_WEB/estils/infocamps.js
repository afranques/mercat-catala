//login barra men�
function buidacorreu()
	{
	var correu = document.loginusers.loginuser.value;
	if (correu == 'correu electr�nic') {document.loginusers.loginuser.value = '';}
	}
	
function omplecorreu()
	{
	var correu = document.loginusers.loginuser.value;
	if (correu == '') {document.loginusers.loginuser.value = 'correu electr�nic';}
	}
	
function buidapwd()
	{
	var pwd = document.loginusers.loginpwd.value;
	if (pwd == 'contrasenya') 
		{
		document.loginusers.loginpwd.value = '';
		document.loginusers.loginpwd.type = 'password';
		}
	}
	
function omplepwd()
	{
	var pwd = document.loginusers.loginpwd.value;
	if (pwd == '')
		{
		document.loginusers.loginpwd.type = 'text';
		document.loginusers.loginpwd.value = 'contrasenya';
		}
	}
//FI login barra men�	

//login p�gina login	
function buidacorreu2()
	{
	var correu2 = document.loginusers2.loginuser2.value;
	if (correu2 == 'correu electr�nic') {document.loginusers2.loginuser2.value = '';}
	}
	
function omplecorreu2()
	{
	var correu2 = document.loginusers2.loginuser2.value;
	if (correu2 == '') {document.loginusers2.loginuser2.value = 'correu electr�nic';}
	}
	
function buidapwd2()
	{
	var pwd2 = document.loginusers2.loginpwd2.value;
	if (pwd2 == 'contrasenya')
		{
		document.loginusers2.loginpwd2.value = '';
		document.loginusers2.loginpwd2.type = 'password';
		}
	}
	
function omplepwd2()
	{
	var pwd2 = document.loginusers2.loginpwd2.value;
	if (pwd2 == '')
		{
		document.loginusers2.loginpwd2.type = 'text';
		document.loginusers2.loginpwd2.value = 'contrasenya';
		}
	}
//FI login p�gina login