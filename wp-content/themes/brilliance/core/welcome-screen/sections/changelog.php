<?php
/**
 * Changelog
 */

$brilliance = wp_get_theme( 'brilliance' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$brilliance_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$brilliance_changelog_lines = explode( PHP_EOL, $brilliance_changelog );
	foreach ( $brilliance_changelog_lines as $brilliance_changelog_line ) {
		if ( substr( $brilliance_changelog_line, 0, 3 ) === "###" ) {
			echo '<h4>' . substr( $brilliance_changelog_line, 3 ) . '</h4>';
		} else {
			echo $brilliance_changelog_line, '<br/>';
		}


	}

	echo '<hr />';


	?>

</div>