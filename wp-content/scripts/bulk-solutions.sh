#!/bin/bash

# AITSC Bulk Solutions Creator
# Creates 5 sample solutions automatically
# Usage: ./bulk-solutions.sh

# Get WordPress path
WP_PATH="$(dirname "$0")/../../../"
cd "$WP_PATH"

echo "🚀 Creating bulk sample solutions..."
echo ""

# Define solutions data
declare -a SOLUTIONS=(
    "Enterprise AI Platform|Comprehensive AI platform for enterprise-scale operations with predictive analytics"
    "Healthcare Analytics Suite|Advanced analytics platform for medical data processing and patient care optimization"
    "Financial Modeling Tools|AI-powered financial modeling and risk assessment system for investment firms"
    "Supply Chain Optimizer|Machine learning solution for supply chain optimization and demand forecasting"
    "Customer Intelligence Hub|AI-driven customer analytics and personalization platform for e-commerce"
)

# Create each solution
for solution in "${SOLUTIONS[@]}"; do
    TITLE=$(echo "$solution" | cut -d'|' -f1)
    DESC=$(echo "$solution" | cut -d'|' -f2)

    echo "Creating: $TITLE"

    POST_ID=$(wp post create \
        --post_type=solution \
        --post_title="$TITLE" \
        --post_content="$DESC" \
        --post_status=publish \
        --post_author=1 \
        --porcelain)

    if [ -n "$POST_ID" ]; then
        # Add relevant metadata based on solution type
        case "$TITLE" in
            *Enterprise*)
                wp post meta update $POST_ID _solution_industry "Enterprise"
                wp post meta update $POST_ID _solution_tech_stack "AI, Cloud, Analytics"
                ;;
            *Healthcare*)
                wp post meta update $POST_ID _solution_industry "Healthcare"
                wp post meta update $POST_ID _solution_tech_stack "AI, Medical Analytics, HIPAA"
                ;;
            *Financial*)
                wp post meta update $POST_ID _solution_industry "Finance"
                wp post meta update $POST_ID _solution_tech_stack "AI, Risk Analysis, Trading"
                ;;
            *Supply*)
                wp post meta update $POST_ID _solution_industry "Logistics"
                wp post meta update $POST_ID _solution_tech_stack "AI, IoT, Optimization"
                ;;
            *Customer*)
                wp post meta update $POST_ID _solution_industry "Retail"
                wp post meta update $POST_ID _solution_tech_stack "AI, ML, Personalization"
                ;;
        esac

        wp post meta update $POST_ID _solution_difficulty "Enterprise"

        echo "  ✅ Created (ID: $POST_ID)"
    else
        echo "  ❌ Failed to create"
    fi
    echo ""
done

echo "✨ Bulk solutions creation complete!"
echo ""
echo "View all solutions at: $(wp option get home)/solutions/"