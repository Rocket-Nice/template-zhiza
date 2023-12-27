<?php get_template_part('new/headaer_new');?>


	<?php
		$term_id = 21;
		$taxonomy = 'podcastscat'; // С версии 4.4. параметр стал не обязательным.
		$term = get_term( $term_id, $taxonomy );
		// die(var_dump($term));
	 ?>

	<section id="archive_podcast">
	  <div class="wrapper">
	    <h1 class="page_title">Подкасты</h1>
	    <div class="box">
	      <div class="once left">
	        <div class="img_block">
	          <img src="<?php echo get_field('podcast_services_img', 'podcastscat_21');?>" alt="" loading='lazy'>
	        </div>
	        <div class="desc_block">
	          <div class="title"><?php echo $term->name; ?></div>
	          <div class="info">
	            <?php echo $term->description; ?>
	          </div>
	        </div>
	        <div class="pd_box_mob owl-carousel">
        	    <?php
        	    	$my_arr = array();
        	        $args = array('post_type' => 'podcasts','podcastscat' => 'zavarili-biznes','posts_per_page' => -1 );
        	        query_posts( $args );
        	        while ( have_posts() ) {
        	        	the_post();
        				array_push($my_arr, get_the_ID());
        	       	}
        	       	$my_arr = array_chunk($my_arr, 3);
    	       	?>
				<?php $iii=200; foreach ($my_arr as $my ) { $iii++; ?>
					<div class="pd_box_once_mob">
						<?php $n=0; foreach ( $my as $post) { $n++; ?>
							<div class="bo">
							  <a href="<?=get_the_permalink($post)?>" class="more"></a>
							  <div class="date"><?php echo get_the_date('j F', $post); ?></div>
							  <a href="<?=get_the_permalink($post)?>" class="name">
							  	<?php if( get_field('main_pod_title', $post) )  { ?>
							  		<?php the_field('main_pod_title', $post) ?>
							  	<?php }else{ ?>
							  		<?php echo get_the_title($post) ?>
							  	<?php } ?>
							  </a>
							  <div class="pl">
								<script>
								$(document).ready(function(){
								    $("#jquery_jplayer_<?php echo $iii; ?><?php echo $n; ?>").jPlayer({
								      ready: function () {
								        $(this).jPlayer("setMedia", {
								          mp3: "<?php echo trim(get_field('podcast_frame', $post)); ?>"
								        });
								      },
								      play: function() { // To avoid multiple jPlayers playing together.
								            $(this).jPlayer("pauseOthers");
								          },
								      swfPath: "/js",
								      supplied: "mp3",
								      wmode: "window",
								      cssSelectorAncestor: "#jp_container_<?php echo $iii; ?><?php echo $n; ?>",
								      remainingDuration: true,
								      toggleDuration: true
								    });
								  });
								</script>
								<div id="jquery_jplayer_<?php echo $iii; ?><?php echo $n; ?>" class="jp-jplayer"></div>
								<div id="jp_container_<?php echo $iii; ?><?php echo $n; ?>" class="jp-audio">
								  <div class="jp-type-single">
								    <div class="jp-gui jp-interface">
								      <ul class="jp-controls">
								        <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
								        <li><a href="javascript:;" class="jp-pause" tabindex="1"></a></li>
								      </ul>
								      <div class="jp-progress">
								        <div class="jp-seek-bar">
								          <div class="jp-play-bar"></div>
								        </div>
								      </div>
								      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
								    </div>
								  </div>
								</div>

							  </div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
	        </div>
	        <?php $my_services =  get_field('podcast_services', 'podcastscat_21');?>
	        <div class="listen_block">
	          <div class="title">Слушайте, где удобно</div>
	          <ul>
	          	<?php foreach ($my_services as $service) { ?>
	          		<li><a href="<?php echo $service['podcast_services_once_link'] ?>"><?php echo $service['podcast_services_once_name'] ?></a></li>
	          	<?php } ?>
	          </ul>
	        </div>
	        <div class="pd_box">
		        <?php
		        	$args = array(
		        		'post_type' => 'podcasts',
		        		'podcastscat' => 'zavarili-biznes',
		        		'posts_per_page' => -1
		        	);
		        	query_posts( $args );
		        	$n=0; while ( have_posts() ) {  the_post(); $n++; ?>
					<div class="pd_box_once">
					  <a href="<?php the_permalink(); ?>" class="more"></a>
					    <a href="<?php the_permalink(); ?>" class="name">
						  	<div class="date"><?php echo get_the_date('j F', get_post(get_the_ID())); ?></div>
						  	<?php the_title() ?>
					  	</a>
					  <div class="desc">
					    <?php echo getPostExcerpt(get_the_ID());?>
					  </div>
					  <div class="pl">
					  	<script>
					  	$(document).ready(function(){
					  	    $("#jquery_jplayer_<?php echo $n; ?>").jPlayer({
					  	      ready: function () {
					  	        $(this).jPlayer("setMedia", {
					  	          mp3: "<?php echo trim(get_field('podcast_frame')); ?>"
					  	        });
					  	      },
					  	      play: function() { // To avoid multiple jPlayers playing together.
					  	            $(this).jPlayer("pauseOthers");
					  	          },
					  	      swfPath: "/js",
					  	      supplied: "mp3",
					  	      wmode: "window",
					  	      cssSelectorAncestor: "#jp_container_<?php echo $n; ?>",
					  	      remainingDuration: true,
					  	      toggleDuration: true
					  	    });
					  	  });
					  	</script>
					  	<div id="jquery_jplayer_<?php echo $n; ?>" class="jp-jplayer"></div>
					  	<div id="jp_container_<?php echo $n; ?>" class="jp-audio">
					  	  <div class="jp-type-single">
					  	    <div class="jp-gui jp-interface">
					  	      <ul class="jp-controls">
					  	        <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
					  	        <li><a href="javascript:;" class="jp-pause" tabindex="1"></a></li>
					  	      </ul>
					  	      <div class="jp-progress">
					  	        <div class="jp-seek-bar">
					  	          <div class="jp-play-bar"></div>
					  	        </div>
					  	      </div>
					  	      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
					  	    </div>
					  	  </div>
					  	</div>
					  </div>
					</div>
		        	<?php } ?>
	        </div>
	      </div>


	      <?php
	      	$term_id2 = 22;
	      	$term_2 = get_term( $term_id2, $taxonomy );
	      	// die(var_dump($term));
	       ?>


	      <div class="once right">
	        <div class="img_block">
	          <img src="<?php echo get_field('podcast_services_img', 'podcastscat_22');?>" alt="" loading='lazy'>
	        </div>
	        <div class="desc_block">
	          <div class="title"><?php echo $term_2->name; ?></div>
	          <div class="info">
	            <?php echo $term_2->description; ?>
	          </div>
	        </div>


	        	        <div class="pd_box_mob owl-carousel">
	                	    <?php
	                	    	$my_arr = array();
	                	        $args = array('post_type' => 'podcasts','podcastscat' => 'biznes-roboty-mechty','posts_per_page' => -1 );
	                	        query_posts( $args );
	                	        while ( have_posts() ) {
	                	        	the_post();
	                				array_push($my_arr, get_the_ID());
	                	       	}
	                	       	$my_arr = array_chunk($my_arr, 3);
	            	       	?>
	        				<?php $iii=400; foreach ($my_arr as $my ) { $iii++; ?>
	        					<div class="pd_box_once_mob">
	        						<?php $n=0; foreach ( $my as $post) { $n++; ?>
	        							<div class="bo color">
	        							  <a href="<?=get_the_permalink($post)?>" class="more"></a>
	        							  <div class="date"><?php echo get_the_date('j F', $post); ?></div>
	        							  <a href="<?=get_the_permalink($post)?>" class="name">
	        							  	<?php if( get_field('main_pod_title', $post) )  { ?>
	        							  		<?php the_field('main_pod_title', $post) ?>
	        							  	<?php }else{ ?>
	        							  		<?php echo get_the_title($post) ?>
	        							  	<?php } ?>
	        							  </a>
	        							  <div class="pl">
	        								<script>
	        								$(document).ready(function(){
	        								    $("#jquery_jplayer_<?php echo $iii; ?><?php echo $n; ?>").jPlayer({
	        								      ready: function () {
	        								        $(this).jPlayer("setMedia", {
	        								          mp3: "<?php echo trim(get_field('podcast_frame', $post)); ?>"
	        								        });
	        								      },
	        								      play: function() {
	        								            $(this).jPlayer("pauseOthers");
	        								          },
	        								      swfPath: "/js",
	        								      supplied: "mp3",
	        								      wmode: "window",
	        								      cssSelectorAncestor: "#jp_container_<?php echo $iii; ?><?php echo $n; ?>",
	        								      remainingDuration: true,
	        								      toggleDuration: true
	        								    });
	        								  });
	        								</script>
	        								<div id="jquery_jplayer_<?php echo $iii; ?><?php echo $n; ?>" class="jp-jplayer"></div>
	        								<div id="jp_container_<?php echo $iii; ?><?php echo $n; ?>" class="jp-audio">
	        								  <div class="jp-type-single">
	        								    <div class="jp-gui jp-interface">
	        								      <ul class="jp-controls">
	        								        <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
	        								        <li><a href="javascript:;" class="jp-pause" tabindex="1"></a></li>
	        								      </ul>
	        								      <div class="jp-progress">
	        								        <div class="jp-seek-bar">
	        								          <div class="jp-play-bar"></div>
	        								        </div>
	        								      </div>
	        								      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
	        								    </div>
	        								  </div>
	        								</div>
	        							  </div>
	        							</div>
	        						<?php } ?>
	        					</div>
	        				<?php } ?>
	        	        </div>


	        <?php $my_services2 =  get_field('podcast_services', 'podcastscat_22');?>
	        <div class="listen_block">
	          <div class="title">Слушайте, где удобно</div>
	          <ul>
	          	<?php foreach ($my_services2 as $service) { ?>
	          		<li><a href="<?php echo $service['podcast_services_once_link'] ?>"><?php echo $service['podcast_services_once_name'] ?></a></li>
	          	<?php } ?>
	          </ul>
	        </div>

            <div class="pd_box">
    	        <?php
    	        	$args = array(
    	        		'post_type' => 'podcasts',
    	        		'podcastscat' => 'biznes-roboty-mechty',
    	        		'posts_per_page' => -1
    	        	);
    	        	query_posts( $args );
    	        	$n=100; while ( have_posts() ) {  the_post(); $n++; ?>
    				<div class="pd_box_once color">
    				  <a href="<?php the_permalink(); ?>" class="more"></a>
    				    <a href="<?php the_permalink(); ?>" class="name">
	    				  	<div class="date"><?php echo get_the_date('j F', get_post(get_the_ID())); ?></div>
	    				  	<?php the_title() ?>
    				    </a>
    				  <div class="desc">
    				    <?php echo getPostExcerpt(get_the_ID());?>
    				  </div>
    				  <div class="pl">
    				  	<script>
    				  	$(document).ready(function(){
    				  	    $("#jquery_jplayer_<?php echo $n; ?>").jPlayer({
    				  	      ready: function () {
    				  	        $(this).jPlayer("setMedia", {
    				  	          mp3: "<?php echo trim(get_field('podcast_frame')); ?>"
    				  	        });
    				  	      },
    				  	      play: function() { // To avoid multiple jPlayers playing together.
    				  	            $(this).jPlayer("pauseOthers");
    				  	          },
    				  	      swfPath: "/js",
    				  	      supplied: "mp3",
    				  	      wmode: "window",
    				  	      cssSelectorAncestor: "#jp_container_<?php echo $n; ?>",
    				  	      remainingDuration: true,
    				  	      toggleDuration: true
    				  	    });
    				  	  });
    				  	</script>
    				  	<div id="jquery_jplayer_<?php echo $n; ?>" class="jp-jplayer"></div>
    				  	<div id="jp_container_<?php echo $n; ?>" class="jp-audio">
    				  	  <div class="jp-type-single">
    				  	    <div class="jp-gui jp-interface">
    				  	      <ul class="jp-controls">
    				  	        <li><a href="javascript:;" class="jp-play" tabindex="1"></a></li>
    				  	        <li><a href="javascript:;" class="jp-pause" tabindex="1"></a></li>
    				  	      </ul>
    				  	      <div class="jp-progress">
    				  	        <div class="jp-seek-bar">
    				  	          <div class="jp-play-bar"></div>
    				  	        </div>
    				  	      </div>
    				  	      <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
    				  	    </div>
    				  	  </div>
    				  	</div>
    				  </div>
    				</div>
    	        	<?php } ?>
            </div>

	      </div>
	      <div class="clr"></div>
	    </div>
	  </div>
	</section>
<?php get_template_part('footer');?>
