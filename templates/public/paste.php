<style type="text/css">
	code {
		white-space: pre;
	}
</style>

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
