<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<base href="<?php echo url(); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/bootstrap-reboot.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/pagination.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/style-color.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/style.css'); ?>">
</head>
<body>
	<div class="container-fluid">
		<div class="row menu">
			<?php require('partials/menu.php'); ?>
			<div class="col-9">
				<div class="row border-bottom pt-4 ps-5 pb-3">
					<div class="col">
						<h1>Panel de Administración</h1>
					</div>
				</div>
				<div class="row">
					<div class="col p-5">
						<?php if(Session::has('errors')): ?>
							<?php $errors = Session::get('errors'); ?>
							<?php if (!is_array($errors)): ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
              						<strong><?php echo $errors; ?></strong><br>
              						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              					</div>
							<?php else: ?>
              					<?php foreach ($errors as $error => $value): ?>
                  					<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  						<strong><?php echo join(', ', $value); ?></strong><br>
                  						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  					</div>
              					<?php endforeach ?>
							<?php endif ?>
          				<?php endif ?>
          				<?php if(Session::has('success')): ?>
          					<div class="alert alert-success alert-dismissible fade show" role="alert">
          					  <strong><?php echo Session::get('success'); ?></strong><br>
          					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          					</div>
          				<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="<?php echo url('frontend/asset/js/jquery-3.7.1.min.js'); ?>"></script>
	<script src="<?php echo url('frontend/asset/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo url('frontend/asset/js/popper.min.js'); ?>"></script>
</body>
</html>
