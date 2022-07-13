<?php

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            /**
             * @var View $view
             */
            $view = app(View::class);

            // TODO Fix me
            $node->props['parallaxOptions'] =
                $node->props['overlay_animation'] === 'parallax'
                    ? [$view, 'parallaxOptions']
                    : function () {
                        return false;
                    };
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

        '2.8.0-beta.0.3' => function ($node) {
            foreach (['overlay', 'title', 'meta', 'content', 'link'] as $prefix) {
                foreach (['x', 'y', 'scale', 'rotate', 'opacity'] as $prop) {
                    $key = "{$prefix}_parallax_{$prop}";
                    $start = implode(
                        ',',
                        array_map(function ($value) {
                            return trim($value);
                        }, explode(',', Arr::get($node->props, "{$key}_start", '')))
                    );
                    $end = implode(
                        ',',
                        array_map(function ($value) {
                            return trim($value);
                        }, explode(',', Arr::get($node->props, "{$key}_end", '')))
                    );
                    if (strlen($start) || strlen($end)) {
                        $default = in_array($prop, ['scale', 'opacity']) ? 1 : 0;
                        $values = [
                            strlen($start) ? $start : $default,
                            $default,
                            strlen($end) ? $end : $default,
                        ];
                        Arr::set($node->props, $key, implode(',', $values));
                    }
                    Arr::del($node->props, "{$key}_start");
                    Arr::del($node->props, "{$key}_end");
                }
            }
        },
        '2.3.0-beta.1.1' => function ($node) {
            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (in_array($style, ['fjord'])) {
                if (Arr::get($node->props, 'overlay_container') === 'default') {
                    $node->props['overlay_container'] = 'large';
                }
            }
        },

        '2.1.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'overlay_width') === 'xxlarge') {
                $node->props['overlay_width'] = '2xlarge';
            }
        },

        '2.0.0-beta.5.1' => function ($node) {
            /**
             * @var Config $config
             */
            $config = app(Config::class);

            list($style) = explode(':', $config('~theme.style'));

            if (!in_array($style, ['jack-baker', 'morgan-consulting', 'vibe'])) {
                if (Arr::get($node->props, 'overlay_container') === 'large') {
                    $node->props['overlay_container'] = 'xlarge';
                }
            }

            if (
                in_array($style, [
                    'craft',
                    'district',
                    'florence',
                    'makai',
                    'matthew-taylor',
                    'pinewood-lake',
                    'summit',
                    'tomsen-brody',
                    'trek',
                    'vision',
                    'yard',
                ])
            ) {
                if (Arr::get($node->props, 'overlay_container') === 'default') {
                    $node->props['overlay_container'] = 'large';
                }
            }
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
            Arr::updateKeys($node->props, ['thumbnav_inline_svg' => 'thumbnav_svg_inline']);
        },

        '1.18.0' => function ($node) {
            if (
                !isset($node->props['slideshow_box_decoration']) &&
                Arr::get($node->props, 'slideshow_box_shadow_bottom') === true
            ) {
                $node->props['slideshow_box_decoration'] = 'shadow';
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
