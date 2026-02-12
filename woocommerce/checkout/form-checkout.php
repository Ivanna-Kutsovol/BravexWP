<?php
defined('ABSPATH') || exit;

$checkout = WC()->checkout();

do_action('woocommerce_before_checkout_form', $checkout);

if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

$billing_fields = $checkout->get_checkout_fields('billing');

function bravex_required_attr($key, $billing_fields) {
    return (!empty($billing_fields[$key]['required'])) ? ' required' : '';
}

function bravex_value($checkout, $key) {
    return esc_attr($checkout->get_value($key));
}
?>

<h1 class="cart__title">Checkout</h1>
<div class="container">
    <section class="checkout">
    <nav class="checkout__steps" aria-label="Checkout steps">
        <button class="checkout__step checkout__step--active" type="button">Shipping & Billing</button>
        <button class="checkout__step" type="button">Payment</button>
    </nav>

    <form name="checkout" method="post" class="checkout__form woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>

        <section class="checkout__section">
            <h2 class="checkout__section-title">Contact Info</h2>
            <div class="checkout__field">
                <input class="checkout__input" type="email" name="billing_email" id="billing_email" placeholder="Email" value="<?php echo bravex_value($checkout, 'billing_email'); ?>"<?php echo bravex_required_attr('billing_email', $billing_fields); ?> />
            </div>
            <div class="checkout__field">
                <input class="checkout__input" type="tel" name="billing_phone" id="billing_phone" placeholder="Phone" value="<?php echo bravex_value($checkout, 'billing_phone'); ?>"<?php echo bravex_required_attr('billing_phone', $billing_fields); ?> />
            </div>
        </section>

        <section class="checkout__section">
            <h2 class="checkout__section-title">Shipping Address</h2>

            <div class="checkout__row">
                <div class="checkout__field">
                    <input class="checkout__input" type="text" name="billing_first_name" id="billing_first_name" placeholder="First Name" value="<?php echo bravex_value($checkout, 'billing_first_name'); ?>"<?php echo bravex_required_attr('billing_first_name', $billing_fields); ?> />
                </div>
                <div class="checkout__field">
                    <input class="checkout__input" type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" value="<?php echo bravex_value($checkout, 'billing_last_name'); ?>"<?php echo bravex_required_attr('billing_last_name', $billing_fields); ?> />
                </div>
            </div>

            <div class="checkout__field">
                <input class="checkout__input" type="text" name="billing_country" id="billing_country" placeholder="Country" value="<?php echo bravex_value($checkout, 'billing_country'); ?>"<?php echo bravex_required_attr('billing_country', $billing_fields); ?> />
            </div>

            <div class="checkout__field">
                <input class="checkout__input" type="text" name="billing_state" id="billing_state" placeholder="State / Region" value="<?php echo bravex_value($checkout, 'billing_state'); ?>"<?php echo bravex_required_attr('billing_state', $billing_fields); ?> />
            </div>

            <div class="checkout__field">
                <input class="checkout__input" type="text" name="billing_address_1" id="billing_address_1" placeholder="Address" value="<?php echo bravex_value($checkout, 'billing_address_1'); ?>"<?php echo bravex_required_attr('billing_address_1', $billing_fields); ?> />
            </div>

            <div class="checkout__row">
                <div class="checkout__field">
                    <input class="checkout__input" type="text" name="billing_city" id="billing_city" placeholder="City" value="<?php echo bravex_value($checkout, 'billing_city'); ?>"<?php echo bravex_required_attr('billing_city', $billing_fields); ?> />
                </div>
            <div class="checkout__field">
                <input class="checkout__input" type="text" name="billing_postcode" id="billing_postcode" placeholder="Postal Code" value="<?php echo bravex_value($checkout, 'billing_postcode'); ?>"<?php echo bravex_required_attr('billing_postcode', $billing_fields); ?> />
            </div>
        </div>
    </section>

        <section class="checkout__section">
        <h2 class="checkout__section-title">Shipping Method</h2>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <?php
            $packages = WC()->shipping()->get_packages();
            $chosen_methods = WC()->session->get('chosen_shipping_methods', []);
            foreach ($packages as $i => $package) :
                $available_methods = $package['rates'];
                foreach ($available_methods as $method) :
                    $checked = isset($chosen_methods[$i]) && $method->id === $chosen_methods[$i];
                    $subtitle = $method->get_meta_data() ? '' : '';
            ?>
            <label class="checkout__radio">
                <input type="radio" name="shipping_method[<?php echo esc_attr($i); ?>]" value="<?php echo esc_attr($method->id); ?>" <?php checked($checked); ?> />
                <span class="checkout__radio-mark"></span>
                <span class="checkout__radio-text">
                    <span class="checkout__radio-title"><?php echo esc_html($method->get_label()); ?></span>
                </span>
                <span class="checkout__price"><?php echo wp_kses_post(wc_price($method->get_cost())); ?></span>
            </label>
            <?php
                endforeach;
            endforeach;
            ?>
        <?php else : ?>
            <label class="checkout__radio">
                <input type="radio" name="shipping_method[0]" value="no_shipping" checked />
                <span class="checkout__radio-mark"></span>
                <span class="checkout__radio-text">
                    <span class="checkout__radio-title"><?php esc_html_e('Pick up In-Store', 'woocommerce'); ?></span>
                </span>
            </label>
        <?php endif; ?>
        </section>

        <?php do_action('woocommerce_checkout_after_customer_details'); ?>

        <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
        <input type="hidden" name="woocommerce_checkout_update_totals" value="1" />
    </form>
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
        <div class="checkout__payment">
            <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>
        </div>
    </section>
    </div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
