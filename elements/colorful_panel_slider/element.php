<?php

namespace YOOtheme;

return [
    'updates' => [
        '2.8.0-beta.0.13' => function ($node) {
            foreach (['title_style', 'meta_style', 'content_style'] as $prop) {
                if (in_array(Arr::get($node->props, $prop), ['meta', 'lead'])) {
                    $node->props[$prop] = 'text-' . Arr::get($node->props, $prop);
                }
            }
        },
        '2.7.3.1' => function ($node) {
            if (empty($node->props['panel_style']) && empty($node->props['panel_padding'])) {
                foreach ($node->children as $child) {
                    if (
                        isset($child->props->panel_style) &&
                        str_starts_with($child->props->panel_style, 'card-')
                    ) {
                        $node->props['panel_padding'] = 'default';
                        break;
                    }
                }
            }
        },

        '2.7.0-beta.0.5' => function ($node) {
            if (
                isset($node->props['panel_style']) &&
                str_starts_with($node->props['panel_style'], 'card-')
            ) {
                if (empty($node->props['panel_card_size'])) {
                    $node->props['panel_card_size'] = 'default';
                }
                $node->props['panel_padding'] = $node->props['panel_card_size'];
                unset($node->props['panel_card_size']);
            }
        },

        '2.7.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'panel_content_padding' => 'panel_padding',
                'panel_size' => 'panel_card_size',
                'panel_card_image' => 'panel_image_no_padding',
            ]);
        },
    ],
];
