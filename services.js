/**
 * Service slides: visibility + move single #service-robot-container into the active slide
 */
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll("section.service-slide");
    const robotHost = document.getElementById("service-robot-container");

    if (!slides.length || !robotHost) return;

    function viewportRect() {
        return {
            top: 0,
            left: 0,
            right: window.innerWidth,
            bottom: window.innerHeight,
            width: window.innerWidth,
            height: window.innerHeight,
        };
    }

    function getModeForSlide(slideId) {
        if (slideId === "ai-solutions") return "idle";
        if (slideId === "web-solutions") return "walkjump";
        if (slideId === "mobile-applications") return "idle";
        if (slideId === "software") return "walk";
        return "idle";
    }

    function getHoverActionForSlide(slideId) {
        if (slideId === "ai-solutions") return "thumbsUp";
        if (slideId === "mobile-applications") return "thumbsUp";
        if (slideId === "web-solutions") return "yes";
        if (slideId === "software") return "yes";
        return "yes";
    }

    function mountRobotToActiveSlide() {
        if (!robotHost) return;

        const cr = viewportRect();
        let bestSlide = null;
        let bestArea = 0;

        slides.forEach((slide) => {
            const r = slide.getBoundingClientRect();
            const top = Math.max(r.top, cr.top);
            const bottom = Math.min(r.bottom, cr.bottom);
            const left = Math.max(r.left, cr.left);
            const right = Math.min(r.right, cr.right);
            const h = Math.max(0, bottom - top);
            const w = Math.max(0, right - left);
            const area = h * w;
            if (area > bestArea) {
                bestArea = area;
                bestSlide = slide;
            }
        });

        const minArea = cr.width * cr.height * 0.12;
        const slot = bestSlide && bestSlide.querySelector(".service-robot-slot");

        if (slot && bestArea >= minArea) {
            if (robotHost.parentElement !== slot) {
                slot.appendChild(robotHost);
            }
            robotHost.removeAttribute("hidden");
            robotHost.style.visibility = "visible";

            const ra = window.serviceRobotAssistant;
            if (ra && typeof ra.setBaseMode === "function" && bestSlide) {
                ra.setBaseMode(getModeForSlide(bestSlide.id));
            }

            if (ra && typeof ra.resize === "function") {
                requestAnimationFrame(() => ra.resize());
            }
        } else {
            robotHost.style.visibility = "hidden";
        }
    }

    const serviceCtas = document.querySelectorAll('.service-slide .service-cta[href="#contact"]');
    serviceCtas.forEach((btn) => {
        const slide = btn.closest("section.service-slide");
        if (!slide) return;

        const slideId = slide.id;
        const onEnter = () => {
            const ra = window.serviceRobotAssistant;
            if (!ra) return;
            const action = getHoverActionForSlide(slideId);
            if (action === "thumbsUp" && typeof ra.sayThumbsUp === "function") ra.sayThumbsUp();
            if (action === "yes" && typeof ra.sayYes === "function") ra.sayYes();
        };

        const onLeave = () => {
            const ra = window.serviceRobotAssistant;
            if (!ra) return;
            if (typeof ra.resumeBehavior === "function") ra.resumeBehavior();
        };

        btn.addEventListener("mouseenter", onEnter);
        btn.addEventListener("mouseleave", onLeave);
    });

    const slideObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!(entry.target instanceof HTMLElement)) return;
                entry.target.classList.toggle("is-visible", entry.isIntersecting && entry.intersectionRatio >= 0.35);
            });
            mountRobotToActiveSlide();
        },
        {
            root: null,
            rootMargin: "-10% 0px -10% 0px",
            threshold: [0, 0.15, 0.25, 0.35, 0.5, 1],
        }
    );

    slides.forEach((slide) => slideObserver.observe(slide));

    window.addEventListener("scroll", mountRobotToActiveSlide, { passive: true });
    window.addEventListener("resize", mountRobotToActiveSlide, { passive: true });
    window.addEventListener("service-robot-ready", mountRobotToActiveSlide, { passive: true });

    mountRobotToActiveSlide();
});
