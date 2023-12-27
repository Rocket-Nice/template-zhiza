<?php
/**
 * @var $postTitleName - название текущего поста. Используется для таргетирование в dataLayer
 */
?>

<?php foreach($posts as $p=>$post):?>
<div class="col-xs-12">
	<article class="topic" data-post-id="<?=$post->ID?>" <?php if ($type != 'color'):?> style="background-color: <?=get_post_meta($post->ID,'card_bg',true)?>; color: <?=get_post_meta($post->ID,'card_color',true)?>;"<?php endif;?>>

		<?php if (has_post_thumbnail($post)):?>


		<?php if( get_field('main_thumb_img', $post) ){ ?>
		<div class="topic__image topic__image--cover 111">
			<?php $top_bg_url = wp_get_attachment_image_src(get_field('main_thumb_img', $post),'large', true); ?>
			<img src="<?php echo $top_bg_url[0] ?>" alt="" style="max-height: 450px;" loading='lazy'>
		</div>
		<?php }else{ ?>
			<div class="topic__image <?php echo (get_post_meta($post->ID,'card_not-cover',true)) ? '' : 'topic__image--cover'?> asd">
				<?php $thumb = get_the_post_thumbnail($post->ID, 'large', array('alt' => $post->post_title));
				$thumb = apply_filters( 'bj_lazy_load_html', $thumb, 10 ); ?>
				<?php echo $thumb; ?>
			</div>
		<?php } ?>

		<?php elseif (get_post_meta($post->ID,'show_video',true)):?>
		<div class="topic__image topic__image--embed">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=parse_youtube(get_post_meta($post->ID,'video_link',true))?>?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		</div>
		<?php endif;?>

		<div class="topic__info">
			<div class="topic__tags">
				<?php foreach (get_post_categories($post) as $c):?>
				<a href="<?=get_term_link($c,'category')?>">
                    <?=$c->name?>
                </a>
				<?php endforeach;?>
			</div>

			<div class="topic__title">
				<a href="<?=get_the_permalink($post)?>"
                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $postTitleName ?>','eventLabel': '<?=$post->post_title?>',});"
                >
                    <?=$post->post_title?>
                </a>
			</div>
			<p> <?php echo getPostExcerpt($post->ID);?></p>
		</div>
	</article>
</div>
<?php endforeach;?>
