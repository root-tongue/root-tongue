<?php

add_action( 'wpmdb_migration_complete', function ( $type, $location ) {
	$current_user = wp_get_current_user()->display_name;
	// this happens on the remote side
	if ( empty( $current_user ) ) {
		return;
	}
	$direction = $type == 'pull' ? 'from' : 'to';
	$message      = "$current_user {$type}ed the database $direction $location";
	rt_send_to_slack( $message );
}, 10, 2 );


function rt_send_to_slack( $message, $icon = ":rocket:" ) {
	$data = "payload=" . json_encode( array(
			"channel"    => "#root-tongue",
			"text"       => $message,
			"icon_emoji" => $icon
		) );

	// You can get your webhook endpoint from your Slack settings
	$ch = curl_init( "https://hooks.slack.com/services/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" );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$result = curl_exec( $ch );
	curl_close( $ch );

	// Laravel-specific log writing method
	// Log::info("Sent to Slack: " . $message, array('context' => 'Notifications'));

	return $result;
}