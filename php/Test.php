<?php
include "MyConnection.php";

// Initialize the search term and infraction variable
$search_term = "";
$selected_infraction = "";

// Check if a search term and infraction have been submitted
if (isset($_POST["search_term"])) {
    $search_term = $_POST["search_term"];
}

if (isset($_POST["selected_infraction"])) {
    $selected_infraction = $_POST["selected_infraction"];
}

// SQL query to retrieve data from the table
$sql = "SELECT * FROM records WHERE (Student_Name LIKE '%$search_term%' OR Grade_Section LIKE '%$search_term%')";

if (!empty($selected_infraction)) {
    $sql .= " AND Infraction = '$selected_infraction'";
}

$sql .= " ORDER BY Student_Name";

// Execute the query
$result = $conn->query($sql);

    // Query the database
    $sql = "SELECT * FROM records ORDER BY Grade_Section, Student_Name";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">

<!--LINKS-->
    <link rel="stylesheet" href="../css/Test.css">
    <link rel="icon" href="../../res/BEC Logo.png">

<!-- LOAD ANIMATION -->
<script>
    window.onload = function() {
        document.body.classList.add('loaded');
    };
</script>

    <title>ADD</title>

</head>

<body>
    
    <!--Navigation-->
    <nav class="navigation">
        <div class="IMS">
            <div class="Logo">
                <a href="https://bec.edu.ph/"><img src="../../res/BEC Logo.png" alt="BEC Logo"></a>
            </div>
            <div class="title"></div>
        </div>
            <div class="nav_links">
                <ul>
                    <li><a href="../../html/ADMIN/home.html">Home</a></li>
                </ul>
            </div>
    </nav>

    <!--Add Form-->
    <div class="main">
        <div class="main-container">
        <div class="form-container">
            
            <a href="../../html/ADMIN/home.html">
                <div class="add_btn">
                    <h3 id="btn-add">Back</h3>
                </div></a>
                
            <?php
            // Display the data in a table
            echo "<table class='candidates'>";
            $current_grade = "";
            $current_name = "";
                while($row = $result->fetch_assoc()) {
            $grade = $row["Grade_Section"];
            $name = $row["Student_Name"];
            $infraction = $row["Infraction"];
            $date = $row["I_Date"];

            if ($current_grade != $grade) {
                echo "<tr><th colspan='2'>$grade</th></tr>";
                $current_grade = $grade;
                $current_name = "";
            }

            if ($current_name != $name) {
                echo "<tr><td>$name</td><td>$infraction - $date</td></tr>";
                $current_name = $name;
            } else {
                echo "<tr><td></td><td>$infraction - $date</td></tr>";
            }
            }
            echo "</table>";

            // Close connection
            $conn->close();
            ?>

            </div>
        </div>
    </div>

    <div class="overlay"></div>

</body>

</html>