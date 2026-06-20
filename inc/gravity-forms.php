<?
// Remove Default Gravity Forms styles
add_action( 'gform_enqueue_scripts', 'gf_dequeue_stylesheets', 11 );
function gf_dequeue_stylesheets() {
    wp_dequeue_style( 'gforms_reset_css' );
    // wp_dequeue_style( 'gforms_datepicker_css' ); // Ugly datepicker > broken illegible datepicker
    wp_dequeue_style( 'gforms_formsmain_css' );
    wp_dequeue_style( 'gforms_ready_class_css' );
    wp_dequeue_style( 'gforms_browsers_css' );
}

// Force Gravity Forms to init scripts in the footer and ensure that the DOM is loaded before scripts are executed.
// Via: https://gist.github.com/eriteric/5d6ca5969a662339c4b3
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_cdata_open', 'wrap_gform_cdata_open', 1 );
add_filter( 'gform_cdata_close', 'wrap_gform_cdata_close', 99 );

function wrap_gform_cdata_open( $content = '' ) {
	if ( ! do_wrap_gform_cdata() ) {
		return $content;
	}
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ' . $content;
	return $content;
}

function wrap_gform_cdata_close( $content = '' ) {
	if ( ! do_wrap_gform_cdata() ) {
		return $content;
	}
	$content .= ' }, false );';
	return $content;
}

function do_wrap_gform_cdata() {
	if (
		is_admin()
		|| ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		|| isset( $_POST['gform_ajax'] )
		|| isset( $_GET['gf_page'] ) // Admin page (eg. form preview).
		|| doing_action( 'wp_footer' )
		|| did_action( 'wp_footer' )
	) {
		return false;
	}
	return true;
}

// Change input[type='submit'] to button
function form_submit_button( $button, $form ) {
    return "<button class='btn btn-primary' id='gform_submit_button_{$form['id']}'><span>{$form['button']['text']}</span></button>";
}
add_filter( 'gform_submit_button', 'form_submit_button', 10, 2 );


// Add Bootstrap CSS class to .gfield form groups
function gf_bootstrap_form_group_class( $classes, $field, $form ) {
    $classes .= ' form-group';
    return $classes;
}
add_filter( 'gform_field_css_class', 'gf_bootstrap_form_group_class', 10, 3 );


// Add Bootstrap .form-control class to Gravity Forms input/select elements
// * Note that we always add 'form-control ' with a space to make later find-replaces easier
// * Adapted from https://gist.github.com/brianpurkiss/60767704bd61149f17a4363dae641818
function gf_bootstrap_form_control_classes( $content, $field, $value, $lead_id, $form_id ) {

    // Check for known GF classes
    $content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
    $content = str_replace('class=\'small', 'class=\'form-control small', $content);
    $content = str_replace('class=\'large', 'class=\'form-control large', $content);

    $content = str_replace('class=\'textarea', 'class=\'textarea form-control ', $content);

    $content = str_replace('class=\'datepicker', 'class=\'datepicker form-control ', $content);

    // Use GF size picker to add Bootstrap form-control size variants
    $content = str_replace('form-control small', 'form-control small form-control-sm', $content);
    $content = str_replace('form-control large', 'form-control large form-control-lg', $content);

    // Special treatment for file uploads because Bootstrap needs them to have "form-control-file"
    if ($field['type'] == 'fileupload') {
        $content = str_replace('form-control ', 'form-control-file ', $content);
    }

    // If we already found a class to hook onto, then we don't have get into any weirder find/replaces.
    if (strpos($content, 'form-control') === false):

        switch ($field["type"]):
            case 'name':
            case 'address':
                $content = str_replace('<select', '<select class=\'form-control\'', $content);
                $content = str_replace('<input', '<input class=\'form-control\'', $content);
                break;
            case 'date':
            case 'time':
                $content = str_replace('<select', '<select class=\'form-control \'', $content);
                $content = str_replace('type=\'number\'', 'type=\'number\' class=\'form-control \'', $content);
                break;
            case 'fileupload':
                // This is only a safety net, see special case above
                $content = str_replace('type=\'file\'', 'type=\'file\' class=\'form-control-file \'', $content);
                break;
            case 'list':
                $content = str_replace('type=\'text\'', 'type=\'text\' class=\'form-control \'', $content);
                break;
            case 'checkbox':
            case 'radio':
                $content = str_replace('type=\'text\'', 'type=\'text\' class=\'form-control form-control-sm\'', $content);
                break;
            case 'textarea':
            case 'hidden':
            case 'html':
                break;
        endswitch;

    endif;

    // Add a class for the specific field type just in case.
    $content = str_replace('form-control ', 'form-control form-control--' . $field["type"] . ' ', $content);

    return $content;
}
add_filter( 'gform_field_content', 'gf_bootstrap_form_control_classes', 10, 5 );


// Add Bootstrap CSS class to form controls
// Adapted from https://gist.github.com/brianpurkiss/60767704bd61149f17a4363dae641818
function gf_bootstrap_form_structure_classes( $content, $field, $value, $lead_id, $form_id ) {
    $content = str_replace('class=\'gfield_description', 'class=\'form-text gfield_description', $content);

    switch ($field["type"]) {
        case 'name':
        case 'address':
            $content = str_replace('class=\'ginput_complex', 'class=\'form-row ginput_complex', $content);
            $content = str_replace('class=\'name_', 'class=\'col name_', $content);
            $content = str_replace('class=\'ginput_full', 'class=\'col-sm-12 ginput_full', $content);
            $content = str_replace('class=\'ginput_left', 'class=\'col-sm-6 ginput_left', $content);
            $content = str_replace('class=\'ginput_right', 'class=\'col-sm-6 ginput_right', $content);
            break;
        case 'date':
        case 'time':
            $content = str_replace('clear-multi', 'form-row clear-multi', $content);
            $content = str_replace('class=\'gfield_date_', 'class=\'col-auto gfield_date_', $content);
            $content = str_replace('class=\'gfield_time_', 'class=\'col-auto gfield_time_', $content);
            break;
        case 'textarea':
        case 'fileupload':
        case 'list':
        case 'checkbox':
        case 'radio':
        case 'hidden':
        case 'html':
    }

    return $content;
}
add_filter( 'gform_field_content', 'gf_bootstrap_form_structure_classes', 10, 5 );
