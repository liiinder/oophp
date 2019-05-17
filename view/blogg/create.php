<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<article>
    <form method="post">
        <fieldset>
        <legend>Create</legend>

        <p>
            <label>Title:<br> 
            <input type="text" name="contentTitle" value="A Title"/>
            </label>
        </p>

        <p>
            <button type="submit" name="doCreate" value="create"><i class="fas fa-plus" aria-hidden="true"></i> Create</button>
            <button type="reset"><i class="fas fa-undo" aria-hidden="true"></i> Reset</button>
        </p>
        </fieldset>
    </form>

</article>
