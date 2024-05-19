<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 10px;
        }

        .grid div {
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
            font-size: 16px;
        }

        #editProfileBtn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #editProfileBtn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>User Information</h1>
    
    <?php
    // Check if email is received from the form
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        echo "<p>Email: $email</p>";

        include './config/database.php';

$sql = " SELECT * FROM main_passengers WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$results = $stmt->get_result();
if ($results->num_rows > 0) {
    // Output data of the first row (assuming there's only one user with the provided email)
    $row = $results->fetch_assoc();
}

        $sql = "SELECT `reg_id`, `reg_firstname`, `reg_lastname`, `reg_email`, `reg_pass`, `reg_region`, `reg_province`, `reg_city`, `reg_barangay`, `reg_idUpload`, `gender`, `dob`, `age`, `status`, `phone`, `nationality` FROM `logindata` WHERE `reg_email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output data of the first row (assuming there's only one user with the provided email)
            $row = $result->fetch_assoc();
            ?>
            <!-- ID Picture section -->
            <label for="idimg">ID Picture:</label>
            <div for="idimg" class="ID">
                <input type="image" name="idimg" id="idimg" style="width: 400px; height: 400px" src="data:image/jpeg;base64,<?php echo base64_encode($row['reg_idUpload']); ?>" alt="ID Picture"><br>
            </div>
            <label for="prof">Prof of Payment</label>
            <div for="prof" class="prof">
    <input type="image" name="prof" id="prof" style="width: 400px; height: 400px" src="<?php echo base64_encode($row['prof_payment']); ?>">
</div>

            <form>
                <div class="grid">
                    <div>
                        <label for="Firstname">Name:</label>
                        <input type="text" name="Firstname" id="Firstname" value="<?php echo $row['reg_firstname'] . ' ' . $row['reg_lastname']; ?>" readonly>

                        <label for="BDate">Birth Date:</label>
                        <input type="date" name="BDate" id="BDate" value="<?php echo $row['dob']; ?>" readonly>

                        <label for="Age">Age:</label>
                        <input type="text" name="Age" id="Age" value="<?php echo $row['age']; ?>" readonly>

                        <label for="Gender">Gender:</label>
                        <input type="text" name="Gender" id="Gender" value="<?php echo $row['gender']; ?>" readonly>

                        <label for="Status">Status:</label>
                        <input type="text" name="Status" id="Status" value="<?php echo $row['status']; ?>" readonly>

                        <label for="Phonenumber">Phone Number:</label>
                        <input type="text" name="Phonenumber" id="Phonenumber" value="<?php echo $row['phone']; ?>" readonly>

                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $row['reg_email']; ?>" readonly autocomplete="email">
                    </div>
                    <div class="secondcolumn">
                        <label for="Nationality">Nationality:</label>
                        <input type="text" name="Nationality" id="Nationality" value="<?php echo $row['nationality']; ?>" readonly>

                        <label for="Region">Region:</label>
                        <input type="text" name="Region" id="Region" value="<?php echo $row['reg_region']; ?>" readonly autocomplete="Region">

                        <label for="Province">Province:</label>
                        <input type="text" name="Province" id="Province" value="<?php echo $row['reg_province']; ?>" readonly>

                        <label for="Citymun">City/Municipality:</label>
                        <input type="text" name="Citymun" id="Citymun" value="<?php echo $row['reg_city']; ?>" readonly>

                        <label for="Brgy">Barangay:</label>
                        <input type="text" name="Brgy" id="Brgy" value="<?php echo $row['reg_barangay']; ?>" readonly>

                        <button type="button" onclick="window.location.href = 'admin.php';">Back</button>


                    </div>
                </div>
            </form>
            <?php
        } else {
            echo "<p>No user found with the provided email.</p>";
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "<p>No email received.</p>";
    }
    ?>
</body>
</html>
