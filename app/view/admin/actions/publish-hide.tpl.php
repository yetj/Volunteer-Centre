<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Akcje - <?= $action->status == 0 ? "Opublikuj" : "Ukryj" ?> akcję</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('actions', 'publish_post', ['id' => $action->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $action->id ?>">
	<input type="hidden" name="status" value="<?= $action->status == 0 ? 1 : 0 ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz <?= $action->status == 0 ? "opublikować" : "ukryć" ?> akcję [<strong>#<?= $action->id ?></strong>] o nazwie <strong><?= $action->name ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('actions', 'index') ?>">Anuluj</a>
		<button class="btn btn-<?= $action->status == 0 ? "success" : "danger" ?>" type="submit"><?= $action->status == 0 ? "Opublikuj" : "Ukryj" ?> akcje</button> 
    </div>
  </div>
</form>