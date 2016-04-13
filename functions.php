<?php

function custom_excerpt_length( $length ) {
	return 18;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_filter( 'the_excerpt', 'ucomm_the_excerpt' );
	function ucomm_the_excerpt( $excerpt ) {
		$excerpt = trim( $excerpt );
			if ( '</p>' === substr( $excerpt, -4 ) ) {
		$excerpt = substr( $excerpt, 0, -4 ); // strip </p>	
		$excerpt = $excerpt . ' <a href="' . esc_url( get_permalink() ) . '">read more</a></p>';
	}
	return $excerpt;
}

add_filter( 'wsu_content_syndicate_host_data', 'innovators_filter_syndicate_host_data', 10, 2 );
/**
 * Filter the thumbnail used from a remote host with WSU Content Syndicate
 *
 * @param object $subset Data associated with a single remote item.
 * @param object $post   Original data used to build the subset.
 *
 * @return object Modified data.
 */
function innovators_filter_syndicate_host_data( $subset, $post ) {
	if ( isset( $post->featured_media ) && isset( $post->_embedded->{'wp:featuredmedia'} ) && 0 < count( $post->_embedded->{'wp:featuredmedia'} ) ) {
		$subset_feature = $post->_embedded->{'wp:featuredmedia'}[0]->media_details;
		if ( isset( $subset_feature->sizes->{'spine-medium_size'} ) ) {
			$subset->thumbnail = $subset_feature->sizes->{'spine-medium_size'}->source_url;
		} else {
			$subset->thumbnail = $post->_embedded->{'wp:featuredmedia'}[0]->source_url;
		}
	} else {
		$subset->thumbnail = false;
	}
	return $subset;
}
