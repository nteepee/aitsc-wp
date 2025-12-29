<?php
/**
 * AITSC Service Content Data
 *
 * Comprehensive content for Australian Industrial Transport Safety Consultants
 * Professional transport safety services with NHVAS accreditation focus
 *
 * @package AITSC_Pro_Theme
 * @since 2.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * AITSC Service Categories and Solutions
 */
function aitsc_get_service_categories() {
    return array(
        'nhvas-accreditation' => array(
            'title' => 'NHVAS Accreditation Services',
            'description' => 'National Heavy Vehicle Accreditation Scheme compliance and accreditation management',
            'icon' => 'dashicons-shield-alt',
            'color' => '#0066cc',
            'services' => array(
                'maintenance-management' => array(
                    'title' => 'Maintenance Management Systems',
                    'description' => 'Comprehensive maintenance management system development and implementation for NHVAS accreditation. Our expert consultants help establish robust maintenance procedures, inspection schedules, and documentation systems that meet all regulatory requirements.',
                    'features' => array(
                        'Maintenance scheduling and tracking systems',
                        'Preventative maintenance programs',
                        'Documentation and record-keeping procedures',
                        'NHVAS compliance assessments',
                        'Staff training and competency verification'
                    ),
                    'pricing' => 'From $2,500',
                    'duration' => '2-4 weeks',
                    'accreditation' => 'NHVAS Base Accreditation'
                ),
                'fatigue-management' => array(
                    'title' => 'Fatigue Management Programs',
                    'description' => 'Advanced fatigue risk management solutions tailored to your operation. We develop comprehensive fatigue management systems that protect drivers and ensure compliance with Heavy Vehicle National Law requirements.',
                    'features' => array(
                        'Risk assessment and hazard identification',
                        'Work diary management systems',
                        'Fatigue monitoring and reporting',
                        'Driver fatigue training programs',
                        'Compliance audits and reviews'
                    ),
                    'pricing' => 'From $3,200',
                    'duration' => '3-6 weeks',
                    'accreditation' => 'NHVAS Fatigue Management'
                ),
                'mass-management' => array(
                    'title' => 'Mass Management & Dimension Compliance',
                    'description' => 'Specialized mass and dimension management systems to ensure your vehicles operate within legal limits while maximizing efficiency and payload capacity.',
                    'features' => array(
                        'Mass management system development',
                        'Vehicle configuration assessments',
                        'Load distribution optimization',
                        'Mass monitoring equipment installation',
                        'Compliance certification and documentation'
                    ),
                    'pricing' => 'From $2,800',
                    'duration' => '2-3 weeks',
                    'accreditation' => 'NHVAS Mass Management'
                )
            )
        ),
        'cor-compliance' => array(
            'title' => 'Chain of Responsibility Compliance',
            'description' => 'Complete Chain of Responsibility (CoR) management systems and training for all parties in the heavy vehicle transport chain',
            'icon' => 'dashicons-networking',
            'color' => '#00aa44',
            'services' => array(
                'cor-risk-management' => array(
                    'title' => 'CoR Risk Management',
                    'description' => 'Comprehensive risk assessment and management systems for Chain of Responsibility compliance. Our consultants identify risks across your entire supply chain and implement effective control measures.',
                    'features' => array(
                        'Supply chain risk assessments',
                        'CoR policy development',
                        'Risk control measure implementation',
                        'Contractor and supplier management',
                        'Incident investigation procedures'
                    ),
                    'pricing' => 'From $3,500',
                    'duration' => '4-6 weeks',
                    'accreditation' => 'CoR Compliance Certification'
                ),
                'heavy-vehicle-law' => array(
                    'title' => 'Heavy Vehicle National Law Compliance',
                    'description' => 'Expert guidance on Heavy Vehicle National Law (HVNL) compliance requirements and obligations for all parties in the transport chain.',
                    'features' => array(
                        'HVNL compliance audits',
                        'Legal obligation assessments',
                        'Policy and procedure development',
                        'Regulatory update services',
                        'NHVR liaison and representation'
                    ),
                    'pricing' => 'From $2,200',
                    'duration' => '2-4 weeks',
                    'accreditation' => 'HVNL Compliance'
                )
            )
        ),
        'transport-safety' => array(
            'title' => 'Transport Safety Consulting',
            'description' => 'Specialized transport safety consulting services covering risk management, safety audits, and regulatory compliance',
            'icon' => 'dashicons-lock',
            'color' => '#cc6600',
            'services' => array(
                'risk-assessment' => array(
                    'title' => 'Transport Risk Assessment & Management',
                    'description' => 'Thorough risk assessments and management system development for transport operations. We identify hazards, assess risks, and implement practical control measures.',
                    'features' => array(
                        'Comprehensive risk assessments',
                        'Hazard identification and analysis',
                        'Risk control measure development',
                        'Safety management system implementation',
                        'Ongoing monitoring and review'
                    ),
                    'pricing' => 'From $2,800',
                    'duration' => '3-5 weeks',
                    'accreditation' => 'ISO 45001 Safety Management'
                ),
                'safety-audits' => array(
                    'title' => 'Safety Audit Preparation',
                    'description' => 'Professional safety audit preparation and compliance management to ensure your transport operations meet all regulatory requirements and industry standards.',
                    'features' => array(
                        'Pre-audit gap analysis',
                        'Compliance documentation preparation',
                        'Safety system reviews',
                        'Corrective action planning',
                        'Audit support and representation'
                    ),
                    'pricing' => 'From $1,800',
                    'duration' => '1-3 weeks',
                    'accreditation' => 'Safety Audit Certification'
                ),
                'incident-investigation' => array(
                    'title' => 'Incident Investigation Services',
                    'description' => 'Professional incident investigation services to identify root causes and develop preventive measures for future incidents.',
                    'features' => array(
                        'Comprehensive incident investigations',
                        'Root cause analysis',
                        'Corrective action recommendations',
                        'Investigation report preparation',
                        'Preventive measure implementation'
                    ),
                    'pricing' => 'From $2,500 per incident',
                    'duration' => '1-2 weeks',
                    'accreditation' => 'Investigation Certification'
                )
            )
        ),
        'driver-training' => array(
            'title' => 'Driver Training & Certification',
            'description' => 'Professional driver training programs covering safety, compliance, and operational requirements for Australian transport',
            'icon' => 'dashicons-education',
            'color' => '#9966cc',
            'services' => array(
                'heavy-vehicle-training' => array(
                    'title' => 'Heavy Vehicle Driver Training',
                    'description' => 'Comprehensive training programs for heavy vehicle drivers covering safety, compliance, and operational best practices.',
                    'features' => array(
                        'Defensive driving techniques',
                        'Vehicle inspection procedures',
                        'Load restraint training',
                        'Fatigue management education',
                        'Emergency response procedures'
                    ),
                    'pricing' => 'From $450 per driver',
                    'duration' => '2-5 days',
                    'accreditation' => 'Heavy Vehicle Certification'
                ),
                'cor-training' => array(
                    'title' => 'Chain of Responsibility Training',
                    'description' => 'Specialized CoR training for all parties in the transport chain, including drivers, schedulers, managers, and executives.',
                    'features' => array(
                        'CoR obligations and responsibilities',
                        'Risk management in transport',
                        'Compliance monitoring procedures',
                        'Documentation requirements',
                        'Incident reporting protocols'
                    ),
                    'pricing' => 'From $280 per participant',
                    'duration' => '1 day',
                    'accreditation' => 'CoR Training Certification'
                )
            )
        )
    );
}

/**
 * AITSC Case Studies
 */
function aitsc_get_case_studies() {
    return array(
        'mining-logistics' => array(
            'title' => 'Mining Equipment Transport Safety System',
            'client' => 'Australian Mining Logistics',
            'industry' => 'Mining & Heavy Equipment',
            'duration' => '6 months',
            'location' => 'Western Australia',
            'challenge' => 'Client required a comprehensive transport safety system for oversized mining equipment movements across remote Western Australian roads, with complex regulatory requirements and multiple stakeholder coordination.',
            'solution' => 'Developed and implemented a complete transport safety management system including route planning procedures, risk assessment methodologies, stakeholder communication protocols, and emergency response plans. Provided specialized training for escort vehicle operators and project managers.',
            'results' => array(
                array('label' => 'Zero incidents', 'value' => '0 recordable incidents in 18 months'),
                array('label' => 'Compliance rate', 'value' => '100% regulatory compliance'),
                array('label' => 'Efficiency improvement', 'value' => '35% reduction in movement times'),
                array('label' => 'Client satisfaction', 'value' => '98% satisfaction score')
            ),
            'testimonial' => 'AITSC transformed our approach to mining equipment transport. Their expertise in heavy vehicle regulations and practical safety solutions has been invaluable to our operations.',
            'testimonial_author' => 'Operations Manager, Australian Mining Logistics',
            'featured' => true
        ),
        'food-distribution' => array(
            'title' => 'Food Distribution Chain of Responsibility',
            'client' => 'National Food Distributors',
            'industry' => 'Food & Beverage Distribution',
            'duration' => '4 months',
            'location' => 'National',
            'challenge' => 'National food distribution company required comprehensive Chain of Responsibility compliance across multiple states with different regulatory requirements and hundreds of subcontractors.',
            'solution' => 'Implemented a national CoR management system including standardized policies and procedures, contractor compliance monitoring, training programs for all supply chain parties, and digital compliance tracking systems.',
            'results' => array(
                array('label' => 'Compliance improvement', 'value' => '92% reduction in compliance issues'),
                array('label' => 'Contractor performance', 'value' => '87% improvement in contractor compliance'),
                array('label' => 'Training completion', 'value' => '100% staff training completion'),
                array('label' => 'Audit results', 'value' => 'Zero major findings in NHVR audit')
            ),
            'testimonial' => 'The CoR system developed by AITSC has revolutionized our compliance management. We now have complete visibility and control across our entire supply chain.',
            'testimonial_author' => 'Compliance Manager, National Food Distributors',
            'featured' => true
        ),
        'construction-fleet' => array(
            'title' => 'Construction Fleet NHVAS Accreditation',
            'client' => 'Major Construction Group',
            'industry' => 'Construction & Infrastructure',
            'duration' => '3 months',
            'location' => 'Victoria',
            'challenge' => 'Large construction company required NHVAS accreditation for their mixed fleet of vehicles operating across multiple construction sites with varying requirements and tight project deadlines.',
            'solution' => 'Provided comprehensive NHVAS accreditation support including maintenance management system development, fatigue management program implementation, mass management procedures, and staff training. Delivered project-specific accreditation packages for different site requirements.',
            'results' => array(
                array('label' => 'Accreditation success', 'value' => '100% first-time accreditation success'),
                array('label' => 'Implementation timeline', 'value' => 'Completed 2 weeks ahead of schedule'),
                array('label' => 'Cost savings', 'value' => '$120K annual compliance cost reduction'),
                array('label' => 'Safety improvement', 'value' => '45% reduction in safety incidents')
            ),
            'testimonial' => 'AITSC delivered exceptional results in achieving our NHVAS accreditation. Their practical approach and deep regulatory knowledge made the complex process straightforward and efficient.',
            'testimonial_author' => 'Fleet Manager, Major Construction Group',
            'featured' => true
        ),
        'waste-management' => array(
            'title' => 'Waste Management Fleet Safety Overhaul',
            'client' => 'Regional Waste Services',
            'industry' => 'Waste Management & Recycling',
            'duration' => '5 months',
            'location' => 'New South Wales',
            'challenge' => 'Regional waste management company needed to upgrade their safety systems to meet new regulatory requirements and improve their safety performance across a diverse fleet operating in challenging urban and rural environments.',
            'solution' => 'Conducted comprehensive safety audit, developed customized safety management system, implemented driver training programs, upgraded vehicle inspection procedures, and established performance monitoring systems.',
            'results' => array(
                array('label' => 'Safety performance', 'value' => '78% reduction in incidents'),
                array('label' => 'Insurance savings', 'value' => '$85K annual premium reduction'),
                array('label' => 'Compliance rate', 'value' => '100% regulatory compliance'),
                array('label' => 'Staff engagement', 'value' => '94% staff satisfaction with new systems')
            ),
            'testimonial' => 'The safety transformation delivered by AITSC has exceeded our expectations. Their practical solutions and ongoing support have created a sustainable safety culture in our organization.',
            'testimonial_author' => 'Safety Manager, Regional Waste Services',
            'featured' => false
        ),
        'livestock-transport' => array(
            'title' => 'Livestock Transport Animal Welfare & Safety',
            'client' => 'Australian Livestock Transport',
            'industry' => 'Agriculture & Livestock',
            'duration' => '4 months',
            'location' => 'Queensland',
            'challenge' => 'Livestock transport company needed to balance animal welfare requirements with driver safety and regulatory compliance across long-distance routes with varying conditions.',
            'solution' => 'Developed integrated safety and animal welfare management system including driver training for animal handling, route planning for animal welfare, emergency response procedures, and compliance monitoring systems.',
            'results' => array(
                array('label' => 'Animal welfare compliance', 'value' => '100% animal welfare standards compliance'),
                array('label' => 'Driver safety', 'value' => '62% reduction in driver safety incidents'),
                array('label' => 'Route efficiency', 'value' => '28% improvement in route planning'),
                array('label' => 'Client retention', 'value' => '96% client retention rate')
            ),
            'testimonial' => 'AITSC\'s expertise in both transport safety and animal welfare requirements has been instrumental in improving our operations and maintaining our industry reputation.',
            'testimonial_author' => 'Managing Director, Australian Livestock Transport',
            'featured' => false
        )
    );
}

/**
 * AITSC Team Members
 */
function aitsc_get_team_members() {
    return array(
        array(
            'name' => 'Michael Thompson',
            'title' => 'Principal Transport Safety Consultant',
            'experience' => '15+ years',
            'specializations' => array('NHVAS Accreditation', 'Chain of Responsibility', 'Risk Management'),
            'qualifications' => array('Bachelor of Transport Management', 'Certified Safety Professional', 'NHVAS Accredited Auditor'),
            'bio' => 'Michael leads AITSC\'s consulting practice with over 15 years of experience in transport safety and regulatory compliance. He has successfully guided over 200 companies through NHVAS accreditation and CoR compliance implementations.',
            'certifications' => array('NHVAS Base Accreditation', 'NHVAS Fatigue Management', 'NHVAS Mass Management', 'ISO 45001 Lead Auditor')
        ),
        array(
            'name' => 'Sarah Richardson',
            'title' => 'Senior Compliance Consultant',
            'experience' => '12+ years',
            'specializations' => array('Heavy Vehicle Law', 'Compliance Auditing', 'Training Development'),
            'qualifications' => array('Master of Laws (Transport Law)', 'Certified Compliance Professional', 'Diploma of Transport Safety'),
            'bio' => 'Sarah specializes in Heavy Vehicle National Law compliance and has extensive experience in developing compliance management systems for transport companies of all sizes. She has represented clients in numerous NHVR investigations and audits.',
            'certifications' => array('CoR Compliance Certification', 'Workplace Health and Safety', 'Training and Assessment')
        ),
        array(
            'name' => 'David Chen',
            'title' => 'Fatigue Management Specialist',
            'experience' => '10+ years',
            'specializations' => array('Fatigue Risk Management', 'Driver Training', 'Human Factors'),
            'qualifications' => array('Bachelor of Psychology (Industrial)', 'Certified Fatigue Management Practitioner', 'Diploma of Training Design'),
            'bio' => 'David is a recognized expert in fatigue management and human factors in transport operations. He has developed innovative fatigue monitoring systems and training programs that have been adopted by major transport companies nationwide.',
            'certifications' => array('NHVAS Fatigue Management', 'Advanced Fatigue Management', 'Psychology Registration')
        ),
        array(
            'name' => 'Emma Wilson',
            'title' => 'Maintenance Management Consultant',
            'experience' => '8+ years',
            'specializations' => array('Maintenance Systems', 'Vehicle Inspection', 'Quality Assurance'),
            'qualifications' => array('Bachelor of Engineering (Mechanical)', 'Certified Maintenance Professional', 'Heavy Vehicle Diagnostic Certification'),
            'bio' => 'Emma brings engineering expertise to maintenance management consulting, helping clients develop efficient and compliant maintenance systems. She has experience with diverse vehicle fleets and has saved clients millions through optimized maintenance programs.',
            'certifications' => array('NHVAS Maintenance Management', 'Heavy Vehicle Inspection', 'Quality Management Systems')
        ),
        array(
            'name' => 'James Patterson',
            'title' => 'Training & Development Manager',
            'experience' => '14+ years',
            'specializations' => array('Driver Training', 'Curriculum Development', 'Safety Culture'),
            'qualifications' => array('Bachelor of Education', 'Certified Trainer and Assessor', 'Advanced Driver Training Certification'),
            'bio' => 'James oversees AITSC\'s training programs and has developed industry-leading curriculum for transport safety and compliance. He has trained over 5,000 transport professionals and is a sought-after speaker at industry conferences.',
            'certifications' => array('Certificate IV in Training and Assessment', 'Heavy Vehicle Driver Training', 'Workplace Training and Assessment')
        )
    );
}

/**
 * AITSC Service Statistics
 */
function aitsc_get_service_statistics() {
    return array(
        'years_experience' => 20,
        'clients_served' => 500,
        'accreditations_achieved' => 1000,
        'audits_passed' => 98,
        'safety_improvement' => 75,
        'states_covered' => 8,
        'industries_served' => 15
    );
}

/**
 * AITSC Industries Served
 */
function aitsc_get_industries_served() {
    return array(
        'Mining & Resources' => 'Specialized safety solutions for mining equipment transport and remote operations',
        'Construction & Infrastructure' => 'Fleet safety and compliance for construction vehicles and equipment',
        'Food & Beverage Distribution' => 'Cold chain safety and CoR compliance for food transport',
        'Agriculture & Primary Industries' => 'Specialized requirements for agricultural transport and livestock',
        'Waste Management & Recycling' => 'Urban and regional waste collection safety systems',
        'Logistics & 3PL' => 'Comprehensive safety solutions for third-party logistics providers',
        'Manufacturing & Distribution' => 'Supply chain safety and warehouse transport compliance',
        'Government & Municipal Services' => 'Public sector transport safety and compliance requirements'
    );
}

/**
 * AITSC Contact Information
 */
function aitsc_get_contact_info() {
    return array(
        'phone' => '1300 247 872',
        'phone_display' => '1300 AITSC',
        'email' => 'info@aitsc.com.au',
        'address' => 'Level 2, 123 Transport Street, Melbourne, VIC 3000',
        'abn' => '123 456 789 000',
        'accredited_number' => 'NHVA-12345',
        'business_hours' => 'Monday to Friday: 8:00 AM - 5:00 PM EST',
        'emergency_contact' => 'Emergency: 1800 247 873',
        'service_areas' => array(
            'New South Wales',
            'Victoria',
            'Queensland',
            'South Australia',
            'Western Australia',
            'Tasmania',
            'Australian Capital Territory',
            'Northern Territory'
        )
    );
}