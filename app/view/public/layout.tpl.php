<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/additional.css">

	<title><?=$title?></title>
</head>
<body>
	<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
		<h5 class="my-0 mr-md-auto font-weight-normal"><?= $projectTitle ?></h5>
		<nav class="my-2 my-md-0 mr-md-3">
			<? if($pages): ?>
			<? foreach($pages as $page): ?>
				<? if(in_array($page->slug, ["apply", "register"])):?>
					<a class="btn btn-outline-success <? if($active == $page->slug):?>active<? endif ?>" href="<?=publicURL($url, 'index', 'page', ['show' => $page->slug])?>"><?=$page->title?></a>
				<? else: ?>
					<a class="btn btn-outline-info <? if($active == $page->slug):?>active<? endif ?>" href="<?=publicURL($url, 'index', 'page', ['show' => $page->slug])?>"><?=$page->title?></a>
				<? endif ?>
			<? endforeach ?>
			<? endif ?>
			<a href="<?= publicURL($url, 'index','login') ?>" class="btn btn-outline-primary">Zaloguj</a>
		</nav>
		
		  <!-- loginModal -->
			<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				<form class="form-signin">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Zaloguj się</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">

					
					  <div class="form-label-group">
						<input type="email" id="inputEmail" class="form-control" placeholder="Adres e-mail" required="" autofocus="">
						<label for="inputEmail" class="noselect">Adres e-mail</label>
					  </div>

					  <div class="form-label-group">
						<input type="password" id="inputPassword" class="form-control" placeholder="Hasło" required="">
						<label for="inputPassword" class="noselect">Hasło</label>
					  </div>

					  <div class="checkbox mb-3">
						<label>
						  <input type="checkbox" value="remember-me"> Pamiętaj mnie
						</label>
					  </div>
					
				  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Anuluj</button>
					<button type="submit" class="btn btn-primary">Zaloguj</button>
				  </div>
				  </form>
				</div>
			  </div>
			</div>
	</div>
	<main role="main">
		<? if(count($errors)): ?>
			<? foreach($errors as $error): ?>
				<div class="alert alert-error">
					<span class="icon icon-exclamation-sign"></span> <?=$error?>
				</div>
			<? endforeach; ?>
		<? endif; ?>
		
		<?=$content?>
		
		<footer class="container">
			<hr class="featurette-divider">
			<p class="float-right"><a href="#">Wróc na górę</a></p>
			<p>&copy; <?= date("Y") ?> <a href="<?=publicURL('global')?>">Volunteer centre</a> &middot; <a href="<?=publicURL('global', 'index', 'page', ['show' => 'polityka-prywatnosci'])?>">Polityka prywatności</a> &middot; <a href="<?=publicURL('global', 'index', 'page', ['show' => 'regulamin'])?>">Regulamin</a></p>
      </footer>
	</main>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
	<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
	
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
</body>
</html>