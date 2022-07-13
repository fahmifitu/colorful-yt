<?php

$link = $props['link'] ? $this->el('a', [
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => str_starts_with((string) $props['link'], '#'),
]) : null;

if ($link && $props['panel_link']) {

    $el->attr($link->attrs + [

        'class' => [
            'uk-link-toggle',
            // Only if `uk-flex` is not already set in `template.php` to let images cover the card height if the cards have different heights
            'uk-display-block' => !($props['panel_style'] && $props['has_panel_image_no_padding'] && in_array($props['image_align'], ['left', 'right'])),
        ],

    ]);

    $props['title'] = $this->striptags($props['title']);
    $props['meta'] = $this->striptags($props['meta']);
    $props['content'] = $this->striptags($props['content']);

    if ($props['title'] && $props['title_hover_style'] != 'reset') {
        $props['title'] = $this->el('span', [
            'class' => [
                'uk-link-{title_hover_style: heading}',
                'uk-link {!title_hover_style}',
            ],
        ], $props['title'])->render($props);
    }

}

if ($link && $props['title'] && $props['title_link']) {

    $props['title'] = $link($props, [
        'class' => [
            'uk-link-{title_hover_style}',
        ],
    ], $this->striptags($props['title']));

}

if ($link && $props['image'] && $props['image_link']) {

    $props['image'] = $link($props, ['class' => [

        'uk-display-block' => $props['panel_style'] && $props['has_panel_image_no_padding'] && in_array($props['image_align'], ['left', 'right']),

    ]], $props['image']);

}

if ($link && $props['link_text']) {

    if ($props['panel_link']) {
        $link = $this->el('div');
    }

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
            // Keep link style if panel link
            'uk-link {@link_style:} {@panel_link}',
            'uk-text-muted {@link_style: link-muted} {@panel_link}',
        ],

    ]);

}

return $link;
