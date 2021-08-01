<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">Update Todo <span class="pull-right"><a href="<?php echo base_url(); ?>">View Todo List</a></span></h3></h2>
        <div class="message"></div>
        <form method="put" action="" class="form-horizontal" name="updateTodo">
            <input type="hidden" name="data_action" value="update_todo" />
            <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id']; ?>" />
            <div class="form-group">
                <label class="control-label col-sm-3">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="name" value="" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Short Description</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="short_desc" value="" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Long Description</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="long_desc" value="" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Details</button>
        </form>
    </div>
</div>

<script>
function getTodoDetail(todo_id) {
	$.ajax({
		method: "GET",
		url : "<?=base_url()?>api/action",
		data: {data_action:'get_todo_detail', todo_id: todo_id},
		dataType:'json',
		success: function(data){
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				var result = (data.data);
                $("input[name='name']").val(result.name);
                $("input[name='short_desc']").val(result.short_desc);
                $("input[name='long_desc']").val(result.long_desc);
            }
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
}

$(document).ready(function(){
	getTodoDetail("<?php echo $_GET['todo_id']; ?>");
});

$(document).on("submit", "form[name='updateTodo']", function(e){
	e.preventDefault();
	var data=$(this).serialize();
	$.ajax({
		method: "POST",
		url : "<?=base_url()?>api/action",
		data: data,
		dataType:'text',
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
		error: function(XMLHttpRequest, textStatus, errorThrown) {
 			console.log(errorThrown);
		}
	});
	return false;
});
</script>