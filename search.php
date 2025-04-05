<?php
get_header();
display_page_banner(array(
    'title' => 'School of Excellence Blogs',
    'description' => 'Results for ' . get_search_query(),
));
?>


<div class="container">
    <div class="generic-content">
        <?php
        if (!have_posts()) {
            echo '<h3 class="results-heading">Sorry, no results match your search.</h3>';
        } else {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/' . get_post_type());
                echo '<br>';
            }
        }
        get_search_form();
        ?>
    </div>
</div>

<?php
get_footer();
?>