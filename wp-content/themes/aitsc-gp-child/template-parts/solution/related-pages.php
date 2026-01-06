<?php
/**
 * Related Pages Navigation Component
 *
 * Displays cross-page navigation based on solution ID and relationships.
 * Provides contextual links to related solution pages.
 *
 * @package AITSC_Pro_Theme
 * @since 3.1.0
 */

$solution_id = get_the_ID();

// Define page relationships based on solution ID
$page_links = array();

// Primary product page (144) links to all pages
if ($solution_id == 144) {
    $page_links = array(
        146 => 'Seatbelt Alert for Buses',
        147 => 'Fleet Compliance',
        149 => 'Rideshare Monitoring',
        145 => 'Installation Guide',
        148 => 'Buckle Sensor',
        150 => 'Seat Sensor',
        151 => 'Display Unit'
    );
}
// Use case pages (146, 147, 149) link to primary + siblings + install
elseif (in_array($solution_id, array(146, 147, 149))) {
    $page_links = array(
        144 => 'Complete System',
        145 => 'Installation Guide',
        146 => 'Seatbelt for Buses',
        147 => 'Fleet Compliance',
        149 => 'Rideshare Monitoring'
    );
    // Remove current page from links
    unset($page_links[$solution_id]);
}
// Installation (145) links to primary + all components
elseif ($solution_id == 145) {
    $page_links = array(
        144 => 'Complete System',
        148 => 'Buckle Sensor',
        150 => 'Seat Sensor',
        151 => 'Display Unit'
    );
}
// Component pages (148, 150, 151) link to primary + install + siblings
elseif (in_array($solution_id, array(148, 150, 151))) {
    $page_links = array(
        144 => 'Buy as Complete System',
        145 => 'Installation Guide',
        148 => 'Buckle Sensor',
        150 => 'Seat Sensor',
        151 => 'Display Unit'
    );
    // Remove current page from links
    unset($page_links[$solution_id]);
}

// Output related pages section if links exist
if (!empty($page_links)) :
?>
    <section class="related-pages py-16 md:py-20 bg-gradient-to-b from-slate-900 to-slate-800">
        <div class="container max-w-7xl mx-auto px-6">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-8 text-center">Explore Related Solutions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php
                foreach ($page_links as $link_id => $link_title) :
                    $link_url = get_permalink($link_id);
                    $current_class = ($link_id == $solution_id) ? 'opacity-50 cursor-not-allowed' : '';
                    if ($link_url && $link_id != $solution_id) :
                ?>
                    <a href="<?php echo esc_url($link_url); ?>"
                       class="related-page-link group relative bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-amber-500/50 rounded-lg p-4 transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/10 <?php echo esc_attr($current_class); ?>">
                        <div class="flex items-center justify-between">
                            <span class="text-white font-medium group-hover:text-amber-400 transition-colors">
                                <?php echo esc_html($link_title); ?>
                            </span>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>
