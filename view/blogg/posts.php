<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
if (!$res) {
    return;
}
?>

<article>

<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1><a href="<?= url("blogg/post/" . $row->slug) ?>"><?= $row->title ?></a></h1>
        <p><i>Published: <time datetime="<?= $row->published ?>" pubdate><?= $row->published ?></time></i></p>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>
