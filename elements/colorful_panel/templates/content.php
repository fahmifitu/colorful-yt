<?php if ($props['image'] || $props['title'] || $props['meta'] || $props['content'] || $props['link']) : ?>
<div>

    <?php if ($props['image']) : ?>
    <img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
    <?php endif ?>

    <?php if ($props['title']) : ?>
    <<?= $props['title_element'] ?>><?= $props['title'] ?></<?= $props['title_element'] ?>>
    <?php endif ?>

    <?php if ($props['meta']) : ?>
    <p><?= $props['meta'] ?></p>
    <?php endif ?>

    <?php if ($props['content']) : ?>
    <div><?= $props['content'] ?></div>
    <?php endif ?>

    <?php if ($props['link']) : ?>
    <p><a href="<?= $props['link'] ?>"><?= $props['link_text'] ?></a></p>
    <?php endif ?>

</div>
<?php endif ?>
