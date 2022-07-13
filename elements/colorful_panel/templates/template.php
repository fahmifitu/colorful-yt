<?php

// Resets
if ($props['icon'] && !$props['image']) {
    $props['panel_image_no_padding'] = '';
}
if ($props['panel_style'] || !$props['image']) {
    $props['image_box_decoration'] = '';
}
if ($props['panel_link']) {
    $props['title_link'] = '';
    $props['image_link'] = '';
}

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));

// New logic shortcuts
$props['has_panel_image_no_padding'] = $props['image'] && (!$props['panel_style'] || $props['panel_image_no_padding']) && $props['image_align'] != 'between';
$props['has_no_padding'] = !$props['panel_style'] && (!$props['image'] || ($props['image'] && $props['image_align'] == 'between'));

// Transition
if ($props['image_transition']) {

    $transition_toggle = $this->el('div', [
        'class' => [
            'uk-inline-clip [uk-transition-toggle {@image_link}]',
            'uk-border-{image_border}' => !$props['panel_style'] || ($props['panel_style'] && (!$props['panel_image_no_padding'] || $props['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',
            'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style} {@link}' => $props['image_link'] || $props['panel_link'],
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_image_no_padding'])),
        ],
    ]);
    $props['image'] = $transition_toggle($props, $props['image']);
}

// Decoration
if ($props['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_image_no_padding'])),
        ],

    ]);

    $props['image'] = $decoration($props, $props['image']);
}

// Panel/Card/Tile
$el = $this->el($props['link'] && $props['panel_link'] ? 'a' : 'div', [

    'class' => [
        'uk-panel [uk-{panel_style: tile-.*}] {@panel_style: |tile-.*}',
        'uk-card uk-{panel_style: card-.*} [uk-card-{!panel_padding: |default}]',
        'uk-tile-hover {@panel_style: tile-.*} {@panel_link} {@link}',
        'uk-card-hover {@!panel_style: |card-hover|tile-.*} {@panel_link} {@link}',
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-margin-remove-first-child' => !in_array($props['image_align'], ['left', 'right']) || !($props['panel_padding'] && $props['has_panel_image_no_padding']),
        'uk-flex {@panel_style} {@has_panel_image_no_padding} {@image_align: left|right}', // Let images cover the card/tile height if they have different heights
        'uk-transition-toggle {@image} {@image_transition} {@panel_link}',
        'uk-light' => isset($props['colorful_text_color']) ? in_array($props['colorful_text_color'], ['white', 'light']) : false,
    ],
] + (isset($props['colorful_background_color']) ? [
    'style' => [
        "background-color: {$props['colorful_background_color']} !important;"
    ]
] : []));

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_style'] && $props['has_panel_image_no_padding']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_grid_column_gap'] == $props['image_grid_row_gap']
                ? 'uk-grid-{image_grid_column_gap}'
                : '[uk-grid-column-{image_grid_column_gap}] [uk-grid-row-{image_grid_row_gap}]'),
        'uk-flex-middle {@image_vertical_align}' => !($props['panel_style'] && $props['panel_image_no_padding']),
    ],

    'uk-grid' => true,
]);

$cell_image = $this->el('div', [

    'class' => [
        'uk-width-{image_grid_width}[@{image_grid_breakpoint}]',
        'uk-flex-last[@{image_grid_breakpoint}] {@image_align: right}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@has_panel_image_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@has_panel_image_no_padding}',
        'uk-margin-remove-first-child {@panel_padding} {@has_panel_image_no_padding}',
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => !($props['panel_padding'] && $props['has_panel_image_no_padding']),
        'uk-flex uk-flex-middle {@image_vertical_align}' => $props['panel_style'] && $props['panel_image_no_padding'],
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($props['panel_style'] && $props['has_panel_image_no_padding']) {
    $props['image'] = $this->el('div', [

        'class' => [
            'uk-card-media-{image_align} {@panel_style: card-.*}',
            'uk-cover-container{@image_align: left|right}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_align} uk-card-media-top; mode: media; media: @{image_grid_breakpoint} {@image_align: left|right} {@panel_style: card-.*}',
        ],

    ], $props['image'])->render($props);
}

?>

<?= $el($props, $attrs) ?>

<?php if ($props['image'] && in_array($props['image_align'], ['left', 'right'])) : ?>

    <?= $grid($props) ?>
    <?= $cell_image($props, $props['image']) ?>
    <?= $cell_content($props) ?>

    <?php if ($this->expr($content->attrs['class'], $props)) : ?>
        <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
    <?php else : ?>
        <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
    <?php endif ?>

    <?= $cell_content->end() ?>
    </div>

<?php else : ?>

    <?php if ($props['image_align'] == 'top') : ?>
        <?= $props['image'] ?>
    <?php endif ?>

    <?php if ($this->expr($content->attrs['class'], $props)) : ?>
        <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
    <?php else : ?>
        <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
    <?php endif ?>

    <?php if ($props['image_align'] == 'bottom') : ?>
        <?= $props['image'] ?>
    <?php endif ?>

<?php endif ?>

<?= $el->end() ?>