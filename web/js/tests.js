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

			// The floor/ceil is necessary at least in FF30/Ubuntu and Chromium/Ubuntu to
			// get equality
			var
				rPositionX = rPanel.position().left + rPanel.width(),
				cPositionXR = $(this).position().left + $(this).width();
			assert.equal(
				Math.floor(rPositionX),
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
 * 
 * @param assert
 * @param lineContainer
 * @param description
 * @param propertyReader A func taking a line jQuery object and returns the property value of interest
 */
function checkLinesProperty(assert, lineContainer, description, propertyReader) {
	// Check that all lines within a file have the same
	var
		oldProperty = null,
		ok = true;
	lineContainer.find('.line').each(function() {
		// A nice generic way to read a (possibly chained) method/property
		var lineProperty = propertyReader($(this));
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
				function(lineItem) {
					return Math.floor(lineItem.height());
				}
			);
		});
	}
);

QUnit.test(
	"Code and line number left alignment",
	function(assert) {
		function getLeftPosition(lineItem) {
			return lineItem.position().left;
		}

		$('.file .side .diff-content').each(function() {
			checkLinesProperty(
				assert,
				$(this),
				'Check that code lines within a file have the same left position',
				getLeftPosition
			);
		});

		$('.file .side .line-numbers').each(function() {
			checkLinesProperty(
				assert,
				$(this),
				'Check that line numbers within a file have the same left position',
				getLeftPosition
			);
		});
	}
);

QUnit.test(
	"Code lines vertical alignment",
	function(assert) {
		function checkEquality(assert, description, value1, value2) {
			var ok = true;

			// Only assert failure once
			if (value1 !== value2) {
				ok = false;
				assert.equal(value1, value2, description);				
			}

			return ok;
		}
		var description = 'Check L and R code and number lines are at the same vertical position';
		$('.file').each(function() {
			var
				file = $(this);
				ok = true;
			file.find('.left.side .diff-content .line').each(function(index) {
				var
					// Here are the left/right code/line elements
					leftLine = $(this),
					rightLine = file.find('.right.side .diff-content .line').eq(index),
					leftNumber = file.find('.left.side .line-numbers .line').eq(index),
					rightNumber = file.find('.right.side .line-numbers .line').eq(index),
					// Here's their top positions
					leftTop = leftLine.position().top,
					rightTop = $(rightLine).position().top,
					// We don't know if line numbers have been rendered at this point
					leftNumberTop,
					rightNumberTop
				;
				
				// Check the top position of code lines
				if (!checkEquality(assert, description, leftTop, rightTop)) ok = false;

				// Only check line numbers if they are present
				if (leftNumber.length && rightNumber.length) {
					leftNumberTop = leftNumber.position().top;
					rightNumberTop = rightNumber.position().top;
					if (!checkEquality(assert, description, leftTop, leftNumberTop)) ok = false;
					if (!checkEquality(assert, description, leftTop, rightNumberTop)) ok = false;
				}

				if (!ok) return false;
			});
			// Only assert success once
			if (ok) {
				assert.ok(true, description);
			}
		});
	}
);

// @todo Do a test to see if line number width + code width expands to full width

QUnit.test(
	'Check diffs without line numbers use full width',
	function(assert) {
		$('.file').each(function() {
			var
				description = 'Check diffs without line numbers use full width',
				lineNumberCount = $(this).find('.line-numbers').length,
				sideWidth,
				ok = true;

			// Only check diffs that have no line numbers
			if (lineNumberCount === 0) {
				$(this).find('.line.diff-line').each(function() {
					// The -2 accounts for the borders
					sideWidth = $(this).parents('.side').width() - 2;
					if ($(this).width() !== sideWidth) {
						assert.equal(
							sideWidth,
							$(this).width(),
							description
						);
						ok = false;
						return false;
					}
				});

				// Only assert success once
				if (ok) {
					assert.ok(true, description);
				} else {
					return false;
				}
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