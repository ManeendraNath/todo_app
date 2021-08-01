<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">Mark Complete Todo <span class="pull-right"><a href="<?php echo base_url(); ?>">View Todo List</a></span></h3></h2>
        <div class="message"></div>
		<table class="table">
		<tbody>
		</tbody>
	</table>
        <form method="post" action="" class="form-horizontal" name="completeTodo">
            <input type="hidden" name="data_action" value="complete_todo" />
            <input type="hidden" name="todo_id" value="<?php echo $_GET['todo_id']; ?>" />
            <button type="submit" class="btn btn-Success">Yes, Complete This Todo</button>
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
                var html = "";
					html += "<tr class='danger'><td colspan='2'>Following record will be marked as completed.</td></tr><tr><td><b>Name</b></td><td>" + result.name + "</td></tr><tr><td><b>Short Description</b></td><td>" + result.short_desc + "</td></tr>";
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

$(document).on("submit", "form[name='completeTodo']", function(e){
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
		error: function(XMLHttpRequest, textStatus, errorThrown) {
 			console.log(errorThrown);
		}
	});
	return false;
});
</script>