<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<article>
    <header>
        <h1><?= $res->title ?></h1>
        <p><i>Latest update: <time datetime="<?= $res->updated ?>" pubdate><?= $res->published ?></time></i></p>
    </header>
    <?= $text ?>
</article>
