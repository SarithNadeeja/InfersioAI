(function () {
    const MIN_LOADER_MS = 700;
    const BANNER_IMAGE = "assets/banner.webp";
    const SERVICE_IMAGES = [
        "assets/ai.webp",
        "assets/development.webp",
        "assets/cloud.webp",
    ];

    const loader = document.getElementById("ai-loader");
    const loaderBar = document.getElementById("ai-loader-bar");
    const loaderPct = document.getElementById("ai-loader-pct");
    const loaderStatus = document.getElementById("ai-loader-status");
    const bannerImage = document.querySelector(".hero-banner__image");
    const servicesSection = document.getElementById("services");
    const serviceCards = document.querySelectorAll(".home-services__card");
    const homeNav = document.querySelector(".home-nav");
    const homeNavMenu = document.getElementById("homeNav");
    const homeNavToggle = document.getElementById("homeNavToggle");

    const statusLines = [
        "Calibrating neural mesh…",
        "Syncing vision models…",
        "Loading experience assets…",
        "Priming intelligence core…",
    ];
    let statusIndex = 0;
    let statusTimer = null;
    let bannerBlobUrl = null;
    let scrollNavThemeObserver = null;

    function setProgress(value) {
        const pct = Math.min(100, Math.max(0, Math.round(value)));
        if (loaderBar) loaderBar.style.width = pct + "%";
        if (loaderPct) loaderPct.textContent = pct + "%";
        if (loader) loader.setAttribute("aria-valuenow", String(pct));
    }

    function cycleStatus() {
        if (!loaderStatus) return;
        loaderStatus.textContent = statusLines[statusIndex % statusLines.length];
        statusIndex += 1;
    }

    function wait(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    function waitForWindowLoad() {
        if (document.readyState === "complete") return Promise.resolve();
        return new Promise((resolve) => {
            window.addEventListener("load", resolve, { once: true });
        });
    }

    function waitForFonts() {
        if (document.fonts && document.fonts.ready) {
            return document.fonts.ready.catch(() => undefined);
        }
        return Promise.resolve();
    }

    function waitForStylesheet() {
        const link = document.querySelector('link[href*="home.css"]');
        if (!link) return Promise.resolve();
        if (link.sheet) return Promise.resolve();
        return new Promise((resolve) => {
            link.addEventListener("load", resolve, { once: true });
            link.addEventListener("error", resolve, { once: true });
            setTimeout(resolve, 4000);
        });
    }

    function resolveAssetUrl(path) {
        try {
            return new URL(path, document.baseURI).href;
        } catch {
            return path;
        }
    }

    function waitForImage(src) {
        return new Promise((resolve) => {
            const img = new Image();
            const done = () => resolve();
            const timeout = setTimeout(done, 10000);
            img.onload = () => {
                clearTimeout(timeout);
                done();
            };
            img.onerror = () => {
                clearTimeout(timeout);
                done();
            };
            img.src = resolveAssetUrl(src);
            if (img.complete) {
                clearTimeout(timeout);
                resolve();
            }
        });
    }

    async function preloadBannerImage(onProgress) {
        const url = resolveAssetUrl(BANNER_IMAGE);

        try {
            const response = await fetch(url, {
                cache: "force-cache",
                credentials: "same-origin",
            });

            if (!response.ok) {
                throw new Error(`Banner HTTP ${response.status}`);
            }

            const total = Number(response.headers.get("content-length")) || 0;
            const body = response.body;

            if (!body || !body.getReader) {
                const blob = await response.blob();
                if (onProgress) onProgress(100);
                if (bannerImage) {
                    bannerBlobUrl = URL.createObjectURL(blob);
                    bannerImage.src = bannerBlobUrl;
                }
                return;
            }

            const reader = body.getReader();
            const chunks = [];
            let loaded = 0;

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                chunks.push(value);
                loaded += value.length;
                if (onProgress && total > 0) {
                    onProgress(Math.min(100, Math.round((loaded / total) * 100)));
                }
            }

            if (onProgress) onProgress(100);
            const blob = new Blob(chunks, { type: "image/webp" });
            if (bannerImage) {
                bannerBlobUrl = URL.createObjectURL(blob);
                bannerImage.src = bannerBlobUrl;
            }
        } catch (err) {
            console.warn("[InfersioAI] Banner fetch failed, using image preload:", err);
            await waitForImage(BANNER_IMAGE);
            if (onProgress) onProgress(100);
        }
    }

    function enablePageScroll() {
        document.documentElement.classList.add("home-page-root--scrollable");
        document.body.classList.add("home-page--scrollable");
    }

    function fadeInHomeNav() {
        if (!homeNav) return;
        homeNav.classList.remove("is-faded");
    }

    function initScrollNavTheme() {
        if (!servicesSection || scrollNavThemeObserver) return;

        scrollNavThemeObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    const overServices = entry.isIntersecting && entry.intersectionRatio >= 0.12;
                    document.body.classList.toggle("home-page--services", overServices);
                });
            },
            { threshold: [0, 0.12, 0.35] }
        );

        scrollNavThemeObserver.observe(servicesSection);
    }

    function initHomeBanner() {
        document.body.classList.add("home-page--image-banner");
        enablePageScroll();
        fadeInHomeNav();

        if (servicesSection) {
            servicesSection.setAttribute("aria-hidden", "false");
            servicesSection.classList.add("is-visible");
        }

        initScrollNavTheme();
    }

    function initServicesEffects() {
        if (!serviceCards.length) return;

        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-inview");
                    }
                });
            },
            { threshold: 0.28, rootMargin: "0px 0px -8% 0px" }
        );

        serviceCards.forEach((card, idx) => {
            card.style.setProperty("--card-delay", `${idx * 90}ms`);
            revealObserver.observe(card);
        });

        if (prefersReducedMotion) return;

        let rafId = null;
        const updateParallax = () => {
            rafId = null;
            const viewportCenter = window.innerHeight / 2;
            serviceCards.forEach((card) => {
                const rect = card.getBoundingClientRect();
                const cardCenter = rect.top + rect.height / 2;
                const distance = (cardCenter - viewportCenter) / Math.max(viewportCenter, 1);
                const shift = Math.max(-16, Math.min(16, distance * 16));
                card.style.setProperty("--scroll-shift", `${shift.toFixed(2)}px`);
            });
        };

        const requestParallaxUpdate = () => {
            if (rafId !== null) return;
            rafId = requestAnimationFrame(updateParallax);
        };

        window.addEventListener("scroll", requestParallaxUpdate, { passive: true });
        window.addEventListener("resize", requestParallaxUpdate, { passive: true });
        requestParallaxUpdate();
    }

    async function runLoader() {
        if (!loader) {
            document.body.classList.remove("is-loading");
            try {
                await preloadBannerImage();
            } catch (e) {
                console.error("[InfersioAI] Banner preload failed:", e);
            }
            initHomeBanner();
            return;
        }

        const loaderStart = performance.now();
        statusTimer = setInterval(cycleStatus, 900);
        cycleStatus();

        setProgress(8);
        await waitForStylesheet();
        setProgress(12);

        if (loaderStatus) {
            loaderStatus.textContent = "Loading banner…";
        }

        const backgroundAssets = Promise.all([
            waitForFonts(),
            Promise.all(SERVICE_IMAGES.map((src) => waitForImage(src))),
            waitForWindowLoad(),
        ]).catch(() => undefined);

        if (loaderBar) {
            loaderBar.classList.add("ai-loader__bar--snap");
        }

        let lastProgress = -1;
        const onBannerProgress = (downloadPct) => {
            const mapped = Math.min(99, Math.round(12 + downloadPct * 0.87));
            if (mapped <= lastProgress) return;
            lastProgress = mapped;
            setProgress(mapped);
        };

        try {
            await preloadBannerImage(onBannerProgress);
        } catch (e) {
            console.error("[InfersioAI] Banner preload failed:", e);
            if (loaderStatus) {
                loaderStatus.textContent = "Could not load banner — check assets/banner.webp";
            }
        }

        setProgress(100);
        initHomeBanner();
        backgroundAssets;

        if (loaderStatus) {
            loaderStatus.textContent = "Ready";
        }

        clearInterval(statusTimer);
        if (loaderBar) {
            loaderBar.classList.remove("ai-loader__bar--snap");
        }

        loader.classList.add("is-done");
        document.body.classList.remove("is-loading");

        setTimeout(() => {
            loader.remove();
        }, 450);
    }

    function initHomeNav() {
        const toggle = document.getElementById("homeNavToggle");
        const menu = document.getElementById("homeNav");
        if (!toggle || !menu) return;

        toggle.addEventListener("click", () => {
            const open = menu.classList.toggle("is-open");
            toggle.setAttribute("aria-expanded", open ? "true" : "false");
            toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
        });

        menu.querySelectorAll(".home-nav__link").forEach((link) => {
            link.addEventListener("click", () => {
                menu.classList.remove("is-open");
                toggle.setAttribute("aria-expanded", "false");
                toggle.setAttribute("aria-label", "Open menu");
            });
        });
    }

    function createCommentCard(comment) {
        const article = document.createElement("article");
        article.className = "home-comments__card";

        const blockquote = document.createElement("blockquote");
        blockquote.className = "home-comments__quote";
        blockquote.textContent = comment.comment_text || "";

        const footer = document.createElement("footer");
        footer.className = "home-comments__meta";

        const strong = document.createElement("strong");
        strong.textContent = comment.name || "";

        const company = document.createElement("span");
        company.className = "home-comments__company";
        company.textContent = comment.company || "";

        footer.append(strong, company);
        article.append(blockquote, footer);
        return article;
    }

    function initHomeCommentForm() {
        const form = document.getElementById("home-comment-form");
        if (!form) return;

        const flash = document.getElementById("home-comment-flash");
        const emptyMsg = document.querySelector(".home-comments__empty");
        const marqueeSection = document.getElementById("home-comments-marquee");
        const track = marqueeSection?.querySelector(".home-comments__track");
        const submitBtn = form.querySelector('[type="submit"]');

        const showFlash = (message, isSuccess) => {
            if (!flash) return;
            flash.textContent = message;
            flash.hidden = false;
            flash.classList.toggle("is-success", isSuccess);
            flash.classList.toggle("is-error", !isSuccess);
        };

        const appendCommentToMarquee = (comment) => {
            if (!track || !comment) return;

            marqueeSection?.removeAttribute("hidden");

            let strips = track.querySelectorAll(".home-comments__strip");
            if (!strips.length) {
                const strip = document.createElement("div");
                strip.className = "home-comments__strip";
                track.appendChild(strip);
                const stripDup = document.createElement("div");
                stripDup.className = "home-comments__strip";
                stripDup.setAttribute("aria-hidden", "true");
                track.appendChild(stripDup);
                strips = track.querySelectorAll(".home-comments__strip");
            }

            strips.forEach((strip) => {
                strip.appendChild(createCommentCard(comment));
            });
        };

        form.addEventListener("submit", async (event) => {
            event.preventDefault();

            if (!form.reportValidity()) return;

            const originalLabel = submitBtn?.textContent || "Submit comment";
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "Submitting…";
            }

            try {
                const response = await fetch(form.action, {
                    method: "POST",
                    body: new FormData(form),
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });

                const data = await response.json().catch(() => ({}));

                if (!response.ok || !data.ok) {
                    showFlash(data.message || "Could not save your comment. Please try again.", false);
                    return;
                }

                const tokenInput = form.querySelector('[name="csrf_token"]');
                if (tokenInput && data.csrf_token) {
                    tokenInput.value = data.csrf_token;
                }

                appendCommentToMarquee(data.comment);
                emptyMsg?.remove();
                form.reset();
                showFlash(data.message || "Thank you — your comment has been added.", true);
            } catch {
                showFlash("Could not save your comment. Please try again.", false);
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalLabel;
                }
            }
        });
    }

    if (document.body.classList.contains("home-page")) {
        initHomeNav();
        initServicesEffects();
        initHomeCommentForm();
        window.addEventListener("pagehide", () => {
            if (bannerBlobUrl) {
                URL.revokeObjectURL(bannerBlobUrl);
            }
        });
        runLoader();
    }
})();
