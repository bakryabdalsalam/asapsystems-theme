<?php
class ASAP_Menu_Walker extends Walker_Nav_Menu {
    private $current_parent = 0;
    private $mega_menu_items = array();

    public function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= '<div class="mega-menu"><div class="mega-menu-grid">';
        } else {
            $output .= '<ul>';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= '</div></div>';
        } else {
            $output .= '</ul>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        if ($depth === 0) {
            $this->current_parent = $item->ID;
            $output .= '<div class="nav-item">';
            $output .= '<a href="' . esc_url($item->url) . '" class="nav-link' . ($has_children ? ' has-mega-menu' : '') . '">';
            $output .= esc_html($item->title);
            if ($has_children) {
                $output .= ' <i class="fas fa-chevron-down"></i>';
            }
            $output .= '</a>';
        } elseif ($depth === 1) {
            $output .= '<div class="mega-menu-column">';
            $output .= '<h3>' . esc_html($item->title) . '</h3>';
            if ($has_children) {
                $output .= '<ul>';
            }
        } else {
            $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
            $output .= '<li>';
            $output .= '<a href="' . esc_url($item->url) . '">';
            if ($icon_class) {
                $output .= '<i class="' . esc_attr($icon_class) . '"></i>';
            }
            $output .= esc_html($item->title) . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        if ($depth === 0) {
            $output .= '</div>';
        } elseif ($depth === 1) {
            if (in_array('menu-item-has-children', $item->classes)) {
                $output .= '</ul>';
            }
            $output .= '</div>';
        } else {
            $output .= '</li>';
        }
    }
}

// Add custom fields to menu items
function asap_add_menu_meta_box() {
    add_meta_box(
        'asap_menu_item_icon',
        __('Menu Item Icon', 'asapsystems'),
        'asap_menu_item_icon_meta_box',
        'nav-menus',
        'side',
        'default'
    );
}
add_action('admin_init', 'asap_add_menu_meta_box');

function asap_menu_item_icon_meta_box($item) {
    $icon_class = get_post_meta($item->ID, '_menu_item_icon', true);
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item->ID; ?>">
            <?php _e('Icon Class (e.g., fas fa-home)', 'asapsystems'); ?><br>
            <input type="text" id="edit-menu-item-icon-<?php echo $item->ID; ?>" 
                   class="widefat edit-menu-item-icon" 
                   name="menu-item-icon[<?php echo $item->ID; ?>]" 
                   value="<?php echo esc_attr($icon_class); ?>">
        </label>
    </p>
    <?php
}

function asap_save_menu_item_icon($menu_id, $menu_item_db_id) {
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        $icon_value = sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_menu_item_icon', $icon_value);
    }
}
add_action('wp_update_nav_menu_item', 'asap_save_menu_item_icon', 10, 2); 