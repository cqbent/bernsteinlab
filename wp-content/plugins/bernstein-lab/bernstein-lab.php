<?php
/**
 * Plugin Name:     Bernstein Lab
 * Description:     Custom plugin for Bernstein Lab
 * Author:          Charles Bent, SYP Development
 * Author URI:      https://www.sypdevelopment.com
 * Text Domain:     bernstein-lab
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Bernstein_Lab
 */

add_action( 'init', 'research_post_type' );
add_action( 'init', 'people_post_type' );
add_action( 'init', 'publications_post_type' );
add_action( 'init', 'lab_life_post_type' );
add_action('init', 'people_roles_taxonomy');



/**
 * Research Project Post Type
 */
function research_post_type() {
	register_post_type( 'research',
		array(
			'labels'       => array(
				'name'          => __( 'Research Projects' ),
				'singular_name' => __( 'Research' )
			),
			'public'       => TRUE,
			'has_archive'  => FALSE,
			'rewrite'      => array( 'slug' => 'research', 'with_front' => false ),
			'hierarchical' => TRUE,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'page-attributes',
				'thumbnail'
			),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-portfolio'
		)
	);
}

/**
 * People Post Type
 */
function people_post_type() {
	register_post_type( 'people',
		array(
			'labels'       => array(
				'name'          => __( 'People' ),
				'singular_name' => __( 'People' )
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array('slug' => 'people/bio', 'with_front' => false),
			'hierarchical' => false,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'thumbnail'
			),
			'taxonomies' => array('category'),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-groups'
		)
	);
}

/**
 * People roles taxonomy
 */
function people_roles_taxonomy() {
	register_taxonomy('roles', 'people',
		array(
			'labels'            => array(
				'name'          => 'People Roles',
				'singular_name' => 'Role',
			),
			'rewrite'           => array(
				'slug'       => 'role',
				'with_front' => FALSE
			),
			'public'            => TRUE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => TRUE,
			'query_var'         => TRUE,
			'hierarchical'      => TRUE
		)
	);
}

/*
 * Publications Post Type
 */
function publications_post_type() {
	register_post_type( 'publications',
		array(
			'labels'       => array(
				'name'          => __( 'Publications' ),
				'singular_name' => __( 'Publication' )
			),
			'public'       => true,
			'has_archive'  => true,
			'rewrite'      => array(
				'slug'       => 'publications',
				'with_front' => false
			),
			'hierarchical' => TRUE,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'page-attributes',
				'thumbnail'
			),
			'taxonomies' => array('category'),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-book'
		)
	);
}

function lab_life_post_type() {
	register_post_type( 'lablife',
		array(
			'labels'       => array(
				'name'          => __( 'Lab Life' ),
				'singular_name' => __( 'Lab Life' )
			),
			'public'       => true,
			'has_archive'  => false,
			'rewrite'      => array('slug' => 'people/lablife', 'with_front' => false),
			'hierarchical' => false,
			'supports'     => array(
				'title',
				'author',
				'custom-fields',
				'editor',
				'thumbnail'
			),
			'not-found'    => __( 'Nothing was found. what to do?' ),
			'menu_icon'    => 'dashicons-palmtree'
		)
	);
}

// modify get_the_archive_title filter
function filter_category_title( $title ) {
	$pattern = '/.+?\:/';

	return preg_replace( $pattern, '', $title );
}

add_filter( 'get_the_archive_title', 'filter_category_title' );


function bernstein_sub_menu($attributes) {
	$output = '';
	$args = array(
		'theme_location' => 'primary_navigation',
		'container_class' => 'submenu-navigation',
		'menu_class' => 'menu-submenu',
		'echo' => FALSE,
	);
	$output = wp_nav_menu($args);
	return $output;
}
add_shortcode('sub_menu', 'bernstein_sub_menu');

/*
 * Latest News
 */
function bernstein_latest_news() {
	$logo   = '<img src="' . plugin_dir_url( __FILE__ ) . '/assets/images/bernstein_stripe.jpg" />';
	$output = '';
	$args   = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3
	);
	$query  = new \WP_Query( $args );
	if ( $query->have_posts() ) {
		$output = '
      <div class="container">
      	<h3>Latest News</h3>';
		while ( $query->have_posts() ) {
			$query->the_post();
			$img = get_the_post_thumbnail();
			if ( ! $img ) {
				$img = $logo;
			}
			$output .= '
        <div class="row">
          <div class="image col-sm-4 col-md-3">
          	<a href="' . get_the_permalink() . '">' . $img . '</a>
		  </div>
		  <div class="description col-sm-8 col-md-9">
		  	<div class="title">
            <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
            </div>
            <div class="date">' . get_the_date( 'F Y' ) . '</div>
            <div class="excerpt">' . wp_trim_excerpt() . '</div>
		  </div>        
        </div>
      ';
		}
		$output .= '</div>';
		wp_reset_postdata();
	}

	return $output;
}

add_shortcode( 'latest_news', 'bernstein_latest_news' );

/*
 * Featured research
 */
function bernstein_research_list($attributes) {
	$atts = shortcode_atts( array(
		'cols' => '12',
	), $attributes );
	$args  = array(
		'post_type'      => 'research',
		'post_status'    => 'publish',
		'orderby'        => 'menu_order'
	);
	$query = new \WP_Query( $args );
	if ( $query->have_posts() ) {
		$output = '
	  	<div class="research-list row">';
		while ( $query->have_posts() ) {
			$query->the_post();
			//$excerpt = substr(strip_tags(get_the_content()), 0, 100) . '... <a href="' . get_the_permalink() . '">Read More</a>';
			$output .= '
			<div class="col-md-'.$atts['cols'].' column">
			  <div class="row no-gutters">
				  <div class="image">
				    <a href="' . get_the_permalink() . '">'. get_the_post_thumbnail() . '</a>
				  </div>
				  <div class="content">
					  <div class="title"><a href="' . get_the_permalink() . '">'. get_the_title() . '</a></div>
					  <div class="excerpt">' . wp_trim_excerpt() . '</div>
				  </div>
			  </div>
			</div>
		  	';
		}
		$output .= '</div>';
		wp_reset_postdata();
	}

	return $output;
}
add_shortcode( 'research_list', 'bernstein_research_list' );

/**
 * People list
 */

function bernstein_people_by_role() {
	$output = '';
	// first get taxonomy terms
	$roles = get_terms('roles');
	// next iterate thru each role
	foreach($roles as $role) {
		$args = array(
			'post_type'   => 'people',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query'   => array(
				array(
					'taxonomy' => 'roles',
					'terms'    => $role->term_id,
					'field'    => 'term_id'
				)
			)
		);
		$list = bernstein_people_list($args);
		if ($list) {
			$output .= '<h3>'.$role->name.'</h3>'.$list;
		}
	}
	return '<div class="people-list">' .$output . '</div>';
}

function bernstein_people_list($args) {
	$output = '';
	/*
	$args  = array(
		'post_type' => 'people',
		'post_status' => 'publish',
		'meta_key' => 'role',
		'orderby' => 'meta_value',
		'order' => 'ASC'
	);
	*/
	$query = new \WP_Query( $args );
	if ( $query->have_posts() ) {
		$role = '';
		while ( $query->have_posts() ) {
			$query->the_post();
			$interests_content = '';
			$bio = get_the_content();
			if ($bio) {
				$title = '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
				$bio_link = '<a href="' . get_the_permalink() . '">Bio</a>';
			}
			else {
				$title = get_the_title();
				$bio_link = '';
			}
			$img          = get_the_post_thumbnail();
			$email_link   = get_field( 'email' ) ? '<a href="mailto:' . get_field( 'email' ) . '" target="_blank">' . get_field( 'email' ) . '</a>' : '';
			$web_link     = get_field( 'website' ) ? '<a href="' . get_field( 'website' ) . '" target="_blank">' . get_field( 'website' ) . '</a>' : '';
			$interests = get_the_category_list(', ');
			if ($interests && $interests != 'Uncategorized') {
				$interests_content = 'Interests: ' . strip_tags($interests);
			}
			/*
			if ($role != get_field('role')) {
				$role = get_field('role');
				$output .= '<h3>'.$role[0].'</h3>';
			}
			*/
			$output       .= '
		    <div class="row">
		    	<div class="col-md-5">
			        ' . $img . '
				</div>
	          	<div class="col-md-7">
					<h4>' . $title . '</h4>
					<div class="job-title">' . get_field( 'job_title' ) . '</div>
					<div class="organization">' . get_field( 'organization' ) . '</div>
					<div class="email">' . $email_link . '</div>
					<div class="interests">'.$interests_content.'</div>
					<div class="bio">'.$bio_link.'</div>
				</div>
		    </div>
		  ';
		}
		//$output .= '</div>';
		wp_reset_postdata();
	}

	return $output;
}

add_shortcode( 'people_list', 'bernstein_people_by_role' );

function bernstein_research_people($object) {
	$output = '';
	if ($object) {
		$output = '<ul>';
		foreach($object as $post) {
			$output .= '<li>'.get_the_title($post->ID).'</li>';
		}
		$output .= '</ul>';
	}
	return $output;
}

function bernstein_research_publications($publications) {
	$output = '';
	//var_dump($publications);
	if ($publications) {
		foreach($publications as $pub) {
			setup_postdata($pub);
			$output .= '
			<div class="publications-list">
				<div class="image"><a href="'.get_the_permalink($pub->ID).'">'.get_the_post_thumbnail($pub->ID, 'full').'</a></div>
				<div class="content">
					<div class="title"><a href="'.get_the_permalink($pub->ID).'">'.get_the_title($pub->ID).'</a></div>
					<div class="excerpt">'.get_the_excerpt($pub->ID).'</div>
				</div>
			</div>
			';
		}
		wp_reset_postdata();
	}
	return $output;
}

function bernstein_lab_life_list() {
	$output = '';
	$logo   = '<img src="' . plugin_dir_url( __FILE__ ) . '/assets/images/bernstein_stripe.jpg" />';
	$args   = array(
		'post_type'      => 'lablife',
		'post_status'    => 'publish',
		'posts_per_page' => -1
	);
	$query  = new \WP_Query( $args );
	if ( $query->have_posts() ) {
		$output = '
      <div class="lab-life-list container">';
		while ( $query->have_posts() ) {
			$query->the_post();
			$img = get_the_post_thumbnail();
			if ( ! $img ) {
				$img = $logo;
			}
			$output .= '
			<div class="row">
		        <div class="col-sm-4 column">
		          <a href="' . get_the_permalink() . '">' . $img . '</a>
		        </div>
		        <div class="col-sm-8">
	              <h4 class="title">
		            <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
		          </h4>
		          <div class="date">' . get_the_date( 'F Y' ) . '</div>
		          <div class="excerpt">' . wp_trim_excerpt() . '</div>
		        </div>
	        </div>
      ';
		}
		$output .= '</div>';
		wp_reset_postdata();
	}

	return $output;
}
add_shortcode( 'lab_life_list', 'bernstein_lab_life_list' );
