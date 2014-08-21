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

/**
 * Checks that the specified property on all lines is the same
 * 
 * @todo Is there a standard approach to taking helper functions out of global space?
 */
function checkLinesProperty(assert, lineContainer, description, propertyString) {
	// Check that all lines within a file have the same
	var
		oldProperty = null,
		ok = true;
	lineContainer.find('.line').each(function() {
		// A nice generic way to read a (possibly chained) method/property
		var lineProperty = eval('$(this).' + propertyString);
		if (oldProperty !== null) {
			if (oldProperty !== lineProperty) {
				// Only assert failure once
				ok = false;
				assert.equal(oldProperty, lineProperty, description);
				return false; // break
			}
		}
		oldProperty = lineProperty;
	});

	// Only assert success once
	if (ok) {
		assert.ok(true, description);
	}
}

QUnit.test(
	"Code line height",
	function(assert) {
		$('.file').each(function() {
			// Check that all lines within a file are the same height
			return checkLinesProperty(
				assert,
				$(this),
				'Check that all lines within a file are the same height',
				'height()'
			);
		});
	}
);

QUnit.test(
	"Code and line number left alignment",
	function(assert) {
		$('.file .side .diff-content').each(function() {
			checkLinesProperty(
				assert,
				$(this),
				'Check that code lines within a file have the same left position',
				'position().left'
			);
		});

		$('.file .side .line-numbers').each(function() {
			checkLinesProperty(
				assert,
				$(this),
				'Check that line numbers within a file have the same left position',
				'position().left'
			);
		});
	}
);

// @todo Add the same for line numbers too
QUnit.test(
	"Code lines vertical alignment",
	function(assert) {
		var description = 'Check L and R lines are at the same vertical position';
		$('.file').each(function() {
			var
				file = $(this);
				ok = true;
			file.find('.left.side .diff-content .line').each(function(index) {
				var
					leftLine = $(this),
					// Retrieve the corresponding line on the right-hand side
					rightLine = file.find('.left.side .diff-content .line').eq(index),
					leftTop = leftLine.position().top,
					rightTop = $(rightLine).position().top;
				// Only assert failure once
				if (leftTop !== rightTop) {
					ok = false;
					assert.equal(leftTop, rightTop, description);				
				}
			});
			// Only assert success once
			if (ok) {
				assert.ok(true, description);
			}
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