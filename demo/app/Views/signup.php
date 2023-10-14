        <div class="container mt-5 d-flex flex-column align-items-center justify-content-center">
            <?php if(isset($validation)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors() ?>
                </div>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error?>
                </div>
            <?php endif; ?>

            <div class="card px-5">
                <div class="card-title mt-5 ">
                    <h2 class="text-center">Signup</h2>  
                </div>
                <div class="card-body py-1">
                    <?php echo form_open(base_url().'signup/send-email'); ?>
                        <div class="form-group mb-1">
                            <?php echo form_label('Username', 'username'); ?>
                            <?php echo form_input(['name' => 'username', 'id' => 'username', 'class' => 'form-control', 'required' => 'required']); ?>
                        </div>
                        <div class="form-group mb-1">
                            <?php echo form_label('Password', 'password'); ?>
                            <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'required' => 'required']); ?>
                        </div>
                        <div class="form-group mb-1">
                            <?php echo form_label('Password Confirm', 'passconf'); ?>
                            <?php echo form_password(['name' => 'passconf', 'id' => 'passconf', 'class' => 'form-control', 'required' => 'required']); ?>
                        </div>
                        <div class="form-group mb-1">
                            <?php echo form_label('Email Address', 'email'); ?>
                            <?php echo form_input(['type' => 'email', 'name' => 'email', 'id' => 'email', 'class' => 'form-control', 'required' => 'required']); ?>
                        </div>
                        <div class="form-group d-grid my-3">
                            <?php echo form_submit(['name' => 'submit', 'value' => 'Signup', 'class' => 'btn btn-primary']); ?>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="text-center">Already have an account? <a href="<?php base_url() ?>login">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
