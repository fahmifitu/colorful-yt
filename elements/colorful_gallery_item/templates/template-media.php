<?php

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

if ($props['image']) {
    $image = include "{$__dir}/template-image.php";
} elseif ($props['video']) {
    $image = include "{$__dir}/template-video.php";
} elseif ($props['hover_image']) {
    $image = include "{$__dir}/template-image.php";
}

// Min-height Placeholder
if ($element['image_min_height']) {

    $placeholder = clone $image;

    $placeholder->attr([
        'class' => ['uk-invisible'],
    ]);

    if (!$props['image'] && $props['video']) {
        $placeholder->attr([
            'autoplay' => false,
        ]);
    }

}

// Image
$image->attr([

    'class' => [
        'el-image',
        'uk-blend-{0}' => $props['media_blend_mode'],
        'uk-transition-{image_transition}',
        'uk-transition-opaque' => $props['image'] || $props['video'],
        'uk-transition-fade {@!image_transition}' => $props['hover_image'] && !($props['image'] || $props['video']),
    ],

    'uk-cover' => (bool) $element['image_min_height'],

]);

// Hover Image
if ($props['hover_image'] && ($props['image'] || $props['video'])) {
    $hover_image = include "{$__dir}/template-hover-image.php";
}

?>

<?php if ($element['image_min_height']) : ?>
<?= $placeholder($element, !$props['image'] && $props['video'] ? '' : null) // Closing tag for video element ?>
<?php endif ?>

<?= $image($element, !$props['image'] && $props['video'] ? '' : null) // Closing tag for video element ?>

<?php if ($props['hover_image'] && ($props['image'] || $props['video'])) : ?>
<?= $hover_image($element) ?>
<?php endif ?>
