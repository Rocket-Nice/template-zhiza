<?php get_template_part('new/headaer_new');?>
<?php
	$my_term = get_the_terms( get_the_ID(), 'podcastscat' );
 ?>

<section id="single_podcast">
  <div class="wrapper">
    <div class="top">
      <div class="img_block">
        <img src="<?php echo get_field('podcast_services_img', 'podcastscat_'.$my_term[0]->term_id.'');?>" alt="" loading='lazy'>
      </div>
      <div class="pl_block <?php if( $my_term[0]->term_id == '22' ){ ?> color<?php } ?>">
      	<script>
      	$(document).ready(function(){
      	    $("#jquery_jplayer").jPlayer({
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
      	      cssSelectorAncestor: "#jp_container",
      	      remainingDuration: true,
      	      toggleDuration: true
      	    });
      	  });
      	</script>
      	<div id="jquery_jplayer" class="jp-jplayer"></div>
      	<div id="jp_container" class="jp-audio">
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

    <div class="info_block">
      <div class="name">Подкаст «<?php echo $my_term[0]->name; ?>»</div>
      <div class="title"><?php the_title(); ?></div>
      <div class="info">
        <?php
              while( have_posts() ) : the_post();
              the_content(); // выводим контент
              endwhile;
          ?>
      </div>
    </div>

	<?php $my_services =  get_field('podcast_services', 'podcastscat_'.$my_term[0]->term_id.'');?>
	<div class="listen_block">
	  <div class="title">Слушайте, где удобно</div>
	  <ul>
	  	<?php foreach ($my_services as $service) { ?>
	  		<li><a href="<?php echo $service['podcast_services_once_link'] ?>"><?php echo $service['podcast_services_once_name'] ?></a></li>
	  	<?php } ?>
	  </ul>
	</div>


    <div class="author_info">
    	<div class="once">
    		<?php the_field('pdocast_info'); ?>
    	</div>
      <div class="once">
        <p>Опубликовали <?php echo get_the_date('j F Y', get_post(get_the_ID())); ?> года</p>
      </div>
    </div>

    <div class="soc_block">
    <div class="share">
    	<div class="likely">
    		<div class="twitter">Твитнуть</div>
    		<div class="facebook">Поделиться</div>
    		<div class="vkontakte">Поделиться</div>
    		<div class="telegram">Отправить</div>
    		<div class="pinterest">Запинить</div>
    	</div>
    </div>
     </div>
  </div>
</section>


<section id="other_podcast">
  <div class="wrapper">
    <div class="block_title">Другие эпизоды</div>
    <div class="block_title_m">Другие эпизоды</div>
    <div class="other_podcast_carousel owl-carousel">
      <div class="once left">
      	<?php
      		$term_id = 21;
      		$taxonomy = 'podcastscat';
      		$term = get_term( $term_id, $taxonomy );
      	 ?>
        <div class="img_block">
          <img src="<?php echo get_field('podcast_services_img', 'podcastscat_21');?>" alt="" loading='lazy'>
        </div>
        <div class="desc_block">
          <div class="title"><?php echo $term->name; ?></div>
          <div class="info">
            <?php echo $term->description; ?>
          </div>
          <?php
          	$args = array(
          		'post_type' => 'podcasts',
          		'podcastscat' => 'zavarili-biznes',
              'posts_per_page' => -1
          	);
          	query_posts( $args );
          	$n=0;
          	while ( have_posts() ) {  the_post(); $n++; } ?>

          <div class="all_num_block">
              <a href="/podcasts/">
                <div class="num"><?php echo $n; ?></div>
                <div class="st"><span><?php echo epizod_count_text($n); ?></span></div>
              </a>
            </div>
        </div>
      </div>
      <div class="once right">
      	<?php
      		$term_id = 22;
      		$taxonomy = 'podcastscat';
      		$term = get_term( $term_id, $taxonomy );
      	 ?>
        <div class="img_block">
          <img src="<?php echo get_field('podcast_services_img', 'podcastscat_22');?>" alt="" loading='lazy'>
        </div>
        <div class="desc_block">
           <div class="title"><?php echo $term->name; ?></div>
            <div class="info">
              <?php echo $term->description; ?>
            </div>
            <?php
            	$args = array('post_type' => 'podcasts', 'podcastscat' => 'biznes-roboty-mechty', 'posts_per_page' => -1 );
            	query_posts( $args ); $n=0;
            	while ( have_posts() ) {  the_post(); $n++; }
            ?>

          <div class="all_num_block">
              <a href="/podcasts/">
                <div class="num"><?php echo $n; ?></div>
                <div class="st"><span><?php echo epizod_count_text($n); ?></span></div>
              </a>
            </div>
        </div>
      </div>
    </div>
    <!-- <div class="clr"></div> -->
  </div>
</section>

<?php get_template_part('footer');?>
