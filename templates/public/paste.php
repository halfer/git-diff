<style type="text/css">
	code {
		white-space: pre;
	}
</style>

<p>
	This page is to see what HTML is best to support copy and pasting from the browser.
</p>

<ul>
	<li>&lt;pre&gt; tags cause double line-breaks in FF when pasted. Can we do something in JS
		to fix this?</li>
	<li><s>&lt;code&gt; tags fix the line-breaks problem, but any tabs or spaces used for indentation
		are collapsed</s>. This can be fixed in JavaScript by replacing tabs/spaces with non-breaking
		space entities</li>
	<li><s>Have just one &lt;pre&gt; tag.</s> This seems to be affected by the same space/tab
		collapsing issue (in FF/Ubuntu, at least)</li>
	<li>We could use a table, but urgh!</li>
</ul>

Demonstration of code tags:

<div class="container">
	<div class="file">
		<div class="left side">
			<div class="diff-content">

				<div
						class="section "
				>
					<div class="line diff-line ">
						<code> */</code>
					</div>
					<div class="line diff-line ">
						<code>function deletePost(PDO $pdo, $postId)</code>
					</div>
					<div class="line diff-line ">
						<code>{</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>	$sqls = array(</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		// Delete comments first, to remove the foreign key objection</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		&quot;DELETE FROM</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			comment</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		WHERE</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			post_id = :id&quot;,</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		// Now we can delete the post</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		&quot;DELETE FROM</code>
					</div>
					<div class="line diff-line ">
						<code>			post</code>
					</div>
					<div class="line diff-line ">
						<code>		WHERE</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			id = :id&quot;,</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>	);</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code></code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>	foreach ($sqls as $sql)</code>
					</div>
					<div class="line diff-line ">
						<code>	{</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		$stmt = $pdo-&gt;prepare($sql);</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		if ($stmt === false)</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		{</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			throw new Exception('There was a problem preparing this query');</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		}</code>
					</div>
					<div class="line diff-line ">
						<code></code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		$result = $stmt-&gt;execute(</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			array('id' =&gt; $postId, )</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		);</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code></code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		// Don't continue if something went wrong</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		if ($result === false)</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		{</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>			break;</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>		}</code>
					</div>
					<div class="line diff-line diff-line-added">
						<code>	}</code>
					</div>
					<div class="line diff-line ">
						<code></code>
					</div>
					<div class="line diff-line ">
						<code>	return $result !== false;</code>
					</div>
					<div class="line diff-line ">
						<code>}</code>
					</div>
					<div class="line diff-line ">
						<code></code>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

Demonstration of a single pre tag:

<div class="container">
	<div class="file">
		<div class="left side">
			<div class="diff-content">

				<div
						class="section "
				>
					<pre><div class="line diff-line "><code> */</code></div><div class="line diff-line "><code>function deletePost(PDO $pdo, $postId)</code></div><div class="line diff-line "><code>{</code></div><div class="line diff-line diff-line-added"><code>	$sqls = array(</code></div><div class="line diff-line diff-line-added"><code>		// Delete comments first, to remove the foreign key objection</code></div><div class="line diff-line diff-line-added"><code>		&quot;DELETE FROM</code></div><div class="line diff-line diff-line-added"><code>			comment</code></div><div class="line diff-line diff-line-added"><code>		WHERE</code></div><div class="line diff-line diff-line-added"><code>			post_id = :id&quot;,</code></div></pre>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
/*
 * @todo Remove jQuery, set up a demo that uses a CDN version - and then systems that employ
 * this can just load jQuery themselves
 */
?>
<script type="text/javascript" src="http://php-tutorial-website.local/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// Set up replacement indent
		var indentString = '&nbsp;&nbsp;&nbsp;&nbsp;';

		// Iterate across each code block
		var codeBlocks = $('.container .file .side');
		codeBlocks.each(function(ord, blockElement) {
			// Iterate across each line
			var lines = $(blockElement).find('.line code');
			lines.each(function(ord, lineElement) {
				var lineText = $(lineElement).text();
				var newText = lineText.replace(/^\t+/, '');
				if (newText.length < lineText.length)
				{
					var addSpaces = lineText.length - newText.length;
					for(var i = 0; i < addSpaces; i++)
					{
						newText = indentString + newText;
					}
					$(lineElement).html(newText);
				}
			});
		});
	});
</script>