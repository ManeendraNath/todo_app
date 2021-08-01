<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h2 class="text-center">Delete Todo <span class="pull-right"><a href="<?php echo base_url(); ?>">View Todo List</a></span></h3></h2>
        <div class="message"></div>
		<table class="table">
		<tbody>
		</tbody>
	</table>
        <form method="post" action="" class="form-horizontal" name="deleteTodo">
            <input type="hidden" name="data_action" value="delete_todo" />
            <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id']; ?>" />
            <button type="submit" class="btn btn-danger">Yes, Delete Todo</button>
        </form>
    </div>
</div>

<script>
function getTodoDetail(todo_id) {
	$.ajax({
		method: "POST",
		url : "<?=base_url()?>api/action",
		data: {data_action:'get_todo_detail', todo_id: todo_id},
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
	getTodoDetail("<?php echo $_GET['todo_id']; ?>");
});

$(document).on("submit", "form[name='deleteTodo']", function(e){
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