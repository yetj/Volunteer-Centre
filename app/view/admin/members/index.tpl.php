<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Użytkownicy</h1>
	<a href="<?= adminURL('members', 'add'); ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Dodaj nowego użytkownika</a>
</div>

			<div class="row">
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-success">
						<div class="big-icon"><span data-feather="users"></span></div>
                        <div class="data-info">
                            <div class="desc">Adminów</div>
                            <div class="value">
								<?= $admin_count ?>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-primary">
						<div class="big-icon"><span data-feather="users"></span></div>
                        <div class="data-info">
                            <div class="desc">Użytkowników</div>
                            <div class="value">
								<?= $member_count ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			
			<h3>Lista użytkowników</h3>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
				  <thead>
					<tr class="text-center">
					  <th class="align-middle" rowspan="2">#</th>
					  <th class="align-middle" rowspan="2">E-mail</th>
					  <th class="align-middle" rowspan="2">Nazwa</th>
					  <th class="align-middle" colspan="5">Uprawnienia globalne</th>
					  <th class="align-middle" rowspan="2">Liczba projektów</th>
					  <th class="align-middle" rowspan="2">Akcje</th>
					</tr>
					<tr class="text-center">
        				<th>Projekty</th>
        				<th>Użytkownicy</th>
        				<th>Szablony globalne</th>
        				<th>Logi</th>
        				<th>Pełny dostęp do projektów</th>
        			</tr>
				  </thead>
				  <tbody>
				  	<? if($members): ?>
				  		<? foreach($members as $member): ?>
        					<tr class="text-center">
        					  <td><?= $member->id ?></td>
        					  <td><?= $member->email ?></td>
        					  <td><?= $member->name ?></td>
        					  <td>
        					  	<? if($member->access & MemberModel::ADMIN_ACCESS_PROJECTS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->access & MemberModel::ADMIN_ACCESS_MEMEBERS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->access & MemberModel::ADMIN_ACCESS_TEMPLATES ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->access & MemberModel::ADMIN_ACCESS_LOGS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td>
        					  	<? if($member->access & MemberModel::ADMIN_ACCESS_ALL_PROJECTS ): ?>
        					  		<span class="badge badge-pill badge-success"><span data-feather="check"></span></span>
        					  	<? else: ?>
        					  		<span class="badge badge-pill badge-danger"><span data-feather="x"></span></span>
        					  	<? endif ?>
        					  </td>
        					  <td><?= $member->projects ?></td>
        					  <td>
        						<a href="<?= adminURL('members', 'edit', ['id' => $member->id]) ?>" class="badge badge-pill badge-info"><span data-feather="edit-2"></span></a>
        						<a href="<?= adminURL('members', 'delete', ['id' => $member->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
        					  </td>
							</tr>
						<? endforeach ?>
					<? endif ?>
				  </tbody>
				</table>
				<?= $this->element('pagination', ['pageConfig' => $pageConfig]) ?>
			</div>