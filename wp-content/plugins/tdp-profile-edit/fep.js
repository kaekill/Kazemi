
if($ == undefined){
	$ = jQuery;
}

$(document).ready(function(){

	$('#pass1').simplePassMeter({
	  'showOnValue': true,
	  'Container': '#pass-strength-result'
	});
	
	$('#pass-strength-result').hide();
	
});