<!DOCTYPE html>
<!--
    {Docs}
    here we create two files header and footer, we split the html page between them so when we write new page that need the header and footer,
    we include them and between them we immediately write the content of the page between the two includes.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        
        <title><?php echo isset($title)? $title : 'Default'; ?></title> <!-- here if the page that the header will be included in has $title then it will be printed else the it will print Default -->
        <link rel="stylesheet" href="<?php echo $css; ?>/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>/jquery-ui.css"> <!-- jquery ui for selectbox -->
        <link rel="stylesheet" href="<?php echo $css; ?>/jquery.selectBoxIt.css"> <!-- select box plugin -->
        <link rel="stylesheet" href="<?php echo $css; ?>/front-style.css">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body>