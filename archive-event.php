<?php
get_header();
display_page_banner(array(
    'title' => 'Upcoming Events',
    'description' => "Check out what's happening at our school"
));
?>

<div class="container">
    <div class="generic-content">
        <?php
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/event');
        } ?>
        <div class="btn-viewAll">
            <?php echo paginate_links(); ?>
        </div>
        <p>View all past events <a href=" <?php echo site_url('/past-events-archive'); ?>"> here</a>.</p>
    </div>
</div>

<?php
get_footer();
?>