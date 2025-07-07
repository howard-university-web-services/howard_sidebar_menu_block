# API Documentation - Howard Sidebar Menu Block

This document provides comprehensive API documentation for the Howard Sidebar Menu Block module, including technical specifications, hooks, and extension points.

## Overview

The Howard Sidebar Menu Block provides a sophisticated menu navigation system that automatically determines the current page's position in the menu hierarchy and displays relevant submenu items. This documentation covers the technical implementation details.

## Architecture

### Module Structure

```
howard_sidebar_menu_block/
├── src/
│   └── Plugin/
│       └── Block/
│           └── HowardSidebarMenuBlock.php  # Main block plugin
├── templates/
│   ├── block--howard-sidebar-menu-block.html.twig
│   └── howard-sidebar-menu--main.html.twig
├── howard_sidebar_menu_block.info.yml      # Module definition
├── howard_sidebar_menu_block.module        # Hook implementations
└── composer.json                           # Composer metadata
```

### Core Components

#### 1. Block Plugin (`HowardSidebarMenuBlock`)

The main block plugin that handles menu tree manipulation and rendering.

**Class**: `Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock`

**Annotation**:
```php
@Block(
  id = "howard_sidebar_menu_block",
  admin_label = @Translation("Howard Sidebar Menu Block")
)
```

**Key Methods**:
- `build()`: Main method that constructs the menu tree and returns render array

#### 2. Menu Tree Manipulation

The module uses Drupal's Menu Tree API to:
- Determine current menu position
- Find parent menu items
- Build contextual submenu trees
- Apply access checks and sorting

#### 3. Theme System Integration

Custom theme hooks and templates provide flexibility for theming.

## Block Plugin API

### HowardSidebarMenuBlock::build()

The primary method that constructs the sidebar menu.

**Return Value**: `array`
- Render array with menu structure and caching metadata

**Process Flow**:
1. Set up URL-based caching
2. Get current route menu tree parameters
3. Determine active trail and parent link
4. Configure menu tree parameters
5. Load and manipulate menu tree
6. Build renderable menu array
7. Apply custom theme

**Code Example**:
```php
public function build() {
  // Enable url-wise caching
  $build = [
    '#cache' => [
      'contexts' => ['url'],
    ],
  ];

  $menu_name = 'main';
  $menu_tree = \Drupal::menuTree();
  $menu_link_manager = \Drupal::service('plugin.manager.menu.link');

  // Get active trail in reverse order
  $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
  $active_trail = array_keys($parameters->activeTrail);

  // Determine parent link
  $parent_link_id = $active_trail[1] ?? $active_trail[0];

  // Configure menu tree parameters
  $parameters->setRoot($parent_link_id);
  $parameters->setMaxDepth(2);
  $parameters->excludeRoot();
  
  // Load and manipulate tree
  $tree = $menu_tree->load($menu_name, $parameters);
  
  // Apply manipulators
  $manipulators = [
    ['callable' => 'menu.default_tree_manipulators:checkNodeAccess'],
    ['callable' => 'menu.default_tree_manipulators:checkAccess'],
    ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
  ];
  $tree = $menu_tree->transform($tree, $manipulators);

  // Build render array
  $menu = $menu_tree->build($tree);
  $menu['#theme'] = 'howard_sidebar_menu__main';

  $build['#markup'] = \Drupal::service('renderer')->render($menu);
  $build['#parent'] = $parent;

  return $build;
}
```

### Parent Link Detection

The module intelligently determines the parent link for contextual navigation:

**Logic**:
1. Get active trail from current route
2. Active trail is in reverse order (current → root)
3. Parent is typically `$active_trail[1]`
4. For root pages, fallback to `$active_trail[0]`
5. For front page, manually set to "Home"

**Code Example**:
```php
// Get parent link title and URL
$parent = [];
if ($parent_link_id !== NULL && $parent_link_id !== '') {
  $parent['#title'] = $menu_link_manager->createInstance($parent_link_id)->getTitle();
  $url_obj = $menu_link_manager->createInstance($parent_link_id)->getUrlObject();
  $parent['#link'] = $url_obj->toString();
}
else {
  $parent['#title'] = 'Home';
  $parent['#link'] = '/';
}
```

### Menu Tree Parameters

The module configures menu tree loading parameters:

**Key Parameters**:
- `setRoot($parent_link_id)`: Start from parent link
- `setMaxDepth(2)`: Limit depth to 2 levels
- `excludeRoot()`: Don't include the root item itself

**Manipulators Applied**:
- `checkNodeAccess`: Verify node access permissions
- `checkAccess`: Check general access permissions
- `generateIndexAndSort`: Sort menu items appropriately

## Hook Implementations

### hook_help()

Provides module help text on the help page.

**Function**: `howard_sidebar_menu_block_help()`

**Parameters**:
- `$route_name`: The current route name
- `$route_match`: The route match object

**Returns**: Help text HTML or NULL

**Implementation**:
```php
function howard_sidebar_menu_block_help($route_name, RouteMatchInterface $route_match) {
  switch ($route_name) {
    case 'help.page.howard_sidebar_menu_block':
      $filepath = dirname(__FILE__) . '/README.md';
      if (file_exists($filepath)) {
        $readme = file_get_contents($filepath);
        return '<pre>' . $readme . '</pre>';
      }
      return NULL;
  }
}
```

### hook_theme()

Defines custom theme hooks for the module.

**Function**: `howard_sidebar_menu_block_theme()`

**Returns**: Array of theme definitions

**Theme Hooks Defined**:
- `howard_sidebar_menu__main`: Main menu theme
- `block__howard_sidebar_menu_block`: Block wrapper theme

**Implementation**:
```php
function howard_sidebar_menu_block_theme($existing, $type, $theme, $path) {
  $theme = [];
  $theme['howard_sidebar_menu__main'] = [
    'base hook' => 'menu',
    'render element' => 'menu',
  ];
  $theme['block__howard_sidebar_menu_block'] = [
    'base hook' => 'block',
    'render element' => 'block',
  ];
  return $theme;
}
```

## Template API

### howard-sidebar-menu--main.html.twig

Main template for rendering the menu tree.

**Available Variables**:
- `items`: Nested array of menu items
- `attributes`: HTML attributes for the menu container
- `menu_name`: Machine name of the menu (typically 'main')

**Each Menu Item Contains**:
- `attributes`: HTML attributes for the menu item
- `below`: Child menu items
- `title`: Menu link title
- `url`: Menu link URL object
- `localized_options`: Menu link localized options
- `is_expanded`: TRUE if link has visible children
- `is_collapsed`: TRUE if link has hidden children
- `in_active_trail`: TRUE if link is in active trail

**Template Structure**:
```twig
{# Import macro for recursive rendering #}
{% import _self as menus %}

{# Render the menu tree #}
{{ menus.menu_links(items, attributes, 0) }}

{# Recursive macro for menu rendering #}
{% macro menu_links(items, attributes, menu_level) %}
  {% import _self as menus %}
  {% if items %}
    {% if menu_level == 0 %}
      <ul{{ attributes }}>
    {% else %}
      <ul>
    {% endif %}
    {% for item in items %}
      <li{{ item.attributes }}>
        {{ link(item.title, item.url) }}
        {% if item.below %}
          {{ menus.menu_links(item.below, attributes, menu_level + 1) }}
        {% endif %}
      </li>
    {% endfor %}
    </ul>
  {% endif %}
{% endmacro %}
```

### block--howard-sidebar-menu-block.html.twig

Block wrapper template for the sidebar menu block.

**Available Variables**:
- `plugin_id`: The block plugin ID
- `label`: Block label
- `configuration`: Block configuration
- `provider`: Module providing the block
- `Block`: Block entity object
- `elements`: Block content elements
- `content`: Rendered block content

## Caching Strategy

### Cache Contexts

The module implements URL-based caching:

```php
$build = [
  '#cache' => [
    'contexts' => ['url'],
  ],
];
```

**Why URL Context?**
- Menu display depends on current page position
- Different URLs may show different menu structures
- Ensures proper cache segregation

### Cache Tags

The module inherits cache tags from:
- Menu tree elements
- Referenced menu items
- Target node entities

### Cache Invalidation

Cache is automatically invalidated when:
- Menu structure changes
- Menu items are added/removed/modified
- Target content is updated
- Menu link titles or URLs change

## Services and Dependencies

### Core Services Used

**Menu Tree Service**:
```php
$menu_tree = \Drupal::menuTree();
```

**Menu Link Manager**:
```php
$menu_link_manager = \Drupal::service('plugin.manager.menu.link');
```

**Renderer Service**:
```php
$renderer = \Drupal::service('renderer');
```

### Module Dependencies

**Required**:
- `drupal:block` - For block system integration

**Implicit Dependencies**:
- `drupal:menu_link_content` - For menu functionality
- `drupal:system` - For core system services

## Extension Points

### Custom Menu Tree Manipulators

Add custom manipulators to modify menu tree:

```php
$manipulators = [
  ['callable' => 'menu.default_tree_manipulators:checkNodeAccess'],
  ['callable' => 'menu.default_tree_manipulators:checkAccess'],
  ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
  ['callable' => 'my_module.custom_manipulator:customSort'],
];
```

### Theme Hook Suggestions

The module provides theme hook suggestions:

- `howard_sidebar_menu__main`
- `howard_sidebar_menu__main__[menu_name]`
- `block__howard_sidebar_menu_block`
- `block__howard_sidebar_menu_block__[region]`

### Alter Hooks

**hook_block_view_alter()**:
```php
function mymodule_block_view_alter(array &$build, BlockPluginInterface $block) {
  if ($block->getPluginId() == 'howard_sidebar_menu_block') {
    // Modify block output
    $build['#pre_render'][] = 'mymodule_prerender_sidebar_menu';
  }
}
```

**hook_menu_tree_alter()**:
```php
function mymodule_menu_tree_alter(array &$tree, array &$manipulators) {
  // Add custom manipulators or modify tree
}
```

## Performance Considerations

### Optimization Strategies

1. **Efficient Menu Tree Loading**:
   - Use `setMaxDepth()` to limit tree depth
   - Apply `excludeRoot()` to reduce overhead
   - Use appropriate manipulators

2. **Caching**:
   - URL-based caching for context-sensitive display
   - Leverage Drupal's cache system
   - Proper cache tag and context implementation

3. **Template Optimization**:
   - Minimize template complexity
   - Use efficient Twig constructs
   - Avoid unnecessary computations in templates

### Memory Usage

The module is designed to be memory-efficient:
- Loads only necessary menu tree portions
- Uses lazy loading where possible
- Properly manages object lifecycles

## Security Considerations

### Access Control

The module respects Drupal's access control:
- Menu link access checking
- Node access verification
- User permission validation

### XSS Prevention

All output is properly escaped:
- Menu titles are sanitized
- URLs are validated
- Template variables are escaped

### CSRF Protection

The module doesn't modify data, so CSRF protection is not required for display functionality.

## Testing

### Unit Testing

Test the block plugin:

```php
public function testMenuTreeBuilding() {
  $block = $this->createBlock();
  $build = $block->build();
  
  $this->assertArrayHasKey('#cache', $build);
  $this->assertContains('url', $build['#cache']['contexts']);
}
```

### Integration Testing

Test menu integration:

```php
public function testMenuIntegration() {
  $this->drupalCreateContentType(['type' => 'page']);
  $node = $this->drupalCreateNode(['type' => 'page']);
  
  // Create menu link
  $menu_link = MenuLinkContent::create([
    'title' => 'Test Page',
    'link' => ['uri' => 'entity:node/' . $node->id()],
    'menu_name' => 'main',
  ]);
  $menu_link->save();
  
  // Place block and test display
  $this->drupalPlaceBlock('howard_sidebar_menu_block');
  $this->drupalGet($node->toUrl());
  $this->assertSession()->elementExists('css', '.howard-sidebar-menu');
}
```

## Troubleshooting

### Common API Issues

**Menu Tree Not Loading**:
- Check menu name configuration
- Verify menu items exist
- Ensure proper permissions

**Parent Detection Failing**:
- Verify active trail calculation
- Check menu hierarchy structure
- Ensure current route has menu link

**Template Not Rendering**:
- Clear template cache
- Check theme hook implementation
- Verify template file locations

---

*This API documentation is maintained alongside the module codebase. For the latest updates, refer to the module source code and inline documentation.*
