function convertToSlug(text){
    return text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}

$('.slug-reference').on('blur', function() {
	$('.slug').val(convertToSlug($(this).val()));
});

$('.delete-btn').on('click', function(e) {
	if(!confirm("Are you sure you want to delete this item?")) e.preventDefault();
});

function getFlashMessage(success, message){

	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": true,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	switch(success)
	{
		case '1':
				toastr["success"](message);
			break;

		case '0':			
				toastr["error"](message);
			break;
	}
	
}