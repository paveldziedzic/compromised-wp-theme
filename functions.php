<?php

declare(strict_types=1);

/**
 * Scope of the application:
 * 1. Allow guests to login to their wordpress account.
 * 2. Allow users to list published posts with pagination.
 * 3. Allow users to CRUD actions on posts.
 * 4. Allow user to log out.
 *
 * Problems that need to be addressed:
 * 1. Security and potential attacks.
 * 2. Code style.
 * 3. Potential performance issues.
 */
\add_filter('show_admin_bar', '__return_false');

\add_action('wp_ajax_nopriv_load_view', 'load_view');
\add_action('wp_ajax_load_view', 'load_view');

function load_view(): void
{
    $view = $_GET['view'] ?: false;

    if (false === $view) {
        return;
    }

    require_once "partials/{$view}.php";
    exit;
}

\add_action('wp_ajax_nopriv_login', 'login');

function login(): void
{
    $email = \filter_input(\INPUT_GET, 'email', \FILTER_SANITIZE_EMAIL);
    $password = \filter_input(\INPUT_GET, 'password', \FILTER_SANITIZE_STRING);

    if (empty($email) || empty($password)) {
        echo 'Missing email!';
        \http_response_code(400);
        exit;
    }

    $user = \wp_signon(['user_login' => $email, 'user_password' => $password]);
    if (\is_wp_error($user)) {
        echo $user->get_error_message();
        \http_response_code(400);
        exit;
    }

    \http_response_code(200);
    exit;
}

\add_action('wp_ajax_post_delete', 'post_delete');

function post_delete(): void
{
    $post_id = \filter_input(\INPUT_GET, 'post', \FILTER_SANITIZE_NUMBER_INT);

    if (empty($post_id)) {
        echo 'Invalid post id!';
        \http_response_code(400);
        exit;
    }

    $deleted = \wp_delete_post($post_id);

    if (false === $deleted) {
        echo 'Post cannot be delted';
        \http_response_code(400);
        exit;
    }

    \http_response_code(200);
    exit;
}

\add_action('wp_ajax_post_insert', 'post_insert');

function post_insert(): void
{
    $post = \json_decode(\stripslashes($_GET['post'] ?? null), true);
    $post = \filter_var_array(
        $post,
        [
            'id' => \FILTER_SANITIZE_NUMBER_INT,
            'post_content' => \FILTER_SANITIZE_STRING,
        ]
    );

    if (empty($post)) {
        echo 'Invalid post!';
        \http_response_code(400);
        exit;
    }

    $post = \wp_insert_post($post);

    if (\is_wp_error($post)) {
        echo $post->get_error_message();
        \http_response_code(400);
        exit;
    }

    \http_response_code(200);
    exit;
}

\add_action('wp_ajax_logout', 'logout');

function logout(): void
{
    \wp_logout();

    \http_response_code(200);
    exit;
}
