(function () {
    const header = document.querySelector(".site-header");
    function syncHeader() {
        if (!header) return;
        header.classList.toggle("is-scrolled", window.scrollY > 16);
    }
    window.addEventListener("scroll", syncHeader, { passive: true });
    window.addEventListener("load", syncHeader);
    syncHeader();
})();

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

    const contactUsLinks = document.querySelectorAll('a.cta-btn[href="contact.php"]');
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

// --- Global Chatbot UI Injection & Logic ---
document.addEventListener("DOMContentLoaded", () => {
    const chatHtml = `
        <div id="chat-backdrop" class="chat-backdrop hidden" aria-hidden="true"></div>
        <div id="global-chat-panel" class="chat-panel hidden" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="chat-dialog-title">
            <div class="chat-header chat-header--brand">
                <div class="chat-header-text">
                    <h3 id="chat-dialog-title">Welcome to our support chat!</h3>
                    <p class="chat-header-status"><span class="chat-status-dot" aria-hidden="true"></span> AI Assistance</p>
                </div>
                <button type="button" id="close-chat" class="chat-close-btn" aria-label="Close chat">&times;</button>
            </div>
            <div class="chat-screen chat-screen--welcome" id="chat-welcome-screen">
                <div class="chat-welcome-body">
                    <div class="chat-welcome-logo" aria-hidden="true">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 8c-8 0-14 6-14 14v4c0 2 1 4 3 5l-2 14h26l-2-14c2-1 3-3 3-5v-4c0-8-6-14-14-14z" fill="url(#chatLogoGrad)"/>
                            <circle cx="24" cy="24" r="3" fill="#fff" opacity="0.9"/>
                            <circle cx="40" cy="24" r="3" fill="#fff" opacity="0.9"/>
                            <defs>
                                <linearGradient id="chatLogoGrad" x1="12" y1="8" x2="52" y2="48" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#60a5fa"/>
                                    <stop offset="1" stop-color="#a78bfa"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <h4 class="chat-welcome-title">Welcome! 👋</h4>
                    <p class="chat-welcome-desc">I'm here to help you with any questions you might have. Let's get started!</p>
                    <button type="button" id="chat-start-btn" class="chat-start-btn">Start Conversation</button>
                </div>
            </div>
            <div class="chat-screen chat-screen--conversation" id="chat-conversation-screen" hidden>
                <div class="chat-body" id="chat-body">
                    <div class="chat-message bot">Hi there! I'm your AI assistant. How can I help you today?</div>
                </div>
                <div class="chat-footer">
                    <input type="text" id="chat-input" placeholder="Type a message..." aria-label="Type your message" />
                    <button type="button" id="send-chat">Send</button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML("beforeend", chatHtml);

    const chatBackdrop = document.getElementById("chat-backdrop");
    const chatPanel = document.getElementById("global-chat-panel");
    const closeBtn = document.getElementById("close-chat");
    const chatTitle = document.getElementById("chat-dialog-title");
    const welcomeScreen = document.getElementById("chat-welcome-screen");
    const conversationScreen = document.getElementById("chat-conversation-screen");
    const startBtn = document.getElementById("chat-start-btn");
    const chatInput = document.getElementById("chat-input");
    const sendBtn = document.getElementById("send-chat");
    const chatBody = document.getElementById("chat-body");
    let activeRobotContainerId = null;
    let chatReturnFocusEl = null;

    const originalPositions = new Map();

    function releaseChatFocus() {
        const active = document.activeElement;
        if (!active || !chatPanel.contains(active)) return;

        const returnEl = chatReturnFocusEl;
        chatReturnFocusEl = null;

        if (
            returnEl &&
            returnEl !== document.body &&
            document.contains(returnEl) &&
            typeof returnEl.focus === "function"
        ) {
            try {
                returnEl.focus({ preventScroll: true });
                return;
            } catch (_) {
                /* focus not allowed on this element */
            }
        }
        active.blur();
    }

    function isMobileChat() {
        return window.innerWidth <= 980;
    }

    function showWelcomeScreen() {
        chatPanel.classList.remove("chat-panel--conversation-active");
        welcomeScreen.hidden = false;
        conversationScreen.hidden = true;
        if (chatTitle) {
            chatTitle.textContent = "Welcome to our support chat!";
        }
    }

    function showConversationScreen() {
        chatPanel.classList.add("chat-panel--conversation-active");
        welcomeScreen.hidden = true;
        conversationScreen.hidden = false;
        if (chatTitle) {
            chatTitle.textContent = "Chat with InfersioAI";
        }
        if (chatInput) {
            setTimeout(() => chatInput.focus(), 120);
        }
    }

    function openChatPanel() {
        if (chatPanel.classList.contains("hidden")) {
            const active = document.activeElement;
            if (active && !chatPanel.contains(active)) {
                chatReturnFocusEl = active;
            }
        }

        if (isMobileChat()) {
            showWelcomeScreen();
            chatBackdrop.classList.remove("hidden");
            chatBackdrop.setAttribute("aria-hidden", "false");
            document.body.classList.add("chat-modal-open");
        } else {
            showConversationScreen();
        }
        chatPanel.classList.remove("hidden");
        chatPanel.setAttribute("aria-hidden", "false");
    }

    function closeChatPanel() {
        releaseChatFocus();

        if (activeRobotContainerId) {
            const container = document.getElementById(activeRobotContainerId);
            if (container) {
                const isAiPageRobotDesktop = container.classList.contains("ai-page-robot") && window.innerWidth > 980;
                if (!isAiPageRobotDesktop && !isMobileChat()) {
                    animateBotTransition(container, false);
                }
                if (isMobileChat()) {
                    container.classList.remove("chatbot-mode");
                }
            }
            activeRobotContainerId = null;
        }
        chatPanel.classList.add("hidden");
        chatPanel.setAttribute("aria-hidden", "true");
        chatBackdrop.classList.add("hidden");
        chatBackdrop.setAttribute("aria-hidden", "true");
        document.body.classList.remove("chat-modal-open");
    }

    function animateBotTransition(container, toChatbotMode) {
        container.style.animation = "none";

        const firstRect = container.getBoundingClientRect();

        if (toChatbotMode) {
            originalPositions.set(container, {
                parent: container.parentNode,
                nextSibling: container.nextSibling,
            });
            document.body.appendChild(container);
            container.classList.add("chatbot-mode");
        } else {
            container.classList.remove("chatbot-mode");
            if (originalPositions.has(container)) {
                const pos = originalPositions.get(container);
                if (pos.parent) {
                    if (pos.nextSibling && pos.parent.contains(pos.nextSibling)) {
                        pos.parent.insertBefore(container, pos.nextSibling);
                    } else {
                        pos.parent.appendChild(container);
                    }
                }
            }
        }

        const lastRect = container.getBoundingClientRect();
        const deltaX = firstRect.left - lastRect.left;
        const deltaY = firstRect.top - lastRect.top;
        const scaleX = firstRect.width / lastRect.width;
        const scaleY = firstRect.height / lastRect.height;

        container.style.transition = "none";
        container.style.transformOrigin = "top left";
        container.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(${scaleX}, ${scaleY})`;
        container.getBoundingClientRect();

        container.style.transition = "transform 0.85s cubic-bezier(0.16, 1, 0.3, 1)";
        container.style.transform = "translate(0, 0) scale(1, 1)";

        container.addEventListener("transitionend", function cleanup(e) {
            if (e.target === container && e.propertyName === "transform") {
                container.style.transition = "";
                container.style.transform = "";
                container.style.transformOrigin = "";
                container.style.animation = "";
                container.removeEventListener("transitionend", cleanup);
            }
        });
    }

    window.addEventListener("robot-clicked", (e) => {
        const containerId = e.detail && e.detail.containerId;
        if (!containerId) return;

        const container = document.getElementById(containerId);
        if (!container) return;

        if (activeRobotContainerId === containerId) {
            if (chatPanel.classList.contains("hidden")) {
                openChatPanel();
            }
            return;
        }

        if (activeRobotContainerId && activeRobotContainerId !== containerId) {
            const oldContainer = document.getElementById(activeRobotContainerId);
            if (oldContainer) {
                const wasAiPageRobotDesktop = oldContainer.classList.contains("ai-page-robot") && window.innerWidth > 980;
                if (!wasAiPageRobotDesktop && !isMobileChat()) {
                    animateBotTransition(oldContainer, false);
                }
            }
        }

        activeRobotContainerId = containerId;

        const isAiPageRobotDesktop = container.classList.contains("ai-page-robot") && window.innerWidth > 980;
        const mobile = isMobileChat();

        if (!isAiPageRobotDesktop && !mobile) {
            chatPanel.classList.remove("chat-panel-inner");
            animateBotTransition(container, true);
            setTimeout(openChatPanel, 150);
        } else if (isAiPageRobotDesktop) {
            chatPanel.classList.add("chat-panel-inner");
            openChatPanel();
        } else {
            chatPanel.classList.remove("chat-panel-inner");
            openChatPanel();
        }
    });

    closeBtn.addEventListener("click", closeChatPanel);

    if (startBtn) {
        startBtn.addEventListener("click", showConversationScreen);
    }

    if (chatBackdrop) {
        chatBackdrop.addEventListener("click", closeChatPanel);
    }

    document.addEventListener("click", (e) => {
        if (chatPanel.classList.contains("hidden")) return;
        if (chatPanel.contains(e.target)) return;
        if (chatBackdrop && chatBackdrop.contains(e.target)) return;

        if (
            e.target.closest(
                ".ai-page-robot, .mobile-floating-bot, #global-mobile-robot, #robot-container, .robot-container, #service-robot-container, .chatbot-mode"
            )
        ) {
            return;
        }

        if (activeRobotContainerId) {
            const container = document.getElementById(activeRobotContainerId);
            if (container && container.contains(e.target)) return;
        }

        closeChatPanel();
    });

    function appendBotReply(text) {
        if (!chatBody) return;
        const el = document.createElement("div");
        el.className = "chat-message bot";
        el.textContent = text;
        chatBody.appendChild(el);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function sendUserMessage() {
        if (!chatInput || !chatInput.value.trim()) return;
        const userEl = document.createElement("div");
        userEl.className = "chat-message user";
        userEl.textContent = chatInput.value.trim();
        chatBody.appendChild(userEl);
        chatInput.value = "";
        chatBody.scrollTop = chatBody.scrollHeight;
        setTimeout(() => {
            appendBotReply("Thanks for your message! Our team will follow up shortly. For urgent requests, email sales@infersioai.com.");
        }, 600);
    }

    if (sendBtn) {
        sendBtn.addEventListener("click", sendUserMessage);
    }
    if (chatInput) {
        chatInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                sendUserMessage();
            }
        });
    }

    function initMobileFloatingBot() {
        document.querySelectorAll(".mobile-floating-bot").forEach((el) => {
            el.classList.remove("mobile-floating-bot");
        });

        if (window.innerWidth <= 980) {
            const primary =
                document.getElementById("robot-container") ||
                document.querySelector(".ai-page-robot");
            if (primary) {
                primary.classList.add("mobile-floating-bot");
            } else if (!document.getElementById("global-mobile-robot")) {
                const globalBotHtml = `<div id="global-mobile-robot" class="mobile-floating-bot" aria-hidden="true"></div>`;
                document.body.insertAdjacentHTML("beforeend", globalBotHtml);

                if (typeof window.THREE === "undefined") {
                    const threeScript = document.createElement("script");
                    threeScript.src = "https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js";
                    threeScript.onload = () => {
                        const gltfScript = document.createElement("script");
                        gltfScript.src = "https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js";
                        gltfScript.onload = () => {
                            window.ROBOT_CONTAINER_ID = "global-mobile-robot";
                            const robotScript = document.createElement("script");
                            robotScript.src = "robot-viewer.js";
                            document.body.appendChild(robotScript);
                        };
                        document.body.appendChild(gltfScript);
                    };
                    document.body.appendChild(threeScript);
                } else {
                    window.ROBOT_CONTAINER_ID = "global-mobile-robot";
                    const robotScript = document.createElement("script");
                    robotScript.src = "robot-viewer.js";
                    document.body.appendChild(robotScript);
                }
            }
        } else {
            const floating = document.querySelector(".mobile-floating-bot");
            if (floating) {
                floating.classList.remove("mobile-floating-bot");
            }
        }
    }
    initMobileFloatingBot();
    window.addEventListener("resize", initMobileFloatingBot);
    window.addEventListener("infersio-robot-mounted", initMobileFloatingBot);
    window.addEventListener("load", initMobileFloatingBot);
});

