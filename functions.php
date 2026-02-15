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
    wp_enqueue_style('cart', $uri . '/assets/css/cart.css');
    wp_enqueue_style('checkout', $uri . '/assets/css/checkout.css');

    wp_enqueue_script('hero', $uri . '/assets/js/hero.js', [], null, true);
    wp_enqueue_script('catalog', $uri . '/assets/js/catalog.js', [], null, true);
    wp_enqueue_script('slider', $uri . '/assets/js/slider.js', [], null, true);
});

// Use theme styles for WooCommerce pages.
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

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

// Handle custom quick add-to-cart links from homepage cards.
add_action('template_redirect', function () {
    if (!isset($_GET['bravex-add']) || !function_exists('WC')) {
        return;
    }

    $product_id = absint(wp_unslash($_GET['bravex-add']));
    if (!$product_id) {
        wc_add_notice(__('Product ID is missing in the card settings.', 'woocommerce'), 'error');
        wp_safe_redirect(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'));
        exit;
    }

    $product = wc_get_product($product_id);
    if (!$product) {
        wc_add_notice(
            sprintf(__('Product with ID %d was not found in WooCommerce.', 'woocommerce'), $product_id),
            'error'
        );
        wp_safe_redirect(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'));
        exit;
    }

    if ($product->is_type('simple')) {
        if (!$product->is_purchasable()) {
            wc_add_notice(__('This product cannot be purchased right now.', 'woocommerce'), 'error');
            wp_safe_redirect(get_permalink($product_id));
            exit;
        }

        if (!$product->is_in_stock()) {
            wc_add_notice(__('This product is out of stock.', 'woocommerce'), 'error');
            wp_safe_redirect(get_permalink($product_id));
            exit;
        }

        $added = WC()->cart->add_to_cart($product_id, 1);
        if ($added) {
            wp_safe_redirect(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'));
            exit;
        }

        wc_add_notice(__('Unable to add this product to the cart. Please check product settings.', 'woocommerce'), 'error');
        wp_safe_redirect(get_permalink($product_id));
        exit;
    }

    wc_add_notice(__('This product type requires selecting options on the product page.', 'woocommerce'), 'notice');
    wp_safe_redirect(get_permalink($product_id));
    exit;
});

// Inject product dimensions into cart item meta for custom cart layout.
add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    if (empty($cart_item['data']) || !is_a($cart_item['data'], 'WC_Product')) {
        return $item_data;
    }

    $product = $cart_item['data'];
    $length = trim((string) $product->get_length());
    $width = trim((string) $product->get_width());
    $height = trim((string) $product->get_height());

    if ($length === '' || $width === '') {
        return $item_data;
    }

    $size_label = 'XL';
    if (is_numeric($width)) {
        $size_label = ((float) $width >= 140) ? 'XL' : 'L';
    }

    $size_value = $size_label . ' ' . $length . 'x' . $width;
    if ($height !== '') {
        $size_value .= 'x' . $height;
    }

    $item_data[] = [
        'key' => 'Size',
        'value' => $size_value,
        'display' => $size_value,
    ];

    return $item_data;
}, 10, 2);

// Force classic checkout rendering so theme override `woocommerce/checkout/form-checkout.php` is used.
add_filter('the_content', function ($content) {
    if (is_admin() || !function_exists('is_checkout')) {
        return $content;
    }

    if (is_checkout() && !is_wc_endpoint_url('order-received')) {
        return do_shortcode('[woocommerce_checkout]');
    }

    return $content;
}, 999);

// Hide coupon entry link on checkout to match the design.
add_action('wp', function () {
    if (function_exists('is_checkout') && is_checkout()) {
        remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
    }
});

?>
