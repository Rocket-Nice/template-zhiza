<?php

function save_selection_ajax() {

	$selection = $_POST['selection'];
	$posts = $_POST['posts'];
	$format = $_POST['format'];
	$type = $_POST['type'];
	$title = $_POST['title'];

	if ($selection):

		update_post_meta($selection,'selection_posts',$posts);
		update_post_meta($selection,'selection_format',$format);
		update_post_meta($selection,'selection_type',$type);

		$update['ID'] = $selection;
		$update['post_title'] = $title;

		wp_update_post($update);

		

	endif;
	exit();

}

add_action('wp_ajax_nopriv_save_selection', 'save_selection_ajax'); 
add_action('wp_ajax_save_selection', 'save_selection_ajax');



?>