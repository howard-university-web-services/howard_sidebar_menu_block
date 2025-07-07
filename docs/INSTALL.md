# Installation Guide - Howard Sidebar Menu Block

This guide provides comprehensive instructions for installing and configuring the Howard Sidebar Menu Block module.

## Overview

The Howard Sidebar Menu Block creates a dynamic sidebar navigation that automatically displays relevant menu items based on the current page's position in the site hierarchy. It's designed specifically for Howard University's Drupal sites.

## Requirements

### System Requirements

- **Drupal**: 10.0+ or 11.0+
- **PHP**: 8.1 or higher
- **Required Modules**:
  - Block (Core)
  - Menu (Core)

### Recommended Modules

- **Menu UI** (Core): For managing menu structures
- **Path** (Core): For URL alias support

## Installation Methods

### Method 1: Composer (Recommended)

Composer is the preferred method for installing Drupal modules as it handles dependencies automatically.

```bash
# Navigate to your Drupal root directory
cd /path/to/drupal

# Install the module
composer require howard/howard_sidebar_menu_block

# Enable the module
drush en howard_sidebar_menu_block

# Clear caches
drush cr
```

### Method 2: Manual Installation

If you cannot use Composer, you can install manually:

1. **Download the module**:
   - Download from [GitHub releases](https://github.com/howard-university-web-services/howard_sidebar_menu_block/releases)
   - Extract to `modules/contrib/howard_sidebar_menu_block`

2. **Enable the module**:
   ```bash
   drush en howard_sidebar_menu_block
   # OR via UI: Admin » Extend » Check "Howard Sidebar Menu Block" » Install
   ```

3. **Clear caches**:
   ```bash
   drush cr
   ```

### Method 3: Development Installation

For development or customization:

```bash
# Clone the repository
git clone https://github.com/howard-university-web-services/howard_sidebar_menu_block.git

# Move to modules directory
mv howard_sidebar_menu_block modules/contrib/

# Enable the module
drush en howard_sidebar_menu_block

# Clear caches
drush cr
```

## Configuration

### Basic Setup

1. **Enable the Module**:
   - Go to Admin » Extend
   - Find "Howard Sidebar Menu Block" and check the box
   - Click "Install"

2. **Place the Block**:
   - Navigate to Admin » Structure » Block layout
   - Click "Place block" in your desired region (typically sidebar)
   - Search for "Howard Sidebar Menu Block"
   - Click "Place block"

3. **Configure Block Settings**:
   - **Block title**: Leave empty for no title, or set custom title
   - **Visibility settings**: Configure when the block should appear
   - **Region**: Ensure it's in the correct sidebar region

### Advanced Configuration

#### Menu Structure Requirements

The module works best with a well-structured main menu:

```
Main Menu Structure:
├── Home
├── About
│   ├── History
│   ├── Leadership
│   └── Mission
├── Programs
│   ├── Undergraduate
│   ├── Graduate
│   └── Professional
└── Contact
```

#### Block Placement Options

**Recommended Regions**:
- `sidebar_first` - Left sidebar
- `sidebar_second` - Right sidebar
- `content_top` - Above main content

**Visibility Settings**:
- **Pages**: Configure specific pages where block should appear
- **Roles**: Limit to specific user roles if needed
- **Content Types**: Show only on specific content types

### Theme Integration

#### Custom Templates

The module provides custom Twig templates that can be overridden:

**Available Templates**:
- `howard-sidebar-menu--main.html.twig` - Main menu template
- `block--howard-sidebar-menu-block.html.twig` - Block wrapper template

**Template Override Locations**:
```
your_theme/
├── templates/
│   ├── block/
│   │   └── block--howard-sidebar-menu-block.html.twig
│   └── menu/
│       └── howard-sidebar-menu--main.html.twig
```

#### CSS Styling

Add custom CSS to your theme:

```css
/* Basic sidebar menu styling */
.howard-sidebar-menu ul {
  list-style: none;
  padding: 0;
}

.howard-sidebar-menu li {
  margin: 0.5rem 0;
}

.howard-sidebar-menu a {
  display: block;
  padding: 0.5rem 0;
  text-decoration: none;
  border-bottom: 1px solid #eee;
}

.howard-sidebar-menu a:hover {
  background-color: #f5f5f5;
}
```

## Post-Installation Tasks

### 1. Test the Installation

- Navigate to a page with submenu items
- Verify the sidebar menu appears
- Check that navigation works correctly
- Test on different page levels

### 2. Configure Caching

The module implements URL-based caching. Verify caching is working:

```bash
# Check cache configuration
drush config-get system.performance

# Clear caches after configuration changes
drush cr
```

### 3. Set Up Permissions

The module uses standard block permissions:

- **Administer blocks**: For configuring block placement
- **View content**: For viewing menu items

## Verification

### Quick Verification Checklist

- [ ] Module appears in Admin » Extend
- [ ] Block is available in Block layout
- [ ] Block appears in assigned region
- [ ] Menu items display correctly
- [ ] Navigation works as expected
- [ ] Parent/child relationships are maintained
- [ ] Caching is functioning properly

### Testing Different Scenarios

1. **Top-level pages**: Should show submenu items
2. **Second-level pages**: Should show siblings and children
3. **Deep nested pages**: Should show relevant hierarchy
4. **Pages not in menu**: Should show appropriate fallback

## Troubleshooting Installation

### Common Issues

#### Module Not Found
```bash
Error: Module 'howard_sidebar_menu_block' not found
```

**Solution**: Verify module is in correct directory:
```bash
ls modules/contrib/howard_sidebar_menu_block/
```

#### Block Not Appearing
**Possible Causes**:
- Block not placed in visible region
- Visibility settings too restrictive
- Theme doesn't have the target region
- Caching issues

**Solutions**:
```bash
# Clear all caches
drush cr

# Rebuild theme registry
drush php-eval "drupal_theme_rebuild();"

# Check theme regions
drush config-get block.block.howard_sidebar_menu_block
```

#### Menu Not Displaying
**Possible Causes**:
- Main menu is empty
- User doesn't have permission to view menu items
- Menu items are not published

**Solutions**:
- Verify main menu structure in Admin » Structure » Menus
- Check content and menu item permissions
- Ensure menu items link to published content

#### Performance Issues
**Symptoms**:
- Slow page loads
- High memory usage
- Cache misses

**Solutions**:
```bash
# Enable page caching
drush config-set system.performance cache.page.max_age 3600

# Enable block caching
drush config-set system.performance cache.block.max_age 3600

# Clear caches
drush cr
```

### Debug Mode

For troubleshooting, enable debug mode:

```php
// In settings.php
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';
```

### Getting Help

If you encounter issues:

1. **Check the logs**: Admin » Reports » Recent log messages
2. **Review configuration**: Admin » Structure » Block layout
3. **Test with minimal theme**: Switch to Bartik or Claro for testing
4. **Check GitHub issues**: [Module issue queue](https://github.com/howard-university-web-services/howard_sidebar_menu_block/issues)

## Updating

### Composer Updates

```bash
# Update to latest version
composer update howard/howard_sidebar_menu_block

# Enable any new features
drush updb

# Clear caches
drush cr
```

### Manual Updates

1. Download new version
2. Replace module files
3. Run database updates: `drush updb`
4. Clear caches: `drush cr`

## Uninstallation

### Safe Removal

```bash
# Remove block placements first
drush config-delete block.block.howard_sidebar_menu_block

# Disable module
drush pmu howard_sidebar_menu_block

# Remove via Composer
composer remove howard/howard_sidebar_menu_block
```

### Clean Removal

```bash
# Remove configuration
drush config-delete howard_sidebar_menu_block.*

# Clear caches
drush cr
```

---

*For additional support, visit the [project homepage](https://github.com/howard-university-web-services/howard_sidebar_menu_block) or submit an issue.*
