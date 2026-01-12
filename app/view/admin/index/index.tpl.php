<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
          </div>
			
			<div class="row">
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile  bg-warning">
						<div class="big-icon"><span data-feather="shopping-cart"></span></div>
                        <div class="data-info">
                            <div class="desc">Projektów</div>
                            <div class="value">
								<?= $projects_waiting ?> / <?= $projects ?>
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
								<?= $members ?>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-danger">
						<div class="big-icon"><span data-feather="heart"></span></div>
                        <div class="data-info">
                            <div class="desc">Akcji</div>
                            <div class="value">
								<?= $actions ?>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="col-12 col-xl-2">
                    <div class="widget widget-tile bg-info">
						<div class="big-icon"><span data-feather="layers"></span></div>
                        <div class="data-info">
                            <div class="desc">Zgłoszeń</div>
                            <div class="value">
								<?= $applications ?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>