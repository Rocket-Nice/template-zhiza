<?php

function remove_selection_ajax() {

	$selection = $_POST['selection'];

	if ($selection):

		$update['ID'] = $selection;
		$update['post_status'] = 'trash';

		wp_update_post($update);

		

	endif;
	exit();

}

add_action('wp_ajax_nopriv_remove_selection', 'remove_selection_ajax'); 
add_action('wp_ajax_remove_selection', 'remove_selection_ajax');



?>