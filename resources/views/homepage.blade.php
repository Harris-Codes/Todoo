<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="classroom-route" content="{{ route('classroom.store') }}">
  <title>Dashboard Sidebar Menu</title>
  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  
@include('partials.sidebar')

  <!---------------------------------- Main content section---------------------------- -->
<section class="home">

    <div class="text">My Classes
        <button class="Join-button" id="openPopup">
            <i class='bx bx-plus-circle join'></i>
            <span class ="join-text">Join Classroom</span>
        </button>
    </div>
    

    

    <div class = "card-container">
        <div class="card">
            <div class="image_container">

            </div>

            <div class="title">
                <span>Bahasa Malaysia</span>
            </div>

            <div class="creator">
                <span>Fatimah Rosli</span>
            </div>

            <div class="button-group">

                <a href="{{ url('classroom') }}" class="view-button">
                  <span>View Class</span>
                </a>

                <button class="delete-button">
                    <i class='bx bx-trash-alt icon'></i>
                </button>
            </div>

        </div>


        <div class="card">
            <div class="image_container">

            </div>

            <div class="title">
                <span>English</span>
            </div>

            <div class="creator">
                <span>Danny Lanny</span>
            </div>

            <div class="button-group">
                <button class="view-button">
                    <span>View Class</span>
                </button>
                <button class="delete-button">
                    <i class='bx bx-trash-alt icon'></i>
                </button>
            </div>

        </div>

        <div class="card">
            <div class="image_container">

            </div>
            <div class="title">
                <span>Mathematic</span>
            </div>
            <div class="creator">
                <span>Stephen Hawking</span>
            </div>
            <div class="button-group">
                <button class="view-button">
                    <span>View Class</span>
                </button>
                <button class="delete-button">
                    <i class='bx bx-trash-alt icon'></i>
                </button>
            </div>
        </div>

        <div class="card">
            <div class="image_container">

            </div>
            <div class="title">
                <span>Science</span>
            </div>
            <div class="creator">
                <span>Nurin Qistina</span>
            </div>
            <div class="button-group">
                <button class="view-button">
                    <span>View Class</span>
                </button>
                <button class="delete-button">
                    <i class='bx bx-trash-alt icon'></i>
                </button>
            </div>
        </div>

        <div class="card">
            <div class="image_container">

            </div>
            <div class="title">
                <span>Art</span>
            </div>
            <div class="creator">
                <span>Faiqal Qistina</span>
            </div>
            <div class="button-group">
                <button class="view-button">
                    <span>View Class</span>
                </button>
                <button class="delete-button">
                    <i class='bx bx-trash-alt icon'></i>
                </button>
            </div>
        </div>

    </div>

    <!-- Pop-up Modal -->
<div class="popup-container" id="popupContainer">
    
      <form class="otp-Form">
 
        <span class="mainHeading">Classroom Code</span>
        <p class="otpSubheading">Enter clasroom code</p>
        <div class="inputContainer">
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input1">
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input2">
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input3">
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input4"> 
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input5"> 
          <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input6"> 

        </div>
          <button class="joinButton" type="submit">Join</button>
            <button class="exitBtn">x</button>

      </form>



</div>

</section>

  <!-- JavaScript file -->
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/homepage.js') }}"></script>

</body>
</html>