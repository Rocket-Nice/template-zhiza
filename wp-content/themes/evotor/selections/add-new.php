<?php

function add_selection_ajax() {

	$post = wp_insert_post(array(
		'post_type' => 'selection'
		));

	$update['ID'] = $post;
	$update['post_title'] = '#'.$post;

	wp_update_post($update);

	$response['id'] = $post;
	$response['date'] = filter_date(get_post_modified_time('U',true,$post));

	wp_send_json($response);

}

add_action('wp_ajax_nopriv_add_selection', 'add_selection_ajax'); 
add_action('wp_ajax_add_selection', 'add_selection_ajax');



?>