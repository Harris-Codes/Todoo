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

//========================== ASSIGNMENT MODAL BACKGROUND==================================
document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("assignmentModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalDescription = document.getElementById("modalDescription");
  const closeBtn = document.querySelector(".close-btn");

  modal.style.display = "none";
  // Open modal when clicking an assignment
  document.querySelectorAll(".clickable-row").forEach(row => {
      row.addEventListener("click", function () {
          modalTitle.innerText = this.dataset.title; // Set title
          modalDescription.innerText = this.dataset.desc; // Set description
          modal.style.display = "flex"; // Show modal
      });
  });

  // Close modal when clicking the close button
  closeBtn.addEventListener("click", function () {
      modal.style.display = "none";
  });

  // Close modal when clicking outside of it
  window.addEventListener("click", function (event) {
      if (event.target === modal) {
          modal.style.display = "none";
      }
  });
});

//========= ==================  UPLOAD BUTTON =================================
document.getElementById("uploadButton").addEventListener("click", function () {
  document.getElementById("fileInput").click(); // Opens hidden file input
});

document.getElementById("fileInput").addEventListener("change", function () {
  const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
  document.getElementById("fileNameDisplay").innerText = fileName;
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


