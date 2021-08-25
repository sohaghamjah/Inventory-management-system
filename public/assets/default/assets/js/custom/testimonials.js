(function ($) {
    "use strict";

    var $carousel = $(".dt-testimonial .owl-carousel").owlCarousel({
        loop: true,
        items: 1,
        dots: false,
        nav: true
    });

    var $carousel2 = $(".dt-testimonial-classic .owl-carousel").owlCarousel({
        loop: true,
        dots: false,
        nav: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            }
        }
    });

    var $carousel3 = $(".dt-testimonial-standard .owl-carousel").owlCarousel({
        loop: true,
        dots: false,
        nav: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 2,
            }
        }
    });

    $.each(['loader-hide', 'layout-changed', 'sidebar-folded', 'sidebar-unfolded'], function (index, value) {
        $(document).on(value, function () {
            setTimeout(function () {
                $carousel.trigger('refresh.owl.carousel');
                $carousel2.trigger('refresh.owl.carousel');
                $carousel3.trigger('refresh.owl.carousel');
            }, 300);
        });
    });

})(jQuery);