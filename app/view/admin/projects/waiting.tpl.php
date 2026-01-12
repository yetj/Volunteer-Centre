<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Projekty - Lista</h1>
</div>
			
			<h2>Lista projektów oczekujących na akceptację</h2>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
              <thead>
                <tr class="text-center">
                  <th>#</th>
                  <th>Nazwa</th>
                  <th>Status</th>
                  <th>Akcje</th>
                </tr>
              </thead>
              <tbody>
              	<?php if ($projects): ?>
                  	<? foreach($projects as $project): ?>
                        <tr class="text-center">
                          <td><?= $project->id ?></td>
                          <td class="text-left"><?= $project->name ?></td>
                          <? if($project->status == 1): ?>
                          	<td><span class="badge badge-success">Zatwierdzony</span></td>
                          <? elseif($project->status == 2): ?>
                          	<td><span class="badge badge-danger">Odrzucony</span></td>
                          <? else: ?>
                          	<td><span class="badge badge-warning">Oczekujący</span></td>
                          <? endif ?>
                          <td>
        					<a href="<?= adminURL('projects', 'show', ['id' => $project->id]) ?>" class="badge badge-pill badge-info"><span data-feather="edit-2"></span></a>        					
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