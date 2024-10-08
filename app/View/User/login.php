<main>
	<div class="container-fluid vh-100 w-25 d-flex justify-content-center align-items-center">
		<div class="row flex-fill">
			<?php if (isset($model['message'])) { ?>
				<div class="alert alert-danger" role="alert">
					<?= $model['message']; ?>
				</div>
			<?php } ?>
			<div class="card p-3">
				<div class="card-body">
					<h3 class="card-title text-center mb-5 ">Sign In</h3>
					<form action="/" method="post" class="d-grid gap-3">
						<div class="form-group">
							<label for="username">Username</label>
							<div class="input-group flex-nowrap">
								<input type="text" class="form-control" id="username" name="username" value="<?= $_POST["username"] ?? "" ?>" placeholder="john.doe" aria-label="Username" aria-describedby="addon-wrapping" autocomplete="off">
							</div>
						</div>

						<div class="form-group mb-3">
							<label for="password">Password</label>
							<div class="input-group flex-nowrap">
								<input type="password" class="form-control" id="password" name="password" placeholder="**********" aria-label="Password" aria-describedby="addon-wrapping">
							</div>
						</div>

						<div class="d-grid gap-2">
							<button class="btn btn-primary" type="submit">Sign In</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>