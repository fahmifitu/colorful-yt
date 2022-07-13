<?php

$text_custom_color = in_array($node->props['text_color'], ['custom', 'image', 'hover_image']) ? "color: {$node->props['overlay_text_color']} !important" : '';
// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-transition-{title_transition} {@overlay_hover}',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove}',
        'uk-margin-remove-top {@title_margin: remove}',
        'uk-margin-remove-bottom',
    ],

] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Meta
$meta = $this->el($element['meta_element'], [

    'class' => [
        'el-meta',
        'uk-transition-{meta_transition} {@overlay_hover}',
        'uk-{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{meta_margin: remove}-top]' => !in_array($element['meta_style'], ['', 'text-meta', 'text-lead', 'text-small', 'text-large']) || $element['meta_element'] != 'div',
    ],

] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-panel',
        'uk-transition-{content_transition} {@overlay_hover}',
        'uk-{content_style}',
        'uk-margin[-{content_margin}]-top {@!content_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{content_margin: remove}-top]' => !in_array($element['content_style'], ['', 'text-meta', 'text-lead', 'text-small', 'text-large']),
    ],

] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Link
$link_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_margin}]-top {@!link_margin: remove}',
    ],

] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

?>

<?php if ($props['meta'] && $element['meta_align'] == 'above-title') : ?>
    <?= $meta($element, $props['meta']) ?>
<?php endif ?>

<?php if ($props['title']) : ?>
    <?= $title($element) ?>
    <?php if ($element['title_color'] == 'background') : ?>
        <span class="uk-text-background"><?= $props['title'] ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
        <span><?= $props['title'] ?></span>
    <?php else : ?>
        <?= $props['title'] ?>
    <?php endif ?>
    <?= $title->end() ?>
<?php endif ?>

<?php if ($props['meta'] && $element['meta_align'] == 'below-title') : ?>
    <?= $meta($element, $props['meta']) ?>
<?php endif ?>

<?php if ($props['content']) : ?>
    <?= $content($element, $props['content']) ?>
<?php endif ?>

<?php if ($props['meta'] && $element['meta_align'] == 'below-content') : ?>
    <?= $meta($element, $props['meta']) ?>
<?php endif ?>

<?php if ($props['link'] && ($props['link_text'] || $element['link_text'])) : ?>
    <?= $link_container($element, $link($element, $props['link_text'] ?: $element['link_text'])) ?>
<?php endif ?>