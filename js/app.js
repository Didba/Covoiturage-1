initialize('depart');
initialize('arrivee');

$('body').on('change','input:file', function(){
	$(this).parent().addClass('fileUploaded');
});

$('body').on('reset','form', function(){
	$('input:file').parent().removeClass('fileUploaded');
});