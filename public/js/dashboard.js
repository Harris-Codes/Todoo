document.addEventListener("DOMContentLoaded", function () {
    const grid = document.getElementById("badgeGrid");
    const badges = grid.querySelectorAll(".badge");
    const badgesPerSlide = 6;
    const totalSlides = Math.ceil(badges.length / badgesPerSlide);
    let currentSlide = 0;

    function updateBadgeCarousel() {
        const offset = currentSlide * -100;
        grid.style.transform = `translateX(${offset}%)`;
    }

    function openEditModal() {
        document.getElementById("editProfileModal").classList.add("active");
    }
    function closeEditModal() {
        document.getElementById("editProfileModal").classList.remove("active");
    }

    window.prevBadgeSlide = function () {
        if (currentSlide > 0) {
            currentSlide--;
            updateBadgeCarousel();
        }
    };

    window.nextBadgeSlide = function () {
        if ((currentSlide + 1) * badgesPerSlide < badges.length) {
            currentSlide++;
            updateBadgeCarousel();
        }
    };

    updateBadgeCarousel();
});

document.addEventListener("DOMContentLoaded", function () {
    let currentClassIndex = 0;
    const slides = document.querySelectorAll(".class-slide");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? "flex" : "none"; // or block depending on your layout
        });
    }

    window.prevCard = function () {
        currentClassIndex =
            (currentClassIndex - 1 + slides.length) % slides.length;
        showSlide(currentClassIndex);
    };

    window.nextCard = function () {
        currentClassIndex = (currentClassIndex + 1) % slides.length;
        showSlide(currentClassIndex);
    };

    // Init
    showSlide(currentClassIndex);
});
