<!--
    {Docs}
    here we create two files in folder languages which are english.php and arabic.php we use them to covert the site(text only) between english and arabic
    in these files we write array with the words that will be converted as keys and in english.php give then english values and in arabic.php give
    them arabic values.
-->

<?php

    $lang = array(
        
        // NavBar.php
        
        'brand'         => 'Zara',
        'dashboard'     => 'DashBoard',
        'categories'    => 'Categories',
        'items'         => 'Items',
        'members'       => 'Members',
        'statistics'    => 'Statistics',
        'logs'          => 'Logs',
        'dropdown'      => 'Ahmed',
        'edit'          => 'Edit',
        'comments'      => 'Comments',
        'settings'      => 'Settings',
        'logout'        => 'Logout',
        
        
        // members.php
        
        // Edit
        
        'editmember'    => 'Edit Member',
        'username'      => 'User Name:',
        'password'      => 'Password:',
        'email'         => 'Email:',
        'fullname'      => 'Full Name:',
        'permission'    => 'Permission:',
        'truststats'    => 'Trust Status:',
        'regstats'      => 'Register Status:'
        
    );
?>