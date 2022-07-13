<?php

if ($iframe = $this->iframeVideo($props['video'])) {

    $video = $this->el('iframe', [

        'class' => [
            'uk-disabled',
        ],

        'src' => $iframe,
        'frameborder' => '0',
        'uk-responsive' => !$element['image_min_height'],

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

    'uk-video' => [
        'automute: true' => !$element['image_min_height'],
    ],

]);

return $video;
