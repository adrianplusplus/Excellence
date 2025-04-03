<?php
get_header();
display_page_banner(array(
    'title' => 'All Courses',
    'description' =>'Check out the list of courses we offer and find one you like!'
));
?>


<div class="container">
    <div class="generic-content">
        <?php
        while (have_posts()) {
            the_post();  ?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <br>
        <?php
        }
        ?>
        <div class="btn-viewAll">
            <?php echo paginate_links(); ?>
        </div>
    </div>
</div>

<?php
get_footer();
?>