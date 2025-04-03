<?php
function load_files()
{
    wp_enqueue_style('school_home_stylesheet', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('school_stylesheet2', get_theme_file_uri('/build/index.css'));

    //load font awesome icons
    wp_enqueue_style('font_awesome_icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

    wp_enqueue_style('school_fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Rubik:wght@300;400;500;600;700&display=swap');
    wp_enqueue_style('school_stylesheet', get_stylesheet_uri());

    wp_enqueue_script('school_js', get_theme_file_uri('/build/index.js'), NULL, '1.0', true);
    wp_localize_script('school_js', 'siteData', array(
        'root_url' => get_site_url()
    ));

    wp_enqueue_style('school_stylesheet', get_stylesheet_uri());
}

function school_features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('teacher_portrait', 180, 270, true);
    add_image_size('teacher_landscape', 220, 180, array( 'left', 'top'));
    add_image_size('page_banner', 1500, 700, true);
    register_nav_menu('header-menu', ('Header Menu'));
    register_nav_menu('footer-menu', ('Footer Menu'));
}

function display_page_banner($args = NULL)
{
    // Check if $args is null and set default values
    if ($args == NULL) {
        $args = array(
            'title' => false,
            'description' => false,
            'image' => false
        );
    }

    if ((isset($args['title']) && $args['title'] == false) || !isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if ((isset($args['description']) && $args['description'] == false) || !isset($args['description'])) {
        $args['description'] = get_field('description');
    }

    if ((isset($args['image']) && $args['image'] == false) || !isset($args['image'])) {
        if (get_field('background_image')) {
            $backgroundImage = get_field('background_image');
            $args['image'] = $backgroundImage["sizes"]["page_banner"];
        } else
            $args['image'] =  get_theme_file_uri('/assets/images/banner.jpg');
    }
?>
    <!-- Banner Section -->
    <div class="image-and-banner">
        <img class="image" src="<?php echo $args['image'] ?>" alt="" />
        <div class="banner-section">
            <div class="banner">
                <h1 class="banner-primary"><?php echo $args['title']; ?></h1>
                <h2 class="banner-description"><?php echo $args['description']; ?></h2>
            </div>
        </div>
    </div>
<?php
}

function alter_school_queries($query)
{
    if (!is_admin() and is_post_type_archive('event') && $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', [[
            'key' => 'event_date',
            'compare' => '>=',
            'value' => date('Ymd'),
            'type' => 'numeric'
        ]]);
    }
}

function school_custom_rest(){
    register_rest_field('post', 'author_name', array(
        'get_callback' => function(){ return get_the_author(); }
    ));
}

add_action('wp_enqueue_scripts', 'load_files');
add_action('after_setup_theme', 'school_features');
add_action('pre_get_posts', 'alter_school_queries');

add_action('rest_api_init', 'school_custom_rest');