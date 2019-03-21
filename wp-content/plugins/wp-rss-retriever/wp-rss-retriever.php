<?php
/**
 * Plugin Name: WordPress RSS Feed Retriever
 * Plugin URI: https://wordpress.org/plugins/wp-rss-retriever/
 * Description: A lightweight RSS feed plugin which uses the shortcode [wp_rss_retriever] to fetch and display an RSS feed in an unordered list.
 * Version: 1.3.1
 * Author: Theme Mason
 * Author URI: https://thememason.com/
 * Text Domain: wp-rss-retriever
 * Domain Path: /languages
 * License: GPL2
 */

// Global variables
define( 'WP_RSS_RETRIEVER_VER', '1.3' );

add_action( 'wp_enqueue_scripts', 'wp_rss_retriever_css');

function wp_rss_retriever_css() {
    wp_enqueue_style('rss-retriever', plugin_dir_url( __FILE__) . 'inc/css/rss-retriever.css', $deps = false, $ver = WP_RSS_RETRIEVER_VER);
}

add_shortcode( 'wp_rss_retriever', 'wp_rss_retriever_func' );

function wp_rss_retriever_func( $atts, $content = null ){
	extract( shortcode_atts( array(
		'url' => '#',
		'items' => '10',
        'orderby' => 'default',
        'title' => 'true',
		'excerpt' => '0',
		'read_more' => 'true',
		'new_window' => 'true',
        'thumbnail' => 'false',
        'source' => 'true',
        'date' => 'true',
        'cache' => '43200',
        'dofollow' => 'false',
        'credits' => 'false'
	), $atts ) );

    update_option( 'wp_rss_cache', $cache );

    //multiple urls
     if( strpos($url, ',') !== false ) {
        $urls = explode(',', $url);
     } else {
        $urls = $url;
     }

    add_filter( 'wp_feed_cache_transient_lifetime', 'wp_rss_retriever_cache' );

    $rss = fetch_feed( $urls );

    remove_filter( 'wp_feed_cache_transient_lifetime', 'wp_rss_retriever_cache' );

    if ( !is_wp_error( $rss ) ) {
        if ($orderby == 'date' || $orderby == 'date_reverse') {
            $rss->enable_order_by_date(true);
        }
        $maxitems = $rss->get_item_quantity( $items ); 
        $rss_items = $rss->get_items( 0, $maxitems );
        if ( $new_window != 'false' ) {
            $newWindowOutput = 'target="_blank" ';
        } else {
            $newWindowOutput = NULL;
        }

        if ($orderby == 'date_reverse') {
            $rss_items = array_reverse($rss_items);
        }

        if ($orderby == 'random') {
            shuffle($rss_items);
        }
    }

    $output = '<div class="wp_rss_retriever">';
        $output .= '<ul class="wp_rss_retriever_list">';
            if ( !isset($maxitems) ) : 
                $output .= '<li>' . __( 'No items', 'wp-rss-retriever' ) . '</li>';
            else : 
                //loop through each feed item and display each item.
                foreach ( $rss_items as $item ) :
                    //variables
                    $content = $item->get_content();
                    $the_title = $item->get_title();
                    $enclosure = $item->get_enclosure();

                    //build output
                    $output .= '<li class="wp_rss_retriever_item"><div class="wp_rss_retriever_item_wrapper">';
                        //title
                        if ($title == 'true') {
                            $output .= '<a class="wp_rss_retriever_title" ' . $newWindowOutput . 'href="' . esc_url( $item->get_permalink() ) . '"' .
                                ($dofollow === 'false' ? ' rel="nofollow" ' : '') .
                                'title="' . $the_title . '">';
                                $output .= $the_title;
                            $output .= '</a>';   
                        }
                        //thumbnail
                        if ($thumbnail != 'false' && $enclosure) {
                            $thumbnail_image = $enclosure->get_thumbnail();                     
                            if ($thumbnail_image) {
                                //use thumbnail image if it exists
                                $resize = wp_rss_retriever_resize_thumbnail($thumbnail);
                                $class = wp_rss_retriever_get_image_class($thumbnail_image);
                                $output .= '<div class="wp_rss_retriever_image"' . $resize . '><img' . $class . ' src="' . $thumbnail_image . '" alt="' . $title . '"></div>';
                            } else {
                                //if not than find and use first image in content
                                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $first_image);
                                if ($first_image){    
                                    $resize = wp_rss_retriever_resize_thumbnail($thumbnail);                                
                                    $class = wp_rss_retriever_get_image_class($first_image["src"]);
                                    $output .= '<div class="wp_rss_retriever_image"' . $resize . '><img' . $class . ' src="' . $first_image["src"] . '" alt="' . $title . '"></div>';
                                }
                            }
                        }
                        //content
                        $output .= '<div class="wp_rss_retriever_container">';
                        if ( $excerpt != 'none' ) {
                            if ( $excerpt > 0 ) {
                                $output .= wp_trim_words(wp_strip_all_tags($content), $excerpt);
                            } else {
                                $output .= wp_strip_all_tags($content);
                            }
                            if( $read_more == 'true' ) {
                                $output .= ' <a class="wp_rss_retriever_readmore" ' . $newWindowOutput . 'href="' . esc_url( $item->get_permalink() ) . '"' .
                                        ($dofollow === 'false' ? ' rel="nofollow" ' : '') .
                                        'title="' . sprintf( __( 'Posted', 'wp-rss-retriever' ) . ' %s', wp_rss_retriever_convert_timezone($item->get_date()) ) . '">';
                                        $output .= __( 'Read more', 'wp-rss-retriever' ) . '&nbsp;&raquo;';
                                $output .= '</a>';
                            }
                        }
                        //metadata
                        if ($source == 'true' || $date == 'true') {
                            $output .= '<div class="wp_rss_retriever_metadata">';
                                $source_title = $item->get_feed()->get_title();
                                $time = wp_rss_retriever_convert_timezone($item->get_date());

                                if ($source == 'true' && $source_title) {
                                    $output .= '<span class="wp_rss_retriever_source">' . sprintf( __( 'Source', 'wp-rss-retriever' ) . ': %s', $source_title ) . '</span>';
                                }
                                if ($source == 'true' && $date == 'true') {
                                    $output .= ' | ';
                                }
                                if ($date == 'true' && $time) {
                                    $output .= '<span class="wp_rss_retriever_date">' . sprintf( __( 'Published', 'wp-rss-retriever' ) . ': %s', $time ) . '</span>';
                                }
                            $output .= '</div>';
                        }
                    $output .= '</div></div></li>';
                endforeach;
            endif;
        $output .= '</ul>';
        if ($credits == 'true') {
            $output .= wp_rss_retriever_get_credits();
        }
    $output .= '</div>';

    return $output;
}

add_option( 'wp_rss_cache', 43200 );

function wp_rss_retriever_cache() {
    //change the default feed cache
    $cache = get_option( 'wp_rss_cache', 43200 );
    return $cache;
}

function wp_rss_retriever_get_image_class($image_src) {
    return ' class="portrait"';
}

function wp_rss_retriever_resize_thumbnail($thumbnail) {
    if ($thumbnail){
        // check if $thumbnail contains width and height separated by x
        if (strpos($thumbnail, 'x') !== false) {
            list($thumbnail_width, $thumbnail_height) = explode('x', $thumbnail);
        } else {
            $thumbnail_width = $thumbnail;
            $thumbnail_height = $thumbnail;
        }

        $resize = ' style="width:' . $thumbnail_width . 'px; height:' . $thumbnail_height . 'px;"';
    } else {
        $resize = '';
    }
    return $resize;
}

function wp_rss_retriever_get_credits() {
    $url = 'https://thememason.com/plugins/rss-retriever/';
    $plugin = array(
            __('WordPress RSS Feed Retriever', 'wp-rss-retriever'),
            __('WordPress RSS Feed Plugin', 'wp-rss-retriever'),
            __('WordPress RSS Feed', 'wp-rss-retriever'),
            __('RSS Feed Aggregator', 'wp-rss-retriever'),
            __('RSS Feed Plugin', 'wp-rss-retriever'),
            __('RSS Feed Retriever', 'wp-rss-retriever'),
            __('Custom RSS Feed', 'wp-rss-retriever')
        );
    mt_srand(crc32(get_bloginfo('url')));
    $num = mt_rand(0, count($plugin) - 1);

    $output  = '<div class="wp_rss_retriever_credits">';
        $output .= __('Powered by', 'wp-rss-retriever') . ' <a title="' . $plugin[$num] . '" href="' . $url . '">' . $plugin[$num] . '</a>';
    $output .= '</div>';

    return $output;
}

function wp_rss_retriever_convert_timezone($timestamp) {
    $date = new DateTime($timestamp);

    // Timezone string set (ie: America/New York)
    if (get_option('timezone_string')) {
        $tz = get_option('timezone_string');
    // GMT offset string set (ie: -5). Convert value to timezone string
    } elseif (get_option('gmt_offset')) {
        $tz = timezone_name_from_abbr('', get_option('gmt_offset') * 3600, 0 );
    } else {
        $tz = 'GMT';
    }

    try {
        $date->setTimezone(new DateTimeZone($tz)); 
    } catch (Exception $e) {
        $date->setTimezone(new DateTimeZone('GMT')); 
    }

    return date_i18n(get_option('date_format') .' - ' . get_option('time_format'), strtotime($date->format('Y-m-d H:i:s')));
}

function wp_rss_retriever_load_textdomain() {
  load_plugin_textdomain( 'wp-rss-retriever', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}

add_action( 'init', 'wp_rss_retriever_load_textdomain' );