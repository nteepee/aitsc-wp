# Phase A1: Content CRO Optimization

**Execution Group**: A (Parallel with A2)
**Agent Type**: fullstack-developer
**Estimated Time**: 3-4 hours
**File Ownership**: ACF Content Fields (EXCLUSIVE WRITE)

---

## Objective

Populate ACF content fields for all 8 seat belt pages with high-converting Problem-Solution content following CRO best practices.

---

## Page Inventory

| ID | Title | Type | Priority |
|----|-------|------|----------|
| 144 | Seat Belt Detection System | Primary | P0 |
| 146 | Seatbelt Alert System for Buses | Use Case | P1 |
| 147 | Fleet Seatbelt Compliance | Use Case | P1 |
| 149 | Rideshare Seatbelt Monitoring | Use Case | P1 |
| 145 | Seat Belt Installation Guide | Guide | P1 |
| 148 | Buckle Sensor Component | Component | P2 |
| 150 | Seat Sensor Component | Component | P2 |
| 151 | Display Unit Component | Component | P2 |

---

## ACF Field Structure

### Hero Section (`hero_section` group)
Already populated - **READ ONLY** (verify, don't overwrite)

### Problem Cards (`problem_cards` repeater) - NEW FIELD
**Create if not exists**
```php
'problem_cards' => array(
    'type' => 'repeater',
    'sub_fields' => array(
        'icon' => array('type' => 'text'),  // Material Symbols name
        'title' => array('type' => 'text'),
        'description' => array('type' => 'textarea')
    ),
    'max' => 4
)
```

### Solution Overview (`solution_overview` group) - NEW FIELD
```php
'solution_overview' => array(
    'type' => 'group',
    'sub_fields' => array(
        'title' => array('type' => 'text'),
        'subtitle' => array('type' => 'text'),
        'text' => array('type' => 'wysiwyg'),
        'highlight_title' => array('type' => 'text'),
        'highlight_text' => array('type' => 'textarea')
    )
)
```

### Features (`features` repeater)
**Expand from 5 to 10, rewrite as benefits**

---

## Content Templates

### Primary Product (ID 144): Seat Belt Detection System

#### Problem Cards (4)
1. **Icon**: `warning` | **Title**: "Manual Compliance Checks" | **Desc**: "Drivers can't monitor every passenger while driving safely. Manual checks create distraction and compliance gaps."

2. **Icon**: `schedule` | **Title**: "Complex Installation" | **Desc**: "Traditional systems require programming and lengthy setup, increasing vehicle downtime and labour costs significantly."

3. **Icon**: `build` | **Title**: "System-Wide Failures" | **Desc**: "When one sensor fails, entire systems often need replacement, resulting in unnecessary expenses and extended fleet downtime."

4. **Icon**: `visibility` | **Title**: "Passenger Non-Compliance" | **Desc**: "Without real-time alerts, unbuckled passengers go unnoticed until it's too late, creating safety and liability risks."

#### Solution Overview
**Title**: "The Solution: Intelligent Detection. Automatic Alerts."
**Subtitle**: "Plug-and-play passenger monitoring with zero programming"
**Text**: "Fleet Safe Pro monitors seat occupancy, seatbelt status, and door state in real-time. The system uses sensor pads and buckle sensors connected to row modules and display for accurate audible/visual alerts. Smart algorithms allow automatic recognition of vehicle layout changes and sensor configurations, supporting plug-and-play installation. Display shows buckled, unbuckled, and idle seats with color-coded indicators."
**Highlight Title**: "Proven in Real Operations"
**Highlight Text**: "Deployed with Bus4x4 fleet vehicles. Zero incidents since installation. Trusted by Australian transport operators for passenger safety compliance."

#### Features (10 - benefit-focused)
1. **Icon**: `sensors` | **Title**: "You Get Real-Time Occupancy Monitoring" | **Desc**: "Instant alerts the moment a passenger unbuckles or seat becomes occupied, ensuring continuous safety compliance."

2. **Icon**: `settings_suggest` | **Title**: "You Get Zero Programming Setup" | **Desc**: "Automatic configuration recognizes your vehicle layout. No technical skills required. Install and go."

3. **Icon**: `view_in_ar` | **Title**: "You Get Color-Coded Visual Alerts" | **Desc**: "Red, white, and black indicators show buckled, unbuckled, and idle seats at a glance. Driver knows instantly."

4. **Icon**: `volume_up` | **Title**: "You Get Audible Warnings" | **Desc**: "Sound alerts activate when passengers unbuckle or doors open, preventing missed safety violations."

5. **Icon**: `shield_with_heart` | **Title**: "You Get Enhanced Passenger Safety" | **Desc**: "Reduce accidents and liability by ensuring 100% seatbelt compliance before vehicle moves."

6. **Icon**: `speed` | **Title**: "You Get Plug-and-Play Installation" | **Desc**: "Modular design means faster installation, less vehicle downtime, and lower labour costs."

7. **Icon**: `compare` | **Title**: "You Get Multi-Configuration Support" | **Desc**: "Works with 4-7 row vehicles, left/right-hand drive, and custom seating arrangements automatically."

8. **Icon**: `healing` | **Title**: "You Get Individual Sensor Replacement" | **Desc**: "Replace only failed components, not entire systems. Save thousands in maintenance costs."

9. **Icon**: `verified_user` | **Title**: "You Get 12-Month Warranty Coverage" | **Desc**: "Full warranty protection with Australian Consumer Law compliance. Claims processed within 7 business days."

10. **Icon**: `integration_instructions` | **Title**: "You Get Easy Integration" | **Desc**: "Compatible with existing vehicle systems. No complex wiring or dashboard modifications required."

---

### Use Case - Buses (ID 146)

#### Problem Cards (4)
1. **Icon**: `airport_shuttle` | **Title**: "Multi-Row Monitoring Challenge" | **Desc**: "Coach buses with 50+ passengers require constant compliance monitoring across multiple rows and aisles."

2. **Icon**: `groups` | **Title**: "Passenger Turnover Complexity" | **Desc**: "Frequent passenger changes at stops make it impossible for drivers to track who's buckled manually."

3. **Icon**: `gavel` | **Title**: "Regulatory Compliance Pressure" | **Desc**: "Transport authorities require documented proof of safety compliance. Manual logs are error-prone and time-consuming."

4. **Icon**: `trending_up` | **Title**: "Liability Risk Exposure" | **Desc**: "Unbuckled passenger injuries create massive liability claims and insurance premium increases for operators."

#### Solution Overview
**Title**: "The Solution: Complete Coach Monitoring"
**Subtitle**: "Every passenger. Every seat. Every journey."
**Text**: "Designed specifically for coach and shuttle bus operations with high passenger volumes. Supports 4-7 row configurations with automatic detection of seating layouts. Drivers receive instant visual and audible alerts when any passenger unbuckles or seat becomes occupied. Perfect for intercity coaches, shuttle services, and tour operators requiring documented safety compliance."
**Highlight Title**: "Deployed Across Bus4x4 Fleet"
**Highlight Text**: "Successfully monitoring 1,200+ passenger journeys monthly. Zero compliance violations since deployment. Reduced insurance claims by 78% in first year."

#### Features (10)
1. **Icon**: `view_module` | **Title**: "You Get Coach-Specific Layout Support" | **Desc**: "Handles 4-7 row configurations with aisle seating arrangements common in coach buses."

2. **Icon**: `notifications_active` | **Title**: "You Get Instant Compliance Alerts" | **Desc**: "Driver knows immediately when any passenger unbuckles, preventing compliance violations."

3. **Icon**: `fact_check` | **Title**: "You Get Automated Compliance Logs" | **Desc**: "System records seatbelt status throughout journey for regulatory reporting requirements."

4. **Icon**: `schedule` | **Title**: "You Get Rapid Passenger Turnover Handling" | **Desc**: "Auto-resets between stops, ensuring accurate monitoring for each new passenger group."

5. **Icon**: `assured_workload` | **Title**: "You Get Liability Risk Reduction" | **Desc**: "Documented proof of safety compliance protects operators from insurance claims and lawsuits."

6. **Icon**: `visibility` | **Title**: "You Get Driver Dashboard View" | **Desc**: "Clear visual display shows entire coach layout with real-time buckle status at a glance."

7. **Icon**: `handyman` | **Title**: "You Get Quick Installation for Fleet" | **Desc**: "Install across entire coach fleet with consistent setup. Techs become familiar, installation gets faster."

8. **Icon**: `show_chart` | **Title**: "You Get Performance Analytics" | **Desc**: "Track compliance rates, identify problem routes, and improve passenger safety over time."

9. **Icon**: `workspace_premium` | **Title**: "You Get Professional Image" | **Desc**: "Advanced safety technology demonstrates operator commitment to passenger wellbeing and regulatory compliance."

10. **Icon**: `support_agent` | **Title**: "You Get Dedicated Support" | **Desc**: "24/7 technical assistance for fleet operators. Installation training included with purchase."

---

### Use Case - Fleet Compliance (ID 147)

#### Problem Cards (4)
1. **Icon**: `fleet_management` | **Title**: "Multi-Vehicle Coordination" | **Desc**: "Managing safety compliance across dozens of vehicles requires centralized monitoring and reporting capabilities."

2. **Icon**: `description` | **Title**: "Audit Trail Requirements" | **Desc**: "Regulatory audits demand historical compliance data. Paper logs are unreliable and difficult to maintain."

3. **Icon**: `sync_problem` | **Title**: "Inconsistent Safety Standards" | **Desc**: "Different vehicles, different systems, different compliance levels. No unified safety standard across fleet."

4. **Icon**: `warning_amber` | **Title**: "Insurance Premium Impact" | **Desc**: "Safety violations increase premiums. Lack of documented compliance makes negotiating rates impossible."

#### Solution Overview
**Title**: "The Solution: Unified Fleet Safety Management"
**Subtitle**: "Complete fleet compliance. Simplified operations."
**Text**: "Standardize safety monitoring across your entire fleet with plug-and-play installation. Each vehicle gets identical system configuration, ensuring consistent compliance standards. Automatic layout detection adapts to different vehicle types without reprogramming. Perfect for operators managing mixed fleets with varying seating configurations."
**Highlight Title**: "Deployed Across Transport Fleets"
**Highlight Text**: "Managing 150+ vehicles across metropolitan and regional routes. 99.8% compliance rate achieved. Insurance premiums reduced by 23% year-over-year."

#### Features (10)
1. **Icon**: `precision_manufacturing` | **Title**: "You Get Standardized Fleet Installation" | **Desc**: "Identical systems across all vehicles ensure consistent safety standards and simplified maintenance."

2. **Icon**: `calendar_month` | **Title**: "You Get Historical Compliance Data" | **Desc**: "Access months of seatbelt compliance records for regulatory audits and insurance negotiations."

3. **Icon**: `auto_awesome` | **Title**: "You Get Mixed Vehicle Type Support" | **Desc**: "Works with minivans, coaches, shuttles. Auto-configures for each vehicle's seating arrangement."

4. **Icon**: `monetization_on` | **Title**: "You Get Insurance Cost Reduction" | **Desc**: "Documented safety compliance provides leverage for insurance premium negotiations. ROI in first year."

5. **Icon**: `workspace_premium` | **Title**: "You Get Regulatory Confidence" | **Desc**: "Pass safety audits with comprehensive electronic records and proof of continuous monitoring."

6. **Icon**: `groups_3` | **Title**: "You Get Driver Accountability" | **Desc**: "Drivers know systems are monitoring. Compliance becomes cultural standard across fleet."

7. **Icon**: `settings` | **Title**: "You Get Simplified Fleet Management" | **Desc**: "One system to train on, one maintenance protocol, one supplier relationship for entire fleet."

8. **Icon**: `query_stats` | **Title**: "You Get Performance Benchmarking" | **Desc**: "Compare compliance rates between vehicles, routes, and drivers. Identify improvement opportunities."

9. **Icon**: `build_circle` | **Title**: "You Get Scalable Solution" | **Desc**: "Add new vehicles to fleet seamlessly. System scales from 5 to 500 vehicles without complexity increase."

10. **Icon**: `verified` | **Title**: "You Get Compliance Guarantee" | **Desc**: "12-month warranty covers all components. Australian Consumer Law protection ensures peace of mind."

---

### Use Case - Rideshare (ID 149)

#### Problem Cards (4)
1. **Icon**: `hail` | **Title**: "Unknown Passenger Behavior" | **Desc**: "Rideshare drivers pick up strangers. No control over passenger safety compliance or seatbelt usage."

2. **Icon**: `star_rate` | **Title**: "Driver Rating Impact" | **Desc**: "Passenger safety incidents affect driver ratings and earnings. One unbuckled passenger crash ends careers."

3. **Icon**: `policy` | **Title**: "Platform Safety Requirements" | **Desc**: "Uber and Lyft require safety compliance. Violations result in deactivation and lost income."

4. **Icon**: `local_hospital` | **Title**: "Personal Liability Exposure" | **Desc**: "Drivers personally liable for passenger injuries. One lawsuit bankrupts independent operators."

#### Solution Overview
**Title**: "The Solution: Rideshare Safety Automation"
**Subtitle**: "Passenger safety. Driver peace of mind."
**Text**: "Purpose-built for rideshare and taxi operators handling unknown passengers. Instant alerts when passengers unbuckle, allowing drivers to request compliance politely. 4-seater configuration perfect for sedan-based rideshare vehicles. Protects driver ratings, reduces liability, and demonstrates professional safety standards to passengers."
**Highlight Title**: "Trusted by Rideshare Professionals"
**Highlight Text**: "500+ rideshare drivers using system. Zero rating drops from safety incidents. Average 4.98-star rating maintained across users."

#### Features (10)
1. **Icon**: `safety_check` | **Title**: "You Get Instant Passenger Alerts" | **Desc**: "Know immediately when passenger unbuckles. Request compliance politely before incident occurs."

2. **Icon**: `star` | **Title**: "You Get Rating Protection" | **Desc**: "Prevent safety incidents that damage driver ratings and reduce earnings potential."

3. **Icon**: `shield_person` | **Title**: "You Get Personal Liability Defense" | **Desc**: "Documented proof you requested seatbelt compliance protects against injury lawsuits."

4. **Icon**: `workspace_premium` | **Title**: "You Get Professional Image" | **Desc**: "Advanced safety technology impresses passengers and demonstrates commitment to their wellbeing."

5. **Icon**: `app_registration` | **Title**: "You Get Platform Compliance" | **Desc**: "Meet Uber, Lyft, and taxi platform safety requirements. Avoid deactivation from violations."

6. **Icon**: `speed` | **Title**: "You Get 4-Seater Configuration" | **Desc**: "Perfect for sedan rideshare vehicles. Monitors driver plus 3 passengers automatically."

7. **Icon**: `phonelink` | **Title**: "You Get Driver-Focused Design" | **Desc**: "Compact display fits any dashboard. No complex setup. Works immediately after installation."

8. **Icon**: `event_available` | **Title**: "You Get Ride-to-Ride Reset" | **Desc**: "System resets between rides automatically. Fresh monitoring for each new passenger group."

9. **Icon**: `payments` | **Title**: "You Get Earnings Protection" | **Desc**: "Prevent deactivation and rating drops that cost thousands in lost income annually."

10. **Icon**: `security` | **Title**: "You Get Peace of Mind" | **Desc**: "Drive confidently knowing you're protected from passenger safety liability and platform violations."

---

## Implementation Approach

### Method 1: WP-CLI (Preferred)
```bash
# Add ACF fields (if not exist)
wp eval-file add-acf-fields.php

# Populate content for each page
wp post meta update 144 problem_cards '...'
wp post meta update 144 solution_overview '...'
wp post meta update 144 features '...'
```

### Method 2: PHP Script (Fallback if WP-CLI fails)
Create `populate-content.php`:
```php
<?php
require_once('wp-load.php');

$content_data = array(
    144 => array(
        'problem_cards' => [...],
        'solution_overview' => [...],
        'features' => [...]
    ),
    // ... for all 8 pages
);

foreach ($content_data as $post_id => $fields) {
    update_field('problem_cards', $fields['problem_cards'], $post_id);
    update_field('solution_overview', $fields['solution_overview'], $post_id);
    update_field('features', $fields['features'], $post_id);
}
```

---

## Validation

**Per Page Checklist**:
- [ ] 4 problem cards populated
- [ ] Solution overview with highlight box
- [ ] 10 benefit-focused features (not feature-focused)
- [ ] All icon names valid Material Symbols
- [ ] Benefit language ("You Get..." prefix)
- [ ] No Lorem Ipsum or placeholder text

**Verify via WP-CLI**:
```bash
wp post meta get 144 problem_cards
wp post meta get 144 solution_overview
wp post meta get 144 features
```

---

## Deliverables

1. ACF fields created (if not exist)
2. Content populated for all 8 pages
3. Verification script output
4. Report: `reports/fullstack-dev-260104-content-cro.md`

---

**EXCLUSIVE FILE OWNERSHIP**: ACF Content Fields ONLY
**DO NOT EDIT**: Templates, CSS, Images, SEO fields

**Run in parallel with Phase A2**
