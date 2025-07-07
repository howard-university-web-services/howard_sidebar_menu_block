# Developer Guide - Howard Sidebar Menu Block

This comprehensive guide covers development, customization, and maintenance of the Howard Sidebar Menu Block module.

## Architecture Overview

The Howard Sidebar Menu Block is designed as a lightweight, efficient navigation solution that leverages Drupal's core menu system to provide contextual sidebar navigation.

### Design Principles

- **Context-Aware Navigation**: Automatically determines menu context based on current page
- **Performance-Oriented**: Minimal database queries and efficient caching
- **Theme-Agnostic**: Clean separation between logic and presentation
- **Extensible**: Multiple hook points for customization
- **Standards-Compliant**: Follows Drupal coding standards and best practices

### Core Architecture

```
Menu Tree API ← Block Plugin → Theme System
      ↑              ↓              ↓
Active Trail    Render Array    Twig Templates
Navigation   →   Processing   →   HTML Output
```

## Development Environment Setup

### Prerequisites

- Drupal 10.0+ or 11.0+ development environment
- PHP 8.1+ with debugging tools
- Composer for dependency management
- Git for version control

### Local Development Setup

```bash
# Clone the repository
git clone https://github.com/howard-university-web-services/howard_sidebar_menu_block.git

# Install dependencies
composer install

# Enable in development environment
drush en howard_sidebar_menu_block --uri=local.dev

# Enable debug mode
drush config-set system.logging error_level verbose
```

### Development Tools

**Recommended Tools**:
- **XDebug**: For step-through debugging
- **Drupal Console**: For code generation
- **PHPCS**: For code standards checking
- **PHPStan**: For static analysis

**Configuration**:
```bash
# Install development dependencies
composer require --dev drupal/core-dev

# Configure PHPCS
vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer
```

## Module Structure Deep Dive

### File Organization

```
howard_sidebar_menu_block/
├── src/
│   └── Plugin/
│       └── Block/
│           └── HowardSidebarMenuBlock.php
├── templates/
│   ├── block--howard-sidebar-menu-block.html.twig
│   └── howard-sidebar-menu--main.html.twig
├── tests/
│   ├── src/
│   │   ├── Unit/
│   │   └── Functional/
├── docs/
│   ├── README.md
│   ├── INSTALL.md
│   ├── API.md
│   └── DEVELOPER.md (this file)
├── howard_sidebar_menu_block.info.yml
├── howard_sidebar_menu_block.module
├── composer.json
└── README.md
```

### Key Components

#### 1. Block Plugin (HowardSidebarMenuBlock.php)

**Purpose**: Core logic for menu tree manipulation and rendering

**Key Responsibilities**:
- Determine current menu context
- Build appropriate menu tree
- Apply access controls and sorting
- Return cached render array

**Extension Points**:
- Custom menu tree manipulators
- Additional caching strategies
- Custom parent detection logic

#### 2. Module File (howard_sidebar_menu_block.module)

**Purpose**: Hook implementations and theme integration

**Key Functions**:
- `howard_sidebar_menu_block_help()`: Provides help text
- `howard_sidebar_menu_block_theme()`: Defines theme hooks

**Extension Points**:
- Additional hook implementations
- Custom theme suggestions
- Preprocess functions

#### 3. Templates

**Purpose**: Presentation layer for menu rendering

**Key Templates**:
- `howard-sidebar-menu--main.html.twig`: Menu structure
- `block--howard-sidebar-menu-block.html.twig`: Block wrapper

## Customization Guide

### Basic Customization

#### 1. Template Overrides

Copy templates to your theme for customization:

```bash
# Copy to your theme
cp modules/contrib/howard_sidebar_menu_block/templates/* themes/custom/your_theme/templates/
```

**Custom Menu Template**:
```twig
{# themes/custom/your_theme/templates/howard-sidebar-menu--main.html.twig #}
{% import _self as menus %}

<nav class="sidebar-navigation" aria-label="Section navigation">
  {{ menus.menu_links(items, attributes, 0) }}
</nav>

{% macro menu_links(items, attributes, menu_level) %}
  {% import _self as menus %}
  {% if items %}
    <ul class="nav-level-{{ menu_level }}"{{ menu_level == 0 ? attributes }}>
    {% for item in items %}
      <li class="nav-item{{ item.in_active_trail ? ' active-trail' : '' }}">
        {% if item.url %}
          <a href="{{ item.url }}" class="nav-link">{{ item.title }}</a>
        {% else %}
          <span class="nav-text">{{ item.title }}</span>
        {% endif %}
        {% if item.below %}
          {{ menus.menu_links(item.below, attributes, menu_level + 1) }}
        {% endif %}
      </li>
    {% endfor %}
    </ul>
  {% endif %}
{% endmacro %}
```

#### 2. CSS Styling

**Basic Styling**:
```css
/* Custom sidebar menu styles */
.sidebar-navigation {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 0.375rem;
  padding: 1rem;
}

.nav-level-0 {
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav-level-1 {
  list-style: none;
  margin: 0.5rem 0 0 1rem;
  padding: 0;
}

.nav-item {
  margin: 0.25rem 0;
}

.nav-link {
  display: block;
  padding: 0.5rem 0.75rem;
  color: #495057;
  text-decoration: none;
  border-radius: 0.25rem;
  transition: all 0.15s ease-in-out;
}

.nav-link:hover {
  background-color: #e9ecef;
  color: #212529;
}

.active-trail > .nav-link {
  background-color: #007bff;
  color: white;
}

.nav-text {
  display: block;
  padding: 0.5rem 0.75rem;
  color: #6c757d;
  font-weight: 600;
}
```

### Advanced Customization

#### 1. Custom Block Plugin

Create a custom block plugin that extends the base functionality:

```php
<?php

namespace Drupal\your_module\Plugin\Block;

use Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock;

/**
 * Custom Howard Sidebar Menu Block.
 *
 * @Block(
 *   id = "custom_howard_sidebar_menu_block",
 *   admin_label = @Translation("Custom Howard Sidebar Menu Block")
 * )
 */
class CustomHowardSidebarMenuBlock extends HowardSidebarMenuBlock {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = parent::build();
    
    // Add custom processing
    $build['#custom_data'] = $this->getCustomData();
    $build['#theme'] = 'custom_howard_sidebar_menu';
    
    return $build;
  }

  /**
   * Get custom data for the menu.
   */
  protected function getCustomData() {
    // Custom logic here
    return [];
  }

}
```

#### 2. Custom Menu Manipulators

Add custom menu tree manipulators:

```php
<?php

namespace Drupal\your_module\MenuTreeManipulator;

use Drupal\Core\Menu\MenuTreeManipulatorInterface;

/**
 * Custom menu tree manipulator.
 */
class CustomMenuTreeManipulator implements MenuTreeManipulatorInterface {

  /**
   * Add custom sorting logic.
   */
  public function customSort(array &$tree) {
    foreach ($tree as &$element) {
      if ($element->subtree) {
        $this->customSort($element->subtree);
      }
    }
    
    // Custom sorting logic
    uasort($tree, function ($a, $b) {
      return strcmp($a->link->getTitle(), $b->link->getTitle());
    });
  }

}
```

#### 3. Theme Hook Suggestions

Add custom theme hook suggestions:

```php
<?php

/**
 * Implements hook_theme_suggestions_HOOK().
 */
function your_theme_theme_suggestions_howard_sidebar_menu(array $variables) {
  $suggestions = [];
  
  // Add suggestions based on current route
  $route_name = \Drupal::routeMatch()->getRouteName();
  if ($route_name) {
    $suggestions[] = 'howard_sidebar_menu__' . str_replace('.', '_', $route_name);
  }
  
  // Add suggestions based on content type
  if ($node = \Drupal::routeMatch()->getParameter('node')) {
    $suggestions[] = 'howard_sidebar_menu__' . $node->getType();
  }
  
  return $suggestions;
}
```

## Testing Procedures

### Unit Testing

**Test File Structure**:
```
tests/
├── src/
│   ├── Unit/
│   │   └── Plugin/
│   │       └── Block/
│   │           └── HowardSidebarMenuBlockTest.php
│   └── Functional/
│       └── HowardSidebarMenuBlockFunctionalTest.php
```

**Unit Test Example**:
```php
<?php

namespace Drupal\Tests\howard_sidebar_menu_block\Unit\Plugin\Block;

use Drupal\Tests\UnitTestCase;
use Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock;

/**
 * Tests the Howard Sidebar Menu Block plugin.
 *
 * @group howard_sidebar_menu_block
 */
class HowardSidebarMenuBlockTest extends UnitTestCase {

  /**
   * Tests the build method.
   */
  public function testBuild() {
    // Mock dependencies
    $block = $this->createMock(HowardSidebarMenuBlock::class);
    
    // Test build method
    $build = $block->build();
    
    // Assertions
    $this->assertIsArray($build);
    $this->assertArrayHasKey('#cache', $build);
  }

}
```

### Functional Testing

**Functional Test Example**:
```php
<?php

namespace Drupal\Tests\howard_sidebar_menu_block\Functional;

use Drupal\Tests\BrowserTestBase;
use Drupal\menu_link_content\Entity\MenuLinkContent;

/**
 * Tests the Howard Sidebar Menu Block functionality.
 *
 * @group howard_sidebar_menu_block
 */
class HowardSidebarMenuBlockFunctionalTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['howard_sidebar_menu_block', 'menu_link_content', 'node'];

  /**
   * Tests block placement and display.
   */
  public function testBlockDisplay() {
    // Create test content
    $this->drupalCreateContentType(['type' => 'page']);
    $node = $this->drupalCreateNode(['type' => 'page', 'title' => 'Test Page']);
    
    // Create menu link
    $menu_link = MenuLinkContent::create([
      'title' => 'Test Page',
      'link' => ['uri' => 'entity:node/' . $node->id()],
      'menu_name' => 'main',
    ]);
    $menu_link->save();
    
    // Place block
    $this->drupalPlaceBlock('howard_sidebar_menu_block');
    
    // Test display
    $this->drupalGet($node->toUrl());
    $this->assertSession()->elementExists('css', '.howard-sidebar-menu');
    $this->assertSession()->linkExists('Test Page');
  }

}
```

### Manual Testing

**Testing Checklist**:
- [ ] Block appears in block library
- [ ] Block can be placed in regions
- [ ] Menu displays on various page types
- [ ] Navigation works correctly
- [ ] Caching functions properly
- [ ] Templates can be overridden
- [ ] Accessibility standards met

## Performance Optimization

### Caching Strategies

#### 1. Block-Level Caching

```php
public function build() {
  $build = [
    '#cache' => [
      'contexts' => ['url', 'user.permissions'],
      'tags' => ['config:menu.main'],
      'max-age' => 3600, // 1 hour
    ],
  ];
  // ... rest of build logic
}
```

#### 2. Template-Level Caching

```twig
{# Cache menu template output #}
{% cache 'sidebar_menu' url.path %}
  {{ menus.menu_links(items, attributes, 0) }}
{% endcache %}
```

### Database Optimization

**Minimize Queries**:
- Use Menu Tree API efficiently
- Limit tree depth with `setMaxDepth()`
- Apply `excludeRoot()` when appropriate
- Use batch processing for large menus

**Example Optimization**:
```php
// Efficient menu loading
$parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
$parameters->setMaxDepth(2); // Limit depth
$parameters->excludeRoot(); // Exclude root item
$tree = $menu_tree->load($menu_name, $parameters);
```

### Memory Management

**Best Practices**:
- Unset large variables when done
- Use generators for large datasets
- Implement lazy loading
- Monitor memory usage in development

## Security Considerations

### Access Control

**Menu Item Access**:
```php
// Use built-in access checking
$manipulators = [
  ['callable' => 'menu.default_tree_manipulators:checkNodeAccess'],
  ['callable' => 'menu.default_tree_manipulators:checkAccess'],
];
```

**Custom Access Checking**:
```php
public function customAccessCheck($menu_item) {
  $account = \Drupal::currentUser();
  
  // Custom access logic
  if (!$account->hasPermission('access custom menu')) {
    return FALSE;
  }
  
  return TRUE;
}
```

### XSS Prevention

**Template Security**:
```twig
{# Always escape user input #}
<a href="{{ item.url|escape }}">{{ item.title|escape }}</a>

{# Use safe filters only when necessary #}
{{ item.description|raw }}
```

**PHP Security**:
```php
// Use proper escaping
$title = Html::escape($menu_item->getTitle());

// Validate URLs
$url = $menu_item->getUrlObject();
if ($url->isExternal()) {
  // Handle external URLs carefully
}
```

## Debugging

### Common Debug Techniques

#### 1. Debug Menu Tree

```php
public function build() {
  // Debug active trail
  $parameters = $menu_tree->getCurrentRouteMenuTreeParameters('main');
  \Drupal::logger('howard_sidebar_menu_block')->debug('Active trail: @trail', [
    '@trail' => print_r($parameters->activeTrail, TRUE),
  ]);
  
  // Continue with normal build...
}
```

#### 2. Template Debugging

```twig
{# Debug template variables #}
{{ dump(items) }}
{{ dump(attributes) }}

{# Debug specific item #}
{% for item in items %}
  <!-- Debug: {{ dump(item) }} -->
  <li>{{ item.title }}</li>
{% endfor %}
```

#### 3. Performance Debugging

```php
// Add timing debug
$start_time = microtime(TRUE);

// ... menu building logic ...

$end_time = microtime(TRUE);
\Drupal::logger('howard_sidebar_menu_block')->debug('Build time: @time seconds', [
  '@time' => $end_time - $start_time,
]);
```

### Common Issues and Solutions

#### Issue: Menu Not Displaying

**Symptoms**: Block appears but no menu items show

**Debug Steps**:
1. Check menu structure in Admin » Structure » Menus
2. Verify menu items are published
3. Check user permissions
4. Enable debug mode and check logs

**Solutions**:
```php
// Debug menu loading
$tree = $menu_tree->load('main', $parameters);
if (empty($tree)) {
  \Drupal::logger('howard_sidebar_menu_block')->warning('Menu tree is empty');
}
```

#### Issue: Wrong Menu Context

**Symptoms**: Shows wrong submenu items

**Debug Steps**:
1. Check active trail detection
2. Verify current route parameters
3. Check menu link relationships

**Solutions**:
```php
// Debug active trail
$route_name = \Drupal::routeMatch()->getRouteName();
$route_parameters = \Drupal::routeMatch()->getRawParameters()->all();
\Drupal::logger('howard_sidebar_menu_block')->debug('Route: @route, Params: @params', [
  '@route' => $route_name,
  '@params' => print_r($route_parameters, TRUE),
]);
```

## Contributing

### Development Workflow

1. **Fork the repository**
2. **Create feature branch**: `git checkout -b feature/your-feature`
3. **Make changes**: Follow coding standards
4. **Write tests**: Add appropriate test coverage
5. **Update documentation**: Keep docs current
6. **Submit pull request**: With clear description

### Code Standards

**PHP Standards**:
- Follow Drupal coding standards
- Use proper docblocks
- Implement proper error handling
- Add appropriate logging

**CSS Standards**:
- Use BEM methodology
- Follow Drupal CSS standards
- Ensure cross-browser compatibility
- Optimize for performance

**JavaScript Standards**:
- Follow Drupal JavaScript standards
- Use ES6+ features appropriately
- Add proper error handling
- Ensure accessibility

### Documentation Standards

- Keep README.md up to date
- Document API changes
- Provide usage examples
- Update version information

---

*This developer guide is maintained alongside the module. For questions or contributions, please refer to the project repository.*
