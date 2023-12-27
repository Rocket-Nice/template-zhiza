$(document).ready(function(){
	if ($('#loadMoreCategory').length) {
		var ppp = 24, page = 1;
	}

	$('#loadMoreCategory').click(function(){
		var offset = ppp*page;
		var button = $(this);
		var text = button.text();
		button.text('Загружаем...');
		$.post(ajaxurl,{
			action: 'load_more_category',
			category: button.attr('data-category'),
			offset: offset,
			ppp: ppp
			
		}).done(function(response){
			console.log(response);
			button.text(text);
			if (parseInt(response.status)) {
				$('#loadCategoryHere').append(response.items);
				cardMediaLoader();
				page++;
				if (!response.hasMore) {
					button.remove();
				}
			}
			
		});
	})
});



$(document).ready(function(){
	if ($('#loadHomeMore').length) {
		var ppp = 24, page = 0;
		var exclude = [];
		$('[data-post-id]').each(function(i,item){
			exclude.push($(item).attr('data-post-id'));
		});
	}

	$('#loadHomeMore').click(function(){
		var offset = ppp*page;
		var button = $(this);
		var text = button.text();
		

		button.text('Загружаем...');
		console.log({
			action: 'load_more_home',
			exclude: exclude,
			offset: offset,
			ppp: ppp
			
		});

		$.post(ajaxurl,{
			action: 'load_more_home',
			exclude: exclude,
			offset: offset,
			ppp: ppp
			
		}).done(function(response){
			
			console.log(response);
			button.text(text);
			if (parseInt(response.status)) {
				$('#loadHomeHere').append(response.items);
				cardMediaLoader();
				page++;
				if (!response.hasMore) {
					button.remove();
				}
			}
			
		});
	})
});
