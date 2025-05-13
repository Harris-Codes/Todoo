
//=================DASHBOARD CARD CLASS======================
document.addEventListener("DOMContentLoaded", function () {
    let currentIndex = 0;
    
    const bmTeacherImage = "/images/bm_teacher.png";
    const mathTeacherImage = "/images/math_teacher.png";
    // Class Data (Using Direct File Paths)
    const classData = [
      {
          name: "Bahasa Malaysia",
          teacher: "Fatimah Rosli",
          image: bmTeacherImage,
          assignments: 5,
          students: 312
      },
      {
          name: "Mathematics",
          teacher: "Stephena Hawking",
          image: mathTeacherImage,
          assignments: 8,
          students: 280
      }
  ];
  
    // Function to Switch Content
    function updateCard() {
        document.getElementById("className").textContent = classData[currentIndex].name;
        document.getElementById("teacherName").textContent = classData[currentIndex].teacher;
        document.getElementById("teacherImage").src = classData[currentIndex].image;
        document.getElementById("assignmentCount").textContent = classData[currentIndex].assignments;
        document.getElementById("studentCount").textContent = classData[currentIndex].students;
    }
  
    // Initialize the card with default content
    updateCard();
  
    // Previous Card Function
    window.prevCard = function () {
        currentIndex = (currentIndex - 1 + classData.length) % classData.length;
        updateCard();
    };
  
    // Next Card Function
    window.nextCard = function () {
        currentIndex = (currentIndex + 1) % classData.length;
        updateCard();
    };
  });
  