<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Classroom</title>
   
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/create-quiz.css') }}">
    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>

    <section class ="home">
        
        <header class = "creation-header">
            <h1><input type="text" id="quiz-title" placeholder="Name Your Quiz"></h1>
        </header>

        <main class = "creation-main">  

            <header class="creation-mainheader">
                <div class="button-group">
                    <!-- Add Notes Button -->
                    <div class="button-notes">
                        <button class="add-notes"><i class='bx bx-bulb icons'></i> Add Notes</button>
                    </div>

                    <!-- Timer Button with Dropdown -->
                    <div class="button-timer">
                        <button class="add-notes dropdown-btn"><i class='bx bx-timer icons'></i> Timer</button>
                        <div class="dropdown-content">
                            <label for="timer-select">Set Timer:</label>
                            <select id="timer-select">
                                <option value="30">30 sec</option>
                                <option value="60">1 min</option>
                                <option value="90">1 min 30 sec</option>
                                <option value="120">2 min</option>
                            </select>
                        </div>
                    </div>

                    <!-- Points Button with Dropdown -->
                    <div class="button-points">
                        <button class="add-notes dropdown-btn"><i class='bx bx-medal icons'></i> Points</button>
                        <div class="dropdown-content">
                            <label for="points-select">Select Points:</label>
                            <select id="points-select">
                                <option value="10">10 Points</option>
                                <option value="20">20 Points</option>
                                <option value="30">30 Points</option>
                                <option value="50">50 Points</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Right-side buttons -->
                    <div class="right-buttons">
                        <button class="save-btn"><i class='bx bx-save'></i> Save</button>
                        <button class="add-question-btn"><i class='bx bx-add-to-queue'></i> Add Question</button>
                        <button class="publish-btn"><i class='bx bx-send' ></i> Publish</button>
                    </div>
            </header>


            
        
            <h1 id="question-title">QUESTION 1</h1>

            <div class="question-container">
                <input type="text" id="question-input" placeholder="Input your question here..">
            </div>

            <div class="slide-note-container">
                <label for="slide-note">Slide Note (Optional):</label>
                <textarea id="slide-note" placeholder="Enter slide note for this question..."></textarea>
            </div>

            <div class="answer-container">
                <div class="answers">
                    <i class='bx bx-checkbox' onclick="toggleCheck(this)"></i>
                    <input type="text" class="answer-input" placeholder="Type answer option here">
                </div>
                <div class="answers">
                    <i class='bx bx-checkbox' onclick="toggleCheck(this)"></i>
                    <input type="text" class="answer-input" placeholder="Type answer option here">
                </div>
                <div class="answers">
                    <i class='bx bx-checkbox' onclick="toggleCheck(this)"></i>
                    <input type="text" class="answer-input" placeholder="Type answer option here">
                </div>
                <div class="answers">
                    <i class='bx bx-checkbox' onclick="toggleCheck(this)"></i>
                    <input type="text" class="answer-input" placeholder="Type answer option here">
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="question-navigation">
                <button class="prev-question-btn" disabled><i class='bx bx-left-arrow'></i> Previous</button>
                <button class="next-question-btn"><i class='bx bx-right-arrow'></i> Next</button>
            </div>



            
        </main>

    </section>
    
    


    <div id="classroomMeta" data-classroom-id="{{ $classroom->id }}"></div>
    
    <script src="{{ asset('js/create-quiz.js') }}"></script>
</body>

</html>