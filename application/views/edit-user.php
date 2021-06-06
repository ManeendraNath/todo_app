<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2 class="text-center">Update User <span class="pull-right"><a href="<?php echo base_url(); ?>">View All Employee</a></span></h3></h2>
        <div class="message"></div>
        <form method="post" action="" class="form-horizontal" name="updateUser">
            <input type="hidden" name="data_action" value="update_user" />
            <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>" />
            <div class="form-group">
                <label class="control-label col-sm-3">First Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="first_name" value="" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Last Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="last_name" value="" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" value="" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Details</button>
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
                $("input[name='first_name']").val(result.first_name);
                $("input[name='last_name']").val(result.last_name);
                $("input[name='email']").val(result.email);
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

$(document).on("submit", "form[name='updateUser']", function(e){
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
				$('.message').html("Record updated successfully.");
			}
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
	return false;
});
</script>