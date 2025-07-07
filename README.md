# Howard Sidebar Menu Block

![Drupal 10](https://img.shields.io/badge/Drupal-10-blue) ![Drupal 11](https://img.shields.io/badge/Drupal-11-blue) ![Version](https://img.shields.io/badge/version-11.0.3-green) ![License](https://img.shields.io/badge/license-GPL--2.0+-blue)

A sophisticated sidebar navigation module for Howard University's Drupal sites that provides intelligent, context-aware menu navigation based on the current page's position in the site hierarchy.

## ✨ Features

- **🎯 Context-Aware Navigation**: Automatically determines current page position and displays relevant submenu items
- **⚡ Performance Optimized**: Efficient menu tree manipulation with intelligent caching
- **🎨 Flexible Theming**: Custom Twig templates with complete design control
- **♿ Accessibility Compliant**: WCAG guidelines support with proper ARIA labels
- **📱 Responsive Design**: Mobile-friendly navigation with responsive breakpoints
- **🔒 Security Focused**: Proper access control and XSS prevention

## 🚀 Quick Start

### Installation

**Composer (Recommended)**:
```bash
composer require howard/howard_sidebar_menu_block
drush en howard_sidebar_menu_block
```

**Manual Installation**:
1. Download from [GitHub releases](https://github.com/howard-university-web-services/howard_sidebar_menu_block/releases)
2. Extract to `modules/contrib/howard_sidebar_menu_block`
3. Enable: `drush en howard_sidebar_menu_block`

### Basic Setup

1. **Enable the module**: Admin → Extend → Howard Sidebar Menu Block
2. **Place the block**: Admin → Structure → Block layout → Place "Howard Sidebar Menu Block"
3. **Configure**: Choose your sidebar region and configure visibility settings

## 📋 Requirements

- **Drupal**: 10.0+ or 11.0+
- **PHP**: 8.1+
- **Dependencies**: Block (Core), Menu (Core)

## 🔧 How It Works

The module intelligently analyzes your current page's position in the main menu hierarchy:

1. **Detects Current Position**: Determines where you are in the menu structure
2. **Finds Parent Context**: Identifies the parent menu item for contextual navigation
3. **Builds Relevant Tree**: Constructs a menu tree showing siblings and children
4. **Renders Contextually**: Displays only relevant navigation options

### Example Behavior

```
Main Menu:                    On "About → History" page, sidebar shows:
├── Home                      ├── History ← (current page)
├── About                     ├── Leadership
│   ├── History              ├── Mission
│   ├── Leadership           └── Contact
│   └── Mission
├── Programs
└── Contact
```

## 📚 Documentation

Comprehensive documentation is available in the [`docs/`](docs/) folder:

- **[📖 Documentation Index](docs/README.md)** - Overview of all documentation
- **[🛠️ Installation Guide](docs/INSTALL.md)** - Detailed setup instructions
- **[⚙️ API Documentation](docs/API.md)** - Technical specifications for developers
- **[👩‍💻 Developer Guide](docs/DEVELOPER.md)** - Customization and development
- **[📝 Changelog](docs/CHANGELOG.md)** - Version history and release notes
- **[📏 Coding Standards](docs/CODING_STANDARDS.md)** - Code quality guidelines
- **[📋 Release Checklist](docs/RELEASE_CHECKLIST.md)** - Release management

## 🎨 Customization

### Template Override

Copy templates to your theme for customization:

```bash
cp modules/contrib/howard_sidebar_menu_block/templates/* themes/your_theme/templates/
```

### CSS Styling

Basic styling example:

```css
.sidebar-menu {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 0.375rem;
  padding: 1rem;
}

.sidebar-menu .nav-link {
  display: block;
  padding: 0.5rem 0.75rem;
  color: #495057;
  text-decoration: none;
}

.sidebar-menu .nav-link:hover {
  background-color: #e9ecef;
}
```

## 🧪 Testing

### Run Tests

```bash
# Unit tests
vendor/bin/phpunit modules/contrib/howard_sidebar_menu_block/tests/src/Unit/

# Functional tests
vendor/bin/phpunit modules/contrib/howard_sidebar_menu_block/tests/src/Functional/
```

### Manual Testing

1. Create a multi-level menu structure
2. Place the sidebar block in a region
3. Navigate to different pages and verify contextual display
4. Test with different user permissions
5. Verify cache invalidation works correctly

## 🔍 Troubleshooting

### Common Issues

**Block not appearing:**
- Check block placement and region configuration
- Verify theme has the target region
- Clear all caches: `drush cr`

**Wrong menu items showing:**
- Verify main menu structure
- Check menu item access permissions
- Review active trail detection

**Performance issues:**
- Enable page caching
- Check for large menu structures (>100 items)
- Monitor memory usage

For detailed troubleshooting, see the [Installation Guide](docs/INSTALL.md#troubleshooting-installation).

## 🤝 Contributing

We welcome contributions! Please see our [Developer Guide](docs/DEVELOPER.md) and [Coding Standards](docs/CODING_STANDARDS.md).

### Development Setup

```bash
git clone https://github.com/howard-university-web-services/howard_sidebar_menu_block.git
composer install
drush en howard_sidebar_menu_block
```

### Code Quality

```bash
# Check coding standards
vendor/bin/phpcs --standard=Drupal,DrupalPractice src/

# Run tests
vendor/bin/phpunit tests/
```

## 📊 Version Information

- **Current Version**: 11.0.3
- **Drupal Compatibility**: 10.0+ | 11.0+
- **Release Date**: July 7, 2025
- **Next Release**: [View Milestone](https://github.com/howard-university-web-services/howard_sidebar_menu_block/milestones)

## 📞 Support

- **🐛 Report Issues**: [GitHub Issues](https://github.com/howard-university-web-services/howard_sidebar_menu_block/issues)
- **💬 Discussions**: [GitHub Discussions](https://github.com/howard-university-web-services/howard_sidebar_menu_block/discussions)
- **📚 Documentation**: [Project Docs](docs/)
- **👨‍💻 Maintainer**: Dan Rogers ([Drupal.org](https://www.drupal.org/u/dan_rogers))

## 📄 License

This project is licensed under the GPL-2.0+ License - see the [LICENSE](LICENSE) file for details.

## 🏛️ About Howard University

This module is developed and maintained by Howard University Web Services for use across Howard University's digital properties. Howard University is a leading research university providing an educational experience of exceptional value to students of high academic standing.

---

**🌟 Star this repository if you find it useful!**
