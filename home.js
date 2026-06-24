(function () {
    const MIN_LOADER_MS = 700;
    const BANNER_IMAGE = "assets/banner.webp";
    const MOBILE_BANNER_IMAGE = "assets/mobilebanner.webp";
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
    const mobileBannerImage = document.querySelector(".hero-banner__mobile-image");
    const servicesSection = document.getElementById("services");
    const serviceCards = document.querySelectorAll(".home-services__card");
    const statusLines = [
        "Calibrating neural mesh…",
        "Syncing vision models…",
        "Loading experience assets…",
        "Priming intelligence core…",
    ];
    let statusIndex = 0;
    let statusTimer = null;
    let bannerBlobUrl = null;
    let mobileBannerBlobUrl = null;

    function isMobileHomeExperience() {
        return (
            window.matchMedia("(max-width: 768px)").matches ||
            /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)
        );
    }

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

    async function preloadBannerImage(onProgress, imagePath, targetEl) {
        const url = resolveAssetUrl(imagePath);

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
                if (targetEl) {
                    const blobUrl = URL.createObjectURL(blob);
                    if (imagePath === MOBILE_BANNER_IMAGE) {
                        mobileBannerBlobUrl = blobUrl;
                    } else {
                        bannerBlobUrl = blobUrl;
                    }
                    targetEl.src = blobUrl;
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
            if (targetEl) {
                const blobUrl = URL.createObjectURL(blob);
                if (imagePath === MOBILE_BANNER_IMAGE) {
                    mobileBannerBlobUrl = blobUrl;
                } else {
                    bannerBlobUrl = blobUrl;
                }
                targetEl.src = blobUrl;
            }
        } catch (err) {
            console.warn("[InfersioAI] Banner fetch failed, using image preload:", err);
            await waitForImage(imagePath);
            if (onProgress) onProgress(100);
        }
    }

    async function preloadDesktopBannerImage(onProgress) {
        return preloadBannerImage(onProgress, BANNER_IMAGE, bannerImage);
    }

    async function preloadMobileBannerImage(onProgress) {
        return preloadBannerImage(onProgress, MOBILE_BANNER_IMAGE, mobileBannerImage);
    }

    function enablePageScroll() {
        document.documentElement.classList.add("home-page-root--scrollable");
        document.body.classList.add("home-page--scrollable");
    }

    function initHomeBanner() {
        if (isMobileHomeExperience()) {
            document.body.classList.add("home-page--mobile-banner");
        } else {
            document.body.classList.add("home-page--image-banner");
        }
        enablePageScroll();

        if (servicesSection) {
            servicesSection.setAttribute("aria-hidden", "false");
            servicesSection.classList.add("is-visible");
        }
    }

    function initLiveCounters() {
        const section = document.getElementById("homeLiveCounter");
        if (!section) return;

        const items = section.querySelectorAll(".home-counter-item[data-counter-value]");
        if (!items.length) return;

        const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

        const formatValue = (value, format) => {
            if (format === "currency") {
                return "$" + value.toLocaleString("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });
            }
            return Math.round(value).toLocaleString("en-US");
        };

        const runCounter = (item) => {
            const display = item.querySelector("[data-counter-display]");
            if (!display || item.dataset.counterAnimated === "true") return;

            const target = parseFloat(item.dataset.counterValue || "0");
            const format = item.dataset.counterFormat || "int";
            item.dataset.counterAnimated = "true";
            item.classList.add("is-inview");

            if (prefersReducedMotion || !Number.isFinite(target)) {
                display.textContent = formatValue(target, format);
                return;
            }

            const duration = 1400;
            const start = performance.now();

            const tick = (now) => {
                const progress = Math.min(1, (now - start) / duration);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = target * eased;
                display.textContent = formatValue(current, format);
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    display.textContent = formatValue(target, format);
                }
            };

            display.textContent = format === "currency" ? "$0.00" : "0";
            requestAnimationFrame(tick);
        };

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        runCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.35, rootMargin: "0px 0px -8% 0px" }
        );

        items.forEach((item, index) => {
            item.style.setProperty("--counter-delay", `${index * 70}ms`);
            observer.observe(item);
        });
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
                if (isMobileHomeExperience()) {
                    await preloadMobileBannerImage();
                } else {
                    await preloadDesktopBannerImage();
                }
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
            if (isMobileHomeExperience()) {
                await preloadMobileBannerImage(onBannerProgress);
            } else {
                await preloadDesktopBannerImage(onBannerProgress);
            }
        } catch (e) {
            console.error("[InfersioAI] Banner preload failed:", e);
            if (loaderStatus) {
                loaderStatus.textContent = isMobileHomeExperience()
                    ? "Could not load banner — check assets/mobilebanner.webp"
                    : "Could not load banner — check assets/banner.webp";
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
        initServicesEffects();
        initLiveCounters();
        initHomeCommentForm();
        window.addEventListener("pagehide", () => {
            if (bannerBlobUrl) {
                URL.revokeObjectURL(bannerBlobUrl);
            }
            if (mobileBannerBlobUrl) {
                URL.revokeObjectURL(mobileBannerBlobUrl);
            }
        });
        runLoader();
    }
})();
