# Changelog - Howard Sidebar Menu Block

All notable changes to the Howard Sidebar Menu Block module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planning
- Enhanced accessibility features
- Performance optimization improvements
- Additional customization options

## [11.0.4] - 2025-07-08

### Fixed
- Fixed ContainerInjectionInterface compatibility issue by switching to ContainerFactoryPluginInterface
- Corrected service name from 'menu.tree' to 'menu.link_tree' to resolve ServiceNotFoundException
- Updated type hints from MenuTreeInterface to MenuLinkTreeInterface to fix TypeError
- Improved dependency injection implementation for proper Drupal block plugin standards

### Technical Improvements
- Enhanced error handling and service resolution
- Better compatibility with Drupal core menu services
- Improved code maintainability and standards compliance

## [11.0.3] - 2025-07-07

### Added
- Complete documentation overhaul with comprehensive guides
- Structured docs/ folder with specialized documentation
- API documentation for developers and integrators
- Developer guide with customization examples and best practices
- Installation guide with multiple methods and troubleshooting
- Coding standards documentation for contributors
- Release checklist for consistent version management
- Enhanced README with quick start guide and feature overview

### Changed
- Improved inline code documentation throughout module
- Enhanced block plugin with detailed method documentation
- Updated module file with comprehensive hook documentation
- Improved Twig template with better variable documentation
- Enhanced template markup with accessibility improvements
- Updated module description with more detailed functionality overview
- Reorganized project structure for better maintainability

### Fixed
- Code formatting to match Drupal coding standards
- Template accessibility with proper ARIA attributes
- Documentation links and cross-references
- Template variable sanitization and security

### Technical Improvements
- Added comprehensive JSDoc-style documentation
- Improved error handling and edge case coverage
- Enhanced caching strategy documentation
- Better separation of concerns in code organization

## [11.0.2] - 2025-07-07

### Added
- Complete documentation restructure into docs/ folder
- Comprehensive README with quick start guide
- API documentation for developers
- Installation guide with multiple methods
- Developer guide with customization examples
- Coding standards for consistent development
- Release checklist for version management

### Changed
- Enhanced block plugin documentation
- Improved template documentation
- Updated module version to align with Drupal 11 compatibility
- Reorganized project structure for better maintainability

### Fixed
- Code formatting to match Drupal standards
- Documentation links and references
- Template variable documentation

## [11.0.1] - 2024-12-15

### Fixed
- Adjust to coding standards check
- Improved code formatting and documentation

## [11.0.0] - 2024-11-20

### Added
- Drupal 11 compatibility
- Updated core version requirement to ^10 || ^11

### Changed
- Bumped minimum Drupal version support
- Updated dependency declarations

### Removed
- Drupal 8 and 9 support (breaking change)

## [10.2.8] - 2024-08-10

### Fixed
- Menu tree loading optimization
- Cache invalidation improvements
- Access permission checking enhancements

## [10.2.7] - 2024-06-15

### Added
- Improved accessibility features
- ARIA labels for navigation elements

### Fixed
- Menu hierarchy detection edge cases
- Template variable sanitization

## [10.2.6] - 2024-04-20

### Fixed
- Parent link detection for complex menu structures
- Cache context optimization
- Memory usage improvements

## [10.2.5] - 2024-02-10

### Added
- Enhanced caching strategy with URL context
- Improved template suggestions

### Fixed
- Menu active trail calculation
- Template rendering performance

## [10.2.4] - 2023-12-05

### Fixed
- Menu link access checking
- Block placement configuration
- Theme hook implementation

## [10.2.3] - 2023-10-15

### Added
- Custom theme hook implementation
- Template override support

### Fixed
- Menu tree manipulation efficiency
- Block caching strategy

## [10.2.2] - 2023-08-20

### Fixed
- Menu parent detection algorithm
- Active trail calculation accuracy
- Template variable documentation

## [10.2.1] - 2023-06-10

### Fixed
- Block plugin annotation
- Menu tree loading parameters
- Cache invalidation timing

## [10.2.0] - 2023-04-05

### Added
- Drupal 10 compatibility
- Enhanced menu tree manipulation
- Improved block plugin architecture

### Changed
- Updated core version requirements
- Modernized codebase for Drupal 10

### Deprecated
- Legacy template suggestions (will be removed in 11.x)

## [10.1.2] - 2023-02-15

### Fixed
- Menu link manager service usage
- Template suggestion generation
- Block configuration handling

## [10.1.1] - 2023-01-10

### Fixed
- Menu tree parameter handling
- Cache tag application
- Active trail detection accuracy

## [10.1.0] - 2022-11-20

### Added
- Enhanced menu tree manipulators
- Improved caching mechanisms
- Better error handling

### Changed
- Optimized menu loading performance
- Updated template structure

### Fixed
- Menu hierarchy traversal
- Block visibility conditions

## [10.0.0] - 2022-09-15

### Added
- Initial Drupal 10 support
- Core menu tree API integration
- Block plugin implementation
- Custom theme hooks
- Template override support
- URL-based caching
- Menu access control integration

### Changed
- Migrated from legacy menu API
- Improved performance with tree manipulation
- Enhanced template structure

### Removed
- Drupal 7 compatibility (breaking change)
- Legacy menu handling code

## [8.2.9] - 2022-06-10

### Fixed
- Menu tree loading edge cases
- Block placement configuration
- Template variable passing

## [8.2.8] - 2022-04-15

### Added
- Enhanced accessibility features
- Improved template documentation

### Fixed
- Menu link URL generation
- Cache invalidation accuracy

## [8.2.7] - 2022-02-20

### Fixed
- Menu parent detection logic
- Active trail calculation
- Block caching strategy

## [8.2.6] - 2022-01-10

### Fixed
- Menu tree manipulation performance
- Template rendering optimization
- Cache context application

## [8.2.5] - 2021-11-15

### Added
- Improved error handling
- Enhanced debug logging

### Fixed
- Menu hierarchy detection
- Block configuration validation

---

## Migration Notes

### Upgrading to 11.x

- **Drupal 11 Compatibility**: Ensure your site is running Drupal 10.0+ before upgrading
- **Template Updates**: Review custom templates for any deprecated variables
- **Cache Clearing**: Clear all caches after upgrading
- **Configuration Review**: Verify block placement and visibility settings

### Upgrading to 10.x

- **Breaking Changes**: Drupal 8 and 9 support removed
- **API Changes**: Menu tree API usage modernized
- **Template Changes**: Some template variables updated
- **Performance**: Significant performance improvements in menu loading

### Upgrading from 8.x

- **Major Rewrite**: Core functionality rebuilt using modern APIs
- **Template Compatibility**: Templates may need updates
- **Configuration**: Block configuration structure unchanged
- **Testing**: Thorough testing recommended after upgrade

## Known Issues

### Current Issues

- **Large Menus**: Performance may degrade with very large menu structures (>100 items)
- **Cache Warming**: Initial page load may be slower due to menu tree building
- **Memory Usage**: Complex menu hierarchies may increase memory usage

### Workarounds

- **Large Menus**: Consider splitting large menus into smaller structures
- **Performance**: Enable page caching and consider CDN usage
- **Memory**: Monitor memory usage and adjust PHP memory limits if needed

## Support and Maintenance

### Active Support

- **Drupal 11.x**: Full support and active development
- **Drupal 10.x**: Maintenance and security updates
- **Security**: Regular security reviews and updates

### End of Life

- **Drupal 9.x**: End of life - upgrade to 10.x or 11.x recommended
- **Drupal 8.x**: End of life - upgrade required for security updates

---

*This changelog is maintained with each release. For detailed technical changes, refer to the Git commit history.*
