<div class="container">
	<div class="file">
		<div class="left side">
			<div class="diff-content">

				<div
						class="section "
				>
					<div class="line diff-line ">
						<pre> */</pre>
					</div>
					<div class="line diff-line ">
						<pre>function deletePost(PDO $pdo, $postId)</pre>
					</div>
					<div class="line diff-line ">
						<pre>{</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>	$sqls = array(</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		// Delete comments first, to remove the foreign key objection</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		&quot;DELETE FROM</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			comment</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		WHERE</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			post_id = :id&quot;,</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		// Now we can delete the post</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		&quot;DELETE FROM</pre>
					</div>
					<div class="line diff-line ">
						<pre>			post</pre>
					</div>
					<div class="line diff-line ">
						<pre>		WHERE</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			id = :id&quot;,</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>	);</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre></pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>	foreach ($sqls as $sql)</pre>
					</div>
					<div class="line diff-line ">
						<pre>	{</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		$stmt = $pdo-&gt;prepare($sql);</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		if ($stmt === false)</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		{</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			throw new Exception('There was a problem preparing this query');</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		}</pre>
					</div>
					<div class="line diff-line ">
						<pre></pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		$result = $stmt-&gt;execute(</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			array('id' =&gt; $postId, )</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		);</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre></pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		// Don't continue if something went wrong</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		if ($result === false)</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		{</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>			break;</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>		}</pre>
					</div>
					<div class="line diff-line diff-line-added">
						<pre>	}</pre>
					</div>
					<div class="line diff-line ">
						<pre></pre>
					</div>
					<div class="line diff-line ">
						<pre>	return $result !== false;</pre>
					</div>
					<div class="line diff-line ">
						<pre>}</pre>
					</div>
					<div class="line diff-line ">
						<pre></pre>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
