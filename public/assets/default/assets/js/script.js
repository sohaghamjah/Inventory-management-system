"use strict";

var wieldy = {
    docBody: $('body'),
    customStyle: null,
    addClass: function (eleRef, eleID, className) {
        jQuery(eleRef).parents(eleID).addClass(className);
    },
    removeClass: function (eleRef, eleID, className) {
        jQuery(eleRef).parents(eleID).removeClass(className);
    },
    sidebar: {
        window: $(window),
        docBody: $('body'),
        drawerRef: jQuery('.dt-sidebar'),
        sidebarToggleHandle: $('[data-toggle=main-sidebar]'),
        foldedHandle: $('[data-handle=folded]'),
        overlay: null,
        enabledFixedSidebar: false,
        enabledFoldedSidebar: false,
        enabledDrawer: false,
        init: function () {
            var sidebar = this;

            if (this.drawerRef.hasClass('dt-drawer')) {
                this.enabledDrawer = true;
            }

            var bodyWidth = sidebar.docBody.innerWidth();
            if (bodyWidth < 992) {
                sidebar.initDrawer();
            } else {
                sidebar.destroy();
            }

            sidebar.window.resize(function () {
                bodyWidth = sidebar.docBody.innerWidth();
                if (bodyWidth < 992) {
                    sidebar.initDrawer();
                } else {
                    sidebar.destroy();
                }
            });

            this.sidebarToggleHandle.on('click', function () {
                sidebar.toggleFolded();
            });
        },
        initDrawer: function () {
            if (this.docBody.hasClass('dt-sidebar--fixed')) {
                this.enabledFixedSidebar = true;
            }

            if (this.docBody.hasClass('dt-sidebar--folded')) {
                this.enabledFoldedSidebar = true;
            }

            this.docBody.removeClass('dt-sidebar--fixed');
            this.docBody.removeClass('dt-sidebar--folded');

            this.drawerRef.addClass('dt-drawer position-left');
        },
        destroy: function () {
            if (!this.enabledDrawer) {
                this.drawerRef.removeClass('dt-drawer position-left');
            }

            if (this.enabledFixedSidebar) {
                this.docBody.addClass('dt-sidebar--fixed');
            }

            if (this.enabledFoldedSidebar) {
                this.docBody.addClass('dt-sidebar--folded');
            }
        },
        toggleFolded: function () {
            if (!this.drawerRef.hasClass('dt-drawer')) {
                if (this.docBody.hasClass('dt-sidebar--folded')) {
                    this.sidebarUnfolded();
                    activeLayoutHandle('default');
                } else {
                    this.sidebarFolded();
                    activeLayoutHandle('folded');
                }
            }
        },
        sidebarFolded: function () {
            this.docBody.addClass('dt-sidebar--folded');
            handleSidbarMenu();
            $(document).trigger('sidebar-folded');
        },
        sidebarUnfolded: function () {
            this.docBody.removeClass('dt-sidebar--folded');
            handleSidbarMenu();
            $(document).trigger('sidebar-unfolded');
        },
        toggle: function () {
            if (this.drawerRef.hasClass('open')) {
                this.close();
            } else {
                this.open()
            }
        },
        open: function () {
            this.drawerRef.addClass('open');
            this.insertOverlay();
            this.sidebarToggleHandle.addClass('active');
        },
        close: function () {
            this.drawerRef.removeClass('open');
            this.overlay.remove();
            this.sidebarToggleHandle.removeClass('active');
        },
        insertOverlay: function () {
            this.overlay = document.createElement('div');
            this.overlay.className = 'dt-backdrop';
            this.drawerRef.after(this.overlay);

            var drawer = this;
            var overlayContainer = $(this.overlay);
            overlayContainer.on('click', function (event) {
                event.stopPropagation();
                drawer.toggle();
            });
        }
    },
    hoverCard: {
        docBody: $('body'),
        hoverHndle: $('[data-hover=thumb-card]'),
        handleRef: null,
        thumbCard: null,
        init: function () {
            var $this = this;
            this.createHoverCard();

            this.hoverHndle.hover(function () {
                $this.handleRef = $(this);
                $this.showThumb();
            }, function () {
                $this.hideThumb();
            });
        },
        showThumb: function () {
            var bodyWidth = this.docBody.outerWidth(true);

            if (bodyWidth > 767) {
                var $this = this;
                var offset = this.handleRef.offset();
                var handleWidth = this.handleRef.outerWidth(true);
                var name = (this.handleRef.data('name')) ? this.handleRef.data('name') : '';

                var innerHtml = '<span class="user-bg-card__info"><span class="dt-avatar-name text-center">' + name + '</span></span>';

                $this.thumbCard.html(innerHtml);

                if (($this.handleRef.data('thumb'))) {
                    $this.thumbCard.css({
                        backgroundImage: 'url(' + $this.handleRef.data('thumb') + ')',
                        backgroundPosition: 'center center',
                        backgroundSize: 'cover'
                    });
                } else {
                    $this.thumbCard.css({background: 'transparent'});
                }

                $this.thumbCard.css({
                    left: (offset.left - ((handleWidth + 67.5) / 2)),
                    top: (offset.top - 100),
                    width: 135,
                    height: 90,
                    zIndex: 2
                });
                $this.thumbCard.fadeIn();
            }
        },
        hideThumb: function () {
            this.thumbCard.fadeOut();
        },
        createHoverCard: function () {
            var tc = document.createElement('div');
            tc.className = 'card user-bg-card position-absolute bg-primary';
            tc.style.display = 'none';
            this.docBody.append(tc);
            this.thumbCard = $(tc);
        }
    },
    customizer: {
        toggleHandle: $('[data-toggle=customizer]'),
        containerPanel: $('.dt-customizer'),
        overlay: null,
        init: function () {
            var $this = this;

            $this.toggleHandle.on('click', function () {
                $this.toggle();
            });
        },
        toggle: function () {
            if (this.containerPanel.hasClass('open')) {
                this.close();
            } else {
                this.open()
            }
        },
        open: function () {
            this.containerPanel.addClass('open');
            this.insertOverlay();
        },
        close: function () {
            this.containerPanel.removeClass('open');
            this.overlay.remove();
        },
        insertOverlay: function () {
            this.overlay = document.createElement('div');
            this.overlay.className = 'dt-backdrop';
            this.containerPanel.after(this.overlay);

            var $this = this;
            var overlayContainer = $(this.overlay);
            overlayContainer.on('click', function (event) {
                event.stopPropagation();
                $this.toggle();
            });
        }
    },
    quickDrawer: {
        toggleHandle: $('[data-toggle=quick-drawer]'),
        containerPanel: $('.dt-quick-drawer'),
        overlay: null,
        init: function () {
            var $this = this;

            $this.toggleHandle.on('click', function () {
                $this.toggle();
            });
        },
        toggle: function () {
            if (this.containerPanel.hasClass('open')) {
                this.close();
            } else {
                this.open()
            }
        },
        open: function () {
            this.containerPanel.addClass('open');
            this.insertOverlay();
        },
        close: function () {
            this.containerPanel.removeClass('open');
            this.overlay.remove();
        },
        insertOverlay: function () {
            this.overlay = document.createElement('div');
            this.overlay.className = 'dt-backdrop';
            this.containerPanel.after(this.overlay);

            var $this = this;
            var overlayContainer = $(this.overlay);
            overlayContainer.on('click', function (event) {
                event.stopPropagation();
                $this.toggle();
            });
        }
    },
    init: function () {
        this.sidebar.init();
        this.hoverCard.init();
        this.customizer.init();
        this.quickDrawer.init();
        this.initCustomStyle();
    },
    updateStyle: function (style) {
        this.customStyle.innerHTML = style;
    },
    initCustomStyle: function () {
        this.customStyle = document.createElement('style');
        this.docBody.prepend(this.customStyle);
    }
};

var hoverEventExcuted = false;
var clickEventExcuted = false;

(function ($) {
    var $body = $('body');
    var $loader = $('.dt-loader-container');
    var $root = $('.dt-root');

    if ($loader.length) {
        $loader.delay(300).fadeOut('noraml', function () {
            $root.css('opacity', '1');
            $(document).trigger('loader-hide');
        });
    } else {
        $(document).trigger('loader-hide');
    }

    if ($('#main-sidebar').length) {
        new PerfectScrollbar('#main-sidebar');
    }

    $('.ps-custom-scrollbar').each(function () {
        new PerfectScrollbar(this);
    });

    if ($.isFunction($.fn.masonry)) {
        var $grid = $('.dt-masonry');
        $grid.masonry({
            // options
            itemSelector: '.dt-masonry__item',
            percentPosition: true
        });

        $(document).on('layout-changed', function () {
            setTimeout(function () {
                $grid.masonry('reloadItems');
                $grid.masonry({
                    // options
                    itemSelector: '.dt-masonry__item',
                    percentPosition: true
                });
            }, 500);
        });
    }

    /* Sidebar */

    // init Drawer
    wieldy.init();

    var current_path = window.location.href.split('/').pop();
    if (current_path == '') {
        current_path = 'index.html';
    }

    var $current_menu = $('a[href="' + current_path + '"]');
    $current_menu.addClass('active').parents('.nav-item').find('> .nav-link').addClass('active');

    if ($current_menu.length > 0) {
        $('.dt-side-nav__item').removeClass('open');

        if ($current_menu.parents().hasClass('dt-side-nav__item')) {
            $current_menu.parents('.dt-side-nav__item').addClass('open selected');
        } else {
            $current_menu.parent().addClass('active').parents('.dt-side-nav__item').addClass('open selected');
        }
    }

    handleSidbarMenu();
    $(window).resize(function () {
        handleSidbarMenu();
    });

    $('.dt-brand__tool').on('click', function () {
        if (wieldy.sidebar.drawerRef.hasClass('dt-drawer')) {
            wieldy.sidebar.toggle();
        }

        $(this).toggleClass('active');
    });

    /* toggle-button */
    var $toggleBtn = $('.toggle-button');
    if ($toggleBtn.length > 0) {
        $toggleBtn.on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            $(this).toggleClass('active');
        });
    }

    /* /Sidebar */

    /* customizer settings */
    var $dtTheme = localStorage.getItem('dt-theme');
    var $dtLayout = localStorage.getItem('dt-layout');
    var $dtStyle = localStorage.getItem('dt-style');
    var $currentTheme = ($dtTheme) ? $dtTheme : 'semidark';
    var $currentThemeStyle = ($dtStyle) ? $dtStyle : 'style-1';
    var $currentLayout = ($dtLayout) ? $dtLayout : 'full-width';

    var $themeChooser = $('#theme-chooser').find('.theme-option');
    var $themeStyleChooser = $('#theme-style-chooser').find('.dt-color-option');
    var $layoutChooser = $('#layout-chooser').find('.choose-option__icon');

    var $themeStylesheet = document.createElement('link');
    $themeStylesheet.rel = 'stylesheet';
    $themeStylesheet.href = '';
    $('head').append($themeStylesheet);

    $('#theme-style-chooser').find('[data-style=' + $currentThemeStyle + ']').addClass('active');
    $('#layout-chooser').find('[data-layout=' + $currentLayout + ']').parent().addClass('active');

    changeTheme($currentTheme, $currentThemeStyle, $themeStylesheet, true);
    changeLayout($currentLayout, true);

    if ($('#theme-option-' + $currentTheme).length) {
        $('#theme-option-' + $currentTheme).parent().addClass('active');
    }

    $themeChooser.on('change', function () {
        $currentTheme = $(this).val();
        changeTheme($currentTheme, $currentThemeStyle, $themeStylesheet);
    });

    $themeStyleChooser.on('click', function () {
        $themeStyleChooser.removeClass('active');
        $(this).addClass('active');
        $currentThemeStyle = $(this).data('style');
        changeTheme($currentTheme, $currentThemeStyle, $themeStylesheet);
    });

    $layoutChooser.on('click', function () {
        $layoutChooser.parent().removeClass('active');
        $(this).parent().addClass('active');
        $currentLayout = $(this).data('layout');
        changeLayout($currentLayout);
    });

    var $toggleFixedHeader = $('#toggle-fixed-header');
    var $toggleFixedSidebar = $('#toggle-fixed-sidebar');
    var $layoutContainer = $('#sidebar-layout');
    var $sidebarLayoutHandle = $layoutContainer.find('.choose-option__icon');

    activeFixedStyle();

    $toggleFixedHeader.on('click', function () {
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
            $body.removeClass('dt-header--fixed');
        } else {
            $body.addClass('dt-header--fixed');
            $(this).parent().addClass('active');
        }
    });

    $toggleFixedSidebar.on('click', function () {
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
            $body.removeClass('dt-sidebar--fixed');
        } else {
            $(this).parent().addClass('active');
            $body.addClass('dt-sidebar--fixed');
            activeLayoutHandle('default');
            wieldy.sidebar.enabledDrawer = false;
            $('.dt-brand__tool').removeClass('active');
            wieldy.sidebar.destroy();
            wieldy.sidebar.sidebarUnfolded();
        }
    });

    if ($body.hasClass('dt-sidebar--folded')) {
        $('[data-value=folded]').parent().addClass('active');
    } else if (wieldy.sidebar.drawerRef.hasClass('dt-drawer')) {
        $('[data-value=drawer]').parent().addClass('active');
    } else {
        $('[data-value=default]').parent().addClass('active');
    }

    $sidebarLayoutHandle.on('click', function () {
        $sidebarLayoutHandle.parent().removeClass('active');
        var layout = $(this).data('value');
        $(this).parent().addClass('active');

        if (layout === 'folded') {
            wieldy.sidebar.enabledDrawer = false;
            wieldy.sidebar.destroy();
            wieldy.sidebar.sidebarFolded();
            $('.dt-brand__tool').addClass('active');
        } else if (layout === 'drawer') {
            wieldy.sidebar.sidebarUnfolded();
            wieldy.sidebar.enabledDrawer = true;
            wieldy.sidebar.initDrawer();
            $('.dt-brand__tool').removeClass('active');
        } else if (layout === 'default') {
            wieldy.sidebar.enabledDrawer = false;
            wieldy.sidebar.destroy();
            wieldy.sidebar.sidebarUnfolded();
            $('.dt-brand__tool').removeClass('active');
        }

        activeFixedStyle();
    });
    /* end customizer settings */

    // go to location
    $('[data-location]').on('click', function (event) {
        event.preventDefault();
        window.location = $(this).data('location');
    });

    /*Popover*/
    $('[data-toggle="popover"]').popover();

    /*Tooltip*/
    $('[data-toggle="tooltip"]').tooltip();

    /*Scroll Spy*/
    $('.scrollspy-horizontal').scrollspy({target: '#scrollspy-horizontal'});

    $('.scrollspy-vertical').scrollspy({target: '#scrollspy-vertical'});

    $('.scrollspy-list-group').scrollspy({target: '#scrollspy-list-group'});

    // dt-indecator
    init_indecator();

    // Displaying user info card on contact hover
    var $mailContacts = $('.contacts-list .dt-contact');
    var $userInfoCard = $('.user-info-card');

    $userInfoCard.hover(function () {
        $userInfoCard.addClass('active').show();
    }, function () {
        $userInfoCard.hide().removeClass('active');
    });

    $mailContacts.each(function () {
        var $contact = $(this);

        $contact.hover(function () {
            var contactWidth = $contact.outerWidth(true);
            var positionValue = $contact.offset();
            var bodyHeight = $body.outerHeight(true);
            var bodyWidth = $body.outerWidth(true);

            if (bodyWidth > 767) {
                var userPic = $('.dt-avatar', $contact).attr('src');
                var userName = $('.dt-contact__title', $contact).text();

                if (userPic) {
                    $('.profile-placeholder', $userInfoCard).hide();
                    $('.profile-pic', $userInfoCard).attr('src', userPic).show();
                } else {
                    $('.profile-pic', $userInfoCard).hide();
                    $('.profile-placeholder', $userInfoCard).text(userName.substring(0, 2)).show();
                }

                $('.dt-avatar-name', $userInfoCard).text(userName);

                var infoCardHeight = $userInfoCard.outerHeight(true);
                var offsetTop = positionValue.top;
                if (bodyHeight < (positionValue.top + infoCardHeight + 20)) {
                    offsetTop = (bodyHeight - infoCardHeight - 20)
                }

                $userInfoCard.css({
                    top: offsetTop,
                    left: (positionValue.left + contactWidth - 15)
                }).show();
            }
        }, function (event) {
            if (!$userInfoCard.hasClass('active')) {
                $userInfoCard.hide();
            }
        });
    });

    if($('#user-menu-dropdown').length) {
        var userDorpdown = $('#user-menu-dropdown').find('.dropdown-menu').clone(true).appendTo("body");

        $('#user-menu-dropdown').on('show.bs.dropdown', function () {
            var $this = $('#user-menu-dropdown');
            userDorpdown.removeClass('show');
            if ($body.hasClass('dt-sidebar--folded')) {
                var positionValue = $this.find('.dropdown-toggle').offset();
                var dropDownHeight = $this.find('.dropdown-toggle').outerHeight(true);
                $this.find('.dropdown-menu').hide();

                setTimeout(function () {
                    userDorpdown.addClass('show').css({
                        position: 'fixed',
                        top: positionValue.top + dropDownHeight,
                        left: positionValue.left,
                        width: 180
                    }).find('.dt-avatar-info').css('display', 'block');
                }, 30);
            }
        });

        $('#user-menu-dropdown').on('hide.bs.dropdown', function () {
            var $this = $('#user-menu-dropdown');
            $this.find('.dropdown-menu').show();
            userDorpdown.removeClass('show');
        });
    }

})(jQuery);

function handleSidbarMenu() {
    var $body = jQuery('body');

    if (jQuery('body').hasClass('dt-sidebar--folded')) {
        if (!hoverEventExcuted) {
            hoverEventExcuted = true;
            jQuery(".dt-sidebar--folded ul.dt-side-nav > li.dt-side-nav__item").each(function () {
                var $currentMenuItem = jQuery(this);
                var $submenu = jQuery('.dt-side-nav__sub-menu', $currentMenuItem);
                var ps;

                $currentMenuItem.find('> a.dt-side-nav__link', $submenu).hover(function () {
                    var $menuLink = jQuery(this);

                    if ($submenu.length && jQuery('body').hasClass('dt-sidebar--folded')) {
                        $submenu.hover(function () {
                            $submenu.addClass('active');
                        }, function () {
                            if (ps)
                                ps.destroy();
                            $submenu.removeClass('active dt-side-nav__balloon').attr('style', '');
                        });

                        $submenu.addClass('dt-side-nav__balloon');
                        var menuItemWidth = $currentMenuItem.outerWidth(true);
                        var positionValue = $menuLink.offset();
                        var bodyHeight = $body.outerHeight(true);
                        var $submenuHeight = $submenu.outerHeight(true);

                        var offsetTop = positionValue.top;
                        if (bodyHeight < (positionValue.top + $submenuHeight + 20)) {
                            offsetTop = (bodyHeight - $submenuHeight - 20)
                        }

                        $submenu.css({
                            top: offsetTop,
                            left: (positionValue.left + menuItemWidth + 5)
                        });

                        if (ps)
                            ps.destroy();
                        ps = new PerfectScrollbar('.dt-side-nav__balloon');
                    } else {
                        $currentMenuItem.addClass('dt-side-nav__tooltip');

                        var $menuLinkText = $menuLink.find('.dt-side-nav__text');
                        var menuItemWidth = $currentMenuItem.outerWidth(true);
                        var positionValue = $menuLink.offset();
                        var menuLinkHeight = $menuLink.outerHeight(true);
                        var $menuLinkTextHeight = $menuLinkText.outerHeight(true);
                        var offsetTop = positionValue.top + ((menuLinkHeight - $menuLinkTextHeight) / 2);

                        $menuLinkText.css({
                            top: offsetTop,
                            left: (positionValue.left + menuItemWidth + 10)
                        });
                    }
                }, function () {
                    if ($submenu.length) {
                        setTimeout(function () {
                            if (!$submenu.hasClass('active')) {
                                if (ps)
                                    ps.destroy();
                                $submenu.removeClass('dt-side-nav__balloon').attr('style', '');
                            }
                        }, 300);
                    } else {
                        jQuery(this).find('.dt-side-nav__text').attr('style', '');
                        $currentMenuItem.removeClass('dt-side-nav__tooltip');
                    }
                });
            });
        }
    } else {
        if (!clickEventExcuted) {
            clickEventExcuted = true;
            var slideDuration = 150;
            jQuery("ul.dt-side-nav > li.dt-side-nav__item").on("click", function () {
                var menuLi = this;
                jQuery("ul.dt-side-nav > li.dt-side-nav__item").not(menuLi).removeClass("open");
                jQuery("ul.dt-side-nav > li.dt-side-nav__item ul").not(jQuery("ul", menuLi)).slideUp(slideDuration);
                jQuery(" > ul", menuLi).slideToggle(slideDuration, function () {
                    jQuery(menuLi).toggleClass("open");
                });
            });

            jQuery("ul.dt-side-nav__sub-menu li").on('click', function (e) {
                var $current_sm_li = jQuery(this);
                var $current_sm_li_parent = $current_sm_li.parent();

                if ($current_sm_li_parent.parent().hasClass("active")) {
                    jQuery("li ul", $current_sm_li_parent).not(jQuery("ul", $current_sm_li)).slideUp(slideDuration, function () {
                        jQuery("li", $current_sm_li_parent).not($current_sm_li).removeClass("active");
                    });

                } else {
                    jQuery("ul.dt-side-nav__sub-menu li ul").not(jQuery(" ul", $current_sm_li)).slideUp(slideDuration, function () {
                        //$("ul.sub-menu li").not($current_sm_li).removeClass("active");console.log('has not parent');
                    });
                }

                jQuery(" > ul", $current_sm_li).slideToggle(slideDuration, function () {
                    jQuery($current_sm_li).toggleClass("active");
                });

                e.stopPropagation();
            });
        }
    }
}

function notifyUser(title) {
    if (title === '') {
        title = 'Settings saved successfully.';
    }

    const toast = swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });

    toast({type: 'success', title: title});
}

/**
 * Change Layout
 * @param {string} $layout
 * @param {boolean} $init
 * @return {undefined}
 */
function changeLayout($layout, $init) {
    var $body = jQuery('body');

    if ($layout === 'framed') {
        $body.removeClass('dt-layout--boxed dt-layout--full-width').addClass('dt-layout--framed');
    } else if ($layout === 'full-width') {
        $body.removeClass('dt-layout--framed dt-layout--boxed').addClass('dt-layout--full-width');
    } else if ($layout === 'boxed') {
        $body.removeClass('dt-layout--framed dt-layout--full-width').addClass('dt-layout--boxed');
    }

    localStorage.setItem('dt-layout', $layout);
    $(document).trigger('layout-changed');

    if (!$init)
        notifyUser('Layout Updated successfully.');
}

/**
 * Change theme
 * @param {string} $theme
 * @param {string} $style
 * @param {string} $themeStylesheet
 * @param {boolean} $init
 * @return {undefined}
 */
function changeTheme($theme, $style, $themeStylesheet, $init) {
    var $body = jQuery('body');
    var $logo = $body.find('.dt-brand__logo-img');

    $('#theme-style-chooser').show();
    if ($theme === 'lite') {
        $logo.attr('src', 'assets/images/logo.png');
        $body.removeClass('theme-dark theme-semidark');
        $themeStylesheet.href = 'assets/css/' + $theme + '-' + $style + '.min.css';
    } else if ($theme === 'dark') {
        $logo.attr('src', 'assets/images/logo-white.png');
        $body.removeClass('theme-semidark').addClass('theme-dark');
        $themeStylesheet.href = 'assets/css/' + $theme + '-style-1.min.css';
        $('#theme-style-chooser').hide();
    } else if ($theme === 'semidark') {
        $body.find('.dt-header .dt-brand__logo-img').attr('src', 'assets/images/logo-white.png');
        $body.find('.dt-login__content-inner .dt-brand__logo-img').attr('src', 'assets/images/logo.png');
        $body.removeClass('theme-dark').addClass('theme-semidark');
        $themeStylesheet.href = 'assets/css/' + $theme + '-' + $style + '.min.css';
    }

    localStorage.setItem('dt-theme', $theme);
    localStorage.setItem('dt-style', $style);
    $(document).trigger('theme-changed');

    if (!$init)
        notifyUser('Theme Updated successfully.');
}

/*
 * Active customizer layout option
 */
function activeLayoutHandle(layout) {
    var $layoutContainer = jQuery('#sidebar-layout');
    $layoutContainer.find('.choose-option').removeClass('active');

    if (layout === 'folded') {
        $layoutContainer.find('[data-value=folded]').parent().addClass('active');
    } else if (layout === 'drawer') {
        $layoutContainer.find('[data-value=drawer]').parent().addClass('active');
    } else if (layout === 'default') {
        $layoutContainer.find('[data-value=default]').parent().addClass('active');
    }
}

/*
 * Active fixed style
 */
function activeFixedStyle() {
    var $body = jQuery('body');
    var $toggleFixedHeader = jQuery('#toggle-fixed-header');
    var $toggleFixedSidebar = jQuery('#toggle-fixed-sidebar');

    if ($body.hasClass('dt-header--fixed')) {
        $toggleFixedHeader.parent().addClass('active');
    } else {
        $toggleFixedHeader.parent().removeClass('active');
    }

    if ($body.hasClass('dt-sidebar--fixed')) {
        $toggleFixedSidebar.parent().addClass('active');
    } else {
        $toggleFixedSidebar.parent().removeClass('active');
    }
}

function init_indecator() {
    var $progressbar = jQuery('.dt-indicator-item__info:not(.complete)');

    $progressbar.each(function (index) {

        var $currentBar = $(this);
        var percentage = Math.ceil($currentBar.data('fill'));
        var maxVal = ($currentBar.data('max')) ? parseInt($currentBar.data('max')) : 100;
        var fillTypePercent = ($currentBar.data('percent')) ? true : false;
        var textSufix = ($currentBar.data('suffix')) ? $currentBar.data('suffix') : '';

        if (percentage && percentage <= maxVal) {
            $({countNum: 0}).animate({countNum: percentage}, {
                duration: 1000,
                easing: 'linear',
                step: function (now, tween) {
                    // What todo on every count
                    var pct = Math.floor(now);
                    var widthPct = Math.floor((pct * 100) / maxVal) + '%';

                    if (fillTypePercent) {
                        pct += '%';
                    }

                    $currentBar.find(".dt-indicator-item__fill").css('width', widthPct);
                    $currentBar.find(".dt-indicator-item__count").text(pct + ' ' + textSufix);
                },
                progress: function (animation, progress, remainingMs) {
                }
            });
        }
    });
}
