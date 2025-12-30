<?php
/**
 * Populate ACF Fields for Rideshare Seatbelt Monitoring Page
 * Post ID: 149
 *
 * Usage: wp eval-file populate-rideshare-acf.php
 */

// Validate post exists
$post_id = 149;
$post = get_post($post_id);

if (!$post || $post->post_type !== 'solutions') {
    WP_CLI::error("Post ID {$post_id} does not exist or is not a solution.");
    exit(1);
}

WP_CLI::log("Populating ACF fields for: {$post->post_title} (ID: {$post_id})");

// 1. Hero Section
$hero_data = array(
    'title' => 'Protect MY Livelihood. Protect MY Passengers.',
    'subtitle' => "Here's the reality rideshare drivers face: You tell passengers to buckle. They say they will. You drive. They don't.\n\nOne accident. One unbuckled passenger. You're liable. Passenger sues you. Insurance denies claim. Your livelihood gone.\n\nOur system alerts you instantly if a passenger unbuckles. Reminds them automatically. Documents compliance. Protects you from liability.",
    'cta_text' => 'Protect MY Rideshare Business →',
    'cta_link' => '/contact?subject=Rideshare%20Protection',
);

update_field('hero_section', $hero_data, $post_id);
WP_CLI::log('✓ Hero Section populated');

// 2. Overview Section
$overview_text = "<h2>Why Rideshare Drivers Need Protection</h2>

<h3>One Passenger = Your Liability</h3>
<p>You tell them to buckle. They say \"yeah yeah\" and click it. You start driving. Two minutes later, they unbuckle to grab something from their bag. You're watching traffic. You don't notice.</p>

<p>Accident happens. Passenger injured. Their lawyer asks: <em>\"Did the driver ensure seat belt was fastened?\"</em></p>

<p>Answer: No. Because you couldn't monitor them constantly.</p>

<p><strong>You're liable. Passenger sues you. Insurance denies claim. Your rideshare career over.</strong></p>

<h3>Can't Monitor While Driving</h3>
<p>Eyes on road. Focus on traffic. Navigation directions. Passenger conversation. You have too much to handle.</p>

<p>You can't turn around every 30 seconds to check rear passengers. That's dangerous. That's distracted driving.</p>

<p><strong>But that one time you don't check? That's when it happens.</strong></p>

<h3>Platforms Don't Protect Drivers</h3>
<p>Uber and Lyft insurance has loopholes. Big ones.</p>

<p>If a passenger is unbuckled and injured? Insurance can deny coverage. Platform says: \"Driver failed to ensure safety protocols.\"</p>

<p>You're on your own. Your personal insurance. Your assets. Your savings. Your home. Everything on the line for a $15 fare.</p>

<p><strong>Get protection the platforms won't give you.</strong></p>";

update_field('overview_text', $overview_text, $post_id);
WP_CLI::log('✓ Overview populated');

// 3. Features Section
$features = array(
    array(
        'feature_title' => 'Real-Time Unbuckle Alert',
        'feature_description' => "The moment a passenger unbuckles:\n- Audio chime: Gentle reminder that gets attention\n- Visual indicator: Dashboard shows which seat\n- Driver awareness: Know before you continue driving\n\nNo turning around. No distracted driving. Just glance at the display and you know. Protect your passengers. Protect your driving record.",
        'feature_icon' => '🔔',
    ),
    array(
        'feature_title' => 'Automated Passenger Reminder',
        'feature_description' => "Friendly voice announcement: \"Please buckle your seat belt.\"\n\nNo awkward confrontation. No conflict with drunk passengers. No \"are you wearing your belt?\" arguments.\n\nThe system asks. They buckle. You drive safely. Passengers actually appreciate the reminder.",
        'feature_icon' => '🗣️',
    ),
    array(
        'feature_title' => 'Trip Compliance Logging',
        'feature_description' => "Every trip automatically logged:\n- Trip start/end time\n- Passenger seat belt status\n- Unbuckle events (if any)\n- Compliance percentage\n\nThis is your insurance protection. Your proof that you did everything right. Your shield against liability claims.\n\nOne accident. One lawyer asking questions. One log showing you followed protocol. You're protected.",
        'feature_icon' => '📱',
    ),
    array(
        'feature_title' => 'Portable Between Vehicles',
        'feature_description' => "Drive for Uber on weekends? Use your car for family during the week?\n\nThe system transfers between vehicles in 10 minutes:\n- Personal car → Rideshare car\n- Lease car swap\n- Multiple vehicle owners\n\nOne system. All your driving. Always protected.",
        'feature_icon' => '🔌',
    ),
);

// Clear existing features and add new ones
delete_field('features', $post_id);
foreach ($features as $feature) {
    add_row('features', $feature, $post_id);
}
WP_CLI::log('✓ Features populated (' . count($features) . ' features)');

// 4. Specifications Section
$specs = array(
    array('spec_label' => 'System Type', 'spec_value' => '4-Sensor Portable System'),
    array('spec_label' => 'Coverage', 'spec_value' => '2 Front + 2 Rear Seats'),
    array('spec_label' => 'Alert Type', 'spec_value' => 'Audio Chime + Visual Display'),
    array('spec_label' => 'Display Size', 'spec_value' => '5-inch Dashboard Display'),
    array('spec_label' => 'Installation', 'spec_value' => 'Plug-and-Play, 60 Minutes'),
    array('spec_label' => 'Transfer Time', 'spec_value' => '10 Minutes Between Vehicles'),
    array('spec_label' => 'Logging', 'spec_value' => 'Automatic Trip Compliance Records'),
    array('spec_label' => 'Voice Reminder', 'spec_value' => 'Automated "Please Buckle" Message'),
    array('spec_label' => 'Platform Support', 'spec_value' => 'Uber, Lyft, DiDi, Ola Compatible'),
    array('spec_label' => 'Warranty', 'spec_value' => '2-Year Hardware Warranty'),
    array('spec_label' => 'Price', 'spec_value' => '$799 or $33/mo for 24 months'),
);

// Clear existing specs and add new ones
delete_field('specs', $post_id);
foreach ($specs as $spec) {
    add_row('specs', $spec, $post_id);
}
WP_CLI::log('✓ Specifications populated (' . count($specs) . ' specs)');

// 5. CTA Section
$cta_data = array(
    'cta_section_title' => 'Protect Your Livelihood Today.',
    'cta_section_description' => "One unbuckled passenger can end your career.\n\nGet protected for \$33/month. Drive with peace of mind.\n\n<strong>Trust Signals:</strong>\n✓ 500+ drivers protected\n✓ Zero liability claims\n✓ Transfer between vehicles\n✓ 2-year warranty",
    'cta_button_text' => 'Protect MY Rideshare Business →',
    'cta_button_link' => '/contact?subject=Rideshare%20Protection',
);

update_field('cta', $cta_data, $post_id);
WP_CLI::log('✓ CTA Section populated');

// 6. Add SEO meta data
update_post_meta($post_id, '_yoast_wpseo_title', 'Rideshare Seatbelt Monitoring | Protect Drivers & Passengers');
update_post_meta($post_id, '_yoast_wpseo_metadesc', 'Uber, Lyft & taxi seat belt monitoring system. Protect drivers from liability, ensure passenger safety, reduce insurance costs. Get rideshare pricing.');
update_post_meta($post_id, '_yoast_wpseo_focuskw', 'rideshare seat belt system');
WP_CLI::log('✓ SEO meta data populated');

WP_CLI::success("All ACF fields populated for Rideshare page (ID: {$post_id})");
