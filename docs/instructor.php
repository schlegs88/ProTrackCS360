<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protrack360</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Add any additional meta tags, stylesheets, or scripts here -->

</head>

<body>

    <!-- Header Section -->
    <header>
        <h1>INSTRUCTOR</h1>

    </header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php">Sign Out</a>
                    <a class="nav-link" href="about.php">About</a>
                    <a class="nav-link" href="instructor.php">Dashboard</a>
                    <a class="nav-link" href="instructorcal.php">Calendar</a>
                    <a class="nav-link" href="instructorgrades.php">Grades</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Portfolio Section -->


    <section id="project-section">
        <h2>Dashboard</h2>
        <?php
        // In your PHP scripts
        session_start();
        require 'config.php';
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($_SESSION['message'] !== null) {
            echo "<p>{$_SESSION['message']}</p>";
            $_SESSION['message'] = null;
        }
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $instructor_id = $_SESSION['UserID'];

        $sql = "SELECT DISTINCT p.Pid, p.ProjectName, p.possibleScore, p.ProjectDescription, p.DueDate, d.deliverableid, d.delivName, d.duedate, d.phase FROM projects p LEFT JOIN deliverables d ON p.Pid = d.Pid WHERE p.InstructorID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        $stmt->bind_param("i", $instructor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<form action='update.php' method='post' id='projectForm'>";
            echo "<table>";
            echo "<thead><tr><th>Project Name</th><th>Possible Score</th><th>Description</th><th>Due Date</th><th>Deliverables</th><th>save</th></tr></thead>";
            echo "<tbody>";
            $lastPid = null;
            while ($row = $result->fetch_assoc()) {
                // Check if we are still on the same project
                if ($lastPid !== $row["Pid"]) {
                    if ($lastPid !== null) {
                        // End previous project row
                        echo "<td><button onclick='showDeliverables(" . $lastPid . ", event)'>View/Edit Deliverables</button></td>";
                        echo "<td><button type='button' onclick='document.getElementById(\"projectForm\").submit();'>Save</button></td>";
                        echo "</tr>"; // Close the previous row
                    }
                    // Start a new project row
                    echo "<tr>";
                    echo "<td><input type='text' name='ProjectName[]' value='" . htmlspecialchars($row["ProjectName"]) . "'></td>";
                    echo "<td><input type='text' name='possibleScore[]' value='" . htmlspecialchars($row["possibleScore"]) . "'></td>";
                    echo "<td><input type='text' name='ProjectDescription[]' value='" . htmlspecialchars($row["ProjectDescription"]) . "'></td>";
                    echo "<td><input type='date' name='duedate[]' style=\"width: 100% !important;
                    padding: 12px !important;
                    border: 2px solid #ddd !important;
                    border-radius: 5px !important;
                    box-sizing: border-box !important;
                    font-size: 16px !important;
                    margin-top: 6px !important;
                    transition: border-color 0.3s ease !important;\"  value='" . htmlspecialchars($row["DueDate"]) . "'></td>";
                    echo "<input type='hidden' name='ProjectId[]' value='" . $row["Pid"] . "'>"; // Hidden input for project ID
                    $lastPid = $row['Pid'];
                } else {
                    // Handle multiple deliverables for the same project here
                    // Example: Append deliverable details to a list under the project
                }
            }
            // Make sure to close the last project row
            if ($lastPid !== null) {
                echo "<td><button id='showDelivs' onclick='showDeliverables(" . $lastPid . ", event); resizeAndRepositionModal();'>View/Edit Deliverables</button></td>";
                echo "<td><button type='button' onclick='document.getElementById(\"projectForm\").submit();'>Save</button></td>";
                echo "</tr>"; // Close the last row
            }
            echo "</tbody>";
            echo "</table>";
            echo "</form>";
        } else {
            echo "<p>No projects found</p>";
        }
        $conn->close();
        ?>

    </section>




    <!-- Button to add a new project -->
    <button onclick="addProjectForm()">Add Project</button>

    <!-- Footer Section -->
    <footer>
        <nav>
            <a href="#terms">Terms and Conditions</a>
            <a href="#priv">Privacy Policy</a>
            <a href="#cookies">Cookie Policy</a>
        </nav>

    </footer>


</body>

<div id="deliverableModal"
style="display:none; position:fixed; top:20%; left:25%; background:white; border:1px solid #ccc; padding:20px; z-index:1000;">
    <div id="deliverableContent"></div>
    <button onclick="closeDeliverableModal()">Close</button>
</div>

<script>
    function addProjectForm() {
        var form = document.createElement("form");
        form.action = "newproj.php";
        form.method = "post";

        var projectNameInput = document.createElement("input");
        projectNameInput.type = "text";
        projectNameInput.name = "ProjectName[]";
        projectNameInput.placeholder = "Enter project name";

        var possibleScoreInput = document.createElement("input");
        possibleScoreInput.type = "text";
        possibleScoreInput.name = "possibleScore[]";
        possibleScoreInput.placeholder = "Enter possible score";

        var projectDescriptionInput = document.createElement("input");
        projectDescriptionInput.type = "text";
        projectDescriptionInput.name = "ProjectDescription[]";
        projectDescriptionInput.placeholder = "Enter project description";

        var submitButton = document.createElement("input");
        submitButton.type = "submit";
        submitButton.value = "Save";

        form.appendChild(projectNameInput);
        form.appendChild(possibleScoreInput);
        form.appendChild(projectDescriptionInput);
        form.appendChild(submitButton);

        document.getElementById("project-section").appendChild(form);


    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('project-section').addEventListener('click', function (event) {
            var target = event.target;
            if (target.tagName === 'BUTTON' && target.getAttribute('data-action') === 'addDeliverable') {
                addDeliverable(target);
            }
        });
    });

    function addDeliverable(Pid) {
        // Access the modal content where the form will be appended.
        var deliverableContent = document.getElementById('deliverableContent');

        // Clear previous content in deliverableContent if necessary
        deliverableContent.innerHTML = '';

        // Create a new form to hold the input fields for the new deliverable.
        var form = document.createElement('form');
        form.action = "insertDeliv.php";
        form.method = "post";

        // Create input for deliverable name.
        var nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = 'NewDeliverableName[]';
        nameInput.placeholder = 'Deliverable Name';

        // Create input for due date.
        var dueDateInput = document.createElement('input');
        dueDateInput.type = 'date';
        dueDateInput.name = 'NewDeliverableDueDate[]';
        dueDateInput.placeholder = 'Due Date';

        // Create input for phase.
        var phaseInput = document.createElement('input');
        phaseInput.type = 'text';
        phaseInput.name = 'NewDeliverablePhase[]';
        phaseInput.placeholder = 'Phase';

        var pidInput = document.createElement('input');
        pidInput.type = 'hidden';
        pidInput.name = 'Pid[]';
        pidInput.value = Pid; // Replace with actual project ID

        // Create submit button.
        var submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.textContent = 'Save';

        // Append all elements to the form.
        form.appendChild(nameInput);
        form.appendChild(dueDateInput);
        form.appendChild(phaseInput);
        form.appendChild(pidInput);
        form.appendChild(submitButton);

        // Append the form to the modal content.
        deliverableContent.appendChild(form);
    }

    function isValidPid(pid) {
        return /^\d+$/.test(pid); // Returns true if pid is a number
    }

    function showDeliverables(pid, event) {
        event.preventDefault();
        event.stopPropagation();

        if (!isValidPid(pid)) {
            console.error("Invalid PID:", pid);
            return; // Stop the function if pid is not valid
        }

        var url = "getDeliverables.php?pid=" + pid;

        var modal = document.getElementById('deliverableModal');
        var deliverableContent = document.getElementById('deliverableContent');
        deliverableContent.innerHTML = ''; // Clear previous content


        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })

            .then(deliverables => {
                var form = document.createElement('form');
                form.action = 'delivUpdate.php';
                form.method = 'post';
                form.id = 'deliverableForm';
                var table = document.createElement('table');
                table.innerHTML = '<tr><th>Name</th><th>Due Date</th><th>Phase</th><th>Action</th></tr>';
                deliverables.forEach(d => {
                    var row = table.insertRow(-1);
                    row.insertCell(0).innerHTML = `<input type="text" value="${d.delivName}" name="delivName[]">`;
                    row.insertCell(1).innerHTML = `<input type="date" value="${d.dueDate}" name="dueDate[]">`;
                    row.insertCell(2).innerHTML = `<input type="text" value="${d.phase}" name="phase[]">`;
                    var actionCell = row.insertCell(3);
                    actionCell.innerHTML = `<input type="hidden" value="${d.deliverableid}" name="delivId[]">`;
                    var saveButton = document.createElement('button');
                    saveButton.textContent = 'Save';
                    saveButton.type = 'button';
                    saveButton.onclick = function () {
                        form.submit();
                    };
                    actionCell.appendChild(saveButton);
                });
                form.appendChild(table);
                deliverableContent.appendChild(form);

                // Button to add new deliverable directly within the modal
                var addButton = document.createElement('button');
                addButton.textContent = 'Add New Deliverable';
                addButton.type = 'button';
                addButton.onclick = () => {
                    addDeliverable(pid);
                } // Link the addDeliverable function
                form.appendChild(addButton);

                modal.style.display = 'block'; // Display the modal
                
            })
            .catch(error => {
                console.error('Error fetching deliverables:', error);
                deliverableContent.innerHTML = '<p>Error loading deliverables. Please try again.</p>';
            });
    }




    function closeDeliverableModal() {
        document.getElementById('deliverableModal').style.display = 'none';
    }

    function resizeAndRepositionModal() {
        var modal = document.getElementById("deliverableModal");
        var modalContent = modal.querySelector(".modal-content");

        // Setting the size of the modal
        modalContent.style.width = "50%"; // Setting the width to 50% of its parent
        modalContent.style.height = "300px"; // Setting a fixed height

        // Repositioning the modal
        modalContent.style.marginTop = "10%"; // 10% from the top of the viewport
        modalContent.style.marginLeft = "25%"; // Since width is 50%, setting left margin to 25% centers it
    }

    function responsiveModalAdjustments() {
        var modalContent = document.getElementById("myModal").querySelector(".modal-content");

        if (window.innerWidth < 600) {
            modalContent.style.width = "90%";
            modalContent.style.marginLeft = "5%";
        } else {
            modalContent.style.width = "50%";
            modalContent.style.marginLeft = "25%";
        }
    }

    window.onresize = responsiveModalAdjustments;
    responsiveModalAdjustments();  // Call on initial load
    // Assuming you have a way to trigger this function, e.g., a button click:
    document.getElementById("showDelivs").addEventListener("click", resizeAndRepositionModal);


</script>

</html>