(function () {
    document.addEventListener("DOMContentLoaded", function () {
        var nodes = document.querySelectorAll("[data-reveal]");
        if (!nodes.length || typeof IntersectionObserver === "undefined") {
            nodes.forEach(function (el) {
                el.classList.add("is-revealed");
            });
            return;
        }

        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add("is-revealed");
                    io.unobserve(entry.target);
                });
            },
            { root: null, threshold: 0.12, rootMargin: "0px 0px -28px 0px" }
        );

        nodes.forEach(function (el) {
            io.observe(el);
        });
    });
})();
