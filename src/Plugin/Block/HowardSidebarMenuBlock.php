<?php

/**
 * @file
 * Contains \Drupal\howard_sidebar_menu_block\Plugin\Block\HowardSidebarMenuBlock.
 *
 * This file provides the HowardSidebarMenuBlock class which creates a
 * context-aware sidebar navigation menu based on the current page's position
 * in the site's main menu hierarchy.
 */

namespace Drupal\howard_sidebar_menu_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Menu\MenuTreeInterface;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Howard Sidebar Menu Block.
 *
 * This block creates a contextual sidebar navigation that automatically
 * determines the current page's position in the main menu hierarchy and
 * displays relevant submenu items. The block intelligently finds the parent
 * menu item and builds a tree showing siblings and children of the current
 * page context.
 *
 * The block uses Drupal's Menu Tree API for efficient menu manipulation
 * and implements proper caching strategies for optimal performance.
 *
 * @Block(
 *   id = "howard_sidebar_menu_block",
 *   admin_label = @Translation("Howard Sidebar Menu Block"),
 *   category = @Translation("Menus"),
 *   context_definitions = {
 *     "node" = @ContextDefinition("entity:node", required = FALSE)
 *   }
 * )
 */
class HowardSidebarMenuBlock extends BlockBase implements ContainerInjectionInterface {

  /**
   * The menu tree service.
   *
   * @var \Drupal\Core\Menu\MenuTreeInterface
   */
  protected $menuTree;

  /**
   * The menu link manager.
   *
   * @var \Drupal\Core\Menu\MenuLinkManagerInterface
   */
  protected $menuLinkManager;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * Constructs a new HowardSidebarMenuBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Menu\MenuTreeInterface $menu_tree
   *   The menu tree service.
   * @param \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager
   *   The menu link manager.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MenuTreeInterface $menu_tree, MenuLinkManagerInterface $menu_link_manager, RendererInterface $renderer) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->menuTree = $menu_tree;
    $this->menuLinkManager = $menu_link_manager;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu.tree'),
      $container->get('plugin.manager.menu.link'),
      $container->get('renderer')
    );
  }

  /**
   * Builds the sidebar menu render array.
   *
   * This method creates a contextual sidebar navigation by:
   * 1. Determining the current page's position in the main menu hierarchy
   * 2. Finding the appropriate parent menu item for context
   * 3. Building a menu tree showing relevant navigation options
   * 4. Applying access controls and sorting
   * 5. Returning a cached render array
   *
   * The method uses Drupal's Menu Tree API for efficient menu manipulation
   * and implements URL-based caching to ensure optimal performance while
   * maintaining context-sensitive display.
   *
   * @return array
   *   A render array containing:
   *   - Menu markup with proper theme hooks
   *   - Parent link information for breadcrumb context
   *   - Caching metadata with URL context
   *   - Empty array if no menu items are found or accessible
   */
  public function build() {
    // Enable URL-wise caching to ensure menu displays correctly
    // based on the current page context.
    $build = [
      '#cache' => [
        'contexts' => ['url'],
      ],
    ];

    // Use the main menu as the primary navigation source.
    $menu_name = 'main';

    // Get the current route's menu tree parameters.
    // This provides the active trail in *reverse order* where
    // the current active link is always the first array element.
    $parameters = $this->menuTree->getCurrentRouteMenuTreeParameters($menu_name);
    $active_trail = array_keys($parameters->activeTrail);

    // Determine the parent link ID for contextual navigation.
    // For most pages, we want the parent of the current page.
    // For root-level pages, we use the current page itself.
    // The active trail is in reverse order: [current, parent, grandparent, ...]
    $parent_link_id = $active_trail[1] ?? $active_trail[0];

    // Build parent link information for template context.
    // This provides breadcrumb-style navigation context.
    $parent = [];
    if ($parent_link_id !== NULL && $parent_link_id !== '') {
      // Get parent link details from the menu link manager.
      $parent_link = $this->menuLinkManager->createInstance($parent_link_id);
      $parent['#title'] = $parent_link->getTitle();
      $url_obj = $parent_link->getUrlObject();
      $parent['#link'] = $url_obj->toString();
    }
    else {
      // Default fallback for pages without clear parent context.
      $parent['#title'] = 'Home';
      $parent['#link'] = '/';
    }

    // Configure menu tree parameters for contextual loading.
    // Set the parent as the root to show its children and siblings.
    $parameters->setRoot($parent_link_id);
    // Limit depth to 2 levels to avoid overwhelming the sidebar.
    $parameters->setMaxDepth(2);
    // Exclude the root item since we're showing its children.
    $parameters->excludeRoot();
    
    // Load the menu tree with our configured parameters.
    $tree = $this->menuTree->load($menu_name, $parameters);

    // Apply menu tree manipulators for access control and sorting.
    // These ensure users only see items they have permission to access
    // and that items are properly sorted according to menu weights.
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkNodeAccess'],
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $this->menuTree->transform($tree, $manipulators);

    // Build a renderable array from the menu tree.
    $menu = $this->menuTree->build($tree);

    // Apply custom theme hook for template override capability.
    // This allows themes to provide custom templates for the sidebar menu.
    $menu['#theme'] = 'howard_sidebar_menu__main';

    // Render the menu and attach to the build array.
    // Pass both the rendered menu and parent context to the template.
    $build['#markup'] = $this->renderer->render($menu);
    $build['#parent'] = $parent;

    return $build;

  }

}
