window.$ = window.jQuery = require('jquery');
var bootstrap = require('bootstrap'),
    owlCarousel = require('./../vendor/owl.carousel/owl-carousel/owl.carousel.js'),
    flot = require('flot'),
    SimpleMDE = require('simplemde');

require('flot/jquery.flot.time.js');
require('flot/excanvas.js');
require('./../vendor/flot/flot.orderBars.js');
require('./../vendor/flot/flot.tooltip.js');

$(document).ready(function() {

    var $root = $('html, body');
    var ancloc = window.location.hash;

    if( !ancloc ) {
        return;
    }

    $root.animate({
        scrollTop: ( $(ancloc).offset().top - 100 )
    }, 500, function () {
        window.location.hash = href;
    });
    return false;
});

$(window).load(function () {
    $(window).on('resize', tabsToSelect);

    $(window).trigger('resize');
});

$(document).ready(function () {

    $(document).scroll(debounce(function (event) {
        var navbar = $('.navbar-fixed-top');

        var docTop = $(document).scrollTop();
        //var bannerHeight = $('.container-fluid.banner').height();
        var navHeight = navbar.height();

        if(docTop > (/*bannerHeight -*/ navHeight )) {
            navbar.addClass('passed-banner');
        } else {
            navbar.removeClass('passed-banner');
        }
    }, 5));

    // $('.navbar a.dashboard').on('mouseenter',function(){
    //     if( !$(this).parent().hasClass('open') ) {
    //         $(this).trigger('click');
    //     }
    // });

    // $('.navbar a.dashboard').click(function(){
    //     location.href = this.href;
    // });

    $(document).trigger('scroll');

    $('nav .navbar-toggle').click(function(){
        if ($('body').width() >= 768) {
            $('body').removeClass('fixed');
            return;
        }

        if( $('body.fixed').length ) {
            $('body').removeClass('fixed');
        } else {
            setTimeout(function(){
                $('body').addClass('fixed');
            }, 200);
        }
    });

    if ($('.flash.alert').length) {
        var alert = $('.flash.alert');

        alert.animate({top: '60px'}, 500);

        if (alert.hasClass('alert-dismissible')) {
            setTimeout(function () {
                alert.animate({top: '-100px'}, 200);
            }, 8000);
        }
    }

    if ($('#homeslider').length) {
        $("#homeslider").owlCarousel({
            singleItem: true,
            autoPlay: 8000,
            stopOnHover: true,
            mouseDrag: false,
            touchDrag: false,
            transitionStyle: "fade",
            dots: false
        });
    }

    if ($('#serverSlider').length) {
        $("#serverSlider").owlCarousel({
            items: 3,
            autoPlay: 4000,
            stopOnHover: true,
            mouseDrag: false,
            touchDrag: false,
            itemsDesktop: false, //5 items between 1000px and 901px
            itemsDesktopSmall: [991, 2], // betweem 900px and 601px
            itemsTablet: [600, 1], //2 items between 600 and 0
            dots: false
        });
    }

    if ($('#featureslider').length) {
        $("#featureslider").owlCarousel({
            singleItem: true,
            autoPlay: 8000,
            stopOnHover: true,
            mouseDrag: false,
            touchDrag: false,
            transitionStyle: "fade",
            dots: false
        });
    }

    if ($('#streamcarousel').length) {
        if ($('#streamcarousel > div').length > 1) {
            $("#streamcarousel").owlCarousel({
                items: 2,
                mouseDrag: false,
                touchDrag: false,
                itemsDesktop: false, //5 items between 1000px and 901px
                itemsDesktopSmall: [991, 1], // betweem 900px and 601px
                itemsTablet: [600, 1], //2 items between 600 and 0
                itemsMobile: false
            });
        } else {
            if ($('#streamcarousel > div.item').length == 1) {
                $('#streamcarousel .item').addClass('one-stream');
            }
        }

    }

    if( $('.inspector input[name=search_type]').length ){
        $('.inspector input[name=search_type]').change(function(){
            $('.searchFilters.show').removeClass('show');
            $('#' + $(this).val() + 'Search').addClass('show');
        });
    }


    if ($('.slider').length) {
        $(".slider").owlCarousel({
            singleItem: true,
            lazyLoad: true,
            autoPlay: 5000,
            stopOnHover: true,
            mouseDrag: false,
            touchDrag: false
        });
    }

    if ($('#scrolldown').length) {
        $("#scrolldown").click(function (e) {
            e.preventDefault();

            var banner = $('.banner').height();

            $('html, body').animate({scrollTop: banner}, 500);
        });
    }

    if($(".simplemde").length) {
        if ($('body').width() <= 499) {
            return;
        }
        var simplemde = new SimpleMDE({
            toolbar: ["bold", "italic", "|", "unordered-list", "ordered-list", "|", "link", "image", "|", "quote"],
            spellChecker: false,
            status: false,
            element: $(".simplemde")[0]
        });
    }


    if($(".markdown-content").length) {
        $(".markdown-content a").each(function(){
            $(this).attr('target', '_blank');
        });
    }
    
    parsePlot();

    if ($('.activatePlot').length) {
        $('.activatePlot').click(function () {

            setTimeout(function () {
                parsePlot();
            }, 10);
        });
    }

    // if ($('#tribespeak').length) {
    //     var webrtc = new simpleWebRTC({
    //         autoRequestMedia: true,
    //         media: {audio: true, video: false},
    //         url: 'https://voice.championark.com/',
    //         /*peerConnectionConfig:{
    //          iceTransports: 'relay'
    //          }*/
    //     });
    //
    //     webrtc.on('readyToCall', function () {
    //         webrtc.joinRoom(tribeChannel);
    //     });
    // }
});

function debounce(fn, delay) {
    var timer = null;
    return function () {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            fn.apply(context, args);
        }, delay);
    };
}

function weekendAreas(axes) {

    var markings = [],
        d = new Date(axes.xaxis.min);

    // go to the first Saturday

    d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
    d.setUTCSeconds(0);
    d.setUTCMinutes(0);
    d.setUTCHours(0);

    var i = d.getTime();

    // when we don't set yaxis, the rectangle automatically
    // extends to infinity upwards and downwards

    do {
        markings.push({xaxis: {from: i, to: i + 2 * 24 * 60 * 60 * 1000}});
        i += 7 * 24 * 60 * 60 * 1000;
    } while (i < axes.xaxis.max);

    return markings;
}

function tabsToSelect() {
    if ($('body').width() >= 768) {
        return;
    }

    if ($('.banner-layout .banner.navigation .navigation .nav-tabs').length) {
        var navigation = $('.banner-layout .banner.navigation .navigation');
        var tabs = $('.nav-tabs > li', navigation);

        if ($('#select-nav select', navigation).length) {
            return false; //script already did its job
        }

        if( tabs.length == 1 ) {
            return false;
        }

        $('#select-nav', navigation).append('<select></select>');

        var select = $('#select-nav select', navigation);

        var active = false;
        tabs.each(function () {
            var href = $('a', this).attr('href');
            var content = String($('a', this).text()).trim();

            if (!$(this).hasClass('active')) {
                select.append('<option value="' + href + '">' + content + '</option>');
            } else {
                select.append('<option disabled selected value="' + href + '">' + content + '</option>');
                active = true;
            }
        });

        if( !active ) {
            select.prepend('<option selected> - Navigation - </option>');
        }

        select.change(function () {
            window.location = $('option:selected', this).val()
        });

    }
}

function parsePlot() {
    $('.stat_canvas').each(function () {

        if ($(this).height() == 0) {
            $(this).height('250px');
        }

        $.plot($(this),
            $(this).data('data'),
            $(this).data('options')
        );
    });
}