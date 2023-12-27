<?php




function selections_settings_page(){

        if (isset($_GET['settings-updated'])) {
            echo '<div id="message" class="updated fade"><p><strong>Изменения сохранены</strong></p></div>';
        }

        $link = admin_url()."admin.php?page=".SELECTIONS_SLUG;
        $formats = json_decode(SELECTIONS_FORMATS,true); 

        ?>
	    <div class="wrap selections">

	    	<?php if ($_GET['layout'] == 'mainpage'):?>

	    		<div class="selections__tabs">

		    		<a href="<?=$link?>" class="selections__tabs__item">Подборки</a>
		    		<a href="<?=$link?>&layout=mainpage" class="selections__tabs__item selections__tabs__item--disabled">Главная страница</a>
		    		<a href="<?=$link?>&layout=golden" class="selections__tabs__item">Золотой фонд</a>

		    		<a href="javascript:void(0)" class="selections__tabs__item selections__tabs__item--insert selections__tabs__item--right">+ Вставить подборку</a>

	    		</div>
	    		<form method="post" action="options.php">

	    		<div class="selections__content selections__content--homepage">
	    			<?php $homepage = get_option('home_selections');?>
	    			<?php if (count($homepage)):?>
	    			<?php foreach ($homepage as $selection):?>
	    				<?php $item = get_post($selection);?>
	    				<div class="selections__item">
	    					<div class="selections__item__header">
		    					<div class="selections__item__name">
		    						<?=$item->post_title?>
		    						<div class="selections__item__name__descr">
		    							Материалы: <?=get_selection_posts_names($item->ID)?>
		    						</div>
		    						
		    					</div>
		    					<div class="selections__item__date selections__item__date--flex">

		    						<span>Обновлена <?=filter_date(get_post_modified_time('U',true,$item))?></span>
		    						
		    						<span class="button deleteSelectionFromHome button-danger button-large">Удалить</span>
		    					</div>

		    					<input type="hidden" name="home_selections[]" value="<?=$item->ID?>">
		    				</div>
	    				</div>
	    			<?php endforeach; else:?>
	    				<p id="emptyHomepage"><br/><br/>Пока нет подборок на главной</p>
	    			<?php endif;?>
	    			
	    		</div>
	    		<?php settings_fields("section_settings");
	            do_settings_sections("theme-options");  submit_button();?>
	    		</form>

	    	<?php elseif($_GET['layout'] == 'golden'):?>

	    		<div class="selections__tabs">

		    		<a href="<?=$link?>" class="selections__tabs__item">Подборки</a>
		    		<a href="<?=$link?>&layout=mainpage" class="selections__tabs__item">Главная страница</a>
		    		<a href="<?=$link?>&layout=golden" class="selections__tabs__item selections__tabs__item--disabled">Золотой фонд</a>


	    		</div>
	    		<form method="post" action="options.php">

	    		<div class="selections__content selections__content--golden">
	    			<?php for ($i=1;$i<=3;$i++):?>
	    			<?php $selection = get_option('golden_selections_'.$i);?>
	    			<div class="golden" data-i="<?=$i?>">
	    				<input type="text" class="golden__input" value="<?=get_option('golden_title_'.$i)?>" placeholder="Заголовок" name="golden_title_<?=$i?>">
	    				<div class="golden__items">
	    				<?php if (count($selection)):?>
	    					<?php foreach ($selection as $item):?>
	    						<div class="golden__item">
	    							<div class="golden__item__delete"></div>
	    							<div class="golden__item__text"><?=get_post($item)->post_title?></div>
	    							<input type="hidden" name="golden_selections_<?=$i?>[]" value="<?=$item?>">
	    						</div>
	    					<?php endforeach;?>
	    				<?php endif;?>
	    				</div>
	    				<div class="golden__add">Добавить материал</div>
	    			</div>
	    			<?php endfor;?>
	    			
	    		</div>
	    		<?php settings_fields("section_settings2");
	            do_settings_sections("theme-options");  submit_button();?>
	    		</form>

	    		

	    	<?php else:?>

	    		<div class="selections__tabs">

		    		<a href="<?=$link?>" class="selections__tabs__item selections__tabs__item--disabled">Подборки</a>
		    		<a href="<?=$link?>&layout=mainpage" class="selections__tabs__item">Главная страница</a>
		    		<a href="<?=$link?>&layout=golden" class="selections__tabs__item">Золотой фонд</a>
		    		<a href="javascript:void(0)" class="selections__tabs__item selections__tabs__item--right selections__tabs__item--new">+ Добавить подборку</a>
		    	</div>

	    		<div class="selections__content selections__content--all">

	    			<?php $selections = get_posts(array('post_type'=>'selection','posts_per_page'=>-1,'post_status'=>'draft'));?>
	    			<?php foreach ($selections as $key => $item):?>
	    				<?php $selectionFormats = explode(';',get_post_meta($item->ID,'selection_format',true)); ?>
	    				<?php $type = (get_post_meta($item->ID,'selection_type',true)) ? get_post_meta($item->ID,'selection_type',true) : 'usual';?>

	    			<div class="selections__item" data-post="<?=$item->ID?>">
	    				<div class="selections__item__header">
	    					<div class="selections__item__name">
	    						<input type="text" class="selectionTitleInput" value="<?=$item->post_title?>" placeholder="Заголовок подборки"/>


	    						
	    					</div>
	    					<div class="selections__item__date">Обновлена <?=filter_date(get_post_modified_time('U',true,$item))?></div>
	    				</div>

	    				<div class="selections__item__meta">
	    					<strong>Тип подборки:</strong>
	    					<select class="type">
	    						<option value="usual" <?=($type == 'usual') ? 'selected': ''?>>Обычная</option>
	    						<option value="color" <?=($type == 'color') ? 'selected': ''?>>С выделением и заголовком</option>
	    					</select>
	    				</div>

	    				<div class="selections__item__body">
	    					<div class="selections__item__floors">
	    						<?php $allPosts = explode(';',get_post_meta($item->ID,'selection_posts',true));
	    						foreach ($allPosts as $p => $postsIDs ):?>
	    						<?php $posts = array();?>
	    						<?php $format = $selectionFormats[$p];?>
	    						<?php $columns = count_columns($format);?>
	    						<div class="selections__item__content" data-columns="<?=$columns?>" data-format="<?=$format?>">
			    					<div class="selections__item__top">
			    						<div>
				    						<span>Формат этажа</span>
				    						<select class="format">
				    							<?php foreach($formats as $f):?>
				    							<?php $s = ($format == $f['name']) ? ' selected ' : '';?>
				    							<option value="<?=$f['name']?>" <?=$s?>><?=$f['name']?></option>
				    							<?php endforeach;?>
				    						</select>
				    					</div>
				    					<div>
				    						<span class="button deleteFloor button-danger button-large">Удалить этаж</span>
				    					</div>
			    					</div>
			    					<div class="selections__item__structure">
			    						<div class="selections__item__structure__columns">
			    						</div>
			    						<div class="selections__item__structure__blocks">
			    							<?php
			    							$floor_posts = explode(',',$postsIDs);
											if (count($floor_posts)) {
												foreach ($floor_posts as $p) {
													$posts[] = get_post($p);
												}
											}?>
			    							<?php if (count($posts)):?>
				    							<?php foreach ($posts as $key => $value):?>
					    							<div class="selections__item__structure__block filled selections__item__structure__block--<?=$key+1?>" data-column="<?=$key+1?>" data-post=<?=$value->ID?>>
					    								<div class="selections__item__structure__block__clear"></div>
					    								<div class="selections__item__structure__block__title"><?=$value->post_title?></div>

					    							</div>
				    							<?php endforeach;?>
				    							<?php for ($i=count($posts)+1;$i<=3;$i++):?>
				    								<div class="selections__item__structure__block add selections__item__structure__block--<?=$i?>" data-column="<?=$i?>">
					    								<div class="selections__item__structure__block__clear"></div>
					    								<div class="selections__item__structure__block__title"></div>
				    								</div>
				    							<?php endfor;?>
				    						<?php else:?>
				    						<div class="selections__item__structure__block add selections__item__structure__block--1" data-column="1">
			    								<div class="selections__item__structure__block__clear"></div>
			    								<div class="selections__item__structure__block__title"></div>
			    							</div>
				    						<div class="selections__item__structure__block add selections__item__structure__block--2" data-column="2">
			    								<div class="selections__item__structure__block__clear"></div>
			    								<div class="selections__item__structure__block__title"></div>
			    							</div>
			    							<div class="selections__item__structure__block add selections__item__structure__block--3" data-column="3">
			    								<div class="selections__item__structure__block__clear"></div>
			    								<div class="selections__item__structure__block__title"></div>
			    							</div>
				    						<?php endif;?>
			    							
			    							
			    						</div>
			    					</div>
			    					
			    				</div>
			    			<?php endforeach;?>
	    					</div>
		    				
		    				<div class="selections__item__add">Добавить этаж</div>
		    				
		    				<div class="selections__item__buttons">
		    					<div>
		    						<span class="button deleteSelection button-danger button-large">Удалить подборку</span>
		    					</div>
		    					<div>
		    						<span class="button saveSelection button-primary button-large">Сохранить подборку</span>
		    					</div>
		    				</div>
	    				</div>
	    			</div>
	    			<?php endforeach;?>
	    			
	    		</div>

	    	<?php endif;?>
		</div>
		<div style="display: none">
			 <div class="box-modal" id="savedSelectionModal">
			 	
			 	<div class="selections-loader">
			 			Подборка сохранена
			 	</div>
			 	

		        
		    </div>
		</div>
		<div style="display: none">
			 <div class="box-modal" id="addSelectionModal">
			 	<div class="box-modal__title">
			 		<div class="box-modal__close arcticmodal-close"></div>
		        	<h1>Добавить материал</h1>	
			 	</div>
			 	<div class="box-modal__content">
			 		<input type="text" id="searchPost" class="box-modal__search">
			 		<div class="box-modal__list">
			 			<?php $allPosts = get_posts(array('posts_per_page'=>-1));?>
			 			<?php foreach ($allPosts as $key => $item):?>
			 				<div class="box-modal__list__item" data-post="<?=$item->ID?>">
			 					<div class="box-modal__list__item__name">
			 						<?=$item->post_title?>
			 					</div>
			 					<div class="box-modal__list__item__button">
			 						<span class="button addPostToSelection">Добавить в подборку</span>
			 					</div>
			 				</div>
			 			<?php endforeach;?>
			 		</div>
			 	</div>

		        
		    </div>
		</div>
		<div style="display: none">
			 <div class="box-modal" id="addToHomeModal">
			 	<div class="box-modal__title">
			 		<div class="box-modal__close arcticmodal-close"></div>
		        	<h1>Вставить подборку</h1>	
			 	</div>
			 	<div class="box-modal__content">
			 		<input type="text" id="searchSelection" class="box-modal__search">
			 		<div class="box-modal__list">
			 			<?php $allPosts = get_posts(array('posts_per_page'=>-1,'post_type'=>'selection','post_status'=>'draft','orderby' => 'modified', 'order' => 'DESC'));?>
			 			<?php foreach ($allPosts as $key => $item):?>
			 				<div class="box-modal__list__item" data-selection="<?=$item->ID?>" data-date="<?=filter_date(get_post_modified_time('U',true,$item))?>">
			 					<div class="box-modal__list__item__name">
			 						<?=$item->post_title?>
			 						<div class="box-modal__list__item__descr">
			 							Материалы: <?=get_selection_posts_names($item->ID)?>
			 						</div>
			 					</div>
			 					<div class="box-modal__list__item__button">
			 						<span class="button addSelectionToHome">Добавить на главную</span>
			 					</div>
			 				</div>
			 			<?php endforeach;?>
			 		</div>
			 	</div>
		        
		    </div>
		</div>
		<div style="display: none">
			 <div class="box-modal" id="addToGoldenModal">
			 	<div class="box-modal__title">
			 		<div class="box-modal__close arcticmodal-close"></div>
		        	<h1>Добавить материал</h1>	
			 	</div>
			 	<div class="box-modal__content">
			 		<input type="text" id="searchPostForGolden" class="box-modal__search">
			 		<div class="box-modal__list">
			 			<?php $allPosts = get_posts(array('posts_per_page'=>-1));?>
			 			<?php foreach ($allPosts as $key => $item):?>
			 				<div class="box-modal__list__item" data-post="<?=$item->ID?>">
			 					<div class="box-modal__list__item__name">
			 						<?=$item->post_title?>
			 					</div>
			 					<div class="box-modal__list__item__button">
			 						<span class="button addPostToGolden">Добавить в фонд</span>
			 					</div>
			 				</div>
			 			<?php endforeach;?>
			 		</div>
			 	</div>

			 	<input type="hidden" id="currentGolden">
		        
		    </div>
		</div>
		<script>
			var selectionsFormats = <?=trim(SELECTIONS_FORMATS)?>;
		</script>
	<?php
}




?>