<?php

namespace YOOtheme;

include_once COLORFUL_YT_PATH . 'src/Color.php';
include_once COLORFUL_YT_PATH . 'src/Palette.php';

return [
    'transforms' => [
        'render' => function ($node) {
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
            // Don't render element if content fields are empty
            return Str::length($node->props['title']) ||
                Str::length($node->props['meta']) ||
                Str::length($node->props['content']) ||
                $node->props['image'] ||
                $node->props['icon'];
        },
    ],

    'updates' => [
        '2.8.0-beta.0.13' => function ($node) {
            foreach (['title_style', 'meta_style', 'content_style'] as $prop) {
                if (in_array(Arr::get($node->props, $prop), ['meta', 'lead'])) {
                    $node->props[$prop] = 'text-' . Arr::get($node->props, $prop);
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

        '2.1.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'title_grid_width') === 'xxlarge') {
                $node->props['title_grid_width'] = '2xlarge';
            }

            if (Arr::get($node->props, 'image_grid_width') === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }
        },

        '2.0.0-beta.5.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'link_type' => function ($value) {
                    if ($value === 'content') {
                        return [
                            'title_link' => true,
                            'image_link' => true,
                            'link_text' => '',
                        ];
                    } elseif ($value === 'element') {
                        return [
                            'panel_link' => true,
                            'link_text' => '',
                        ];
                    }
                },
            ]);
        },

        '1.22.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'title_breakpoint' => 'title_grid_breakpoint',
                'image_breakpoint' => 'image_grid_breakpoint',
                'title_gutter' => function ($value) {
                    return ['title_grid_column_gap' => $value, 'title_grid_row_gap' => $value];
                },
                'image_gutter' => function ($value) {
                    return ['image_grid_column_gap' => $value, 'image_grid_row_gap' => $value];
                },
            ]);
        },

        '1.20.0-beta.1.1' => function ($node) {
            Arr::updateKeys($node->props, ['maxwidth_align' => 'block_align']);
        },

        '1.20.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'title_style') === 'heading-hero') {
                $node->props['title_style'] = 'heading-xlarge';
            }

            if (Arr::get($node->props, 'title_style') === 'heading-primary') {
                $node->props['title_style'] = 'heading-medium';
            }

            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (
                in_array($style, [
                    'craft',
                    'district',
                    'jack-backer',
                    'tomsen-brody',
                    'vision',
                    'florence',
                    'max',
                    'nioh-studio',
                    'sonic',
                    'summit',
                    'trek',
                ])
            ) {
                if (
                    Arr::get($node->props, 'title_style') === 'h1' ||
                    (empty($node->props['title_style']) &&
                        Arr::get($node->props, 'title_element') === 'h1')
                ) {
                    $node->props['title_style'] = 'heading-small';
                }
            }

            if (in_array($style, ['florence', 'max', 'nioh-studio', 'sonic', 'summit', 'trek'])) {
                if (Arr::get($node->props, 'title_style') === 'h2') {
                    $node->props['title_style'] =
                        Arr::get($node->props, 'title_element') === 'h1' ? '' : 'h1';
                } elseif (
                    empty($node->props['title_style']) &&
                    Arr::get($node->props, 'title_element') === 'h2'
                ) {
                    $node->props['title_style'] = 'h1';
                }
            }

            if (in_array($style, ['fuse', 'horizon', 'joline', 'juno', 'lilian', 'vibe', 'yard'])) {
                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] = 'heading-small';
                }
            }

            if (in_array($style, ['copper-hill'])) {
                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] =
                        Arr::get($node->props, 'title_element') === 'h1' ? '' : 'h1';
                } elseif (Arr::get($node->props, 'title_style') === 'h1') {
                    $node->props['title_style'] =
                        Arr::get($node->props, 'title_element') === 'h2' ? '' : 'h2';
                } elseif (
                    empty($node->props['title_style']) &&
                    Arr::get($node->props, 'title_element') === 'h1'
                ) {
                    $node->props['title_style'] = 'h2';
                }
            }

            if (in_array($style, ['trek', 'fjord'])) {
                if (Arr::get($node->props, 'title_style') === 'heading-medium') {
                    $node->props['title_style'] = 'heading-large';
                }
            }

            if (in_array($style, ['juno', 'vibe', 'yard'])) {
                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-medium';
                }
            }

            if (
                in_array($style, [
                    'district',
                    'florence',
                    'flow',
                    'nioh-studio',
                    'summit',
                    'vision',
                ])
            ) {
                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-large';
                }
            }

            if (in_array($style, ['lilian'])) {
                if (Arr::get($node->props, 'title_style') === 'heading-xlarge') {
                    $node->props['title_style'] = 'heading-2xlarge';
                }
            }
        },

        '1.19.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'meta_align') === 'top') {
                $node->props['meta_align'] = 'above-title';
            }

            if (Arr::get($node->props, 'meta_align') === 'bottom') {
                $node->props['meta_align'] = 'below-title';
            }

            if (Arr::get($node->props, 'link_style') === 'panel') {
                if (Arr::get($node->props, 'panel_style')) {
                    $node->props['link_type'] = 'element';
                } else {
                    $node->props['link_type'] = 'content';
                }
                $node->props['link_style'] = 'default';
            }

            Arr::updateKeys($node->props, ['image_card' => 'panel_card_image']);
        },

        '1.18.10.3' => function ($node) {
            if (Arr::get($node->props, 'meta_align') === 'top') {
                if (!empty($node->props['meta_margin'])) {
                    $node->props['title_margin'] = $node->props['meta_margin'];
                }
                $node->props['meta_margin'] = '';
            }
        },

        '1.18.10.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'image_inline_svg' => 'image_svg_inline',
                'image_animate_svg' => 'image_svg_animate',
            ]);
        },

        '1.18.0' => function ($node) {
            if (
                !isset($node->props['image_box_decoration']) &&
                Arr::get($node->props, 'image_box_shadow_bottom') === true
            ) {
                $node->props['image_box_decoration'] = 'shadow';
            }

            if (
                !isset($node->props['meta_color']) &&
                Arr::get($node->props, 'meta_style') === 'muted'
            ) {
                $node->props['meta_color'] = 'muted';
                $node->props['meta_style'] = '';
            }
        },
    ],
];
