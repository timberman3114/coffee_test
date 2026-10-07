<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.svg">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-primary text-light font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<header class="fixed top-0 left-0 right-0 z-50 bg-primary/95 backdrop-blur-sm border-b border-gold/20">
    <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
        <?php if (has_custom_logo()): ?>
            <a href="<?php echo home_url(); ?>" class="flex items-center">
                <?php 
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if ($logo): ?>
                    <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="h-10 w-auto">
                <?php endif; ?>
            </a>
        <?php else: ?>
            <a href="<?php echo home_url(); ?>" class="text-2xl font-bold text-gold font-serif">
                <?php bloginfo('name'); ?>
            </a>
        <?php endif; ?>
        
        <?php
        // Ukryj navbar-content na podstronie /menu
        $is_menu_page = (isset($_SERVER['REQUEST_URI']) && preg_match('#^/menu/?$#', $_SERVER['REQUEST_URI']));
        ?>

        <button class="navbar-burger flex flex-col items-center justify-center w-10 h-10 rounded-lg border border-gold/30 hover:border-gold transition-colors duration-300 lg:hidden" aria-label="Menu" aria-expanded="false"<?php if ($is_menu_page) echo ' style="display:none"'; ?>>
            <span class="burger-line w-6 h-0.5 bg-light mb-1.5"></span>
            <span class="burger-line w-6 h-0.5 bg-light mb-1.5"></span>
            <span class="burger-line w-6 h-0.5 bg-light"></span>
        </button>
        
        <div class="navbar-content hidden lg:flex items-center gap-8"<?php if ($is_menu_page) echo ' style="display:none"'; ?>>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'fallback_cb' => function() {
                    // Default menu if none set
                    echo '<a href="#home" class="nav-link text-light hover:text-gold transition-colors duration-300">Home</a>';
                    echo '<a href="#menu" class="nav-link text-light hover:text-gold transition-colors duration-300">Menu</a>';
                    echo '<a href="#about" class="nav-link text-light hover:text-gold transition-colors duration-300">O nas</a>';
                    echo '<a href="#gallery" class="nav-link text-light hover:text-gold transition-colors duration-300">Galeria</a>';
                    echo '<a href="#contact" class="nav-link text-light hover:text-gold transition-colors duration-300">Kontakt</a>';
                },
                'walker' => new class extends Walker_Nav_Menu {
                    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                        $output .= '<a href="' . esc_url($item->url) . '" class="nav-link text-light hover:text-gold transition-colors duration-300">' . esc_html($item->title) . '</a>';
                    }
                    public function end_el(&$output, $item, $depth = 0, $args = null) {}
                    public function start_lvl(&$output, $depth = 0, $args = null) {}
                    public function end_lvl(&$output, $depth = 0, $args = null) {}
                }
            ]);
            ?>
        </div>
    </nav>
    
    <!-- Mobile menu -->
    <div class="navbar-mobile hidden lg:hidden bg-primary border-t border-gold/20">
        <div class="container mx-auto px-6 py-4 flex flex-col gap-4">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'fallback_cb' => function() {
                    echo '<a href="#home" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">Home</a>';
                    echo '<a href="#menu" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">Menu</a>';
                    echo '<a href="#about" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">O nas</a>';
                    echo '<a href="#gallery" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">Galeria</a>';
                    echo '<a href="#contact" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">Kontakt</a>';
                },
                'walker' => new class extends Walker_Nav_Menu {
                    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                        $output .= '<a href="' . esc_url($item->url) . '" class="nav-link text-light hover:text-gold transition-colors duration-300 py-2">' . esc_html($item->title) . '</a>';
                    }
                    public function end_el(&$output, $item, $depth = 0, $args = null) {}
                    public function start_lvl(&$output, $depth = 0, $args = null) {}
                    public function end_lvl(&$output, $depth = 0, $args = null) {}
                }
            ]);
            ?>
        </div>
    </div>
</header>
