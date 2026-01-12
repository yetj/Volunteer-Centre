<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Użytkownicy</h1>
	<a href="<?= adminURL('users', 'add'); ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Dodaj nowego użytkownika</a>
</div>


			<h3>Lista użytkowników w projekcie</h3>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
				  <thead>
					<tr class="text-center">
					  <th class="align-middle" rowspan="2">#</th>
					  <th class="align-middle" rowspan="2">E-mail</th>
					  <th class="align-middle" colspan="7">Uprawnienia w projekcie</th>
					  <th class="align-middle" rowspan="2">Akcje</th>
					</tr>
					<tr class="text-center">
        				<th>Użytkownicy</th>
        				<th>Strony</th>
        				<th>Szablony</th>
        				<th>Akcje</th>
        				<th>Zgłoszenia</th>
        				<th>Ustawienia</th>
        				<th>Logi</th>
        			</tr>
				  </thead>
				  <tbody>
				  	<? if($members): ?>
				  		<? foreach($members as $member): ?>
        					<tr class="text-center">
        					  <td><?= $member->id ?></td>
        					  <td><?= $member->email ?></td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_USERS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_PAGES ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_TEMPLATES ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_ACTIONS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_APPLICATIONS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_SETTINGS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->project_access & MemberModel::PROJECT_ACCESS_LOGS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        						<a href="<?= adminURL('users', 'edit', ['id' => $member->id]) ?>" class="badge badge-pill badge-info"><span data-feather="edit-2"></span></a>
        						<a href="<?= adminURL('users', 'delete', ['id' => $member->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
        					  </td>
							</tr>
						<? endforeach ?>
					<? endif ?>
				  </tbody>
				</table>
			</div>