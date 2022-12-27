(function () {
    "use strict";

    // Show modal
    function showModal() {
        const el = document.querySelector("#search-result-modal");
        const modal = tailwind.Modal.getOrCreateInstance(el);
        modal.show();

        // Set focus
        el.addEventListener("shown.tw.modal", () => {
            $(el).find("input")[0].focus();
        });
    }

    // On click event
    $(".top-bar, .top-bar-boxed")
        .find(".search")
        .find("input")
        .on("click", function () {
            showModal();
        });

    // On press event (Ctrl+k)
    $("body").on("keydown", function (e) {
        if ((e.ctrlKey || e.metaKey) && e.which == 75) {
            showModal();
        }
    });
})();
