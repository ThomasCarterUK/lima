<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>

    <?php

    $this->themeStyles();
    $this->themeScripts();

    ?>
</head>
<body>
    <div class="site-wrapper">
        <div class="site-header">
            <div class="container header-container">
                <div class="header-left">
                    <div class="logo">
                        <h1 class="logo-text"><?php echo SITE_TITLE; ?></h1>
                    </div>
                    <div class="slogan">
                        <p><?php echo SITE_DESCRIPTION; ?></p>
                    </div>
                </div>
                <div class="header-right">
                    <?php $this->menuLocation('header'); ?>
                </div>
            </div>
        </div>
        <div class="content-wrap">