<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h1 class="h2">Użytkownicy - dodaj nowego</h1>
</div>
			

<form class="needs-validation" action="<?= adminURL('users', 'add_post') ?>" method="post" novalidate>
  	<h5>Podstawowe informacje</h5>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationEmail">E-mail</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
        </div>
        <input type="email" class="form-control" id="validationEmail" placeholder="E-mail" value="<?= isset($post['email']) ? $post['email'] : '' ?>" name="email" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
          Wprowadzony adres e-mail nie jest poprawny!
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationPassword01">Hasło</label>
      <input type="password" class="form-control" id="validationPassword01" onkeyup="validatePassword(this.value);" placeholder="" value="<?= isset($post['password']) ? $post['password'] : '' ?>" name="password" required>
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
      <input type="password" class="form-control" id="validationPassword02" placeholder="" value="<?= isset($post['password2']) ? $post['password2'] : '' ?>" name="password2" required>
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
  	<h5>Uprawnienia w projekcie</h5>
  	<table class="table table-sm table-bordered">
  		<thead class="thead-light">
  			<tr class="text-center">
        		<th><label for="USERS">Użytkownicy</label></th>
        		<th><label for="PAGES">Strony</label></th>
        		<th><label for="TEMPLATES">Szablony</label></th>
        		<th><label for="ACTIONS">Akcje wolontariackie</label></th>
        		<th><label for="APPLICATIONS">Zagłoszenia</label></th>
        		<th><label for="SETTINGS">Ustawienia</label></th>
        		<th><label for="LOGS">Logi</label></th>
        	</tr>
  		</thead>
  		<tbody>
  			<tr class="text-center">
  				<td><input type="checkbox" name="access[]" id="USERS" value="<?= MemberModel::PROJECT_ACCESS_USERS ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_USERS, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="PAGES" value="<?= MemberModel::PROJECT_ACCESS_PAGES ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_PAGES, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="TEMPLATES" value="<?= MemberModel::PROJECT_ACCESS_TEMPLATES ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_TEMPLATES, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="ACTIONS" value="<?= MemberModel::PROJECT_ACCESS_ACTIONS ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_ACTIONS, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="APPLICATIONS" value="<?= MemberModel::PROJECT_ACCESS_APPLICATIONS ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_APPLICATIONS, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="SETTINGS" value="<?= MemberModel::PROJECT_ACCESS_SETTINGS ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_SETTINGS, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  				<td><input type="checkbox" name="access[]" id="LOGS" value="<?= MemberModel::PROJECT_ACCESS_LOGS ?>" <?= isset($post['access']) ? in_array(MemberModel::PROJECT_ACCESS_LOGS, $post['access']) ? 'checked="checked"' : '' : '' ?>></td>
  			</tr>
  		</tbody>
  	</table>
  	</div>
  </div>
  <div class="form-row">
    <div class="col-md-8 mb-3">
		<a class="btn btn-warning float-right" href="<?= adminURL('users') ?>">Anuluj</a>
		<button class="btn btn-primary" type="submit">Dodaj użytkownika</button> 
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