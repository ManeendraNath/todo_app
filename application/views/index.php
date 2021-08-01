<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<h3>Todo List <span class="pull-right"><a href="<?php echo base_url(); ?>new-todo">Add New Todo</a></span></h3>
	<div class="message"></div>
	<form class="form-inline">
		<div class="form-group">
			<label>Status</label>
			<select name="status" class="form-control">
				<option value="">All</option>
				<option value="1">In Progress</option>
				<option value="2">Completed</option>
			</select>
		</div>
	</form>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Short Description</th>
				<th>Long Description</th>
				<th>Status</th>
				<th>Date Added</th>
				<th>Date Modofied</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script>
$(document).ready(function(){
	fetchData();
});
function fetchData(status = "") {
	$.ajax({
		method: "GET",
		url : "<?php echo base_url(); ?>api/action",
		data: {data_action:'fetch_data', status: status},
		dataType:'json',
		success: function(data){
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				var result = (data.data);
				var html = "";
				for(var i = 0; i < result.length;i++) {
					html += "<tr><td>" + parseInt(i+1) + "</td><td>" + result[i].name.substr(0,1).toUpperCase()+result[i].name.substr(1) + "</td><td>" + result[i].short_desc + "</td><td>" + result[i].long_desc + "</td>";
					if(result[i].status == 1) {
						html += "<td><span class='label label-primary'>In Progress</span></td>";
					} else if(result[i].status == 2) {
						html += "<td><span class='label label-success'>Completed</span></td>";
					} else if(result[i].status == 0) {
						html += "<td><span class='label label-danger'>Deleted</span></td>";
					}
					html += "<td>" + result[i].date_added + "</td>";
					if(result[i].date_modified !== null) {
						html += "<td>" + result[i].date_modified + "</td>";
					} else {
						html += "<td></td>";
					}
					if(result[i].status == 1) {
						html += "<td><a href='<?php echo base_url(); ?>complete-todo?todo_id=" + result[i].id + "' class='btn btn-success btn-sm'>Mark Complete</a> <a href='<?php echo base_url(); ?>view-todo?todo_id=" + result[i].id + "' class='btn btn-info btn-sm'>View</a>  <a href='<?php echo base_url(); ?>edit-todo?todo_id=" + result[i].id + "' class='btn btn-warning btn-sm'>Edit</a> <a href='<?php echo base_url(); ?>delete-todo?todo_id=" + result[i].id + "' class='btn btn-danger btn-sm'>Delete</a></td><tr>";
					} else {
						html += "<td>No action required</td><tr>";
					}
				}
				$('tbody').html(html);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
 			console.log(errorThrown);
		}
	});
}


$("select[name='status']").change(function(){
	var status = $(this).val();
	fetchData(status);
});
</script> 
