<?php if ($props['image']) : ?>
<img src="<?= $props['image'] ?>" alt="<?= $props['image_alt'] ?>">
<?php elseif ($props['video']) : ?>
<?php if ($this->iframeVideo($props['video'], [], false)) : ?>
<iframe src="<?= $props['video'] ?>"></iframe>
<?php else : ?>
<video src="<?= $props['video'] ?>"></video>
<?php endif ?>
<?php endif ?>

<?php if ($props['title']) : ?>
<<?= $element['title_element'] ?>><?= $props['title'] ?></<?= $element['title_element'] ?>>
<?php endif ?>

<?php if ($props['meta']) : ?>
<p><?= $props['meta'] ?></p>
<?php endif ?>

<?php if ($props['content']) : ?>
<div><?= $props['content'] ?></div>
<?php endif ?>

<?php if ($props['link']) : ?>
<p><a href="<?= $props['link'] ?>"><?= $props['link_text'] ?: $element['link_text'] ?></a></p>
<?php endif ?>
