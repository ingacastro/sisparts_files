<script src="/metronic-assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	 //Applying masks
	$('.phone-mask').inputmask("mask", {
		mask:"(99) 9999-9999"
	});
/*	$('.rfc-mask').inputmask("mask", {
		mask:"(99) 9999-9999"
	});*/
	$('.integer-mask').inputmask({ "mask": "9", "repeat": "13"});
/*	$('.integer-mask').inputmask("integer", {
	    rightAlign: false,
	    allowMinus: false,
	    oncleared: function () { self.Value(''); }
	});*/
	$('.currency-mask').inputmask("numeric", {
	    radixPoint: ".",
	    groupSeparator: ",",
	    digits: 2,
	    autoGroup: true,
	    allowMinus: false,
	    prefix: '$ ', //Space after $, this will not truncate the first character.
	    rightAlign: false,
	    removeMaskOnSubmit: true,
	    oncleared: function () { self.Value(''); }
	});
});
</script>