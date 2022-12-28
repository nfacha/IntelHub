import SimpleBar from "simplebar";

(function () {
    "use strict";

    // Scrollbar
    if ($(".side-nav .scrollable").length) {
        new SimpleBar($(".side-nav .scrollable")[0]);
    }

    // Side Menu
    $(".side-menu").on("click", function () {
        if ($(this).parent().find("ul").length) {
            if ($(this).parent().find("ul").first()[0].offsetParent !== null) {
                $(this)
                    .find(".side-menu__sub-icon")
                    .removeClass("transform rotate-180");
                $(this).removeClass("side-menu--open");
                $(this)
                    .parent()
                    .find("ul")
                    .first()
                    .slideUp(300, function () {
                        $(this).removeClass("side-menu__sub-open");
                    });
            } else {
                $(this)
                    .find(".side-menu__sub-icon")
                    .addClass("transform rotate-180");
                $(this).addClass("side-menu--open");
                $(this)
                    .parent()
                    .find("ul")
                    .first()
                    .slideDown(300, function () {
                        $(this).addClass("side-menu__sub-open");
                    });
            }
        }
    });

    // Simple Menu Toggler
    $(".side-nav__header__toggler").on("click", function () {
        if ($(".side-nav").hasClass("side-nav--simple")) {
            $(".side-nav").addClass("hover");
            $(".wrapper")[0].animate(
                {
                    marginLeft: "270px",
                },
                {
                    duration: 200,
                }
            ).onfinish = function () {
                $(".side-nav").removeClass("hover");
                $(".side-nav").removeClass("side-nav--simple");
                $(".wrapper").removeClass("wrapper--simple");
            };
        } else {
            $(".side-nav").addClass("side-nav--simple");
            $(".wrapper").css("margin-left", "270px");
            $(".wrapper")[0].animate(
                {
                    marginLeft: "112px",
                },
                {
                    duration: 200,
                }
            ).onfinish = function () {
                $(".wrapper").removeAttr("style");
                $(".wrapper").addClass("wrapper--simple");
            };
        }
    });

    // Mobile Menu Toggler
    $(".mobile-menu-toggler").on("click", function () {
        if ($(".side-nav").hasClass("side-nav--active")) {
            $(".side-nav").removeClass("side-nav--active");
        } else {
            $(".side-nav").addClass("side-nav--active");
        }
    });
})();
