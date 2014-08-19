QUnit.test(
	"Panel alignment",
	function(assert) {
		$('.file').each(function() {
			// Get panels
			var
				lPanel = $(this).find('.left.side'),
				rPanel = $(this).find('.right.side'),

				lPositionY = lPanel.position().top,
				rPositionY = rPanel.position().top;
			assert.equal(
				lPositionY, rPositionY,
				'Check the vertical alignment of the L and R panels'
			);

			var cPositionY = $(this).position().top;
			assert.equal(
				cPositionY, lPositionY,
				'Check the top of the panels in relation to the container'
			);

			// Check the height of the two panels
			var
				lHeight = lPanel.height(),
				rHeight = rPanel.height();
			assert.equal(lHeight, rHeight);

			// Check the left panel is on the left side
			var
				lPositionX = lPanel.position().left,
				cPositionX = $(this).position().left;
			assert.equal(lPositionX, cPositionX);

			// Check that the right panel is on the right side. The ceil() is necessary
			// at least in FF30/Ubuntu to get equality :)
			var
				rPositionX = rPanel.position().left + lPanel.width()
				cPositionXR = $(this).position().left + $(this).width();
			assert.equal(
				Math.ceil(rPositionX),
				Math.ceil(cPositionXR)
			);
		});
	}
);

QUnit.test(
	"Line height",
	function(assert) {
		$('.file').each(function() {
			// Check that all lines within a file are the same height
			var oldHeight = null;
			$(this).find('.line').each(function() {
				var lineHeight = $(this).height();
				if (oldHeight !== null) {
					assert.equal(oldHeight, lineHeight);
				}
				oldHeight = lineHeight;
			});
		});
	}
);