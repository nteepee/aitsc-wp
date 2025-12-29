<?php
/**
 * Advanced Contact Form Template Part
 * 
 * Clean Single-Step Version (WorldQuant Aesthetic)
 */

if (!defined('ABSPATH')) {
    exit;
}

$form_title = get_theme_mod('aitsc_contact_title', 'Contact Us');
?>

<div class="contact-section-wrapper">
    <!-- Page Header (Removed as Duplicate)
    <div class="text-center mb-5">
        <h2 class="wq-section-title"><?php echo esc_html($form_title); ?></h2>
        <p class="wq-subtitle text-muted">Reach out for inquiries about fleet safety, partnerships, or support.</p>
    </div> -->

    <div class="contact-grid">

        <!-- MAIN FORM CARD -->
        <div class="wq-card">
            <h3>Send us a message</h3>
            <form action="#" method="POST" class="simple-contact-form">
                <?php wp_nonce_field('aitsc_contact_form_submit', 'aitsc_contact_nonce'); ?>

                <div class="form-row-2">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter your first name"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter your last name"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email address"
                        required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" class="form-control" rows="5" placeholder="How can we help?"
                        required></textarea>
                </div>

                <button type="submit" class="submit-btn">Submit Message</button>
            </form>
        </div>

        <!-- CONTACT INFO SIDEBAR -->
        <div class="info-stack">
            <div class="wq-card">
                <h3>Other ways to connect</h3>

                <a href="mailto:contact@aitsc.au" class="connect-item">
                    <div class="icon-box">
                        <span class="material-symbols-outlined">mail</span>
                    </div>
                    <div class="item-details">
                        <p class="item-title">contact@aitsc.au</p>
                        <p class="item-desc">Email us for any inquiry</p>
                    </div>
                </a>

                <a href="tel:+61234567890" class="connect-item">
                    <div class="icon-box">
                        <span class="material-symbols-outlined">call</span>
                    </div>
                    <div class="item-details">
                        <p class="item-title">+61 2 3456 7890</p>
                        <p class="item-desc">Mon-Fri from 9am to 5pm</p>
                    </div>
                </a>

                <div class="connect-item">
                    <div class="icon-box">
                        <span class="material-symbols-outlined">location_on</span>
                    </div>
                    <div class="item-details">
                        <p class="item-title">123 Fleet St, Sydney, NSW 2000</p>
                        <p class="item-desc">Visit our office</p>
                    </div>
                </div>

                <!-- Map -->
                <div class="map-container">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuAumIp5adSoWD72ZQzQLrIpLn7REEt1umoy1j1QrJyw_Hoeqe3jpAihhHZi2YlYvXsJwavevos4lv6DECSsNXuqvII-lnG5zBXj30OyZSzPjchIlPiYDPqG4ISWvupCpbprLzFO440Nxz2xuxP1mDAaDlmYCbO0GMJeRaxRcAENzXQ_V40WWz-ckbN_TD7Xpu2gkD1_VYdQWYJUs6DyS2WMmEjM0_LPlzoWkos9BWvE7fixcuT3VLIRW4klRgXbRFLjodr2KIsAx34"
                        alt="Map">
                </div>
            </div>
        </div>

    </div>
</div>