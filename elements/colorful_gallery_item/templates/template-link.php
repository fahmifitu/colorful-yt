<?php

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

$link = $props['link'] ? $this->el('a', [
    'href' => $props['link'],
]) : null;

// Lightbox
if ($link && $element['lightbox']) {

    if ($type = $this->isImage($props['link'])) {

        if ($type !== 'svg' && ($element['lightbox_image_width'] || $element['lightbox_image_height'])) {
            $props['link'] = "{$props['link']}#thumbnail={$element['lightbox_image_width']},{$element['lightbox_image_height']},{$element['lightbox_image_orientation']}";
        }

        $link->attr([
            'href' => $imageProvider->getUrl($props['link']),
            'data-alt' => $props['image_alt'],
            'data-type' => 'image',
        ]);

    } elseif ($this->isVideo($props['link'])) {
        $link->attr('data-type', 'video');
    } elseif (!$this->iframeVideo($props['link'])) {
        $link->attr('data-type', 'iframe');
    } else {
        $link->attr('data-type', true);
    }

    // Caption
    $caption = '';

    if ($props['title'] && $element['title_display'] != 'item') {

        $caption .= "<h4 class='uk-margin-remove'>{$props['title']}</h4>";

        if ($element['title_display'] == 'lightbox') {
            $props['title'] = '';
        }
    }

    if ($props['content'] && $element['content_display'] != 'item') {

        $caption .= $props['content'];

        if ($element['content_display'] == 'lightbox') {
            $props['content'] = '';
        }
    }

    if ($caption) {
        $link->attr('data-caption', $caption);
    }

} elseif ($link) {

    $link->attr([
        'target' => ['_blank {@link_target}'],
        'uk-scroll' => str_starts_with((string) $props['link'], '#'),
    ]);

}

if ($link && $element['overlay_link']) {

    $el->attr($link->attrs + [

        'class' => [
            // Needs to be child of `uk-light` or `uk-dark`
            'uk-link-toggle',
        ],

    ]);

    $props['title'] = $this->striptags($props['title']);
    $props['meta'] = $this->striptags($props['meta']);
    $props['content'] = $this->striptags($props['content']);

    if ($props['title'] && $element['title_hover_style'] != 'reset') {
        $props['title'] = $this->el('span', [
            'class' => [
                'uk-link-{title_hover_style: heading}',
                'uk-link {!title_hover_style}',
            ],
        ], $props['title'])->render($element);
    }

}

if ($link && $props['title'] && $element['title_link']) {

    $props['title'] = $link($element, [
        'class' => [
            'uk-link-{title_hover_style}',
        ],
    ], $this->striptags($props['title']));

}

if ($link && ($props['link_text'] || $element['link_text'])) {

    if ($element['overlay_link']) {
        $link = $this->el('div');
    }

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
            'uk-transition-{link_transition} {@overlay_hover}',
            // Keep link style if overlay link
            'uk-link {@link_style:} {@overlay_link}',
            'uk-text-muted {@link_style: link-muted} {@overlay_link}',
        ],

    ]);

}

return $link;
