git-diff
========

This is a simple PHP library to render Git diff output as `div`-based HTML output. Features:

* Clipboard copy from either side (often diff libraries intermingle left/right, making copying difficult)
* Line numbering (can be turned off)
* Sections without changes are indicated
* CSS output is easily restyled

A demo file is included, or you can simply do something like this:

    <?php

    // Grab diff output from the git binary
    $diffStr = `git diff changedfile`;

    // Analyse it here
    $gitDiff = new \ilovephp\DiffPage();
    $gitDiff->parseDiff($diffStr);

    // Turn line numbers off if required (default = on)
    $gitDiff->setEnableLineNumbers(false);

    // Render it here
    $gitDiff->render();

License is GPL2 or later.
