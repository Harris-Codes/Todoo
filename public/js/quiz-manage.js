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
