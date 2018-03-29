jQuery(document).ready(function () {
    //cache DOM elements
    var mainContent = $('.cd-main-content'),
        header = $('.cd-main-header'),
        sidebar = $('.cd-side-nav'),
        sidebarTrigger = $('.cd-nav-trigger'),
        topNavigation = $('.cd-top-nav'),
        searchForm = $('.cd-search'),
        accountInfo = $('.account');

    //on resize, move search and top nav position according to window width
    var resizing = false;
    moveNavigation();
    $(window).on('resize', function () {
        if (!resizing) {
            (!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300): window.requestAnimationFrame(moveNavigation);
            resizing = true;
        }
    });

    //on window scrolling - fix sidebar nav
    var scrolling = false;
    checkScrollbarPosition();
    $(window).on('scroll', function () {
        if (!scrolling) {
            (!window.requestAnimationFrame) ? setTimeout(checkScrollbarPosition, 300): window.requestAnimationFrame(checkScrollbarPosition);
            scrolling = true;
        }
    });

    //mobile only - open sidebar when user clicks the hamburger menu
    sidebarTrigger.on('click', function (event) {
        event.preventDefault();
        $([sidebar, sidebarTrigger]).toggleClass('nav-is-visible');
    });

    //click on item and show submenu
    $('.has-children > a').on('click', function (event) {
        var mq = checkMQ(),
            selectedItem = $(this);
        if (mq == 'mobile' || mq == 'tablet') {
            event.preventDefault();
            if (selectedItem.parent('li').hasClass('selected')) {
                selectedItem.parent('li').removeClass('selected');
            } else {
                sidebar.find('.has-children.selected').removeClass('selected');
                accountInfo.removeClass('selected');
                selectedItem.parent('li').addClass('selected');
            }
        }
    });

    //click on account and show submenu - desktop version only
    accountInfo.children('a').on('click', function (event) {
        var mq = checkMQ(),
            selectedItem = $(this);
        if (mq == 'desktop') {
            event.preventDefault();
            accountInfo.toggleClass('selected');
            sidebar.find('.has-children.selected').removeClass('selected');
        }
    });

    $(document).on('click', function (event) {
        if (!$(event.target).is('.has-children a')) {
            sidebar.find('.has-children.selected').removeClass('selected');
            accountInfo.removeClass('selected');
        }
    });

    //on desktop - differentiate between a user trying to hover over a dropdown item vs trying to navigate into a submenu's contents
    sidebar.children('ul').menuAim({
        activate: function (row) {
            $(row).addClass('hover');
        },
        deactivate: function (row) {
            $(row).removeClass('hover');
        },
        exitMenu: function () {
            sidebar.find('.hover').removeClass('hover');
            return true;
        },
        submenuSelector: ".has-children",
    });

    function checkMQ() {
        //check if mobile or desktop device
        return window.getComputedStyle(document.querySelector('.cd-main-content'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
    }

    function moveNavigation() {
        var mq = checkMQ();

        if (mq == 'mobile' && topNavigation.parents('.cd-side-nav').length == 0) {
            detachElements();
            topNavigation.appendTo(sidebar);
            searchForm.removeClass('is-hidden').prependTo(sidebar);
        } else if ((mq == 'tablet' || mq == 'desktop') && topNavigation.parents('.cd-side-nav').length > 0) {
            detachElements();
            searchForm.insertAfter(header.find('.cd-logo'));
            topNavigation.appendTo(header.find('.cd-nav'));
        }
        checkSelected(mq);
        resizing = false;
    }

    function detachElements() {
        topNavigation.detach();
        searchForm.detach();
    }

    function checkSelected(mq) {
        //on desktop, remove selected class from items selected on mobile/tablet version
        if (mq == 'desktop') $('.has-children.selected').removeClass('selected');
    }

    function checkScrollbarPosition() {
        var mq = checkMQ();

        if (mq != 'mobile') {
            var sidebarHeight = sidebar.outerHeight(),
                windowHeight = $(window).height(),
                mainContentHeight = mainContent.outerHeight(),
                scrollTop = $(window).scrollTop();

            ((scrollTop + windowHeight > sidebarHeight) && (mainContentHeight - sidebarHeight != 0)) ? sidebar.addClass('is-fixed').css('bottom', 0): sidebar.removeClass('is-fixed').attr('style', '');
        }
        scrolling = true;
    }

    /* Selecting form components*/
    $(".form-wrapper li").on('click', function () {
        $('.form-line').removeClass("liselected");
        $(this).addClass("liselected");
    });

    /* Open right sidebar form customization*/
    $(".form-line").on('click', function () {
        $(".right-sidebar").addClass("shw-rside");
    });

    /*Sidebar Menu*/
    $(".right-side-toggle").on('click', function () {
        $(".right-sidebar").toggleClass("shw-rside");
    });

    // This is for resize window
    $(function () {
        $(window).bind("load resize", function () {
            var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 1170) {
                $('body').addClass('content-wrapper');
            } else {
                $('body').removeClass('content-wrapper');
            }
        });
    });

    /**
     * Scroll button
     */

    $(window).scroll(function () {
        var currentScrollTop = $(this).scrollTop();
        var buttonPosition = currentScrollTop + 5;

        $(".button-group-sidebar").css('top', buttonPosition);
    });

    $('.survey-action').on('click', function (e) {
        e.preventDefault();
    });

    $("#sortable1").sortable({
        axis: 'y',
        cursor: 'pointer',
        connectWith: ".page-section",
        cancel: '.no-sort',
        change: function (event, ui) {
            if (ui.placeholder.index() < 1) {
                $('.sortable-first').after(ui.placeholder);
            }
        },
        stop: function (event, ui) {
            $(ui.item).removeAttr('style');
        },
    }).disableSelection();

    $('.content-wrapper form').on('click', '.remove-element', function (event) {
        $(this).parent('li').remove();
    });
});
