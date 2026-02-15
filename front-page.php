<?php get_header(); ?>

<?php
$template_uri = get_template_directory_uri();

function bravex_image_url($field_name) {
    $img = get_field($field_name);
    return (is_array($img) && isset($img['url'])) ? $img['url'] : '';
}
?>

<main>
    <section id="hero" class="hero">
        <div class="slider-container" id="slider-container">
            <div class="hero__content">
                <h1 class="hero__title"><?php echo esc_html(get_field('hero_title')); ?></h1>
                <p class="hero__text"><?php echo esc_html(get_field('hero_text')); ?></p>
                <div class="container-btn">
                    <?php
                    $hero_btn_text = get_field('hero_button_text');
                    $hero_btn_link = get_field('hero_button_link');
                    ?>
                    <?php if ($hero_btn_link) : ?>
                        <a class="btn-text" href="<?php echo esc_url($hero_btn_link); ?>"><?php echo esc_html($hero_btn_text); ?></a>
                    <?php else : ?>
                        <button class="btn-text"><?php echo esc_html($hero_btn_text); ?></button>
                    <?php endif; ?>
                    <img class="btn-img" src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
                </div>
            </div>

            <?php
            $hero_videos = [];
            for ($i = 1; $i <= 3; $i++) {
                $file = get_field("hero_video_{$i}_file");
                $poster = get_field("hero_video_{$i}_poster");
                $hero_videos[] = [
                    'file' => is_array($file) && isset($file['url']) ? $file['url'] : '',
                    'poster' => is_array($poster) && isset($poster['url']) ? $poster['url'] : ''
                ];
            }

            $hero_videos = array_values(array_filter($hero_videos, function ($video) {
                return !empty($video['file']);
            }));

            if (count($hero_videos) === 0) {
                $hero_videos = [
                    ['file' => $template_uri . '/assets/video/hero/hero0.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                    ['file' => $template_uri . '/assets/video/hero/hero1.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                    ['file' => $template_uri . '/assets/video/hero/hero2.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                ];
            }

            foreach ($hero_videos as $index => $video) :
                if (!$video['file']) continue;
                $poster_url = $video['poster'] ? $video['poster'] : ($template_uri . '/assets/img/hero/slide1.svg');
            ?>
                <video class="hero__video <?php echo $index === 0 ? 'block' : ''; ?>" muted autoplay loop playsinline poster="<?php echo esc_url($poster_url); ?>">
                    <source src="<?php echo esc_url($video['file']); ?>" type="video/mp4">
                </video>
            <?php endforeach; ?>

            <div class="bottom" id="bottom"></div>
        </div>
        <div class="hero__shadow"></div>
    </section>

    <section id="categories" class="categories">
        <div class="block__header">
            <h2 class="block__title">
                <?php echo esc_html(get_field('categories_title_prefix')); ?>
                <p class="block__title--block"><?php echo esc_html(get_field('categories_title_highlight')); ?></p>
            </h2>
            <div class="block__logo">
                <img src="<?php echo esc_url($template_uri); ?>/assets/img/logo.svg" alt="BRAVEX">
            </div>
        </div>
        <div class="cards" id="cards">
            <?php
            $default_category_images = [
                $template_uri . '/assets/img/categories/furnitureSofas.png',
                $template_uri . '/assets/img/categories/childrenFurniture.png',
                $template_uri . '/assets/img/categories/bathroomSanitaryFurniture.png',
                $template_uri . '/assets/img/categories/kitchens.png',
                $template_uri . '/assets/img/categories/lightingMirrors.png',
                $template_uri . '/assets/img/categories/doorsGlassPartitions.png',
                $template_uri . '/assets/img/categories/decorFinishingMaterials.png',
                $template_uri . '/assets/img/categories/architectureStairs.png',
            ];
            ?>
            <?php for ($i = 1; $i <= 8; $i++) :
                $cat_title = get_field("category_{$i}_title");
                $cat_link = get_field("category_{$i}_link");
                $cat_img = get_field("category_{$i}_image");
                $cat_img_url = is_array($cat_img) && isset($cat_img['url']) ? $cat_img['url'] : ($default_category_images[$i - 1] ?? '');
                if (!$cat_title && !$cat_img_url) continue;
            ?>
                <div class="card">
                    <?php if ($cat_link) : ?>
                        <a href="<?php echo esc_url($cat_link); ?>">
                            <?php if ($cat_img_url) : ?>
                                <img src="<?php echo esc_url($cat_img_url); ?>" alt="<?php echo esc_attr($cat_title); ?>">
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <?php if ($cat_img_url) : ?>
                            <img src="<?php echo esc_url($cat_img_url); ?>" alt="<?php echo esc_attr($cat_title); ?>">
                        <?php endif; ?>
                    <?php endif; ?>
                    <p class="card__title"><?php echo esc_html($cat_title); ?></p>
                </div>
            <?php endfor; ?>
        </div>
        <div class="container-btn btn--categories">
            <?php
            $cat_btn_text = get_field('categories_button_text');
            $cat_btn_link = get_field('categories_button_link');
            ?>
            <?php if ($cat_btn_link) : ?>
                <a class="btn-text" href="<?php echo esc_url($cat_btn_link); ?>"><?php echo esc_html($cat_btn_text); ?></a>
            <?php else : ?>
                <button class="btn-text"><?php echo esc_html($cat_btn_text); ?></button>
            <?php endif; ?>
            <img class="btn-img" src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
        </div>
    </section>

    <section id="catalog" class="catalog">
        <h2 class="catalog__title"><?php echo esc_html(get_field('catalog_title')); ?></h2>
        <div class="slider-container">
            <?php
            $catalog_videos = [];
            for ($i = 1; $i <= 4; $i++) {
                $file = get_field("catalog_video_{$i}_file");
                $poster = get_field("catalog_video_{$i}_poster");
                $catalog_videos[] = [
                    'file' => is_array($file) && isset($file['url']) ? $file['url'] : '',
                    'poster' => is_array($poster) && isset($poster['url']) ? $poster['url'] : ''
                ];
            }

            $catalog_videos = array_values(array_filter($catalog_videos, function ($video) {
                return !empty($video['file']);
            }));

            if (count($catalog_videos) === 0) {
                $catalog_videos = [
                    ['file' => $template_uri . '/assets/video/catalog/catalog0.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                    ['file' => $template_uri . '/assets/video/catalog/catalog1.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                    ['file' => $template_uri . '/assets/video/catalog/catalog2.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                    ['file' => $template_uri . '/assets/video/catalog/catalog6.mp4', 'poster' => $template_uri . '/assets/img/hero/slide1.svg'],
                ];
            }

            foreach ($catalog_videos as $index => $video) :
                if (!$video['file']) continue;
                $poster_url = $video['poster'] ? $video['poster'] : ($template_uri . '/assets/img/hero/slide1.svg');
            ?>
                <video class="catalog__video <?php echo $index === 2 ? 'block' : ''; ?>" muted autoplay loop playsinline poster="<?php echo esc_url($poster_url); ?>">
                    <source src="<?php echo esc_url($video['file']); ?>" type="video/mp4">
                </video>
            <?php endforeach; ?>
        </div>
        <div class="block__content catalog__content">
            <h3 class="block__mainText catalog__mainText"><?php echo esc_html(get_field('catalog_main_text')); ?></h3>
            <div class="block__container">
                <?php
                $catalog_logo = get_field('catalog_logo');
                $catalog_logo_url = is_array($catalog_logo) && isset($catalog_logo['url']) ? $catalog_logo['url'] : $template_uri . '/assets/img/logo.svg';
                ?>
                <img class="catalog__img" src="<?php echo esc_url($catalog_logo_url); ?>" alt="logo">
                <span class="line"></span>
                <p class="container__text"><?php echo esc_html(get_field('catalog_description')); ?></p>
            </div>
        </div>
        <div class="block__content--main">
            <div class="container-btn btn--catalog">
                <?php
                $catalog_btn_text = get_field('catalog_button_text');
                $catalog_btn_link = get_field('catalog_button_link');
                ?>
                <?php if ($catalog_btn_link) : ?>
                    <a class="btn-text" href="<?php echo esc_url($catalog_btn_link); ?>"><?php echo esc_html($catalog_btn_text); ?></a>
                <?php else : ?>
                    <button class="btn-text"><?php echo esc_html($catalog_btn_text); ?></button>
                <?php endif; ?>
                <img class="btn-img" src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
            </div>
            <div class="block__cards">
                <?php
                $catalog_active_index = (int) get_field('catalog_active_index');
                if ($catalog_active_index <= 0) $catalog_active_index = 3;
                ?>
                <?php for ($i = 1; $i <= 4; $i++) :
                    $card_title = get_field("catalog_card_{$i}_title");
                    if (!$card_title) continue;
                    $card_class = ($i === $catalog_active_index) ? 'block__card catalog__card catalog__active' : 'block__card catalog__card';
                ?>
                    <div class="<?php echo esc_attr($card_class); ?>">
                        <p class="block__text"><?php echo esc_html($card_title); ?></p>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section id="newItems" class="newItems">
        <div class="newItems__header">
            <h2 class="block__title"><?php echo esc_html(get_field('new_items_title')); ?></h2>
            <div class="block__arrows">
                <div class="block__arrow left">
                    <img src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
                </div>
                <div class="block__arrow right block__active">
                    <img src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
                </div>
            </div>
        </div>
        <div class="newItems__cards-container">
            <div id="newItemsCards" class="newItems__cards">
                <?php
                $new_items = new WP_Query([
                    'post_type' => 'new_item',
                    'posts_per_page' => 8,
                ]);
                if ($new_items->have_posts()) :
                    while ($new_items->have_posts()) : $new_items->the_post();
                        $product_id = get_field('product_id');
                        $price = get_field('price');
                        $size = get_field('size');
                        $image = get_field('image');
                        $image_url = is_array($image) && isset($image['url']) ? $image['url'] : '';
                ?>
                <div class="newItems__card">
                    <?php if ($image_url) : ?>
                        <img class="newItems__img" src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php endif; ?>
                    <div class="newItems__content">
                        <?php if ($size) : ?>
                            <p class="newItems__description"><?php echo esc_html($size); ?></p>
                        <?php endif; ?>
                        <div class="newItems__titleWrapper">
                            <p class="newItems__title"><?php the_title(); ?></p>
                            <?php if ($price) : ?>
                                <p class="newItems__price"><?php echo esc_html($price); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($product_id) : ?>
                        <a class="newItems__plus" href="<?php echo esc_url(add_query_arg('bravex-add', (int) $product_id, home_url('/'))); ?>">+</a>
                    <?php else : ?>
                        <span class="newItems__plus">+</span>
                    <?php endif; ?>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <section id="advantages" class="advantages">
        <div class="block__header">
            <h2 class="block__title">
                <?php echo esc_html(get_field('advantages_title_prefix')); ?>
                <p class="block__title--block"><?php echo esc_html(get_field('advantages_title_highlight')); ?></p>
            </h2>
            <div class="block__logo">
                <img src="<?php echo esc_url($template_uri); ?>/assets/img/logo.svg" alt="BRAVEX">
            </div>
        </div>
        <div class="advantages__cards-container">
            <div id="advantagesCards" class="advantages__cards">
                <?php
                $default_advantage_icons = [
                    $template_uri . '/assets/img/advantages/icon0.svg',
                    $template_uri . '/assets/img/advantages/icon1.svg',
                    $template_uri . '/assets/img/advantages/icon2.svg',
                    $template_uri . '/assets/img/advantages/icon3.svg',
                    $template_uri . '/assets/img/advantages/icon4.svg',
                    $template_uri . '/assets/img/advantages/icon5.svg',
                    $template_uri . '/assets/img/advantages/icon6.svg',
                    $template_uri . '/assets/img/advantages/icon7.svg',
                ];
                ?>
                <?php for ($i = 1; $i <= 8; $i++) :
                    $adv_icon = get_field("advantage_{$i}_icon");
                    $adv_title = get_field("advantage_{$i}_title");
                    $adv_text = get_field("advantage_{$i}_text");
                    $adv_icon_url = is_array($adv_icon) && isset($adv_icon['url']) ? $adv_icon['url'] : ($default_advantage_icons[$i - 1] ?? '');
                    if (!$adv_title && !$adv_icon_url) continue;
                ?>
                <div class="advantages__card">
                    <div class="advantages__card--circle">
                        <?php if ($adv_icon_url) : ?>
                            <img class="advantages__icon" src="<?php echo esc_url($adv_icon_url); ?>" alt="advantages">
                        <?php endif; ?>
                    </div>
                    <div class="context__card">
                        <p class="advantages__card--title"><?php echo esc_html($adv_title); ?></p>
                        <p class="advantages__card--text"><?php echo esc_html($adv_text); ?></p>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section id="collection" class="collection">
        <div class="collection__header">
            <h2 class="collection__title"><?php echo esc_html(get_field('collection_title')); ?></h2>
            <div class="block__logo">
                <?php
                $collection_logo = get_field('collection_logo');
                $collection_logo_url = is_array($collection_logo) && isset($collection_logo['url']) ? $collection_logo['url'] : $template_uri . '/assets/img/logo.svg';
                ?>
                <img src="<?php echo esc_url($collection_logo_url); ?>" alt="BRAVEX">
            </div>
        </div>

        <div class="img-container">
            <?php
            $collection_image = get_field('collection_image');
            $collection_image_url = is_array($collection_image) && isset($collection_image['url']) ? $collection_image['url'] : ($template_uri . '/assets/img/collection.svg');
            ?>
            <?php if ($collection_image_url) : ?>
                <img class="collection__img" src="<?php echo esc_url($collection_image_url); ?>" alt="collection">
            <?php endif; ?>
        </div>

        <div class="block__content collection__content">
            <h3 class="block__mainText collection__mainText"><?php echo esc_html(get_field('collection_name')); ?></h3>
            <div class="block__container">
                <p class="collection__price"><?php echo esc_html(get_field('collection_price')); ?></p>
                <span class="line"></span>
                <p class="container__text collection__text"><?php echo esc_html(get_field('collection_note')); ?></p>
            </div>
        </div>
        <div class="block__content--main">
            <div class="container-btn btn--catalog">
                <?php
                $collection_btn_text = get_field('collection_button_text');
                $collection_btn_link = get_field('collection_button_link');
                ?>
                <?php if ($collection_btn_link) : ?>
                    <a class="btn-text" href="<?php echo esc_url($collection_btn_link); ?>"><?php echo esc_html($collection_btn_text); ?></a>
                <?php else : ?>
                    <button class="btn-text"><?php echo esc_html($collection_btn_text); ?></button>
                <?php endif; ?>
                <img class="btn-img" src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
            </div>
            <div class="block__cards">
                <?php
                $collection_active_index = (int) get_field('collection_meta_active_index');
                if ($collection_active_index <= 0) $collection_active_index = 3;
                ?>
                <?php for ($i = 1; $i <= 3; $i++) :
                    $meta_label = get_field("collection_meta_{$i}_label");
                    $meta_value = get_field("collection_meta_{$i}_value");
                    if (!$meta_label && !$meta_value) continue;
                    $meta_class = ($i === $collection_active_index) ? 'block__card catalog__active' : 'block__card';
                ?>
                <div class="<?php echo esc_attr($meta_class); ?>">
                    <p class="card__description"><?php echo esc_html($meta_label); ?></p>
                    <p class="block__text"><?php echo esc_html($meta_value); ?></p>
                </div>
                <?php endfor; ?>
            </div>
            </div>
    </section>

    <section id="insights" class="insights">
        <div class="block__header">
            <h2 class="block__title">
                <?php echo esc_html(get_field('insights_title_prefix')); ?>
                <p class="block__title--block"><?php echo esc_html(get_field('insights_title_highlight')); ?></p>
            </h2>
            <div class="block__arrows">
                <div class="block__arrow left">
                    <img src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
                </div>
                <div class="block__arrow right block__active">
                    <img src="<?php echo esc_url($template_uri); ?>/assets/img/arrow.svg" alt="arrow">
                </div>
            </div>
        </div>
        <div class="insights__cards-container">
            <div id="insightsCards" class="insights__cards">
                <?php
                $default_insight_images = [
                    $template_uri . '/assets/img/insights/insights0.svg',
                    $template_uri . '/assets/img/insights/insights1.svg',
                    $template_uri . '/assets/img/insights/insights2.svg',
                    $template_uri . '/assets/img/insights/insights3.svg',
                ];
                ?>
                <?php for ($i = 1; $i <= 4; $i++) :
                    $insight_img = get_field("insight_{$i}_image");
                    $insight_title = get_field("insight_{$i}_title");
                    $insight_desc = get_field("insight_{$i}_description");
                    $insight_link = get_field("insight_{$i}_link");
                    $insight_img_url = is_array($insight_img) && isset($insight_img['url']) ? $insight_img['url'] : ($default_insight_images[$i - 1] ?? '');
                    if (!$insight_title && !$insight_img_url) continue;
                ?>
                <div class="insights__card">
                    <?php if ($insight_img_url) : ?>
                        <img class="insights__img" src="<?php echo esc_url($insight_img_url); ?>" alt="<?php echo esc_attr($insight_title); ?>">
                    <?php endif; ?>
                    <div class="insights__content">
                        <span class="insights__title"><?php echo esc_html($insight_title); ?></span>
                        <span class="insights__description"><?php echo esc_html($insight_desc); ?></span>
                    </div>
                    <a class="insights__arrow" href="<?php echo esc_url($insight_link ? $insight_link : '#'); ?>">
                        <img class="insights__arrowImg" src="<?php echo esc_url($template_uri); ?>/assets/img/insights/insightsArrow.svg" alt="arrow">
                    </a>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
