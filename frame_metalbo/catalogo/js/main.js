"use strict";

function pad(n) {
    return (n < 10) ? ("0" + n) : n;
}

$(document).ready(function () {

    // Single Product Tabs
    $('.prod-tabs li').on('click', 'a', function () {
        if ($(this).hasClass('active') || $(this).attr('data-prodtab') == '')
            return false;
        $(this).parents('.prod-tabs').find('li a').removeClass('active');
        $(this).addClass('active');

        // mobile
        $('.prod-tab-mob[data-prodtab-num=' + $(this).data('prodtab-num') + ']').parents('.prod-tab-cont').find('.prod-tab-mob').removeClass('active');
        $('.prod-tab-mob[data-prodtab-num=' + $(this).data('prodtab-num') + ']').addClass('active');

        $($(this).attr('data-prodtab')).parents('.prod-tab-cont').find('.prod-tab').css('height', '0px');
        $($(this).attr('data-prodtab')).css('height', 'auto');
        return false;
    });

    // Single Product Tabs (mobile)
    $('.prod-tab-cont').on('click', '.prod-tab-mob', function () {
        if ($(this).hasClass('active') || $(this).attr('data-prodtab') == '')
            return false;
        $(this).parents('.prod-tab-cont').find('.prod-tab-mob').removeClass('active');
        $(this).addClass('active');

        // main
        $('.prod-tabs li a[data-prodtab-num=' + $(this).data('prodtab-num') + ']').parents('.prod-tabs').find('li a').removeClass('active');
        $('.prod-tabs li a[data-prodtab-num=' + $(this).data('prodtab-num') + ']').addClass('active');

        $($(this).attr('data-prodtab')).parents('.prod-tab-cont').find('.prod-tab').css('height', '0px');
        $($(this).attr('data-prodtab')).css('height', 'auto').hide().fadeIn();
        return false;
    });


    // Popular Products Tabs
    $('.fr-pop-tabs li').on('click', 'a', function () {
        if ($(this).hasClass('active') || $(this).attr('data-frpoptab') == '')
            return false;
        $(this).parents('.fr-pop-tabs').find('li a').removeClass('active');
        $(this).addClass('active');

        // mobile
        $('.fr-pop-tab-mob[data-frpoptab-num=' + $(this).data('frpoptab-num') + ']').parents('.fr-pop-tab-cont').find('.fr-pop-tab-mob').removeClass('active');
        $('.fr-pop-tab-mob[data-frpoptab-num=' + $(this).data('frpoptab-num') + ']').addClass('active');

        $($(this).attr('data-frpoptab')).parents('.fr-pop-tab-cont').find('.fr-pop-tab').css('height', '0px');
        $($(this).attr('data-frpoptab')).css('height', 'auto').hide().fadeIn();
        return false;
    });

    // Popular Products Tabs (mobile)
    $('.fr-pop-tab-cont').on('click', '.fr-pop-tab-mob', function () {
        if ($(this).hasClass('active') || $(this).attr('data-frpoptab') == '')
            return false;
        $(this).parents('.fr-pop-tab-cont').find('.fr-pop-tab-mob').removeClass('active');
        $(this).addClass('active');

        // main
        $('.fr-pop-tabs li a[data-frpoptab-num=' + $(this).data('frpoptab-num') + ']').parents('.fr-pop-tabs').find('li a').removeClass('active');
        $('.fr-pop-tabs li a[data-frpoptab-num=' + $(this).data('frpoptab-num') + ']').addClass('active');

        $($(this).attr('data-frpoptab')).parents('.fr-pop-tab-cont').find('.fr-pop-tab').animate({
            'height': '0px'
        }, 350);
        $($(this).attr('data-frpoptab')).animate({
            'height': $($(this).attr('data-frpoptab')).find('.flex-viewport').outerHeight() + 'px'
        }, 350);

        return false;
    });

    // Accordions
    $('.accordion-tab-cont').on('click', '.accordion-tab-mob', function () {
        if ($(this).hasClass('active') || $(this).attr('data-accordion') == '')
            return false;
        $(this).parents('.accordion-tab-cont').find('.accordion-tab-mob').removeClass('active');
        $(this).addClass('active');

        $($(this).attr('data-accordion')).parents('.accordion-tab-cont').find('.accordion-tab').animate({
            'height': '0px'
        }, 350);
        $($(this).attr('data-accordion')).animate({
            'height': $($(this).attr('data-accordion')).find('.accordion-inner').outerHeight() + 'px'
        }, 350);

        return false;
    });

    // "All Features" button
    $('.prod-showprops').on('click', function () {
        if ($('.prod-tabs li a.active').attr('data-prodtab') == '#prod-tab-2') {
            $('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
        } else {
            $('.prod-tabs li a').removeClass('active');
            $('#prod-props').addClass('active');
            $('.prod-tab-cont .prod-tab').css('height', '0px');
            $('#prod-tab-2').css('height', 'auto');
            $('html, body').animate({scrollTop: ($('.prod-tabs-wrap').offset().top - 10)}, 700);
        }
        return false;
    });

    // Sidebar Categories
    $('#section-sb-toggle').on('click', function () {
        $('#section-sb-list').slideToggle();
        if ($(this).hasClass('opened'))
            $(this).removeClass("opened");
        else
            $(this).addClass('opened');
        return false;
    });
    $("#section-sb-list li.has_child").on("click", ".section-sb-toggle", function () {
        $(this).parent().next("ul").slideToggle();
        if ($(this).hasClass('opened'))
            $(this).removeClass("opened");
        else
            $(this).addClass('opened');
        return false;
    });

    // Filter Toggle (mobile)
    $('#section-filter-toggle').on('click', function () {
        $(this).next('.section-filter-cont').slideToggle();
        if ($(this).hasClass('opened')) {
            $(this).removeClass("opened").find('span').text($(this).data("open"));
        } else {
            $(this).addClass('opened').find('span').text($(this).data("close"));
        }
        return false;
    });

    // Product Offers (select type)
    $('body').on('click', '.offer-props-select p', function () {
        if ($(this).parent().hasClass('opened'))
            $(this).parent().removeClass('opened');
        else
            $(this).parent().addClass('opened');
        return false;
    });
    $('body').on('click', '.offer-props-select li', function () {
        if ($(this).parent().parent().hasClass('opened'))
            $(this).parent().parent().removeClass('opened');
        else
            $(this).parent().parent().addClass('opened');
    });
    $('body').on('click', '.offer-props-select li', function () {
        $(this).parent().parent().find('p').html($(this).text());
    });

    // Topmenu
    $('.topmenu').on('click', '.mainmenu-btn', function () {
        if ($('body').hasClass('mainmenu-show')) {
            $('body').removeClass('mainmenu-show');
        } else {
            $('body').addClass('mainmenu-show');
        }
        return false;
    });
    $('html').on('click', 'body.mainmenu-show', function () {
        $('body').removeClass('mainmenu-show');
    });
    $('body').on('click', '.mainmenu', function (event) {
        event.stopPropagation();
    });

    // Topmenu (mobile)
    if ($(window).width() < 751) {
        $('.topmenu .mainmenu li a .fa').on('click', function () {
            if ($(this).parent().next('.sub-menu').hasClass('opened')) {
                $(this).parent().next('.sub-menu').removeClass('opened');
                $(this).parent().next('.sub-menu').slideUp();
            } else {
                $(this).parent().next('.sub-menu').addClass('opened');
                $(this).parent().next('.sub-menu').slideDown();
            }
            return false;
        });

        $('.topcatalog').on('click', '.topcatalog-btn', function () {
            if ($('body').hasClass('topcatalog-show')) {
                $('body').removeClass('topcatalog-show');
            } else {
                $('body').addClass('topcatalog-show');
            }
            return false;
        });
        $('html').on('click', 'body.topcatalog-show', function () {
            $('body').removeClass('topcatalog-show');
        });
        $('body').on('click', '.topcatalog-list', function (event) {
            event.stopPropagation();
        });
        $('.topcatalog li .fa').on('click', function () {
            if ($(this).next('ul').hasClass('opened')) {
                $(this).next('ul').removeClass('opened');
                $(this).next('ul').slideUp();
            } else {
                $(this).next('ul').addClass('opened');
                $(this).next('ul').slideDown();
            }
            return false;
        });
    }

    // Search Button
    $('.topsearch').on('click', '#topsearch-btn', function () {
        if ($('body').hasClass('search-show')) {
            $('body').removeClass('search-show');
        } else {
            $('body').addClass('search-show');
        }
        return false;
    });

    // Search Close
    $('body.search-show').on('click', '#topsearch-btn', function () {
        if ($('body').hasClass('search-show')) {
            $('body').removeClass('search-show');
        }
        return false;
    });
    $('html').on('click', 'body.search-show', function () {
        $('body').removeClass('search-show');
    });
    $('body').on('click', '.topsearch', function (event) {
        event.stopPropagation();
    });

    // Mainmenu "more" button
    if ($('.mainmenu').length > 0) {
        if ($(window).width() > 751) {
            var menu_sections = $('.mainmenu');
            var menu_width = menu_sections.width();
            var menu_items_width = 0;
            menu_sections.find('> li').each(function () {
                if (!$(this).hasClass('mainmenu-more')) {
                    menu_items_width = menu_items_width + $(this).outerWidth(true);
                    if (menu_width < menu_items_width) {
                        $(this).addClass('mainmenu-other');
                        $(this).appendTo('.mainmenu-sub');
                    } else if ($(this).hasClass('mainmenu-other')) {
                        $(this).removeClass('mainmenu-other');
                        $(this).prependTo('.mainmenu-sub');
                    }
                }
            });
            if (menu_width < menu_items_width) {
                $('.mainmenu-more').show();
            }
        }

        $('.mainmenu').addClass('sections-show');

        $(window).resize(function () {
            var menu_sections = $('.mainmenu');
            var menu_width = menu_sections.width();
            var menu_items_width = 0;
            if ($(window).width() > 751) {
                menu_sections.find('> li').each(function () {
                    menu_items_width = menu_items_width + ($(this).outerWidth(true) + 4);
                    if (!$(this).hasClass('mainmenu-more')) {
                        if (menu_width < menu_items_width) {
                            $(this).addClass('mainmenu-other');
                            $(this).appendTo('.mainmenu-sub');
                        } else if ($(this).hasClass('mainmenu-other')) {
                            $(this).removeClass('mainmenu-other');
                            $(this).prependTo('.mainmenu-sub');
                        }
                    }
                });
                if (menu_width < menu_items_width) {
                    $('.mainmenu-more').show();
                }
            } else {
                menu_sections.find('li.mainmenu-other').insertBefore('.mainmenu-more');
                menu_sections.find('li.mainmenu-other').removeClass('mainmenu-other');
            }
        });

    }

    // Popular Products "more" button
    if ($('.fr-pop-tabs').length > 0) {
        if ($(window).width() > 751) {
            var menu_sections = $('.fr-pop-tabs');
            var menu_width = menu_sections.width();
            var menu_items_width = 0;
            menu_sections.find('> li').each(function () {
                if (!$(this).hasClass('fr-pop-tabs-more')) {
                    menu_items_width = menu_items_width + $(this).outerWidth(true);
                    if (menu_width < menu_items_width) {
                        $(this).addClass('fr-pop-tabs-other');
                        $(this).appendTo('.fr-pop-tabs-sub');
                    } else if ($(this).hasClass('fr-pop-tabs-other')) {
                        $(this).removeClass('fr-pop-tabs-other');
                        $(this).prependTo('.fr-pop-tabs-sub');
                    }
                }
            });
            if (menu_width < menu_items_width) {
                $('.fr-pop-tabs-more').show();
            }
        }

        $('.fr-pop-tabs').addClass('sections-show');

        $(window).resize(function () {
            var menu_sections = $('.fr-pop-tabs');
            var menu_width = menu_sections.width();
            var menu_items_width = 0;
            if ($(window).width() > 751) {
                menu_sections.find('> li').each(function () {
                    menu_items_width = menu_items_width + ($(this).outerWidth(true) + 4);
                    if (!$(this).hasClass('fr-pop-tabs-more')) {
                        if (menu_width < menu_items_width) {
                            $(this).addClass('fr-pop-tabs-other');
                            $(this).appendTo('.fr-pop-tabs-sub');
                        } else if ($(this).hasClass('fr-pop-tabs-other')) {
                            $(this).removeClass('fr-pop-tabs-other');
                            $(this).prependTo('.fr-pop-tabs-sub');
                        }
                    }
                });
                if (menu_width < menu_items_width) {
                    $('.fr-pop-tabs-more').show();
                }
            } else {
                menu_sections.find('li.fr-pop-tabs-other').insertBefore('.fr-pop-tabs-more');
                menu_sections.find('li.fr-pop-tabs-other').removeClass('fr-pop-tabs-other');
            }
        });

    }

    // Reviews "Show Answer" button
    if ($('.reviews-i-showanswer').length > 0) {
        $('.reviews-i-showanswer').on('click', function () {
            if ($(this).hasClass('opened')) {
                $(this).removeClass('opened').find('span').text($(this).find('span').data('open'));
                $(this).parents('.reviews-i').find('.reviews-i-answer').slideUp();
            } else {
                $(this).addClass('opened').find('span').text($(this).find('span').data('close'));
                $(this).parents('.reviews-i').find('.reviews-i-answer').slideDown();
            }
            return false;
        });
    }

    // Catalog Gallery - Show Properties on hover
    if ($('.prod-items-galimg .prod-i-properties-label').length > 0) {
        $('.prod-items-galimg .prod-i-properties-label').on({
            mouseenter: function () {
                $(this).parents('.prod-i').find('.prod-i-properties').addClass('show');
                return false;
            },
            mouseleave: function () {
                $(this).parents('.prod-i').find('.prod-i-properties').removeClass('show');
                return false;
            }
        });
    }

    // Catalog Table - Show more info button
    if ($('.prodtb-i-toggle').length > 0) {
        $('.prodtb-i-toggle').on('click', function () {
            if ($(this).hasClass('opened')) {
                $(this).removeClass('opened').parents('.prodtb-i').find('.prodlist-i').hide();
            } else {
                $(this).addClass('opened').parents('.prodtb-i').find('.prodlist-i').show();
            }
            return false;
        });
    }

    // Forms Validation
    var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,6})+$/;
    $('.form-validate').submit(function () {
        var errors = 0;
        $(this).find('[data-required="text"]').each(function () {
            if ($(this).attr('data-required-email') == 'email') {
                if (!filterEmail.test($(this).val())) {
                    $(this).addClass("redborder");
                    errors++;
                } else {
                    $(this).removeClass("redborder");
                }
                return;
            }
            if ($(this).val() == '') {
                $(this).addClass('redborder');
                errors++;
            } else {
                $(this).removeClass('redborder');
            }
        });
        if (errors === 0) {
            var form1 = $(this);
            $.ajax({
                type: "POST",
                url: 'php/email.php',
                data: $(this).serialize(),
                success: function (data) {
                    form1.append('<p class="form-result">Thank you!</p>');
                    $("form").trigger('reset');
                }
            });
        }
        return false;
    });
    $('.form-validate').find('[data-required="text"]').blur(function () {
        if ($(this).attr('data-required-email') == 'email' && ($(this).hasClass("redborder"))) {
            if (filterEmail.test($(this).val()))
                $(this).removeClass("redborder");
            return;
        }
        if ($(this).val() != "" && ($(this).hasClass("redborder")))
            $(this).removeClass("redborder");
    });


});




$(window).load(function () {

    // Quick View button
    $('.qview-btn').fancybox({
        content: $('.qview-modal'),
        padding: 0,
        helpers: {
            overlay: {
                locked: false
            }
        }
    });

    // Product Images Slider
    if ($('.prod-slider-car').length > 0) {
        $('.prod-slider-car').each(function () {
            $(this).bxSlider({
                pagerCustom: $(this).parents('.prod-slider-wrap').find('.prod-thumbs-car'),
                adaptiveHeight: true,
                infiniteLoop: false,
            });
            $(this).parents('.prod-slider-wrap').find('.prod-thumbs-car').bxSlider({
                slideWidth: 5000,
                slideMargin: 8,
                moveSlides: 1,
                infiniteLoop: false,
                minSlides: 5,
                maxSlides: 5,
                pager: false,
            });
        });
    }

    // Filter
    if ($('.section-filter-ttl').length > 0) {
        $('.section-filter').on('click', '.section-filter-ttl', function () {
            if ($(this).parents('.section-filter-item').hasClass('opened')) {
                $(this).parents('.section-filter-item').removeClass('opened');

            } else {
                $(this).parents('.section-filter-item').addClass('opened');
            }
            return false;
        });
    }

    // Product Countdown
    if ($('.countdown').length > 0) {
        $('.countdown').each(function () {
            if (!$(this).data('date')) {
                return;
            }
            var countdown = $(this);
            var BigDay = new Date(countdown.data('date'));
            var msPerDay = 24 * 60 * 60 * 1000;
            window.setInterval(function () {
                var today = new Date();
                var timeLeft = (BigDay.getTime() - today.getTime());
                var e_daysLeft = timeLeft / msPerDay;
                var daysLeft = Math.floor(e_daysLeft);
                var e_hrsLeft = (e_daysLeft - daysLeft) * 24;
                var hrsLeft = Math.floor(e_hrsLeft);
                var e_minsLeft = (e_hrsLeft - hrsLeft) * 60;
                var minsLeft = Math.floor(e_minsLeft);
                var e_secsLeft = (e_minsLeft - minsLeft) * 60;
                var secsLeft = Math.floor(e_secsLeft);
                var timeString = daysLeft + "d " + pad(hrsLeft) + ":" + pad(minsLeft) + ":" + pad(secsLeft);
                countdown.html(timeString);
                if (!countdown.hasClass('display')) {
                    countdown.addClass('display');
                }
            }, 1000);
        });
    }

});



/* PRODUCT V2 - start */
var fixed_obj = {};

function compareScrollStyles(st, newSt) {
    var obj1 = $.extend({}, st),
            obj2 = $.extend({}, newSt);
    $.each(obj1, function (i, k) {
        if (i !== 'position') {
            obj1[i] = Math.round(k);
        }
    });
    $.each(obj2, function (i, k) {
        if (i !== 'position') {
            obj2[i] = Math.round(k);
        }
    });
    return JSON.stringify(obj1) === JSON.stringify(obj2);
}

function setStyle(elem, name, value) {
    elem = $(elem);
    if (!elem)
        return;
    if (typeof name == 'object')
        return $.each(name, function (k, v) {
            setStyle(elem, k, v);
        });
    elem.removeAttr('style');
    elem.css(name, value + 'px');
}

function fixed_on_scroll() {

    var
            thumbs = $('.prod2-thumbs-car'),
            content = $('.prod-cont-inner'),
            slider = $('.prod2-slider-wrap');

    var
            wh = $(window).height() || 0,
            st = $(window).scrollTop(),
            headH = 15,
            isFixed = content.css('position') == 'fixed',
            contentH = content.outerHeight(),
            sliderH = slider.outerHeight(),
            sliderPos = slider.offset().top,
            tooBig = contentH >= sliderH,
            contentBottom = st + wh - sliderH - sliderPos,
            contentPB = Math.max(0, contentBottom),
            contentPT = sliderPos - headH,
            contentPos = content.offset().top,
            thumbsH = (typeof thumbs !== "undefined" ? thumbs.outerHeight() : 0),
            thumbsPos = (typeof thumbs.offset() !== "undefined" ? thumbs.offset().top : 0),
            lastSt = fixed_obj.lastSt || 0,
            lastStyles = fixed_obj.lastStyles || {},
            styles,
            needFix = false,
            smallEnough = headH + contentH + contentPB <= wh,
            delta = 1;

    if (st - delta < contentPT && !(smallEnough && contentPos < headH) || tooBig) {
        thumbs.removeAttr('style');
        thumbs.removeClass('stick');
    } else if ((wh + st >= Math.max(contentPos + contentH, sliderPos + sliderH)) && (thumbsPos > sliderPos)) {
        thumbs.css('margin-top', (thumbsPos - sliderPos) + 'px');
        thumbs.removeClass('stick');
    } else if (wh + st < Math.max(contentPos + contentH, sliderPos + sliderH) && thumbsH < contentH) {
        thumbs.removeAttr('style');
        thumbs.addClass('stick');
    }

    if (st - delta < contentPT && !(smallEnough && contentPos < headH) || tooBig) {
        styles = {
            marginTop: 0
        };
    } else if (st - delta < Math.min(lastSt, contentPos - headH) || smallEnough) {
        styles = {
            top: headH
        };
        needFix = true;
    } else if (st + delta > Math.max(lastSt, contentPos + contentH - wh) && contentBottom < 0) {
        styles = {
            bottom: 0
        };
        needFix = true;
    } else {
        styles = {
            marginTop: (contentBottom >= 0) ? sliderH - contentH : Math.min(contentPos - sliderPos, sliderH - contentH + contentPT)
        };
    }

    if (!compareScrollStyles(styles, lastStyles)) {
        $.each(lastStyles, function (i, k) {
            lastStyles[i] = null;
        });
        setStyle(content, $.extend(lastStyles, styles));
        fixed_obj.lastStyles = styles;
    }
    if (needFix !== isFixed) {
        if (needFix) {
            $(content).addClass('fixed');
        } else {
            $(content).removeClass('fixed');
        }
    }
    fixed_obj.lastSt = st;

    if (content.width() !== content.parent().width() && needFix) {
        content.width(content.parent().width());
    }
}


$(window).load(function () {

    if ($('.prod2-slider-wrap').length > 0) {
        if ($(window).width() >= 975) {
            fixed_on_scroll();
        }
        $(window).scroll(function () {
            if ($(window).width() >= 975) {
                fixed_on_scroll();
            }
        });
    }

    if ($('.prod2-thumbs-car li a').length > 0) {

        // Scroll to
        $('.prod2-thumbs-car li').on('click', 'a', function () {
            if ($(window).width() >= 975) {
                var
                        el_index = $(this).attr('data-slide-index'),
                        slide = $('.prod2-slider-car li img').eq(el_index),
                        slide_h = slide.outerHeight(),
                        w_h = $(window).height(),
                        slide_pos = slide.offset().top + slide_h / 2 - w_h / 2;
                $('html, body').animate({scrollTop: slide_pos}, 700);
                return false;
            }
        });

        // Waypoints
        $('.prod2-slider-car li img').each(function (i) {
            var this_img = $(this);
            var inview = new Waypoint.Inview({
                element: this_img,
                entered: function (direction) {
                    $('.prod2-thumbs-car li img').removeClass('scroll_active');
                    $('.prod2-thumbs-car li img').eq(i).addClass('scroll_active');
                }
            });
        });
    }

    // Product Images Slider
    if ($('.prod2-slider-car').length > 0) {
        $('.prod2-slider-car').each(function () {

            var this_slider = $(this);
            var this_thumbs = $(this).parents('.prod2-slider-wrap').find('.prod2-thumbs-car');

            var slider_load = false;
            var slider;
            var thumbs;
            if ($(window).width() < 975) {
                slider_load = true;

                this_slider.parents('.prod2-slider-wrap').addClass('slider-load');

                slider = this_slider.bxSlider({
                    pagerCustom: this_thumbs,
                    adaptiveHeight: true,
                    infiniteLoop: false,
                });
                thumbs = this_thumbs.bxSlider({
                    slideWidth: 5000,
                    slideMargin: 8,
                    moveSlides: 1,
                    infiniteLoop: false,
                    minSlides: 5,
                    maxSlides: 5,
                    pager: false,
                });
            } else {

            }
            $(window).resize(function () {
                if (!slider_load && $(window).width() < 975) {
                    slider_load = true;

                    this_slider.parents('.prod2-slider-wrap').addClass('slider-load');

                    slider = this_slider.bxSlider({
                        pagerCustom: this_thumbs,
                        adaptiveHeight: true,
                        infiniteLoop: false,
                    });
                    thumbs = this_thumbs.bxSlider({
                        slideWidth: 5000,
                        slideMargin: 8,
                        moveSlides: 1,
                        infiniteLoop: false,
                        minSlides: 5,
                        maxSlides: 5,
                        pager: false
                    });
                } else if (slider_load && $(window).width() >= 975) {
                    slider_load = false;
                    this_slider.parents('.prod2-slider-wrap').removeClass('slider-load');
                    slider.destroySlider();
                    thumbs.destroySlider();
                }
            });
        });

    }



});
/* PRODUCT V2 - end */




// Compare List
(function ($) {
    $.fn.setDraggable = function () {
        var compares = $(this),
                html = $('html');

        compares.each(function () {
            var compare = $(this),
                    tables = compare.find('.wccm-table'),
                    wrappers = compare.find('.wccm-table-wrapper'),
                    dragging = false,
                    maxshift = wrappers.width() - tables.width(),
                    offset = 0,
                    shift = 0;

            $(window).resize(function () {
                maxshift = wrappers.width() - tables.width();
                if (maxshift < 0) {
                    wrappers.css('cursor', 'move');
                } else {
                    wrappers.css('cursor', 'default');
                    tables.css('margin-left', '0');
                }
            });

            if (maxshift < 0) {
                wrappers.css('cursor', 'move');
                shift = parseInt(tables.css('margin-left'));
            }

            tables.mousedown(function (e) {
                var node = e.target.nodeName;

                if (maxshift < 0 && node != 'IMG' && node != 'A') {
                    dragging = true;
                    offset = e.screenX;
                    shift = parseInt(tables.css('margin-left'));
                    wrappers.css('cursor', 'default');
                }
            });

            html.mouseup(function () {
                dragging = false;
                if (maxshift < 0) {
                    wrappers.css('cursor', 'move');
                }
            });

            html.mousemove(function (e) {
                var move = shift - (offset - e.screenX);
                if (dragging && maxshift <= move && move <= 0) {
                    tables.css('margin-left', move + 'px');
                }
            });
        });

        return compares;
    };

    $(document).ready(function () {
        $('.wccm-compare-table').setDraggable();
    });
})(jQuery);

//================================================================ Inicio funções filtro ===================================================================//
//Documentação - Comentários podem ser replicados para cada uma das funções abaixo
//Funções para captura e request de dados dos filtros por campo em sequencia:
// 1 - Linha de produtos *Valores fixos de: Porcas e Parafusos*
// 2 - Tipo de produto
// 3 - Acabamentos
// 4 - Bitolas/Diâmetros

//Captura mudança de valor no campo 1 
$("#gru").change(function () {
    //Verifica se campo 2 possui classe OPENED *Aberta*
    if ($('#tipo').hasClass('opened')) {
        //Se sim, mantem a classe OPENED e entra na condicional
        //Adiciona classe hidden para esconder a mensagem de notificação de filtro vazio
        $("#filter-msg").addClass('hidden');
        //Captura valor do campo 1
        var gru = $('#gru').val();
        //Limpa campos 2,3 e 4 para reaplicar filtros caso deseja mudar a linha de produtos filtrada
        //trigger('chosen:updated') faz o trabalho de atualizar a lista de itens *<options>* no campo select 
        $('#fam').empty().trigger('chosen:updated');
        $('#subf').empty().trigger('chosen:updated');
        //Append - Adiciona HTML com mensagem indicando o carregamento dos dados da lista *<options>* no campo select
        $('#subg').empty().append('<option>Carregando...</option>').trigger('chosen:updated');
        //Request JSON com o valor do campo 1 do filtro *dados*
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroSubG" + "&dados=" + gru, function (result) {
            //Valor padrão do primeiro item do select usado como "legenda" do campo
            var html = '<option value="0" disabled selected>Tipo de produto</option>';
            //Para cada item retornado no Json, cria um option para dar append no campo 2
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            //Limpa options no campo 2
            $('#subg').empty();
            //Append options no campo 2 e chama funcção da biblioteca "chosen.jquery.min.js" para atualizar os itens da lista
            $('#subg').append(html).trigger('chosen:updated');
        });
    } else {
        //Campo 2 já foi ativado por uso do filtro do campo 1 anteriormente, não adiciona classe OPENED ao campo 2
        //Executa mesmas funções anteriores, porem sem resetar o campo 1 ou fechar o campo 2
        var gru = $('#gru').val();
        $("#filter-msg").addClass('hidden');
        $('#fam').empty().trigger('chosen:updated');
        $('#subf').empty().trigger('chosen:updated');
        $('#subg').empty();
        $('#subg').append('<option>Carregando...</option>').trigger('chosen:updated');
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroSubG" + "&dados=" + gru, function (result) {
            var html = '<option value="0" disabled selected>Tipo de produto</option>';
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            $('#subg').empty();
            $('#subg').append(html).trigger('chosen:updated');

        });


        $('#tipo').addClass('opened');

    }
});
//Documentação e comentários podem ser replicados a partir da função change do campo anterior.
//Mudar apenar a sequencia numerica dos campos. Ex: 1 para 2,2 para 3 e 3 para 4.
$("#subg").change(function () {
    if ($('#acab').hasClass('opened')) {
        var gru = $('#gru').val();
        var subg = $('#subg').val();
        $('#fam').empty();
        $('#fam').append('<option>Carregando...</option>').trigger('chosen:updated');
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroFam" + "&dados=" + gru + ',' + subg, function (result) {
            var html = '';
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            $('#fam').empty();
            $('#fam').append(html).trigger('chosen:updated');
        });
    } else {
        var gru = $('#gru').val();
        var subg = $('#subg').val();
        $('#fam').empty();
        $('#fam').append('<option>Carregando...</option>').trigger('chosen:updated');
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroFam" + "&dados=" + gru + ',' + subg, function (result) {
            var html = '';
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            $('#fam').empty();
            $('#fam').append(html).trigger('chosen:updated');

        });
        $('#acab').addClass('opened');

    }
});

//Documentação e comentários podem ser replicados a partir da função change do campo anterior.
//Mudar apenar a sequencia numerica dos campos. Ex: 1 para 2,2 para 3 e 3 para 4.
$("#fam").change(function () {
    if ($('#bit').hasClass('opened')) {
        var gru = $('#gru').val();
        var subg = $('#subg').val();
        var fam = $('#fam').val();
        $('#subf').empty();
        $('#subf').append('<option>Carregando...</option>').trigger('chosen:updated');
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroSubF" + "&dados=" + gru + ',' + subg + ',' + fam, function (result) {
            var html = '';
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            $('#subf').empty();
            $('#subf').append(html).trigger('chosen:updated');
        });
    } else {
        var gru = $('#gru').val();
        var subg = $('#subg').val();
        var fam = $('#fam').val();
        $('#subf').empty();
        $('#subf').append('<option>Carregando...</option>').trigger('chosen:updated');
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=filtroSubF" + "&dados=" + gru + ',' + subg + ',' + fam, function (result) {
            var html = '';
            result.forEach(function (dados) {
                html = html + '<option value ="' + dados['cod'] + '">' + dados['desc'] + '</option>';
            });
            $('#subf').empty();
            $('#subf').append(html).trigger('chosen:updated');

        });
        $('#bit').addClass('opened');

    }
});


//=========================================================================== Fim funções filtro ============================================================================//


//=========================================================================== Início da montagem da tela =========================================================================================================//
//Baseado no filtro, mota toda a tela que mostra os produtos
function filtro() {
    //valor/código do GRUPO
    var gru = $('#gru').val();
    //valor/código do SUBGRUPO
    var subg = $('#subg').val();
    //valor/código da FAMILIA
    var fam = $('#fam').val();
    //valor/código SUBFAMILIA
    var subf = $('#subf').val();
    if (gru == null) {
        //Mostra mensagem notificando usuário sobre a necessidade de um valor no campo de filtro
        $("#filter-msg").removeClass('shake animated hidden').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
            $("#filter-msg").removeClass('shake animated');
        });
    } else {
        //Concatena os valores de cada campo do filtro
        var dados = gru + '|' + subg + '|' + fam + '|' + subf;
        //Cria variável que vai receber o HTML
        var htmlTable = '';
        //Contador de load/paginas
        var itens = 0;
        //Limpa conteúdo da DIV que ira receber o HTML
        $('#prods').empty();
        //Adiciona animação CARREGANDO enquanto o HTML é gerado,concatenado e inserido na DIV
        $('#prods').append('<span class="back"><span>C</span><span>a</span><span>r</span><span>r</span><span>e</span><span>g</span><span>a</span><span>n</span><span>d</span><span>o</span></span>');
        //Request JSON com os valores dos campos do filtro *dados*
        $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=montaFiltro" + "&dados=" + dados, function (result) {
            //Gera HTML com cada um dos itens trazidos pelo request JSON da Classe na frame
            result.forEach(function (e) {
                //Concatena HTML gerado para o item anterior com o próximo item para formar a lista
                htmlTable = htmlTable + '<div class="prod-items section-items prod-tb">'
                        + '<div class="prodtb-i">'
                        + '<div class="prodtb-i-top">'
                        + '<button class="prodtb-i-toggle" type="button"></button>'
                        + '<h3 class="prodtb-i-ttl">' + e['prodes'] + '</h3>'
                        + '<div class="quant-prod">'
                        + '<span class="prodtb-i-price">'
                        + '<b>Qnt:</b>'
                        + '<input id="' + e['procod'] + '-qnt" class="quant-prod-form" type="text" data-required="text" placeholder="x100">'
                        + '</span>'
                        + '</div>'
                        + '<p id="' + e['procod'] + '-id" name="' + e['procod'] + '" class="prodtb-i-action">'
                        + '<a id="' + e['procod'] + '-addCart" class="prodtb-i-buy"><span>Adicionar ao carrinho</span><i id="' + e['procod'] + '-cart" class="fa fa-shopping-basket"></i></a>'
                        + '</p>'
                        + '</div>'
                        + '<div class="prodlist-i">'
                        + '<a class="list-img-carousel prodlist-i-img">'
                        + '<!-- NO SPACE -->'
                        + '<img src="img/media/' + e['media'] + '" alt="' + e['media'] + '" title="Imagem ilustrativa, acabamentos podem variar.">'
                        + '<!-- NO SPACE -->'
                        + '</a>'
                        + '<div class="prodlist-i-cont">'
                        + '<div class="prodlist-i-txt">'
                        + '<p>Imangem ilustrativa, acabamentos podem variar.</p>'
                        + '<p>Quantidades e preços:</p>'
                        + '<ul class="prodlist-i-props2">'
                        + '<li><span class="prodlist-i-propttl"><span>Código Metalbo</span></span> <span class="prodlist-i-propval">' + e['procod'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Preço R$/100pçs</span></span> <span id="' + e['procod'] + '-preco" class="prodlist-i-propval">' + e['preco'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Un. medida</span></span> <span class="prodlist-i-propval">' + e['pround'] + '</span></li>';
                //Tipo de embalagem e quantidades
                if (e['cxnormal'] != 'N/A') {
                    htmlTable = htmlTable + '<li><span class="prodlist-i-propttl"><span>Mínima</span></span> <span class="prodlist-i-propval">' + e['cxnormal'] + '</span></li>';
                }
                if (e['cxmaster'] != 'N/A') {
                    htmlTable = htmlTable + '<li><span class="prodlist-i-propttl"><span>Master</span></span> <span class="prodlist-i-propval">' + e['cxmaster'] + '</span></li>';
                }
                if (e['saco'] != 'N/A') {
                    htmlTable = htmlTable + '<li><span class="prodlist-i-propttl"><span>Saco</span></span> <span class="prodlist-i-propval">' + e['saco'] + '</span></li>';
                }
                htmlTable = htmlTable
                        + '<li><span class="prodlist-i-propttl"><span>Classe</span></span> <span class="prodlist-i-propval">' + e['classe'] + '</span></li>' + '</ul>'
                        + '</div>'
                        + '</div>'
                        + 'Dimensões listados em Milímetros - MM.'
                        + '<ul class="prodlist-i-props2">'
                        + '<li><span class="prodlist-i-propttl"><span>Material</span></span> <span class="prodlist-i-propval">' + e['promatcod'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Angulo hélice</span></span> <span class="prodlist-i-propval">' + e['proanghel'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Chave mín.</span></span> <span class="prodlist-i-propval">' + e['prodchamin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Chave máx.</span></span> <span class="prodlist-i-propval">' + e['prodchamax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Altura mín.</span></span> <span class="prodlist-i-propval">' + e['prodaltmin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Altura máx.</span></span> <span class="prodlist-i-propval">' + e['prodaltmax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. furo mín.</span></span> <span class="prodlist-i-propval">' + e['proddiamin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. furo máx.</span></span> <span class="prodlist-i-propval">' + e['proddiamax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. mín.</span></span> <span class="prodlist-i-propval">' + e['procommin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. máx.</span></span> <span class="prodlist-i-propval">' + e['procommax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. prim. min.</span></span> <span class="prodlist-i-propval">' + e['prodiapmin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. prim. máx.</span></span> <span class="prodlist-i-propval">' + e['prodiapmax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. ext. mín.</span></span> <span class="prodlist-i-propval">' + e['prodiaemin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. ext. máx.</span></span> <span class="prodlist-i-propval">' + e['prodiaemax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. haste mín.</span></span> <span class="prodlist-i-propval">' + e['procomrmin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. haste máx.</span></span> <span class="prodlist-i-propval">' + e['procomrmax'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. haste mín.</span></span> <span class="prodlist-i-propval">' + e['comphastma'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Diâm. haste máx.</span></span> <span class="prodlist-i-propval">' + e['comphastmi'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. rosca mín.</span></span> <span class="prodlist-i-propval">' + e['diamhastmi'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Com. rosca máx.</span></span> <span class="prodlist-i-propval">' + e['diamhastma'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Prof. caneco mín.</span></span> <span class="prodlist-i-propval">' + e['pfcmin'] + '</span></li>'
                        + '<li><span class="prodlist-i-propttl"><span>Prof. caneco máx.</span></span> <span class="prodlist-i-propval">' + e['pfcmax'] + '</span></li>'
                        + '</ul>'
                        + '</div>'
                        + '<script>$("#' + e['procod'] + '-id").on("click",function(){'
                        + 'if($("#' + e['procod'] + '-cart").hasClass("cart-active")){'
                        + 'var text = $("#shopping-cart").text();'
                        + 'text--;'
                        + '$("#shopping-cart").text(" " + text);'
                        + '$("#' + e['procod'] + '-cart").removeClass("cart-active");'
                        + 'var cod = $(this).attr("name");'
                        + 'removeCart(cod);'
                        + '$("#' + e['procod'] + '-addCart > span").replaceWith("<span>Adicionar ao carrinho</span>");'
                        + '$("#' + e['procod'] + '-addCart > span").removeClass("span-active");'
                        + '}else{'
                        + 'var text = $("#shopping-cart").text();'
                        + 'text++;'
                        + '$("#shopping-cart").text(" " + text);'
                        + '$("#' + e['procod'] + '-cart").addClass("cart-active");'
                        + 'var cod = $(this).attr("name");'
                        + 'var quant = $("#' + e['procod'] + '-qnt").val();'
                        + 'var string = $("#' + e['procod'] + '-preco").text();'
                        + 'var preco = moedaParaNumero(string);'
                        + 'addCart(cod, quant,preco);'
                        + '$("#' + e['procod'] + '-addCart > span").replaceWith("<span>Remover do carrinho</span>");'
                        + '$("#' + e['procod'] + '-addCart > span").addClass("span-active");'
                        + '}});'
                        + '$("#' + e['procod'] + '-qnt").on("input", function () {'
                        + 'var result = $("#cart-list > #' + e['procod'] + '-cartItem").text().split("|");'
                        + 'var string = $("#' + e['procod'] + '-preco").text();'
                        + 'var preco = moedaParaNumero(string);'
                        + '$("#' + e['procod'] + '-cartItem").text(result[0] + "|" + $("#' + e['procod'] + '-qnt").val() + "|" + preco);'
                        + '});'
                        + '</script>'
                        + '</div>'
                        + '</div>';
                itens++;
            });
            //Limpa DIV dos dados carregadosna página
            $('#prods').empty();
            //Append - Adiciona o HTML gerado a partir do JSON dentro da DIV carregando os dados na página
            $('#prods').append(htmlTable);
            //Mostra mensagem no "cabeçalho" que mostra quantidade de itens retornados no filtro
            if (itens > 0) {
                $('#filtro-count').html('Seu filtro retornou ' + itens + ' item(s), veja abaixo. Valores de quantidade dados em centos (x100).');
            } else {
                $('#filtro-count').html('Seu filtro não retornou nenhum item.');
            }

            chkDropDown();

            //Contador que mostra apenas os primeiros 20 items 
            $("#prods > div").slice(20).css('display', 'none');
            //Função contador que tras a quantidade de itens escondidos para o calculo do botão "carregar mais"
            var hidden = countLoad();
            //Calculo de resto mostrando quantos itens faltam mostrar dos itens carregados baseados no filtro
            var shown = itens - hidden;
            //Limpa a div do botão "carregar mais"
            $('#carregar-mais').empty();
            //Monta o botão "carregar mais" mostrando quantos itens foram carregados do total
            $('#carregar-mais').append('<p class="load-more"  id="loadMore"><a id="load-msg" href="#" >Mostrando ' + shown + ' de ' + itens + ' itens. Carregar mais...</a></p>');
            //Função do botão carregar mais
            $("#loadMore").on('click', function (e) {
                e.preventDefault();
                //Conta os próximos 20 itens da lista somando com os primeiros 20 fixos e altera o display, mostrando os itens 
                $("#prods > div:hidden").slice(0, 20).css('display', 'block');
                //Contador para verificar se todos os itens foram carregados
                var hidden = countLoad();
                switch (hidden) {
                    //Caso todos os itens carregados, desativa o clique do botão e mostra mensagem 
                    case 0:
                        $('#loadMore').removeClass().addClass('load-more-end');
                        $('#loadMore').off('click');
                        $('#load-msg').html('Todos os itens carregados.');
                        break;
                        //Caso faltem itens a serem mostrados, mostra mensagem com quantidade de itens que ainda faltam carregar
                    default:
                        var shown = itens - hidden;
                        $('#loadMore').removeClass().addClass('load-more');
                        $('#load-msg').html('Mostrando ' + shown + ' de ' + itens + ' itens. Carregar mais...');
                }
            });
            //Botão de busca do conteudo carregado na tela
            $('#search-btn').click(function () {
                var val = $('#search-val').val().toLowerCase();
                $("#prods > div").hide();
                $("#prods > div").each(function () {
                    var text = $(this).text().toLowerCase();
                    if (text.indexOf(val) != -1)
                    {
                        $(this).show();
                        $("#prods > div").slice(20).css('display', 'none');
                        var hidden = countLoad();
                        var shown = itens - hidden;
                        $('#load-msg').html('Mostrando ' + shown + ' de ' + itens + ' itens. Carregar mais...');
                    }
                });

            });
        });
    }

}

//========================================================================================= Fim da montagem da tela ============================================================================

//Retorna para o topo da página
//Não faz nenhuma alteração na DOM
$('#toTop').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 600);
    return false;
});
//Função para esconder o botão VOLTAR AO TOPO até que posição do scroll na página seja alcançada
$(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
        $('#toTop').fadeIn();
    } else {
        $('#toTop').fadeOut();
    }
});
//Função para esconder botão CARREGAR MAIS até que a posição do scroll na página seja alcançada
//Utilizada como base para trazer a quantidade fixa de 20 itens por clique devido a responsividade mobile, fazendo a lista ficar com comprimento maior
$(window).scroll(function () {
    if ($(this).scrollTop() > 500) {
        $('#loadMore').fadeIn("slow");
    } else {
        $('#loadMore').fadeOut("slow");
    }
});

//Loading para carregar página - GIF
$(window).load(function () {
    $(".se-pre-con").fadeOut("slow");
});

//Adiciona um balão ao passar o mouse sobre o botão de rodapé - VOLTAR AO TOPO
//Ver jquery-balloon.js plug-in
$('#toTop').balloon({position: "left",
    css: {
        backgroundColor: '#006b00',
        color: '#fff',
        fontSize: '14px'
    }
});

//Função para limpar a página e filtro
$('#reset').click(function () {
    $('#prods').empty();
    $('#prods').append('<h2 class="title-content">Seus itens vão carregar aqui!</h2>');
    $('#gru').empty().append('<option value="0" disabled selected>Produtos</option>'
            + '<option value="12">Porcas (PO) e afins</option>'
            + '<option value="13">Parafusos (PF) e afins</option>').trigger('chosen:updated');
    $('#tipo').removeClass('opened');
    $('#subg').empty().append('<option value="0" disabled selected>Tipo de produto</option>').trigger('chosen:updated');
    $('#acab').removeClass('opened');
    $('#fam').empty().trigger('chosen:updated');
    $('#bit').removeClass('opened');
    $('#subf').empty().trigger('chosen:updated');
    $('#filtro-count').empty();
    $('#cart-count').empty();



});

//Contador de itens ocultos 
function countLoad() {
    var hidden = 0;
    $("#prods > div").each(function () {
        if ($(this).css('display') === 'none') {
            hidden++;
        }
    });
    return hidden;
}
/*
 $('#shopping-list').on('click', function () {
 $('#prods').hide();
 $('#shopping-list > i').toggleClass('fa-shopping-cart fa-list');
 });*/
//Cria "lista de compras" oculta com os códigos dos itens que foram postos no carrinho, para criar consultas SQL
function addCart(cod, quant, preco) {
    $('#cart-list').append('<li id="' + cod + '-cartItem">' + cod + '|' + quant + '|' + preco + '</li>');
}
//Remove individualmente itens adicionados na "lista de compras"
function removeCart(cod) {
    $('#' + cod + '-cartItem').remove();
}
//Baseado nos itens do #cart-list monta toda a tela do carrinho de compras
function shoppingList() {
    //Captura valor/texto mostrado no icone do carrinho de compras 
    var text = $("#shopping-cart").text();
    //Faz verificações se existem itens no carrinho de compras
    if (text <= 0) {
        //Para e sai da função
        return;
    } else {
        //Se possui ao menos 1 item:
        //Verifica se a lista de itens está escondida
        if ($('#prods').css('display') === 'none' && text > 0) {
            //Se sim:
            //Cria função toggle no botão de carrinho de compras, permitindo mostrar os itens do filtro e esconder o carrinho de compras
            $('#table-prods > #send-form').hide();
            $('#waiting-msg').remove();
            $('#cart-table').empty().hide();
            $('#cart-count').empty().hide();
            $('#prods').show();
            $('#filtro-count').show();
            $('#load-msg').show();

            chkDropDown();
        }
        //Se a lista de itens não está escondida
        else {
            //Se sim:
            //Cria uma função toggle no botão de carrinho de compras, permitindo mostrar o carrinho de compras e esconder de itens do filtro
            //Cria GIF de loading enquanto o HTML do carrinho de compras é gerado
            $('#cart-table').append('<span class="back"><span>C</span><span>a</span><span>r</span><span>r</span><span>e</span><span>g</span><span>a</span><span>n</span><span>d</span><span>o</span></span>').show();
            //Esconde a lista de itens do filtro
            $('#prods').hide();
            //Esconde mensagem do cabeçalho que mostra quantidade de itens do filtro
            $('#filtro-count').hide();
            //Esconde botão carregar mais
            $('#load-msg').hide();
            //Mostra mensagem do cabeçalho que mostra quantidades de itens no carrinho de compras
            $('#cart-count').empty().html('Você tem ' + text + ' item(s) no seu carrinho.').show();
            //Cria array com os códigos dos itens na lista de compras
            var codigos = [];
            //For each para capturar itens da lista de compras
            $('#cart-list').find('li').each(function () {
                var result = $(this).text().split('|');
                var quant = $('#' + result[0] + '-qnt').val();
                var string = $('#' + result[0] + '-preco').text();
                var preco = moedaParaNumero(string);
                codigos.push(result[0] + '|' + quant + '|' + preco);
                //codigos.push($(this).text());
            });
            //Json da consulta SQL com os códigos dos itens da lista de compras
            $.getJSON("http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=montaCarrinho" + "&dados=" + codigos, function (result) {
                //Variavel que vai ser alimentada com o HTML do carrinho de compras
                var htmlCart = '';
                //Replica função for each usada para criar itens da lista de produtos
                result.forEach(function (e) {
                    //Concatena HTML gerado para o item anterior com o próximo item para formar a lista
                    htmlCart = htmlCart + '<div id="' + e['procod'] + '-prodIdTab" class="prod-items section-items prod-tb">'
                            + '<div class="prodtb-i">'
                            + '<div class="prodtb-i-top">'
                            + '<button class="prodtb-i-toggle" type="button"></button>'
                            + '<h3 class="prodtb-i-ttl">' + e['prodes'] + '</h3>'
                            + '<div class="quant-prod">'
                            + '<span class="prodtb-i-price">'
                            + '<b>Qnt:</b>'
                            + '<input id="' + e['procod'] + '-qnt" class="quant-prod-form" type="text" data-required="text" value="' + e['quant'] + '" placeholder="x100" disabled>'
                            + '</span>'
                            + '</div>'
                            + '<p id="' + e['procod'] + '-idCartItem" name="' + e['procod'] + '" class="prodtb-i-action">'
                            + '<a id="' + e['procod'] + '-removeCartItem" class="prodtb-i-buy"><span class ="span-active">Remover do carrinho</span><i id="' + e['procod'] + '-cartItemSpan" class="fa fa-times-circle cart-active"></i></a>'
                            + '</p>'
                            + '</div>'
                            + '<div class="prodlist-i">'
                            + '<a class="list-img-carousel prodlist-i-img">'
                            + '<!-- NO SPACE -->'
                            + '<img src="img/media/' + e['media'] + '" alt="' + e['media'] + '" title="Imagem ilustrativa, acabamentos podem variar.">'
                            + '<!-- NO SPACE -->'
                            + '</a>'
                            + '<div class="prodlist-i-cont">'
                            + '<div class="prodlist-i-txt">'
                            + '<p>Imangem ilustrativa, acabamentos podem variar.</p>'
                            + '<p>Quantidades e preços:</p>'
                            + '<ul class="prodlist-i-props2">'
                            + '<li><span class="prodlist-i-propttl"><span>Código Metalbo</span></span> <span class="prodlist-i-propval">' + e['procod'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Preço R$/100pçs</span></span> <span id="' + e['procod'] + '-preco" class="prodlist-i-propval">' + e['preco'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Un. medida</span></span> <span class="prodlist-i-propval">' + e['pround'] + '</span></li>';
                    //Tipo de embalagens e quantidades
                    if (e['cxnormal'] != 'N/A') {
                        htmlCart = htmlCart + '<li><span class="prodlist-i-propttl"><span>Mínima</span></span> <span class="prodlist-i-propval">' + e['cxnormal'] + '</span></li>';
                    }
                    if (e['cxmaster'] != 'N/A') {
                        htmlCart = htmlCart + '<li><span class="prodlist-i-propttl"><span>Master</span></span> <span class="prodlist-i-propval">' + e['cxmaster'] + '</span></li>';
                    }
                    if (e['saco'] != 'N/A') {
                        htmlCart = htmlCart + '<li><span class="prodlist-i-propttl"><span>Saco</span></span> <span class="prodlist-i-propval">' + e['saco'] + '</span></li>';
                    }
                    htmlCart = htmlCart
                            + '<li><span class="prodlist-i-propttl"><span>Classe</span></span> <span class="prodlist-i-propval">' + e['classe'] + '</span></li>' + '</ul>'
                            + '</div>'
                            + '</div>'
                            + 'Dimensões listados em Milímetros - MM.'
                            + '<ul class="prodlist-i-props2">'
                            + '<li><span class="prodlist-i-propttl"><span>Material</span></span> <span class="prodlist-i-propval">' + e['promatcod'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Angulo hélice</span></span> <span class="prodlist-i-propval">' + e['proanghel'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Chave mín.</span></span> <span class="prodlist-i-propval">' + e['prodchamin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Chave máx.</span></span> <span class="prodlist-i-propval">' + e['prodchamax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Altura mín.</span></span> <span class="prodlist-i-propval">' + e['prodaltmin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Altura máx.</span></span> <span class="prodlist-i-propval">' + e['prodaltmax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. furo mín.</span></span> <span class="prodlist-i-propval">' + e['proddiamin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. furo máx.</span></span> <span class="prodlist-i-propval">' + e['proddiamax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. mín.</span></span> <span class="prodlist-i-propval">' + e['procommin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. máx.</span></span> <span class="prodlist-i-propval">' + e['procommax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. prim. min.</span></span> <span class="prodlist-i-propval">' + e['prodiapmin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. prim. máx.</span></span> <span class="prodlist-i-propval">' + e['prodiapmax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. ext. mín.</span></span> <span class="prodlist-i-propval">' + e['prodiaemin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. ext. máx.</span></span> <span class="prodlist-i-propval">' + e['prodiaemax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. haste mín.</span></span> <span class="prodlist-i-propval">' + e['procomrmin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. haste máx.</span></span> <span class="prodlist-i-propval">' + e['procomrmax'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. haste mín.</span></span> <span class="prodlist-i-propval">' + e['comphastma'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Diâm. haste máx.</span></span> <span class="prodlist-i-propval">' + e['comphastmi'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. rosca mín.</span></span> <span class="prodlist-i-propval">' + e['diamhastmi'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Com. rosca máx.</span></span> <span class="prodlist-i-propval">' + e['diamhastma'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Prof. caneco mín.</span></span> <span class="prodlist-i-propval">' + e['pfcmin'] + '</span></li>'
                            + '<li><span class="prodlist-i-propttl"><span>Prof. caneco máx.</span></span> <span class="prodlist-i-propval">' + e['pfcmax'] + '</span></li>'
                            + '</ul>'
                            + '</div>'
                            + '<script>'
                            + '$("#' + e['procod'] + '-idCartItem").on("click",function(){'
                            + '$("#' + e['procod'] + '-prodIdTab").remove();'
                            + 'var text = $("#shopping-cart").text();'
                            + 'text--;'
                            + '$("#shopping-cart").text(" " + text);'
                            + '$("#' + e['procod'] + '-cartItem").remove();'
                            + '$("#' + e['procod'] + '-cart").removeClass("cart-active");'
                            + '$("#' + e['procod'] + '-addCart > span").replaceWith("<span>Adicionar ao carrinho</span>");'
                            + '$("#cart-count").empty().html("Você tem " + text + " item(s) no seu carrinho.");'
                            + 'back();'
                            + '});'
                            + '</script>'
                            + '</div>'
                            + '</div>';
                });
                //Limpa DIV do carrinho de compras, append HTML do carrinho de compras na DIV e mostra na tela
                $('#cart-table').empty().append(htmlCart).show();


                //Cria form de envio e geração do PDF
                $('#table-prods > #cart-table').before('<div id="send-form" style="text-align: center">'
                        + '<p class="contactform-field" style="display: inline-block;margin-bottom: 10px;">'
                        + '<label  class="contactform-label">E-mail</label>'
                        + '<!-- NO SPACE -->'
                        + '<span class="contactform-input" style="margin: 0 5px;width: 300px;">'
                        + '<input class="input-email-cart" placeholder="Seu e-mail" type="text" id="email" name="email" data-required="text" data-required-email="email"></span>'
                        + '</p>'
                        + '<div id="UF" class="select-location-div">'
                        + '<div >'
                        + '<div >'
                        + '<select id="UF-select" onchange="getES()" class="select-location">'
                        + '<option value="0" disabled selected>Selecione o Estado</option>'
                        + '<option value="12">Acre</option>'
                        + '<option value="27">Alagoas</option>'
                        + '<option value="16">Amapá</option>'
                        + '<option value="13">Amazonas</option>'
                        + '<option value="29">Bahia</option>'
                        + '<option value="23">Ceará</option>'
                        + '<option value="53">Distrito Federal</option>'
                        + '<option value="32">Espírito Santo</option>'
                        + '<option value="52">Goiás</option>'
                        + '<option value="21">Maranhão</option>'
                        + '<option value="51">Mato Grosso</option>'
                        + '<option value="50">Mato Grosso do Sul</option>'
                        + '<option value="31">Minas Gerais</option>'
                        + '<option value="41">Paraná</option>'
                        + '<option value="25">Paraíba</option>'
                        + '<option value="15">Pará</option>'
                        + '<option value="26">Pernambuco</option> '
                        + '<option value="22">Piauí</option>'
                        + '<option value="33">Rio de Janeiro</option>'
                        + '<option value="24">Rio Grande do Norte</option>'
                        + '<option value="43">Rio Grande do Sul</option>'
                        + '<option value="11">Rondônia</option>'
                        + '<option value="14">Roraima</option>'
                        + '<option value="42">Santa Catarina</option>'
                        + '<option value="28">Sergipe</option>'
                        + '<option value="35">São Paulo</option>'
                        + '<option value="17">Tocantins</option>'
                        + '</select>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<div id="ES" class="select-location-div">'
                        + '<div >'
                        + '<div >'
                        + '<select id="ES-select" class="select-location">'
                        + '<option value="0" disabled selected>Selecione a Cidade</option>'
                        + '</select>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<div id="send-form" style="text-align: center;margin: 0 0 10px 0;">'
                        + '<input id="send-list" onclick="sendPdfEmail()" class="btn class-test" value="Enviar para Metalbo" type="button">'
                        + '<input id="send-pdf" onclick="sendPdf()" class="btn class-test" value="Gerar lista" type="button">'
                        + '</div>'
                        + '<p id="waiting-msg" class="msg-email hidden"></p>');

                //Botão de busca do conteudo carregado na tela
                $('#search-btn').click(function () {
                    var val = $('#search-val').val().toLowerCase();
                    $("#cart-table > div").hide();
                    $("#cart-table > div").each(function () {
                        var text = $(this).text().toLowerCase();
                        if (text.indexOf(val) != -1)
                        {
                            $(this).show();
                        }
                    });

                });
                chkDropDown();
            });
        }
    }
}

//Função para esconder e limpar DIV do carrinho de compras e voltar para a tela principal 
function home() {
    if ($('#prods').is(":hidden")) {
        $('#table-prods > #send-form').remove();
        $('#waiting-msg').remove();
        $('#cart-table').empty();
        $('#cart-count').empty();
        $('#prods').show();
        $('#filtro-count').show();
        $('#load-msg').show();

        chkDropDown();
    } else {
        return;
    }
}
//Função para limpar todos os itens do carrinho
function limpaCart() {
    var text = $("#shopping-cart").text();
    if (text <= 0) {
        return;
    } else {
        if ($('#prods').is(":hidden")) {
            $('#cart-list').find('li').each(function () {
                var string = $(this).text().split('|');
                var cod = string[0];
                $('#' + cod + '-addCart > span').replaceWith("<span>Adicionar ao carrinho</span>");
                $('#' + cod + '-cart').removeClass('cart-active');
            });
            $('#table-prods > #send-form').remove();
            $('#waiting-msg').remove();
            $('#cart-table').empty();
            $('#cart-count').empty();
            $('#prods').show();
            $('#filtro-count').show();
            $('#load-msg').show();
            $("#shopping-cart").text(' 0');
            $('#cart-list').empty();

            chkDropDown();
        } else {
            $('#cart-list').find('li').each(function () {
                var string = $(this).text().split('|');
                var cod = string[0];
                $('#' + cod + '-addCart > span').replaceWith("<span>Adicionar ao carrinho</span>");
                $('#' + cod + '-cart').removeClass('cart-active');
            });
            $('#table-prods > #send-form').remove();
            $('#waiting-msg').remove();
            $('#cart-table').empty();
            $('#cart-count').empty();
            $("#shopping-cart").text(' 0');
            $('#cart-list').empty();
        }

    }
}
//Função que verifica individualmente, quantos itens existem no carrinho, a cada item que é removido do carrinho
function back() {
    var text = $("#shopping-cart").text();
    if (text > 0) {
        //Enquanto itens no carrinho, maior que 0, para a função e retorna
        return;
    } else {
        //Se o carrinho foi esvaziado, executa função home()
        home();
    }
}
//Função baseada na API do IBGE Brasil para busca dos municípios por estado para criar select no form de envio de e-mail
function getES() {
    //Captura valor númerico do código do estado
    var uf = $("#UF-select").val();
    //Json que recebe os dados com os nomes dos múnicípios do estado selecionado
    $.getJSON('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + uf + '/municipios', function (result) {
        //Variavel alimentada com o HTML criando os options do select de Cidades
        //Valor padrão do primeiro item do select usado como "legenda" do campo
        var htmlSelect = '<option value="0" disabled selected>Selecione a Cidade</option>';
        //For each utilizado para alimentar HTML do select com os options contendo nomes das cidades
        result.forEach(function (es) {
            htmlSelect = htmlSelect + '<option value="' + es['nome'] + '">' + es['nome'] + '</option>';
        });
        //Limpa e cria append do HTML do select de cidades
        $("#ES-select").empty().append(htmlSelect);
    });
}

//Função para gerar o PDF com os itens do carrinho de compras
function sendPdf() {
    //Verifica se tem itens no carrinho
    var text = $("#shopping-cart").text();
    if (text <= 0) {
        //Se vazio, para a funcção
        return;
    } else {
        //Se possui ao menos um item
        //Variavel de arrey dos códigos 
        var codigos = [];
        //For each que alimenta array com os códigos dos itens do carrinho de compras
        $('#cart-list').find('li').each(function () {
            codigos.push($(this).text());
        });
        //Abre janela do PDF em nova aba e envia dados para consulta SQL e geração do PDF no PHP da frame Metalbo
        window.open('http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=PDF' + '&dados=' + codigos, '_blank');
    }
}

//Função para gerar e enviar o PDF via e-mail para Metalbo com cópia do PDF para o usuário
function sendPdfEmail() {
    //Variaveis para pegar valores
    var text = $("#shopping-cart").text();
    //Validação do formato de e-mail
    var email = validateEmail($("#email").val());
    var uf = $('#UF-select').val();
    var es = $('#ES-select').val();
    //Verifica se tem itens no carrinho
    if (text <= 0) {
        //Se não, para a função e retorna 
        return;
    } else {
        //Vefirica valores
        if (email == false || uf == null || es == null) {
            $("#waiting-msg").text('Oops, e-mail inválido ou informações insuficientes!').addClass('email-error').removeClass('shake animated hidden').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $("#waiting-msg").removeClass('shake animated');
            });
        } else {
            //For each que alimenta array com os códigos dos itens do carrinho de compras
            var codigos = [];
            $("#cart-list").find('li').each(function () {
                codigos.push($(this).text());
            });
            //Array que envia os dados do Estado e Cidade do usuário que está enviando o e-mail
            var dadosUF = [];
            dadosUF[0] = $('#UF-select option:selected').html();
            dadosUF[1] = $('#ES-select option:selected').html();
            //Mostra mensagem notificando usuário que o e-mail está sendo enviado
            $("#waiting-msg").text('Olá, aguarde enquanto enviamos seu e-mail.').removeClass('shake animated hidden email-error email-success').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $("#waiting-msg").removeClass('shake animated');
            });
            //Json que recebe confirmação ou erro ao enviar e-mail via PHP na frame Metalbo
            $.getJSON('http://localhost/GitHub/frame_metalbo/index.php?classe=MET_TEC_Catalogo&metodo=PDF' + '&dados=' + codigos + '&email=' + $("#email").val() + '&dadosUF=' + dadosUF, function (result) {
                if (result == 'success') {
                    //Caso sucesso, mostra mensagem verde com mensagem de sucesso
                    $("#waiting-msg").text('E-mail foi enviado com sucesso, cheque sua caixa de entrada para uma cópia!').addClass('email-success').removeClass('shake animated hidden email-error').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $("#waiting-msg").removeClass('shake animated');
                    });
                } else {
                    //Caso erro, mostra mensagem vermelha com mensagem de erro
                    $("#waiting-msg").text('Erro ao tentar enviar o e-mail, tente novamente mais tarde!').addClass('email-error').removeClass('shake animated hidden email-success').addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $("#waiting-msg").removeClass('shake animated');
                    });
                }
            });
        }
    }
}

//Funcção para validar formato de e-mail
function validateEmail(email) {
    if (email == '' || email == null) {
        return false;
    } else {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test(email);
    }
}

function chkDropDown() {

    //Toggle - informações extra
    //Recarrega dropdown de dados extras abaixo da linha/grid de cada item
    //Verifica se o dropdown possui dados
    if ($('.prodtb-i-toggle').length > 0) {
        //Captura clique no dropdown
        $('.prodtb-i-toggle').on('click', function () {
            //Ao clicar, verifica se tem a classe OPENED *Aberta* 
            if ($(this).hasClass('opened')) {
                //Se possui a classe, ao clicar, fecha/esconde *hide* o dropdown 
                $(this).removeClass('opened').parents('.prodtb-i').find('.prodlist-i').hide();
            } else {
                //Se não possiu a classe, ao clicar, abre/mostra *show* o dropdown
                $(this).addClass('opened').parents('.prodtb-i').find('.prodlist-i').show();
            }
            return false;
        });
    }
}

/**
 * Função para converter numero para moeda
 * @param {type} n
 * @param {type} c
 * @param {type} d
 * @param {type} t
 * @returns {@var;d|@var;t|s|String}
 */
function numeroParaMoeda(n, c, d, t)
{
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

/**
 * Função para converte moeda para número
 * @param {type} valor
 * @returns {unresolved}
 */
function moedaParaNumero(valor)
{
    //return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
    return isNaN(valor) == false ? parseFloat(valor) : parseFloat(valor.replace("R$", "").replace(".", "").replace(",", "."));
}