<?php

// Here's the files and diffs to look at
$files = array(
	'/test/diffs/add-lines1', '/test/diffs/del-lines1', '/test/diffs/add-del1',
	'/test/diffs/modify-lines1', '/test/diffs/modify-lines2',
);

$pages = array();
$diffs = array();

// Set up demo pages
foreach ($files as $ord => $file)
{
	$pages[$ord] = new \ilovephp\DiffPage();
	$diffs[$ord] = file_get_contents($root . $file);
	$pages[$ord]->parseDiff($diffs[$ord]);
}

?>

<h2>Unit test data</h2>

<div id="qunit" style="max-width: 600px;"></div>

<?php for ($fileNo = 0; $fileNo < count($files); $fileNo++): ?>

	<p>Graphical diff:</p>
	<div class="container">
		<?php $pages[$fileNo]->render() ?>
	</div>

	<p>Raw diff:</p>
	<pre><?php echo htmlspecialchars($diffs[$fileNo]) ?></pre>

<?php endfor ?>

<link rel="stylesheet" href="/styles/qunit-1.15.0.css">
<script type="text/javascript" src="/js/qunit-1.15.0.js"></script>
<script type="text/javascript" src="/js/tests.js"></script>
