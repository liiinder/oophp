<?php

namespace Anax\View;

/**
 * Navbar for my Blogg
 */

?>
<navbar class="navbar">
    <a href="<?= url("blogg/main") ?>">Show all content</a> |
    <a href="<?= url("blogg/admin") ?>">Admin</a> |
    <a href="<?= url("blogg/create") ?>">Create</a> |
    <a href="<?= url("blogg/pages") ?>">Pages</a> |
    <a href="<?= url("blogg/posts") ?>">Blogg</a>
</navbar> 
