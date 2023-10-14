        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-body px-5 mt-4">
                            <div class="title mb-4">
                                <h2>Edit Post</h2>
                            </div>

                            <?php echo form_open(base_url().'post-edit/post'); ?>
                                <div class="form-group">
                                    <?php echo form_label('', 'title');?>
                                    <?php echo form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control mb-4', 'required' => 'required', 'id' => 'title-input']); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo form_label('', 'content');?>
                                    <?php echo form_textarea(['name' => 'content', 'placeholder' => 'Content', 'class' => 'form-control', 'required' => 'required', 'id' => 'content-input']); ?>
                                </div>
                                <div id="dropzone">
                                    <p>Upload one image at a time by dragging and dropping it onto the dashed region</p>
                                    <input type="hidden" name="images[]" id="images-input" multiple>
                                    <div id="image-preview"></div>
                                </div>

                                <div class="form-group mt-5">
                                    <?php echo form_label('Course: ', 'courses');?>
                                    <div class="btn-group" data-toggle="buttons">
                                        <?php foreach ($user_courses as $course): ?>
                                            <label class="btn btn-outline-primary">
                                                <input type="radio" name="course" value="<?php echo $course->course_code ?>">
                                                <?php echo $course->course_code ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php echo form_submit(['name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-primary mt-4']); ?>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            function previewFile(file) {
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    let img = $('<img>');
                    img.attr('src', reader.result);
                    $('#image-preview').append(img);
                };
            }
            
            $('#dropzone').on('drop', function(e) {
                e.stopPropagation();
                e.preventDefault();
                this.classList.remove('highlight');
                let files = e.originalEvent.dataTransfer.files;
                let formData = new FormData();
                files = [...files];
                files.forEach(file => {
                    formData.append('images[]', file);
                });
                files.forEach(previewFile);
                $.ajax({
                    url: '<?php echo base_url('post-edit/upload-image'); ?>',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            console.log(data.success);
                            // var imagePaths = data.imagePaths;
                            $('#images-input').val(data.imagePaths);
                            console.log($.isArray($('#images-input').val()));
                        } else {
                            console.log(data.fail);
                        }
                    }
                });
            });

            $('#dropzone').on('dragenter', function(e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).addClass('highlight');
            });

            $('#dropzone').on('dragover', function(e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).addClass('highlight');
            });

            $('#dropzone').on('dragleave', function(e) {
                e.stopPropagation();
                e.preventDefault();
                $(this).removeClass('highlight');
            });
        });
    </script>

