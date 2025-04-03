<?php
get_header();
?>

<!-- Banner Area -->
<div class="image-and-banner">
    <img class="image" src="<?php echo get_theme_file_uri('/assets/images/banner-main.jpg'); ?>" alt="banner" />
    <div class="banner-section">
        <div class="banner">
            <h1 class="banner-primary">We believe in <br />quality education</h1>
            <p class="banner-description">Check out our courses and find your major</p>
            <a class="large-btn" href="<?php echo get_post_type_archive_link('course') ?>">Start Here</a>
        </div>
    </div>
</div>

<!-- Counters -->
<section>
    <div class="counter">
        <div class="box">
            <h1>
                <div class="value" data-target="2000">0</div>
            </h1>
            <h2>Students</h2>
        </div>
        <div class="box">
            <h1>
                <div class="value" data-target="75">0</div>
            </h1>
            <h2>Courses</h2>
        </div>
        <div class="box">
            <h1>
                <div class="value" data-target="120">0</div>
            </h1>
            <h2>Teachers</h2>
        </div>
        <div class="box">
            <h1>
                <div class="value" data-target="50">0</div>
            </h1>
            <h2>Awards</h2>
        </div>
    </div>
</section>

<section>
    <div class="two-col-split">

        <!-- Blog posts -->
        <?php
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 3
        );

        $query = new WP_Query($args);
        ?>
        <div class="blogs">
            <h1 class="heading">From Our Blogs</h1>
            <div class="box-container">
                <?php
                while ($query->have_posts()) {
                    $query->the_post(); ?>
                    <div class="box-2">
                        <div class="content">
                            <p class="date">
                                <span class="month"><?php the_time('M'); ?></span>
                                <span class="day"><?php the_time('d'); ?></span>
                                </>
                            <p class="user"><i class="fas fa-user"></i><?php the_author_posts_link(); ?></p>
                            <a href="<?php the_permalink() ?>" class="title"><?php the_title(); ?></a>
                            <p><?php echo wp_trim_words(get_the_content(), 15); ?></p>
                            <a href="<?php the_permalink(); ?>" class="link-blue">Read more</a>
                        </div>
                    </div>
                <?php }
                wp_reset_query(); ?>
            </div>
            <div class="btn-viewAll">
                <a href="<?php echo site_url('/blog'); ?>" class="btn">View All Blog Posts</a>
            </div>
        </div>

        <!-- Event posts -->
        <?php
        $date = date('Ymd');  //variable holds today’s date
        $args = array(
            'posts_per_page' => 2,
            'post_type' => 'event',
            'orderby' => 'meta_value',
            'meta_key' => 'event_date',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $date,
                    'type' => 'numeric'
                )
            )
        );

        $upcomingEvents = new WP_Query($args);
        ?>
        <div class="events">
            <h1 class="heading">Upcoming Events</h1>
            <div class="event-container">
                <?php
                while ($upcomingEvents->have_posts()) {
                    $upcomingEvents->the_post();
                    get_template_part('template-parts/event');
                }
                wp_reset_postdata(); ?>

            </div>
            <div class="btn-viewAll">
                <a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn">View All Events</a>
            </div>
        </div>
    </div>
</section>

<!-- Slideshow -->
<section>
    <div class="hero-slider check">
        <div class="slider">
            <div class="slideshow">
                <input type="radio" name="radio-btn" id="radio1" />
                <input type="radio" name="radio-btn" id="radio2" />
                <input type="radio" name="radio-btn" id="radio3" />

                <div class="slide first">
                    <img class="image" src="<?php echo get_theme_file_uri('/assets/images/graduation.jpg'); ?>" alt="graduation ceremony" />
                    <div class="info">
                        <h2>Graduation ceremony 2022</h2>
                        <p>The 98th garduation ceremony of the School of Excellence was held last month.</p>
                        <p><a href="#" class="btn">Learn more</a></p>
                    </div>
                </div>
                <div class="slide">
                    <img class="image" src="<?php echo get_theme_file_uri('/assets/images/lecture-hall'); ?>.jpg" alt="lecture hall" />
                    <div class="info">
                        <h2>Inauguration of new lecture halls</h2>
                        <p>Three new lecture halls in the Emerging Sciences building have been inaugurated.</p>
                        <p><a href="#" class="btn">Learn more</a></p>
                    </div>
                </div>
                <div class="slide">
                    <img class="image" src="<?php echo get_theme_file_uri('/assets/images/library.jpg'); ?>" alt="library" />
                    <div class="info">
                        <h2>Latest additions to the library</h2>
                        <p>Find out the new titles that have been added to our library this month.</p>
                        <p><a href="#" class="btn">Learn more</a></p>
                    </div>
                </div>

                <div class="navigation-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                </div>
            </div>

            <div class="navigation-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
            </div>
        </div>
    </div>
</section>


<?php
get_footer();
?>