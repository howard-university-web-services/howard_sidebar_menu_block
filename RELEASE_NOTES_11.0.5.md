# Release Notes - Howard Sidebar Menu Block v11.0.5

**Release Date:** July 8, 2025

## Summary

This release configures the Howard Sidebar Menu Block module for distribution via Packagist instead of Drupal.org, improving the installation and dependency management experience for custom Drupal sites.

## 🔧 Configuration Changes

### Packagist Distribution Setup
- **Updated composer.json metadata**: Enhanced with comprehensive package information for Packagist distribution
- **Removed Drupal.org dependencies**: Cleaned up .info.yml by removing project-specific metadata 
- **Added security coverage information**: Clearly indicates this is a custom module not covered by Drupal Security Team
- **Updated stability requirements**: Changed minimum-stability to "stable" with prefer-stable configuration
- **Enhanced package metadata**: Added better keywords, support links, and documentation references

### Technical Improvements
- Updated datestamp to reflect current release
- Added Howard University Web Services as co-developer in composer.json
- Improved package description and keywords for better discoverability
- Added explicit Drupal core version requirements
- Enhanced support section with documentation links

## 📋 Affected Files

- `composer.json` - Complete metadata overhaul for Packagist distribution
- `howard_sidebar_menu_block.info.yml` - Removed Drupal.org-specific metadata
- `docs/CHANGELOG.md` - Updated with release information

## 🔧 Installation

### For New Installations
```bash
composer require howard/howard_sidebar_menu_block:^11.0.5
drush en howard_sidebar_menu_block
```

### For Existing Installations
```bash
composer update howard/howard_sidebar_menu_block
drush cr
```

## ⚠️ Important Notes

- **Distribution Change**: This module is now distributed via Packagist instead of Drupal.org
- **No Functional Changes**: All existing functionality remains exactly the same
- **No Configuration Changes**: No updates to existing block configurations required
- **Composer Compatibility**: Enhanced composer.json provides better dependency resolution
- **Security Notice**: Custom module - not covered by Drupal Security Team (clearly documented)

## 🧪 Testing

- All existing functionality remains unchanged
- No new testing requirements beyond standard installation verification
- Compatible with existing sites using previous versions

## 📖 Documentation

- Updated package metadata reflects Packagist distribution
- Enhanced composer.json provides clear package information
- All existing documentation remains valid

## 🔄 Upgrade Path

1. Update via Composer: `composer update howard/howard_sidebar_menu_block`
2. Clear caches: `drush cr`
3. No additional configuration required

## 🎯 Next Steps

With Packagist distribution configured, future releases will be automatically available via Composer for easier dependency management and version control.

---

**Full Changelog**: [View on GitHub](https://github.com/howard-university-web-services/howard_sidebar_menu_block/blob/main/docs/CHANGELOG.md)
