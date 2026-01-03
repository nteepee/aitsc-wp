<?php
/**
 * Tabs Component
 *
 * Renders an interactive tabbed content area using pure CSS (radio button hack)
 * to avoid JavaScript dependency for basic functionality.
 *
 * @package AITSC_Pro_Theme
 * @subpackage Components
 * @since 3.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Tabs Block
 *
 * @param array $args {
 *     @type string $title       Section title
 *     @type string $id          Unique ID for this tab group (required for input names)
 *     @type array  $tabs        Array of tab items:
 *         @type string $id          Tab ID (unique slug)
 *         @type string $label       Tab label
 *         @type string $content     Tab content (HTML allowed)
 *         @type string $icon        Optional icon name
 * }
 */
function aitsc_render_tabs($args = array())
{
    $defaults = array(
        'title' => '',
        'id' => 'tabs-' . uniqid(),
        'tabs' => array()
    );

    $args = wp_parse_args($args, $defaults);

    if (empty($args['tabs'])) {
        return;
    }

    $group_id = esc_attr($args['id']);
    ?>

    <div class="aitsc-tabs-component">
        <?php if (!empty($args['title'])): ?>
            <h3>
                <?php echo esc_html($args['title']); ?>
            </h3>
        <?php endif; ?>

        <div class="aitsc-tabs">
            <!-- Navigation Inputs & Labels -->
            <div class="aitsc-tabs__nav">
                <?php foreach ($args['tabs'] as $index => $tab):
                    $tab_id = $group_id . '-' . $tab['id'];
                    $checked = ($index === 0) ? 'checked' : '';
                    ?>
                    <input type="radio" class="aitsc-tab__input" name="<?php echo $group_id; ?>"
                        id="<?php echo esc_attr($tab_id); ?>" <?php echo $checked; ?>>

                    <label for="<?php echo esc_attr($tab_id); ?>" class="aitsc-tab__label">
                        <?php if (!empty($tab['icon'])): ?>
                            <span class="material-symbols-outlined">
                                <?php echo esc_html($tab['icon']); ?>
                            </span>
                        <?php endif; ?>
                        <?php echo esc_html($tab['label']); ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- Content Panels -->
            <div class="aitsc-tabs__content">
                <?php foreach ($args['tabs'] as $tab):
                    $tab_id = $group_id . '-' . $tab['id'];
                    $panel_id = 'panel-' . $tab_id;
                    ?>
                    <div class="aitsc-tab__panel" id="<?php echo esc_attr($panel_id); ?>"
                        data-tab-source="<?php echo esc_attr($tab_id); ?>">
                        <?php echo wp_kses_post($tab['content']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
}
