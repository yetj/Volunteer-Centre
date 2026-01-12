<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Zgłoszenie #<?= $app->id ?> do akcji "<?= $action->name ?>"</h1>
</div>

<em><a href="<?= adminURL('applications', 'action', ['id' => $action->id]) ?>">&laquo; wróć do listy zgłoszeń</a></em><br><br>

<? if($app): ?>
    <form class="needs-validation" novalidate action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $app->id ?>" />
      <div class="form-row">
        <div class="col-md-2 mb-3">
        	<label for="span1">Data nadesłania zgłoszenia:</label><br>
        	<span id="span1"><?= date("Y-m-d H:i:s", $app->date) ?></span>
        </div>
        <div class="col-md-4 mb-3">
          <label for="select1">Status</label>
          <div class="input-group">
              <select name="status" class="form-control" id="select1">
        		<option value="0" <?= $app->status == 0 ? "selected='selected'" : '' ?>>Oczekuje</option>
        		<option value="1" <?= $app->status == 1 ? "selected='selected'" : '' ?>>Przyjęte</option>
        		<option value="2" <?= $app->status == 2 ? "selected='selected'" : '' ?>>Odrzucone</option>
              </select>
              <div class="input-group-append">
              	<button class="btn btn-primary" type="submit" name="status_button">Zmień status</button>
              </div>
          </div>
          <label for="text2">Wadomość zwrotna dla kandydata</label>
          <textarea rows="3" cols="10" class="form-control" id="text2" name="feedback"><?= $app->feedback ?></textarea>
        </div>
        <div class="col-md-2 mb-3">
          <label for="validationCustom02">Ocena zgłoszenia</label>
          <? if (!isset($isvoted->vote)): ?>
              <div class="input-group">
                  <select name="vote" class="form-control" id="select1">
            		<option value="0">0</option>
            		<option value="1">1</option>
            		<option value="2">2</option>
            		<option value="3">3</option>
            		<option value="4">4</option>
            		<option value="5">5</option>
            		<option value="6">6</option>
                  </select>
                  <div class="input-group-append">
                  	<button class="btn btn-primary" type="submit" name="vote_button">Oddaj głos</button>
                  </div>
              </div>
          <? else: ?>
          	<br>
        	<span id="span2">Twoja ocena: <strong><?= $isvoted->vote ?></strong></span><br>
        	<span id="span2">Oddanych głosów: <strong><?= $avgVote->num ?></strong></span><br>
        	<span id="span2">Średnia ocena: <strong><?= round($avgVote->sum/$avgVote->num, 2) ?></strong></span><br>
          <? endif ?>
        </div>
      </div>
    </form>
    
    <h5>Odpowiedzi:</h5>
    
    <table class="table table-sm">
    	<thead>
        	<tr>
        		<th style="width:30%;">Pytanie</th>
        		<th>Odpowiedź</th>
        	</tr>
        </thead>
    	<tbody>
    		<? foreach($app_replys as $app_reply): ?>
    			<tr>
    				<td><?= $app_reply->name ?></td>
    				<td><?= $app_reply->value ?></td>
    			</tr>
    		<? endforeach; ?>
    	</tbody>
    </table>
    
    <br>
    <h5>Komentarze:</h5>
    <form class="needs-validation" novalidate action="" method="post">
    	<input type="hidden" name="id" value="<?= $app->id ?>" />
    	<div class="form-row">
            <div class="col-md-6 mb-3">
            	<label for="span1">Dodaj komentarz do zgłoszenia:</label><br>
        		<textarea class="form-control" name="comment"></textarea>
            </div>
            <div class="col-md-2 mb-3">
            	<button class="btn btn-primary" type="submit" name="comment_button">Dodaj komentarz</button>
            </div>
        </div>
    </form>
    <? if($comments): ?>
    	<table class="table table-sm table-striped">
    		<tr>
    			<th style="width:15%;">Autor i data</th>
    			<th>Komentarz</th>
    		</tr>
        	<? foreach($comments as $comment): ?>
        			<tr>
        				<td>
        					<strong><?= $comment->name ?></strong><br>
        					<small><?= date("Y-m-d H:i:s", $comment->date) ?></small>
        				</td>
        				<td>
        					<?= $comment->comment ?>
        				</td>
        			</tr>
        	<? endforeach ?>
    	</table>
    <? else: ?>
    	<div class="alert alert-info "><span data-feather="alert-triangle"></span> To zgłoszenie nie zostało jeszcze skomentowane...</div>
    <? endif ?>
<? else: ?>
	<div class="alert alert-warning "><span data-feather="alert-triangle"></span> Wybrane zgłoszenie nie istnieje!</div>
<? endif ?>