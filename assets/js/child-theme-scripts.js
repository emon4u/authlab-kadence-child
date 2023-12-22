(function ($) {
    'use strict';
    $(document).on('ready', function (e) {
        // Integration Filter
        $('.authlab-integration-wrap').each(function () {
            const iso = new Isotope('.integration-items', {
                itemSelector: '.integration-item',
                percentPosition: true,
            });

            const filtersElem = $(this).find('.filters-categories li');
            filtersElem.on('click', function (event) {
                const filterValue = event.target.getAttribute('data-filter');
                iso.arrange({
                    filter: filterValue
                });
            });

            const navItem = $(this).parent().find('.filters-categories li');
            navItem.on('click', function (e) {
                navItem.removeClass('active');
                $(this).addClass('active');
            });
        });

        // Navigation Menu
        $('.authlab-navigation-menu').each(function () {
            const selector = $(this),
                navToggler = selector.find('.navbar-toggler'),
                navPanel = selector.find('.navigation-wrapper'),
                navOverly = selector.find('.navigation-overly'),
                navClose = selector.find('.navbar-close'),
                showPanel = 'show-panel';

            const toggleMobileMenu = () => {
                navToggler.on('click', function (e) {
                    navPanel.addClass(showPanel);
                    navOverly.addClass(showPanel);
                    e.preventDefault();
                });
                navClose.on('click', function (e) {
                    e.preventDefault();
                    navPanel.removeClass(showPanel);
                    navOverly.removeClass(showPanel);
                });
                navOverly.on('click', function (e) {
                    e.preventDefault();
                    navPanel.removeClass(showPanel);
                    navOverly.removeClass(showPanel);
                });
            }

            toggleMobileMenu();
        });

        // Faq Accordion
        $('.authlab-faq-wrap').each(function () {
            const $selector = $(this),
                $filterCategory = $selector.find('.filter-category'),
                $accordionItem = $selector.find('.accordion-item'),
                $accordionContent = $selector.find('.accordion-content'),
                $accordionHeader = $selector.find('.accordion-header');

            function filterItems(category) {
                if (category === 'all') {
                    $accordionItem.slideDown(400);
                } else {
                    $accordionItem.hide();
                    $accordionItem.each(function () {
                        const categories = $(this).data('category').split(' ');
                        if (categories.includes(category)) {
                            $(this).show();
                        }
                    });
                }
            }

            filterItems($filterCategory.val());

            $filterCategory.change(function () {
                filterItems($(this).val());
            });

            $accordionHeader.click(function () {
                const isActive = $(this).hasClass('active');

                $accordionHeader.removeClass('active');
                $accordionContent.slideUp(400);

                if (!isActive) {
                    $(this).addClass('active');
                    $(this).siblings('.accordion-content').slideDown(400);
                }
            });

            $accordionHeader.first().trigger('click');
        });
    });
})(jQuery);