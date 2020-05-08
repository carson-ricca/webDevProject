    <?php 
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $fName = $_POST["fName1"];
                $lName = $_POST["lName1"];
                $phone = $_POST["phone1"];
                $email = $_POST["email1"];
                $msg = $_POST["msg1"];
              }
            echo "<p>Thank you for contacting us!</p>";
            echo "<p>You sent us the following message:</p>";
            echo $msg ."<br><br>";
            echo "<p>And you provided us with the following contact information:</p>";
            echo "First Name: " . $fName . "<br>";
            echo "Last Name: " . $lName . "<br>";
            echo "Phone Number: " . $phone . "<br>";
            echo "Email: " . $email . "<br>";
    ?>