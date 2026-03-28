const navToggle = document.getElementById("navToggle");
const navbar = document.getElementById("navbar");
const dropdownParents = document.querySelectorAll(".has-dropdown");

if (navToggle && navbar) {
    navToggle.addEventListener("click", () => {
        navbar.classList.toggle("open");
    });
}

dropdownParents.forEach((item) => {
    const trigger = item.querySelector("a");
    if (!trigger) return;

    trigger.addEventListener("click", (event) => {
        if (window.innerWidth <= 980) {
            event.preventDefault();
            item.classList.toggle("mobile-open");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const rotatorItems = [
        document.getElementById("hero-slide-1"),
        document.getElementById("hero-rotator-ai"),
        document.getElementById("software-engineering"),
    ];

    let rotatorIndex = 0;
    let rotatorTimer = null;

    function setRotatorIndex(nextIndex) {
        if (!rotatorItems[0] && !rotatorItems[1] && !rotatorItems[2]) return;
        rotatorIndex = Math.max(0, Math.min(2, nextIndex));

        rotatorItems.forEach((el, i) => {
            if (!el) return;
            el.classList.toggle("is-active", i === rotatorIndex);
        });
    }

    function startRotator() {
        if (!rotatorItems[0] && !rotatorItems[1] && !rotatorItems[2]) return;

        if (rotatorTimer) clearInterval(rotatorTimer);
        rotatorTimer = setInterval(() => {
            setRotatorIndex((rotatorIndex + 1) % 3);
        }, 4800);
    }

    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) return;
        section.scrollIntoView({ behavior: "smooth", block: "start" });
    }

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener("click", (e) => {
            const href = link.getAttribute("href");
            if (!href || href === "#") return;

            const id = href.slice(1);
            if (!id) return;

            if (document.getElementById(id)) {
                e.preventDefault();
                if (id === "home") {
                    scrollToSection("home");
                    setRotatorIndex(0);
                } else if (id === "software-engineering") {
                    scrollToSection("home");
                    setRotatorIndex(2);
                } else {
                    scrollToSection(id);
                }
                if (navbar) navbar.classList.remove("open");
            }
        });
    });

    if (location.hash && location.hash.length > 1) {
        const id = location.hash.slice(1);
        requestAnimationFrame(() => {
            if (id === "home") {
                scrollToSection("home");
                setRotatorIndex(0);
            } else if (id === "software-engineering") {
                scrollToSection("home");
                setRotatorIndex(2);
            } else if (document.getElementById(id)) {
                scrollToSection(id);
            }
        });
    }

    setRotatorIndex(0);
    startRotator();

    const form = document.getElementById("contactForm");
    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const name = formData.get("name") || "";
            alert(`Thanks${name ? ", " + name : ""}! We received your message.`);
            form.reset();
        });
    }

    const contactUsLinks = document.querySelectorAll('a.cta-btn[href="#contact"]');
    if (contactUsLinks.length) {
        const assistant = () => window.robotAssistant;

        contactUsLinks.forEach((link) => {
            link.addEventListener("mouseenter", () => {
                const a = assistant();
                if (a && typeof a.sayYes === "function") a.sayYes();
            });

            link.addEventListener("mouseleave", () => {
                const a = assistant();
                if (a && typeof a.resumeBehavior === "function") a.resumeBehavior();
            });
        });
    }
});
