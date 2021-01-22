<!-- page content -->
<div class="right_col" role="main">
  <div class="">
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Użytkownicy</h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			  <table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
				<tr>
					<th>Awatar</th>
					<th>Login</th>
					<th>Użytkownik</th>
					<th>Email</th>
					<th>Nr tel.</th>
					<th>Domeny</th>
					<th>Ostatina aktywność</th>
					<th>Akcje</th>
				</tr>
				</thead>
				
				<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo avatar_img($user['avatar'], '', 'width: 50px; height: 50px;') ?></td>
						<td><?php echo $user['user'] ?></td>
						<td><?php echo $user['name'] ?></td>
						<td><?php echo $user['mail'] ?></td>
						<td><?php echo $user['phone'] ?></td>
						<td></td>
						<td></td>
						<td>Edytuj</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<div class="row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h2>Dodaj użytkownika</h2>
			<ul class="nav navbar-right panel_toolbox">
			  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
			  </li>
			</ul>
			<div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<form class="form-horizontal form-label-left input_mask">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Login">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Użytkownik">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess5" placeholder="Nr. tel">
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                      </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <select class="select2_multiple form-control" multiple="multiple">
                            <option>rid.isowiki.eu</option>
                            <option>sim.isowiki.eu</option>
                          </select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
							<label style="margin-top:10px">Typ użytkownika:</label>
                          <div class="radio">
                            <label>
                              <input type="radio" checked="" value="standard" id="optionsRadios1" class="flat" name="perms"> Standardowy
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" value="protected" id="optionsRadios2" class="flat" name="perms"> Chroniony
                            </label>
                          </div>
						 <div class="radio">
                            <label>
                              <input type="radio" value="admin" id="optionsRadios3" class="flat" name="perms"> BAS Admin
                            </label>
                          </div>
                        </div>
                        
					<div class="col-md-8 col-sm-8 col-xs-12" `>
						<!-- Show the cropped image in modal -->
						<br>
						<br>
						<div class="col-md-8">
						  <div class="img-container" style="height:400px">
							<img id="image" src="images/cropper.jpg" alt="Picture">
						  </div>
						</div>
						<div class="col-md-4">
						  <div class="docs-preview clearfix">
							<div class="img-preview preview-lg"></div>
						  </div>
						</div>
					  <br>
					  <br>
					</div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Anuluj</button>
                          <button type="submit" class="btn btn-success">Zapisz</button>
                        </div>
                      </div>

                    </form>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
<!-- /page content -->

<script>


</script>
