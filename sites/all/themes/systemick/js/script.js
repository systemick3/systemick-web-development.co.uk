/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {


// To understand behaviors, see https://drupal.org/node/756722#behaviors
Drupal.behaviors.systemick = {
 	attach: function(context, settings) {

		var tabs = $('.homepage-tabs');
		var tab = $('.tab');
		var container = $('.view-skills .view-content');

		if (tabs.length && container.length) {
			//  First tab should be active on page load
			tabs.find('.tab:first-child').addClass('active');

			// Give each view row a class corresponding to the id of it's tab
			// Make the first row visible on page load
			var ids = [];

	  	tabs.find('.tab').each(function(index) {
				ids[index] = $(this).attr('id');
			});

			var height = 0;
			container.find('.views-row').each(function(index) {
				$(this).addClass(ids[index]);
				if (index == 0) {
					$(this).addClass('row-visible');
				}
				else {
					$(this).hide();
					$(this).siblings('.links').hide();
				}

				if ($(this).height() > height) {
					height = $(this).height();
				}
			});

			// Handle a tab click:
			// Switch the active class to the clicked tab
			// Show the appropraite views row
			tab.click(function(event) {
				var current = $(this);
				var selectedClass = current.attr('id');
				tabs.find('.tab').removeClass('active');
				current.addClass('active');

				container.find('.views-row').each(function(index) {
					if ($(this).hasClass(selectedClass)) {
						selected = $(this);
					}
					$(this).removeClass('row-visible');
					$(this).hide();
					$(this).height(height);
				});

				selected.fadeIn().addClass('row-visible');

				return false;
			});
		}
	}
};


})(jQuery, Drupal, this, this.document);
