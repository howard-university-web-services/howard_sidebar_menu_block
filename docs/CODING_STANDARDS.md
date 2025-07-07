# Coding Standards - Howard Sidebar Menu Block

This document outlines the coding standards and best practices for the Howard Sidebar Menu Block module. All contributors should follow these guidelines to ensure consistent, maintainable, and high-quality code.

## Overview

The Howard Sidebar Menu Block follows Drupal's official coding standards and includes additional project-specific guidelines for optimal development workflow.

## PHP Coding Standards

### Drupal PHP Standards

Follow the [Drupal PHP Coding Standards](https://www.drupal.org/docs/develop/standards/php):

**File Structure**:
```php
<?php

namespace Drupal\howard_sidebar_menu_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a Howard Sidebar Menu Block.
 *
 * @Block(
 *   id = "howard_sidebar_menu_block",
 *   admin_label = @Translation("Howard Sidebar Menu Block"),
 *   category = @Translation("Menus")
 * )
 */
class HowardSidebarMenuBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Implementation here.
  }

}
```

**Key Requirements**:
- Use 2-space indentation
- No trailing whitespace
- Unix line endings (LF)
- UTF-8 encoding without BOM
- Maximum line length of 80 characters
- Proper namespace declarations
- Complete docblock comments

### Documentation Standards

**Class Documentation**:
```php
/**
 * Provides a Howard Sidebar Menu Block.
 *
 * This block creates a contextual sidebar navigation based on the current
 * page's position in the main menu hierarchy.
 *
 * @Block(
 *   id = "howard_sidebar_menu_block",
 *   admin_label = @Translation("Howard Sidebar Menu Block"),
 *   category = @Translation("Menus")
 * )
 */
```

**Method Documentation**:
```php
/**
 * Builds the sidebar menu render array.
 *
 * @return array
 *   A render array containing the sidebar menu with caching metadata.
 */
public function build() {
  // Implementation.
}
```

**Property Documentation**:
```php
/**
 * The menu tree service.
 *
 * @var \Drupal\Core\Menu\MenuTreeInterface
 */
protected $menuTree;
```

### Error Handling

**Exception Handling**:
```php
try {
  $menu_tree = \Drupal::menuTree();
  $parameters = $menu_tree->getCurrentRouteMenuTreeParameters('main');
}
catch (\Exception $e) {
  \Drupal::logger('howard_sidebar_menu_block')->error('Menu tree loading failed: @message', [
    '@message' => $e->getMessage(),
  ]);
  return [];
}
```

**Validation**:
```php
/**
 * Validates menu parameters.
 *
 * @param array $parameters
 *   The menu parameters to validate.
 *
 * @return bool
 *   TRUE if parameters are valid, FALSE otherwise.
 */
protected function validateParameters(array $parameters) {
  if (empty($parameters['menu_name'])) {
    return FALSE;
  }
  
  return TRUE;
}
```

## Twig Template Standards

### Template Structure

**File Header**:
```twig
{#
/**
 * @file
 * Template for the Howard Sidebar Menu.
 *
 * Available variables:
 * - items: Nested list of menu items
 * - attributes: HTML attributes for the menu container
 * - menu_name: Machine name of the menu
 *
 * Each menu item contains:
 * - title: The menu link title
 * - url: The menu link URL object
 * - below: Submenu items
 * - attributes: HTML attributes for the menu item
 * - in_active_trail: TRUE if item is in active trail
 */
#}
```

**Template Organization**:
```twig
{# Import macros #}
{% import _self as menus %}

{# Main template logic #}
{% if items %}
  <nav class="sidebar-menu" aria-label="{{ 'Section navigation'|t }}">
    {{ menus.menu_links(items, attributes, 0) }}
  </nav>
{% endif %}

{# Recursive macro definition #}
{% macro menu_links(items, attributes, menu_level) %}
  {# Macro implementation #}
{% endmacro %}
```

### Accessibility Standards

**ARIA Labels**:
```twig
<nav class="sidebar-menu" aria-label="{{ 'Section navigation'|t }}">
  <ul{{ attributes.addClass('menu', 'nav') }}>
    {% for item in items %}
      <li{{ item.attributes.addClass('nav-item') }}>
        <a href="{{ item.url }}" 
           class="nav-link"
           {% if item.in_active_trail %}aria-current="page"{% endif %}>
          {{ item.title }}
        </a>
      </li>
    {% endfor %}
  </ul>
</nav>
```

**Semantic HTML**:
- Use `<nav>` for navigation containers
- Use proper heading hierarchy
- Include skip links where appropriate
- Ensure keyboard navigation support

## CSS Standards

### Drupal CSS Guidelines

Follow [Drupal CSS Coding Standards](https://www.drupal.org/docs/develop/standards/css):

**File Structure**:
```css
/**
 * @file
 * Styles for the Howard Sidebar Menu Block.
 *
 * Provides styling for the contextual sidebar navigation menu,
 * including responsive behavior and accessibility features.
 */

/* Base menu styles */
.sidebar-menu {
  background: #f8f9fa;
  border: 1px solid #dee2e6;
  border-radius: 0.375rem;
  padding: 1rem;
}

/* Navigation list styles */
.sidebar-menu .menu {
  list-style: none;
  margin: 0;
  padding: 0;
}

/* Menu item styles */
.sidebar-menu .nav-item {
  margin: 0.25rem 0;
}

/* Link styles */
.sidebar-menu .nav-link {
  display: block;
  padding: 0.5rem 0.75rem;
  color: #495057;
  text-decoration: none;
  border-radius: 0.25rem;
  transition: all 0.15s ease-in-out;
}

.sidebar-menu .nav-link:hover,
.sidebar-menu .nav-link:focus {
  background-color: #e9ecef;
  color: #212529;
  outline: 2px solid #007bff;
  outline-offset: 2px;
}

/* Active state */
.sidebar-menu .nav-link[aria-current="page"] {
  background-color: #007bff;
  color: white;
}

/* Responsive styles */
@media (max-width: 768px) {
  .sidebar-menu {
    padding: 0.5rem;
  }
  
  .sidebar-menu .nav-link {
    padding: 0.75rem 0.5rem;
  }
}
```

### BEM Methodology

Use BEM (Block Element Modifier) naming convention:

```css
/* Block */
.sidebar-menu { }

/* Elements */
.sidebar-menu__list { }
.sidebar-menu__item { }
.sidebar-menu__link { }

/* Modifiers */
.sidebar-menu--compact { }
.sidebar-menu__link--active { }
.sidebar-menu__item--expanded { }
```

## JavaScript Standards

### Drupal JavaScript Guidelines

Follow [Drupal JavaScript Coding Standards](https://www.drupal.org/docs/develop/standards/javascript):

**File Structure**:
```javascript
/**
 * @file
 * JavaScript enhancements for the Howard Sidebar Menu Block.
 *
 * Provides interactive features such as collapsible menu sections
 * and keyboard navigation enhancements.
 */

(function ($, Drupal) {
  'use strict';

  /**
   * Initializes the sidebar menu behavior.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.howardSidebarMenu = {
    attach: function (context, settings) {
      // Behavior implementation
      $('.sidebar-menu', context).once('howard-sidebar-menu').each(function () {
        // Initialize menu functionality
      });
    },
    
    detach: function (context, settings, trigger) {
      // Cleanup when behavior is detached
      if (trigger === 'unload') {
        $('.sidebar-menu', context).removeOnce('howard-sidebar-menu');
      }
    }
  };

})(jQuery, Drupal);
```

**Key Requirements**:
- Use strict mode
- Proper JSDoc comments
- ES5 compatibility (unless ES6+ is specifically required)
- Use Drupal behaviors pattern
- Include proper cleanup in detach

### JSDoc Documentation

```javascript
/**
 * Enhances keyboard navigation for the sidebar menu.
 *
 * @param {HTMLElement} menu
 *   The menu container element.
 */
function enhanceKeyboardNavigation(menu) {
  // Implementation
}

/**
 * Configuration object for menu behavior.
 *
 * @typedef {Object} MenuConfig
 * @property {boolean} collapsible - Whether menu sections are collapsible
 * @property {string} activeClass - CSS class for active menu items
 * @property {number} animationDuration - Animation duration in milliseconds
 */
```

## Documentation Standards

### README Files

**Structure**:
1. Project title and description
2. Requirements
3. Installation instructions
4. Configuration
5. Usage examples
6. Troubleshooting
7. Contributing guidelines
8. License information

**Format**:
- Use Markdown format
- Include table of contents for long documents
- Use proper heading hierarchy
- Include code examples with syntax highlighting
- Add links to external resources

### API Documentation

**Inline Comments**:
```php
// Get the current route parameters for menu tree building.
$parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

// Determine the active trail to find parent menu item.
// Active trail is in reverse order (current page → root).
$active_trail = array_keys($parameters->activeTrail);
```

**Complex Logic**:
```php
/**
 * Determines the parent menu item for contextual navigation.
 *
 * The parent is typically the second item in the active trail,
 * as the first item is the current page. For root-level pages,
 * we fall back to the first item or manually set "Home".
 *
 * @param array $active_trail
 *   The active menu trail in reverse order.
 *
 * @return string|null
 *   The parent menu link ID, or NULL if not found.
 */
protected function getParentLinkId(array $active_trail) {
  // Implementation with detailed comments
}
```

## Testing Standards

### Unit Tests

**Test Structure**:
```php
<?php

namespace Drupal\Tests\howard_sidebar_menu_block\Unit\Plugin\Block;

use Drupal\Tests\UnitTestCase;
use Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock;

/**
 * Tests the Howard Sidebar Menu Block plugin.
 *
 * @coversDefaultClass \Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock
 * @group howard_sidebar_menu_block
 */
class HowardSidebarMenuBlockTest extends UnitTestCase {

  /**
   * Tests the build method with valid menu tree.
   *
   * @covers ::build
   */
  public function testBuildWithValidMenuTree() {
    // Test implementation
  }

  /**
   * Tests the build method with empty menu tree.
   *
   * @covers ::build
   */
  public function testBuildWithEmptyMenuTree() {
    // Test implementation
  }

}
```

### Functional Tests

**Test Coverage**:
- Block placement and configuration
- Menu display functionality
- Cache behavior
- Access control
- Template rendering
- Responsive behavior

## Version Control Standards

### Git Workflow

**Branch Naming**:
- `feature/description` - New features
- `bugfix/description` - Bug fixes
- `hotfix/description` - Critical fixes
- `docs/description` - Documentation updates

**Commit Messages**:
```
Type: Brief description (50 chars max)

Longer explanation of the change, if needed. Wrap at 72 characters.
Include references to issues or tickets.

- Bullet points for multiple changes
- Use present tense ("Add feature" not "Added feature")
- Be specific about what changed

Fixes #123
```

**Commit Types**:
- `feat:` - New feature
- `fix:` - Bug fix
- `docs:` - Documentation changes
- `style:` - Code style changes
- `refactor:` - Code refactoring
- `test:` - Adding or updating tests
- `chore:` - Maintenance tasks

### Code Review

**Review Checklist**:
- [ ] Code follows Drupal coding standards
- [ ] Documentation is complete and accurate
- [ ] Tests cover new functionality
- [ ] No security vulnerabilities
- [ ] Performance impact considered
- [ ] Accessibility requirements met
- [ ] Browser compatibility verified

## Release Standards

### Version Management

**Semantic Versioning**:
- `MAJOR.MINOR.PATCH` format
- MAJOR: Breaking changes
- MINOR: New features (backward compatible)
- PATCH: Bug fixes (backward compatible)

**Release Process**:
1. Update version numbers
2. Update CHANGELOG.md
3. Run all tests
4. Update documentation
5. Create release tag
6. Deploy to production

### Quality Assurance

**Pre-release Checklist**:
- [ ] All tests pass
- [ ] Code standards compliance verified
- [ ] Documentation updated
- [ ] Security review completed
- [ ] Performance testing done
- [ ] Accessibility validation passed
- [ ] Cross-browser testing completed

## Tools and Automation

### Code Quality Tools

**PHP CodeSniffer**:
```bash
# Check coding standards
vendor/bin/phpcs --standard=Drupal,DrupalPractice modules/contrib/howard_sidebar_menu_block/

# Fix coding standards automatically
vendor/bin/phpcbf --standard=Drupal modules/contrib/howard_sidebar_menu_block/
```

**PHPStan**:
```bash
# Static analysis
vendor/bin/phpstan analyse modules/contrib/howard_sidebar_menu_block/
```

**ESLint** (for JavaScript):
```bash
# Lint JavaScript files
npx eslint modules/contrib/howard_sidebar_menu_block/js/
```

### Automated Testing

**PHPUnit Configuration**:
```xml
<phpunit>
  <testsuites>
    <testsuite name="howard_sidebar_menu_block">
      <directory>./tests</directory>
    </testsuite>
  </testsuites>
</phpunit>
```

**GitHub Actions** (example):
```yaml
name: Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.1
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: vendor/bin/phpunit
```

---

*These coding standards ensure consistent, maintainable, and high-quality code. All contributors should review and follow these guidelines.*
