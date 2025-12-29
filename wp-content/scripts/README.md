# AITSC WP-CLI Content Automation Scripts

Quick reference guide for AITSC Pro Theme content management.

## Scripts Overview

### 1. create-solution.sh
Creates a new Solution post with metadata.

```bash
./create-solution.sh "Title" "Description"
```

**Example:**
```bash
./create-solution.sh "AI Risk Management" "Advanced AI-powered risk assessment system"
```

### 2. create-case-study.sh
Creates a new Case Study with client information and ROI.

```bash
./create-case-study.sh "Title" "Client Name" "ROI %"
```

**Example:**
```bash
./create-case-study.sh "Banking AI Success" "National Bank" "350"
```

### 3. bulk-solutions.sh
Creates 5 sample solutions automatically.

```bash
./bulk-solutions.sh
```

## Useful WP-CLI Commands

### View Content
```bash
# List all solutions
wp post list --post_type=solution

# List all case studies
wp post list --post_type=case-study

# Get post count by type
wp post count --post_type=solution
wp post count --post_type=case-study
```

### Manage Content
```bash
# Delete a post
wp post delete 123 --force

# Update post status
wp post update 123 --post_status=draft

# Bulk delete all solutions (use with caution!)
wp post delete $(wp post list --post_type=solution --format=ids) --force
```

### Database Operations
```bash
# Export database
wp db export backup-$(date +%Y%m%d).sql

# Search and replace
wp search-replace "old-text" "new-text"

# Clear caches
wp cache flush
```

## File Permissions

Make scripts executable:
```bash
chmod +x *.sh
```

## Quick Start

1. Create a solution:
   ```bash
   ./create-solution.sh "Custom AI Solution" "Tailored AI implementation"
   ```

2. Create a case study:
   ```bash
   ./create-case-study.sh "Client Success Story" "Tech Corp" "275"
   ```

3. View results:
   - Solutions: `http://localhost:8888/aitsc-wp/solutions/`
   - Case Studies: `http://localhost:8888/aitsc-wp/case-studies/`

## Support

For issues or questions, check WordPress admin or review the AITSC Pro Theme documentation.