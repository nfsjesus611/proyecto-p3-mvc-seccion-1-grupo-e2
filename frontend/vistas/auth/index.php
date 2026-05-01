<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<base href="<?php echo url(); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/style-color.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo url('frontend/asset/css/fontawesome.all.min.css'); ?>">
</head>
<body>
	<section class="intro d-flex justify-content-center align-items-center">
	  <div class="bg-image h-100">
	    <div class="mask d-flex align-items-center h-100" style="background-color: #f3f2f2;">
	      <div class="container-fluid">
	        <div class="row d-flex justify-content-center align-items-center">
	          <div class="col-12 col-lg-9 col-xl-8">
	            <div class="card" style="border-radius: 1rem;">
	              <div class="row g-0">
	                <div class="col-md-4">
						<img src="<?php echo url('frontend/asset/img/estacion-pasajeros-usuarios-Metro-Los-Teques.jpg') ?>" alt="login form" class="img-fluid" style="border-top-left-radius: 1rem; border-bottom-left-radius: 1rem;width: 100%;height: 100%;object-fit: cover;background-blend-mode: multiply;" />
	                </div>
	                <div class="col-md-8 d-flex align-items-center">
	                  <div class="card-body py-5 px-4 p-md-5">
	                  	<div class="row">
	                  		<div class="col">
	                  			<div class="row">
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
	                  			<div class="row justify-content-center align-items-center">
	                  				<div class="col w-100">
			                  			<img class="mx-auto d-block" src="<?php echo url('frontend/asset/img/DF-LiCB6_400x400.jpg') ?>" alt="login form2" style="width: 20%; height: 20%;">
	                  				</div>
	                  			</div>
	                  			<form action="<?php echo url('backend/auth/login'); ?>" method="POST" class="validate">
									<!-- <h4 class="fw-bold mb-4 text-center" style="color: #C85C57;">Inicio de Sesion</h4> -->
									<h4 class="fw-bold mb-4 text-center">Inicio de Sesion</h4>
									<div class="form-floating mb-4 flex-nowrap">
										<input class="form-control" type="email" id="email" name="email" placeholder="Correo Electronico:" data-rules="required|email">
										<label for="email">Correo Electronico:</label>
										<div class="invalid-feedback"></div>
									</div>

									<div class="input-group align-items-start password-container">
										<div class="form-floating mb-4 flex-nowrap">
											<input class="form-control password-field" type="password" id="password" name="password" placeholder="Contraseña:" data-rules="required|password">
											<label for="password">Contraseña:</label>
										</div>
										<span class="input-group-text toggle-password" style="height: 58px;">
											<i class="fa-solid fa-eye-slash p-2"></i>
										</span>
										<div class="invalid-feedback"></div>
									</div>

									<div class="row w-100 mb-3">
										<div class="col">
											<input id="btn-reset" class="form-control btn btn-warning" type="reset" value="Reestablecer">
										</div>
										<div class="col">
											<input id="btn-submit" class="form-control btn btn-success" type="submit" value="Ingresar">
										</div>
									</div>
									<p class="">
										¿No tienes cuenta?
										<a href="<?php echo url('backend/auth/register'); ?>"> Registrate Aqui.</a>
										
									</p>
									<p>
										Olvido la contraseña?
										<a href="#"> Presione Aqui.</a>
										
									</p>
			                    </form>
	                  		</div>
	                  	</div>
	                  </div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</section>
	<!-- <script src="bootstrap.esm.min.js"></script> -->
	<script src="<?php echo url('frontend/asset/js/popper.min.js'); ?>"></script>
	<script src="<?php echo url('frontend/asset/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo url('frontend/asset/js/formulario3.js'); ?>"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
		  const passwordContainers = document.querySelectorAll('.password-container');

		  passwordContainers.forEach(container => {
		    const passwordField = container.querySelector('.password-field');
		    const togglePasswordBtn = container.querySelector('.toggle-password');
		    const toggleIcon = togglePasswordBtn.querySelector('i');

		    togglePasswordBtn.addEventListener('click', function() {
		      // Alterna el tipo de input
		      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
		      passwordField.setAttribute('type', type);

		      // Alterna el ícono del ojo
		      if (type === 'password') {
		        toggleIcon.classList.remove('fa-eye');
		        toggleIcon.classList.add('fa-eye-slash');
		      } else {
		        toggleIcon.classList.remove('fa-eye-slash');
		        toggleIcon.classList.add('fa-eye');
		      }
		    });
		  });
		});
	</script>
</body>
</html>
