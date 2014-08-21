QUnit.test(
	"Panel alignment",
	function(assert) {
		$('.file').each(function() {
			// Get panels
			var
				lPanel = $(this).find('.left.side'),
				rPanel = $(this).find('.right.side');

			// Always read positions when they are needed, as the QUnit logging can make
			// positions go stale quickly
			assert.equal(
				lPanel.position().top, rPanel.position().top,
				'Check the vertical alignment of the L and R panels'
			);

			var cPositionY = $(this).position().top;
			assert.equal(
				cPositionY, lPanel.position().top,
				'Check the top of the panels in relation to the container'
			);

			var
				lHeight = lPanel.height(),
				rHeight = rPanel.height();
			assert.equal(
				lHeight, rHeight,
				'Check the height of the two panels'
			);

			var
				lPositionX = lPanel.position().left,
				cPositionX = $(this).position().left;
			assert.equal(
				lPositionX, cPositionX,
				'Check the left panel is on the left side'
			);

			// The ceil() is necessary at least in FF30/Ubuntu to get equality :)
			var
				rPositionX = rPanel.position().left + lPanel.width()
				cPositionXR = $(this).position().left + $(this).width();
			assert.equal(
				Math.ceil(rPositionX),
				Math.ceil(cPositionXR),
				'Check that the right panel is on the right side'
			);
		});
	}
);

QUnit.test(
	"Code line height",
	function(assert) {
		$('.file').each(function() {
			// Check that all lines within a file are the same height
			var
				oldHeight = null,
				ok = true;
			$(this).find('.line').each(function() {
				var lineHeight = $(this).height();
				if (oldHeight !== null) {
					if (oldHeight !== lineHeight) {
						// Only assert failure once
						ok = false;
						assert.equal(
							oldHeight,
							lineHeight,
							'Check that all lines within a file are the same height'
						);
						return false; // break
					}
				}
				oldHeight = lineHeight;
			});

			// Only assert success once
			if (ok) {
				assert.ok(true, 'Check that all lines within a file are the same height');
			}
		});
	}
);

QUnit.test(
	"Code line alignment",
	function(assert) {
		var descriptions = {
			'diff-content': 'Check that code lines within a file have the same left position',
			'line-numbers': 'Check that line numbers within a file have the same left position'
		};
		$.each(descriptions, function(className, description) {
			$('.file .side .' + className).each(function() {
				var
					oldLeft = null,
					ok = true;
				$(this).find('.line').each(function() {
					var lineLeft = $(this).position().left;
					if (oldLeft !== null) {
						if (oldLeft !== lineLeft) {
							// Only assert failure once
							ok = false;
							assert.equal(oldLeft, lineLeft, description);
							return false; // break
						}
					}
					oldLeft = lineLeft;
				});

				// Only assert success once
				if (ok) {
					assert.ok(true, description);
				}
			});
		});
	}
);

QUnit.test(
	'Specific diff tests',
	function(assert) {
		var countInnerClasses = function(innerCss, indexes, description) {
			$.each(
				indexes,
				function(index, expectedCount) {
					assert.equal(
						$('#container-' + index + ' ' + innerCss).length,
						expectedCount,
						description + ' for test #' + index
					);
				}
			);
		};

		// Count insertions
		countInnerClasses(
			'.diff-line-added',
			new Array(3, 0, 1, 1, 3),
			'Check number of insertions'
		);

		// Count deletions
		countInnerClasses(
			'.diff-line-deleted',
			new Array(0, 2, 1, 1, 3),
			'Check number of deletions'
		);

		// Left-empties
		countInnerClasses(
			'.left .diff-line-empty',
			new Array(3, 0, 1, 0, 0),
			'Check number of empty lines on the left'
		);

		// Right-empties
		countInnerClasses(
			'.right .diff-line-empty',
			new Array(0, 2, 1, 0, 0),
			'Check number of empty lines on the right'
		);
	}
);