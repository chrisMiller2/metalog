<?php
session_start();
session_destroy();
echo 'You have been inactive, so we logged you 
out because it is fun to see you login again and again and again... :)';
echo '<a href="login.html">Return to the login page</a>';
header("location: login.html");