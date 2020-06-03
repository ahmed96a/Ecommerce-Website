<?php

// test file to access a file outside public_html and print it's content
// we cant go directly to that file that is outside the public_html with url like = https://asd-commerce.000webhostapp.com/../test/test.php
// but we can include that file in our code so we can use that advatage to store our imprtant data so no one can access it through the internet

$content = file_get_contents("../Test_Outside_Public_html/Outside_Public_html.txt");
echo "$content";

?>