<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Projekty</h1>
	<a href="<?= adminURL('projects', 'add') ?>" class="btn btn-success float-right"><span data-feather="plus"></span> Dodaj nowy projekt</a>
</div>

			<div class="row">
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-warning" onclick="location.href='<?= adminURL('projects', 'waiting') ?>'" style="cursor:pointer;">
						<div class="big-icon"><span data-feather="clock"></span></div>
                        <div class="data-info">
                            <div class="desc">Oczekujące</div>
                            <div class="value">
								<?= $waiting->sum ?>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-success">
						<div class="big-icon"><span data-feather="activity"></span></div>
                        <div class="data-info">
                            <div class="desc">Aktywne</div>
                            <div class="value">
								<?= sizeof($projects) ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			
			
			<h2>Lista projektów</h2>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Nazwa</th>
                  <th>Slug</th>
                  <th>Status</th>
                  <th>Użytkowników</th>
                  <th>Akcji</th>
                  <th>Zgłoszeń</th>
                  <th>Akcje</th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($projects): ?>
                  	<? foreach($projects as $project): ?>
                        <tr class="text-center">
                          <td><?= $project->id ?></td>
                          <td class="text-left"><?= $project->name ?></td>
                          <td><?= $project->slug ?></td>
                          <? if($project->status == 1): ?>
                          	<td><span class="badge badge-success">Aktywny</span></td>
                          <? elseif($project->status == 2): ?>
                          	<td><span class="badge badge-danger">Zablokowany</span></td>
                          <? else: ?>
                          	<td><span class="badge badge-warning">Nieaktywny</span></td>
                          <? endif ?>
                          <td>1</td>
                          <td>2</td>
                          <td>3</td>
                          <td>
        					<a href="<?= adminURL('projects', 'edit', ['id' => $project->id]) ?>" class="badge badge-pill badge-info"><span data-feather="edit-2"></span></a>
        					<? if($project->slug != 'global'): ?>
        						<a href="<?= adminURL('projects', 'delete', ['id' => $project->id]) ?>" class="badge badge-pill badge-danger"><span data-feather="trash-2"></span></a>
        					<? endif ?>
        				  </td>
                        </tr>
                    <? endforeach ?>
				<? else: ?>
					<tr>
						<td colspan="7" align="center"><i>Brak projektów w bazie</i></td>
					</tr>
				<? endif ?>
				  </tbody>
				</table>
			</div>