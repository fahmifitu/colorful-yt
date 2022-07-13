<?php

namespace YOOtheme;

include_once COLORFUL_YT_PATH . 'src/Color.php';
include_once COLORFUL_YT_PATH . 'src/Palette.php';

return [
    'transforms' => [
        'render' => function ($node, $params) {
            if ($node->props['colorful_type'] === 'image') {
                if ($node->props['image']) {
                    $palette = \League\ColorExtractor\Palette::fromFilename($node->props['image']);
                    $colors = $palette->getMostUsedColors(1);

                    foreach ($colors as $color => $count) {
                        $node->props['colorful_text_color'] = \League\ColorExtractor\Color::getContrastColor($color);
                        $node->props['colorful_background_color'] = \League\ColorExtractor\Color::fromIntToHex($color);
                    }
                }
            } else if ($node->props['colorful_type'] === 'custom') {
                $node->props['colorful_background_color'] = $node->props['panel_background_color'];
                if (in_array($node->props['text_color'], ['light', 'dark'])) {
                    $node->props['colorful_text_color'] = $node->props['text_color'];
                }
                if ($node->props['text_color'] === 'image') {
                    if ($node->props['image']) {
                        $palette = \League\ColorExtractor\Palette::fromFilename($node->props['image']);
                        $colors = $palette->getMostUsedColors(1);

                        foreach ($colors as $color => $count) {
                            $node->props['panel_text_color'] = \League\ColorExtractor\Color::fromIntToHex($color);
                        }
                        $node->props['text_color_hover'] = false;
                    }
                }
            }
            // Display
            foreach (['title', 'meta', 'content', 'link', 'image'] as $key) {
                if (!$params['parent']->props["show_{$key}"]) {
                    $node->props[$key] = '';
                    if ($key === 'image') {
                        $node->props['icon'] = '';
                    }
                }
            }

            // Don't render element if content fields are empty
            return Str::length($node->props['title']) ||
                Str::length($node->props['meta']) ||
                Str::length($node->props['content']) ||
                $node->props['image'] ||
                $node->props['icon'];
        },
    ],
];
