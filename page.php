<?php
get_header();
display_page_banner() 
?>


<div class="container">
    <!-- breadcrumb navigation-->
    <?php
    $parentPage = wp_get_post_parent_id(get_the_ID());

    if ($parentPage) { ?>
        <div class="breadcrumb-btns">
            <div class="breadcrumb-1">
                <a href="<?php echo get_permalink($parentPage) ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parentPage) ?>
                </a>
            </div>
            <div class="breadcrumb-2">
                <p><?php the_title() ?></p>
            </div>
        </div>
    <?php }
    ?>

    <!-- sidebar navigation-->
    <?php
    $childrenPages = get_pages(array(
        'child_of' => get_the_ID()
    ));
    if ($childrenPages or $parentPage) { ?>
        <div class="sidebar">
            <h2 class="sidebar-title">
                <a href="<?php echo get_permalink($parentPage) ?>"><?php echo get_the_title($parentPage) ?></a>
            </h2>
            <ul class="sidebar-links">
                    <?php
                    if ($parentPage) {
                        $parentId = $parentPage;
                    } else {
                        $parentId = get_the_ID();
                    }
                    wp_list_pages(array(
                        'title_li' => NULL,
                        'child_of' => $parentId,
                        'sort_column' => 'menu_ordering',
                    ));
                    ?>
            </ul>
        </div>
    <?php }
    ?>



    <!-- page content -->
    <div class="generic-content">
        <p>
            <?php the_content(); ?>
        </p>
        <br />
    </div>

    <!-- Teachers -->
    <div class="box-1">
        <h2 class="headline">Teachers:</h2>
        <ul class="page-flex">
            <li class="teacher-image">
                <img src="assets/images/teacher1.jpg" alt="">
                <h1 class="teacher-name"><a href="#">Dr. John Doe</a></h1>
            </li>
            <li class="teacher-image">
                <img src="assets/images/teacher2.jpg" alt="">
                <h1 class="teacher-name"><a href="#">Dr. Jane Doe</a></h1>
            </li>
        </ul>
    </div>
    
</div>

<?php
get_footer();
?>