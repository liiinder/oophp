            </article>
        </main>
        <footer class="site-footer">
            Validatorer: <a href="http://validator.w3.org/check/referer">HTML5</a> -
            <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> -
            <a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a>
            <br>
            <?php
                setlocale(LC_TIME, "sv_SE");
                $time = strftime("%Y-%m-%d %T", filemtime(__FILE__));
                $time1 = strftime("%e %h %Y", filemtime(__FILE__));
                echo("Uppdaterad <time datetime=\"$time\">$time1</time> av Kristoffer Linder");
            ?>
        </footer>
    </body>
</html>
