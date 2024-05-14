

<?php
$password = "123"; // replace with your password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo $hashed_password;

