/*
 * Swaps tab indents with blocks of hard spaces
 */

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
