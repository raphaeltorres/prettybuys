<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Product Add</a></li>
			</ul>

			<div class="row-fluid sortable ui-sortable">
				<div class="box span12">
					<div class="box-header" data-original-title="">
						<h2><i class="icon-tag"></i><span class="break"></span>Product Add</h2>
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
								<label class="control-label" for="selectError">Category</label>
								<div class="controls">
									{$productTypeList}
								</div>
							  </div>
							  
							 <div class="control-group">
								<label class="control-label" for="selectError1">Area</label>
								<div class="controls">
									{$areaList}
								</div>
							  </div>
							
							 <div class="control-group">
								<label class="control-label" for="focusedInput">Product Name:</label>
								<div class="controls">{$product_name}</div>
							</div>
							  
							  <div class="control-group input-prepend">
								<label class="control-label" for="focusedInput">Product Link:</label>
								<div class="controls">
							 	 <span class="add-on">www.</span>
								{$product_link}
								</div>
							  </div>
							      
							<div class="control-group hidden-phone">
								<label class="control-label" for="textarea2">Product Description</label>
								<div class="controls">
									<textarea class="cleditor" id="product_description" name="product_description" rows="3"></textarea>
							  	</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">Quantity</label>
								<div class="controls">
								<input class="input-small focused autonum" type="number" name="quantity" min="0" max="100000">
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="appendedInput">Savings</label>
								<div class="controls">
								  <div class="input-append">
									<input class="input-small focused autonum" id="appendedInput" type="text" name="savings"><span class="add-on">%</span>
								  </div>
								  <span class="help-inline"></span>
								</div>
							  </div>
							  
							<div class="control-group">
								<label class="control-label" for="appendedPrependedInput">Price</label>
								<div class="controls">
								  <div class="input-prepend input-append">
									<span class="add-on">P</span><input class="input-small focused" id="appendedPrependedInput" type="text" name="product_price"><span class="add-on">.00</span>
								  </div>
								</div>
							  </div>
							
								<div class="control-group">
								<label class="control-label">Featured</label>
								<div class="controls">
								<input class="input-small focused autonum" type="number" name="featured" min="0" max="100">
								</div>
							  </div>
							  
							  
							   <div class="control-group">
								<label class="control-label">Status</label>
								<div class="controls">
								  <label class="radio">
									<input type="radio" name="status" id="optionsRadios1" value="1" checked="">
									Yes
								  </label>
								  <div style="clear:both"></div>
								  <label class="radio">
									<input type="radio" name="status" id="optionsRadios2" value="0">
									No
								  </label>
								</div>
							  </div>
							  
							  	<div class="control-group">
								<label class="control-label">Expiry Days</label>
								<div class="controls">
								<input class="input-small focused autonum" type="number" name="expiry" min="0" max="5">
								</div>
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