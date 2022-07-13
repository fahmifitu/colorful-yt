<?php

// If link is not set use the default image for the lightbox
if (!$props['link'] && $element['lightbox']) {
    $props['link'] = $props['image'];
}

$el = $this->el($isLink = $props['link'] && $element['overlay_link'] ? 'a' : 'div', [

    'class' => [
        'el-item',

        'uk-margin-auto uk-width-{item_maxwidth}',

        'uk-box-shadow-{image_box_shadow}',
        'uk-box-shadow-hover-{image_hover_box_shadow}',

        'uk-border-{image_border} {@!image_box_decoration}',
        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
        'uk-inline-clip {@!image_box_decoration}',

        'uk-transition-toggle' => $isTransition = $element['overlay_hover'] || $element['image_transition'] || $props['hover_image'],

    ],

    'style' => [
        'min-height: {image_min_height}px; {@!image_box_decoration}',
        'background-color: ' . $props['media_background'] . ';' => $props['media_background'],
    ],

    'tabindex' => $isTransition && !$isLink ? 0 : null,
]);

$box_decoration_clip = $this->el('div', [

    'class' => [
        'uk-inline-clip',
    ],

    'style' => [
        'min-height: {image_min_height}px; {@image_box_decoration}',
    ],

]);

$overlay = $this->el('div', [

    'class' => [
        'uk-{overlay_style}',
        'uk-transition-{overlay_transition} {@overlay_hover} {@overlay_cover}',

        'uk-position-cover {@overlay_cover}',
        'uk-position-{overlay_margin} {@overlay_cover}',
    ],

] + (isset($props['colorful_background_color']) ? [
    'style' => [
        "background-color: {$props['colorful_background_color']} !important;"
    ]
] : []));

$position = $this->el('div', [

    'class' => [
        'uk-position-{overlay_position} [uk-position-{overlay_margin} {@overlay_style}]',
        'uk-transition-{overlay_transition} {@overlay_hover}' => !$element['overlay_transition_background'] || !$element['overlay_cover'],
    ],

]);

$content = $this->el('div', [

    'class' => [
        'uk-light' => isset($props['colorful_text_color']) ? in_array($props['colorful_text_color'], ['white', 'light']) : false,
        $element['overlay_style'] ? 'uk-overlay' : 'uk-panel',
        'uk-padding {@!overlay_padding} {@!overlay_style}',
        'uk-padding-{!overlay_padding: |none}',
        'uk-padding-remove {@overlay_padding: none} {@overlay_style}',
        'uk-width-{overlay_maxwidth} {@!overlay_position: top|bottom}',
        'uk-margin-remove-first-child',
    ],

]);

if (!$element['overlay_cover']) {
    $position->attr($overlay->attrs);
}

// Link
$link = include "{$__dir}/template-link.php";

// Helper
$helper = '';

$helper_condition_color = !$element['overlay_style'] || $element['overlay_mode'] == 'cover';
$helper_condition_toggle = ($props['text_color_hover'] || $element['text_color_hover']) && ((!$element['overlay_style'] && $props['hover_image']) || ($element['overlay_cover'] && $element['overlay_hover'] && $element['overlay_transition_background']));

if ($helper_condition_color || $helper_condition_toggle) {

    $helper = $this->el('div', [

        'class' => [
            // Needs to be parent of `uk-light` or `uk-dark`
            'uk-{0}' => $helper_condition_color
                ? ($props['text_color'] ?: $element['text_color'])
                : false,
        ],

    ]);

    // Needs to be on anchor to have just one focusable toggle when using keyboard navigation
    $el->attr([

        // Inverse text color on hover
        'uk-toggle' => $helper_condition_toggle
            ? 'cls: uk-light uk-dark; mode: hover; target: !*'
            : false,

    ]);
}

?>

<?php if ($helper) : ?>
    <?= $helper($props) ?>
<?php endif ?>

<?= $el($element, $attrs) ?>

<?php if ($element['image_box_decoration']) : ?>
    <?= $box_decoration_clip($element) ?>
<?php endif ?>

<?= $this->render("{$__dir}/template-media", compact('props')) ?>

<?php if ($props['media_overlay']) : ?>
    <div class="uk-position-cover" style="background-color:<?= $props['media_overlay'] ?>"></div>
<?php endif ?>

<?php if ($element['overlay_cover']) : ?>
    <?= $overlay($element, '') ?>
<?php endif ?>

<?php if ($props['title'] || $props['meta'] || $props['content'] || ($props['link'] && ($props['link_text'] || $element['link_text']))) : ?>
    <?= $position($element, $content($element, $this->render("{$__dir}/template-content", compact('props', 'link')))) ?>
<?php endif ?>

<?php if ($element['image_box_decoration']) : ?>
    <?= $box_decoration_clip->end() ?>
<?php endif ?>

<?= $el->end() ?>

<?php if ($helper) : ?>
    <?= $helper->end() ?>
<?php endif ?>