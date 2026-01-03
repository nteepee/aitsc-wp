<?php
/**
 * Template Part: Science of Safety Section
 */
?>

<!-- SCIENCE OF SAFETY SECTION -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-normal text-slate-900 mb-4">The Science of Safety</h2>
            <p class="text-cyan-600 font-medium tracking-widest text-sm uppercase">Why Leading Fleets Trust AITSC</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php
            // Define science cards data
            $science_cards = [
                [
                    'icon' => 'psychology',
                    'icon_aria' => true,
                    'title' => 'Predictive Intelligence',
                    'description' => 'Our AI models don\'t just record incidents—they predict them. By analyzing millions of data points, we identify risks before they become realities.'
                ],
                [
                    'icon' => 'verified_user',
                    'icon_aria' => true,
                    'title' => 'Absolute Compliance',
                    'description' => 'We maintain a 100% NHVAS accreditation record. Our systems are built to meet the strictest regulatory standards in Australia.'
                ],
                [
                    'icon' => 'schedule',
                    'icon_aria' => true,
                    'title' => '24/7 Command',
                    'description' => 'Safety never sleeps. Our command center monitors your fleet around the clock, ensuring rapid response to any anomaly.'
                ]
            ];

            foreach ($science_cards as $card) {
                aitsc_render_card([
                    'variant' => 'glass',
                    'title' => $card['title'],
                    'description' => $card['description'],
                    'icon' => $card['icon'],
                    'size' => 'medium',
                    'custom_class' => 'p-6 rounded-lg group'
                ]);
            }
            ?>
        </div>
    </div>
</section>