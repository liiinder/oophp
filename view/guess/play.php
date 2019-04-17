<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?><article>
    <h3>Make a guess between 1 and 100.</h3>
    <?= "<h1>You have " , $tries , ($tries == 1) ? " try" : " tries" , " left.</h1>" ?>
    <form class="game" method="POST" action="post-process">
        <input type="number" name="guess" placeholder="Enter a number">
        <br>
        <input type="submit" name="make" value="Make guess"><input type="submit" name="reset" value="Reset game"><input type="submit" name="cheat" value="Cheat">
    </form>
    <h3><?= $content ?></h3>
</article>
