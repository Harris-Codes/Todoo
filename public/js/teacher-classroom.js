const body = document.querySelector('body'),
  sidebar = body.querySelector('nav'),
  toggle = body.querySelector(".toggle"),
  searchBtn = body.querySelector(".search-box"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");



// Toggle sidebar visibility
toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close");
})



function confirmLogout(event){
  event.preventDefault();
  if(confirm('Are you sure you want to log out?')){
    window.location.href = "{{url('login')}}"; 
  }
}
  



// -------------------------for the pop-out window------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
  const joinButton = document.querySelector(".Join-button"); // Join button
  const popupContainer = document.getElementById("popupContainer"); // Modal container
  const closePopup = document.querySelector(".exitBtn"); // Close button

  // Show modal when "Join Class" button is clicked
  joinButton.addEventListener("click", function () {
      popupContainer.classList.add("active"); // Show pop-up
  });

  // Hide modal when close button is clicked
  closePopup.addEventListener("click", function () {
      popupContainer.classList.remove("active"); // Hide pop-up
  });

  // Hide modal when clicking outside of it
  popupContainer.addEventListener("click", function (event) {
      if (event.target === popupContainer) {
          popupContainer.classList.remove("active");
      }
  });
});



//======================= NAVIGATION TAB =================================================
function openTab(event, tabName) {
  // Hide all tab contents
  document.querySelectorAll(".tab-content").forEach(tab => {
      tab.classList.remove("active");
  });

  // Remove active class from all tab links
  document.querySelectorAll(".tab-link").forEach(button => {
      button.classList.remove("active");
  });

  // Show the selected tab
  document.getElementById(tabName).classList.add("active");

  // Mark the clicked tab as active
  event.currentTarget.classList.add("active");
}




// ================ REPLY BUTTON ========================
// ================ REPLY HANDLING FOR TEACHER ========================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.reply-section').forEach(section => {
        const replyBtn = section.querySelector('.reply-btn');
        const replyInputContainer = section.querySelector('.reply-input-container');

        // Show input when "Reply" is clicked
        replyBtn.addEventListener('click', function () {
            replyInputContainer.style.display = 'flex';
            replyBtn.style.display = 'none';

            // Autofocus input
            const input = replyInputContainer.querySelector('input');
            if (input) input.focus();
        });

        // Hide input when clicking outside
        document.addEventListener('click', function (e) {
            if (!section.contains(e.target)) {
                replyInputContainer.style.display = 'none';
                replyBtn.style.display = 'flex';
            }
        });
    });
});

  

//================ =======================TAB FOR GRADING========================================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-button").forEach(button => {
        button.addEventListener("click", function () {
            const assignmentId = this.dataset.assignmentId;
            const assignmentTitle = this.dataset.assignmentTitle;
            viewSubmissions(assignmentId, assignmentTitle);
        });
    });
});



//==================== ASSIGNMENT TABLE/Edit=====================
document.querySelectorAll(".edit-button").forEach(button => {
    button.addEventListener("click", function () {
        const id = this.dataset.id;
        const title = this.dataset.title;
        const due = this.dataset.date;
        const desc = this.dataset.desc;

        // Open modal
        document.getElementById("addAssignmentModal").style.display = "flex";

        // Fill the form
        document.getElementById("assignmentTitle").value = title;
        document.getElementById("assignmentDue").value = due;
        document.getElementById("assignmentDesc").value = desc;

        // Set form action to the update route
        const form = document.getElementById("assignmentForm");
        form.action = `/assignments/${id}`; // or use a Laravel route helper if passing via JS

        // Set method to PUT
        document.getElementById("assignmentMethod").value = "PUT";
    });
});




//=========================== MODAL TO HANDLE ASSIGNMENT CREATION MODAL ==================================
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("addAssignmentModal");
  const openBtn = document.getElementById("openAddAssignment");
  const closeBtn = document.getElementById("closeAddAssignment");
  const form = document.getElementById("assignmentForm");
  const tableBody = document.getElementById("assignmentTableBody");

 

  // Open modal
  openBtn.addEventListener("click", function () {
    modal.style.display = "flex";

    // Reset form fields
    form.reset();

    // Set to CREATE route
    form.action = "/assignments"; // Or use a Blade route if rendering in-line

    // Reset method to POST
    document.getElementById("assignmentMethod").value = "POST";
  });

  // Close modal when clicking the close button
  closeBtn.addEventListener("click", function () {
      modal.style.display = "none";
  });

  // Close modal when clicking outside
  window.addEventListener("click", function (event) {
      if (event.target === modal) {
          modal.style.display = "none";
      }
  });

  // Handle form submission
  form.addEventListener("submit", function (event) {
      

      // Get form values
      const title = document.getElementById("assignmentTitle").value;
      const dueDate = document.getElementById("assignmentDue").value;
      const description = document.getElementById("assignmentDesc").value;
      const file = document.getElementById("assignmentFile").files[0]?.name || "No file";

      // Create new row
      const newRow = document.createElement("tr");
      newRow.setAttribute("data-desc", description);
      newRow.innerHTML = `
          <td>${title}</td>
          <td>${dueDate}</td>
          <td>
              <button class="view-button">
                  <i class="fa-solid fa-eye"></i>
              </button>
              <button class="delete-button">
                  <i class="fa-solid fa-trash"></i> DELETE
              </button>
          </td>
      `;

      // Append to table
      tableBody.appendChild(newRow);

      // Reset form & Close modal
      form.reset();
      modal.style.display = "none";
  });

  // Delete assignment
  tableBody.addEventListener("click", function (event) {
      if (event.target.closest(".delete-button")) {
          event.target.closest("tr").remove();
      }
  });
});


document.getElementById("uploadButton").addEventListener("click", function () {
    document.getElementById("fileInput").click(); // Open hidden file input
});

document.getElementById("fileInput").addEventListener("change", function () {
    const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
    document.getElementById("fileNameDisplay").innerText = fileName;
});


//=====================CREATE POST========================
document.addEventListener("DOMContentLoaded", function () {
  const postInputContainer = document.getElementById("postInputContainer");
  const postInput = document.getElementById("postInput");
  const postExpanded = document.getElementById("postExpanded");
  const postTextArea = document.getElementById("postTextArea");
  const cancelButton = document.querySelector(".cancel-button");
  const postButton = document.querySelector(".post-button");
  const createQuizButton = document.querySelector(".quiz-button");

  // Function to expand post input when clicked
  postInput.addEventListener("click", function () {
      postExpanded.style.display = "block";
      postInputContainer.style.display = "none"; // Hide input field when expanding
      postTextArea.focus();
  });

  // Function to cancel post (hide expanded box and restore input field)
  cancelButton.addEventListener("click", function () {
      postExpanded.style.display = "none";
      postTextArea.value = "";
      postInputContainer.style.display = "flex"; // Restore input field
  });

  // Function to submit post
  postButton.addEventListener("click", function () {
      const content = postTextArea.value.trim();
      if (content !== "") {
          alert("Post submitted: " + content);
          postExpanded.style.display = "none";
          postTextArea.value = "";
          postInputContainer.style.display = "flex"; // Restore input field
      } else {
          alert("Post content cannot be empty!");
      }
  });

  // Function to create a quiz (redirect or show modal)
  createQuizButton.addEventListener("click", function () {
      alert("Redirecting to create quiz page...");
      window.location.href = "/create-quiz"; 
  });

  // Hide expanded post box if clicked outside
  document.addEventListener("click", function (event) {
      const postContainer = document.querySelector(".create-post-container");

      // If clicking outside the entire post container, hide expanded box and restore input field
      if (!postContainer.contains(event.target)) {
          postExpanded.style.display = "none";
          postTextArea.value = "";
          postInputContainer.style.display = "flex"; // Restore input field
      }
  });
});


//=======================================TAB FOR STUDENT ================================================
document.addEventListener("DOMContentLoaded", function () {
    const studentTableBody = document.getElementById("studentTableBody");
    const studentModal = document.getElementById("addStudentModal");
    const studentEmailInput = document.getElementById("studentEmail");
    
    // Open the modal
    window.openStudentModal = function () {
        studentModal.style.display = "flex";  // Ensure flexbox centering works
    };

    // Close the modal
    window.closeStudentModal = function () {
        studentModal.style.display = "none";
        studentEmailInput.value = ""; // Clear input field after closing
    };



    // Remove student from list
    studentTableBody.addEventListener("click", function (event) {
        if (event.target.closest(".delete-student")) {
            event.target.closest("tr").remove();
        }
    });
});


//=====================Files TAB=====================================================


function showMainFileTable() {
    currentFolderId = null;
    currentFolderName = null;
    document.getElementById("folderTitle").innerText = "Files";
    document.getElementById("backToMainTable").style.display = "none";

    const fileTableBody = document.getElementById("fileTableBody");
    fileTableBody.innerHTML = "<tr><td colspan='4'>Loading...</td></tr>";

    let folders = [];

    console.log("🚀 Fetching folders...");

    fetch(`/classroom/${classroomId}/folders/list`)
        .then(res => {
            console.log("📦 Folder response status:", res.status);
            return res.json();
        })
        .then(folderList => {
            console.log("📂 Folders:", folderList);
            folders = folderList;
        })
        .catch(err => {
            console.error("❌ Error fetching folders:", err);
        })
        .finally(() => {
            console.log("📥 Now fetching root files...");

            fetch(`/classroom/${classroomId}/files/root`)
                .then(res => {
                    console.log("📄 File response status:", res.status);
                    return res.json();
                })
                .then(files => {
                    console.log("📄 Files:", files);
                    fileTableBody.innerHTML = "";

                    if (folders.length === 0 && files.length === 0) {
                        fileTableBody.innerHTML = "<tr><td colspan='4'>No folders or files found.</td></tr>";
                        return;
                    }

                    folders.forEach(folder => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td><i class='bx bx-folder'></i> ${folder.name}</td>
                            <td>-</td><td>-</td>
                            <td>
                                <button onclick="viewFolder(${folder.id}, '${folder.name}')" class="view-folder-btn">
                                    VIEW
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
                                    <a href="/storage/${file.file_path}" target="_blank" class="download-button">
                                    <i class='bx bxs-download'></i>
                                    </a>
                                    <button type="button" class="delete-button" data-file-id="${file.id}">
                                    <i class='bx bx-trash'></i>
                                    </button>
                                </div>
                        </td>`;
                        fileTableBody.appendChild(row);
                    });
                })
                .catch(err => {
                    console.error("❌ Error fetching root files:", err);
                    fileTableBody.innerHTML = "<tr><td colspan='4'>Failed to load files.</td></tr>";
                });
        });
}



function viewFolder(folderId, folderName) {
    currentFolderId = folderId;
    currentFolderName = folderName;
    console.log("📁 Setting currentFolderId:", folderId);

    document.getElementById("folderTitle").innerText = `📂 ${folderName}`;
    document.getElementById("backToMainTable").style.display = "inline-block";

    const fileTableBody = document.getElementById("fileTableBody");
    fileTableBody.innerHTML = "";

    fetch(`/classroom/${classroomId}/folders/${folderId}/files`)
        .then(res => res.json())
        .then(files => {
            if (!files.length) {
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
                            <a href="/storage/${file.file_path}" target="_blank" class="view-button">
                            <i class='bx bxs-download'></i>
                            </a>
                            <button type="button" class="delete-button" data-file-id="${file.id}">
                            <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    </td>`;
                fileTableBody.appendChild(row);
            });
            
        });
}

function createFolder() {
    const name = document.getElementById("folderName").value.trim();
    const classroomId = document.getElementById("classroomMeta").dataset.classroomId;

    if (!name) return alert("Enter a folder name");

    fetch(`/classroom/${classroomId}/folders`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ name })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeFolderModal();
            showMainFileTable();
        } else {
            alert("Folder creation failed.");
        }
    })
    .catch(err => {
        console.error("Folder creation error:", err);
        alert("Something went wrong.");
    });
}


function openFolderModal() {
    document.getElementById("folderModal").style.display = "flex";
}

function closeFolderModal() {
    document.getElementById("folderModal").style.display = "none";
    document.getElementById("folderName").value = "";
}

function triggerUpload() {
    const input = document.getElementById("uploadInput");
    input.value = "";
    input.click();

    input.onchange = function () {
        if (!input.files.length) return;

        const formData = new FormData();
        formData.append("file", input.files[0]);

        const token = document.querySelector('meta[name="csrf-token"]').content;

        // ✅ Define the URL properly before using it
        const url = currentFolderId
            ? `/classroom/${classroomId}/folders/${currentFolderId}/files`
            : `/classroom/${classroomId}/files`;

        console.log("📤 Uploading to URL:", url);

        fetch(url, {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": token
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (currentFolderId) {
                    viewFolder(currentFolderId, currentFolderName);
                } else {
                    showMainFileTable();
                }
            }
        });
    };
}



window.addEventListener("DOMContentLoaded", function () {
    // Automatically open the "posts" tab (or "files", if preferred)
    const defaultTab = document.querySelector('.tab-link');
    if (defaultTab) defaultTab.click(); 
  });
  


let classroomId = null;
let currentFolderId = null;
let currentFolderName = null;

document.addEventListener("DOMContentLoaded", () => {
    classroomId = document.getElementById("classroomMeta").dataset.classroomId;
    console.log("✅ DOM loaded, classroomId:", classroomId);
    showMainFileTable();
});

function viewSubmissions(assignmentId, assignmentTitle) {
    // Switch to grading tab
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById('grading').classList.add('active');

    // Set title
    document.getElementById('grading-title').innerText = `Grading: ${assignmentTitle}`;

    // Make AJAX call
    fetch(`/assignments/${assignmentId}/submissions`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#grading tbody');
            tbody.innerHTML = ''; // clear existing

            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4">No submissions yet.</td></tr>`;
                return;
            }

            data.forEach(sub => {
                const row = document.createElement('tr');
                row.dataset.submissionId = sub.id;
            
                row.innerHTML = `
                    <td class="student-info-cell">
                        <div class="student-info">
                            <img src="${sub.profile_picture ? '/storage/' + sub.profile_picture : '/images/default-user.png'}" class="student-pic">
                            <span class="student-name">${sub.student_name}</span>
                        </div>
                    </td>
                    <td>${sub.original_filename}</td>
                    <td><a href="/storage/${sub.file_path}" class="download-button" download>⬇</a></td>
                    <td class="grade-buttons">
                        <div class="grade-container">
                            <button class="grade grade-A">A</button>
                            <button class="grade grade-B">B</button>
                            <button class="grade grade-C">C</button>
                            <button class="grade grade-D">D</button>
                        </div>
                        <span class="graded-text" style="display: none;">Graded</span>
                        <button class="undo-btn" style="display: none;">Undo</button>
                    </td>
                `;
            
                // Append to table first
                tbody.appendChild(row);
            
                // ✅ Auto-show grade if exists
                if (sub.grade) {
                    const gradeButtons = row.querySelectorAll('.grade');
                    const gradedText = row.querySelector('.graded-text');
                    const undoBtn = row.querySelector('.undo-btn');
            
                    // Hide all grade buttons
                    gradeButtons.forEach(btn => {
                        if (btn.textContent === sub.grade) {
                            // Optional: highlight or mark selected one
                            btn.classList.add('selected-grade');
                        } else {
                            btn.style.display = 'none';
                        }
                    });
            
                    // Show graded message
                    gradedText.textContent = `Graded: ${sub.grade}`;
                    gradedText.style.display = 'inline-block';
                    undoBtn.style.display = 'inline-block';
                }
            });

            bindGradeEvents();
        })
        .catch(err => {
            console.error("Failed to fetch submissions:", err);
        });
}




function bindGradeEvents() {
    document.querySelectorAll(".grade-buttons .grade").forEach(button => {
        button.onclick = function () {
            const parentTd = this.closest(".grade-buttons");
            const gradedText = parentTd.querySelector(".graded-text");
            const undoBtn = parentTd.querySelector(".undo-btn");
            const allGrades = parentTd.querySelectorAll(".grade");

            const grade = this.textContent;
            const submissionId = this.closest("tr").dataset.submissionId;

            fetch(`/submissions/${submissionId}/grade`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ grade })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    allGrades.forEach(btn => btn.style.display = "none");
                    gradedText.textContent = `Graded: ${grade}`;
                    gradedText.style.display = "inline-block";
                    undoBtn.style.display = "inline-block";
                } else {
                    alert("Failed to grade submission.");
                }
            })
            .catch(err => {
                console.error("❌ Error grading:", err);
                alert("Something went wrong.");
            });
        };
    });

    

    document.querySelectorAll(".undo-btn").forEach(button => {
        button.onclick = function () {
            const parentTd = this.closest(".grade-buttons");
            const gradedText = parentTd.querySelector(".graded-text");
            const undoBtn = parentTd.querySelector(".undo-btn");
            const allGrades = parentTd.querySelectorAll(".grade");
            const submissionId = this.closest("tr").dataset.submissionId;

            fetch(`/submissions/${submissionId}/grade/reset`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    allGrades.forEach(btn => btn.style.display = "inline-block");
                    gradedText.style.display = "none";
                    undoBtn.style.display = "none";
                } else {
                    alert("Failed to reset grade.");
                }
            })
            .catch(err => {
                console.error("❌ Error resetting grade:", err);
                alert("Something went wrong.");
            });
        };
    });
}


//=================== DELETE FILE CONFIRMATION ==================
document.addEventListener("click", function (event) {
    const button = event.target.closest(".delete-button");
    if (!button || !button.dataset.fileId) return;

    if (!button) return;

    event.preventDefault(); // 🛑 Important: prevent default navigation or form behavior

    const fileId = button.dataset.fileId;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    if (!confirm("Are you sure you want to delete this file?")) return;

    fetch(`/classroom/${classroomId}/files/${fileId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
            "Accept": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("Failed to delete.");
        return res.json();
    })
    .then(data => {
        if (data.success) {
            if (currentFolderId) {
                viewFolder(currentFolderId, currentFolderName);
            } else {
                showMainFileTable();
            }
        }
    })
    .catch(err => {
        console.error("❌ Error deleting file:", err);
        alert("Failed to delete file.");
    });
});

