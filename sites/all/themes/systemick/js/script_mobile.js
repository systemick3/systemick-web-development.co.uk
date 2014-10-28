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

			// Hide the body text of all tabs
			container.find('.field-name-body, .links').hide();
      
      var row = $('.view-skills .views-row');
      var leftChevron = '<i class="fa fa-chevron-circle-left"></i>';
      
      row.find('header').append(leftChevron);

			row.click(function(event) {
				$(this).find('.field-name-body').slideToggle();
        var icon = $(this).find('.fa');
        icon.toggleClass('fa-chevron-circle-left');
        icon.toggleClass('fa-chevron-circle-down');
				return false;
			});
	  }
	};


})(jQuery, Drupal, this, this.document);
