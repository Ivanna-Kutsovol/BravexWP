<?php
// Theme setup: menus, thumbnails, WooCommerce support.
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');

    register_nav_menus([
        'main' => 'Main Menu',
    ]);
});

// Enqueue styles and scripts.
add_action('wp_enqueue_scripts', function () {
    $uri = get_template_directory_uri();

    wp_enqueue_style('normalize', $uri . '/assets/css/normalize.css');
    wp_enqueue_style('main', $uri . '/assets/css/main.css');
    wp_enqueue_style('header', $uri . '/assets/css/components/header.css');
    wp_enqueue_style('hero', $uri . '/assets/css/components/hero.css');
    wp_enqueue_style('categories', $uri . '/assets/css/components/categories.css');
    wp_enqueue_style('catalog', $uri . '/assets/css/components/catalog.css');
    wp_enqueue_style('newitems', $uri . '/assets/css/components/newItems.css');
    wp_enqueue_style('advantages', $uri . '/assets/css/components/advantages.css');
    wp_enqueue_style('collection', $uri . '/assets/css/components/collection.css');
    wp_enqueue_style('insights', $uri . '/assets/css/components/insights.css');
    wp_enqueue_style('footer', $uri . '/assets/css/footer.css');

    wp_enqueue_script('hero', $uri . '/assets/js/hero.js', [], null, true);
    wp_enqueue_script('catalog', $uri . '/assets/js/catalog.js', [], null, true);
    wp_enqueue_script('slider', $uri . '/assets/js/slider.js', [], null, true);
});

// ACF JSON: ensure WordPress loads field groups from the theme folder.
add_filter('acf/settings/save_json', function ($path) {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]);
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

// Custom Post Type: New Items (for homepage slider cards).
add_action('init', function () {
    $labels = [
        'name' => 'New Items',
        'singular_name' => 'New Item',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Item',
        'edit_item' => 'Edit Item',
        'new_item' => 'New Item',
        'view_item' => 'View Item',
        'search_items' => 'Search Items',
        'not_found' => 'No items found',
        'not_found_in_trash' => 'No items found in Trash',
        'all_items' => 'All Items',
        'menu_name' => 'New Items',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => ['title', 'thumbnail'],
        'has_archive' => false,
        'show_in_rest' => true,
    ];

    register_post_type('new_item', $args);
});

// Customize the WooCommerce checkout button to match theme styles.
add_filter('woocommerce_order_button_html', function ($button) {
    $label = apply_filters('woocommerce_order_button_text', __('Continue', 'woocommerce'));
    $arrow = esc_url(get_template_directory_uri() . '/assets/img/arrowCart.svg');
    return '<button type="submit" class="cart__summary__btn" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($label) . '">' . esc_html($label) . ' <img class="cart__summary__arrow" src="' . $arrow . '" alt="arrow"></button>';
});

?>
