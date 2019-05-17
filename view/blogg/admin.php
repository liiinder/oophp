<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<article>
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
            <th>Actions</th>
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
            <td>
                <a class="icons" href="<?= url("blogg/edit/" . $row->id) ?>" title="Edit this content">
                    <i class="fas fa-edit" aria-hidden="true"></i>
                </a>
                <a class="icons" href="<?= url("blogg/delete/" . $row->id) ?>" title="Delete this content">
                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</article>
