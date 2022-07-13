<?php
$text_custom_color = in_array($node->props['text_color'], ['custom', 'image']) ? "color: {$node->props['overlay_text_color']} !important" : '';

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove}',
        'uk-margin-remove-top {@title_margin: remove}',
        'uk-margin-remove-bottom',
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']($element, 'title_'),
] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Meta
$meta = $this->el($element['meta_element'], [

    'class' => [
        'el-meta',
        'uk-{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{meta_margin: remove}-top]' => !in_array($element['meta_style'], ['', 'text-meta', 'text-lead', 'text-small', 'text-large']) || $element['meta_element'] != 'div',
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']($element, 'meta_'),
] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-panel',
        'uk-{content_style}',
        'uk-margin[-{content_margin}]-top {@!content_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{content_margin: remove}-top]' => !in_array($element['content_style'], ['', 'text-meta', 'text-lead', 'text-small', 'text-large']),
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']($element, 'content_'),
] + (isset($props['colorful_background_color']) ? [
    'style' => [
        $text_custom_color
    ]
] : []));

// Link
$link = $this->el('a', [

    'class' => [
        'el-link',
        'uk-{link_style: link-(muted|text)}',
        'uk-button uk-button-{!link_style: |link-(muted|text)} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
    ],

    'href' => $props['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => str_starts_with((string) $props['link'], '#'),
    'uk-slideshow-parallax' => $element['parallaxOptions']($element, 'link_'),
]);

$link_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_margin}]-top {@!link_margin: remove}',
    ],

]);

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