        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body mt-5">

                            <div class="content px-5 mb-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2><?php echo $post->title ?></h2>
                                    <button id="bookmarkButton" data-post-id="<?php echo $post->id ?>" data-bookmarked="<?php echo $isBookmarked ? "true" : "false" ?>">
                                        <?php echo $isBookmarked ? "Unbookmark" : "Bookmark" ?>
                                    </button>
                                </div>

                                <p>
                                    Author: <?php echo $post->username?>
                                    <br>
                                    Created at: <?php echo $post->created_at ?>
                                </p>

                                <p><?php echo $post->content ?></p>

                                <?php if ($images !== NULL): ?>
                                    <!-- <?php print_r($images); ?> -->
                                    <?php foreach ($images as $image): ?>
                                        <img src="<?php echo '/demo/writable/uploads/' . $image['image_path']; ?>" alt="User Profile Picture" style="height: 200px; width: 200px;">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <hr>
                            <div class="comments mt-5 px-5">
                                <h3 class="mb-3">Comments</h3>
                                <ul class="list-unstyled">
                                    <?php foreach ($comments as $comment): ?>
                                        <li class="comment mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-2">
                                                    <img src="<?php echo $comment->filename ?>" alt="User Avatar">
                                                </div>
                                                <div class="comment-info">
                                                    <span class="username fs-6"><?php echo $comment->username ?></span>
                                                    <span class="comment-time fs-6 text-secondary"><?php echo $comment->created_at ?></span>
                                                </div>
                                            </div>
                                            <div class="comment-content my-2"><?php echo $comment->content ?></div>
                                            <div class="like-area d-flex align-items-center">
                                                <button class="like-button me-2" data-comment-id="<?php echo $comment->id ?>">Like</button>
                                                <span id="likes-<?php echo $comment->id ?>"><?php echo $comment->likes ?></span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <div class="add-comment mt-5 px-5">
                                <h3>Add Comment</h3>
                                <?php echo form_open(base_url().'add-comment'); ?>
                                    <div class="form-group">
                                        <?php echo form_input(['name' => 'post_id', 'type' => 'hidden', 'class' => 'form-control', 'value' => $post->id]); ?>
                                        <?php echo form_input(['name' => 'username', 'type' => 'hidden', 'class' => 'form-control', 'value' => session()->get('username')]); ?>
                                    </div>

                                    <div class="form-group">
                                        <?php echo form_label('', 'content');?>
                                        <?php echo form_textarea(['name' => 'content', 'placeholder' => 'Content', 'class' => 'form-control', 'required' => 'required', 'id' => 'content-input']); ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo form_submit(['name' => 'submit', 'value' => 'submit', 'class' => 'btn btn-primary mt-3']); ?>
                                    </div>
                                <?php echo form_close() ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            function commentLike(commentId) {
                let likesElement = $("#likes-" + commentId);
                let button = $("button[data-comment-id='" + commentId + "']");
                let isLiked = button.text();
                console.log(isLiked);
                $.ajax({
                    url: "<?php echo base_url('update-likes') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        commentId: commentId,
                        isLiked: isLiked
                    },
                    success: function(response) {
                        if (response.success) {
                            let likeCount = parseInt(response.likes);
                            likesElement.text(parseInt(response.likeCount));

                            if (isLiked == "Like") {
                                button.text("Unlike");
                            } else {
                                button.text("Like");
                            }
                        } else {
                            console.error("Error: " + response.message);
                        }
                    }
                });
            }

            function bookmarkPost(postId) {
                let button = $("button[data-post-id='" + postId + "']");
                let isBookmarked = button.data("bookmarked") || "false";
                $.ajax({
                    url: "<?php echo base_url('bookmark-post') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        postId: postId,
                        isBookmarked: isBookmarked
                    },
                    success: function(response) {
                        // database is also changed in the Bookmarks controller.
                        if (response.success) {
                            if (isBookmarked == "true") {
                                button.data("bookmarked", "false");
                                button.text("Bookmark");
                            } else {
                                button.data("bookmarked", "true");
                                button.text("Unbookmark");
                            }
                        } else {
                            console.error("Error: " + response.message);
                        }
                    }
                });
            }

            $("button[data-comment-id]").on("click", function() {
                var commentId = $(this).data("comment-id");
                var username = "<?php session()->get('username') ?>";
                commentLike(commentId, username);
            });

            $("#bookmarkButton").on("click", function() {
                var postId = $(this).data("post-id");
                bookmarkPost(postId);
            });
        });
    </script>