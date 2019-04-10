<?php

namespace Drupal\howard_sidebar_menu_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Howard Sidebar Menu Block
 *
 * @Block(
 *   id = "howard_sidebar_menu_block",
 *   admin_label = @Translation("Howard Sidebar Menu Block")
 * )
 */
class HowardSidebarMenuBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {

    // Enable url-wise caching.
    $build = [
      '#cache' => [
        'contexts' => ['url'],
      ],
    ];

    $menu_name = 'main';
    $menu_tree = \Drupal::menuTree();
    $menu_link_manager = \Drupal::service('plugin.manager.menu.link');

    // This one will give us the active trail in *reverse order*.
    // Our current active link always will be the first array element.
    $parameters   = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);
    $active_trail = array_keys($parameters->activeTrail);

    // But actually we need its parent.
    // Except for <front>. Which has no parent.
    $parent_link_id = isset($active_trail[1]) ? $active_trail[1] : $active_trail[0];

    // Get parent link title and URL to display as "back link". Manually set Home for first level pages
    $parent = [];
    if(isset($parent_link_id) && $parent_link_id !== NULL && $parent_link_id !== '') {
      $parent['#title'] = $menu_link_manager->createInstance($parent_link_id)->getTitle();
      $url_obj = $menu_link_manager->createInstance($parent_link_id)->getUrlObject();
      $parent['#link'] = $url_obj->toString();
    } else {
      $parent['#title'] = 'Home';
      $parent['#link'] = '/';
    }
    
    // Having the parent now we set it as starting point to build our custom tree.
    $parameters->setRoot($parent_link_id);
    $parameters->setMaxDepth(2);
    $parameters->excludeRoot();
    $tree = $menu_tree->load($menu_name, $parameters);

    // Optional: Native sort and access checks.
    $manipulators = [
      ['callable' => 'menu.default_tree_manipulators:checkNodeAccess'],
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ];
    $tree = $menu_tree->transform($tree, $manipulators);

    // Finally, build a renderable array.
    $menu = $menu_tree->build($tree);

    // Set custom theme in order to template
    $menu['#theme'] = 'howard_sidebar_menu__main';

    // Pass template, parent, and rendered menu
    $build['#markup'] = \Drupal::service('renderer')->render($menu);
    $build['#parent'] = $parent;

    return $build;

  }


}
