<?php

    // {Docs}
    // here we will set the pathes of our folders as values to variables, that will help us if we want to change the structure of our folders
    // we don't have to go to each include '' statement and modify the path, but if we use the variables we only have to go here and change the
    // the value of that variable.  {note;- also there is feature in some editors to search for aspecific word and replace that word in all that file
    // so that feature can be used instead of creating init.php}

    // Using init.php IS BETTER
    
    
    // Error Reporting
    
    // http://php.net/manual/en/function.ini-set.php ,, http://php.net/manual/en/errorfunc.configuration.php#ini.display-errors

    ini_set("display_errors","1"); // This determines whether errors should be printed to the screen as part of the output or if they should be hidden from the user,, 1 is the default value so we hadn't to write it

    // http://php.net/manual/en/function.error-reporting.php ,, http://php.net/manual/en/errorfunc.configuration.php {that link show the default value}

    error_reporting(E_ALL); // also not important to write it because it's default value to report most of the errors

//

    include "include/DBClass.php";

// Routes
    
    $tpl   = 'include/templates';
    $langs = 'include/languages';
    $css   = 'layout/css';
    $js    = 'layout/js';

    
// Include the files

    include "$langs/english.php";
    include "$tpl/header.php";
    include $tpl . '/navbar.php';

?>