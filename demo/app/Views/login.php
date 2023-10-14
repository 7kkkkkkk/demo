		<div class="container mt-5 d-flex flex-column align-items-center justify-content-center">
			<?php if (isset($success)): ?>
				<div class="alert alert-success"><?= $success ?></div>
			<?php endif; ?>
			<?php if (isset($error)): ?>
				<div class="alert alert-danger"><?= $error ?></div>
			<?php endif; ?>

			<div class="card px-5">
				<div class="card-title mt-5 ">
					<h2 class="text-center">Welcome to Student Forum</h2>
				</div>
				<div class="card-body">
					<?php echo form_open(base_url().'login/check_login'); ?>
						<div class="form-group mb-1">
							<?php echo form_label('Username', 'username', ['class' => 'col-form-label']); ?>
							<?php echo form_input('username', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<div class="form-group mb-1">
							<?php echo form_label('Password', 'password', ['class' => 'col-form-label']); ?>
							<?php echo form_password('password', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<div class="login-options d-flex justify-content-between my-3">
							<div class="form-group">
								<?php echo form_checkbox('remember', '1', false, ['class' => 'form-check-input', 'id' => 'remember']); ?>
								<?php echo form_label('Remember me', 'remember', ['class' => 'form-check-label']); ?>
							</div>
							<a href="<?php echo base_url('forgot-password'); ?>" class="card-link">Forgot password?</a>
						</div>
						<div class="form-group d-grid my-3">
							<?php echo form_submit('login', 'Log in', ['class' => 'btn btn-primary']); ?>
						</div>
					<?php echo form_close(); ?>
					<p class="text-center">Don't have an account? <a class="card-link" href="<?php echo base_url('signup'); ?>">Sign up</a></p>
				</div>
			</div>
		</div>
	</div>