const body = document.querySelector('body'),
  sidebar = body.querySelector('nav'),
  toggle = body.querySelector(".toggle"),
  searchBtn = body.querySelector(".search-box"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");

// ====================== SIDEBAR TOGGLE ======================
toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

// ====================== CONFIRM LOGOUT ======================
function confirmLogout(event) {
  event.preventDefault();
  if (confirm('Are you sure you want to log out?')) {
    window.location.href = "{{url('login')}}";
  }
}

// ====================== ASSIGNMENT MODAL ======================
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("assignmentModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalDescription = document.getElementById("modalDescription");
  const closeBtn = document.querySelector(".close-btn");

  if (modal) {
    modal.style.display = "none";

    document.querySelectorAll(".clickable-row").forEach(row => {
      row.addEventListener("click", function () {
        modalTitle.innerText = this.dataset.title;
        modalDescription.innerText = this.dataset.desc;
        modal.style.display = "flex";
      });
    });

    closeBtn.addEventListener("click", function () {
      modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  }
});

// ====================== FILE UPLOAD BUTTON ======================
document.getElementById("uploadButton")?.addEventListener("click", function () {
  document.getElementById("fileInput").click();
});

document.getElementById("fileInput")?.addEventListener("change", function () {
  const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
  document.getElementById("fileNameDisplay").innerText = fileName;
});

// ====================== TABS SWITCHING ======================
function openTab(event, tabName) {
  document.querySelectorAll(".tab-content").forEach(tab => {
    tab.classList.remove("active");
  });

  document.querySelectorAll(".tab-link").forEach(button => {
    button.classList.remove("active");
  });

  document.getElementById(tabName).classList.add("active");
  event.currentTarget.classList.add("active");
}

// ================ REPLY TOGGLE ========================
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.reply-section').forEach(section => {
    const replyBtn = section.querySelector('.reply-btn');
    const replyInputContainer = section.querySelector('.reply-input-container');
    
    if (replyBtn && replyInputContainer) {
      replyBtn.addEventListener('click', function () {
        replyBtn.style.display = 'none';
        replyInputContainer.style.display = 'flex';
        const input = replyInputContainer.querySelector('.reply-input');
        if (input) input.focus();
      });
    }
  });
});

// ================ CLOSE REPLY TOGGLE ========================
document.addEventListener('click', function (event) {
  document.querySelectorAll('.reply-section').forEach(section => {
    const replyBtn = section.querySelector('.reply-btn');
    const replyInputContainer = section.querySelector('.reply-input-container');

    if (replyInputContainer && replyInputContainer.style.display === 'flex') {
      // If the click was outside the section
      if (!section.contains(event.target)) {
        replyInputContainer.style.display = 'none';
        replyBtn.style.display = 'flex';
      }
    }
  });
});


