initialize('depart');
initialize('arrivee');

$('body').on('change','input:file', function(){
	$(this).parent().addClass('fileUploaded');
});

$('body').on('reset','form', function(){
	$('input:file').parent().removeClass('fileUploaded');
});



//Run the code when document ready
$(function() {
	//use this method to add new colors to pallete
	//$.fn.colorPicker.addColors(['000', '000', 'fff', 'fff']);
	var namedColors = [
		{name: "Noir", hex: "000000"},
		{name: "Gris", hex: "666666"},
		{name: "Blanc", hex: "ffffff"},
		{name: "Bleu marine", hex: "010066"},
		{name: "Bleu turquoise", hex: "32ccfe"},
		{name: "Rouge", hex: "cc0001"},
		{name: "Marron", hex: "614100"},
		{name: "Vert", hex: "006500"},
		{name: "Rose", hex: "cb3398"},
		{name: "Orange", hex: "fe6500"},
		{name: "Rose pâle", hex: "fe98ca"},
		{name: "Jaune", hex: "ffcc00"},
		{name: "Violet", hex: "c2aeeb"}
	]

	$('input[name=couleur]').colorPicker({pickerDefault: "000000", colors: namedColors});
});