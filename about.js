(function () {
    document.addEventListener("DOMContentLoaded", function () {
        var nodes = document.querySelectorAll(".about-reveal");
        if (!nodes.length) return;

        if (typeof IntersectionObserver === "undefined") {
            nodes.forEach(function (el) {
                el.classList.add("is-visible");
            });
            return;
        }

        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add("is-visible");
                    io.unobserve(entry.target);
                });
            },
            { root: null, threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
        );

        nodes.forEach(function (el) {
            io.observe(el);
        });
    });
})();
