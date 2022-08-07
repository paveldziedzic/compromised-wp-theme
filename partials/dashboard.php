<div class="col-8">
    <button type="button" class="btn btn-outline-primary mb-3" onclick="logout()">Logout</button>

    <div class="alert alert-warning mb-3 d-none" id="response-error" role="alert"></div>

    <p>Current page: <?= $_GET['page'] ?? 1 ?></p>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Date</th>
            <th scope="col">Author</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $posts = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 3,
            'paged' => $_GET['page'] ?? 1
        ]);

        foreach ($posts->get_posts() as $post) {

            $author = get_user_by('ID', $post->post_author);
            ?>

            <tr>
                <th scope="row"><?php echo $post->ID ?></th>
                <td><?= $post->post_title ?></td>
                <td><?= $post->post_date ?></td>
                <td><?= $author->display_name ?></td>
                <td>
                    <button onclick="deletePost(event, <?= $post->ID ?>)" type="button"
                            class="btn btn-danger">Delete</button>
                </td>
            </tr>
        <?php }
        ?>
        </tbody>
    </table>

    <?php
    $max_posts = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => -1,
    ]);

    ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php foreach (range(1, ceil(count($max_posts->posts) / 3)) as $item): ?>
                <li class="page-item <?= ($_GET['page'] ?? 1) == $item ? 'active' : '' ?>">
                    <button class="page-link" onclick="load_view('dashboard', {page: <?= $item?>})">
                        <?= $item ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>