<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zaloguj się</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/css/admin-panel.css">
  </head>

  <body>
<br><br><br>
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Zaloguj się</div>
                        <div class="card-body">
                            <form action="" method="post" id="login-form">
								
                            	<? if(count($errors)): ?>
                            		<div class="form-group row">
                            		<? foreach($errors as $error): ?>
                            			<div class="alert alert-danger col-md-12" role="alert">
                      						<?=$error?>
                    					</div>
                            		<? endforeach; ?>
                            		</div>
                        		<? endif; ?>
                        		
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">Adres e-mail</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    </div>
                                </div>
    
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Hasło</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 offset-md-4">
                                	<a class="btn btn-warning float-right" href="/">Anuluj</a>
                                    <button type="submit" class="btn btn-primary">
                                        Zaloguj
                                    </button>
                                </div>
    						</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

  </body>
</html>