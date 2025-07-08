# Release Notes - Howard Sidebar Menu Block v11.0.4

**Release Date:** July 8, 2025

## Summary

This is a critical bug fix release that resolves fatal errors and compatibility issues with Drupal's dependency injection system.

## 🐛 Bug Fixes

### Critical Fixes
- **Fixed ContainerInjectionInterface compatibility**: Switched from `ContainerInjectionInterface` to `ContainerFactoryPluginInterface` to resolve fatal error about incompatible method signatures
- **Corrected service name**: Changed from `menu.tree` to `menu.link_tree` to resolve `ServiceNotFoundException`
- **Fixed type hints**: Updated from `MenuTreeInterface` to `MenuLinkTreeInterface` to resolve `TypeError`

### Technical Improvements
- Enhanced dependency injection implementation for proper Drupal block plugin standards
- Improved error handling and service resolution
- Better compatibility with Drupal core menu services
- Enhanced code maintainability and standards compliance

## 📋 Affected Files

- `src/Plugin/Block/HowardSidebarMenuBlock.php` - Main block plugin implementation
- `howard_sidebar_menu_block.info.yml` - Updated version and datestamp
- `README.md` - Updated version badge
- `docs/CHANGELOG.md` - Added release notes

## 🔧 Installation

### For New Installations
```bash
composer require howard/howard_sidebar_menu_block:^11.0.4
drush en howard_sidebar_menu_block
```

### For Existing Installations
```bash
composer update howard/howard_sidebar_menu_block
drush cr
```

## ⚠️ Important Notes

- This release fixes fatal errors that would prevent the module from loading
- No breaking changes to existing functionality
- No configuration changes required
- Fully compatible with Drupal 10 and 11

## 🧪 Testing

- [x] PHP syntax validation passed
- [x] Module loads without fatal errors
- [x] Block placement and configuration working
- [x] Menu tree generation functioning properly
- [x] Dependency injection working correctly

## 📚 Documentation

Full documentation available in the `docs/` folder:
- [Installation Guide](docs/INSTALL.md)
- [Developer Guide](docs/DEVELOPER.md)
- [API Documentation](docs/API.md)
- [Complete Changelog](docs/CHANGELOG.md)

## 🤝 Support

- **Issues**: [GitHub Issues](https://github.com/howard-university-web-services/howard_sidebar_menu_block/issues)
- **Source**: [GitHub Repository](https://github.com/howard-university-web-services/howard_sidebar_menu_block)
- **Maintainer**: Dan Rogers

---

**Previous Version:** 11.0.3  
**Current Version:** 11.0.4  
**Next Planned Version:** 11.0.5 (TBD)
