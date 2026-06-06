(function () {
    const MIN_LOADER_MS = 700;
    const BANNER_FETCH_TIMEOUT_MS = 180000;
    const BANNER_PLAYBACK_RATE = 1;
    /** Empty white tail at end of banner.webm — stop before this */
    const BANNER_TAIL_TRIM_SEC = 1;
    const BANNER_SERVICES_ZOOM_MS = 600;
    const REVERSE_SEEK_FPS = 24;
    const SWIPE_THRESHOLD_PX = 28;
    const SWIPE_THRESHOLD_COARSE_PX = 36;

    function resolveAssetUrl(path) {
        try {
            return new URL(path, document.baseURI).href;
        } catch {
            return path;
        }
    }

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
    const video = document.getElementById("banner-video");
    const mobileBannerImage = document.querySelector(".hero-banner__mobile-image");
    const heroBanner = document.querySelector(".hero-banner");
    const bannerScrollHint = document.getElementById("bannerScrollHint");
    const VIDEO_BANNER = (video && video.dataset.bannerSrc) || "assets/banner.webm";
    const VIDEO_BANNER_MP4 = (video && video.dataset.bannerMp4) || "assets/banner.mp4";
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
    let servicesVisible = false;
    let bannerDurationSec = 0;
    let servicesRevealAnimating = false;
    let servicesRevealTimer = null;
    let bannerVideoInitialized = false;
    let bannerMediaReady = false;
    let bannerBlobUrl = null;

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

    function isMobileHomeExperience() {
        return (
            window.matchMedia("(pointer: coarse)").matches ||
            /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent)
        );
    }

    function preferProgressiveBannerLoad() {
        return isMobileHomeExperience();
    }

    function blockIntroVideoOnMobile() {
        if (!isMobileHomeExperience() || !video) return;
        video.preload = "none";
        video.querySelectorAll("source").forEach((node) => node.remove());
        video.removeAttribute("src");
        video.load();
    }

    blockIntroVideoOnMobile();

    let mobileBannerBlobUrl = null;
    let mobileNavThemeObserver = null;

    async function preloadMobileBannerImage(onProgress) {
        const url = resolveAssetUrl(MOBILE_BANNER_IMAGE);

        try {
            const response = await fetch(url, {
                cache: "force-cache",
                credentials: "same-origin",
            });

            if (!response.ok) {
                throw new Error(`Mobile banner HTTP ${response.status}`);
            }

            const total = Number(response.headers.get("content-length")) || 0;
            const body = response.body;

            if (!body || !body.getReader) {
                const blob = await response.blob();
                if (onProgress) onProgress(100);
                if (mobileBannerImage) {
                    mobileBannerBlobUrl = URL.createObjectURL(blob);
                    mobileBannerImage.src = mobileBannerBlobUrl;
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
            if (mobileBannerImage) {
                mobileBannerBlobUrl = URL.createObjectURL(blob);
                mobileBannerImage.src = mobileBannerBlobUrl;
            }
        } catch (err) {
            console.warn("[InfersioAI] Mobile banner fetch failed, using image preload:", err);
            await waitForImage(MOBILE_BANNER_IMAGE);
            if (onProgress) onProgress(100);
        }
    }

    function initMobileScrollNavTheme() {
        if (!servicesSection || mobileNavThemeObserver) return;

        mobileNavThemeObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    const overServices = entry.isIntersecting && entry.intersectionRatio >= 0.12;
                    document.body.classList.toggle("home-page--services", overServices);
                });
            },
            { threshold: [0, 0.12, 0.35] }
        );

        mobileNavThemeObserver.observe(servicesSection);
    }

    function initMobileHomeBanner() {
        document.body.classList.add("home-page--mobile-banner");
        enablePageScroll();
        fadeInHomeNav();
        setBannerScrollHintVisible(false);

        if (servicesSection) {
            servicesSection.setAttribute("aria-hidden", "false");
            servicesSection.classList.add("is-visible");
        }

        initMobileScrollNavTheme();
    }

    function bufferedEndSec(targetVideo) {
        try {
            const ranges = targetVideo.buffered;
            if (!ranges.length) return 0;
            let end = 0;
            for (let i = 0; i < ranges.length; i += 1) {
                end = Math.max(end, ranges.end(i));
            }
            return end;
        } catch {
            return 0;
        }
    }

    function isVideoFullyBuffered(targetVideo) {
        if (!targetVideo) return false;
        if (targetVideo.readyState >= 4) return true;
        const dur = targetVideo.duration;
        if (!Number.isFinite(dur) || dur <= 0) return false;
        return bufferedEndSec(targetVideo) >= dur - 0.35;
    }

    function isBannerReadyToInteract(targetVideo) {
        if (!targetVideo) return false;
        if (isVideoFullyBuffered(targetVideo)) return true;
        if (!preferProgressiveBannerLoad()) return false;
        const dur = targetVideo.duration;
        if (!Number.isFinite(dur) || dur <= 0) return false;
        if (targetVideo.readyState < 3) return false;
        return bufferedEndSec(targetVideo) >= dur * 0.9;
    }

    function waitForVideoCanPlayThrough(targetVideo) {
        if (!targetVideo) return Promise.resolve();

        return new Promise((resolve, reject) => {
            const cleanup = () => {
                clearTimeout(timeoutId);
                targetVideo.removeEventListener("canplaythrough", onProgress);
                targetVideo.removeEventListener("progress", onProgress);
                targetVideo.removeEventListener("loadeddata", onProgress);
                targetVideo.removeEventListener("error", onError);
            };

            const finish = () => {
                cleanup();
                resolve();
            };

            const onError = () => {
                cleanup();
                reject(new Error("Banner video failed to decode"));
            };

            const onProgress = () => {
                if (isBannerReadyToInteract(targetVideo)) {
                    finish();
                }
            };

            if (isBannerReadyToInteract(targetVideo)) {
                finish();
                return;
            }

            const timeoutId = setTimeout(() => {
                if (isBannerReadyToInteract(targetVideo)) {
                    finish();
                    return;
                }
                cleanup();
                reject(new Error("Banner video load timed out"));
            }, BANNER_FETCH_TIMEOUT_MS);

            targetVideo.addEventListener("canplaythrough", onProgress, { once: true });
            targetVideo.addEventListener("progress", onProgress);
            targetVideo.addEventListener("loadeddata", onProgress);
            targetVideo.addEventListener("error", onError, { once: true });
        });
    }

    async function fetchBannerAsBlob(url, onProgress) {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), BANNER_FETCH_TIMEOUT_MS);

        try {
            const response = await fetch(url, {
                cache: "force-cache",
                credentials: "same-origin",
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`Banner HTTP ${response.status}`);
            }

            const total = Number(response.headers.get("content-length")) || 0;
            const body = response.body;

            if (!body || !body.getReader) {
                const blob = await response.blob();
                if (onProgress) onProgress(100);
                return URL.createObjectURL(blob);
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
            const mime = response.headers.get("content-type") || "video/webm";
            const blob = new Blob(chunks, { type: mime.split(";")[0] });
            return URL.createObjectURL(blob);
        } finally {
            clearTimeout(timeoutId);
        }
    }

    function mountBannerOnVideo(targetVideo, mediaUrl) {
        targetVideo.querySelectorAll("source").forEach((node) => node.remove());
        targetVideo.src = mediaUrl;
        targetVideo.preload = "auto";
        targetVideo.load();
    }

    function getBannerFetchUrl() {
        if (!video) return resolveAssetUrl(VIDEO_BANNER);
        const current = video.currentSrc || video.src;
        if (current) return current;
        const sources = video.querySelectorAll("source");
        for (const source of sources) {
            const type = source.getAttribute("type") || "";
            if (!type || video.canPlayType(type) !== "") {
                const src = source.getAttribute("src");
                if (src) return resolveAssetUrl(src);
            }
        }
        return resolveAssetUrl(VIDEO_BANNER);
    }

    async function resolveBannerSources() {
        if (!video) return;

        const mp4Url = resolveAssetUrl(VIDEO_BANNER_MP4);
        let useMp4 = false;
        try {
            const head = await fetch(mp4Url, { method: "HEAD", cache: "force-cache" });
            useMp4 = head.ok;
        } catch {
            useMp4 = false;
        }

        video.querySelectorAll("source").forEach((node) => node.remove());

        if (useMp4) {
            const mp4 = document.createElement("source");
            mp4.src = mp4Url;
            mp4.type = "video/mp4";
            video.appendChild(mp4);
        }

        const webm = document.createElement("source");
        webm.src = resolveAssetUrl(VIDEO_BANNER);
        webm.type = "video/webm";
        video.appendChild(webm);
    }

    async function preloadBannerProgressive(onProgress) {
        video.preload = "auto";
        video.load();

        await new Promise((resolve, reject) => {
            const onProg = () => {
                const dur = video.duration;
                if (dur > 0 && onProgress) {
                    onProgress(Math.min(100, Math.round((bufferedEndSec(video) / dur) * 100)));
                }
                if (isBannerReadyToInteract(video)) {
                    cleanup();
                    resolve();
                }
            };

            const cleanup = () => {
                clearTimeout(timeoutId);
                video.removeEventListener("progress", onProg);
                video.removeEventListener("canplaythrough", onProg);
                video.removeEventListener("loadeddata", onProg);
                video.removeEventListener("error", onError);
            };

            const onError = () => {
                cleanup();
                reject(new Error("Banner video failed to load"));
            };

            if (isBannerReadyToInteract(video)) {
                resolve();
                return;
            }

            const timeoutId = setTimeout(() => {
                if (isBannerReadyToInteract(video) || video.readyState >= 3) {
                    cleanup();
                    resolve();
                    return;
                }
                cleanup();
                reject(new Error("Banner video load timed out"));
            }, BANNER_FETCH_TIMEOUT_MS);

            video.addEventListener("progress", onProg);
            video.addEventListener("canplaythrough", onProg, { once: true });
            video.addEventListener("loadeddata", onProg);
            video.addEventListener("error", onError, { once: true });
        });
    }

    /** Mobile / touch — progressive buffer (do not change without mobile QA). */
    async function preloadBannerVideoFully(onProgress) {
        if (!video) return;

        video.muted = true;
        video.playsInline = true;
        video.setAttribute("playsinline", "");
        video.setAttribute("webkit-playsinline", "");

        await resolveBannerSources();
        await preloadBannerProgressive(onProgress);
        bannerMediaReady = true;
    }

    /** Desktop — full file fetch + blob; progress snaps to real download % */
    async function preloadBannerVideoDesktop(onProgress) {
        if (!video) return;

        video.muted = true;
        video.playsInline = true;
        video.setAttribute("playsinline", "");
        video.setAttribute("webkit-playsinline", "");

        await resolveBannerSources();

        const url = getBannerFetchUrl();
        try {
            bannerBlobUrl = await fetchBannerAsBlob(url, onProgress);
            mountBannerOnVideo(video, bannerBlobUrl);
            await waitForVideoCanPlayThrough(video);
        } catch (err) {
            console.warn("[InfersioAI] Banner blob preload failed, using progressive load:", err);
            await preloadBannerProgressive(onProgress);
        }

        if (onProgress) {
            onProgress(100);
        }
        bannerMediaReady = true;
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

    function setBannerScrollHintVisible(isVisible) {
        if (!bannerScrollHint) return;
        bannerScrollHint.hidden = !isVisible;
        bannerScrollHint.classList.toggle("is-visible", isVisible);
    }

    function startBannerVideo() {
        if (!video || bannerVideoInitialized) return;
        bannerVideoInitialized = true;

        video.muted = true;
        video.playsInline = true;
        video.setAttribute("playsinline", "");
        video.setAttribute("webkit-playsinline", "");
        video.autoplay = false;
        video.loop = false;
        video.preload = "auto";
        setBannerScrollHintVisible(false);

        let duration = 0;
        let ready = false;
        let prepared = false;
        let controlsBound = false;
        let reverseRaf = null;
        let reverseLastTs = 0;
        /** @type {"idle" | "forward" | "reverse"} */
        let mode = "idle";

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
            if (ready && !isBannerInteractionLocked()) {
                setBannerScrollHintVisible(true);
            }
        }

        function onBannerEnded() {
            const end = duration > 0 ? Math.max(0, duration - BANNER_TAIL_TRIM_SEC) : 0;
            if (end > 0) {
                video.currentTime = end;
            }
            video.pause();
            video.classList.remove("is-playing");
            setIdle();
            setBannerScrollHintVisible(false);
            document.body.classList.remove("home-page--intro-playing");
            if (!servicesVisible) {
                revealServicesFromBanner();
            }
        }

        function beginForwardPlayback() {
            document.body.classList.add("home-page--intro-playing");
            setBannerScrollHintVisible(false);
            stopReverseRaf();
            mode = "forward";
            video.classList.add("is-playing");
            video.playbackRate = BANNER_PLAYBACK_RATE;
            video.currentTime = 0;
            fadeOutHomeNav();

            const playPromise = video.play();
            if (playPromise && typeof playPromise.catch === "function") {
                playPromise.catch(() => {
                    document.body.classList.remove("home-page--intro-playing");
                    setIdle();
                    fadeInHomeNav();
                });
            }
        }

        function playForward() {
            if (!bannerMediaReady || !ready) return;
            if (isBannerInteractionLocked()) return;
            if (mode === "forward") return;

            if (!duration && Number.isFinite(video.duration) && video.duration > 0) {
                duration = video.duration;
                bannerDurationSec = duration;
            }
            if (!duration) return;

            if (isBannerAtEnd()) {
                revealServicesFromBanner();
                return;
            }

            beginForwardPlayback();
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
                document.body.classList.remove("home-page--intro-playing");
                setIdle();
                fadeInHomeNav();
                return;
            }

            video.currentTime = next;
            reverseRaf = requestAnimationFrame(reverseTick);
        }

        function playReverse() {
            if (!bannerMediaReady || !ready) return;
            if (isBannerInteractionLocked()) return;
            if (mode === "reverse") return;
            if (video.currentTime <= 0.05) {
                video.currentTime = 0;
                video.pause();
                fadeInHomeNav();
                setBannerScrollHintVisible(true);
                return;
            }

            document.body.classList.add("home-page--intro-playing");
            setBannerScrollHintVisible(false);
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
            if (controlsBound) return;
            controlsBound = true;

            const swipeThreshold = window.matchMedia("(pointer: coarse)").matches
                ? SWIPE_THRESHOLD_COARSE_PX
                : SWIPE_THRESHOLD_PX;

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
                    }, 140);

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

            const touchTarget = heroBanner || video;
            let touchY = 0;
            let touchActive = false;

            touchTarget.addEventListener(
                "touchstart",
                (e) => {
                    if (!ready || isBannerInteractionLocked()) return;
                    touchY = e.touches[0].clientY;
                    touchActive = true;
                },
                { passive: true }
            );

            touchTarget.addEventListener(
                "touchmove",
                (e) => {
                    if (!touchActive || !ready || isBannerInteractionLocked()) return;
                    const dy = touchY - e.touches[0].clientY;
                    if (Math.abs(dy) > 12) {
                        e.preventDefault();
                    }
                },
                { passive: false }
            );

            touchTarget.addEventListener(
                "touchend",
                (e) => {
                    if (!touchActive || !ready || isBannerInteractionLocked()) return;
                    touchActive = false;
                    const y = e.changedTouches[0].clientY;
                    const dy = touchY - y;
                    if (dy > swipeThreshold) onUserScrollDown();
                    else if (dy < -swipeThreshold) onUserScrollUp();
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
            if (!bannerMediaReady) return;
            if (!Number.isFinite(video.duration) || video.duration <= 0) return;
            if (!isBannerReadyToInteract(video)) return;

            prepared = true;
            duration = video.duration;
            bannerDurationSec = duration;
            ready = true;
            video.pause();
            video.currentTime = 0;
            video.playbackRate = BANNER_PLAYBACK_RATE;
            fadeInHomeNav();
            setBannerScrollHintVisible(true);
            bindControls();
        }

        const onMeta = () => prepareVideo();

        video.addEventListener("loadedmetadata", onMeta);
        video.addEventListener("canplaythrough", onMeta);
        video.addEventListener("progress", onMeta);

        if (video.readyState >= 1) {
            onMeta();
        }

        video.addEventListener("error", () => {
            console.error("[InfersioAI] Banner video failed to load");
        });
    }

    async function runLoader() {
        if (!loader) {
            document.body.classList.remove("is-loading");
            if (isMobileHomeExperience()) {
                try {
                    await preloadMobileBannerImage();
                } catch (e) {
                    console.error("[InfersioAI] Mobile banner preload failed:", e);
                }
                initMobileHomeBanner();
            } else {
                try {
                    await preloadBannerVideoDesktop();
                } catch (e) {
                    console.error("[InfersioAI] Banner preload failed:", e);
                }
                startBannerVideo();
            }
            return;
        }

        const loaderStart = performance.now();
        statusTimer = setInterval(cycleStatus, 900);
        cycleStatus();

        setProgress(8);
        await waitForStylesheet();
        setProgress(12);

        if (loaderStatus) {
            loaderStatus.textContent = "Loading intro video…";
        }

        const backgroundAssets = Promise.all([
            waitForFonts(),
            Promise.all(SERVICE_IMAGES.map((src) => waitForImage(src))),
            waitForWindowLoad(),
        ]).catch(() => undefined);

        if (isMobileHomeExperience()) {
            if (loaderStatus) {
                loaderStatus.textContent = "Loading banner…";
            }

            try {
                await preloadMobileBannerImage((downloadPct) => {
                    setProgress(12 + downloadPct * 0.8);
                });
            } catch (e) {
                console.error("[InfersioAI] Mobile banner preload failed:", e);
                if (loaderStatus) {
                    loaderStatus.textContent = "Could not load banner — check assets/mobilebanner.webp";
                }
            }

            setProgress(94);
            initMobileHomeBanner();

            await backgroundAssets;
            setProgress(98);

            const elapsed = performance.now() - loaderStart;
            if (elapsed < MIN_LOADER_MS) {
                await wait(MIN_LOADER_MS - elapsed);
            }

            setProgress(100);
            if (loaderStatus) loaderStatus.textContent = "Ready";

            await wait(120);
            clearInterval(statusTimer);

            loader.classList.add("is-done");
            document.body.classList.remove("is-loading");

            setTimeout(() => {
                loader.remove();
            }, 450);
            return;
        }

        if (loaderBar) {
            loaderBar.classList.add("ai-loader__bar--snap");
        }

        let lastDesktopProgress = -1;
        const onDesktopDownloadProgress = (downloadPct) => {
            const mapped = Math.min(99, Math.round(12 + downloadPct * 0.87));
            if (mapped <= lastDesktopProgress) return;
            lastDesktopProgress = mapped;
            setProgress(mapped);
        };

        try {
            await preloadBannerVideoDesktop(onDesktopDownloadProgress);
        } catch (e) {
            console.error("[InfersioAI] Banner preload failed:", e);
            if (loaderStatus) {
                loaderStatus.textContent = "Could not load intro — check assets/banner.webm on server";
            }
            if (video && isVideoFullyBuffered(video)) {
                bannerMediaReady = true;
            }
        }

        setProgress(100);
        startBannerVideo();
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

        const servicesLink = menu.querySelector('a[href="#services"]');
        if (servicesLink) {
            servicesLink.addEventListener("click", (e) => {
                if (document.body.classList.contains("home-page--mobile-banner")) return;
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
