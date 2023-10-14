        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body mt-3">
                            <h1>Search Results</h1>

                            <?php foreach ($posts as $post): ?>
                                <div class="card my-3">
                                    <div class="card-body">
                                        <h2><a href="<?= base_url('/posts/' . $post->id) ?>"><?= $post->title ?></a></h2>
                                        <p><?= $post->username ?></p>
                                        <p><?= $post->content ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
