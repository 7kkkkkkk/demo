<div class="container mt-5">
	<!-- Prompt area for success/error message -->
	<?php if (isset($success)): ?>
		<div class="alert alert-success"><?= $success ?></div>
	<?php endif; ?>
	<?php if (isset($error)): ?>
		<div class="alert alert-danger"><?= $error ?></div>
	<?php endif; ?>

		<div class="container">
			<div class="card">
				<div class="card-title mt-5">
					<h2 class="text-center">Forgot Password</h2>
				</div>
				<div class="card-subtitle text-body-secondary">
					<h6 class="text-center">No worries, just a few steps to reset your password.</h6>
				</div>
				<div class="card-body px-5">
					<?php echo form_open(base_url().'forgot-password/send-email'); ?>
						<div class="form-group">
							<?php echo form_label('Username', 'username', ['class' => 'col-form-label']); ?>
							<?php echo form_input('username', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<?php echo form_submit('submit', 'Submit', ['class' => 'btn btn-primary btn-block']); ?>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>