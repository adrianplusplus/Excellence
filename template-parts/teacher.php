<div class="box-2">
    <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h1>
    <div class="post-meta">
        <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('M j, Y'); ?> in <?php the_category(', '); ?></p>
    </div>
    <p><?php
        if (has_excerpt()) {
            echo get_the_excerpt();
        } else {
            echo wp_trim_words(get_the_content(), 30);
        }
        ?>
        <a href="<?php the_permalink(); ?>" class="link-blue">Read more</a>
    </p>
</div>