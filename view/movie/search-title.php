<?php

namespace Anax\View;

?>

<form method="post" action="search">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="searchtitle">
    <p>
        <label>Title (use % as wildcard):</label>
        <input type="search" name="search" value="<?= $search ?>"/>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
        <a href="<?= url("movie/show") ?>">Show all</a>
    </p>
    </fieldset>
</form>
