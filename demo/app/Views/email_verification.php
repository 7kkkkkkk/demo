		<div class="container mt-5">
			<?php if (isset($error)): ?>
				<div class="alert alert-danger"><?= $error ?></div>
			<?php endif; ?>
			<div class="card">
				<div class="card-title mt-5">
					<h2 class="text-center">Email Verification</h2>
				</div>
				<div class="card-subtitle text-body-secondary">
					<h6 class="text-center">We have sent you a email with verification code.</h6>
				</div>
				<div class="card-body px-5">
					<?php echo form_open(base_url().'check_verification') ?>
						<div class="form-group">
							<?php echo form_label('6-digit code', '', ['class' => 'col-form-label']); ?>
							<?php echo form_input('verification_code', '', ['class' => 'form-control form-control-lg', 'required' => true]); ?>
						</div>
						<div class="form-group">
							<?php echo form_hidden('source', $source); ?>
						</div>
						<div class="form-group d-grid my-3">
							<?php echo form_submit('submit', 'Submit', ['class' => 'btn btn-primary btn-block']); ?>
						</div>
					<?php echo form_close() ?>
				</div>  
			</div>    
		</div>
	</div>
