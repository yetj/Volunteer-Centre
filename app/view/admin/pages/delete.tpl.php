<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Strony - Usuń stronę</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('pages', 'delete_post', ['id' => $page->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $page->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć stronę [<strong>#<?= $page->id ?></strong>] o nazwie <strong><?= $page->title ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('pages', 'index') ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń stronę</button> 
    </div>
  </div>
</form>