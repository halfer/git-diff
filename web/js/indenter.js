/*
 * Swaps tab indents with blocks of hard spaces
 * 
 * Implemented as a jQuery plugin
 */

(function($) {
	$.fn.gitDiffIndentTabs = function(options) {
		// These options can be overridden if necessary
		var defaults = {
			codeCss: '.file .side .line code',
			indentString: '&nbsp;&nbsp;&nbsp;&nbsp;'
		};
		var options = $.extend(defaults, options);

		return this.each(function() {
			var lines = $(this).find(options.codeCss);
			lines.each(function(ord, lineElement) {
				// Grab the text in HTML mode
				var lineText = $(lineElement).html();
				var newText = lineText.replace(/^\t+/, '');
				if (newText.length < lineText.length)
				{
					var addSpaces = lineText.length - newText.length;
					for(var i = 0; i < addSpaces; i++)
					{
						newText = options.indentString + newText;
					}
					$(lineElement).html(newText);
				}
			});
		});
	};
})(jQuery);
