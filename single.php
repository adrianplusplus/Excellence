<?php
get_header();
while (have_posts()) {
    the_post();
    display_page_banner(); ?>


    <div class="container">
        <!-- Breadcrumb navigation-->
        <div class="breadcrumb-btns">
            <div class="breadcrumb-1">
                <a href="<?php echo site_url('/blog') ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Back to Blog
                </a>
            </div>
            <div class="breadcrumb-2">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('M j, Y'); ?> in <?php the_category(', '); ?></p>
            </div>
        </div>

        <!-- Post content-->
        <div class="generic-content">
            <p><?php the_content() ?></p>
        </div>

        <!-- Previous and Next post links -->
        <div class="btn-viewAll">
            <?php
            previous_post_link('%link', '← Previous post ');
            echo str_repeat('&nbsp;', 4);
            next_post_link('%link', '  Next post →');
            ?>
        </div>
    </div>
<?php
}
get_footer();
?>