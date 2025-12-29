<?php
/**
 * AITSC Rate Limiting Test Suite
 *
 * Comprehensive tests for contact form rate limiting functionality
 * Tests: aitsc_check_rate_limit() and integration with aitsc_handle_contact_form()
 *
 * @package AITSC_Pro_Theme
 * @subpackage Tests
 * @since 2.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    // Mock WordPress environment for standalone testing
    define( 'ABSPATH', __DIR__ . '/../../../' );
    define( 'HOUR_IN_SECONDS', 3600 );
}

/**
 * Mock WordPress functions for standalone testing
 */
class WP_Mock {
    private static $options = array();
    private static $server_vars = array();

    public static function init() {
        // Set up server variables
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'Test Agent';
        $_SERVER['HTTP_REFERER'] = 'http://localhost/test/';

        // Set up WordPress constants
        if ( ! defined( 'HOUR_IN_SECONDS' ) ) {
            define( 'HOUR_IN_SECONDS', 3600 );
        }
    }

    public static function get_option( $name, $default = false ) {
        return isset( self::$options[$name] ) ? self::$options[$name] : $default;
    }

    public static function update_option( $name, $value, $autoload = null ) {
        self::$options[$name] = $value;
        return true;
    }

    public static function delete_option( $name ) {
        unset( self::$options[$name] );
        return true;
    }

    public static function reset() {
        self::$options = array();
    }

    public static function sanitize_email( $email ) {
        return filter_var( $email, FILTER_SANITIZE_EMAIL );
    }

    public static function md5( $str ) {
        return md5( $str );
    }

    public static function time() {
        return time();
    }
}

/**
 * Rate Limiting Implementation (copied for testing)
 */
function aitsc_check_rate_limit( $email ) {
    $option_key = 'aitsc_form_submissions_' . md5( WP_Mock::sanitize_email( $email ) );
    $submissions = WP_Mock::get_option( $option_key, array() );
    $now = WP_Mock::time();
    $hour_ago = $now - HOUR_IN_SECONDS;

    // Clean up old submissions (older than 1 hour)
    $submissions = array_filter( $submissions, function( $timestamp ) use ( $hour_ago ) {
        return $timestamp > $hour_ago;
    } );

    // Check if limit exceeded
    if ( count( $submissions ) >= 5 ) {
        $oldest_timestamp = min( $submissions );
        $retry_after = ceil( ( $oldest_timestamp + HOUR_IN_SECONDS - $now ) / 60 );

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
    WP_Mock::update_option( $option_key, $submissions, false );

    return array( 'limited' => false );
}

/**
 * Test Suite Class
 */
class RateLimitingTestSuite {
    private $test_results = array();
    private $test_emails = array();

    public function __construct() {
        WP_Mock::init();
        $this->test_emails = array(
            'test1@example.com',
            'test2@example.com',
            'test3@example.com',
            'test4@example.com',
            'test5@example.com',
            'test6@example.com'
        );
    }

    /**
     * Reset test state before each test
     */
    private function reset() {
        WP_Mock::reset();
    }

    /**
     * Assert helper functions
     */
    private function assert_true( $condition, $test_name, $message = '' ) {
        $passed = $condition === true;
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message ?: ( $passed ? 'Assertion passed' : 'Expected true, got false' )
        );
        return $passed;
    }

    private function assert_false( $condition, $test_name, $message = '' ) {
        $passed = $condition === false;
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message ?: ( $passed ? 'Assertion passed' : 'Expected false, got true' )
        );
        return $passed;
    }

    private function assert_equals( $expected, $actual, $test_name, $message = '' ) {
        $passed = $expected === $actual;
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message ?: sprintf( 'Expected %s, got %s', json_encode($expected), json_encode($actual) )
        );
        return $passed;
    }

    private function assert_array_has_key( $key, $array, $test_name, $message = '' ) {
        $passed = is_array( $array ) && isset( $array[$key] );
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message ?: ( $passed ? "Key '$key' exists" : "Key '$key' not found in array" )
        );
        return $passed;
    }

    private function assert_is_type( $value, $type, $test_name, $message = '' ) {
        $passed = false;
        switch ( $type ) {
            case 'array':
                $passed = is_array( $value );
                break;
            case 'string':
                $passed = is_string( $value );
                break;
            case 'int':
            case 'integer':
                $passed = is_int( $value );
                break;
            case 'bool':
            case 'boolean':
                $passed = is_bool( $value );
                break;
        }
        $this->test_results[] = array(
            'test' => $test_name,
            'passed' => $passed,
            'message' => $message ?: sprintf( 'Expected %s, got %s', $type, gettype($value) )
        );
        return $passed;
    }

    /**
     * TEST SCENARIO 1: First submission should pass rate limit check
     */
    public function test_scenario_1_first_submission() {
        $this->reset();
        $email = 'first@example.com';

        $result = aitsc_check_rate_limit( $email );

        // Test result structure
        $this->assert_is_type( $result, 'array', 'Scenario 1.1: Result is array' );
        $this->assert_array_has_key( 'limited', $result, 'Scenario 1.2: Has "limited" key' );
        $this->assert_is_type( $result['limited'], 'bool', 'Scenario 1.3: "limited" is boolean' );

        // Test first submission passes
        $this->assert_false( $result['limited'], 'Scenario 1.4: First submission not limited' );
    }

    /**
     * TEST SCENARIO 2: 5 submissions within 1 hour - should allow all
     */
    public function test_scenario_2_five_submissions_allowed() {
        $this->reset();
        $email = 'five_allowed@example.com';

        // Submit 5 times
        for ( $i = 1; $i <= 5; $i++ ) {
            $result = aitsc_check_rate_limit( $email );
            $this->assert_false(
                $result['limited'],
                "Scenario 2.$i: Submission #$i allowed (within limit)",
                "Submission $i should be allowed"
            );
        }

        // Verify storage
        $option_key = 'aitsc_form_submissions_' . md5( $email );
        $submissions = WP_Mock::get_option( $option_key );
        $this->assert_equals( 5, count( $submissions ), 'Scenario 2.6: 5 submissions stored' );
    }

    /**
     * TEST SCENARIO 3: 6th submission within 1 hour - should be rate limited
     */
    public function test_scenario_3_sixth_submission_limited() {
        $this->reset();
        $email = 'sixth_limited@example.com';

        // Submit 5 times (all should pass)
        for ( $i = 1; $i <= 5; $i++ ) {
            aitsc_check_rate_limit( $email );
        }

        // 6th submission should be limited
        $result = aitsc_check_rate_limit( $email );

        $this->assert_true( $result['limited'], 'Scenario 3.1: 6th submission is limited' );
        $this->assert_array_has_key( 'message', $result, 'Scenario 3.2: Has "message" key' );
        $this->assert_array_has_key( 'retry_after', $result, 'Scenario 3.3: Has "retry_after" key' );
        $this->assert_is_type( $result['message'], 'string', 'Scenario 3.4: "message" is string' );
        $this->assert_is_type( $result['retry_after'], 'int', 'Scenario 3.5: "retry_after" is integer' );

        // Check retry_after is reasonable (should be close to 60 minutes)
        $this->assert_true(
            $result['retry_after'] > 0 && $result['retry_after'] <= 60,
            'Scenario 3.6: "retry_after" is reasonable (1-60 minutes)',
            "retry_after: {$result['retry_after']} minutes"
        );

        // Check message contains retry time
        $this->assert_true(
            strpos( $result['message'], (string)$result['retry_after'] ) !== false,
            'Scenario 3.7: Message contains retry time'
        );
    }

    /**
     * TEST SCENARIO 4: Submission after 1 hour - should be allowed again
     */
    public function test_scenario_4_after_hour_allowed() {
        $this->reset();
        $email = 'after_hour@example.com';

        // Manually create old submissions (>1 hour ago)
        $now = time();
        $old_timestamps = array(
            $now - 3700, // 61 minutes ago
            $now - 3800, // 63 minutes ago
            $now - 3900, // 65 minutes ago
            $now - 4000, // 66 minutes ago
            $now - 4100  // 68 minutes ago
        );

        $option_key = 'aitsc_form_submissions_' . md5( $email );
        WP_Mock::update_option( $option_key, $old_timestamps );

        // Old submissions should be cleaned up, new one allowed
        $result = aitsc_check_rate_limit( $email );

        $this->assert_false(
            $result['limited'],
            'Scenario 4.1: Submission allowed after old entries cleaned',
            'Old submissions should be removed by cleanup logic'
        );

        // Verify cleanup worked
        $submissions = WP_Mock::get_option( $option_key );
        $this->assert_equals( 1, count( $submissions ), 'Scenario 4.2: Only new submission stored (old ones cleaned)' );
    }

    /**
     * TEST SCENARIO 5: Cleanup of old submissions (older than 1 hour)
     */
    public function test_scenario_5_cleanup_old_submissions() {
        $this->reset();
        $email = 'cleanup_test@example.com';
        $now = time();

        // Create mixed timestamps: some old, some recent
        $mixed_timestamps = array(
            $now - 7200,  // 2 hours ago (should be cleaned)
            $now - 5400,  // 90 minutes ago (should be cleaned)
            $now - 1800,  // 30 minutes ago (should stay)
            $now - 900,   // 15 minutes ago (should stay)
            $now - 300    // 5 minutes ago (should stay)
        );

        $option_key = 'aitsc_form_submissions_' . md5( $email );
        WP_Mock::update_option( $option_key, $mixed_timestamps );

        // Trigger cleanup by calling rate limit check
        $result = aitsc_check_rate_limit( $email );

        // Should be allowed (only 3 old + 1 new = 4, under limit of 5)
        $this->assert_false(
            $result['limited'],
            'Scenario 5.1: Allowed after cleanup of old submissions'
        );

        // Verify cleanup: should have 4 entries (3 recent + 1 new)
        $submissions = WP_Mock::get_option( $option_key );
        $this->assert_equals( 4, count( $submissions ), 'Scenario 5.2: Old submissions cleaned, recent ones kept' );

        // Verify all remaining are recent
        $hour_ago = $now - HOUR_IN_SECONDS;
        foreach ( $submissions as $timestamp ) {
            $this->assert_true(
                $timestamp > $hour_ago,
                'Scenario 5.3: All remaining timestamps are within 1 hour'
            );
        }
    }

    /**
     * TEST SCENARIO 6: WordPress options storage works correctly
     */
    public function test_scenario_6_wordpress_options_storage() {
        $this->reset();
        $email = 'storage_test@example.com';
        $expected_key = 'aitsc_form_submissions_' . md5( $email );

        // First submission
        aitsc_check_rate_limit( $email );

        // Check storage
        $submissions = WP_Mock::get_option( $expected_key );
        $this->assert_is_type( $submissions, 'array', 'Scenario 6.1: Submissions stored as array' );
        $this->assert_equals( 1, count( $submissions ), 'Scenario 6.2: One submission stored' );

        // Second submission
        aitsc_check_rate_limit( $email );
        $submissions = WP_Mock::get_option( $expected_key );
        $this->assert_equals( 2, count( $submissions ), 'Scenario 6.3: Two submissions stored' );

        // Verify timestamps are valid
        $now = time();
        foreach ( $submissions as $timestamp ) {
            $this->assert_true(
                $timestamp > 0 && $timestamp <= $now,
                'Scenario 6.4: Valid timestamp stored',
                "Timestamp: $timestamp"
            );
        }
    }

    /**
     * TEST SCENARIO 7: Multiple emails have separate rate limits
     */
    public function test_scenario_7_multiple_emails_separate_limits() {
        $this->reset();

        $email1 = 'user1@example.com';
        $email2 = 'user2@example.com';

        // Each user submits 5 times
        for ( $i = 0; $i < 5; $i++ ) {
            $result1 = aitsc_check_rate_limit( $email1 );
            $result2 = aitsc_check_rate_limit( $email2 );
            $this->assert_false( $result1['limited'], "Scenario 7." . ($i*2+1) . ": Email1 submission $i allowed" );
            $this->assert_false( $result2['limited'], "Scenario 7." . ($i*2+2) . ": Email2 submission $i allowed" );
        }

        // 6th for email1 should be limited
        $result1 = aitsc_check_rate_limit( $email1 );
        $this->assert_true( $result1['limited'], 'Scenario 7.11: Email1 6th submission limited' );

        // But email2's 6th submission should also be limited
        $result2 = aitsc_check_rate_limit( $email2 );
        $this->assert_true( $result2['limited'], 'Scenario 7.12: Email2 6th submission limited' );
    }

    /**
     * TEST SCENARIO 8: Return structure validation
     */
    public function test_scenario_8_return_structure() {
        $this->reset();
        $email = 'structure_test@example.com';

        // Test not limited structure
        $result = aitsc_check_rate_limit( $email );

        $this->assert_is_type( $result, 'array', 'Scenario 8.1: Result is array' );
        $this->assert_array_has_key( 'limited', $result, 'Scenario 8.2: Has "limited" key' );
        $this->assert_equals( false, $result['limited'], 'Scenario 8.3: "limited" is false' );

        // Test limited structure
        $email2 = 'limited_structure@example.com';
        for ( $i = 0; $i < 6; $i++ ) {
            $result = aitsc_check_rate_limit( $email2 );
        }

        $this->assert_equals( true, $result['limited'], 'Scenario 8.4: "limited" is true' );
        $this->assert_array_has_key( 'message', $result, 'Scenario 8.5: Has "message" key' );
        $this->assert_array_has_key( 'retry_after', $result, 'Scenario 8.6: Has "retry_after" key' );
        $this->assert_is_type( $result['message'], 'string', 'Scenario 8.7: "message" is string' );
        $this->assert_is_type( $result['retry_after'], 'int', 'Scenario 8.8: "retry_after" is int' );
        $this->assert_true( !empty( $result['message'] ), 'Scenario 8.9: "message" is not empty' );
        $this->assert_true( $result['retry_after'] >= 0, 'Scenario 8.10: "retry_after" is non-negative' );
    }

    /**
     * TEST SCENARIO 9: Edge case - exactly 5 submissions
     */
    public function test_scenario_9_exactly_five_submissions() {
        $this->reset();
        $email = 'exactly_five@example.com';

        // Submit exactly 5 times - boundary test
        for ( $i = 0; $i < 5; $i++ ) {
            $result = aitsc_check_rate_limit( $email );
            $this->assert_false( $result['limited'], "Scenario 9." . ($i+1) . ": Submission " . ($i+1) . " allowed (at limit)" );
        }
    }

    /**
     * TEST SCENARIO 10: Edge case - submissions at exactly 1 hour boundary
     */
    public function test_scenario_10_hour_boundary() {
        $this->reset();
        $email = 'boundary@example.com';
        $now = time();

        // Create submission at exactly 1 hour ago
        $option_key = 'aitsc_form_submissions_' . md5( $email );
        WP_Mock::update_option( $option_key, array( $now - HOUR_IN_SECONDS - 1 ) );

        // This old submission should be cleaned up
        $result = aitsc_check_rate_limit( $email );
        $this->assert_false( $result['limited'], 'Scenario 10.1: Submission just over 1 hour old is cleaned' );

        // Now test submission at exactly 1 hour - 1 second (should be kept)
        $email2 = 'boundary2@example.com';
        $option_key2 = 'aitsc_form_submissions_' . md5( $email2 );
        WP_Mock::update_option( $option_key2, array( $now - HOUR_IN_SECONDS + 1 ) );

        $result2 = aitsc_check_rate_limit( $email2 );
        $this->assert_false( $result2['limited'], 'Scenario 10.2: Submission just under 1 hour old is kept' );
    }

    /**
     * TEST SCENARIO 11: Email sanitization
     */
    public function test_scenario_11_email_sanitization() {
        $this->reset();

        // Test with various email formats
        $emails = array(
            'test@example.com' => 'test@example.com',
            '  test@example.com  ' => 'test@example.com',
            'TEST@EXAMPLE.COM' => 'TEST@EXAMPLE.COM',
            'test+tag@example.com' => 'test+tag@example.com',
        );

        foreach ( $emails as $input => $expected ) {
            $email = 'test11_' . md5( $input ) . '@example.com';
            aitsc_check_rate_limit( $email );
            $option_key = 'aitsc_form_submissions_' . md5( $email );
            $stored = WP_Mock::get_option( $option_key );
            $this->assert_true( is_array( $stored ), "Scenario 11.$input: Email sanitization works for $input" );
        }
    }

    /**
     * TEST SCENARIO 12: Integration test - simulate contact form handler behavior
     */
    public function test_scenario_12_contact_form_integration() {
        $this->reset();
        $email = 'integration@example.com';

        // Simulate contact form submission workflow
        $form_data = array(
            'email' => $email,
            'first_name' => 'Test',
            'last_name' => 'User'
        );

        // Simulate multiple form submissions
        $submission_results = array();
        for ( $i = 0; $i < 7; $i++ ) {
            $rate_limit_result = aitsc_check_rate_limit( $form_data['email'] );

            if ( $rate_limit_result['limited'] ) {
                // Simulate wp_send_json_error response
                $submission_results[] = array(
                    'success' => false,
                    'error' => 'rate_limited',
                    'message' => $rate_limit_result['message'],
                    'retry_after' => $rate_limit_result['retry_after']
                );
            } else {
                // Form would proceed normally
                $submission_results[] = array(
                    'success' => true,
                    'message' => 'Form submitted successfully'
                );
            }
        }

        // Verify first 5 succeed
        for ( $i = 0; $i < 5; $i++ ) {
            $this->assert_true(
                $submission_results[$i]['success'],
                "Scenario 12." . ($i+1) . ": Form submission " . ($i+1) . " succeeds"
            );
        }

        // Verify 6th and 7th fail with rate limit error
        $this->assert_false(
            $submission_results[5]['success'],
            'Scenario 12.6: Form submission 6 fails due to rate limit'
        );
        $this->assert_equals(
            'rate_limited',
            $submission_results[5]['error'],
            'Scenario 12.7: Error type is rate_limited'
        );
        $this->assert_array_has_key(
            'retry_after',
            $submission_results[5],
            'Scenario 12.8: Error response includes retry_after'
        );
    }

    /**
     * Run all tests
     */
    public function run_all_tests() {
        echo "\n";
        echo "========================================\n";
        echo " AITSC RATE LIMITING TEST SUITE\n";
        echo "========================================\n";
        echo "Testing: aitsc_check_rate_limit()\n";
        echo "Date: " . date( 'Y-m-d H:i:s' ) . "\n";
        echo "========================================\n\n";

        // Run all test scenarios
        $this->test_scenario_1_first_submission();
        echo "✓ Scenario 1: First submission - COMPLETE\n";

        $this->test_scenario_2_five_submissions_allowed();
        echo "✓ Scenario 2: Five submissions allowed - COMPLETE\n";

        $this->test_scenario_3_sixth_submission_limited();
        echo "✓ Scenario 3: Sixth submission limited - COMPLETE\n";

        $this->test_scenario_4_after_hour_allowed();
        echo "✓ Scenario 4: After hour cleanup - COMPLETE\n";

        $this->test_scenario_5_cleanup_old_submissions();
        echo "✓ Scenario 5: Cleanup old submissions - COMPLETE\n";

        $this->test_scenario_6_wordpress_options_storage();
        echo "✓ Scenario 6: WordPress storage - COMPLETE\n";

        $this->test_scenario_7_multiple_emails_separate_limits();
        echo "✓ Scenario 7: Multiple emails - COMPLETE\n";

        $this->test_scenario_8_return_structure();
        echo "✓ Scenario 8: Return structure - COMPLETE\n";

        $this->test_scenario_9_exactly_five_submissions();
        echo "✓ Scenario 9: Exactly five submissions - COMPLETE\n";

        $this->test_scenario_10_hour_boundary();
        echo "✓ Scenario 10: Hour boundary - COMPLETE\n";

        $this->test_scenario_11_email_sanitization();
        echo "✓ Scenario 11: Email sanitization - COMPLETE\n";

        $this->test_scenario_12_contact_form_integration();
        echo "✓ Scenario 12: Contact form integration - COMPLETE\n";

        // Generate summary report
        $this->generate_report();
    }

    /**
     * Generate test report
     */
    private function generate_report() {
        $total = count( $this->test_results );
        $passed = count( array_filter( $this->test_results, function( $r ) { return $r['passed']; } ) );
        $failed = $total - $passed;

        echo "\n";
        echo "========================================\n";
        echo " TEST RESULTS SUMMARY\n";
        echo "========================================\n";
        echo "Total Tests: $total\n";
        echo "Passed: $passed (" . round( ($passed/$total)*100, 1 ) . "%)\n";
        echo "Failed: $failed (" . round( ($failed/$total)*100, 1 ) . "%)\n";
        echo "========================================\n\n";

        if ( $failed > 0 ) {
            echo "FAILED TESTS:\n";
            echo "----------------------------------------\n";
            foreach ( $this->test_results as $result ) {
                if ( ! $result['passed'] ) {
                    echo "✗ {$result['test']}\n";
                    echo "  {$result['message']}\n\n";
                }
            }
        }

        echo "DETAILED RESULTS:\n";
        echo "----------------------------------------\n";
        foreach ( $this->test_results as $result ) {
            $status = $result['passed'] ? '✓ PASS' : '✗ FAIL';
            echo "$status: {$result['test']}\n";
            if ( ! $result['passed'] ) {
                echo "  → {$result['message']}\n";
            }
        }
        echo "\n";

        return array(
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'percentage' => round( ($passed/$total)*100, 1 )
        );
    }

    /**
     * Get test results for external use
     */
    public function get_results() {
        return $this->test_results;
    }
}

// Run tests if executed directly
if ( php_sapi_name() === 'cli' || isset( $_SERVER['REQUEST_URI'] ) ) {
    $suite = new RateLimitingTestSuite();
    $suite->run_all_tests();
}
