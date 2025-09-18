<?php
add_theme_support('title-tag');

// подключение радарио для определенных страниц
function enqueue_radario_script_conditionally() {
	if (
		is_page_template('page-sobitiya.php') ||
		is_page_template('home-sobitiya.php') || 
		is_page_template('page-vistavki.php') ||
		is_page_template('home-vistavki.php') || 
		is_singular('sobitiya') ||
		is_singular('vistavki') ||
		is_front_page()
	) {
		wp_enqueue_script(
			'radario-openapi',
			'https://radario.ru/frontend/src/api/openapi/openapi.js',
			[],
			null,
			false
		);
	}
}
add_action('wp_enqueue_scripts', 'enqueue_radario_script_conditionally');

// меню
register_nav_menu('main-menu', 'Меню');
class Walker_Nav_A_Only extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {}
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes = implode(' ', $item->classes);
		$output .= '<a class="menu_item btn-ghost ' . esc_attr($classes) . '" href="' . esc_attr($item->url) . '">' . $item->title . '</a>';
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
	}
}

// Изменение стандартного названия WP записи на художники
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Художники';
    $submenu['edit.php'][5][0] = 'Все художники';
    $submenu['edit.php'][10][0] = 'Добавить художника';
    $submenu['edit.php'][16][0] = 'Метки';
}
add_action('admin_menu', 'change_post_menu_label');

function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    
    $labels->name               = 'Художники';
    $labels->singular_name      = 'Художник';
    $labels->add_new            = 'Добавить художника';
    $labels->add_new_item       = 'Добавить нового художника';
    $labels->edit_item          = 'Редактировать художника';
    $labels->new_item           = 'Новый художник';
    $labels->view_item          = 'Посмотреть художника';
    $labels->search_items       = 'Искать художника';
    $labels->not_found          = 'Художники не найдены';
    $labels->not_found_in_trash = 'В корзине художников не найдено';
    $labels->all_items          = 'Все художники';
    $labels->menu_name          = 'Художники';
    $labels->name_admin_bar     = 'Художник';
}
add_action('init', 'change_post_object_label');

// Сохранение первой буквы художника
add_action('save_post', function($post_id) {
	if (get_post_type($post_id) !== 'post') return;

	$title = get_the_title($post_id);
	$parts = explode(' ', $title);
	$letter = mb_substr($parts[0], 0, 1, 'UTF-8');
	update_post_meta($post_id, 'artist_letter', mb_strtoupper($letter));
});
add_theme_support('post-thumbnails');
?>
