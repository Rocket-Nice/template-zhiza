function cardMediaLoader() {
	$(".card__media img").each(function() {
	    let src = $(this).attr('src');

	    $(this).parent().css({
	      'background-image': `url(${src})` 
	    });
	  });
}

$(document).ready(function() {
  cardMediaLoader();
});
