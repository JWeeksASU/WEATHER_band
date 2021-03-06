<?php

/**
 * All AJAX calls go here.
 */
function wpcf_ajax_embedded() {

    if ( isset( $_REQUEST['_typesnonce'] ) ) {
        if ( !wp_verify_nonce( $_REQUEST['_typesnonce'], '_typesnonce' ) ) {
            die( 'Verification failed' );
        }
    } else {

        if ( !isset( $_REQUEST['_wpnonce'] )
                || !wp_verify_nonce( $_REQUEST['_wpnonce'],
                        $_REQUEST['wpcf_action'] ) ) {
            die( 'Verification failed' );
        }
    }

    global $wpcf;

    switch ( $_REQUEST['wpcf_action'] ) {

        case 'editor_insert_date':
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields/date.php';
            wpcf_fields_date_editor_form();
            break;

        case 'insert_skype_button':
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields/skype.php';
            wpcf_fields_skype_meta_box_ajax();
            break;

        case 'editor_callback':
            // Determine Field type and context
            $views_usermeta = false;
            if ( isset( $_GET['field_type'] ) && $_GET['field_type'] == 'usermeta' ) {
                // Group filter
                wp_enqueue_script( 'suggest' );
                $field = types_get_field( $_GET['field_id'], 'usermeta' );
                $meta_type = 'usermeta';
            } 
            elseif ( isset( $_GET['field_type'] ) && $_GET['field_type'] == 'views-usermeta' ){
                $field = types_get_field( $_GET['field_id'], 'usermeta' );
                $meta_type = 'usermeta';
                $views_usermeta = true;
            }else {
                $field = types_get_field( $_GET['field_id'] );
                $meta_type = 'postmeta';
            }
            $post_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : null;
            $shortcode = isset( $_GET['shortcode'] ) ? urldecode( $_GET['shortcode'] ) : null;
            $callback = isset( $_GET['callback'] ) ? $_GET['callback'] : false;
            if ( !empty( $field ) ) {
                // Editor
                WPCF_Loader::loadClass( 'editor' );
                $editor = new WPCF_Editor();
                $editor->frame( $field, $meta_type, $post_id, $shortcode,
                        $callback, $views_usermeta );
            }
            break;

        case 'dismiss_message':
            if ( isset( $_GET['id'] ) ) {
                $messages = get_option( 'wpcf_dismissed_messages', array() );
                $messages[] = $_GET['id'];
                update_option( 'wpcf_dismissed_messages', $messages );
            }
            break;

        case '_dismiss_message':
            if ( isset( $_GET['id'] ) ) {
                $messages = get_option( '_wpcf_dismissed_messages', array() );
                $messages[strval( $_GET['id'] )] = strval( $_GET['id'] );
                update_option( '_wpcf_dismissed_messages', $messages );
            }
            break;

        case 'pr_add_child_post':
            $output = 'Passed wrong parameters';
            if ( isset( $_GET['post_id'] )
                    && isset( $_GET['post_type_child'] )
                    && isset( $_GET['post_type_parent'] ) ) {

                $relationships = get_option( 'wpcf_post_relationship', array() );
                $post = get_post( intval( $_GET['post_id'] ) );
                if ( !empty( $post->ID ) ) {
                    $post_type = strval( $_GET['post_type_child'] );
                    $parent_post_type = strval( $_GET['post_type_parent'] );
                    $data = $relationships[$parent_post_type][$post_type];
                    /*
                     * Since Types 1.1.5
                     * 
                     * We save new post
                     * CHECKPOINT
                     */
                    $id = $wpcf->relationship->add_new_child( $post->ID,
                            $post_type );

                    if ( !is_wp_error( $id ) ) {
                        /*
                         * Here we set Relationship
                         * CHECKPOINT
                         */
                        $parent = get_post( intval( $_GET['post_id'] ) );
                        $child = get_post( $id );
                        if ( !empty( $parent->ID ) && !empty( $child->ID ) ) {

                            // Set post
                            $wpcf->post = $child;

                            // Set relationship :)
                            $wpcf->relationship->_set( $parent, $child, $data );

                            // Render new row
                            $output = $wpcf->relationship->child_row( $post->ID,
                                    $id, $data );
                        } else {
                            $output = __( 'Error creating post relationship',
                                    'wpcf' );
                        }
                    } else {
                        $output = $id->get_error_message();
                    }
                } else {
                    $output = __( 'Error getting parent post', 'wpcf' );
                }
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output . wpcf_form_render_js_validation( '#post',
                            false ),
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_save_all':
            $output = '';
            if ( isset( $_POST['post_id'] ) ) {

                $parent_id = intval( $_POST['post_id'] );
                if ( isset( $_POST['wpcf_post_relationship'][$parent_id] ) ) {
                    $wpcf->relationship->save_children( $parent_id,
                            (array) $_POST['wpcf_post_relationship'][$parent_id] );
                    $output = $wpcf->relationship->child_meta_form(
                            $parent_id, strval( $_POST['post_type'] )
                    );
                }
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                // TODO Move to conditional
                $output .= '<script type="text/javascript">wpcfConditionalInit();</script>';
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_save_child_post':
            ob_start(); // Try to catch any errors
            $output = '';
            if ( isset( $_GET['post_id'] )
                    && isset( $_GET['parent_id'] )
                    && isset( $_GET['post_type_parent'] )
                    && isset( $_GET['post_type_child'] )
                    && isset( $_POST['wpcf_post_relationship'] ) ) {

                $parent_id = intval( $_GET['parent_id'] );
                $child_id = intval( $_GET['post_id'] );
                $parent_post_type = strval( $_GET['post_type_parent'] );
                $child_post_type = strval( $_GET['post_type_child'] );
                if ( isset( $_POST['wpcf_post_relationship'][$parent_id][$child_id] ) ) {
                    $fields = (array) $_POST['wpcf_post_relationship'][$parent_id][$child_id];
                    $wpcf->relationship->save_child( $parent_id, $child_id,
                            $fields );
                    $output = $wpcf->relationship->child_row( $parent_id,
                            $child_id,
                            $wpcf->relationship->settings( $parent_post_type,
                                    $child_post_type ) );
                    if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                    // TODO Move to conditional
                    $output .= '<script type="text/javascript">wpcfConditionalInit(\'#types-child-row-'
                            . $child_id . '\');</script>';
                    }
                }
            }
            $errors = ob_get_clean();
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                    'errors' => $errors
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'errors' => $errors,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_delete_child_post':
            require_once WPCF_EMBEDDED_ABSPATH . '/includes/post-relationship.php';
            $output = 'Passed wrong parameters';
            if ( isset( $_GET['post_id'] ) ) {
                $output = wpcf_pr_admin_delete_child_item( intval( $_GET['post_id'] ) );
            }
            echo json_encode( array(
                'output' => $output,
            ) );
            break;

        case 'pr-update-belongs':
            require_once WPCF_EMBEDDED_ABSPATH . '/includes/post-relationship.php';
            $output = 'Passed wrong parameters';
            if ( isset( $_POST['post_id'] ) && isset( $_POST['wpcf_pr_belongs'][$_POST['post_id']] ) ) {
                $post_id = intval( $_POST['post_id'] );
                $updated = wpcf_pr_admin_update_belongs( $post_id,
                        $_POST['wpcf_pr_belongs'][$post_id] );
                $output = is_wp_error( $updated ) ? $updated->get_error_message() : $updated;
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_pagination':
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields-post.php';
            require_once WPCF_EMBEDDED_ABSPATH . '/includes/post-relationship.php';
            $output = 'Passed wrong parameters';
            if ( isset( $_GET['post_id'] ) && isset( $_GET['post_type'] ) ) {
                global $wpcf;
                $parent = get_post( esc_attr( $_GET['post_id'] ) );
                $child_post_type = esc_attr( $_GET['post_type'] );

                if ( !empty( $parent->ID ) ) {

                    // Set post in loop
                    $wpcf->post = $parent;

                    // Save items_per_page
                    $wpcf->relationship->save_items_per_page(
                            $parent->post_type, $child_post_type,
                            intval( $_GET[$wpcf->relationship->items_per_page_option_name] )
                    );

                    $output = $wpcf->relationship->child_meta_form(
                            $parent->ID, $child_post_type
                    );
                }
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_sort':
            $output = 'Passed wrong parameters';
            if ( isset( $_GET['field'] ) && isset( $_GET['sort'] ) && isset( $_GET['post_id'] ) && isset( $_GET['post_type'] ) ) {
                $output = $wpcf->relationship->child_meta_form(
                        intval( $_GET['post_id'] ), strval( $_GET['post_type'] )
                );
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;

        case 'pr_sort_parent':
            $output = 'Passed wrong parameters';
            if ( isset( $_GET['field'] ) && isset( $_GET['sort'] ) && isset( $_GET['post_id'] ) && isset( $_GET['post_type'] ) ) {
                $output = $wpcf->relationship->child_meta_form(
                        intval( $_GET['post_id'] ), strval( $_GET['post_type'] )
                );
            }
            if ( !defined( 'WPTOOLSET_FORMS_VERSION' ) ) {
                echo json_encode( array(
                    'output' => $output,
                ) );
            } else {
                echo json_encode( array(
                    'output' => $output,
                    'conditionals' => array('#post' => wptoolset_form_get_conditional_data( 'post' )),
                ) );
            }
            break;
        /* Usermeta */
        case 'um_repetitive_add':
            if ( isset( $_GET['field_id'] ) ) {
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields-post.php';
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/usermeta-post.php';
                $field = wpcf_admin_fields_get_field( $_GET['field_id'], false,
                        false, false, 'wpcf-usermeta' );
                if ( isset( $_GET['user_id'] ) ) {
                    $user_id = $_GET['user_id'];
                } else {
                    $user_id = wpcf_usermeta_get_user();
                }
                global $wpcf;
                $wpcf->usermeta_repeater->set( $user_id, $field );
                /*
                 * 
                 * Force empty values!
                 */
                $wpcf->usermeta_repeater->cf['value'] = null;
                $wpcf->usermeta_repeater->meta = null;
                $form = $wpcf->usermeta_repeater->get_field_form( null, true );

                echo json_encode( array(
                    'output' => wpcf_form_simple( $form )
                    . wpcf_form_render_js_validation( '#your-profile', false ),
                ) );
            } else {
                echo json_encode( array(
                    'output' => 'params missing',
                ) );
            }
            break;

        case 'um_repetitive_delete':
            if ( isset( $_POST['user_id'] ) && isset( $_POST['field_id'] ) ) {
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
                $user_id = $_POST['user_id'];

                $field = wpcf_admin_fields_get_field( $_POST['field_id'], false,
                        false, false, 'wpcf-usermeta' );
                $meta_id = $_POST['meta_id'];
                if ( !empty( $field ) && !empty( $user_id ) && !empty( $meta_id ) ) {
                    /*
                     * 
                     * 
                     * Changed.
                     * Since Types 1.2
                     */
                    global $wpcf;
                    $wpcf->usermeta_repeater->set( $user_id, $field );
                    $wpcf->usermeta_repeater->delete( $meta_id );

                    echo json_encode( array(
                        'output' => 'deleted',
                    ) );
                } else {
                    echo json_encode( array(
                        'output' => 'field or post not found',
                    ) );
                }
            } else {
                echo json_encode( array(
                    'output' => 'params missing',
                ) );
            }
            break;
        /* End Usermeta */
        case 'repetitive_add':
            if ( isset( $_GET['field_id'] ) ) {
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields-post.php';
                $field = wpcf_admin_fields_get_field( $_GET['field_id'] );
                $post_id = intval( $_GET['post_id'] );

                /*
                 * When post is new - post_id is 0
                 * We can safely set post_id to 1 cause
                 * values compared are filtered anyway.
                 */
                if ( $post_id == 0 ) {
                    $post_id = 1;
                }

                $post = get_post( $post_id );

                global $wpcf;
                $wpcf->repeater->set( $post, $field );
                /*
                 * 
                 * Force empty values!
                 */
                $wpcf->repeater->cf['value'] = null;
                $wpcf->repeater->meta = null;
                $form = $wpcf->repeater->get_field_form( null, true );

                echo json_encode( array(
                    'output' => wpcf_form_simple( $form )
                    . wpcf_form_render_js_validation( '#post', false ),
                ) );
            } else {
                echo json_encode( array(
                    'output' => 'params missing',
                ) );
            }
            break;

        case 'repetitive_delete':
            if ( isset( $_POST['post_id'] ) && isset( $_POST['field_id'] ) ) {
                require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
                $post = get_post( $_POST['post_id'] );
                $field = wpcf_admin_fields_get_field( $_POST['field_id'] );
                $meta_id = $_POST['meta_id'];
                if ( !empty( $field ) && !empty( $post->ID ) && !empty( $meta_id ) ) {
                    /*
                     * 
                     * 
                     * Changed.
                     * Since Types 1.2
                     */
                    global $wpcf;
                    $wpcf->repeater->set( $post, $field );
                    $wpcf->repeater->delete( $meta_id );

                    echo json_encode( array(
                        'output' => 'deleted',
                    ) );
                } else {
                    echo json_encode( array(
                        'output' => 'field or post not found',
                    ) );
                }
            } else {
                echo json_encode( array(
                    'output' => 'params missing',
                ) );
            }
            break;

        case 'cd_verify':

            if ( empty( $_POST['wpcf'] ) && empty( $_POST['wpcf_post_relationship'] ) ) {
                die();
            }
            WPCF_Loader::loadClass( 'helper.ajax' );
            $js_execute = WPCF_Helper_Ajax::conditionalVerify( $_POST );

            // Render JSON
            if ( !empty( $js_execute ) ) {
                echo json_encode( array(
                    'output' => '',
                    'execute' => $js_execute,
                    'wpcf_nonce_ajax_callback' => wp_create_nonce( 'execute' ),
                ) );
            }
            die();
            break;

        case 'cd_group_verify':
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/fields.php';
            require_once WPCF_EMBEDDED_INC_ABSPATH . '/conditional-display.php';
            $group = wpcf_admin_fields_get_group( $_POST['group_id'] );
            if ( empty( $group ) ) {
                echo json_encode( array(
                    'output' => ''
                ) );
                die();
            }
            $execute = '';
            $group['conditional_display'] = get_post_meta( $group['id'],
                    '_wpcf_conditional_display', true );
            // Filter meta values (switch them with $_POST values)
            add_filter( 'get_post_metadata',
                    'wpcf_cd_meta_ajax_validation_filter', 10, 4 );
            $post = false;
            if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
                $split = explode( '?', $_SERVER['HTTP_REFERER'] );
                if ( isset( $split[1] ) ) {
                    parse_str( $split[1], $vars );
                    if ( isset( $vars['post'] ) ) {
                        $post = get_post( $vars['post'] );
                    }
                }
            }
            // Dummy post
            if ( !$post ) {
                $post = new stdClass();
                $post->ID = 1;
            }
            if ( !empty( $group['conditional_display']['conditions'] ) ) {
                $result = wpcf_cd_post_groups_filter( array(0 => $group), $post,
                        'group' );
                if ( !empty( $result ) ) {
                    $result = array_shift( $result );
                    $passed = $result['_conditional_display'] == 'passed' ? true : false;
                } else {
                    $passed = false;
                }
                if ( !$passed ) {
                    $execute = 'jQuery("#wpcf-group-' . $group['slug']
                            . '").slideUp().find(".wpcf-cd-group")'
                            . '.addClass(\'wpcf-cd-group-failed\')'
                            . '.removeClass(\'wpcf-cd-group-passed\').hide();';
                } else {
                    $execute = 'jQuery("#wpcf-group-' . $group['slug']
                            . '").show().find(".wpcf-cd-group")'
                            . '.addClass(\'wpcf-cd-group-passed\')'
                            . '.removeClass(\'wpcf-cd-group-failed\').slideDown();';
                }
            }
            // Remove filter meta values (switch them with $_POST values)
            remove_filter( 'get_post_metadata',
                    'wpcf_cd_meta_ajax_validation_filter', 10, 4 );
            echo json_encode( array(
                'output' => '',
                'execute' => $execute,
                'wpcf_nonce_ajax_callback' => wp_create_nonce( 'execute' ),
            ) );
            break;

        default:
            break;
    }
    if ( function_exists( 'wpcf_ajax' ) ) {
        wpcf_ajax();
    }
    die();
}
