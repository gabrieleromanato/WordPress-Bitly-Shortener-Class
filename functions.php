<?php
require_once( TEMPLATEPATH . '/inc/BitlyShortener.php' );

/* Usage in The Loop:
 * <?php $permalink = get_permalink(); ?>
 * <a href="<?php bitly_shortener( $permalink ); ?>">Short link</a>
 */

if( !function_exists( 'bitly_shortener' ) ) {
function bitly_shortener( $url ) {
	global $post;
	$post_id = $post->ID;
	$short = '';
	$link = get_post_meta( $post_id, 'bitly-link', true );
	$original_link = get_post_meta( $post_id, 'original-link', true );
	if( !empty( $link ) ) {
		if( $url == $original_link ) {
			$short = $link;
		} else {
			$shortener = new BitlyShortener( $url );
			$shortened_link = $bitly->shorten();
			update_post_meta( $post_id, 'bitly-link', $shortened_link );
			update_post_meta( $post_id, 'original-link', $url );
			
			$short = $shortened_link;
		}
	} else {
		$bitly = new BitlyShortener( $url );
		$short_link = $bitly->shorten();
		update_post_meta( $post_id, 'bitly-link', $short_link );
		update_post_meta( $post_id, 'original-link', $url );
		$short = $short_link;
	}
	echo $short;
}
}
?>
