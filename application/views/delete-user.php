<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2 class="text-center">Update User <span class="pull-right"><a href="<?php echo base_url(); ?>">View All Employee</a></span></h3></h2>
        <div class="message"></div>
		<table class="table">
		<tbody>
		</tbody>
	</table>
        <form method="post" action="" class="form-horizontal" name="deleteUser">
            <input type="hidden" name="data_action" value="delete_user" />
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>" />
            <button type="submit" class="btn btn-danger">Yes, Delete Employee</button>
        </form>
    </div>
</div>

<script>
function getUserDetail(user_id) {
	$.ajax({
		method: "POST",
		url : "<?=base_url()?>api/action",
		data: {data_action:'get_user_detail', user_id: user_id},
		dataType:'json',
		success: function(data){
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				var result = (data.data);
                var html = "";
					html += "<tr class='danger'><td colspan='2'>Following record will be deleted.</td></tr><tr><td>First Name</td><td>" + result.first_name.substr(0,1).toUpperCase()+result.first_name.substr(1) + "</td></tr><tr><td>Last Name</td><td>" + result.last_name.substr(0,1).toUpperCase()+result.last_name.substr(1) + "</td></tr><tr><td>Email</td><td>" + result.email + "</td><tr>";
				$('tbody').html(html);
            }
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
}

$(document).ready(function(){
	getUserDetail("<?php echo $_GET['user_id']; ?>");
});

$(document).on("submit", "form[name='deleteUser']", function(e){
	e.preventDefault();
	var data=$(this).serialize();
	$.ajax({
		method: "POST",
		url : "<?=base_url()?>api/action",
		data: data,
		dataType:'json',
		success: function(data){
			console.log(data);
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				console.log(data.data);
				$('.message').addClass("alert alert-success");
				$('.message').html("Record deleted successfully.");
			}
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
	return false;
});
</script>