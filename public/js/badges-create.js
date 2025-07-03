document.addEventListener("DOMContentLoaded", function () {
    // === Sidebar toggle logic ===
    const sidebar = document.querySelector("nav.sidebar");
    const toggleBtn = document.querySelector(".toggle");

    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    }

    // Initial render of badge images
    renderBadgePage();
});

let currentBadgePage = 0;
const badgesPerPage = 3;
const totalBadges = 9;

// === Render carousel images ===
function renderBadgePage() {
    const container = document.getElementById("badgeImagePageContainer");
    container.innerHTML = "";

    const start = currentBadgePage * badgesPerPage;
    const end = Math.min(start + badgesPerPage, totalBadges);

    for (let i = start + 1; i <= end; i++) {
        const imageName = `badge-${i}.png`;

        const label = document.createElement("label");
        label.classList.add("badge-option");
        label.innerHTML = `
            <input type="radio" name="badgeImage" value="${imageName}" onchange="selectBadgeImage('${imageName}')">

            <img src="/images/${imageName}" alt="Badge ${i}">
        `;
        container.appendChild(label);
    }

    document.getElementById("badgeImagePageIndicator").innerText =
        currentBadgePage + 1;

    // Optional: auto-select the first badge of the page
    const firstRadio = container.querySelector('input[type="radio"]');
    if (firstRadio) {
        firstRadio.checked = true;
        selectBadgeImage(firstRadio.value);
    }
}

// === Navigate carousel left/right ===
function changeBadgeImagePage(direction) {
    const maxPages = Math.ceil(totalBadges / badgesPerPage);
    currentBadgePage += direction;

    if (currentBadgePage < 0) currentBadgePage = 0;
    if (currentBadgePage >= maxPages) currentBadgePage = maxPages - 1;

    renderBadgePage();
}

function selectBadgeImage(imageName) {
    const hiddenInput = document.getElementById("selectedBadgeImage");
    if (hiddenInput) {
        hiddenInput.value = imageName;
        console.log("Selected badge image set to:", imageName);
    }
}

// === Switch to Step 2 ===
function goToBadgeStep2() {
    document.querySelector(".step-1").style.display = "none";
    document.querySelector(".step-2").style.display = "flex";
}

function goToBadgeStep1() {
    document.querySelector(".step-2").style.display = "none";
    document.querySelector(".step-1").style.display = "flex";
}
