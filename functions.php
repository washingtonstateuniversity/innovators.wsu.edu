<?php

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
add_filter( 'the_excerpt', 'ucomm_the_excerpt' );
	function ucomm_the_excerpt( $excerpt ) {
		$excerpt = trim( $excerpt );
			if ( '</p>' === substr( $excerpt, -4 ) ) {
		$excerpt = substr( $excerpt, 0, -4 ); // strip </p>	
		$excerpt = $excerpt . ' <a href="<?php echo get_permalink(); ?>">...read more</a></p>';
	}
	return $excerpt;
}