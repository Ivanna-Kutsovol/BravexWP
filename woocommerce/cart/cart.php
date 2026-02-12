<?php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');

if (WC()->cart->is_empty()) {
    wc_get_template('cart/cart-empty.php');
    return;
}
?>

<h1 class="cart__title">Shopping Bag</h1>
<div class="container">
    <section class="cart">
        <span class="cart__line"></span>

        <div class="cart__items">
            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                $product = $cart_item['data'];
                if (!$product || !$product->exists() || $cart_item['quantity'] <= 0) {
                    continue;
                }
                $product_name = $product->get_name();
                $product_permalink = $product->is_visible() ? $product->get_permalink($cart_item) : '';
                $product_image = $product->get_image();
                $item_price = wc_price($cart_item['line_subtotal']);
                $item_meta = wc_get_formatted_cart_item_data($cart_item, true);
            ?>
            <div class="cart__item">
                <div class="cart__main">
                    <div class="cart__img">
                        <?php echo $product_permalink ? '<a href="' . esc_url($product_permalink) . '">' . $product_image . '</a>' : $product_image; ?>
                    </div>

                    <div class="cart__content">
                        <h2 class="cart__name"><?php echo esc_html($product_name); ?></h2>
                        <?php if ($product->get_short_description()) : ?>
                            <p class="cart__description"><?php echo wp_kses_post($product->get_short_description()); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item_meta)) : ?>
                            <p class="cart__size"><?php echo wp_kses_post($item_meta); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="cart__meta">
                    <a class="cart__delete" href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" aria-label="<?php esc_attr_e('Remove this item', 'woocommerce'); ?>"></a>
                    <p class="cart__item__price"><?php echo wp_kses_post($item_price); ?></p>
                </div>
            </div>

            <span class="cart__line"></span>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="cart__summary">
        <h2 class="cart__summary__title">Order Summary</h2>
        <div class="cart__summary__wrapper">
            <p class="cart__summary__label">Subtotal</p>
            <p class="cart__summary__price"><?php wc_cart_totals_subtotal_html(); ?></p>
        </div>
        <div class="cart__summary__wrapper">
            <div class="cart__summary__shippingWrapper">
                <p class="cart__summary__label">Express Delivery</p>
                <p class="cart__summary__delivery"><?php echo esc_html(WC()->cart->get_shipping_method_full_label()); ?></p>
            </div>
            <p class="cart__summary__price"><?php wc_cart_totals_shipping_html(); ?></p>
        </div>
        <span class="cart__summary__line"></span>
        <div class="cart__summary__wrapper">
            <p class="cart__summary__label">Total</p>
            <p class="cart__summary__price"><?php wc_cart_totals_order_total_html(); ?></p>
        </div>
        <a  href="<?php echo esc_url(wc_get_checkout_url()); ?>"
            class="cart__summary__btn"
            aria-label="checkout">
            Checkout
            <img class="cart__summary__arrow" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/arrowCart.svg" alt="arrow"></a>
    </section>
    </div>

<?php do_action('woocommerce_after_cart'); ?>
