<?php

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            $node->tags = [];

            // Filter tags
            if (!empty($node->props['filter'])) {
                foreach ($node->children as $child) {
                    $child->tags = [];

                    foreach (explode(',', Arr::get($child->props, 'tags', '') ?: '') as $tag) {
                        // Strip tags as precaution if tags are mapped dynamically
                        $tag = strip_tags($tag);

                        if ($key = str_replace(' ', '-', trim($tag))) {
                            $child->tags[$key] = trim($tag);
                        }
                    }

                    $node->tags += $child->tags;
                }

                natsort($node->tags);

                if ($node->props['filter_reverse']) {
                    $node->tags = array_reverse($node->tags, true);
                }
            }
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
        
        '2.4.14.2' => function ($node) {
            $node->props['animation'] = Arr::get($node->props, 'item_animation');
            $node->props['item_animation'] = true;
        },

        '2.1.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'item_maxwidth') === 'xxlarge') {
                $node->props['item_maxwidth'] = '2xlarge';
            }
        },

        '2.0.0-beta.8.1' => function ($node) {
            Arr::updateKeys($node->props, ['grid_align' => 'grid_column_align']);
        },

        '2.0.0-beta.5.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'link_type' => function ($value) {
                    if ($value === 'content') {
                        return [
                            'title_link' => true,
                            'link_text' => '',
                        ];
                    } elseif ($value === 'element') {
                        return [
                            'overlay_link' => true,
                            'link_text' => '',
                        ];
                    }
                },
            ]);
        },

        '1.22.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'divider' => 'grid_divider',
                'filter_breakpoint' => 'filter_grid_breakpoint',
                'gutter' => function ($value) {
                    return ['grid_column_gap' => $value, 'grid_row_gap' => $value];
                },
                'filter_gutter' => function ($value) {
                    return ['filter_grid_column_gap' => $value, 'filter_grid_row_gap' => $value];
                },
            ]);
        },

        '1.20.0-beta.1.1' => function ($node) {
            Arr::updateKeys($node->props, ['maxwidth_align' => 'block_align']);
        },

        '1.20.0-beta.0.1' => function ($node) {
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
        },

        '1.19.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'meta_align') === 'top') {
                $node->props['meta_align'] = 'above-title';
            }

            if (Arr::get($node->props, 'meta_align') === 'bottom') {
                $node->props['meta_align'] = 'below-title';
            }

            $node->props['link_type'] = 'element';
        },

        '1.18.10.3' => function ($node) {
            if (Arr::get($node->props, 'meta_align') === 'top') {
                if (!empty($node->props['meta_margin'])) {
                    $node->props['title_margin'] = $node->props['meta_margin'];
                }
                $node->props['meta_margin'] = '';
            }
        },

        '1.18.0' => function ($node) {
            if (
                !isset($node->props['grid_parallax']) &&
                Arr::get($node->props, 'grid_mode') === 'parallax'
            ) {
                $node->props['grid_parallax'] = Arr::get($node->props, 'grid_parallax_y');
            }

            if (!isset($node->props['show_hover_image'])) {
                $node->props['show_hover_image'] = Arr::get($node->props, 'show_image2');
            }

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
