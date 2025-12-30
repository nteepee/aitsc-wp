# Phase 4: Backup Deletion Strategy

**Objective**: Remove clutter and confusion by deleting backup files and folders.
**Dependencies**: None.
**Output**: Cleaner directory structure.

## Targets
- Directory: `wp-content/themes/aitsc-pro-theme/components-dark-backup/`
- Directory: `wp-content/themes/aitsc-pro-theme/assets_legacy_backup/`
- File: `wp-content/themes/aitsc-pro-theme/style.css.dark-backup`
- File: `wp-content/themes/aitsc-pro-theme/PHASE3-IMPLEMENTATION-COMPLETE.md` (if obsolete)
- Any other `*.bak` or `*.backup` files found in theme root.

## Action Items

1.  **Verify Content**
    *   Briefly check if `assets_legacy_backup` contains anything NOT migrated. (Assumption: All valid assets are in `assets/`).
    *   Briefly check `components-dark-backup` (Should be obsolete dark mode versions).

2.  **Delete**
    *   Execute deletion commands.

3.  **Validation**
    *   `ls -R` to confirm absence.

## Execution Steps

```bash
rm -rf wp-content/themes/aitsc-pro-theme/components-dark-backup/
rm -rf wp-content/themes/aitsc-pro-theme/assets_legacy_backup/
rm wp-content/themes/aitsc-pro-theme/style.css.dark-backup
```
