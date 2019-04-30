<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

$br = <<<EOD
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
EOD;

?>
<article>
    <?php
    $player = $game->getPlayers()[$game->getTurn()];
    $winner = false;

    foreach ($game->getPlayers() as $index => $play) {
        if ($play->getScore() >= $game->getMaxScore()) {
            $winner = true;
        }
    }

    foreach ($game->getPlayers() as $index => $play) {
        echo "<h3>" . ($play->isPlayer() ? "Spelare" : "Dator") .
        " #" . ($index + 1) . " - " . $play->getScore() . " poäng. " .
        ($play->getScore() >= $game->getMaxScore() ? "Vinnare!" : null);
        if ($index == $game->getTurn()) {
            if (($play->getRound() != 0 && $play->isSafe()) || ($play->getRound() == 0 && !$play->isSafe())) {
                echo " Du kastade: " . implode(", ", $play->getValues()) .
                ". Poäng denna rundan: " . $play->getRound();
            } elseif (!$winner) {
                echo " Det är din tur!";
            }
        }
        echo "</h3>";
    }
    ?>
    <form class="game" method="POST" action="postProcess">
        <?php
        if (!$winner) {
            if ($player->isSafe()) {
                echo '<input type="submit" name="roll" value="Kasta tärningarna">';
            }
            echo '<input type="submit" name="save" value="Spara / Lämna över">';
            echo $br;
        }
        ?>
        <input type="submit" name="init" value="Starta om spelet">
    </form>
</article>
