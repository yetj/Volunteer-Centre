<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony globalne - Usuń szablon</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('global_templates', 'delete_post', ['id' => $template->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $template->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć szablon [<strong>#<?= $template->id ?></strong>] o nazwie <strong><?= $template->name ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('global_templates', 'index') ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń szablon</button> 
    </div>
  </div>
</form>