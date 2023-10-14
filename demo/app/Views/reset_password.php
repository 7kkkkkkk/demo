		<div class="container mt-5 d-flex flex-column align-items-center justify-content-center">
			<!-- Prompt area for success/error message -->    <?php if(isset($validation)): ?>
				<div class="alert alert-danger" role="alert">
					<?php echo $validation->listErrors() ?>
				</div>
			<?php endif; ?>    

			<div class="card">
				<div class="card-title mt-5">
					<h2 class="text-center">Create New Password</h2>
				</div>
				<div class="card-body px-5">
					<?php echo form_open(base_url().'reset-password'); ?>
						<div class="form-group">
							<?php echo form_label('Password', 'password', ['class' => 'col-form-label']); ?>
							<?php echo form_password('password', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<div class="form-group">
							<?php echo form_label('Confirm Password', 'passconf', ['class' => 'col-form-label']); ?>
							<?php echo form_password('passconf', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<?php echo form_submit('submit', 'Submit', ['class' => 'btn btn-primary btn-block']); ?>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>