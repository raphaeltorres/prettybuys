<!-- start: Content -->
<div id="content" class="span10">

			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="#">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Deals</a></li>
			</ul>

			<div class="row-fluid ">
				<div class="span6"><button class="btn btn-small productadd"><i class="icon-shopping-cart"></i> Add Deal</button>
				</div>
			</div>
			
			<div class="row-fluid sortable">
			
				<div class="box span12">
                
                     <div class="{$msgClass}"><strong>{$msgInfo}</strong></div>        
					<div class="box-header" data-original-title>
						<h2><i class="icon-barcode"></i><span class="break"></span>Deals</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="icon-wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th width="30%">Product Name</th>
								  <th width="15%">Category</th>
								  <th width="15%">Merchant</th>
								  <th width="10%">Price</th>
								  <th width="5%">Quantity</th>
                                  <th width="10%">Active</th>
                                  <th width="15%">Action</th>
								  
							  </tr>
						  </thead>   
						  <tbody>
							
							{foreach from=$productlist item=product}
							<tr>
								<td>{$product->product_name}</td>
								<td class="center">{$product->product_type}</td>
								<td class="center">{$product->user_first_name} {$product->user_last_name}</td>
								<td class="center">P {$product->product_price|number_format:2}</td>
								<td class="center">{$product->quantity}</td>
								<td class="center">
									<span class="label label-success">Active</span>
								</td>
								
								<td class="center">
									<a class="btn btn-success" href="#"><i class="icon-zoom-in icon-white"></i></a>
									<a class="btn btn-info" href="{$baseUrl}user/edituser/{$user->user_id}"><i class="icon-edit icon-white"></i></a>
									<a class="btn btn-danger" href="#"><i class="icon-trash"></i></a>
								</td>
							</tr>
							{/foreach}
						  </tbody>
					  </table> 
                          
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

			
			
			
						
			
			
			
			
			
			
			<!--/row-->
			
       

	</div>
	<!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">Ã—</button>
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