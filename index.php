<html lang="en_EN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="<?= get_template_directory_uri() ?>/script.js"></script>
    <?php wp_head(); ?>
</head>
<body>

<div class="container h-100">
    <div class="row h-100">
        <div class="col-12 h-100 d-flex align-items-center justify-content-center" id="app">
            <script>load_view('<?= is_user_logged_in() ? 'dashboard' : 'login' ?>')</script>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>
