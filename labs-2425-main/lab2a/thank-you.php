<?php

require "helpers/helper-functions.php";

session_start();

$fullname = $_POST['fullname'];
$birthdate = $_POST['birthdate'];
$contact_number = $_POST['contact_number'];
$sex = $_POST['sex'];
$program = $_POST['program'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = sha1($_POST['password']);
$agree = isset($_POST['agree']) ? 'Yes' : 'No';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

function calculateAge($birthdate) {
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $birthDate->diff($currentDate)->y;
    return $age;
}

$age = calculateAge($birthdate);

$formattedBirthdate = date("F j, Y", strtotime($birthdate));

$_SESSION['fullname'] = $fullname;
$_SESSION['birthdate'] = $formattedBirthdate;
$_SESSION['contact_number'] = $contact_number;
$_SESSION['sex'] = $sex;
$_SESSION['program'] = $program;
$_SESSION['address'] = $address;
$_SESSION['email'] = $email;
$_SESSION['password'] = $password;
$_SESSION['age'] = $age;

$csvFilePath = '../lab2b/registrations.csv';


$file = fopen($csvFilePath, 'a');

fputcsv($file, [
    $fullname,
    $formattedBirthdate,
    $age,
    $contact_number,
    $sex,
    $program,
    $address,
    $email
]);

fclose($file);

session_destroy();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #2</title>
    <link rel="icon" href="https://phpsandbox.io/assets/img/brand/phpsandbox.png">
    <link rel="stylesheet" href="https://assets.ubuntu.com/v1/vanilla-framework-version-4.15.0.min.css" />   
</head>
<body>

<section style="text-align: center; padding: 20px;">
  <div style="display: inline-block; text-align: left;">
    <div style="margin-bottom: 20px;">
      <h1>Thank You!</h1>
    </div>
    <div style="margin-bottom: 20px;">
      <p>Your registration has been successfully submitted. Your details are all set!</p>
      <table aria-label="Session Data" style="margin: 0 auto; border-collapse: collapse;">
        <thead>
                <tr>
                    <th></th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($_SESSION as $key => $val):
            ?>
                <tr>
                    <th><?php echo htmlspecialchars($key); ?></th>
                    <td><?php echo htmlspecialchars($val); ?></td>
                </tr>
            <?php
            endforeach;
            ?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

</body>
</html>