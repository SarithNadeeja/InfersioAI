(function () {
    const MIN_LOADER_MS = 1400;
    const BANNER_PLAYBACK_RATE = 1;
    /** Empty white tail at end of banner.webm — stop before this */
    const BANNER_TAIL_TRIM_SEC = 1;
    const BANNER_SERVICES_ZOOM_MS = 950;
    const REVERSE_SEEK_FPS = 24;
    const VIDEO_BANNER = "assets/banner.webm";
    const SERVICE_IMAGES = [
        "assets/ai.webp",
        "assets/development.webp",
        "assets/cloud.webp",
    ];

    const loader = document.getElementById("ai-loader");
    const loaderBar = document.getElementById("ai-loader-bar");
    const loaderPct = document.getElementById("ai-loader-pct");
    const loaderStatus = document.getElementById("ai-loader-status");
    const video = document.getElementById("banner-video");
    const servicesSection = document.getElementById("services");
    const serviceCards = document.querySelectorAll(".home-services__card");
    const homeNav = document.querySelector(".home-nav");
    const homeNavMenu = document.getElementById("homeNav");
    const homeNavToggle = document.getElementById("homeNavToggle");
    const visitWebsiteBtn = document.getElementById("visitWebsiteBtn");

    const statusLines = [
        "Calibrating neural mesh…",
        "Syncing vision models…",
        "Loading experience assets…",
        "Priming intelligence core…",
    ];
    let statusIndex = 0;
    let statusTimer = null;
    let servicesVisible = false;
    let bannerDurationSec = 0;
    let servicesRevealAnimating = false;
    let servicesRevealTimer = null;

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

    function waitForVideoElement(targetVideo, src) {
        if (!targetVideo) return Promise.resolve();

        const source = targetVideo.querySelector("source");
        if (source && source.getAttribute("src") !== src) {
            source.src = src;
            targetVideo.load();
        }

        return new Promise((resolve) => {
            const done = () => resolve();
            const timeout = setTimeout(done, 15000);
            const onReady = () => {
                clearTimeout(timeout);
                targetVideo.removeEventListener("canplaythrough", onReady);
                targetVideo.removeEventListener("loadeddata", onReady);
                targetVideo.removeEventListener("error", onReady);
                done();
            };

            if (targetVideo.readyState >= 3) {
                clearTimeout(timeout);
                resolve();
                return;
            }

            targetVideo.addEventListener("canplaythrough", onReady, { once: true });
            targetVideo.addEventListener("loadeddata", onReady, { once: true });
            targetVideo.addEventListener("error", onReady, { once: true });
            if (source) {
                targetVideo.load();
            }
        });
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
            img.src = src;
            if (img.complete) {
                clearTimeout(timeout);
                resolve();
            }
        });
    }

    function enablePageScroll() {
        document.documentElement.classList.add("home-page-root--scrollable");
        document.body.classList.add("home-page--scrollable");
    }

    function syncServicesNavTheme() {
        if (!servicesVisible) return;
        document.body.classList.add("home-page--services");
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

    function getEffectiveBannerEnd() {
        if (!Number.isFinite(bannerDurationSec) || bannerDurationSec <= 0) {
            return 0;
        }
        return Math.max(0, bannerDurationSec - BANNER_TAIL_TRIM_SEC);
    }

    function prefersReducedMotion() {
        return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    }

    function finalizeServicesReveal() {
        if (!servicesSection || servicesVisible) return;
        servicesVisible = true;
        servicesRevealAnimating = false;

        if (servicesRevealTimer !== null) {
            clearTimeout(servicesRevealTimer);
            servicesRevealTimer = null;
        }

        if (video) {
            const end = getEffectiveBannerEnd();
            if (end > 0) {
                video.currentTime = end;
            }
            video.pause();
            video.classList.remove("is-playing");
        }

        servicesSection.classList.remove("is-zoom-revealing", "is-zoom-reveal-active");
        servicesSection.classList.add("is-visible");
        servicesSection.setAttribute("aria-hidden", "false");
        document.body.classList.remove("home-page--services-zoom-reveal");
        document.body.classList.add("home-page--after-video");
        document.body.classList.add("home-page--services");
        enablePageScroll();
        fadeInHomeNav();

        requestAnimationFrame(() => {
            window.scrollTo({ top: 0, behavior: "auto" });
            syncServicesNavTheme();
        });
    }

    function revealServicesFromBanner() {
        if (!servicesSection || servicesVisible || servicesRevealAnimating) return;

        const end = getEffectiveBannerEnd();
        if (video) {
            video.pause();
            if (end > 0) {
                video.currentTime = end;
            }
            video.classList.remove("is-playing");
        }

        if (prefersReducedMotion()) {
            finalizeServicesReveal();
            return;
        }

        servicesRevealAnimating = true;
        document.body.classList.add("home-page--services-zoom-reveal");
        enablePageScroll();
        servicesSection.setAttribute("aria-hidden", "false");
        servicesSection.classList.add("is-zoom-revealing");
        servicesSection.classList.remove("is-visible");

        const finishReveal = () => {
            if (servicesVisible) return;
            finalizeServicesReveal();
        };

        const onZoomEnd = (event) => {
            if (event.target !== servicesSection || event.propertyName !== "transform") return;
            servicesSection.removeEventListener("transitionend", onZoomEnd);
            finishReveal();
        };

        servicesSection.addEventListener("transitionend", onZoomEnd);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                servicesSection.classList.add("is-zoom-reveal-active");
            });
        });

        servicesRevealTimer = window.setTimeout(() => {
            servicesRevealTimer = null;
            servicesSection.removeEventListener("transitionend", onZoomEnd);
            finishReveal();
        }, BANNER_SERVICES_ZOOM_MS);
    }

    function showServices() {
        revealServicesFromBanner();
    }

    function isBannerInteractionLocked() {
        return servicesVisible || servicesRevealAnimating;
    }

    function onBannerTimeUpdate() {
        if (!video || isBannerInteractionLocked()) return;
        const end = getEffectiveBannerEnd();
        if (end <= 0) return;
        if (video.currentTime >= end - 0.04) {
            revealServicesFromBanner();
        }
    }

    function closeHomeNavMenu() {
        if (!homeNavMenu || !homeNavToggle) return;
        homeNavMenu.classList.remove("is-open");
        homeNavToggle.setAttribute("aria-expanded", "false");
        homeNavToggle.setAttribute("aria-label", "Open menu");
    }

    function fadeOutHomeNav() {
        if (!homeNav) return;
        closeHomeNavMenu();
        homeNav.classList.add("is-faded");
    }

    function fadeInHomeNav() {
        if (!homeNav) return;
        homeNav.classList.remove("is-faded");
    }

    function setVisitButtonReady(isReady) {
        if (!visitWebsiteBtn) return;
        visitWebsiteBtn.disabled = !isReady;
        visitWebsiteBtn.classList.toggle("is-hidden", !isReady);
    }

    function startBannerVideo() {
        if (!video) return;

        video.muted = true;
        video.playsInline = true;
        video.autoplay = false;
        video.loop = false;
        video.preload = "auto";
        setVisitButtonReady(false);

        let duration = 0;
        let ready = false;
        let prepared = false;
        /** @type {"idle" | "forward" | "reverse"} */
        let mode = "idle";
        let reverseRaf = null;
        let reverseLastTs = 0;

        function isBannerAtEnd() {
            const end = duration > 0 ? Math.max(0, duration - BANNER_TAIL_TRIM_SEC) : 0;
            return end > 0 && video.currentTime >= end - 0.05;
        }

        function stopReverseRaf() {
            if (reverseRaf !== null) {
                cancelAnimationFrame(reverseRaf);
                reverseRaf = null;
            }
            reverseLastTs = 0;
        }

        function setIdle() {
            mode = "idle";
            stopReverseRaf();
            video.pause();
            video.playbackRate = BANNER_PLAYBACK_RATE;
        }

        function onBannerEnded() {
            const end = duration > 0 ? Math.max(0, duration - BANNER_TAIL_TRIM_SEC) : 0;
            if (end > 0) {
                video.currentTime = end;
            }
            video.pause();
            video.classList.remove("is-playing");
            setIdle();
            if (!servicesVisible) {
                revealServicesFromBanner();
            }
        }

        function playForward() {
            if (!ready || !duration) return;
            if (isBannerInteractionLocked()) return;
            if (mode === "forward") return;
            if (isBannerAtEnd()) {
                revealServicesFromBanner();
                return;
            }

            setVisitButtonReady(false);
            fadeOutHomeNav();
            stopReverseRaf();
            mode = "forward";
            video.classList.add("is-playing");
            video.playbackRate = BANNER_PLAYBACK_RATE;

            const playPromise = video.play();
            if (playPromise && typeof playPromise.catch === "function") {
                playPromise.catch(() => {
                    setIdle();
                    fadeInHomeNav();
                });
            }
        }

        function reverseTick(ts) {
            if (mode !== "reverse" || !duration) return;

            if (!reverseLastTs) reverseLastTs = ts;
            const frameGap = ts - reverseLastTs;
            if (frameGap < 1000 / REVERSE_SEEK_FPS) {
                reverseRaf = requestAnimationFrame(reverseTick);
                return;
            }

            const dt = Math.min(frameGap / 1000, 0.12);
            reverseLastTs = ts;

            let next = video.currentTime - BANNER_PLAYBACK_RATE * dt;
            if (next <= 0) {
                video.currentTime = 0;
                video.classList.remove("is-playing");
                setIdle();
                fadeInHomeNav();
                return;
            }

            video.currentTime = next;
            reverseRaf = requestAnimationFrame(reverseTick);
        }

        function playReverse() {
            if (!ready || !duration) return;
            if (mode === "reverse") return;
            if (video.currentTime <= 0.05) {
                video.currentTime = 0;
                video.pause();
                fadeInHomeNav();
                return;
            }

            fadeOutHomeNav();
            video.pause();
            video.playbackRate = BANNER_PLAYBACK_RATE;
            stopReverseRaf();
            mode = "reverse";
            video.classList.add("is-playing");
            reverseRaf = requestAnimationFrame(reverseTick);
        }

        function onUserScrollDown() {
            if (isBannerInteractionLocked()) return;
            if (isBannerAtEnd()) {
                showServices();
                return;
            }
            playForward();
        }

        function onUserScrollUp() {
            if (isBannerInteractionLocked()) return;
            playReverse();
        }

        function bindControls() {
            let wheelAccum = 0;
            let wheelResetTimer = null;

            window.addEventListener(
                "wheel",
                (e) => {
                    if (!ready || isBannerInteractionLocked()) return;

                    wheelAccum += e.deltaY;
                    clearTimeout(wheelResetTimer);
                    wheelResetTimer = setTimeout(() => {
                        wheelAccum = 0;
                    }, 120);

                    if (wheelAccum > 40) {
                        wheelAccum = 0;
                        onUserScrollDown();
                    } else if (wheelAccum < -40) {
                        wheelAccum = 0;
                        onUserScrollUp();
                    }
                },
                { passive: true }
            );

            let touchY = 0;
            window.addEventListener(
                "touchstart",
                (e) => {
                    touchY = e.touches[0].clientY;
                },
                { passive: true }
            );
            window.addEventListener(
                "touchend",
                (e) => {
                    if (!ready || isBannerInteractionLocked()) return;
                    const y = e.changedTouches[0].clientY;
                    const dy = touchY - y;
                    if (dy > 12) onUserScrollDown();
                    else if (dy < -12) onUserScrollUp();
                },
                { passive: true }
            );
        }

        video.addEventListener("ended", () => {
            if (mode === "forward") {
                onBannerEnded();
            }
        });

        video.addEventListener("timeupdate", onBannerTimeUpdate);

        function prepareVideo() {
            if (prepared) return;
            if (!Number.isFinite(video.duration) || video.duration <= 0) return;
            prepared = true;
            duration = video.duration;
            bannerDurationSec = duration;

            let finished = false;
            const finish = () => {
                if (finished) return;
                finished = true;
                video.pause();
                video.currentTime = 0;
                video.playbackRate = BANNER_PLAYBACK_RATE;
                ready = true;
                fadeInHomeNav();
                setVisitButtonReady(true);
            };

            if (video.readyState >= 4) {
                finish();
                return;
            }

            video.addEventListener("canplaythrough", finish, { once: true });
            setTimeout(finish, 8000);
        }

        const onMeta = () => {
            if (video.readyState >= 1) prepareVideo();
        };

        video.addEventListener("loadedmetadata", onMeta, { once: true });

        if (video.readyState >= 1) {
            onMeta();
        } else {
            video.load();
        }

        video.addEventListener("error", () => {
            console.error("[InfersioAI] Banner video failed to load");
        });

        if (visitWebsiteBtn) {
            visitWebsiteBtn.addEventListener("click", () => {
                playForward();
            });
        }
    }

    async function runLoader() {
        if (!loader) {
            document.body.classList.remove("is-loading");
            startBannerVideo();
            return;
        }

        const loaderStart = performance.now();
        statusTimer = setInterval(cycleStatus, 900);
        cycleStatus();

        setProgress(8);
        await waitForStylesheet();
        setProgress(22);

        await waitForFonts();
        setProgress(42);

        await waitForVideoElement(video, VIDEO_BANNER);
        setProgress(58);

        await Promise.all(SERVICE_IMAGES.map((src) => waitForImage(src)));
        setProgress(78);

        await waitForWindowLoad();
        setProgress(96);

        const elapsed = performance.now() - loaderStart;
        if (elapsed < MIN_LOADER_MS) {
            await wait(MIN_LOADER_MS - elapsed);
        }

        setProgress(100);
        if (loaderStatus) loaderStatus.textContent = "Ready";

        await wait(280);
        clearInterval(statusTimer);

        loader.classList.add("is-done");
        document.body.classList.remove("is-loading");
        startBannerVideo();

        setTimeout(() => {
            loader.remove();
        }, 700);
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

        const servicesLink = menu.querySelector('a[href="#services"]');
        if (servicesLink) {
            servicesLink.addEventListener("click", (e) => {
                if (servicesVisible) return;
                e.preventDefault();
                if (video) {
                    const dur = video.duration;
                    if (Number.isFinite(dur) && dur > 0) {
                        video.currentTime = Math.max(0, dur - BANNER_TAIL_TRIM_SEC);
                        video.pause();
                    }
                }
                showServices();
            });
        }
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
            if (!track || !marqueeSection) return;

            let strips = track.querySelectorAll(".home-comments__strip");
            if (strips.length === 0) {
                marqueeSection.hidden = false;
                for (let i = 0; i < 2; i += 1) {
                    const strip = document.createElement("div");
                    strip.className = "home-comments__strip";
                    if (i === 1) strip.setAttribute("aria-hidden", "true");
                    track.appendChild(strip);
                }
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
        window.addEventListener("scroll", syncServicesNavTheme, { passive: true });
        runLoader();
    }
})();
