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

  if (modal) {
    modal.style.display = "none";

    document.querySelectorAll(".clickable-row").forEach(row => {
      row.addEventListener("click", function () {
        modalTitle.innerText = this.dataset.title;
        modalDescription.innerText = this.dataset.desc;
        modalAssignmentId.value = this.dataset.id;
        modal.style.display = "flex";
    
        if (fileInput) fileInput.value = '';
        if (fileNameDisplay) fileNameDisplay.innerText = "No file chosen";
    
        const grade = this.dataset.grade;
        const submissionWrapper = document.getElementById("submissionWrapper");
    
        // Restore original form HTML if not graded
        if (!grade && submissionWrapper) {
          submissionWrapper.innerHTML = `
            <form action="{{ route('assignment.submit') }}" method="POST" enctype="multipart/form-data">
              
              <input type="hidden" name="assignment_id" id="modalAssignmentId">
    
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
    
          // Re-bind file upload trigger (since we replaced the element)
          document.getElementById("uploadButton")?.addEventListener("click", function () {
            document.getElementById("fileInput").click();
          });
    
          document.getElementById("fileInput")?.addEventListener("change", function () {
            const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
            document.getElementById("fileNameDisplay").innerText = fileName;
          });
    
        } else if (grade && submissionWrapper) {
          submissionWrapper.innerHTML = `
            <p style="color: red; font-weight: bold;">
              You have already been graded <strong>(Grade: ${grade})</strong>. Resubmission is not allowed.
            </p>`;
        }
      });
    });
    
    
    

    closeBtn?.addEventListener("click", function () {
      modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
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

            folders.forEach(folder => {
              const row = document.createElement("tr");
              row.innerHTML = `
                <td><i class='bx bx-folder'></i> ${folder.name}</td>
                <td>-</td>
                <td>-</td>
                <td>
                  <button onclick="viewFolder(${folder.id}, '${folder.name}')" class="file-action-view">
                    VIEW FOLDER
                  </button>
                </td>`;
              fileTableBody.appendChild(row);
            });
            

            files.forEach(file => {
              const row = document.createElement("tr");
              row.innerHTML = `
                <td><i class='bx bx-file'></i> ${file.file_name}</td>
                <td>${file.modified_at}</td>
                <td>${file.modified_by}</td>
                <td>
                  <div style="display: flex; gap: 10px;">
                    <a href="/storage/${file.file_path}" target="_blank" class="file-action-view" title="View File">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                  </div>
                </td>`;
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
          row.innerHTML = `
            <td><i class='bx bx-file'></i> ${file.file_name}</td>
            <td>${file.modified_at}</td>
            <td>${file.modified_by}</td>
            <td>
              <div style="display: flex; gap: 10px;">
                <a href="/storage/${file.file_path}" target="_blank" class="file-action-view" title="View File">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </div>
            </td>`;
          fileTableBody.appendChild(row);
        });
      });
  }

  // Expose for global use
  window.showMainFileTable = showMainFileTable;
  window.viewFolder = viewFolder;

  showMainFileTable();
});
