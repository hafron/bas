
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="gentella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="gentella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="gentella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="gentella/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="gentella/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signin"></a>
		<?php foreach ($errors as $error): ?>
			<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Błąd:</span>
			  <?php echo $error ?>
			</div>
		<?php endforeach ?>
      <div class="login_wrapper">
        <div class="form login_form">
          <section class="login_content">
            <form method="post">
              <h1>Formularz logowania</h1>
              <div>
                <input type="text" class="form-control" placeholder="Użytkownik" required="" name="user" value="<?php echo post('user') ?>" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Hasło" required="" name="pass" />
              </div>
              <div>
                <input class="btn btn-default submit"  type="submit" value="Zaloguj">
                <a class="reset_pass" href="#">Zapomniałeś hasła?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <h1><i class="fa fa-paw"></i> BAS Server</h1>
                </div>
              </div>
            </form>
          </section>
        </div>

    </div>
  </body>
</html>
