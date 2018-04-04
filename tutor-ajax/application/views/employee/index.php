<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<title>CRUD-AJAX</title>
</head>
<body>

	<div class="container">
		<h3>Employee List</h3>
		<div class="alert alert-success" role="alert" style="display: none;">
	</div>
		<button type="button" id="btnAdd" class="btn btn-success">
		  Add New
		</button>
		<table class="table table-striped table-inverse table-hover table-bordered" style="margin-top: 20px">
			<thead>
				<tr>
					<th>ID</th>
					<th>Employee Name</th>
					<th>Address</th>
					<th>Created at</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody id="showdata">
				
			</tbody>
		</table>	

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      		<form action="" method="POST" id="myForm" role="form">
		      			<input type="hidden" name="textId" value="0">
		      			<fieldset class="form-group">
		      				<label for="exampleInputEmail1">Employee Name</label>
		      				<input type="text" name="textEmployeeName" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
		      			</fieldset>
		      			<fieldset class="form-group">
		      				<label for="exampleInputPassword1">Address</label>
		      				<textarea class="form-control" name="textAddress"></textarea>
		      			</fieldset>
		      		</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" id="btnSave" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal Delete -->
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      		Do you want to delete this record ?
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" id="btnDelete" class="btn btn-danger">Delete</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
	$(function(){

		showAllEmployee();
		
		//btnAdd
		$('#btnAdd').click(function(){
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Add New Employee');
			$('#myForm').attr('action','<?php echo base_url() ?>employee/addEmployee');
		});

		$('#btnSave').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();

			var employeeName = $('input[name=textEmployeeName]');
			var address = $('textarea[name=textAddress]');
			var result = '';

			if (employeeName.val()=='') {
				employeeName.addClass('is-invalid');
			}else{
				employeeName.removeClass('is-invalid');
				result += '1';
			}

			if (address.val()=='') {
				address.addClass('is-invalid');
			}else{
				address.removeClass('is-invalid');
				result += '2';
			}

			if (result=='12') {
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: url,
					data: data,
					async: false,
					dataType: 'json',
					success: function(response){
						if (response.success) {
							$('#myModal').modal('hide');
							$('#myForm')[0].reset();
							
							if (response.type == 'add') {
								var type = 'Added';
							} else if(response.type == 'update'){
								var type = 'Updated'
							}

							$('.alert-success').html('Employee '+type+' Successfully').fadeIn().delay(3000).fadeOut('slow');
							showAllEmployee();
						}else{
							alert('error');
						}
					},
					error: function(){
						alert('Could Not Add Data');
					}
				});
			}
		});

		function showAllEmployee(){
			$.ajax({
				type : 'ajax',
				url : '<?php echo base_url() ?>employee/showAllEmployee',
				async : false,
				dataType : 'json',
				success: function(data){
					console.log(data);

					var html = '';
					var i;
					for(i=0;i<data.length;i++){
						html += '<tr>'+
									'<td>'+data[i].id_employee+'</td>'+
									'<td>'+data[i].employee_name+'</td>'+
									'<td>'+data[i].address+'</td>'+
									'<td>'+data[i].created_at+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info item-edit" data="'+data[i].id_employee+'">Edit</a>'+
										'<a href="javascript:;" class="btn btn-danger item-delete" data="'+data[i].id_employee+'">Delete</a>'+
									'</td>'+
								'</tr>';
					}
					$('#showdata').html(html);
				},
				error: function(){
					alert('Database Not Connected');
				}
			});

			//edit
			$('#showdata').on('click','.item-edit',function(){
				var id = $(this).attr('data');
				$('#myModal').modal('show');
				$('#myModal').find('.modal-title').text('Edit Employee');
				$('#myForm').attr('action','<?php echo base_url() ?>employee/updateEmployee');
				$.ajax({
					type : 'ajax',
					method : 'get',
					url : '<?php echo base_url() ?>employee/editEmployee',
					data : {id_employee: id},
					async : false,
					dataType : 'json',
					success : function(response){
						console.log(response);
						$('input[name=textId]').val(response.id_employee);
						$('input[name=textEmployeeName]').val(response.employee_name);
						$('textarea[name=textAddress]').val(response.address);
						showAllEmployee();

					},
					error : function(){
						alert('Could not Edit Data');
					}
				});
			});

			//delete
			$('#showdata').on('click','.item-delete',function(){
				var id = $(this).attr('data');
				$('#deleteModal').modal('show');
				console.log(id);
				//prevent previous handler --> unbind()
				$('#btnDelete').unbind().click(function(){
					$.ajax({
						type : 'ajax',
						method : 'get',
						async : false,
						url : '<?php echo base_url() ?>employee/deleteEmployee',
						data : {id_employee : id},
						dataType : 'json',
						success : function(response){
							if (response.success) {
								$('#deleteModal').modal('hide');
								$('.alert-success').html('Employee Deleted Successfully');
								showAllEmployee();
							} else {
								alert('error');
							}
						},
						error : function(){
							alert('Could not Delete Data');
						}
					});
				});			
			});
		}
	});
</script>
</body>
</html>
