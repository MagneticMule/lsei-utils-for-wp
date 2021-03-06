<?php

/**
 * Defines and created the custom post object for Building a City of Literature
 *
 * @author Thomas Sweeney <magneticmule@gmail.com>
 *
 */


class PostManager {

    /**
     * The custom taxonomy for this post object. Within the context of
     * Wordpress, a taxonomy is a way to group things together. Within the context of
     * (this custom post object, a taxonomy will allow us to group together
     *
     * @link(https://codex.wordpress.org/Taxonomies)
     * @var array
    **/
    private $taxonomy;

    /**
     * An array of labels for this post type. By default, post labels are used for non-hierarchical post types and page labels for hierarchical ones.
     * if empty, 'name' is set to value of 'label', and 'singular_name' is set to value of 'name'.
     *
     * @var array
     */
    private $labels;

    /**
     * Tag identifier used by file includes and selector attributes.
     *
     * @var string
     */
    protected $tag = 'PostManager';

    /**
     * Friendly name used to identify the plugin.
     *
     * @var string
     */
    protected $name = 'postutils';

    /**
     * Current version of the plugin.
     *
     * @var string
     */
    protected $version = '0.1.1';

    /**
     * Default Constructor.
     */
    public function __construct()
    {
        $this->taxonomy = array();
        $this->labels   = array();
    }

    /**
     * Rename the standard blog admin area from "Posts to " Group Blog".
     * 
     */
    function changeBlogLabel()
    {
        global $menu;
        global $submenu;
        $menu[2][0] = 'Blog';
        $submenu['edit.php'][5][0] = 'All Posts';
        $submenu['edit.php'][10][0] = 'Add Post';
        $submenu['edit.php'][16][0] = 'Post Tags';
    }

    function changeBlogObject()
    {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Group Blog';
        $labels->singular_name = 'Blog Post';
        $labels->add_new = 'Add Blog Post';
        $labels->add_new_item = 'Add Blog post';
        $labels->edit_item = 'Edit Blog post';
        $labels->new_item = 'Blog Post';
        $labels->view_item = 'View Blog Posts';
        $labels->search_items = 'Search Blog Posts';
        $labels->not_found = 'No Blog Posts found';
        $labels->not_found_in_trash = 'No Blog Posts found in Trash';
        $labels->all_items = 'All Blog Posts';
        $labels->menu_name = 'Group Blog';
        $labels->name_admin_bar = 'Group Blog';
    }



     /**
      * Defines an array of labels to pass to the custom post type
      *
      * @see register_post_type()
      * @link https://codex.wordpress.org/Function_Reference/register_post_type. 
      */
    function buildNewsPost()
     {
         $labels = array(
            'name' => __( 'News' ),
            'singular_name' => __( 'News' ),
            'add_new' => ( 'Add News Item' ),
            'add_new_item' => ( 'Add New News Item' ),
            'edit_item' => ( 'Edit News Item' ),
            'new_item' => ( 'Add News Item' ),
            'view_item' => ( 'View News Item' ),
            'not_found' => ( 'No News found' ),
            'not_found_in_trash' => ( 'No News found in Trash' ),
            'parent_item_colon' => ( 'Parent News Item:' ),
            'menu_name' => ( 'News' ),
            );

         $customPostArgs = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => 'News Items',
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 1,
            'menu_icon' => 'dashicons-format-aside',
            'show_in_nav_menus' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => true,
            'capability_type' => 'post',
            'rewrite' => array( 'slug' => 'news' )
            );

         register_post_type( 'news', $customPostArgs );
     }

        

//      /**
//       * Creates a help tab for the News post type.
//       * @see add_help_tab()
//       * @link https://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
//       */
//       function addNewsHelpTab() {
//         $screen = get_current_screen();
//         $screenIds = array( 'edit-playscripts', 'playscripts' );

//     if ( ! in_array( $screen->id, $screenIds ) ) {
//         return;
//     }
// }

/*
    $screen->add_help_tab(
        array(
            'id'      => 'sp_overview',
            'title'   => 'Overview',
            'content' => '<p>You can add the contents of a new PlayScript by either pasting in preformatted text from
            a word processor or by using the built in word processor here. Either way, you can edit the text here using the tools
            provided.</p>'
        )
    );

    $screen->add_help_tab(
        array(
            'id'      => 'sp_video',
            'title'   => 'Video',
            'content' => '<iframe width="720" height="405" src="https://www.youtube.com/embed/Avcp4m6BkLQ?rel=0" frameborder="1" allow="autoplay; encrypted-media" allowfullscreen style="padding:20px 0 0 20px;"></iframe>'
        )
    );


    $screen->add_help_tab(
        array(
            'id'      => 'sp_support',
            'title'   => 'Support',
            'content' => '<p>If you get really stuck, email Tommy at <a href="mailto:skywriter@gmail.com">skywriter@gmail.com</a></p>'
        )
    );

/*
    // Add a sidebar to contextual help.
    // $screen->set_help_sidebar( 'For further help on Wordpress go to ' );

    }
    /*

    /**
     * 
     * @param [type] $query [description]
     */
    function addPostToQuery($query) {
        if( is_home() && $query->is_main_query() )
        {
            $query->set( 'news', 'post' );
        }
        return $query;
    }

    

    /**
     * The 'register_post_type' function needs to be called during the WP init phase of execution.
     * note, when using this in a class based plugin we need to define the callback class 
     * "which is always $this" as the first element of an array.
     * @return null
     */
    public function registerPostManager()
    {      
        add_action( 'init', array($this, 'changeBlogLabel' ));
        add_action( 'init', array($this, 'changeBlogObject' ));
        add_action( 'init', array($this, 'buildNewsPost' ));
        // add_action( "load-edit.php", array($this, 'addNewsHelpTab' ));
        // add_action( "load-post.php", array($this, 'addNewsHelpTab' ));
    }
}
