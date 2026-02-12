<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(''); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo.svg" alt="BRAVEX">
    </a>
    <nav class="menu" aria-label="Main navigation">
        <ul class="menu__list">
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/')); ?>">SHOWROOM</a></li>
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/')); ?>">DELIVERY AND PAYMENT</a></li>
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/')); ?>">TIPS</a></li>
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/')); ?>">3D VISUALIZATION</a></li>
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/#insights')); ?>">BLOG</a></li>
            <li class="menu__item"><a class="menu__link" href="<?php echo esc_url(home_url('/#catalog')); ?>">CATALOG</a></li>
        </ul>
    </nav>
    <div class="header-actions">
        <button class="header-actions__btn header-actions__btn--search" aria-label="Search">
            <svg class="header-icon" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1_28)">
                <path d="M18.2324 17.3927L13.2541 12.4146C14.3162 11.1621 14.9588 9.54334 14.9588 7.77649C14.9586 3.81588 11.7367 0.59375 7.7762 0.59375C3.81573 0.59375 0.59375 3.81588 0.59375 7.77649C0.59375 11.737 3.81573 14.9589 7.7762 14.9589C9.5432 14.9589 11.1621 14.3164 12.4144 13.2543L17.3927 18.2324C17.5086 18.3484 17.6606 18.4064 17.8126 18.4064C17.9646 18.4064 18.1165 18.3484 18.2326 18.2324C18.4643 18.0006 18.4643 17.6244 18.2324 17.3927ZM1.78125 7.77649C1.78125 4.47064 4.47049 1.78125 7.7762 1.78125C11.0819 1.78125 13.7713 4.47064 13.7713 7.77649C13.7713 11.0822 11.0819 13.7714 7.7762 13.7714C4.47049 13.7713 1.78125 11.082 1.78125 7.77649Z" fill="currentColor"/>
            </g>
            <defs>
                <clipPath id="clip0_1_28">
                    <rect width="19" height="19" fill="white"/>
                </clipPath>
            </defs>
            </svg>
        </button>

        <button class="header-actions__btn header-actions__btn--heart" aria-label="Favorites">
            <svg class="header-icon" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.49998 17.943C9.22949 17.943 8.96871 17.845 8.76548 17.667C7.99792 16.9958 7.25791 16.3651 6.60502 15.8087L6.60169 15.8058C4.68751 14.1746 3.03456 12.7659 1.88446 11.3782C0.598822 9.82688 0 8.35599 0 6.74912C0 5.18792 0.535331 3.74761 1.50728 2.69333C2.49082 1.62658 3.84038 1.03906 5.30779 1.03906C6.40454 1.03906 7.40896 1.3858 8.29306 2.06957C8.73924 2.41472 9.14367 2.83713 9.49998 3.32984C9.85643 2.83713 10.2607 2.41472 10.707 2.06957C11.5911 1.3858 12.5956 1.03906 13.6923 1.03906C15.1596 1.03906 16.5093 1.62658 17.4928 2.69333C18.4648 3.74761 19 5.18792 19 6.74912C19 8.35599 18.4013 9.82688 17.1157 11.3781C15.9656 12.7659 14.3127 14.1745 12.3989 15.8055C11.7448 16.3628 11.0036 16.9945 10.2343 17.6673C10.0313 17.845 9.77033 17.943 9.49998 17.943ZM5.30779 2.15205C4.15494 2.15205 3.09587 2.61215 2.32542 3.44769C1.54352 4.29585 1.11284 5.46827 1.11284 6.74912C1.11284 8.10057 1.61512 9.30923 2.7413 10.6681C3.8298 11.9815 5.44883 13.3613 7.32343 14.9588L7.32691 14.9617C7.98227 15.5203 8.72518 16.1535 9.49839 16.8295C10.2762 16.1521 11.0203 15.518 11.677 14.9586C13.5514 13.361 15.1703 11.9815 16.2588 10.6681C17.3848 9.30923 17.8871 8.10057 17.8871 6.74912C17.8871 5.46827 17.4564 4.29585 16.6745 3.44769C15.9042 2.61215 14.845 2.15205 13.6923 2.15205C12.8478 2.15205 12.0724 2.42052 11.3878 2.94991C10.7776 3.42189 10.3526 4.01854 10.1034 4.43602C9.9753 4.6507 9.74974 4.77885 9.49998 4.77885C9.25022 4.77885 9.02466 4.6507 8.89652 4.43602C8.64748 4.01854 8.22247 3.42189 7.61219 2.94991C6.92755 2.42052 6.15217 2.15205 5.30779 2.15205Z" fill="currentColor"/>
            </svg>
        </button>

        <a href="<?php echo esc_url(function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart')); ?>"
            class="header-actions__btn header-actions__btn--cart"
            aria-label="Cart">
            <svg class="header-icon" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.1407 4.5H10.6668V3.15C10.6668 1.41328 9.25352 0 7.5168 0C5.78009 0 4.3668 1.41328 4.3668 3.15V4.5H2.89288C1.71778 4.5 0.732527 5.41758 0.648574 6.58962L0.00567128 15.5896C-0.0386959 16.2105 0.178816 16.8275 0.603328 17.2828C1.02742 17.7385 1.62725 18 2.24998 18H12.7837C13.4064 18 14.0062 17.7385 14.4303 17.2828C14.8548 16.8275 15.0723 16.2105 15.028 15.5896L14.3851 6.58962C14.3011 5.41758 13.3158 4.5 12.1407 4.5ZM5.2668 3.15C5.2668 1.90944 6.27625 0.9 7.5168 0.9C8.75736 0.9 9.7668 1.90944 9.7668 3.15V4.5H5.2668V3.15ZM13.772 16.6698C13.5136 16.9471 13.1629 17.1 12.7836 17.1H2.24994C1.87071 17.1 1.51999 16.9471 1.26159 16.6698C1.00362 16.3924 0.876632 16.0317 0.903457 15.6537L1.54636 6.65374C1.59646 5.95062 2.18796 5.4 2.89284 5.4H12.1407C12.8456 5.4 13.4371 5.95062 13.4872 6.65378L14.1301 15.6538C14.1569 16.0317 14.0299 16.3925 13.772 16.6698Z" fill="currentColor"/>
            </svg>
        </a>
    </div>
</header>
