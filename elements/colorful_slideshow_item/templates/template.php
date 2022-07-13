<?php

// Extra effect for pull/push
$opacity = ($props['text_color'] ?: $element['text_color']) === 'light' ? '0.5' : '0.2';

$pull_push = $this->el('div', [

    'class' => [
        'uk-position-cover',
    ],

    'uk-slideshow-parallax' => $element['slideshow_animation'] == 'push'
        ? 'scale: 1.2,1.2,1'
        : 'scale: 1,1.2,1.2',
]);

$pull_push_overlay = $this->el('div', [

    'class' => [
        'uk-position-cover',
    ],

    'uk-slideshow-parallax' => $element['slideshow_animation'] == 'push'
        ? "opacity: 0,0,{$opacity}; backgroundColor: #000,#000"
        : "opacity: {$opacity},0,0; backgroundColor: #000,#000",
]);

// Kenburns
$kenburns_alternate = [
    'center-left',
    'top-right',
    'bottom-left',
    'top-center',
    '', // center-center
    'bottom-right',
];

$kenburns = $this->el('div', [

    'class' => [
        'uk-position-cover uk-animation-kenburns uk-animation-reverse',
        'uk-transform-origin-{0}' => $element['slideshow_kenburns'] == 'alternate'
            ? $kenburns_alternate[$i % count($kenburns_alternate)]
            : ($element['slideshow_kenburns'] == 'center-center'
                ? ''
                : $element['slideshow_kenburns']),
    ],

    'style' => [
        '-webkit-animation-duration: {slideshow_kenburns_duration}s;',
        'animation-duration: {slideshow_kenburns_duration}s;',
    ],

]);

// Image
$image = $this->el('image', [

    'class' => [
        'el-image',
    ],

    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'loading' => $element['image_loading'] ? false : null,
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => true,
    'thumbnail' => true,
]);

// Video
if ($iframe = $this->iframeVideo($props['video'])) {

    $video = $this->el('iframe', [

        'class' => [
            'uk-disabled',
        ],

        'src' => $iframe,
        'frameborder' => '0',

    ]);
} else {

    $video = $this->el('video', [

        'src' => $props['video'],
        'controls' => false,
        'loop' => true,
        'autoplay' => true,
        'muted' => true,
        'playsinline' => true,

    ]);
}

$video->attr([

    'width' => $element['image_width'],
    'height' => $element['image_height'],

    'class' => ['el-image'],

    'uk-cover' => true,

]);


// Blend mode
if ($props['media_blend_mode']) {
    if (in_array($element['slideshow_animation'], ['push', 'pull'])) {
        $pull_push->attr('class', ["uk-blend-{$props['media_blend_mode']}"]);
    } elseif ($element['slideshow_kenburns']) {
        $kenburns->attr('class', ["uk-blend-{$props['media_blend_mode']}"]);
    } elseif ($props['image']) {
        $image->attr('class', ["uk-blend-{$props['media_blend_mode']}"]);
    } elseif ($props['video']) {
        $video->attr('class', ["uk-blend-{$props['media_blend_mode']}"]);
    }
}

// Overlay Position
$position = $this->el('div', [

    'class' => [
        'uk-position-cover uk-flex',
        'uk-flex-top {@overlay_position: .*top.*}',
        'uk-flex-bottom {@overlay_position: .*bottom.*}',
        'uk-flex-left {@overlay_position: .*left.*}',
        'uk-flex-right {@overlay_position: .*right.*}',
        'uk-flex-center {@overlay_position: (|.*-)center}',
        'uk-flex-middle {@overlay_position: center(|-.*)}',
        'uk-container {@overlay_container}',
        'uk-container-{!overlay_container: |default}',
        'uk-section[-{overlay_container_padding}] {@overlay_container}',
        'uk-padding[-{overlay_margin}] {@!overlay_margin: none} {@!overlay_container}',
    ],

]);

// Overlay
$overlay = $this->el('div', [

    'class' => [
        'el-overlay',
        'uk-flex-1 {@overlay_position: top|bottom}',
        'uk-panel {@!overlay_style}',
        'uk-overlay uk-{overlay_style}',
        'uk-padding-{overlay_padding} {@overlay_style}',
        'uk-width-{overlay_width} {@!overlay_position: top|bottom}',
        'uk-transition-{overlay_animation} {@!overlay_animation: |parallax}',
        'uk-{0} {@!overlay_style}' => $props['text_color'] ?: $element['text_color'],
        'uk-margin-remove-first-child',
        'uk-light' => isset($props['colorful_text_color']) ? in_array($props['colorful_text_color'], ['white', 'light'])  : false,

    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']($element, 'overlay_'),
] + (isset($props['colorful_background_color']) ? [
    'style' => [
        "background-color: {$props['colorful_background_color']} !important;"
    ]
] : []));

?>

<?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
    <?= $pull_push($element) ?>
<?php endif ?>

<?php if ($element['slideshow_kenburns']) : ?>
    <?= $kenburns($element) ?>
<?php endif ?>

<?= $props['image'] ? $image() : '' ?>
<?= $props['video'] && !$props['image'] ? $video([], '') : '' ?>

<?php if ($element['slideshow_kenburns']) : ?>
    </div>
<?php endif ?>

<?php if (in_array($element['slideshow_animation'], ['push', 'pull'])) : ?>
    </div>
    <?= $pull_push_overlay($element, '') ?>
<?php endif ?>

<?php if ($props['media_overlay']) : ?>
    <div class="uk-position-cover" style="background-color:<?= $props['media_overlay'] ?>"></div>
<?php endif ?>

<?php if ($props['title'] || $props['meta'] || $props['content'] || $props['link']) : ?>
    <?= $position($element) ?>
    <?= $overlay($element) ?>

    <?= $this->render("{$__dir}/template-content", compact('props')) ?>

    </div>
    </div>
<?php endif ?>