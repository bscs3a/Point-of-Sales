<!DOCTYPE html>
<html>

<head>
    <title>Form Test</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
</head>

<body>
    <form action=></form>


    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
</body>

</html>

<?php
    // Check if the id is set in the URL
    // Start a new session or resume the existing one
    // if (isset($_SESSION['id'])) {
    //     // Get the id from the session
    //     $id = $_SESSION['id'];

    //     $db = Database::getInstance();
    //     $conn = $db->connect();

    //     // Prepare the SQL statement
    //     $stmt = $conn->prepare('SELECT name FROM name WHERE id = :id');

    //     // Bind the id to the SQL statement
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //     // Execute the SQL statement
    //     $stmt->execute();

    //     // Fetch the result
    //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if ($result) {
    //         // The id exists in the database, store the name in a text input
    //         echo '<label for="id">ID:</label><br>';
    //         echo '<input type="text" id="id" name="id" value="' . htmlspecialchars($id) . '"><br>';
    //         echo '<label for="name">Name:</label><br>';
    //         echo '<input type="text" id="name" name="name" value="' . htmlspecialchars($result['name']) . '">';
    //     } else {
    //         // The id does not exist in the database
    //         echo "The id does not exist in the database.";
    //     }
    // } else {
    //     echo "No id set in the session.";
    // }    
?>