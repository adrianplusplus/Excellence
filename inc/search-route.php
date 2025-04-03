<?php

function school_rest_api()
{
    register_rest_route('excellence/v1', 'search', array(
        'method' => 'WP_REST_SERVER::READABLE',
        'callback' => 'school_search_results'
    ));
}

function school_search_results($request)
{
    $args = array(
        'post_type' => array('post', 'page', 'course', 'teacher', 'event'),
        'posts_per_page' => -1,
        's' => sanitize_text_field($request['term'])
    );
    $allPosts = new WP_Query($args);
    $allResults = array(
        'posts' => array(),
        'pages' => array(),
        'courses' => array(),
        'teachers' => array(),
        'events' => array()
    );

    while ($allPosts->have_posts()) {
        $allPosts->the_post();
        if (get_post_type() == 'post') {
            array_push($allResults['posts'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'author' => get_the_author()
            ));
        }
        if (get_post_type() == 'page') {
            array_push($allResults['pages'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
        if (get_post_type() == 'course') {
            array_push($allResults['courses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_id()
            ));
        }
        if (get_post_type() == 'teacher') {
            array_push($allResults['teachers'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'thumbnail')
            ));
        }
        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $excerpt = null;
            if (has_excerpt()) {
                $excerpt = get_the_excerpt();
            } else {
                $excerpt = wp_trim_words(get_the_content(), 20);
            }
            array_push($allResults['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'excerpt' => $excerpt,
                'date' => $eventDate->format('d'),
                'month' => $eventDate->format('M')
            ));
        }
    }
    wp_reset_query();
    if ($allResults['courses']) {
        //create array with relation attribute
        $metaQuery = array('relation' => 'OR',);

        //populate $metaQuery array with sub arrays for each condition
        foreach ($allResults['courses'] as $element) {
            array_push($metaQuery, array(
                'key' => 'related_courses',
                'compare' => 'LIKE',
                'value' => '"' . $element['id'] . '"'
            ));
        }

        $args = array(
            'post_type' => array('teacher', 'event'),
            'meta_query' => $metaQuery
        );

        $relatedPosts = new WP_Query($args);
        while ($relatedPosts->have_posts()) {
            $relatedPosts->the_post();
            if (get_post_type() == 'teacher') {
                array_push($allResults['teachers'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'thumbnail')
                ));
            }
            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $excerpt = null;
                if (has_excerpt()) {
                    $excerpt = get_the_excerpt();
                } else {
                    $excerpt = wp_trim_words(get_the_content(), 20);
                }
                array_push($allResults['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'excerpt' => $excerpt,
                    'date' => $eventDate->format('d'),
                    'month' => $eventDate->format('M')
                ));
            }
        }
        $allResults['teachers'] = array_values(array_unique($allResults['teachers'], SORT_REGULAR));
        $allResults['events'] = array_values(array_unique($allResults['events'], SORT_REGULAR));
    }
    return $allResults;
}

add_action('rest_api_init', 'school_rest_api');
