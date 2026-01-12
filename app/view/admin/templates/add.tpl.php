<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Szablony - Dodaj nowy szablon</h1>
</div>

<form class="needs-validation" action="<?= adminURL('templates', 'add_post') ?>" method="post">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nazwa</label>
      <input type="text" class="form-control" id="validationCustom01" name="name" placeholder="Nazwa szablonu" value="" required>
    	<div class="invalid-feedback">
      		Nazwa szablonu nie jest odpowiednia
    	</div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-2 mb-3">
      <label for="validationCustom02">Wybierz rodzaj szablonu</label><br>
      		<? if($global_templates): ?>
      			<table class="table table-borderless table-sm">
      				<tr>
              			<? foreach($global_templates as $global_template): ?>
              				<td style="text-align: center;">
                  				<label>
                  					<img src="data:<?= $global_template->img_type ?>;base64,<?= base64_encode($global_template->img) ?>"/><br>
                  					<input type="radio" name="global_template" value="<?= $global_template->id ?>">
                  				</label>
              				</td>
              			<? endforeach ?>
      				</tr>
      			</table>
      		<? else: ?>
      			<em>Brak szablonów do wyboru...</em>
      		<? endif ?>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('templates', 'index') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Dodaj szablon</button> 
    </div>
  </div>
</form>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>