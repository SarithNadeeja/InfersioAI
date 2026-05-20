/* global THREE */

(function () {
    // Allow reusing this file for multiple robot canvases.
    // Defaults are for the banner robot.
    const containerId = window.ROBOT_CONTAINER_ID || "robot-container";
    const assistantKey = window.ROBOT_ASSISTANT_KEY || "robotAssistant";
    const readyEvent = window.ROBOT_READY_EVENT || "robot-ready";

    // Service pages (AI, Web, Mobile app, maintenance — not homepage): idle → wave every 30s → idle → …
    const SERVICE_IDLE_WAVE_CYCLE_KEYS = new Set([
        "aiPageRobotAssistant",
        "aiAgentsPageRobotAssistant",
        "aiChatbotsPageRobotAssistant",
        "aiAutomationPageRobotAssistant",
        "aiLeadGenerationPageRobotAssistant",
        "aiContentAutomationPageRobotAssistant",
        "aiSecurityPageRobotAssistant",
        "webSolutionsPageRobotAssistant",
        "mobileApplicationsPageRobotAssistant",
        "customWebsiteDevPageRobotAssistant",
        "webApplicationDevelopmentPageRobotAssistant",
        "ecommerceSolutionsPageRobotAssistant",
        "uiUxDesignPageRobotAssistant",
        "websiteMaintenancePageRobotAssistant",
        "androidAppDevPageRobotAssistant",
        "iosAppDevPageRobotAssistant",
        "crossPlatformAppsPageRobotAssistant",
        "appUiUxDesignPageRobotAssistant",
        "appMaintenancePageRobotAssistant",
        "softwareEngineeringPageRobotAssistant",
        "desktopAppDevPageRobotAssistant",
        "customBusinessSoftwarePageRobotAssistant",
        "systemAutomationToolsPageRobotAssistant",
        "apiDevelopmentPageRobotAssistant",
        "cloudSoftwarePageRobotAssistant",
        "aboutPageRobotAssistant",
        "contactPageRobotAssistant",
    ]);
    const IDLE_WAVE_CYCLE_SECONDS = 30;

    const container = document.getElementById(containerId);
    if (!container) return;

    const clock = new THREE.Clock();

    // Scene / camera / renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, 1, 0.01, 5000);
    camera.position.set(0, 1.2, 3);

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true,
    });
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    // Lighting
    scene.add(new THREE.AmbientLight(0xffffff, 0.65));
    const dirLight = new THREE.DirectionalLight(0xffffff, 1.2);
    dirLight.position.set(4, 8, 6);
    scene.add(dirLight);
    scene.add(new THREE.HemisphereLight(0x8fb6ff, 0x1b2437, 0.65));

    // Animation system
    let mixer = null;
    const actions = {}; // actions[clipName] = mixer.clipAction(clip)
    let currentAction = null;
    let modelRoot = null;

    // Walk / Wave loop
    let state = "walk"; // "walk" | "wave"
    let stateElapsed = 0;
    const WALK_SECONDS = 5.0;
    const FADE_SECONDS = 0.35;

    let walkName = null;
    let waveName = null; // kept for backward compatibility
    let yesName = null;
    let pendingSayYes = false;

    // Service-slide pose system
    // baseMode controls the default looping pose while not hovering.
    let idleName = null;
    let sitName = null;
    let standName = null;
    let thumbsName = null;
    let noName = null;
    let angryName = null;
    let sadName = null;
    let happyName = null;
    let surprisedName = null;
    let coolName = null;
    let danceName = null;
    let deadName = null;
    let baseMode =
        assistantKey === "serviceRobotAssistant" ||
        assistantKey === "reviewRobotAssistant" ||
        assistantKey === "aiPageRobotAssistant" ||
        assistantKey === "aiAgentsPageRobotAssistant" ||
        assistantKey === "aiChatbotsPageRobotAssistant" ||
        assistantKey === "aiAutomationPageRobotAssistant" ||
        assistantKey === "aiLeadGenerationPageRobotAssistant" ||
        assistantKey === "aiContentAutomationPageRobotAssistant" ||
        assistantKey === "aiSecurityPageRobotAssistant" ||
        assistantKey === "webSolutionsPageRobotAssistant" ||
        assistantKey === "mobileApplicationsPageRobotAssistant" ||
        assistantKey === "customWebsiteDevPageRobotAssistant" ||
        assistantKey === "webApplicationDevelopmentPageRobotAssistant" ||
        assistantKey === "ecommerceSolutionsPageRobotAssistant" ||
        assistantKey === "uiUxDesignPageRobotAssistant" ||
        assistantKey === "websiteMaintenancePageRobotAssistant" ||
        assistantKey === "androidAppDevPageRobotAssistant" ||
        assistantKey === "iosAppDevPageRobotAssistant" ||
        assistantKey === "crossPlatformAppsPageRobotAssistant" ||
        assistantKey === "appUiUxDesignPageRobotAssistant" ||
        assistantKey === "appMaintenancePageRobotAssistant" ||
        assistantKey === "softwareEngineeringPageRobotAssistant" ||
        assistantKey === "desktopAppDevPageRobotAssistant" ||
        assistantKey === "customBusinessSoftwarePageRobotAssistant" ||
        assistantKey === "systemAutomationToolsPageRobotAssistant" ||
        assistantKey === "apiDevelopmentPageRobotAssistant" ||
        assistantKey === "cloudSoftwarePageRobotAssistant" ||
        assistantKey === "aboutPageRobotAssistant" ||
        assistantKey === "contactPageRobotAssistant"
            ? "idle"
            : "walk";
    let pendingThumbsUp = false;
    let pendingSayNo = false;

    // Subtle horizontal movement while walking
    let wiggleT = 0;
    let modelRadiusRef = 1;
    let sequenceHold = false; // when true, stop the walk/wave loop
    let idleWaveCycleTimer = 0;

    function normalizeName(name) {
        return String(name || "")
            .trim()
            .toLowerCase();
    }

    function findClipNameByKeywords(names, keywords) {
        const upper = names.slice();
        for (const key of keywords) {
            const hit = upper.find((n) => normalizeName(n).includes(key));
            if (hit) return hit;
        }
        return null;
    }

    function resizeRenderer() {
        // Use clientWidth/Height to get the layout size ignoring CSS transforms
        const width = Math.max(1, container.clientWidth);
        const height = Math.max(1, container.clientHeight);

        camera.aspect = width / height;
        camera.updateProjectionMatrix();

        renderer.setSize(width, height, false);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    }

    const resizeObserver = new ResizeObserver(() => {
        resizeRenderer();
    });
    resizeObserver.observe(container);
    resizeRenderer();

    function fitModel(model) {
        // 1) Center using Box3
        model.updateMatrixWorld(true);
        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());
        model.position.sub(center);

        // 2) Dynamic scaling based on bounding box size
        const size = box.getSize(new THREE.Vector3());
        const height = size.y > 0 ? size.y : 1;

        // Scale so the model roughly occupies a comfortable height in camera space.
        // (No hardcoded model scale vectors; this is derived from bounding box height.)
        const targetHeight = 2.4;
        const scale = targetHeight / height;
        model.scale.multiplyScalar(scale);
        model.updateMatrixWorld(true);

        // 3) Re-center after scaling
        const box2 = new THREE.Box3().setFromObject(model);
        const center2 = box2.getCenter(new THREE.Vector3());
        model.position.sub(center2);

        // 4) Update radius + camera
        const size2 = box2.getSize(new THREE.Vector3());
        const radius = Math.max(size2.x, size2.y, size2.z) / 2 || 1;
        modelRadiusRef = radius;

        // Fit camera to bounding sphere radius
        const fovRad = THREE.MathUtils.degToRad(camera.fov);
        const margin = 1.6;
        const distance = (radius / Math.tan(fovRad / 2)) * margin;

        camera.near = Math.max(0.01, distance / 1000);
        camera.far = Math.max(100, distance * 60);
        camera.updateProjectionMatrix();

        // Slightly left so it's angled, still facing the viewer
        camera.position.set(-distance * 0.1, distance * 0.22, distance * 0.95);
        camera.lookAt(0, 0, 0);

        // Nudge down so the character sits naturally inside the frame
        model.position.y -= radius * 0.12;
    }

    function playAnimation(name, opts) {
        if (!name || !actions[name]) return;

        const next = actions[name];
        const prev = currentAction;
        const loop = opts && opts.loop ? opts.loop : THREE.LoopRepeat;
        const repetitions =
            opts && typeof opts.repetitions === "number" ? opts.repetitions : Infinity;
        const clampWhenFinished = !!(opts && opts.clampWhenFinished);

        if (prev && prev !== next) prev.fadeOut(FADE_SECONDS);

        // Ensure only one animation plays. Avoid stopping `prev` immediately
        // so fadeOut remains visible; stop/reset other actions right away.
        Object.keys(actions).forEach((key) => {
            const act = actions[key];
            if (act === next) return;
            if (act === prev) return;
            act.stop();
            act.reset();
        });

        next.reset();
        next.setLoop(loop, repetitions);
        next.clampWhenFinished = clampWhenFinished;
        next.fadeIn(FADE_SECONDS);
        next.play();

        currentAction = next;

        if (prev && prev !== next) {
            const prevToStop = prev;
            setTimeout(() => {
                try {
                    prevToStop.stop();
                    prevToStop.reset();
                } catch (e) {
                    // ignore
                }
            }, Math.round(FADE_SECONDS * 1000) + 30);
        }
    }

    function sequenceTick(delta) {
        if (!mixer) return;
        if (sequenceHold) return;
        stateElapsed += delta;

        if (state === "walk") {
            wiggleT += delta;
            if (modelRoot) {
                modelRoot.position.x =
                    Math.sin(wiggleT * 0.9) * modelRadiusRef * 0.035;
            }

            if (stateElapsed >= WALK_SECONDS && waveName) {
                state = "wave";
                stateElapsed = 0;
                playAnimation(waveName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
            }
        } else if (state === "wave") {
            if (modelRoot) modelRoot.position.x = 0;
        }

        if (
            SERVICE_IDLE_WAVE_CYCLE_KEYS.has(assistantKey) &&
            baseMode === "idle" &&
            waveName &&
            state === "static"
        ) {
            idleWaveCycleTimer += delta;
            if (idleWaveCycleTimer >= IDLE_WAVE_CYCLE_SECONDS) {
                idleWaveCycleTimer = 0;
                state = "wave";
                playAnimation(waveName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
            }
        }
    }

    function sayYes() {
        if (!mixer || !modelRoot) {
            pendingSayYes = true;
            return;
        }

        // Pause the walking loop and play a wave-like "yes" once.
        sequenceHold = true;
        state = "wave";
        stateElapsed = 0;
        wiggleT = 0;

        const targetYes =
            yesName || waveName || findClipNameByKeywords(Object.keys(actions), ["yes", "nod", "agree", "wave"]);

        if (!targetYes) {
            // If we can't detect a yes-like clip, just stop on current pose.
            Object.keys(actions).forEach((key) => {
                const act = actions[key];
                if (!act) return;
                act.stop();
                act.reset();
            });
            return;
        }

        playAnimation(targetYes, {
            loop: THREE.LoopOnce,
            repetitions: 1,
            clampWhenFinished: true,
        });
    }

    function sayThumbsUp() {
        if (!mixer || !modelRoot) {
            pendingThumbsUp = true;
            return;
        }

        // Pause the base pose and play a thumbs-like gesture once.
        sequenceHold = true;
        state = "wave";
        stateElapsed = 0;
        wiggleT = 0;

        const targetThumb =
            thumbsName ||
            findClipNameByKeywords(Object.keys(actions), [
                "thumb",
                "thumbs",
                "like",
                "good",
                "up",
                "ok",
            ]) ||
            yesName ||
            waveName;

        if (!targetThumb) {
            Object.keys(actions).forEach((key) => {
                const act = actions[key];
                if (!act) return;
                act.stop();
                act.reset();
            });
            return;
        }

        playAnimation(targetThumb, {
            loop: THREE.LoopOnce,
            repetitions: 1,
            clampWhenFinished: true,
        });
    }

    function sayNo() {
        if (!mixer || !modelRoot) {
            pendingSayNo = true;
            return;
        }

        sequenceHold = true;
        state = "wave";
        stateElapsed = 0;
        wiggleT = 0;

        const targetNo =
            noName ||
            angryName ||
            sadName ||
            findClipNameByKeywords(Object.keys(actions), [
                "no",
                "shake",
                "angry",
                "sad",
                "disagree",
            ]);

        if (!targetNo) {
            return;
        }

        playAnimation(targetNo, {
            loop: THREE.LoopOnce,
            repetitions: 1,
            clampWhenFinished: true,
        });
    }

    function rateExperience(rating) {
        const value = Math.max(1, Math.min(5, Number(rating) || 0));
        if (!value) return;

        if (value === 1) {
            if (deadName) {
                sequenceHold = true;
                playAnimation(deadName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
                return;
            }
            if (angryName || noName) {
                sequenceHold = true;
                playAnimation(angryName || noName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
            } else {
                sayNo();
            }
            return;
        }

        if (value === 2) {
            if (sadName || angryName || noName) {
                sequenceHold = true;
                playAnimation(sadName || angryName || noName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
            } else {
                sayNo();
            }
            return;
        }

        if (value === 3) {
            // Requested: 3-star should give thumbs up.
            sayThumbsUp();
            return;
        }

        if (value === 4) {
            if (happyName) {
                sequenceHold = true;
                playAnimation(happyName, {
                    loop: THREE.LoopOnce,
                    repetitions: 1,
                    clampWhenFinished: true,
                });
            } else {
                sayYes();
            }
            return;
        }

        if (danceName) {
            sequenceHold = true;
            playAnimation(danceName, {
                loop: THREE.LoopOnce,
                repetitions: 1,
                clampWhenFinished: true,
            });
            return;
        }

        if (coolName) {
            sequenceHold = true;
            playAnimation(coolName, {
                loop: THREE.LoopOnce,
                repetitions: 1,
                clampWhenFinished: true,
            });
        } else {
            sayYes();
        }
    }

    function resumeBehavior() {
        // Resume looping base pose for the currently active service slide.
        sequenceHold = false;
        pendingSayYes = false;
        pendingThumbsUp = false;
        pendingSayNo = false;
        stateElapsed = 0;
        wiggleT = 0;
        if (SERVICE_IDLE_WAVE_CYCLE_KEYS.has(assistantKey)) {
            idleWaveCycleTimer = 0;
        }

        if (!actions || !Object.keys(actions).length) return;

        let baseActionName = null;
        if (baseMode === "walk") {
            baseActionName = walkName || Object.keys(actions)[0];
            state = "walk";
        } else if (baseMode === "idle") {
            baseActionName = idleName || walkName || Object.keys(actions)[0];
            state = "static";
        } else if (baseMode === "sit") {
            baseActionName = sitName || idleName || walkName || Object.keys(actions)[0];
            state = "static";
        } else if (baseMode === "stand") {
            baseActionName = standName || idleName || walkName || Object.keys(actions)[0];
            state = "static";
        } else if (baseMode === "walkjump") {
            // Prefer a combined walk/jump clip if the GLB provides one; fallback to walk.
            baseActionName =
                findClipNameByKeywords(Object.keys(actions), ["walkjump", "walk_jump", "walk jump", "jumpwalk", "jump"]) ||
                walkName ||
                Object.keys(actions)[0];
            state = "walk";
        } else {
            baseActionName = walkName || Object.keys(actions)[0];
            state = "walk";
        }

        if (baseActionName) {
            playAnimation(baseActionName, {
                loop: THREE.LoopRepeat,
                repetitions: Infinity,
                clampWhenFinished: false,
            });
        }

        if (modelRoot) modelRoot.position.x = 0;
    }

    function setBaseMode(mode) {
        baseMode = mode;
        if (!mixer) return;
        // Apply immediately by resuming the base pose.
        resumeBehavior();
    }

    const loader = new THREE.GLTFLoader();
    loader.load(
        "assets/RobotExpressive.glb",
        (gltf) => {
            modelRoot = gltf.scene || (gltf.scenes && gltf.scenes[0]);
            scene.add(modelRoot);

            fitModel(modelRoot);

            const clips = Array.isArray(gltf.animations) ? gltf.animations : [];
            if (!clips.length) {
                return;
            }

            mixer = new THREE.AnimationMixer(modelRoot);

            const clipNames = clips.map((clip, i) => {
                const name =
                    clip && clip.name ? clip.name : `Animation ${i + 1}`;
                actions[name] = mixer.clipAction(clip);
                return name;
            });

            walkName = findClipNameByKeywords(clipNames, ["walk", "walking", "run"]);
            waveName = findClipNameByKeywords(clipNames, ["wave", "waving"]);
            yesName = findClipNameByKeywords(clipNames, [
                "yes",
                "nod",
                "agree",
                "affirm",
                "right",
                "left",
                "ok",
                "wave",
                "waving",
            ]);
            idleName = findClipNameByKeywords(clipNames, ["idle", "rest", "standby", "relax", "still"]);
            sitName = findClipNameByKeywords(clipNames, ["sit", "sitting", "seated", "chair"]);
            standName = findClipNameByKeywords(clipNames, ["stand", "standing", "upright", "up"]);
            thumbsName = findClipNameByKeywords(clipNames, ["thumb", "thumbs", "like", "good", "up", "ok"]);
            noName = findClipNameByKeywords(clipNames, ["no", "disagree", "headshake", "shake"]);
            angryName = findClipNameByKeywords(clipNames, ["angry", "mad", "furious"]);
            sadName = findClipNameByKeywords(clipNames, ["sad", "unhappy", "upset"]);
            happyName = findClipNameByKeywords(clipNames, ["happy", "joy", "smile", "cheer"]);
            surprisedName = findClipNameByKeywords(clipNames, ["surprise", "surprised", "wow", "shock"]);
            coolName = findClipNameByKeywords(clipNames, ["cool", "confident", "pose", "swagger"]);
            danceName = findClipNameByKeywords(clipNames, ["dance", "dancing", "groove", "party"]);
            deadName = findClipNameByKeywords(clipNames, ["dead", "death", "die", "fall", "collapse", "knockout"]);

            // Pick initial base pose based on assistantKey (banner vs services).
            let startName = walkName || clipNames[0];
            if (baseMode === "idle") startName = idleName || walkName || clipNames[0];
            if (baseMode === "sit") startName = sitName || idleName || walkName || clipNames[0];
            if (baseMode === "stand") startName = standName || idleName || walkName || clipNames[0];
            if (baseMode === "walk") startName = walkName || clipNames[0];

            stateElapsed = 0;
            wiggleT = 0;

            if (baseMode === "walk") {
                state = "walk";
            } else {
                state = "static";
            }

            playAnimation(startName, {
                loop: THREE.LoopRepeat,
                repetitions: Infinity,
                clampWhenFinished: false,
            });

            if (pendingSayYes) {
                pendingSayYes = false;
                // Kick off the "yes" immediately after load finishes.
                sayYes();
            }

            if (pendingThumbsUp) {
                pendingThumbsUp = false;
                sayThumbsUp();
            }

            if (pendingSayNo) {
                pendingSayNo = false;
                sayNo();
            }

            // When wave finishes, return to walk.
            mixer.addEventListener("finished", (event) => {
                if (state !== "wave") return;
                if (!event || !event.action) return;
                if (event.action !== currentAction) return;

                // If user is hovering, keep the "yes" pose.
                if (sequenceHold) return;

                // Return to the selected base pose for the active service slide.
                resumeBehavior();
            });
        },
        undefined,
        (err) => {
            console.error("Failed to load GLB:", err);
        }
    );

    function animate() {
        requestAnimationFrame(animate);
        const delta = clock.getDelta();
        if (mixer) {
            mixer.update(delta);
            sequenceTick(delta);
        }
        renderer.render(scene, camera);
    }

    // Hub landing pages only: "Learn More" on service cards → yes nod (AI / Web / Mobile / Software mains).
    const HUB_LEARN_MORE_SAY_YES_KEYS = new Set([
        "aiPageRobotAssistant",
        "webSolutionsPageRobotAssistant",
        "mobileApplicationsPageRobotAssistant",
        "softwareEngineeringPageRobotAssistant",
    ]);

    // AI Solutions + Web Solutions dedicated pages (corner robot): hover primary "Contact Us" CTA → yes nod.
    const CONTACT_CTA_HOVER_ASSISTANT_KEYS = new Set([
        "aiPageRobotAssistant",
        "aiAgentsPageRobotAssistant",
        "aiChatbotsPageRobotAssistant",
        "aiAutomationPageRobotAssistant",
        "aiLeadGenerationPageRobotAssistant",
        "aiContentAutomationPageRobotAssistant",
        "aiSecurityPageRobotAssistant",
        "webSolutionsPageRobotAssistant",
        "customWebsiteDevPageRobotAssistant",
        "webApplicationDevelopmentPageRobotAssistant",
        "ecommerceSolutionsPageRobotAssistant",
        "uiUxDesignPageRobotAssistant",
        "websiteMaintenancePageRobotAssistant",
        "androidAppDevPageRobotAssistant",
        "iosAppDevPageRobotAssistant",
        "crossPlatformAppsPageRobotAssistant",
        "appUiUxDesignPageRobotAssistant",
        "appMaintenancePageRobotAssistant",
        "softwareEngineeringPageRobotAssistant",
        "desktopAppDevPageRobotAssistant",
        "customBusinessSoftwarePageRobotAssistant",
        "systemAutomationToolsPageRobotAssistant",
        "apiDevelopmentPageRobotAssistant",
        "cloudSoftwarePageRobotAssistant",
    ]);

    function attachContactUsCtaHoverSayYes() {
        if (!CONTACT_CTA_HOVER_ASSISTANT_KEYS.has(assistantKey)) return;
        const label = /^\s*contact\s+us\s*$/i;
        document.querySelectorAll('a[href="contact.php"]').forEach((link) => {
            const text = (link.textContent || "").replace(/\s+/g, " ").trim();
            if (!label.test(text)) return;
            link.addEventListener("mouseenter", () => {
                sayYes();
            });
            link.addEventListener("mouseleave", () => {
                resumeBehavior();
            });
        });
    }

    function attachGetStartedHeroHoverThumbsUp() {
        if (!CONTACT_CTA_HOVER_ASSISTANT_KEYS.has(assistantKey)) return;
        const label = /^\s*get\s+started\s*$/i;
        document.querySelectorAll('a[href^="#"]').forEach((link) => {
            const text = (link.textContent || "").replace(/\s+/g, " ").trim();
            if (!label.test(text)) return;
            link.addEventListener("mouseenter", () => {
                sayThumbsUp();
            });
            link.addEventListener("mouseleave", () => {
                resumeBehavior();
            });
        });
    }

    function attachHubLearnMoreHoverSayYes() {
        if (!HUB_LEARN_MORE_SAY_YES_KEYS.has(assistantKey)) return;
        const label = /^\s*learn\s+more\s*$/i;
        document.querySelectorAll("a.ai-btn-outline:not(.ai-btn-wide)").forEach((link) => {
            const text = (link.textContent || "").replace(/\s+/g, " ").trim();
            if (!label.test(text)) return;
            link.addEventListener("mouseenter", () => {
                sayYes();
            });
            link.addEventListener("mouseleave", () => {
                resumeBehavior();
            });
        });
    }

    // Expose a tiny API for website UI events (hover Contact Us).
    // Note: `assistantKey` is window.robotAssistant by default.
    const assistant = (window[assistantKey] = window[assistantKey] || {});
    assistant.sayYes = sayYes;
    assistant.sayNo = sayNo;
    assistant.sayThumbsUp = sayThumbsUp;
    assistant.rateExperience = rateExperience;
    assistant.resumeBehavior = resumeBehavior;
    assistant.setBaseMode = setBaseMode;
    assistant.resize = resizeRenderer;

    attachContactUsCtaHoverSayYes();
    attachGetStartedHeroHoverThumbsUp();
    attachHubLearnMoreHoverSayYes();

    // --- Raycaster & Mouse Interactivity ---
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    let isHoveringRobot = false;

    function isCornerPageRobotContainer() {
        return (
            container.classList.contains("ai-page-robot") ||
            container.classList.contains("mobile-floating-bot") ||
            container.id === "global-mobile-robot"
        );
    }

    function isClickOnRobotCanvas(e) {
        if (container.classList.contains("chatbot-mode")) return false;
        const rect = renderer.domElement.getBoundingClientRect();
        if (rect.width < 4 || rect.height < 4) return false;
        return (
            e.clientX >= rect.left &&
            e.clientX <= rect.right &&
            e.clientY >= rect.top &&
            e.clientY <= rect.bottom
        );
    }

    function dispatchRobotClicked(e) {
        e.stopPropagation();
        window.dispatchEvent(
            new CustomEvent("robot-clicked", {
                detail: { containerId: containerId },
            })
        );
    }

    document.addEventListener("click", (e) => {
        if (!isClickOnRobotCanvas(e)) return;

        let openChat = false;

        if (modelRoot) {
            const rect = renderer.domElement.getBoundingClientRect();
            mouse.x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
            mouse.y = -((e.clientY - rect.top) / rect.height) * 2 + 1;
            raycaster.setFromCamera(mouse, camera);
            const intersects = raycaster.intersectObject(modelRoot, true);
            if (intersects.length > 0) {
                openChat = true;
            }
        }

        if (!openChat && isCornerPageRobotContainer()) {
            openChat = true;
        }

        if (openChat) {
            dispatchRobotClicked(e);
        }
    });

    document.addEventListener("mousemove", (e) => {
        if (container.classList.contains("chatbot-mode")) {
            if (isHoveringRobot) {
                document.body.style.cursor = "";
                isHoveringRobot = false;
            }
            return;
        }

        const rect = renderer.domElement.getBoundingClientRect();
        const overCanvas =
            rect.width >= 4 &&
            rect.height >= 4 &&
            e.clientX >= rect.left &&
            e.clientX <= rect.right &&
            e.clientY >= rect.top &&
            e.clientY <= rect.bottom;

        let showPointer = false;

        if (overCanvas) {
            if (modelRoot) {
                mouse.x = ((e.clientX - rect.left) / rect.width) * 2 - 1;
                mouse.y = -((e.clientY - rect.top) / rect.height) * 2 + 1;
                raycaster.setFromCamera(mouse, camera);
                const intersects = raycaster.intersectObject(modelRoot, true);
                showPointer = intersects.length > 0;
            }
            if (!showPointer && isCornerPageRobotContainer()) {
                showPointer = true;
            }
        }

        if (showPointer && !isHoveringRobot) {
            document.body.style.cursor = "pointer";
            isHoveringRobot = true;
        } else if (!showPointer && isHoveringRobot) {
            document.body.style.cursor = "";
            isHoveringRobot = false;
        }
    });

    animate();

    setTimeout(() => {
        window.dispatchEvent(new CustomEvent(readyEvent, { bubbles: true }));
        window.dispatchEvent(
            new CustomEvent("infersio-robot-mounted", {
                bubbles: true,
                detail: { containerId: containerId },
            })
        );
    }, 0);
})();

