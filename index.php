<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .login-form, .register-form, .welcome-form, .register-success, .student-register-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: none; /* Hide forms initially */
        }

        .login-form h2, .register-form h2, .welcome-form h2, .student-register-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        .register-info {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
            text-align: center;
        }

        .welcome-message {
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .student-list {
            margin-top: 20px;
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #f9f9f9;
        }

        .student-list ul {
            list-style: none;
            padding: 0;
        }

        .student-list li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-list li:last-child {
            border-bottom: none;
        }

        .student-list .student-header {
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px; /* Reduced font size */
        }

        .student-list .student-info {
            display: flex;
            justify-content: space-between; /* Student ID, First Name, Last Name on the same row */
            margin-bottom: 5px; /* Add space between lines */
        }

        .student-list .student-info span {
            margin-right: 5px; /* Reduced space between columns */
        }

        .student-list .student-options button {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #f44336;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        .student-list .student-options button.edit {
            background-color: #4CAF50;
        }

        .student-list .additional-info {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }

    </style>
</head>
<body>
    <!-- Login Form -->
    <div class="login-form" id="loginFormDiv">
        <h2>Login</h2>
        <form id="loginForm" onsubmit="return validateLoginForm(event)">
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
            <div id="error-message" class="error" style="display: none;">Please enter both email and password.</div>
        </form>
    </div>

    <!-- Welcome Form (after login) -->
    <div class="welcome-form" id="welcomeFormDiv">
        <h2>Welcome to the System</h2>
        <div class="welcome-message">
            <p id="welcomeMessage"></p> <!-- Display logged-in user's email -->
        </div>
        
        <!-- Register a Student Section -->
        <div class="register-info">
            <p>This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>
        </div>
        <div class="form-group">
            <button onclick="showStudentRegisterForm()">Register Student</button> <!-- Button text changed to "Register Student" -->
        </div>
    </div>

    <!-- Student Registration Form -->
    <div class="student-register-form" id="studentRegisterFormDiv">
        <h2>Register New Student</h2>
        <form id="studentRegisterForm" onsubmit="return addStudent(event)">
            <div class="form-group">
                <label for="studentID">Student ID</label>
                <input type="text" id="studentID" name="studentID" placeholder="Enter Student ID" required onkeydown="moveToNextField(event, 'firstName')">
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Student</button>
            </div>
            <div id="student-error-message" class="error" style="display: none;">Please fill in all fields to register the student.</div>
        </form>

        <!-- Student List will now be inside the Register New Student section -->
        <div id="studentList" class="student-list" style="display: none;">
            <h3>Student List</h3> <!-- Changed heading text here -->
            <!-- Adding a header row at the top of the list -->
            <div class="student-header">
                <span>Student ID</span>
                <span>First Name</span>
                <span>Last Name</span>
                <span>Options</span> <!-- Changed "Actions" to "Options" -->
            </div>
            <ul id="studentListContainer"></ul>
        </div>
    </div>

    <script>
        // Array to store registered students
        var students = [];

        function validateLoginForm(event) {
            event.preventDefault(); // Prevent form submission to allow validation and dynamic display

            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var errorMessage = document.getElementById("error-message");
            var loginFormDiv = document.getElementById("loginFormDiv");

            // Check if either the email or password is empty
            if (email === "" || password === "") {
                errorMessage.style.display = "block"; // Show error message
                return false; // Prevent form submission
            } else {
                errorMessage.style.display = "none"; // Hide error message if validation passes
                // Hide login form and show welcome form with the user's email
                loginFormDiv.style.display = "none";
                document.getElementById("welcomeFormDiv").style.display = "block";
                document.getElementById("welcomeMessage").textContent = `${email}`; // Only show the email
                return true; // Allow form submission (not really needed here as we are handling display)
            }
        }

        function showStudentRegisterForm() {
            // Hide welcome form and show student registration form
            document.getElementById("welcomeFormDiv").style.display = "none";
            document.getElementById("studentRegisterFormDiv").style.display = "block";
        }

        function addStudent(event) {
            event.preventDefault(); // Prevent form submission to allow validation

            var studentID = document.getElementById("studentID").value;
            var firstName = document.getElementById("firstName").value;
            var lastName = document.getElementById("lastName").value;
            var studentErrorMessage = document.getElementById("student-error-message");

            // Check if any fields are empty
            if (studentID === "" || firstName === "" || lastName === "") {
                studentErrorMessage.style.display = "block"; // Show error message
                return false; // Prevent form submission
            } else {
                studentErrorMessage.style.display = "none"; // Hide error message if validation passes
                // Add student to the list
                students.push({ studentID, firstName, lastName });

                // Update the student list display
                displayStudentList();

                // Reset form fields
                document.getElementById("studentRegisterForm").reset();
                return true; // Allow form submission
            }
        }

        function displayStudentList() {
            var studentListContainer = document.getElementById("studentListContainer");

            // Clear previous list
            studentListContainer.innerHTML = "";

            // Loop through students array and create list item for each student's info
            students.forEach(function(student, index) {
                var listItem = document.createElement("li");

                var studentItemDiv = document.createElement("div");
                studentItemDiv.classList.add("student-info");

                studentItemDiv.innerHTML = `
                    <span>${student.studentID}</span>
                    <span>${student.firstName}</span>
                    <span>${student.lastName}</span>
                `;

                // Add options (edit and delete) buttons for each student
                var studentOptions = document.createElement("div");
                studentOptions.classList.add("student-options");

                var editButton = document.createElement("button");
                editButton.textContent = "Edit";
                editButton.classList.add("edit");
                editButton.onclick = function() { editStudent(index); };

                var deleteButton = document.createElement("button");
                deleteButton.textContent = "Delete";
                deleteButton.onclick = function() { deleteStudent(index); };

                studentOptions.appendChild(editButton);
                studentOptions.appendChild(deleteButton);

                listItem.appendChild(studentItemDiv);
                listItem.appendChild(studentOptions);
                studentListContainer.appendChild(listItem);
            });

            // Show student list section if there are students
            document.getElementById("studentList").style.display = students.length > 0 ? "block" : "none";
        }

        // Edit student function
        function editStudent(index) {
            var student = students[index];
            document.getElementById("studentID").value = student.studentID;
            document.getElementById("firstName").value = student.firstName;
            document.getElementById("lastName").value = student.lastName;
            students.splice(index, 1); // Remove the old student from the array (will be updated)
        }

        // Delete student function
        function deleteStudent(index) {
            students.splice(index, 1); // Remove the student from the array
            displayStudentList(); // Re-render the student list
        }

        // Show the login form by default when the page loads
        window.onload = function() {
            document.getElementById("loginFormDiv").style.display = "block";
        };
    </script>
</body>
</html>
