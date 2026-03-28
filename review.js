document.addEventListener("DOMContentLoaded", () => {
    const starWrap = document.getElementById("starRating");
    const ratingText = document.getElementById("ratingText");
    const reviewComment = document.getElementById("reviewComment");
    const reviewSubmitBtn = document.getElementById("reviewSubmitBtn");
    if (!starWrap || !ratingText) return;

    const stars = Array.from(starWrap.querySelectorAll(".star-btn"));
    let selected = 0;

    const labels = {
        1: "1 Star selected.",
        2: "2 Stars selected.",
        3: "3 Stars selected.",
        4: "4 Stars selected.",
        5: "5 Stars selected.",
    };

    function paintStars(value) {
        stars.forEach((s) => {
            const n = Number(s.getAttribute("data-rating") || "0");
            s.classList.toggle("active", n <= value);
        });
    }

    function react(value) {
        const assistant = window.reviewRobotAssistant;
        if (!assistant || typeof assistant.rateExperience !== "function") return;
        assistant.rateExperience(value);
    }

    stars.forEach((btn) => {
        btn.addEventListener("mouseenter", () => {
            const value = Number(btn.getAttribute("data-rating") || "0");
            paintStars(value);
            ratingText.textContent = labels[value] || "Select a star rating";
            react(value);
        });

        btn.addEventListener("click", () => {
            selected = Number(btn.getAttribute("data-rating") || "0");
            paintStars(selected);
            ratingText.textContent = labels[selected] || "Select a star rating";
            react(selected);
        });
    });

    starWrap.addEventListener("mouseleave", () => {
        paintStars(selected);
        ratingText.textContent = selected ? (labels[selected] || "Thanks for your review.") : "Select a star rating";
        const assistant = window.reviewRobotAssistant;
        if (assistant && typeof assistant.resumeBehavior === "function") {
            assistant.resumeBehavior();
        }
    });

    if (reviewSubmitBtn) {
        reviewSubmitBtn.addEventListener("click", () => {
            const text = reviewComment ? String(reviewComment.value || "").trim() : "";
            if (!selected) {
                ratingText.textContent = "Please select a star rating first.";
                return;
            }
            if (!text) {
                ratingText.textContent = "Please add a comment before submitting.";
                return;
            }
            ratingText.textContent = "Thank you! Your review has been captured.";
            if (reviewComment) reviewComment.value = "";
        });
    }

    window.addEventListener(
        "review-robot-ready",
        () => {
            const assistant = window.reviewRobotAssistant;
            if (!assistant) return;
            if (typeof assistant.setBaseMode === "function") assistant.setBaseMode("idle");
            if (typeof assistant.resumeBehavior === "function") assistant.resumeBehavior();
        },
        { passive: true }
    );
});
