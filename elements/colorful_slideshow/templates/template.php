<?php

$el = $this->el('div', [

    'uk-slideshow' => $this->expr([
        'ratio: {0};' => $props['slideshow_height'] ? 'false' : $props['slideshow_ratio'],
        'minHeight: {slideshow_min_height}; {@!slideshow_height}',
        'maxHeight: {slideshow_max_height}; {@!slideshow_height}',
        'animation: {slideshow_animation};',
        'velocity: {slideshow_velocity};',
        'autoplay: {slideshow_autoplay}; [pauseOnHover: false; {!slideshow_autoplay_pause}; ] [autoplayInterval: {slideshow_autoplay_interval}000;]',
    ], $props) ?: true,

]);

// Container
$container = $this->el('div', [

    'class' => [
        'uk-position-relative',
        'uk-visible-toggle {@slidenav} {@slidenav_hover}',
    ],

    'tabindex' => ['-1 {@slidenav} {@slidenav_hover}'],

]);

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom uk-display-block {@slideshow_box_decoration: shadow}',
        'tm-mask-default {@slideshow_box_decoration: mask}',
        'tm-box-decoration-{slideshow_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@slideshow_box_decoration_inverse} {@slideshow_box_decoration: default|primary|secondary}',
    ],

]);

// Items
$items = $this->el('ul', [

    'class' => [
        'uk-slideshow-items',
        'uk-box-shadow-{slideshow_box_shadow}',
    ],

    'uk-height-viewport' => $props['slideshow_height'] ? [
        'offset-top: true;',
        'minHeight: {slideshow_min_height};',
        'offset-bottom: 20; {@slideshow_height: percent}',
        'offset-bottom: !.uk-section +; {@slideshow_height: section}',
    ] : false,

]);

?>

<?= $el($props, $attrs) ?>

    <?= $container($props) ?>

        <?php if ($props['slideshow_box_decoration']) : ?>
        <?= $decoration($props) ?>
        <?php endif ?>

            <?= $items($props) ?>
                <?php foreach ($children as $i => $child) : ?>
                <li class="el-item" <?= $child->props['media_background'] ? "style=\"background-color: {$child->props['media_background']};\"" : '' ?>>
                    <?= $builder->render($child, ['i' => $i, 'element' => $props]) ?>
                </li>
                <?php endforeach ?>
            </ul>

        <?php if ($props['slideshow_box_decoration']) : ?>
        </div>
        <?php endif ?>

        <?php if ($props['slidenav']) : ?>
        <?= $this->render("{$__dir}/template-slidenav") ?>
        <?php endif ?>

        <?php if ($props['nav'] && !$props['nav_below']) : ?>
        <?= $this->render("{$__dir}/template-nav") ?>
        <?php endif ?>

    </div>

    <?php if ($props['nav'] && $props['nav_below']) : ?>
    <?= $this->render("{$__dir}/template-nav") ?>
    <?php endif ?>

</div>
