<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Projekty - Usuń projekt</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('projects', 'delete_post', ['id' => $project->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $project->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć projekt [<strong>#<?= $project->id ?></strong>] o nazwie <strong><?= $project->name ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('projects', 'index') ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń projekt</button> 
    </div>
  </div>
</form>