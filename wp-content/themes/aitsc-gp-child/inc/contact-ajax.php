<?php
/**
 * AITSC Contact Form AJAX Handler
 *
 * Handles form submissions with validation and email sending
 * Professional contact management for transport safety consulting
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register AJAX handlers
 */
function aitsc_register_contact_ajax() {
    add_action( 'wp_ajax_aitsc_contact_form_submit', 'aitsc_handle_contact_form' );
    add_action( 'wp_ajax_nopriv_aitsc_contact_form_submit', 'aitsc_handle_contact_form' );
}
add_action( 'init', 'aitsc_register_contact_ajax' );

/**
 * Handle contact form submission
 */
function aitsc_handle_contact_form() {
    // Verify nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'aitsc_contact_form_submit' ) ) {
        wp_send_json_error( 'Security check failed.' );
    }

    // Sanitize and validate form data
    $form_data = aitsc_sanitize_contact_data( $_POST );

    // Check rate limit BEFORE validation (save resources)
    // Uses email + IP combination to prevent bypass
    $rate_limit_result = aitsc_check_rate_limit( $form_data['email'], $form_data['ip_address'] );
    if ( $rate_limit_result['limited'] ) {
        wp_send_json_error( array(
            'message' => $rate_limit_result['message'],
            'retry_after' => $rate_limit_result['retry_after']
        ) );
    }

    // Validate required fields
    $validation_result = aitsc_validate_contact_data( $form_data );
    if ( ! $validation_result['valid'] ) {
        wp_send_json_error( $validation_result['message'] );
    }

    // Prepare email content
    $email_content = aitsc_prepare_contact_email( $form_data );

    // Send email to admin
    $admin_email = get_option( 'admin_email' );
    $email_sent = aitsc_send_contact_email( $admin_email, $email_content['subject'], $email_content['body'], $form_data['email'], $form_data['first_name'] . ' ' . $form_data['last_name'] );

    // Send confirmation email to user (optional)
    if ( $email_sent && ! empty( $form_data['company_email'] ) ) {
        aitsc_send_confirmation_email( $form_data['email'], $form_data['first_name'] );
    }

    // Prepare response - do NOT include form data (PII protection)
    $response = array(
        'success' => $email_sent,
        'message' => $email_sent ? 'Thank you for your inquiry. We will contact you within 24 hours.' : 'Sorry, there was an error sending your message. Please try again.',
        'redirect_url' => get_theme_mod( 'aitsc_contact_redirect_url', home_url( '/thank-you/' ) )
    );

    // Send JSON response
    wp_send_json( $response );
}

/**
 * Sanitize contact form data
 */
function aitsc_sanitize_contact_data( $raw_data ) {
    $sanitized = array();

    // Contact information
    $sanitized['first_name'] = isset( $raw_data['first_name'] ) ? sanitize_text_field( $raw_data['first_name'] ) : '';
    $sanitized['last_name'] = isset( $raw_data['last_name'] ) ? sanitize_text_field( $raw_data['last_name'] ) : '';
    $sanitized['email'] = isset( $raw_data['email'] ) ? sanitize_email( $raw_data['email'] ) : '';
    $sanitized['phone'] = isset( $raw_data['phone'] ) ? sanitize_text_field( $raw_data['phone'] ) : '';

    // Business information
    $sanitized['company_name'] = isset( $raw_data['company_name'] ) ? sanitize_text_field( $raw_data['company_name'] ) : '';
    $sanitized['company_size'] = isset( $raw_data['company_size'] ) ? sanitize_text_field( $raw_data['company_size'] ) : '';
    $sanitized['industry'] = isset( $raw_data['industry'] ) ? sanitize_text_field( $raw_data['industry'] ) : '';
    $sanitized['vehicle_count'] = isset( $raw_data['vehicle_count'] ) ? absint( $raw_data['vehicle_count'] ) : 0;

    // Service selection
    $sanitized['services'] = isset( $raw_data['services'] ) && is_array( $raw_data['services'] ) ?
        array_map( 'sanitize_text_field', $raw_data['services'] ) : array();

    // Message details
    $sanitized['subject'] = isset( $raw_data['subject'] ) ? sanitize_text_field( $raw_data['subject'] ) : '';
    $sanitized['message'] = isset( $raw_data['message'] ) ? sanitize_textarea_field( $raw_data['message'] ) : '';
    $sanitized['urgency'] = isset( $raw_data['urgency'] ) ? sanitize_text_field( $raw_data['urgency'] ) : '';

    // Form metadata
    $sanitized['form_type'] = isset( $raw_data['form_type'] ) ? sanitize_text_field( $raw_data['form_type'] ) : '';
    $sanitized['form_id'] = isset( $raw_data['form_id'] ) ? sanitize_text_field( $raw_data['form_id'] ) : '';
    $sanitized['consent'] = isset( $raw_data['consent'] ) ? rest_sanitize_boolean( $raw_data['consent'] ) : false;

    // Add submission metadata
    $sanitized['ip_address'] = aitsc_get_client_ip();
    $sanitized['user_agent'] = sanitize_text_field($_SERVER['HTTP_USER_AGENT'] ?? '');
    $sanitized['submission_date'] = current_time( 'Y-m-d H:i:s' );
    $sanitized['page_url'] = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( $_SERVER['HTTP_REFERER'] ) : '';

    return $sanitized;
}

/**
 * Get real client IP address (proxy-aware)
 * Checks multiple headers for forwarded IPs
 */
function aitsc_get_client_ip() {
    $ip_keys = array(
        'HTTP_CF_CONNECTING_IP',      // Cloudflare
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    );

    foreach ( $ip_keys as $key ) {
        if ( ! empty( $_SERVER[ $key ] ) ) {
            $ip = sanitize_text_field( $_SERVER[ $key ] );

            // Handle X-Forwarded-For with multiple IPs
            if ( strpos( $ip, ',' ) !== false ) {
                $ips = explode( ',', $ip );
                $ip = trim( $ips[0] );
            }

            // Validate IP format
            if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
                return $ip;
            }
        }
    }

    return '0.0.0.0';
}

/**
 * Check rate limit for form submissions
 * Limits: 5 submissions per (email + IP) per hour
 */
function aitsc_check_rate_limit( $email, $ip_address ) {
    // Use both email and IP to prevent bypass via email aliases
    $option_key = 'aitsc_form_submissions_' . md5( sanitize_email( $email ) . '|' . $ip_address );
    $submissions = get_option( $option_key, array() );
    $now = time();
    $hour_ago = $now - HOUR_IN_SECONDS;

    // Clean up old submissions (older than 1 hour)
    $submissions = array_filter( $submissions, function( $timestamp ) use ( $hour_ago ) {
        return $timestamp > $hour_ago;
    } );

    // Check if limit exceeded
    if ( count( $submissions ) >= 5 ) {
        $oldest_timestamp = min( $submissions );
        $retry_after = (int) ceil( ( $oldest_timestamp + HOUR_IN_SECONDS - $now ) / 60 );

        return array(
            'limited' => true,
            'message' => sprintf(
                'Too many submissions. Please try again in %d minutes.',
                $retry_after
            ),
            'retry_after' => $retry_after
        );
    }

    // Record this submission
    $submissions[] = $now;
    update_option( $option_key, $submissions, false );

    return array( 'limited' => false );
}

/**
 * Validate contact form data
 */
function aitsc_validate_contact_data( $data ) {
    $errors = array();

    // Required field validation
    if ( empty( $data['first_name'] ) ) {
        $errors[] = 'First name is required.';
    }

    if ( empty( $data['last_name'] ) ) {
        $errors[] = 'Last name is required.';
    }

    if ( empty( $data['email'] ) ) {
        $errors[] = 'Email address is required.';
    } elseif ( ! is_email( $data['email'] ) ) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ( empty( $data['phone'] ) ) {
        $errors[] = 'Phone number is required.';
    }

    if ( empty( $data['company_name'] ) ) {
        $errors[] = 'Company name is required.';
    }

    // Multi-step form specific validations
    if ( $data['form_type'] === 'multi_step_contact' ) {
        if ( empty( $data['company_size'] ) ) {
            $errors[] = 'Company size is required.';
        }

        if ( empty( $data['industry'] ) ) {
            $errors[] = 'Industry is required.';
        }

        if ( empty( $data['vehicle_count'] ) || $data['vehicle_count'] < 1 ) {
            $errors[] = 'Number of vehicles must be at least 1.';
        }

        if ( empty( $data['services'] ) ) {
            $errors[] = 'Please select at least one service.';
        }
    }

    // Single form specific validations
    if ( $data['form_type'] === 'single_contact' ) {
        if ( empty( $data['subject'] ) ) {
            $errors[] = 'Subject is required.';
        }
    }

    // Consent validation
    if ( ! $data['consent'] ) {
        $errors[] = 'Please accept the terms to continue.';
    }

    // Honeypot check
    if ( isset( $_POST['honeypot'] ) && ! empty( $_POST['honeypot'] ) ) {
        $errors[] = 'Suspicious activity detected.';
    }

    if ( ! empty( $errors ) ) {
        return array(
            'valid' => false,
            'message' => implode( ' ', $errors )
        );
    }

    return array( 'valid' => true );
}

/**
 * Prepare contact email content
 */
function aitsc_prepare_contact_email( $data ) {
    $service_categories = aitsc_get_service_categories();
    $contact_info = aitsc_get_contact_info();

    // Get service names if provided
    $selected_services = '';
    if ( ! empty( $data['services'] ) ) {
        $service_names = array();
        foreach ( $data['services'] as $service_key ) {
            // Find service in categories
            foreach ( $service_categories as $category_key => $category ) {
                if ( isset( $category['services'][$service_key] ) ) {
                    $service_names[] = $category['services'][$service_key]['title'];
                    break;
                }
            }
        }
        $selected_services = implode( ', ', $service_names );
    }

    // Email subject
    $subject = 'AITSC Transport Safety Inquiry';
    if ( ! empty( $data['subject'] ) ) {
        $subject .= ': ' . $data['subject'];
    } elseif ( ! empty( $data['company_name'] ) ) {
        $subject .= ' from ' . $data['company_name'];
    }

    // Email body
    $body = "
    <h2>New Transport Safety Inquiry</h2>

    <h3>Contact Information</h3>
    <p><strong>Name:</strong> {$data['first_name']} {$data['last_name']}</p>
    <p><strong>Email:</strong> {$data['email']}</p>
    <p><strong>Phone:</strong> {$data['phone']}</p>

    <h3>Business Information</h3>
    <p><strong>Company:</strong> {$data['company_name']}</p>";

    if ( ! empty( $data['company_size'] ) ) {
        $body .= "<p><strong>Company Size:</strong> {$data['company_size']}</p>";
    }

    if ( ! empty( $data['industry'] ) ) {
        $body .= "<p><strong>Industry:</strong> {$data['industry']}</p>";
    }

    if ( ! empty( $data['vehicle_count'] ) ) {
        $body .= "<p><strong>Fleet Size:</strong> {$data['vehicle_count']} vehicles</p>";
    }

    if ( ! empty( $selected_services ) ) {
        $body .= "
        <h3>Services Interested In</h3>
        <p>{$selected_services}</p>";
    }

    if ( ! empty( $data['urgency'] ) ) {
        $urgency_levels = array(
            'low' => 'Low - Planning for future implementation',
            'medium' => 'Medium - Implementation within 3 months',
            'high' => 'High - Urgent compliance requirements',
            'critical' => 'Critical - Immediate assistance needed'
        );
        $urgency_text = isset( $urgency_levels[$data['urgency']] ) ? $urgency_levels[$data['urgency']] : $data['urgency'];
        $body .= "
        <h3>Urgency Level</h3>
        <p>{$urgency_text}</p>";
    }

    if ( ! empty( $data['message'] ) ) {
        $body .= "
        <h3>Additional Information</h3>
        <p>" . nl2br( $data['message'] ) . "</p>";
    }

    $body .= "
    <hr>
    <p><small>Submission Date: {$data['submission_date']}</small></p>
    <p><small>Page URL: {$data['page_url']}</small></p>
    ";

    return array(
        'subject' => $subject,
        'body' => $body
    );
}

/**
 * Send contact email
 */
function aitsc_send_contact_email( $to_email, $subject, $body, $from_email = '', $from_name = '' ) {
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
        'Reply-To: ' . $from_name . ' <' . $from_email . '>'
    );

    return wp_mail( $to_email, $subject, $body, $headers );
}

/**
 * Send confirmation email to user
 */
function aitsc_send_confirmation_email( $user_email, $first_name ) {
    $subject = 'Thank you for contacting AITSC';

    $body = "
    <h2>Thank You, {$first_name}!</h2>

    <p>Thank you for your inquiry with Australian Industrial Transport Safety Consultants.</p>

    <p>We have received your message and will contact you within 24 hours to discuss your transport safety requirements.</p>

    <h3>What Happens Next?</h3>
    <ul>
        <li>Our expert team will review your requirements</li>
        <li>We will prepare a customized safety solution proposal</li>
        <li>A consultant will contact you to schedule a consultation</li>
    </ul>

    <p>If you need immediate assistance, please call us at <strong>1300 247 872</strong>.</p>

    <p>Best regards,<br>
    The AITSC Team</p>

    <hr>
    <p><small>Australian Industrial Transport Safety Consultants<br>
    ABN: 123 456 789 000<br>
    Phone: 1300 247 872<br>
    Email: info@aitsc.com.au<br>
    Web: https://aitsc.com.au</small></p>
    ";

    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: AITSC <info@aitsc.com.au>'
    );

    return wp_mail( $user_email, $subject, $body, $headers );
}

/**
 * Send JSON error response
 */
function aitsc_send_json_error( $message ) {
    wp_send_json( array(
        'success' => false,
        'message' => $message
    ) );
}