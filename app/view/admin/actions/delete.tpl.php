<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Akcje - Usuń akcje</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('actions', 'delete_post', ['id' => $action->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $action->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć akcję [<strong>#<?= $action->id ?></strong>] o nazwie <strong><?= $action->name ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('actions', 'index') ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń akcję</button> 
    </div>
  </div>
</form>