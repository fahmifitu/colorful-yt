<?php

$nav = $this->el('ul', [

    'class' => [
        'el-nav uk-slider-nav',
        'uk-{nav}',
        'uk-flex-{nav_align}',
    ],

    'uk-margin' => true,
]);

$nav_container = $this->el('div', [

    'class' => [
        'uk-margin[-{nav_margin}]-top',
        'uk-visible@{nav_breakpoint}',
        'uk-{nav_color}',
        'uk-position-relative {@panel_style} {@panel_card_offset}', // Fix `uk-slider-container-offset` causing overlaying the nav
    ],

]);

echo $props['nav_color'] ? $nav_container($props, $nav($props, '')) : $nav($props, $nav_container->attrs, '');
