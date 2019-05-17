<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<article>
    <h2>Allt innehåll i databasen</h2>
    <?php
    if (!$res) {
        return;
    }
    ?>
    <table>
        <tr class="first">
            <th>Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Path</th>
            <th>Slug</th>
            <th>Published</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Deleted</th>
        </tr>
    <?php foreach ($res as $row) : ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><?= $row->title ?></td>
            <td><?= $row->type ?></td>
            <td><?= $row->path ?></td>
            <td><?= $row->slug ?></td>
            <td><?= $row->published ?></td>
            <td><?= $row->created ?></td>
            <td><?= $row->updated ?></td>
            <td><?= $row->deleted ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
</article>
