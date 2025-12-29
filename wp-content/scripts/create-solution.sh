#!/bin/bash

# AITSC Solution Creator Script
# Creates a new Solution post with proper metadata
# Usage: ./create-solution.sh "Title" "Description"

TITLE="$1"
DESCRIPTION="$2"

if [ -z "$TITLE" ]; then
    echo "Usage: $0 \"Solution Title\" \"Solution Description\""
    echo "Example: $0 \"Enterprise AI Platform\" \"Comprehensive AI solution for large enterprises\""
    exit 1
fi

if [ -z "$DESCRIPTION" ]; then
    DESCRIPTION="Industry-leading solution powered by advanced AI technology."
fi

# Get WordPress path
WP_PATH="$(dirname "$0")/../../../"
cd "$WP_PATH"

# Create the solution post
POST_ID=$(wp post create \
    --post_type=solution \
    --post_title="$TITLE" \
    --post_content="$DESCRIPTION" \
    --post_status=publish \
    --post_author=1 \
    --porcelain)

if [ -n "$POST_ID" ]; then
    # Set default metadata for solutions
    wp post meta update $POST_ID _solution_industry "Technology"
    wp post meta update $POST_ID _solution_tech_stack "AI, Machine Learning"
    wp post meta update $POST_ID _solution_difficulty "Advanced"

    echo "✅ Solution created successfully!"
    echo "Post ID: $POST_ID"
    echo "Title: $TITLE"
    echo "View at: $(wp option get home)/?p=$POST_ID"
else
    echo "❌ Failed to create solution"
    exit 1
fi