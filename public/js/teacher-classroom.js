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
document.addEventListener("DOMContentLoaded", function () {
  const replyBtn = document.querySelector(".reply-btn");
  const replyInputContainer = document.getElementById("replyInputContainer");
  const sendReplyBtn = document.getElementById("sendReplyBtn");
  const replyInput = document.getElementById("replyInput");
  const commentList = document.getElementById("commentList");
  const studentImage = "/images/student-boy.png"; // Direct file path



  // Show Reply Input When "Reply" Button Clicked
  replyBtn.addEventListener("click", function () {
      replyInputContainer.style.display = "flex";
      replyBtn.style.display = "none"; // Hide Reply Button
  });

  // Submit Reply
  sendReplyBtn.addEventListener("click", function () {
      let replyText = replyInput.value.trim();
      if (replyText !== "") {
          // Create a New Comment Element
          let comment = document.createElement("div");
          comment.classList.add("comment");

           comment.innerHTML = `
           <img src="${studentImage}" alt="Profile Picture" class="profile-pic">
                <div class="comment-details">
                    <span class="student-name">Muhd Harris</span>
                    
                    <div class="comment-text">${replyText}</div>
                </div>
            `;

          // Append Comment to Comment List
          commentList.appendChild(comment);

          // Clear Input Field
          replyInput.value = "";
      }
  });
});

//================ =======================TAB FOR GRADING========================================
document.addEventListener("DOMContentLoaded", function () {
    const gradingTab = document.getElementById("grading");
    const gradingTitle = document.getElementById("grading-title");

    document.querySelectorAll(".view-button").forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            // Get the assignment title from the <td>
            const assignmentRow = this.closest("tr");
            const assignmentTitle = assignmentRow.querySelector("td:first-child").textContent;

            // Update the grading tab title with the assignment name
            gradingTitle.textContent = ` ${assignmentTitle}`;

            // Show the grading tab and hide others
            document.querySelectorAll(".tab-content").forEach(tab => tab.classList.remove("active"));
            gradingTab.classList.add("active");

            // Remove active class from all tab links
            document.querySelectorAll(".tab-link").forEach(tab => tab.classList.remove("active"));
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".grade-buttons .grade").forEach(button => {
        button.addEventListener("click", function () {
            const parentTd = this.closest(".grade-buttons");
            const gradedText = parentTd.querySelector(".graded-text");
            const undoBtn = parentTd.querySelector(".undo-btn");
            const allGrades = parentTd.querySelectorAll(".grade");

            // Hide all grade buttons
            allGrades.forEach(btn => btn.style.display = "none");

            // Show "Graded" text and "Undo" button
            gradedText.style.display = "inline-block";
            undoBtn.style.display = "inline-block";

            // Store selected grade
            parentTd.dataset.selectedGrade = this.textContent;
        });
    });

    document.querySelectorAll(".undo-btn").forEach(button => {
        button.addEventListener("click", function () {
            const parentTd = this.closest(".grade-buttons");
            const gradedText = parentTd.querySelector(".graded-text");
            const undoBtn = parentTd.querySelector(".undo-btn");
            const allGrades = parentTd.querySelectorAll(".grade");

            // Show all grade buttons again
            allGrades.forEach(btn => btn.style.display = "flex");

            // Hide "Graded" text and "Undo" button
            gradedText.style.display = "none";
            undoBtn.style.display = "none";

            // Remove stored grade
            delete parentTd.dataset.selectedGrade;
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
                                <button onclick="viewFolder(${folder.id}, '${folder.name}')">View</button>
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
                                    <a href="/storage/${file.file_path}" target="_blank" class="view-button">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
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
                            <i class="fa fa-eye" aria-hidden="true"></i>
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

