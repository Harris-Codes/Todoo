const body = document.querySelector('body'),
  sidebar = body.querySelector('nav'),
  toggle = body.querySelector(".toggle"),
  searchBtn = body.querySelector(".search-box"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");

// ====================== SIDEBAR TOGGLE ======================
toggle?.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

// ====================== CONFIRM LOGOUT ======================
function confirmLogout(event) {
  event.preventDefault();
  if (confirm('Are you sure you want to log out?')) {
    window.location.href = "{{url('login')}}";
  }
}

// ====================== DOM READY ======================
document.addEventListener("DOMContentLoaded", function () {

  // ====================== ASSIGNMENT MODAL ======================
  const modal = document.getElementById("assignmentModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalDescription = document.getElementById("modalDescription");
  const modalAssignmentId = document.getElementById("modalAssignmentId");
  const fileInput = document.getElementById("fileInput");
  const fileNameDisplay = document.getElementById("fileNameDisplay");
  const closeBtn = document.querySelector(".close-btn");
  const badgeModal = document.getElementById("badgeModal");
  const badgeSound = document.getElementById("badgeSound");



  const assignmentTableBody = document.querySelector(".assignment-table tbody");
    if (assignmentTableBody) {
        const rows = assignmentTableBody.querySelectorAll("tr");
        if (rows.length > 4) {
            assignmentTableBody.parentElement.classList.add("scrollable-assignment");
        }
    }

  if (badgeModal && badgeSound) {

    setTimeout(() => {
      badgeSound.play().catch(err => {
        console.warn("Autoplay blocked or error playing sound:", err);
      });
    }, 100); 
  }

  
  if (modal) {
    modal.style.display = "none";

    document.querySelectorAll(".clickable-row").forEach(row => {
      row.addEventListener("click", function () {
        modalTitle.innerText = this.dataset.title;
        modalDescription.innerText = this.dataset.desc;
        modalAssignmentId.value = this.dataset.id;
        modal.style.display = "flex";
        modal.style.visibility = "visible";
    
        if (fileInput) fileInput.value = '';
        if (fileNameDisplay) fileNameDisplay.innerText = "No file chosen";
    
        const grade = this.dataset.grade;
        const submissionWrapper = document.getElementById("submissionWrapper");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
        const attachment = this.dataset.attachment ?? '';
        let attachmentHTML = '';

        if (attachment) {
            attachmentHTML = `
                <div class="attachment-section" style="margin-bottom:15px;">
                    <a href="/storage/${attachment}" target="_blank" class="view-file-button" style="
                        display: inline-block;
                        background-color: var(--graded);
                        color: white;
                        padding: 8px 16px;
                        border-radius: 8px;
                        text-decoration: none;
                        font-weight: bold;
                    ">
                        <i class="fa fa-file"></i> View Attached File
                    </a>
                </div>
            `;
        }

        if (!grade) {
          submissionWrapper.innerHTML = `
          ${attachmentHTML}
          <form action="/submit-assignment" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="${csrfToken}">
              <input type="hidden" name="assignment_id" value="${this.dataset.id}">
      
              <div class="upload-section">
                  <div class="file-upload-container">
                      <input type="file" id="fileInput" name="submission_file" style="display: none;" required>
                      <button type="button" id="uploadButton">
                          <i class="fa fa-upload"></i> ADD FILE
                      </button>
                      <p id="fileNameDisplay" class="file-name">No file chosen</p>
                  </div>
              </div>
      
              <div class="submit-btn-container">
                  <button type="submit" class="submit-btn">Submit Assignment</button>
              </div>
          </form>
      `;
      
        
          // rebind file triggers
          document.getElementById("uploadButton")?.addEventListener("click", function () {
            document.getElementById("fileInput").click();
          });
        
          document.getElementById("fileInput")?.addEventListener("change", function () {
            const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
            document.getElementById("fileNameDisplay").innerText = fileName;
          });
        
        } else {
          submissionWrapper.innerHTML = `
            <div class="graded-card">
              <div class="grade-circle">C</div>
              <div class="graded-info">
                  <h3>Assignment Graded</h3>
                  <p>You have received a grade of <strong>C</strong> for this assignment.</p>
                  <p class="resubmit-note">Resubmission is not allowed.</p>
              </div>
          </div>
          `;
        }
        
      });
    });
    
    
    

    closeBtn?.addEventListener("click", function () {
      modal.style.display = "none";
      modal.style.visibility = "hidden";
    });

    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
        modal.style.visibility = "hidden";
      }
    });
  }

  // ====================== FILE UPLOAD DISPLAY ======================
  document.getElementById("uploadButton")?.addEventListener("click", function () {
    document.getElementById("fileInput").click();
  });

  document.getElementById("fileInput")?.addEventListener("change", function () {
    const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
    document.getElementById("fileNameDisplay").innerText = fileName;
  });

  // ====================== TABS SWITCHING ======================
  window.openTab = function (event, tabName) {
    document.querySelectorAll(".tab-content").forEach(tab => {
      tab.classList.remove("active");
    });

    document.querySelectorAll(".tab-link").forEach(button => {
      button.classList.remove("active");
    });

    document.getElementById(tabName).classList.add("active");
    event.currentTarget.classList.add("active");
  };

  // ====================== REPLY TOGGLE ======================
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

  // ====================== CLOSE REPLY IF CLICK OUTSIDE ======================
  document.addEventListener('click', function (event) {
    document.querySelectorAll('.reply-section').forEach(section => {
      const replyBtn = section.querySelector('.reply-btn');
      const replyInputContainer = section.querySelector('.reply-input-container');

      if (replyInputContainer && replyInputContainer.style.display === 'flex') {
        if (!section.contains(event.target)) {
          replyInputContainer.style.display = 'none';
          replyBtn.style.display = 'flex';
        }
      }
    });
  });

  // ====================== STUDENT FILE VIEW ======================
  const fileTableBody = document.getElementById("fileTableBody");
  const folderTitle = document.getElementById("folderTitle");
  const backToMainTable = document.getElementById("backToMainTable");
  const classroomId = document.getElementById("classroomMeta")?.dataset.classroomId;

  let currentFolderId = null;
  let currentFolderName = null;

  function showMainFileTable() {
    currentFolderId = null;
    currentFolderName = null;
    folderTitle.innerText = "Files";
    backToMainTable.style.display = "none";
    fileTableBody.innerHTML = "<tr><td colspan='4'>Loading...</td></tr>";
  
    let folders = [];
  
    fetch(`/classroom/${classroomId}/folders/list`)
      .then(res => res.json())
      .then(data => {
        folders = data;
  
        fetch(`/classroom/${classroomId}/files/root`)
          .then(res => res.json())
          .then(files => {
            fileTableBody.innerHTML = "";
  
            if (folders.length === 0 && files.length === 0) {
              fileTableBody.innerHTML = "<tr><td colspan='4'>No folders or files found.</td></tr>";
              return;
            }
  
            // Render folders as clickable rows
            folders.forEach(folder => {
              const row = document.createElement("tr");
              row.classList.add("clickable-folder-row");
              row.dataset.id = folder.id;
              row.dataset.name = folder.name;
              row.innerHTML = `
                <td colspan="4"><i class='bx bx-folder'></i> ${folder.name}</td>
              `;
              fileTableBody.appendChild(row);
            });
  
     
            document.querySelectorAll('.clickable-folder-row').forEach(row => {
              row.addEventListener('click', function () {
                const folderId = this.dataset.id;
                const folderName = this.dataset.name;
                viewFolder(folderId, folderName);
              });
            });
  
            // Render files
            files.forEach(file => {
              const row = document.createElement("tr");
              row.classList.add("clickable-file-row");
              row.dataset.filePath = file.file_path;
            
              row.innerHTML = `
                <td><i class='bx bx-file'></i> ${file.file_name}</td>
                <td>${file.modified_at}</td>
                <td>${file.modified_by}</td>
              `;
            
              // Make entire row clickable
              row.addEventListener("click", function () {
                const filePath = this.dataset.filePath;
                window.open(`/storage/${filePath}`, '_blank');
              });
            
              fileTableBody.appendChild(row);
            });
            
          });
      });
  }
  

  function viewFolder(folderId, folderName) {
    currentFolderId = folderId;
    currentFolderName = folderName;
    folderTitle.innerText = `📂 ${folderName}`;
    backToMainTable.style.display = "inline-block";
    fileTableBody.innerHTML = "<tr><td colspan='4'>Loading...</td></tr>";
  
    fetch(`/classroom/${classroomId}/folders/${folderId}/files`)
      .then(res => res.json())
      .then(files => {
        fileTableBody.innerHTML = "";
  
        if (files.length === 0) {
          fileTableBody.innerHTML = "<tr><td colspan='4'>No files in this folder.</td></tr>";
          return;
        }
  
        files.forEach(file => {
          const row = document.createElement("tr");
          row.classList.add("clickable-file-row");
          row.dataset.filePath = file.file_path;
  
          row.innerHTML = `
            <td><i class='bx bx-file'></i> ${file.file_name}</td>
            <td>${file.modified_at}</td>
            <td>${file.modified_by}</td>
          `;
  
          row.addEventListener("click", function () {
            window.open(`/storage/${file.file_path}`, '_blank');
          });
  
          fileTableBody.appendChild(row);
        });
      });
  }
  
  

  // Expose for global use
  window.showMainFileTable = showMainFileTable;
  window.viewFolder = viewFolder;

  showMainFileTable();

  // ====================== LEADERBOARD MODAL ======================
  function openLeaderboardModal(quizId) {
    fetch(`/quiz/${quizId}/leaderboard`)
      .then(res => res.json())
      .then(data => {
        const avatars = { 0: 'first', 1: 'second', 2: 'third' };

        for (let i = 0; i < 3; i++) {
          const user = data[i];
          if (user) {
            document.getElementById(`${avatars[i]}-name`).innerText = user.user.name;
            document.getElementById(`${avatars[i]}-score`).innerText = `${user.score} pts`;
            document.getElementById(`${avatars[i]}-avatar`).src = `/storage/${user.user.profile_picture}`;
          }
        }

        const list = document.getElementById("leaderboard-list");
        list.innerHTML = "";
        data.slice(3).forEach((entry, index) => {
          const row = document.createElement("div");
          row.className = "leaderboard-entry";
          row.innerHTML = `<span>${index + 4}. ${entry.user.name}</span><span>${entry.score} pts</span>`;
          list.appendChild(row);
        });

        const modal = document.getElementById("leaderboardModal");
        modal.classList.add("show");

      });
  }

  function closeLeaderboardModal() {
    const modal = document.getElementById("leaderboardModal");
    modal.classList.remove("show");
    
  }
  window.closeLeaderboardModal = closeLeaderboardModal;



  document.querySelectorAll(".clickable-result-row").forEach(btn => {
    btn.addEventListener("click", function () {
      const quizId = this.dataset.quizId;
      openLeaderboardModal(quizId);
    });
  });

  // ====================== BADGE INFO MODAL ======================
document.querySelectorAll('.clickable-badge-row').forEach(row => {
  row.addEventListener('click', () => {
      document.getElementById('badgeInfoImage').src = row.dataset.image;
      document.getElementById('badgeInfoName').textContent = row.dataset.name;

      const type = row.dataset.type;
      const value = row.dataset.condition;
      let conditionText = '';

      if (type === 'submission_count') {
          conditionText = `Submit ${value} assignments to earn this badge.`;
      } else if (type === 'perfect_quiz') {
          conditionText = `Achieve ${value} perfect quiz scores to earn this badge.`;
      } else if (type === 'quiz_count') {
          conditionText = `Attempt ${value} quizzes to earn this badge.`;
      } else {
          conditionText = 'Earn this badge by completing the required condition.';
      }

      document.getElementById('badgeInfoCondition').textContent = conditionText;

      document.getElementById('badgeInfoModal').style.display = 'flex';
  });
});

window.closeBadgeInfoModal = function () {
  document.getElementById('badgeInfoModal').style.display = 'none';
}


});
