<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Add User</a></li>
			</ul>

			<div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-edit"></i><span class="break"></span>New User</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
							{$form_open}
							<fieldset>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Username</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="username" type="text" value="">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Password</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="password" type="password" value="">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">First Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="firstName" type="text" value="">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Last Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="lastName" type="text" value="">
								</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="focusedInput">Email</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" name="email" type="text" value="">
								</div>
							  </div>
							  
							<div class="control-group">
                            	<label class="control-label" for="selectError1">Select Group</label>
                                <div class="controls">{$groupList}</div>
                            </div>
							
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Save changes</button>
								<button class="btn">Cancel</button>
							  </div>
							</fieldset>
						  {$form_close}
					
					</div>
				</div><!--/span-->
			
			</div>	
			<!--/row-->
	</div>
	<!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">√ó</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="clearfix"></div>