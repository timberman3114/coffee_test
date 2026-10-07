<?php
// Get Front Page ID for ACF fields
$front_page_id = get_option('page_on_front');

// Footer fields from ACF
$footer_description = get_field('footer_description', $front_page_id) ?: 'Specialty coffee w sercu miasta. Pasja do kawy, dbałość o każdy szczegół.';
$opening_hours_weekdays = get_field('opening_hours_weekdays', $front_page_id) ?: '7:00 - 20:00';
$opening_hours_saturday = get_field('opening_hours_saturday', $front_page_id) ?: '8:00 - 18:00';
$opening_hours_sunday = get_field('opening_hours_sunday', $front_page_id) ?: '9:00 - 16:00';
$contact_address = get_field('contact_address', $front_page_id) ?: 'ul. Kawowa 15, Poznań';
$contact_phone = get_field('contact_phone', $front_page_id) ?: '+48 123 456 789';
$contact_email = get_field('contact_email', $front_page_id) ?: 'hello@blackbrew.pl';
$social_facebook = get_field('social_facebook', $front_page_id);
$social_instagram = get_field('social_instagram', $front_page_id);
$footer_copyright = get_field('footer_copyright', $front_page_id) ?: 'Black Brew Coffee. Wszelkie prawa zastrzeżone.';
?>

<footer class="bg-dark border-t border-gold/20 py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & opis -->
            <div>
                <?php if (has_custom_logo()): ?>
                    <?php 
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if ($logo): ?>
                        <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="h-8 w-auto mb-4">
                    <?php endif; ?>
                <?php else: ?>
                    <h3 class="text-2xl font-bold text-gold font-serif mb-4"><?php bloginfo('name'); ?></h3>
                <?php endif; ?>
                <p class="text-gray-400 text-sm">
                    <?php echo esc_html($footer_description); ?>
                </p>
                
                <?php if ($social_facebook || $social_instagram): ?>
                    <div class="flex gap-4 mt-4">
                        <?php if ($social_facebook): ?>
                            <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-gold transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        <?php endif; ?>
                        <?php if ($social_instagram): ?>
                            <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener" class="text-gray-400 hover:text-gold transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Godziny otwarcia -->
            <div>
                <h4 class="text-lg font-semibold text-light mb-4">Godziny otwarcia</h4>
                <ul class="text-gray-400 text-sm space-y-2">
                    <li>Pon - Pt: <?php echo esc_html($opening_hours_weekdays); ?></li>
                    <li>Sobota: <?php echo esc_html($opening_hours_saturday); ?></li>
                    <li>Niedziela: <?php echo esc_html($opening_hours_sunday); ?></li>
                </ul>
            </div>
            
            <!-- Kontakt -->
            <div>
                <h4 class="text-lg font-semibold text-light mb-4">Kontakt</h4>
                <ul class="text-gray-400 text-sm space-y-2">
                    <li><?php echo esc_html($contact_address); ?></li>
                    <li><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>" class="hover:text-gold transition-colors"><?php echo esc_html($contact_phone); ?></a></li>
                    <li><a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hover:text-gold transition-colors"><?php echo esc_html($contact_email); ?></a></li>
                </ul>
            </div>
            
        </div>
        
        <div class="border-t border-gold/20 mt-8 pt-8 text-center text-gray-500 text-sm">
            <p><a href="https://www.dominikdober.pl">&copy; <?php echo date('Y'); ?> DOMINIK DOBER.</a> Wszelkie prawa zastrzeżone</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
