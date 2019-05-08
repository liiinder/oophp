<?php

namespace Anax\View;

?>

<form method="post" action="search">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="searchyear">
    <p>
        <label>Created between: 
        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        - 
        <input type="number" name="year2" value="<?= $year2 ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
        <a href="<?= url("movie/show") ?>">Show all</a>
    </p>
    </fieldset>
</form>
