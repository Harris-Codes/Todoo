document.addEventListener("DOMContentLoaded", function () {
    // Sidebar toggle logic
    const sidebar = document.querySelector("nav.sidebar");
    const toggleBtn = document.querySelector(".toggle");

    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    }

    
});

document.getElementById("publishBtn").addEventListener("click", function () {
    // Example: after successful publishing logic (AJAX or just frontend change)
    this.innerHTML = "<i class='bx bx-check'></i> Published";
    this.classList.remove("publish-btn");
    this.classList.add("published-btn");
    this.disabled = true; // Optional: prevent re-click
  });
  