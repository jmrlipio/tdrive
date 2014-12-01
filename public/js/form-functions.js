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