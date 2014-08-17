<?php // jQuery should already be loaded before we load this ?>
<script type="text/javascript" src="/js/indenter.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.container').gitDiffIndentTabs();
	});
</script>

<p>
	This page is to see what HTML is best to support copy and pasting from the browser.
</p>

<ol>
	<li>
		&lt;pre&gt; tags cause double line-breaks in FF when pasted, so I gave up with that.
	</li>
	<li>
		&lt;code&gt; tags fix the line-breaks problem, but any tabs or spaces used for indentation
		are collapsed when pasted.
	</li>
	<li>Have just one &lt;pre&gt; tag. That would work, but seems to be affected by the same
		space/tab collapsing issue (in FF/Ubuntu, at least). Since this offers no advantage,
		I've not gone down this road.
	</li>
	<li>
		I could use a table, but urgh!
	</li>
</ol>

<p>I've used option (2) and fixed the collapsing spaces with some JavaScript, which swaps
tabs with hard spaces.</p>

<p>Demonstration of code tags:</p>

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

<p>Demonstration of a single pre tag:</p>

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
