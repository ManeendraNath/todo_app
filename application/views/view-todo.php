<div class="row">
    <div class="col-md-12">
        <h2 class="text-center">View Todo <span class="pull-right"><a href="<?php echo base_url(); ?>">View Todo List</a></span></h3></h2>
        <div class="message"></div>
        <h3></h3>
        <p></p>
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
			console.log(data);
			if(data.is_error == "yes") {
				$('.message').addClass("alert alert-danger");
				$('.message').html("Something went wrong. Please try again later.");
			} else {
				var result = (data.data);
                $("h3").text(result.name);
                $("p").text(result.long_desc);
            }
		},
		error: function() {
			alert("Some Error occured. Please try again after some time."); 
		}
	});
}

$(document).ready(function(){
	getTodoDetail("<?php echo (int)$_GET['todo_id']; ?>");
});

</script>