<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body>
    <header>
        <nav>
            <div class="menu-icon">
                <span class="fas fa-bars"></span>
            </div>
            <div class="logo">
                School of <br> <span> Excellence</span>
            </div>
            <div class="nav-items">
                <!--
                <?php
                $args = array(
                    'theme_location' => 'header-menu'
                );

                wp_nav_menu($args);
                ?>
                -->
                <li <?php if(is_front_page()) echo 'class="current-menu-item"'?>><a href="<?php echo site_url();?>">Home</a></li>
                <li <?php if(get_post_type() == 'post') echo 'class="current-menu-item"'?>><a href="<?php echo site_url('/blog');?>">Blog</a></li>
                <li <?php if(is_page('about-us') or wp_get_post_parent_id(0) == 12) echo 'class="current-menu-item"'?>><a href="<?php echo site_url('/about-us');?>">About</a></li>
                <li <?php if(get_post_type() == 'course') echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link('course') ?>">Courses</a></li>
                <li <?php if(get_post_type() == 'event' or is_page('past-events-archive')) echo 'class="current-menu-item"'?>><a href="<?php echo get_post_type_archive_link('event') ?>">Events</a></li>
                <li><a href="#">Blog</a></li>  

                <li><a class="sm-btn" href="#">Login</a></li>
                <li><a class="sm-btn position" href="#">Sign Up</a></li>
            </div>
            <div class="cancel-icon">
                <span class="fas fa-times"></span>
            </div>
            <div class="search-icon">
                <span class="fas fa-search"></span>
            </div>
        </nav>
    </header>