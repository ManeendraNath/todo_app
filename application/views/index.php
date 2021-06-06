<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
	<h3>View Employees Details <span class="pull-right"><a href="<?php echo base_url(); ?>new-user">Add New Employee</a></span></h3>
	<div class="message"></div>
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>
<script>
function fetchData() {
	$.ajax({
		method: "POST",
		url : "<?php echo base_url(); ?>api/action",
		data: {data_action:'fetch_data'},
		dataType:'json',
		success: function(data){
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				var result = (data.data);
				var html = "";
				for(var i = 0; i < result.length;i++) {
					html += "<tr><td>" + parseInt(i+1) + "</td><td>" + result[i].first_name.substr(0,1).toUpperCase()+result[i].first_name.substr(1) + "</td><td>" + result[i].last_name.substr(0,1).toUpperCase()+result[i].last_name.substr(1) + "</td><td>" + result[i].email + "</td>";
					if(result[i].status == 1) {
						html += "<td><span class='label label-primary'>Active</span></td>";
					} else if(result[i].status == 2) {
						html += "<td><span class='label label-danger'>Deleted</span></td>";
					}
					html += "<td><a href='<?php echo base_url(); ?>edit-user?user_id=" + result[i].id + "' class='btn btn-warning btn-sm'>Edit</a> <a href='<?php echo base_url(); ?>delete-user?user_id=" + result[i].id + "' class='btn btn-danger btn-sm'>Delete</a></td><tr>";
				}
				$('tbody').html(html);
			}
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
}
$(document).ready(function(){
	fetchData();
});
</script>