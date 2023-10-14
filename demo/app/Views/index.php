
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="card my-3">
                        <div class="card-body mt-3">
                            <h5>Your Courses</h5>
                            <!-- Course List -->
                            <ul class="list-unstyled" id="course-list">
                                <?php foreach ($user_courses as $course): ?>
                                    <li class="course-item p-2" data-course-code="<?php echo $course->course_code; ?>">
                                    <?php echo $course->course_code; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Add Course Form -->
                            <?= form_open(base_url('add-course'), ['class' => 'mb-3']) ?>
                            <?= form_label('Select Course:', 'course_code', ['class' => 'form-label']) ?>
                            <?php
                                $options = [];
                                foreach ($allCourses as $course) {
                                    $options[$course['course_code']] = $course['course_code'];
                                }
                                echo form_dropdown('course_code', $options, set_value('course_code'), ['class' => 'form-select']);
                            ?>
                            <div class="d-grid my-3">
                                <?= form_submit('submit', 'Add Course', ['class' => 'btn btn-primary']) ?>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-body">
                            <h6>Donation for wildlife animals in UQ</h6>
                            <!-- PayPal Button -->
                            <div id="paypal-button-container">
                                <!-- PayPal button code goes here -->
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-9">
                    <div class="card my-3">
                        <div class="card-body mt-3 p-0">
                            <div id="post-list">
                                <!-- Display the corresponding posts here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Implement paypal sdk -->
    <script src="https://www.paypal.com/sdk/js?client-id=AY_FtEGNq-l7lvk7BL7I8_kCbzRQayOmfHJ7dYmsXaOln7PVs8YDzEQTlafn-A-AXSftdV1FHQ-DNjId"></script>
    <script>
        paypal.Buttons({
            // Set up the transaction
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.00'
                        }
                    }]
                });
            },
            // Finalize the transaction
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    let transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nThank you for your kindness.');
                });
            }
        }).render('#paypal-button-container');

        $(document).ready(function() {
            var page = 1;

            function fetchPosts(courseCode) {
                $.ajax({
                    url: '<?php echo base_url("posts/fetch_posts"); ?>',
                    method: 'POST',
                    data: { courseCode: courseCode, page: page },
                    success: function(data) {
                        // Check if there are posts fetched
                        if (data.posts.length > 0) {
                            // Iterate over each post and prepare its html
                            for (var i = 0; i < data.posts.length; i++) {
                                var post = data.posts[i];

                                var postItem = '<div class="post-item px-3">' +
                                '<h4><a href="<?php echo base_url('posts/'); ?>' + post.id + '">' + post.title + '</a></h4>' +
                                '<p>' + post.content + '</p>' +
                                '</div>';

                                $('#post-list').append(postItem);
                            }
                            // Increment the page counter for the next fetch
                            page++;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(status);
                    }
                });
            }

            $('#course-list').on('click', '.course-item', function() {
                // Remove the default selected course-item
                $('.course-item').removeClass('active');
                $(this).addClass('active');
                var courseCode = $(this).data('course-code');
                $('#post-list').empty();
                page = 1;
                fetchPosts(courseCode);
            });

            // Check if the user has reached the bottom of the post-list
            function isScrollBottom() {
                var element = $('#post-list');
                return element.scrollTop() + element.innerHeight() >= element[0].scrollHeight;
            }
            // Fetch posts for the first course by default
            function activateFirstCourse() {
                var firstCourse = $('#course-list .course-item:first');
                firstCourse.addClass('active');
                var courseCode = firstCourse.data('course-code');
                fetchPosts(courseCode);
            }
            // Bind the scroll event to the post-list
            $('#post-list').on('scroll', function() {
                if (isScrollBottom()) {
                    var courseCode = $('.course-item.active').data('course-code');
                    fetchPosts(courseCode); // Fetch more posts when reaching the bottom
                }
            });

            activateFirstCourse();
        });
    </script>





