#!/bin/bash

# AITSC Case Study Creator Script
# Creates a new Case Study with client information and ROI
# Usage: ./create-case-study.sh "Title" "Client Name" "ROI Percentage"

TITLE="$1"
CLIENT="$2"
ROI="$3"

if [ -z "$TITLE" ] || [ -z "$CLIENT" ]; then
    echo "Usage: $0 \"Case Study Title\" \"Client Name\" \"ROI Percentage\""
    echo "Example: $0 \"Financial Transformation Success\" \"Global Bank Corp\" \"325\""
    exit 1
fi

if [ -z "$ROI" ]; then
    ROI="250"
fi

# Get WordPress path
WP_PATH="$(dirname "$0")/../../../"
cd "$WP_PATH"

# Create default case study content
CONTENT="<h2>Challenge</h2>
<p>$CLIENT faced significant challenges in scaling their operations and optimizing workflows.</p>

<h2>Solution</h2>
<p>Our comprehensive AI-powered solution transformed their business processes, resulting in dramatic improvements.</p>

<h2>Results</h2>
<ul>
    <li>$ROI% return on investment</li>
    <li>60% reduction in operational costs</li>
    <li>40% increase in productivity</li>
    <li>100% ROI achieved within 6 months</li>
</ul>

<h2>Technology Stack</h2>
<p>Custom AI algorithms, cloud infrastructure, and advanced analytics platform.</p>"

# Create the case study post
POST_ID=$(wp post create \
    --post_type=case-study \
    --post_title="$TITLE" \
    --post_content="$CONTENT" \
    --post_status=publish \
    --post_author=1 \
    --porcelain)

if [ -n "$POST_ID" ]; then
    # Set case study metadata
    wp post meta update $POST_ID _client_name "$CLIENT"
    wp post meta update $POST_ID _roi_percentage "$ROI"
    wp post meta update $POST_ID _case_industry "Technology"
    wp post meta update $POST_ID _project_duration "6 months"

    echo "✅ Case study created successfully!"
    echo "Post ID: $POST_ID"
    echo "Title: $TITLE"
    echo "Client: $CLIENT"
    echo "ROI: $ROI%"
    echo "View at: $(wp option get home)/case-studies/$POST_ID"
else
    echo "❌ Failed to create case study"
    exit 1
fi