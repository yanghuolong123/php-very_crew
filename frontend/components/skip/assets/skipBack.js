var seconds = $('#seconds').val();
var skipUrl = $('#skipUrl').val(); 
var closed = $('#closeWindow').val();
var rd;	 		
function redirection() {
	if(seconds <= 0)
	{
		window.clearInterval(rd);
		return;
	}
 
	seconds --;
	document.getElementById('sec').innerHTML='&nbsp;&nbsp;'+seconds+'&nbsp;&nbsp;';
	
	if(seconds == 0)
	{
		if(closed == 'yes') {window.opener = null; window.close();} 
		window.clearInterval(rd);
		window.location.href = skipUrl; 
		// history.go(-1);
	}
}
	
onload = function() {
	rd = window.setInterval(redirection, 1000);
}

