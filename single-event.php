<?php
get_header();
while (have_posts()) {
    the_post();
    display_page_banner();
?>

    <div class="container">
        <!-- Breadcrumb navigation-->
        <div class="breadcrumb-btns">
            <div class="breadcrumb-1">
                <a href="<?php echo get_post_type_archive_link('event') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Back to Events
                </a>
            </div>
            <div class="breadcrumb-2">
                <p><?php the_title(); ?></p>
            </div>
        </div>

        <!-- Post content-->
        <div class="generic-content">
            <!-- Custom Fields -->
            <?php
            $theDate = new DateTime(get_field('event_date')); ?>

            <h3>Date: <?php echo $theDate->format('M d, Y'); ?></h3>
            <h3>Location: <?php the_field('event_location'); ?></h3>
            <h3>Time: <?php the_field('event_time'); ?></h3>
            <br><br>
            <p><?php the_content() ?></p>
            <br><br>

            <?php
            $relatedCourses = get_field('related_courses');
            if ($relatedCourses) { ?>
                <br>
                <h1 class="post-title">Related Course(s): </h1>
                <?php
                foreach ($relatedCourses as $post) {
                    setup_postdata($post); ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>



    </div>
<?php
}
get_footer();
?>