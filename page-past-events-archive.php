<?php
get_header();
display_page_banner();
$date = date('Ymd');  //variable holds today’s date
$args = array(
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'orderby' => 'meta_value',
    'meta_key' => 'event_date',
    'meta_query' => array(
        array(
            'key' => 'event_date',
            'compare' => '<',
            'value' => $date,
            'type' => 'numeric'
        )
    )
);
//$args array of arguments for custom query
$pastEvents = new WP_Query($args);
?>
<div class="container">
    <div class="generic-content">
        <?php
        while ($pastEvents->have_posts()) {
            $pastEvents->the_post();
            get_template_part('template-parts/event');
        }
        ?>
        <div class="btn-viewAll">
            <?php echo paginate_links(['total' => $pastEvents->max_num_pages]); ?>
        </div>
    </div>
</div>
<?php
wp_reset_query();
get_footer();
?>