<?php

include "options-page.php";
include "add-new.php";
include "delete.php";
include "save.php";

define("SELECTIONS_SLUG","selections");

define("SELECTIONS_FORMATS",'
	[
		{
			"name": "1-1-1",
			"columns": [
				{
					"count":1, 
					"width":1
				},
				{
					"count":1,
					"width":1
				},
				{
					"count":1, 
					"width":1
				}
			]
		},
		{
			"name": "1-1", 
			"columns": [
				{
					"count":1, 
					"width":1
				}, 
				{
					"count":1, 
					"width":1
				} 
			] 
		}, 
		{
			"name": "1-2", 
			"columns": [
				{
					"count":1, 
					"width":1
				}, 
				{
					"count":1, 
					"width":2
				} 
			] 
		}, 
		{
			"name": "2-1", 
			"columns": [
				{
					"count":1, 
					"width":2
				},
				{
					"count":1, 
					"width":1
				} 
			] 
		}, 
		{
			"name": "1", 
			"columns": [
				{
					"count":1, 
					"width":1
				} 
			] 
		} 
	]
');


add_action('init', 'selection_custom_post_types');
function selection_custom_post_types() {

	global $wp_rewrite;

	register_post_type('selection', array(
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => false,
		'publicly_queryable' => true,
		'supports' => array('title'),
		'labels' =>
		    array(
		        'name' => 'Подборки',
		        'singular_name' => 'Подборка',
		        'add_new' => 'Добавить подборку',
		        'add_new_item' => 'Добавить подборку',
		        'edit_item' => 'Редактировать подборку',
		        'new_item' => 'Новая подборка',
		        'all_items' => 'Все подборки',
		        'view_item' => 'Просмотр подборки',
		        'search_items' => 'Искать подборку',
		        'not_found' =>  'Не найдено подборки',
		        'not_found_in_trash' => 'Не найдено подборок в корзине',
		        'parent_item_colon' => '',
	        ),
	    'has_archive' => true,
		'rewrite' => true
	));
}



function add_theme_menu_item(){
	add_menu_page("Подборки", "Подборки", "manage_options", SELECTIONS_SLUG, "selections_settings_page", 'dashicons-editor-table', 20);
}

add_action("admin_menu", "add_theme_menu_item");


function selections_css() {
	if (is_admin() && $_GET['page'] == SELECTIONS_SLUG) {

		echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/selections/arcticmodal/jquery.arcticmodal-0.3.css?v=2">';


		echo "<link href='".get_template_directory_uri()."/selections/css/selections.css?v=".get_file_ver('selections/css/selections.css')."' rel='stylesheet'>";
	}
}
add_action('admin_head','selections_css');

function selections_js() {
	if (is_admin() && $_GET['page'] == SELECTIONS_SLUG) {
		echo '
    <script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>';
		echo "<script>var ajaxURL = '".admin_url()."admin-ajax.php';</script>";
		echo "<script src='".get_template_directory_uri()."/selections/js/scripts.js?v=".get_file_ver('selections/js/scripts.js')."'></script>";
		echo '<script src="'.get_template_directory_uri().'/selections/arcticmodal/jquery.arcticmodal-0.3.min.js?v='.get_file_ver('selections/arcticmodal/jquery.arcticmodal-0.3.min.js').'"></script>';
		echo '<script src="'.get_template_directory_uri().'/selections/js/jquery.mark.min.js"></script>';
	}
}
add_action('admin_footer','selections_js',100);






function count_columns($format) {
	 $formats = json_decode(SELECTIONS_FORMATS,true);
	foreach ($formats as $key => $value) {
		if ($value['name'] == $format) $found = $value;
	}

	$width = 0;

	foreach ($found['columns'] as $column) {
		$width+= intval($column['width']);
	}

	return $width;

}



function get_selection_posts($selection_id) {
	$meta = get_post_meta($selection_id,'selection_posts',true);
	$posts = [];

	if ($meta) {
		$floors = explode(';',$meta);

		foreach ($floors as $floor) {
			$ids = explode(',',$floor);
			$getPosts = get_posts(array('include'=>$ids,'posts_per_page'=>-1));

			$posts = array_merge($posts,$getPosts);
		}


		return $posts;
	}


}

function get_selection_floors($selection_id) {
	$meta = get_post_meta($selection_id,'selection_posts',true);
	$posts = [];

	if ($meta) {
		$floors = explode(';',$meta);

		return $floors;
	}


}

/**
 * @param $selection_id - id поста, выбранного через get_option('home_selections')
 */
function get_selection_view($selection_id, $post_name) {
	$meta = explode(';',get_post_meta($selection_id,'selection_format',true));
	$floors = get_selection_floors($selection_id);
	$type = get_post_meta($selection_id,'selection_type',true);

	if ($type == 'color') echo '<section class="level" data-title="Подборка">
          <h2>'.get_the_title($selection_id).'</h2>';
	foreach ($floors as $key => $floor) {
		$floor_posts = explode(',',$floor);
		if (count($floor_posts)) {
			foreach ($floor_posts as $p) {
				$posts[] = get_post($p);
			}
		}

		echo '<div class="row">';
		$postTitleName = $post_name;
		include(get_template_directory() . "/selections/view/".$meta[$key].".php");
		echo '</div>';
		unset($posts);
	}

	if ($type == 'color') echo '</section>';



}

function home_selections(){}


function selections_options(){
	add_settings_field("home_selections", "", "display_home_selections", "theme-options");


    register_setting("section_settings", "home_selections");

    add_settings_field("golden_selections_1", "", "display_home_selections", "theme-options");
	add_settings_field("golden_selections_2", "", "display_home_selections", "theme-options");
	add_settings_field("golden_selections_3", "", "display_home_selections", "theme-options");

    register_setting("section_settings2", "golden_selections_1");
    register_setting("section_settings2", "golden_selections_2");
    register_setting("section_settings2", "golden_selections_3");

    add_settings_field("golden_title_1", "", "display_home_selections", "theme-options");
	add_settings_field("golden_title_2", "", "display_home_selections", "theme-options");
	add_settings_field("golden_title_3", "", "display_home_selections", "theme-options");

    register_setting("section_settings2", "golden_title_1");
    register_setting("section_settings2", "golden_title_2");
    register_setting("section_settings2", "golden_title_3");
}


add_action("admin_init", "selections_options");





function get_selection_posts_names($selection_id) {
	$posts = get_selection_posts($selection_id);
	foreach ($posts as $key => $p) {
		$array[] = $p->post_title;
	}

	return (count($array)) ? implode(', ',$array) : 'Нет материалов';
}






?>
