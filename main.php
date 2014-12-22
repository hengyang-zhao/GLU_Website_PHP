<?php require_once("utility.php"); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GLU - GPU LU Solver</title>
        <link rel='stylesheet' type='text/css' href='styles.css' />
    </head>
    <body>
        <h1>Welcome to G.L.U.<br>The GPU LU solver for sparse linear equations</h1>
        <h2>Introduction</h2>
        <p>Here goes the introduction</p>

        <h2>Publications</h2>
        <ul>
            <li>Publication 1</li>
            <li>Publication 2</li>
            <li>Publication 3</li>
        </ul>

        <h2>Documentation</h2>
        <p>Content...</p>

        <h2>Acknowledgement</h2>
        <p>Content...</p>

        <h2>Apply for a download</h2>
        <p>Content...</p>
        <form action="index.php" method="POST">
            <div class="app">
            <table class="reg">
                <colgroup>
                    <col style="width: 120px; text-align: right;">
                    <col style="width: 400px">
                    <col style="width: 150">
                </colgroup>
                <tbody>
                <tr>
                    <td>First name</td>
                    <td><input type="text" name="firstName"></td>
                    <td><span class="desc">20 chars max.</span><br> <span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type="text" name="lastName"></td>
                    <td><span class="desc">20 chars max.</span><br><span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td><input type="text" name="email"></td>
                    <td><span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>Phone number</td>
                    <td><input type="text" name="phone"></td>
                    <td><span class="desc"></span></td>
                </tr>
                <tr>
                    <td>Package name</td>
                    <td>
                        <?php
                        $files = enumerate_packages($GLOBALS["package_dir"]);
                        $checked = ' checked '; # check the first one by default
                        foreach ($files as $f) {
                            $f = htmlentities($f);
                            echo '<label><input type="radio" name="package" style="width: auto; margin-right: 10px"'
                                . $checked . 'value="' . $f . '"><i>' . $f . '</i></label><br>';
                            if ($checked) $checked = "";
                        }
                        ?>
                    </td>
                    <td><span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>Organization</td>
                    <td><input type="text" name="organization"></td>
                    <td><span class="desc">40 chars max.</span><br><span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>Research area</td>
                    <td><textarea class="app" name="researchArea" rows="3"></textarea></td>
                    <td><span class="desc">80 chars max.</span><br><span class="req">(*required)</span></td>
                </tr>
                <tr>
                    <td>Why this download?</td>
                    <td><textarea class="app" name="reason" rows="5"></textarea></td>
                    <td><span class="desc">200 chars max.</span><br></td>
                </tr>
                </tbody>
                <tr>
                    <td colspan="3" align="center">
                        <?php echo recaptcha_get_html($GLOBALS["recaptcha_site_key"]); ?>
                    </td>
                </tr>
            </table>
            <input type="submit" value="request library">
            </div>
        </form>
    </body>
</html>

