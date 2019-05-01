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
    $player = $game->getPlayer();
    $winner = false;

    $histogram = new \Linder\Hundred2\Histogram();
    $histogram->injectData($game);

    // Check if we have any winners.
    foreach ($game->getPlayers() as $index => $play) {
        if ($play->getScore() >= $game->getMaxScore()) {
            $winner = true;
        }
    }

    // Print the players and their scores
    foreach ($game->getPlayers() as $index => $play) {
        echo "<h3>" . ($play->isPlayer() ? "Spelare" : "Dator") .
        " #" . ($index + 1) . " - " . $play->getScore() . " poäng. " .
        ($play->getScore() >= $game->getMaxScore() ? "Vinnare!" : null);
        // If its the current player, print the throw/round score
        if ($index == $game->getTurn()) {
            if (($play->getRoundScore() != 0 && $play->isSafe()) ||
                ($play->getRoundScore() == 0 && !$play->isSafe())) {
                echo " Du kastade: " . implode(", ", $play->getValues()) .
                ". Poäng denna rundan: " . $play->getRoundScore();
            } elseif (!$winner) {
                // Or that its his turn.
                echo " Det är din tur!";
            }
        }
        echo "</h3>";
    }
    ?>
    <form class="game" method="POST" action="postProcess">
        <?php
        // If we dont have a winner print the buttons for roll/save
        if (!$winner) {
            if ($player->isSafe()) {
                echo '<input type="submit" name="roll" value="Kasta tärningarna">';
                echo '<input type="submit" name="save" value="Spara">';
            } else {
                echo '<input type="submit" name="save" value="Lämna över">';
            }
            echo $br;
        }
        ?>
        <input type="submit" name="init" value="Starta om spelet">
        <?php
        echo $br;
        echo $histogram->getAsText();
        $all = array_count_values($game->getAllThrows());
        if ($all) {
            echo "1 är slagen " . (array_key_exists(1, $all) ? $all[1]/count($game->getAllThrows())*100 : "0") . "%";
        }
        ?>
    </form>
</article>
