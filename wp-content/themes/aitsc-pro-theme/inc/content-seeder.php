<?php
/**
 * Content Seeder for AITSC
 * Run once to populate pages and CPTs.
 */

function aitsc_seed_content()
{
    // Flag to prevent double seeding
    if (get_option('aitsc_content_seeded_v3'))
        return;

    // 1. Create "Fleet Safe Pro" Solution
    $fleet_safe_content = '
    <!-- Overview -->
    <p><strong>Fleet Safe Pro</strong> is the ultimate eco-system for heavy vehicle safety, designed to eliminate blind spots and prevent accidents before they happen. Integrating quad-radar arrays with AI vision processing, this system provides a complete 360° shield around your vehicle.</p>
    <p>By distinguishing between static objects and Vulnerable Road Users (VRUs) in real-time, Fleet Safe Pro reduces false alarms while ensuring immediate intervention when it matters most.</p>

    <!-- Detailed Sections handled by Meta Fields in template, but adding core description here -->
    ';

    $post_id = wp_insert_post(array(
        'post_title' => 'Fleet Safe Pro',
        'post_content' => $fleet_safe_content,
        'post_status' => 'publish',
        'post_type' => 'solutions',
        'post_excerpt' => 'The ultimate eco-system for heavy vehicle safety. Features 360° oversight, Active Braking, and AI-powered VRU protection.',
    ));

    if ($post_id) {
        // Meta Fields matching single-solutions.php
        update_post_meta($post_id, '_solution_industry_focus', array('transportation', 'safety'));
        update_post_meta($post_id, '_solution_complexity', 'enterprise');
        update_post_meta($post_id, '_solution_technologies', '77GHz Radar, LiDAR, AI Vision, CAN Bus J1939');
        update_post_meta($post_id, '_solution_certification', 'ISO 13849, UN R151');

        $features = "360° Oversight: Eliminate blind spots with quad-radar array.\nVRU Protection: Distinguishes pedestrians from static objects.\nActive Braking: Autonomous intervention prevents collisions.\nAnti-Rollaway: Fail-safe braking protocols.";
        update_post_meta($post_id, '_solution_key_features', $features);

        $outcomes = "Reduced Accident Rate by up to 90%.\nFull Compliance with CoR mandates.\nLower Insurance Premiums via proven risk mitigation.";
        update_post_meta($post_id, '_solution_outcomes', $outcomes);

        // Assign Category
        wp_set_object_terms($post_id, 'Passenger Monitoring', 'solution_category');
    }

    // 2. Create "About Us" Page
    $about_content = '
    <p><strong>We combine deep engineering roots with practical transport safety mandates.</strong> We don\'t just consult; we build the systems that keep Australian roads safe.</p>
    
    <h3>Our Expertise</h3>
    <p>From embedded firmware to AI-powered fleet protection, we deliver end-to-end transport safety solutions. Our team consists of elite engineers, compliance experts, and software architects dedicated to solving deep infrastructure problems.</p>

    <h3>Why Us?</h3>
    <ul>
        <li><strong>Independent:</strong> Unbiased testing and certification.</li>
        <li><strong>Technical Deep-Dive:</strong> We analyze the code, the hardware, and the data.</li>
        <li><strong>Outcome Focused:</strong> Solving the "Most Expensive Problems" first.</li>
    </ul>
    ';

    $about_id = wp_insert_post(array(
        'post_title' => 'We Are AITSC',
        'post_content' => $about_content,
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'about',
    ));

    // 3. Create "Contact" Page
    $contact_content = '
    <p>Let\'s solve your safety challenge. Discuss your project with our engineering team.</p>
    <p><strong>Phone:</strong> 1300 AITSC (1300 000 000)<br>
    <strong>Email:</strong> info@aitsc.au</p>
    ';

    $contact_id = wp_insert_post(array(
        'post_title' => 'Contact Us',
        'post_content' => $contact_content,
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'contact',
    ));

    // 4. Create a Sample Case Study: "Metro Transit Authority"
    $cs_content = '
    <p>Metro Transit Authority faced significant challenges with passenger safety monitoring across their large urban bus fleet.</p>
    <p>Traditional monitoring systems failed to provide comprehensive coverage of passenger incidents, delayed emergency response times, and lacked actionable data for proactive safety management.</p>
    ';

    $cs_id = wp_insert_post(array(
        'post_title' => 'Metro Transit Authority Success Story',
        'post_content' => $cs_content,
        'post_status' => 'publish',
        'post_type' => 'case_studies',
        'post_excerpt' => 'How Metro Transit Authority achieved 95% seat belt compliance with AITSC solutions.',
    ));

    if ($cs_id) {
        update_post_meta($cs_id, '_case_study_client', 'Metro Transit Authority');
        update_post_meta($cs_id, '_case_study_client_industry', 'Public Transport');
        update_post_meta($cs_id, '_case_study_challenge', 'Existing systems provided limited visibility into student behavior and lacked emergency response capabilities.');
        update_post_meta($cs_id, '_case_study_results', 'Deployed Fleet Safe Pro district-wide. Achieved 95% compliance and reduced incidents by 40%.');
        update_post_meta($cs_id, '_case_study_metrics', "Compliance: 95%\nIncident Reduction: 40%\nFleet Size: 200+ Buses");
    }

    // Mark as seeded
    update_option('aitsc_content_seeded_v3', true);
}
add_action('init', 'aitsc_seed_content');
