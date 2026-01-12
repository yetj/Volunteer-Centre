<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Użytkownicy - dodaj nowego</h1>
</div>
			

<form class="needs-validation" action="<?= adminURL('members', 'edit_post', ['id' => $member->id]) ?>" method="post" novalidate>
<input type="hidden" name="id" value="<?= $member->id ?>">
  	<h5>Podstawowe informacje</h5>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationEmail">E-mail</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
        </div>
        <input type="email" class="form-control" id="validationEmail" placeholder="E-mail" value="<?= isset($post['email']) ? $post['email'] : $member->email ?>" name="email" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
          Wprowadzony adres e-mail nie jest poprawny!
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationEmail">Nazwa</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend"><span data-feather="users"></span></span>
        </div>
        <input type="text" class="form-control" placeholder="Nazwa" value="<?= isset($post['name']) ? $post['name'] : $member->name ?>" name="name" aria-describedby="inputGroupPrepend" required>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationPassword01">Hasło</label>
      <input type="password" class="form-control" id="validationPassword01" onkeyup="validatePassword(this.value);" placeholder="" value="<?= isset($post['password']) ? $post['password'] : '' ?>" name="password">
      <div class="" id="validationPassword01Msg"></div>
      <div class="invalid-feedback" id="x">
        Wprowadź hasło!
      </div>
      <div class="valid-feedback">
        Ok!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationPassword02">Potwierdź hasło</label>
      <input type="password" class="form-control" id="validationPassword02" placeholder="" value="<?= isset($post['password2']) ? $post['password2'] : '' ?>" name="password2">
      <div class="invalid-feedback">
        Potwierdź hasło!
      </div>
      <div class="valid-feedback">
        Ok!
      </div>
    </div>
  </div>
  
  <div class="form-row">
  	<div class="col-md-8 mb-3">
  	<h5>Globalne uprawnienia</h5>
  	<table class="table table-sm table-bordered">
  		<thead class="thead-light">
  			<tr class="text-center">
        		<th><label for="PROJECTS">Projekty</label></th>
        		<th><label for="MEMEBERS">Użytkownicy</label></th>
        		<th><label for="TEMPLATES">Szablony globalne</label></th>
        		<th><label for="LOGS">Logi</label></th>
        		<th><label for="ALL_PROJECTS">Pełny dostęp do projektów</label></th>
        	</tr>
  		</thead>
  		<tbody>
  			<tr class="text-center">  				
  				<td><input type="checkbox" name="access[]" id="PROJECTS" value="<?= MemberModel::ADMIN_ACCESS_PROJECTS ?>" <?= $access[1] ? 'checked="checked"' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="MEMEBERS" value="<?= MemberModel::ADMIN_ACCESS_MEMEBERS ?>" <?= $access[2] ? 'checked="checked"' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="TEMPLATES" value="<?= MemberModel::ADMIN_ACCESS_TEMPLATES ?>" <?= $access[3] ? 'checked="checked"' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="LOGS" value="<?= MemberModel::ADMIN_ACCESS_LOGS ?>" <?= $access[4] ? 'checked="checked"' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="ALL_PROJECTS" value="<?= MemberModel::ADMIN_ACCESS_ALL_PROJECTS ?>" <?= $access[5] ? 'checked="checked"' : '' ?>></td>
  			</tr>
  		</tbody>
  	</table>
  	</div>
  </div>
  
  <div class="form-row">
	  <div class="col-md-6 mb-3">
		<h5>Projekty</h5>
			<? if($projects): ?>
				<? foreach($projects as $project): ?>
        		  <div class="input-group">
        			<label><input type="checkbox" name="projects[]" value="<?= $project->id ?>" <?= isset($post['projects']) ? (in_array($project->id, $post['projects']) ? 'checked="checked"' : '') : (in_array($project->id, $member_projects) ? 'checked="checked"' : '') ?>/> <strong><?= $project->slug ?></strong> - <?= $project->name ?></label>
        		  </div>
		  		<? endforeach ?>
		  	<? endif ?>
	  </div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('members') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Edytuj użytkownika</button> 
    </div>
  </div>
</form>


<script>
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

function validatePassword(password) {
    
    // Do not show anything when the length of password is zero.
    if (password.length === 0) {
        document.getElementById("validationPassword01Msg").innerHTML = "";
        return;
    }
    // Create an array and push all possible values that you want in password
    var matchedCase = new Array();
    matchedCase.push("[$@$!%*#?&]"); // Special Charector
    matchedCase.push("[A-Z]");      // Uppercase Alpabates
    matchedCase.push("[0-9]");      // Numbers
    matchedCase.push("[a-z]");     // Lowercase Alphabates

    // Check the conditions
    var ctr = 0;
    for (var i = 0; i < matchedCase.length; i++) {
        if (new RegExp(matchedCase[i]).test(password)) {
            ctr++;
        }
    }
    // Display it
    var color = "";
    var strength = "";
    switch (ctr) {
        case 0:
        case 1:
        case 2:
            strength = "Bardzo słabe";
            color = "red";
            break;
        case 3:
            strength = "Średnie";
            color = "orange";
            break;
        case 4:
            strength = "Mocne";
            color = "green";
            break;
    }
    document.getElementById("validationPassword01Msg").innerHTML = strength;
    document.getElementById("validationPassword01Msg").style.color = color;
}

function validatePassword2() {
	
}
</script>