<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<article>
    <form method="POST" action="<?= url("mytextfilter/post-process") ?>">
        <label for="bbcode">bbcode</label>
        <input type="checkbox" id="bbcode" name="bbcode" <?= $myfilter["bbcode"]; ?>>
        <label for="link">Make Clickable</label>
        <input type="checkbox" id="link" name="link" <?= $myfilter["link"]; ?>>
        <label for="markdown">Markdown</label>
        <input type="checkbox" name="markdown" id="markdown" <?= $myfilter["markdown"]; ?>>
        <label for="nl2br">nl2br</label>
        <input type="checkbox" name="nl2br" id="nl2br" <?= $myfilter["nl2br"]; ?>>
        <textarea name="text" id="text" cols="30" rows="10" placeholder="Din text som skall filtreras">
            <?= $myfilter["text"]; ?>
        </textarea>
        <input type="submit" name="doFilter" value="Filtrera texten">
        <hr>
        <?= $myfilter["filtered"] ?>
    </form>
</article>
