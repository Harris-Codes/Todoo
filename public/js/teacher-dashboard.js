document.addEventListener("DOMContentLoaded", function () {
    const slideTrack = document.getElementById("teacherClassCarousel");
    const slides = slideTrack.querySelectorAll(".class-slide");
    const slideWidth = slides[0]?.offsetWidth || 300; // fallback if empty
    const gap = 40; // match your CSS gap
    let currentIndex = 0;

    window.nextCard = function () {
        if ((currentIndex + 1) * (slideWidth + gap) < slideTrack.scrollWidth) {
            currentIndex++;
            updateCarousel();
        }
    };

    window.prevCard = function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    };

    function updateCarousel() {
        const offset = -(currentIndex * (slideWidth + gap));
        slideTrack.style.transform = `translateX(${offset}px)`;
    }

    // Reset carousel on load
    updateCarousel();
});
