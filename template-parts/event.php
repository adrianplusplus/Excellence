<div <?php if(is_front_page()) echo 'class="event"'; else echo 'class=archive-event'; ?>>
    <a class="event-date" href="<?php the_permalink(); ?>">
        <span class="month"><?php $theDate = new DateTime(get_field('event_date'));
                            echo $theDate->format('M'); ?></span>
        <span class="day"><?php echo $theDate->format('d'); ?></span>
    </a>
    <div class="content">
        <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <p class="event-discription"><?php
                                        if (has_excerpt()) {
                                            echo get_the_excerpt();
                                        } else {
                                            echo wp_trim_words(get_the_content(), 20);
                                        } ?>
            <a href="<?php the_permalink(); ?>" class="link-blue">Learn more</a>
        </p>
    </div>
</div>