<?php
get_header();
while (have_posts()) {
    the_post();
    display_page_banner(); ?>

    <div class="container">

        <!-- Post content-->
        <div class="generic-content">
            <div class="image-and-text">
                <div class="column1">
                    <?php the_post_thumbnail('teacher_portrait'); ?>
                </div>
                <div class="column2">
                    <p><?php the_content(); ?></p>
                </div>
            </div>
        </div>

        <!-- Courses taught -->
        <?php
        $relatedCourses = get_field('related_courses');
        if ($relatedCourses) { ?>
            <br>
            <h1 class="post-title">Course(s) taught: </h1>

            <?php
            foreach ($relatedCourses as $post) {
                setup_postdata($post);
            ?>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php
            }
            wp_reset_postdata();
        } ?>

    </div>
<?php
}
get_footer();
?>