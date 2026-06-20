<?php

function flamedrop_fetch_api_data() {
    $data = [];

    $url = 'https://api.coburns.com:2018/api/branches';
    $response = wp_remote_get( $url );

    if ( ! flamedrop_check_response( $response ) ) {
        return false;
    }

    $body = wp_remote_retrieve_body( $response );
    $last_update = wp_remote_retrieve_header( $response, 'date' );
    $locations = json_decode( $body );

    foreach ($locations as $location) {
        $id = $location->branchid;
        $location->last_WP_update = $last_update;
        $data[$id] = flamedrop_sanitize_location($location);
        // var_dump($id);
        // var_dump($data[$id]);
    }

    return $data;
}

function flamedrop_sanitize_location($location) {
    $fields = ["name", "Id", "branchid", "url"];

    $location->{"flamedrop"} = true;

    foreach ($fields as $field) {
        $location->{"flamedrop_" . $field} = $location->{$field};
        unset($location->{$field});
    }

    return $location;
}


function flamedrop_get_local_data() {
    $transient = get_transient( 'flamedrop_locations' );

    // Yep!  Just return it and we're done.
    if( ! empty( $transient ) ) {

        // The function will return here every time after the first time it is run, until the transient expires.
        return $transient;

    // Nope!  We gotta make a call.
    } else {

        $data = flamedrop_fetch_api_data();

        // Save the API response so we don't have to call again until tomorrow.
        set_transient( 'flamedrop_locations', $data, 15 * MINUTE_IN_SECONDS );

        // Return the list of subscribers.  The function will return here the first time it is run, and then once again, each time the transient expires.
        return $data;

    }
}

// Given an HTTP response, check it to see if it is worth storing.
function flamedrop_check_response( $response ) {
    // Is the response an array?
    if( ! is_array( $response ) ) { return FALSE; }

    // Is the response a wp error?
    if( is_wp_error( $response ) ) { return FALSE; }

    // Is the response weird?
    if( ! isset( $response['response'] ) ) { return FALSE; }

    // Is there a status code?
    if( ! isset( $response['response']['code'] ) ) { return FALSE; }

    // Is the status code bad?
    if( in_array( $response['response']['code'], flamedrop_bad_status_codes() ) ) { return FALSE; }

    // We made it!  Return the status code, just for posterity's sake.
    return $response['response']['code'];
}

// A list of HTTP statuses that suggest that we have data that is not worth storing.
function flamedrop_bad_status_codes() {
  return array( 404, 500 );
}
