var $ = jQuery;

// NEW selector
jQuery.expr[':'].Contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};

// OVERWRITES old selecor
jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};

$.expr[":"].contains = $.expr.createPseudo(function(arg) {
    return function( elem ) {
        return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
    };
});


$(document).ready(function() {


	// ===== раскрываем подборку при клике на хэдер =======
	

	$('.selections__item__header').click(function(e) {
		

		var item = $(this).closest('.selections__item');
		if (item.hasClass('selections__item--opened')) {
			if (e.target.tagName != "INPUT")
				item.removeClass('selections__item--opened');
		}

		else {
			
			item.addClass('selections__item--opened');
		}
	});
	



	// ====== создаем новую подборку ====

	$('.selections__tabs__item--new').click(function(){
		var button = $(this);		
		button.addClass('selections__tabs__item--loading');

		
		$.ajax({
	      url: ajaxURL,
	      method:'POST',
	      data: {
	        action: 'add_selection',
	        page: 1
	      },
	      success: function(response) {
	      	var array = [];
			$(selectionsFormats).each(function(i,item){
				let selected = (i == 0) ? ' selected ' : '';
				array.push('<option value="'+item.name+'" '+selected+'>'+item.name+'</option>')
			});
			
			var text = '<div class="selections__item selections__item--opened" data-post="'+response.id+'"> <div class="selections__item__header"> <div class="selections__item__name"> <input type="text" class="selectionTitleInput" value="'+response.id+'" placeholder="Заголовок подборки"> </div> <div class="selections__item__date">Обновлена '+response.date+'</div> </div> <div class="selections__item__meta"> <strong>Тип подборки:</strong> <select class="type"> <option value="usual" selected>Обычная</option> <option value="color">С выделением и заголовком</option> </select> </div> <div class="selections__item__body"> <div class="selections__item__floors ui-sortable"> <div class="selections__item__content" data-columns="3" data-format="1-1-1"> <div class="selections__item__top"> <div><span>Формат этажа</span> <select class="format"> '+array.join('')+' </select></div><div><span class="button deleteFloor button-danger button-large">Удалить этаж</span></div> </div> <div class="selections__item__structure"> <div class="selections__item__structure__columns"> </div> <div class="selections__item__structure__blocks"> <div class="selections__item__structure__block add selections__item__structure__block--1" data-column="1"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> <div class="selections__item__structure__block add selections__item__structure__block--2" data-column="2"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> <div class="selections__item__structure__block add selections__item__structure__block--3" data-column="3"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> </div> </div> </div></div> <div class="selections__item__add">Добавить этаж</div> <div class="selections__item__buttons"> <div> <span class="button deleteSelection button-danger button-large">Удалить подборку</span> </div> <div> <span class="button saveSelection button-primary button-large">Сохранить подборку</span> </div> </div> </div> </div>';
			$('.selections__content--all').prepend(text);
			button.removeClass('selections__tabs__item--loading');
	      }
	    });
	});







	// ====== меняем формат подборки =====


	$('body').on('change','select.format',function() {
		var select = $(this);
		var value = select.val();
		var filtersFormats = selectionsFormats.filter(function(a){
			return a.name == value;
		});

		if (filtersFormats.length) {
			var selectedFormat = filtersFormats[0];
			var countColumns = 0;
			selectedFormat.columns.map(function(col,c){
				countColumns+=col.width;
			});
			select.closest('.selections__item__content').attr('data-columns',countColumns).attr('data-format',selectedFormat.name);
		}

		else {
			console.log("can't find selected format in formats array");
		}

	});






	// =======  вызов попапа ==========

	$('body').on('click','.add',function(){
		if ($(this).hasClass('add')) {
			var column = $(this);

			$('#addSelectionModal').arcticmodal();

			window.currentSelectionColumn = column;
		}
			
	});





	// =======  поиск ==========

	$('#searchPost').on('input',function(){
		var text = $(this).val();
		container = $(this).closest('.box-modal__content');
  		container.find('.box-modal__list__item__name:not(:contains('+text+'))').closest('.box-modal__list__item').addClass('hidden');

		container.find('.box-modal__list__item__name:contains('+text+')').closest('.box-modal__list__item').removeClass('hidden');

  		$('.box-modal__list__item__name').unmark();
  		$('.box-modal__list__item__name').mark(text);
	});






	// =======  вставляем пост в подборку ==========


	$('.addPostToSelection').click(function(){
		var columnBlock = window.currentSelectionColumn;

		var post = $(this).closest('.box-modal__list__item').attr('data-post');
		var postTitle = $(this).closest('.box-modal__list__item').find('.box-modal__list__item__name').first().text();

		$(columnBlock).removeClass('add').addClass('filled').attr('data-post',post);
		$(columnBlock).find('.selections__item__structure__block__title').text(postTitle);


		
		$('#addSelectionModal').arcticmodal('close').delay(1000).queue(function(next){
		    $('#searchPost').val('');
			$('#addSelectionModal .box-modal__list__item').removeClass('hidden');
			$('.box-modal__list__item__name').unmark();
		    next();
		    //window.currentSelectionColumn = '';
		});

	});





	//=======  удаляем пост из подборки ==========

	$('body').on('click','.selections__item__structure__block__clear',function() {
		var item = $(this).closest('.selections__item__structure__block');
		item.find('.selections__item__structure__block__title').first().text('');
		item.removeClass('filled').delay(10).queue(function(){
		    item.addClass("add").dequeue();
		});
		item.attr('data-post','');
	});







	//=======  удаляем подборку ==========


	$('body').on('click','.deleteSelection',function() {
		var selection = $(this).closest('.selections__item');
		var selectionID = selection.attr('data-post');
		selection.remove();
		$.ajax({
	      url: ajaxURL,
	      method:'POST',
	      data: {
	        action: 'remove_selection',
	        selection: selectionID
	      }
	    });

	});





	//=======  сохраняем подборку ==========



	$('body').on('click','.saveSelection',function() {
		var button = $(this);
		var selection = $(this).closest('.selections__item');
		var selectionID = selection.attr('data-post');
		var selectionType = selection.find('select.type').first().val();
		var selectionTitle = selection.find('input.selectionTitleInput').first().val();

		var posts = [];
		var formats = [];

		button.addClass('saveSelection--loading');

		/*selection.find('.selections__item__structure__block:not(:hidden)').each(function(i,item){
			posts.push($(item).attr('data-post'));
		});*/

		selection.find('.selections__item__content').each(function(f,floor){
			var floorPosts = [];
			formats.push($(floor).attr('data-format'));
			$(floor).find('.selections__item__structure__block:not(:hidden)').each(function(i,item){
				floorPosts.push($(item).attr('data-post'));
			});
			posts.push(floorPosts.join(','));
		});

		$.ajax({
	      url: ajaxURL,
	      method:'POST',
	      data: {
	        action: 'save_selection',
	        selection: selectionID,
	        posts: posts.join(';'),
	        format: formats.join(';'),
	        type: selectionType,
	        title: selectionTitle
	      },
	      success: function(response) {
	      	button.removeClass('saveSelection--loading');
	      	$('#savedSelectionModal').arcticmodal().delay(2000).queue(function(){
			    $('#savedSelectionModal').arcticmodal('close').dequeue();
			});
	      }
	    });

	});














	//============== открываем попап с подборками ==============

	$('.selections__tabs__item--insert').click(function(){
		$('#addToHomeModal').arcticmodal();
	});


	// =======  поиск подборки ==========

	$('#searchSelection').on('input',function(){
		var text = $(this).val();
		container = $(this).closest('.box-modal__content');
  		container.find('.box-modal__list__item__name:not(:contains('+text+'))').closest('.box-modal__list__item').addClass('hidden');

		container.find('.box-modal__list__item__name:contains('+text+')').closest('.box-modal__list__item').removeClass('hidden');

  		$('.box-modal__list__item__name').unmark();
  		$('.box-modal__list__item__name').mark(text);
	});




	// ======= вставляем подборку на главную ===========

	$('.addSelectionToHome').click(function(){
		var button = $(this);
		var selection = button.closest('.box-modal__list__item');
		var id = selection.attr('data-selection');
		var date = selection.attr('data-date');
		var title = selection.find('.box-modal__list__item__name').first().html().replace('box-modal__list__item__descr','selections__item__name__descr');


		$('.selections__content').append('<div class="selections__item"> <div class="selections__item__header"> <div class="selections__item__name">'+title+'</div> <div class="selections__item__date selections__item__date--flex"><span>Обновлена '+date+'</span><span class="button deleteSelectionFromHome button-danger button-large">Удалить</span></div> <input type="hidden" name="home_selections[]" value="'+id+'"> </div> </div>');

		$('#addToHomeModal').arcticmodal('close');
		$("#emptyHomepage").hide();
	});


	// ============ разрешаем перетаскивать подборки на главной ==========

	$(".selections__content--homepage").sortable();




	//========== убираем подборку с главной ==================


	$('body').on('click','.deleteSelectionFromHome',function(){
		$(this).closest('.selections__item').remove();
	});




	// =========== открываем попап, чтобы добавить материал в Золотой фонд =============


	$('body').on('click','.golden__add',function(){
		var golden = $(this).closest('.golden').attr('data-i');
		$('#addToGoldenModal').arcticmodal();
		$('#currentGolden').val(golden);

	});



	//=========== вставляем материал в Золотой фонд ================================


	$('.addPostToGolden').click(function(){
		var golden = $('#currentGolden').val();
		var post = $(this).closest('.box-modal__list__item').attr('data-post');
		var postTitle = $(this).closest('.box-modal__list__item').find('.box-modal__list__item__name').first().text();

		$('.golden[data-i="'+golden+'"]').find('.golden__items').first().append('<div class="golden__item"> <div class="golden__item__delete"></div> <div class="golden__item__text">'+postTitle+'</div> <input type="hidden" name="golden_selections_'+golden+'[]" value="'+post+'"> </div>');


		
		$('#addToGoldenModal').arcticmodal('close').delay(1000).queue(function(next){
		    $('#searchPostForGolden').val('');
			$('#addToGoldenModal .box-modal__list__item').removeClass('hidden');
			$('.box-modal__list__item__name').unmark();
		    next();
		});

	});


	//=========== поиск поста для Золотого фонда ==================

	$('#searchPostForGolden').on('input',function(){
		var text = $(this).val();
		container = $(this).closest('.box-modal__content');
  		container.find('.box-modal__list__item__name:not(:contains('+text+'))').closest('.box-modal__list__item').addClass('hidden');

		container.find('.box-modal__list__item__name:contains('+text+')').closest('.box-modal__list__item').removeClass('hidden');

  		$('.box-modal__list__item__name').unmark();
  		$('.box-modal__list__item__name').mark(text);
	});




	//=========== удаляем пост из Золотого фонда ===============

	$('body').on('click','.golden__item__delete',function(){
		$(this).closest('.golden__item').remove();
	});






	// ============ разрешаем перетаскивать материалы внутри Золотого фонда ==========

	$(".golden__items").sortable();





	// ========== добавляем этаж в подборку ================

	$('body').on('click','.selections__item__add', function(){
		var floors = $(this).closest('.selections__item').find('.selections__item__floors').first();
		var array = [];
		$(selectionsFormats).each(function(i,item){
			let selected = (i == 0) ? ' selected ' : '';
			array.push('<option value="'+item.name+'" '+selected+'>'+item.name+'</option>')
		});
		var text = '<div class="selections__item__content" data-columns="3" data-format="1-1-1"> <div class="selections__item__top"> <div><span>Формат этажа</span> <select class="format"> '+array.join('')+' </select></div><div><span class="button deleteFloor button-danger button-large">Удалить этаж</span></div> </div> <div class="selections__item__structure"> <div class="selections__item__structure__columns"> </div> <div class="selections__item__structure__blocks"> <div class="selections__item__structure__block add selections__item__structure__block--1" data-column="1"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> <div class="selections__item__structure__block add selections__item__structure__block--2" data-column="2"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> <div class="selections__item__structure__block add selections__item__structure__block--3" data-column="3"> <div class="selections__item__structure__block__clear"></div> <div class="selections__item__structure__block__title"></div> </div> </div> </div> </div>';
		floors.append(text);
	});



	// ========== удаляем этаж из подборки ============

	$('body').on('click','.deleteFloor', function(){
		$(this).closest('.selections__item__content').remove();
	});




	// ========== разрешаем сортировать этажи =============

	$(".selections__item__floors").sortable();


	





});