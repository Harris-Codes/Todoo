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
      // window.location.href = "/create-quiz"; // Uncomment this line if you have a quiz creation page
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

    // Add a new student
    window.addStudent = function (event) {
        event.preventDefault(); // Prevent default form submission

        let studentEmail = studentEmailInput.value.trim();

        if (studentEmail !== "") {
            let newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>
                    <div class="student-info">
                        <img src="/images/student-boy.png" class="student-pic">
                        <span class="student-name">${studentEmail.split('@')[0]}</span> <!-- Extract name -->
                    </div>
                </td>
                <td>${studentEmail}</td>
                <td>
                    <button class="delete-student"><i class='bx bx-trash'></i> Remove</button>
                </td>
            `;

            studentTableBody.appendChild(newRow);
            closeStudentModal(); // Close modal after adding student
        } else {
            alert("Please enter a valid email!");
        }
    };

    // Remove student from list
    studentTableBody.addEventListener("click", function (event) {
        if (event.target.closest(".delete-student")) {
            event.target.closest("tr").remove();
        }
    });
});


//========================== CREATING FOLDER IN FILE TABS =============================
document.addEventListener("DOMContentLoaded", function () {
    const folderContainer = document.getElementById("folderContainer");
    const addFolderBtn = document.querySelector(".add-folder-btn");
    const fileInput = document.getElementById("fileInput");

    // Function to add a new folder
    addFolderBtn.addEventListener("click", function () {
        folderModal.style.display = "flex"; // 

        if (folderName) {
            let newFolder = document.createElement("div");
            newFolder.classList.add("folder");
            newFolder.innerHTML = `
                <i class="bx bx-folder"></i>
                <span>${folderName}</span>
                <button class="delete-folder">X</button>
            `;

            folderContainer.appendChild(newFolder);

            // Add event listener to open folder
            newFolder.addEventListener("click", function (event) {
                if (!event.target.classList.contains("delete-folder")) {
                    openFolder(folderName, newFolder);
                }
            });

            // Add event listener to delete folder
            newFolder.querySelector(".delete-folder").addEventListener("click", function (event) {
                event.stopPropagation();
                newFolder.remove();
            });
        }
    });

    // Function to open folder and add files
    function openFolder(folderName, folderElement) {
        let fileAction = confirm(`Open ${folderName}? Click "OK" to upload files.`);
        if (fileAction) {
            fileInput.click();
            fileInput.onchange = function () {
                const file = fileInput.files[0];
                if (file) {
                    let fileDiv = document.createElement("div");
                    fileDiv.classList.add("file");
                    fileDiv.innerHTML = `
                        <span>${file.name}</span>
                        <button class="delete-file">X</button>
                    `;
                    folderElement.appendChild(fileDiv);

                    // Add delete file functionality
                    fileDiv.querySelector(".delete-file").addEventListener("click", function () {
                        fileDiv.remove();
                    });
                }
            };
        }
    }
});


// =============================== file management =============================
document.addEventListener("DOMContentLoaded", function () {
    const folderModal = document.getElementById("folderModal");
    const createFolderBtn = document.getElementById("createFolderBtn");
    const fileTableBody = document.getElementById("fileTableBody");
    const fileInput = document.getElementById("fileInput");
    let selectedColor = "#4da6ff"; // Default folder color

    // Open Folder Modal
    document.getElementById("openFolderModal").addEventListener("click", function () {
        folderModal.style.display = "flex";
    });

    // Close Folder Modal
    window.closeFolderModal = function () {
        folderModal.style.display = "none";
        document.getElementById("folderName").value = ""; // Clear input
    };

    // Handle Folder Color Selection
    document.querySelectorAll(".color-choice").forEach(choice => {
        choice.addEventListener("click", function () {
            selectedColor = this.getAttribute("data-color");
            document.querySelectorAll(".color-choice").forEach(c => c.classList.remove("selected"));
            this.classList.add("selected");
        });
    });

    // Create Folder
    createFolderBtn.addEventListener("click", function () {
        const folderName = document.getElementById("folderName").value.trim();
        if (folderName === "") {
            alert("Please enter a folder name.");
            return;
        }

        // Hide "No files uploaded" message
        document.getElementById("noFilesRow").style.display = "none";

        // Create folder row
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
        <td>
            <i class='bx bx-folder' style='color: ${selectedColor};'></i> ${folderName}
        </td>
        <td>-</td>
        <td>-</td>
        <td>
            <button class="view-folder-btn" onclick="viewFolder('${folderName}')">
                <i class='bx bx-folder-open'></i> View
            </button>
            <button class="delete-btn" onclick="deleteRow(this)">
                <i class='bx bx-trash'></i> Delete
            </button>
        </td>
    
        `;

        // Append to table
        fileTableBody.appendChild(newRow);

        // Close modal after creating folder
        closeFolderModal();
    });

    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>
            <i class='bx bx-folder' style='color: ${selectedColor};'></i> ${folderName}
        </td>
        <td>-</td>
        <td>-</td>
        <td>
            <button class="view-folder-btn" onclick="viewFolder('${folderName}')">
                <i class='bx bx-folder-open'></i> View
            </button>
            <button class="delete-btn" onclick="deleteRow(this)">
                <i class='bx bx-trash'></i> Delete
            </button>
        </td>
    `;


    // Delete Row Function
    window.deleteRow = function (button) {
        button.closest("tr").remove();

        // Show "No files uploaded" message if table is empty
        if (fileTableBody.children.length === 1) {
            document.getElementById("noFilesRow").style.display = "table-row";
        }
    };
});


//======================== VIEW BUTTON IN FOLDER =======================
window.viewFolder = function (folderName) {
    const fileTable = document.getElementById("fileTableBody");
    const folderTitle = document.getElementById("folderTitle");
    const backButton = document.getElementById("backToMainTable");

    // Show "Back" button and update title
    folderTitle.innerText = `📂 ${folderName}`;
    backButton.style.display = "block";

    // Clear the file table
    fileTable.innerHTML = "";

    // Example files inside the folder (replace with backend data later)
    const files = [
        { name: "Lesson_Plan.pdf", modified: "Feb 12, 2025", modifiedBy: "Teacher" },
        { name: "Homework.docx", modified: "Feb 10, 2025", modifiedBy: "Teacher" },
    ];

    // Populate table with files inside the folder
    files.forEach(file => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td><i class='bx bx-file'></i> ${file.name}</td>
            <td>${file.modified}</td>
            <td>${file.modifiedBy}</td>
            <td>
                <button class="delete-btn" onclick="deleteRow(this)">
                    <i class='bx bx-trash'></i> Delete
                </button>
            </td>
        `;
        fileTable.appendChild(row);
    });
};



// ============================== STORE THE INPUT FROM CREATE FOLDER ====================
window.showMainFileTable = function () {
    const fileTable = document.getElementById("fileTableBody");
    const folderTitle = document.getElementById("folderTitle");
    const backButton = document.getElementById("backToMainTable");

    // Hide "Back" button and reset title
    folderTitle.innerText = "Files";
    backButton.style.display = "none";

    // Load folders from localStorage
    let folders = JSON.parse(localStorage.getItem("folders")) || [];

    console.log("Folders loaded:", folders); // Debugging log

    fileTable.innerHTML = "";

    if (folders.length === 0) {
        fileTable.innerHTML = `<tr id="noFilesRow"><td colspan="4">No files uploaded yet...</td></tr>`;
    } else {
        folders.forEach(folder => {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td><i class='bx bx-folder' style='color: ${folder.color};'></i> ${folder.name}</td>
                <td>-</td>
                <td>-</td>
                <td>
                    <button class="view-folder-btn" onclick="viewFolder('${folder.name}')">
                        <i class='bx bx-folder-open'></i> View
                    </button>
                    <button class="delete-btn" onclick="deleteFolder('${folder.name}', this)">
                        <i class='bx bx-trash'></i> Delete
                    </button>
                </td>
            `;
            fileTable.appendChild(row);
        });
    }
};

document.addEventListener("DOMContentLoaded", function () {
    showMainFileTable(); // Load stored folders when page loads
});
console.log("Stored folders:", JSON.parse(localStorage.getItem("folders")));




createFolderBtn.addEventListener("click", function () {
    const folderName = document.getElementById("folderName").value.trim();
    if (folderName === "") {
        alert("Please enter a folder name.");
        return;
    }

    // Get folders from localStorage
    let folders = JSON.parse(localStorage.getItem("folders")) || [];

    // Add the new folder to the array
    folders.push({ name: folderName, color: selectedColor });

    // Save updated folders list to localStorage
    localStorage.setItem("folders", JSON.stringify(folders));

    console.log("Folders after saving:", JSON.parse(localStorage.getItem("folders"))); // Debugging log

    // Refresh file table
    showMainFileTable();

    // Close modal
    closeFolderModal();
});
