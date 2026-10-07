<?php get_header(); ?>

<?php
// Get Front Page ID for ACF fields
$front_page_id = get_option('page_on_front');

// Get ACF fields with fallbacks
$hero_subtitle = get_field('hero_subtitle', $front_page_id) ?: 'Specialty Coffee';
$hero_title = get_field('hero_title', $front_page_id) ?: 'Black Brew';
$hero_description = get_field('hero_description', $front_page_id) ?: 'Gdzie każda filiżanka opowiada historię. Kawa specialty palone lokalnie, serwowana z pasją.';
$hero_button1_text = get_field('hero_button1_text', $front_page_id) ?: 'Zobacz Menu';
$hero_button1_link = get_field('hero_button1_link', $front_page_id) ?: '#menu';
$hero_button2_text = get_field('hero_button2_text', $front_page_id) ?: 'Odwiedź nas';
$hero_button2_link = get_field('hero_button2_link', $front_page_id) ?: '#contact';
$hero_background = get_field('hero_background', $front_page_id);
?>

<!-- Hero Section -->
<section id="home" class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary via-primary/95 to-dark"></div>
    <?php if ($hero_background): ?>
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('<?php echo esc_url($hero_background); ?>');"></div>
    <?php else: ?>
        <div class="absolute inset-0 bg-[url('assets/images/hero-bg.jpg')] bg-cover bg-center opacity-20"></div>
    <?php endif; ?>
    
    <div class="container mx-auto px-6 text-center relative z-10">
        <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block animate-fade-up"><?php echo esc_html($hero_subtitle); ?></span>
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-serif font-bold text-light mb-6 animate-fade-up">
            <?php echo esc_html($hero_title); ?>
        </h1>
        <p class="text-xl md:text-2xl text-gray-300 max-w-2xl mx-auto mb-8 animate-fade-up">
            <?php echo esc_html($hero_description); ?>
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-up">
            <a href="<?php echo esc_url($hero_button1_link); ?>" class="btn-primary"><?php echo esc_html($hero_button1_text); ?></a>
            <a href="<?php echo esc_url($hero_button2_link); ?>" class="btn-secondary"><?php echo esc_html($hero_button2_text); ?></a>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<?php
// Menu section options
$menu_subtitle = get_field('menu_subtitle', $front_page_id) ?: 'Nasze Menu';
$menu_title = get_field('menu_title', $front_page_id) ?: 'Wybrane Smaki';
$menu_button_text = get_field('menu_button_text', $front_page_id) ?: 'Pełne Menu';
$menu_items_count = get_field('menu_items_count', $front_page_id) ?: 6;

// Query menu items
$menu_items = new WP_Query([
    'post_type' => 'menu_item',
    'posts_per_page' => $menu_items_count,
    'meta_query' => [
        [
            'key' => 'featured',
            'value' => '1',
            'compare' => '='
        ]
    ]
]);

// Fallback - if no featured items, get any menu items
if (!$menu_items->have_posts()) {
    $menu_items = new WP_Query([
        'post_type' => 'menu_item',
        'posts_per_page' => $menu_items_count,
    ]);
}
?>

<!-- Menu Highlights Section -->
<section id="menu" class="py-24 bg-dark">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 scroll-animate">
            <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block"><?php echo esc_html($menu_subtitle); ?></span>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-light"><?php echo esc_html($menu_title); ?></h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 scroll-animate">
            <?php if ($menu_items->have_posts()): ?>
                <?php while ($menu_items->have_posts()): $menu_items->the_post(); ?>
                    <?php 
                    $price = get_field('price');
                    $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'menu-thumb');
                    ?>
                    <div class="menu-card group">
                        <div class="aspect-square overflow-hidden rounded-xl mb-4">
                            <?php if ($thumbnail): ?>
                                <img src="<?php echo esc_url($thumbnail); ?>" 
                                     alt="<?php echo esc_attr(get_the_title()); ?>" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-gold/20 to-brown/20 group-hover:scale-105 transition-transform duration-500"></div>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-semibold text-light mb-2"><?php the_title(); ?></h3>
                        <?php if (get_the_excerpt()): ?>
                            <p class="text-gray-400 text-sm mb-3"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                        <?php elseif (get_the_content()): ?>
                            <p class="text-gray-400 text-sm mb-3"><?php echo wp_trim_words(get_the_content(), 10); ?></p>
                        <?php endif; ?>
                        <?php if ($price): ?>
                            <span class="text-gold font-semibold"><?php echo esc_html($price); ?> zł</span>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <!-- Fallback if no menu items exist yet -->
                <div class="col-span-full text-center text-gray-400">
                    <p>Dodaj pozycje menu w panelu WordPress → Menu Kawiarni</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-12 scroll-animate">
            <a href="<?php echo get_post_type_archive_link('menu_item'); ?>" class="btn-primary"><?php echo esc_html($menu_button_text); ?></a>
        </div>
    </div>
</section>

<?php
// About section
$about_subtitle = get_field('about_subtitle', $front_page_id) ?: 'Nasza Historia';
$about_title = get_field('about_title', $front_page_id) ?: 'Pasja do kawy od 2018 roku';
$about_content = get_field('about_content', $front_page_id);
$about_button_text = get_field('about_button_text', $front_page_id) ?: 'Poznaj nas';
$about_button_link = get_field('about_button_link', $front_page_id) ?: '#contact';
$about_image = get_field('about_image', $front_page_id);
$about_years = get_field('about_years', $front_page_id) ?: '6';
$about_years_label = get_field('about_years_label', $front_page_id) ?: 'lat doświadczenia';

// Default content if not set
if (!$about_content) {
    $about_content = '<p>Black Brew to miejsce stworzone przez miłośników kawy dla miłośników kawy. Wszystko zaczęło się od małej palarni i marzenia o serwowaniu najlepszej kawy w mieście.</p><p>Dziś współpracujemy z najlepszymi plantatorami z Etiopii, Kolumbii i Brazylii. Każde ziarno jest starannie wyselekcjonowane i palone na miejscu, by zagwarantować świeżość i niepowtarzalny smak.</p>';
}
?>

<!-- About Section -->
<section id="about" class="py-24 bg-primary">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="scroll-animate">
                <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block"><?php echo esc_html($about_subtitle); ?></span>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-light mb-6">
                    <?php echo esc_html($about_title); ?>
                </h2>
                <div class="text-gray-300 mb-8 space-y-4 [&>p]:mb-4">
                    <?php echo wp_kses_post($about_content); ?>
                </div>
                <a href="<?php echo esc_url($about_button_link); ?>" class="btn-secondary"><?php echo esc_html($about_button_text); ?></a>
            </div>
            <div class="relative scroll-animate">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden bg-gradient-to-br from-gold/10 to-brown/10">
                    <?php if ($about_image): ?>
                        <img src="<?php echo esc_url($about_image['url']); ?>" 
                             alt="<?php echo esc_attr($about_image['alt'] ?: 'O nas'); ?>" 
                             class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-gold text-dark p-6 rounded-xl">
                    <span class="text-4xl font-bold"><?php echo esc_html($about_years); ?>+</span>
                    <p class="text-sm"><?php echo esc_html($about_years_label); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Gallery section
$gallery_subtitle = get_field('gallery_subtitle', $front_page_id) ?: 'Galeria';
$gallery_title = get_field('gallery_title', $front_page_id) ?: 'Wnętrze & Klimat';

// Query gallery items
$gallery_items = new WP_Query([
    'post_type' => 'gallery_item',
    'posts_per_page' => 8,
]);
?>

<!-- Gallery Section -->
<section id="gallery" class="py-24 bg-dark">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16 scroll-animate">
            <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block"><?php echo esc_html($gallery_subtitle); ?></span>
            <h2 class="text-4xl md:text-5xl font-serif font-bold text-light"><?php echo esc_html($gallery_title); ?></h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 scroll-animate">
            <?php if ($gallery_items->have_posts()): ?>
                <?php while ($gallery_items->have_posts()): $gallery_items->the_post(); ?>
                    <?php $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'gallery-thumb'); ?>
                    <?php if ($thumbnail): ?>
                        <div class="aspect-square rounded-xl overflow-hidden hover:scale-105 transition-transform duration-300 cursor-pointer">
                            <img src="<?php echo esc_url($thumbnail); ?>" 
                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                 class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <!-- Fallback placeholders -->
                <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-gold/10 to-brown/10 hover:scale-105 transition-transform duration-300 cursor-pointer"></div>
                <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-gold/10 to-brown/10 hover:scale-105 transition-transform duration-300 cursor-pointer"></div>
                <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-gold/10 to-brown/10 hover:scale-105 transition-transform duration-300 cursor-pointer"></div>
                <div class="aspect-square rounded-xl overflow-hidden bg-gradient-to-br from-gold/10 to-brown/10 hover:scale-105 transition-transform duration-300 cursor-pointer"></div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Contact section
$contact_subtitle = get_field('contact_subtitle', $front_page_id) ?: 'Kontakt';
$contact_title = get_field('contact_title', $front_page_id) ?: 'Odwiedź nas';
$contact_description = get_field('contact_description', $front_page_id) ?: 'Zapraszamy do naszej kawiarni w centrum Poznania. Chętnie przygotujemy dla Ciebie idealną kawę.';
$contact_address = get_field('contact_address', $front_page_id) ?: 'ul. Kawowa 15, 61-123 Poznań';
$contact_phone = get_field('contact_phone', $front_page_id) ?: '+48 123 456 789';
$contact_email = get_field('contact_email', $front_page_id) ?: 'hello@blackbrew.pl';
$contact_map_embed = get_field('contact_map_embed', $front_page_id);
?>

<!-- Contact Section -->
<section id="contact" class="py-24 bg-primary">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="scroll-animate">
                <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block"><?php echo esc_html($contact_subtitle); ?>
                <h2 class="text-4xl md:text-5xl font-serif font-bold text-light mb-6"><?php echo esc_html($contact_title); ?></h2>
                <p class="text-gray-300 mb-8">
                    <?php echo esc_html($contact_description); ?>
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="min-w-12 min-h-12 rounded-full bg-gold/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-light font-semibold">Adres</h4>
                            <p class="text-gray-400"><?php echo esc_html($contact_address); ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="min-w-12 min-h-12 rounded-full bg-gold/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-light font-semibold">Telefon</h4>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>" class="text-gray-400 hover:text-gold transition-colors"><?php echo esc_html($contact_phone); ?></a>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="min-w-12 min-h-12 rounded-full bg-gold/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-light font-semibold">Email</h4>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="text-gray-400 break-all hover:text-gold transition-colors"><?php echo esc_html($contact_email); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="rounded-2xl overflow-hidden h-[400px] bg-gradient-to-br from-gold/10 to-brown/10 scroll-animate">
                <?php if ($contact_map_embed): ?>
                    <iframe 
                        src="<?php echo esc_url($contact_map_embed); ?>" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
