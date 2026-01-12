<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Użytkownicy - Usuń użytkownika</h1>
</div>

<form class="needs-validation" novalidate action="<?= adminURL('members', 'delete_post', ['id' => $member->id]) ?>" method="post">
	<input type="hidden" name="id" value="<?= $member->id ?>">
  <div class="form-row">
    <div class="col-md-8 mb-3">
		Czy aby na pewno chcesz usunąć użytkownika [<strong>#<?= $member->id ?></strong>] o adresie e-mail <strong><?= $member->email ?></strong>?
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('members', 'index') ?>">Anuluj</a>
		<button class="btn btn-danger" type="submit">Usuń użytkownika</button> 
    </div>
  </div>
</form>