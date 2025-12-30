# MIGRATION_GUIDE.md

## Summary

This migration involved several key steps:

-   **Moved CPTs to plugin `aitsc-core`**: The custom post types (Solutions and Case Studies) have been successfully migrated to the `aitsc-core` plugin, ensuring better modularity and maintainability.
-   **Switched to GP Child Theme**: The active theme has been switched to a GeneratePress Child Theme, providing a robust and flexible foundation for customization.
-   **Created Scaffold Elements**: Basic GeneratePress Elements have been scaffolded for Solutions and Case Studies, preparing the groundwork for layout design.

## Next Steps (Critical)

To complete the migration and restore the display of Solutions and Case Studies, follow these detailed instructions to build out the layouts using GenerateBlocks:

### 1. Single Solution Template

1.  Navigate to `Appearance > Elements` in the WordPress admin.
2.  Edit the element named "Single Solution Template".
3.  **Set Location**:
    -   Under the "Display Rules" section, set the "Location" to `Solution > All Solutions`. This ensures the template applies to all individual Solution posts.
4.  **Build Layout with GenerateBlocks**:
    -   Inside the editor, use GenerateBlocks to design the layout for single solution posts.
    -   **Example Structure**:
        -   Add a `Container` block for overall sectioning.
        -   Inside the container, add a `Grid` block (e.g., 50/50 or 70/30) for content and sidebar.
        -   For the main content area, add a `Headline` block.
        -   **Dynamic Data**: Use the dynamic data options in GenerateBlocks to pull in post information:
            -   For the Solution Title: Select "Post Title".
            -   For other meta (e.g., categories, tags, custom fields): Explore the dynamic data options for "Post Meta" or "Terms".
        -   Add other blocks as needed (e.g., Image, Paragraph, etc.) using dynamic data where appropriate.

### 2. Solution Archive Template

1.  Navigate to `Appearance > Elements` in the WordPress admin.
2.  Edit the element named "Solution Archive Template".
3.  **Set Location**:
    -   Under the "Display Rules" section, set the "Location" to `Solution Archive`. This ensures the template applies to the main Solutions archive page.
4.  **Build Layout with GenerateBlocks**:
    -   Similar to the single template, use GenerateBlocks to design the layout for the Solution archive.
    -   **Example Structure**:
        -   You will typically use a Query Loop block here to display a list of solution posts.
        -   Inside the Query Loop, design the card layout for each solution (e.g., Featured Image, Post Title with dynamic data, Excerpt, Read More button).

### 3. Case Study Templates

Repeat the steps above for Case Studies:

-   **Single Case Study Template**:
    -   Edit "Single Case Study Template".
    -   Set Location to `Case Study > All Case Studies`.
    -   Build the layout using GenerateBlocks, incorporating dynamic data for title and meta.
-   **Case Study Archive Template**:
    -   Edit "Case Study Archive Template".
    -   Set Location to `Case Study Archive`.
    -   Build the layout using GenerateBlocks, typically with a Query Loop for listing case study posts.

## Safety / Rollback

In case of any issues or if a rollback is necessary, a backup of the `wp-content` directory (`wp-content-backup.zip`) and the database (`backup.sql`) are available in the root directory of the WordPress installation. Please do not delete these files until you are certain the migration is complete and stable.