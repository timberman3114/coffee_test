<?php 
/**
 * Template: Menu Archive
 * Displays all menu items grouped by category
 */
 get_header(); 

// Hardcoded titles for menu page (different from homepage)
$menu_subtitle = 'Nasze Menu';
$menu_title = 'Pełne Menu';

// Get all menu categories - sorted by custom order field, then by name
$categories = get_terms([
    'taxonomy' => 'menu_category',
    'hide_empty' => true,
]);

// Sort by custom order field
if (!empty($categories) && !is_wp_error($categories)) {
    usort($categories, function($a, $b) {
        $order_a = get_field('category_order', 'menu_category_' . $a->term_id) ?: 99;
        $order_b = get_field('category_order', 'menu_category_' . $b->term_id) ?: 99;
        
        if ($order_a == $order_b) {
            return strcmp($a->name, $b->name);
        }
        return $order_a - $order_b;
    });
}

// Get uncategorized items
$uncategorized_items = new WP_Query([
    'post_type' => 'menu_item',
    'posts_per_page' => -1,
    'tax_query' => [
        [
            'taxonomy' => 'menu_category',
            'operator' => 'NOT EXISTS',
        ],
    ],
]);
?>

<!-- Hero Section -->
<section class="pt-48 pb-16 bg-primary">
    <div class="container mx-auto px-6 text-center">
        <span class="text-gold uppercase tracking-[0.3em] text-sm mb-4 block"><?php echo esc_html($menu_subtitle); ?></span>
        <h1 class="text-4xl md:text-6xl font-serif font-bold text-light mb-6"><?php echo esc_html($menu_title); ?></h1>
        <p class="text-gray-300 max-w-2xl mx-auto">
            Wszystkie nasze kawy przygotowujemy z ziaren specialty, palonych lokalnie z dbałością o każdy szczegół.
        </p>
    </div>
</section>

<!-- Menu Content -->
<section class="py-16 bg-dark">
    <div class="container mx-auto px-6">
        
        <?php if (!empty($categories) && !is_wp_error($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <?php
                $category_items = new WP_Query([
                    'post_type' => 'menu_item',
                    'posts_per_page' => -1,
                    'tax_query' => [
                        [
                            'taxonomy' => 'menu_category',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        ],
                    ],
                ]);
                
                if ($category_items->have_posts()):
                ?>
                    <!-- Category: <?php echo esc_html($category->name); ?> -->
                    <div class="mb-16 scroll-animate">
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-2xl md:text-3xl font-serif font-bold text-gold whitespace-nowrap">
                                <?php echo esc_html($category->name); ?>
                            </h2>
                            <div class="h-px bg-gold/30 flex-1"></div>
                        </div>
                        
                        <?php if ($category->description): ?>
                            <p class="text-gray-400 mb-6"><?php echo esc_html($category->description); ?></p>
                        <?php endif; ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while ($category_items->have_posts()): $category_items->the_post(); ?>
                                <?php 
                                $price = get_field('price');
                                $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'menu-thumb');
                                ?>
                                <div class="flex gap-4 p-4 rounded-xl bg-primary/50 hover:bg-primary transition-colors duration-300 group">
                                    <?php if ($thumbnail): ?>
                                        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="<?php echo esc_url($thumbnail); ?>" 
                                                 alt="<?php echo esc_attr(get_the_title()); ?>" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-gold/20 to-brown/20 flex-shrink-0"></div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-2">
                                            <h3 class="text-lg font-semibold text-light"><?php the_title(); ?></h3>
                                            <?php if ($price): ?>
                                                <span class="text-gold font-bold whitespace-nowrap"><?php echo esc_html($price); ?> zł</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (get_the_excerpt()): ?>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                        <?php elseif (get_the_content()): ?>
                                            <p class="text-gray-400 text-sm mt-1"><?php echo wp_trim_words(get_the_content(), 15); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <?php 
        // Show uncategorized items if any
        if ($uncategorized_items->have_posts()): 
        ?>
            <div class="mb-16 scroll-animate">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-2xl md:text-3xl font-serif font-bold text-gold whitespace-nowrap">
                        Inne
                    </h2>
                    <div class="h-px bg-gold/30 flex-1"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php while ($uncategorized_items->have_posts()): $uncategorized_items->the_post(); ?>
                        <?php 
                        $price = get_field('price');
                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'menu-thumb');
                        ?>
                        <div class="flex gap-4 p-4 rounded-xl bg-primary/50 hover:bg-primary transition-colors duration-300 group">
                            <?php if ($thumbnail): ?>
                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="<?php echo esc_url($thumbnail); ?>" 
                                         alt="<?php echo esc_attr(get_the_title()); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </div>
                            <?php else: ?>
                                <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-gold/20 to-brown/20 flex-shrink-0"></div>
                            <?php endif; ?>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <h3 class="text-lg font-semibold text-light"><?php the_title(); ?></h3>
                                    <?php if ($price): ?>
                                        <span class="text-gold font-bold whitespace-nowrap"><?php echo esc_html($price); ?> zł</span>
                                    <?php endif; ?>
                                </div>
                                <?php if (get_the_excerpt()): ?>
                                    <p class="text-gray-400 text-sm mt-1"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                <?php elseif (get_the_content()): ?>
                                    <p class="text-gray-400 text-sm mt-1"><?php echo wp_trim_words(get_the_content(), 15); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php 
        // Fallback if no items at all
        if (empty($categories) && !$uncategorized_items->have_posts()): 
        ?>
            <div class="text-center py-16">
                <p class="text-gray-400 text-lg">Menu jest w przygotowaniu. Zapraszamy wkrótce!</p>
                <a href="<?php echo home_url(); ?>" class="btn-primary mt-6 inline-block">Wróć na stronę główną</a>
            </div>
        <?php endif; ?>
        
        <!-- Back to home -->
        <div class="text-center mt-8 scroll-animate">
            <a href="<?php echo home_url(); ?>#menu" class="btn-secondary">← Wróć do strony głównej</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
