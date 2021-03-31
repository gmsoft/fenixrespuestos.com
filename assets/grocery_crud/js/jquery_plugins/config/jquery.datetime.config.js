  $(function(){
    $('.datetime-input').datetime({
		userLang	: 'es',
		americanMode: true,
	});
    
	$('.datetime-input-clear').button();
	
	$('.datetime-input-clear').click(function(){
		$(this).parent().find('.datetime-input').val("");
		return false;
	});	

  });