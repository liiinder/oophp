<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>

<h1>Redigera id: <?= $res->id ?></h1>
<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= $res->id ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="contentTitle" value="<?= $res->title ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br> 
        <input type="text" name="contentPath" value="<?= $res->path ?>"/>
    </p>

    <p>
        <label>Slug:<br> 
        <input type="text" name="contentSlug" value="<?= $res->slug ?>"/>
    </p>

    <p>
        <label>Text:<br> 
        <textarea name="contentData" rows="10" cols="100"><?= $res->data ?></textarea>
     </p>

     <p>
         <label>Type:<br> 
         <input type="text" name="contentType" value="<?= $res->type ?>"/>
     </p>

     <p>
         <label>Filter: (bbcode, nl2br, link, markdown)<br> 
         <input type="text" name="contentFilter" value="<?= $res->filter ?>"/>
     </p>

     <p>
         <label>Publish:<br> 
         <input type="datetime" name="contentPublish" value="<?= $res->published ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave" value="save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete" value="delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
