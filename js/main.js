$(function() {
	$('#addfile').click(function() {
		var html = '<div class="input-group" style="margin-bottom:10px;"><input type="file" style="width:300px" name="file[]" class="form-control btn btn-primary pull-left"><a href="javascript:void(0);" onclick="delfile(this);" class="btn btn-danger pull-right">remove</a></div>';
		$('#uploaddiv').append(html);            
	});

	delfile = function(id) {
		$(id).parent().remove();
	}

	//INSERT USER DATA
	$('form[name="userForm"]').submit(function(e) {
		e.preventDefault();
		var name = $('input[name="name"]').val();
		var email = $('input[name="email"]').val();
		var password = $('input[name="password"]').val();
		var data= {
				buttonsave: 1,
				name: name,
				email: email,
				password: password
			};
			console.log(data);
		$.ajax({
			url: "./main.php",
			type: "POST",
			async: false,
			data: data,
			success: function(response) {
				console.log(response);
				$('#userData').empty();	
				show();
			},
			error: function() {
				console.log('error');
			}
		});
	});

	//SHOW USER DATA
	show = function () {
		$.ajax({
			url: './main.php', 
			type: 'GET',
			data: {
				show: 1,
			},
			success: function(data) {
				userData(data);
			}
		});
	};
	show();

	function userData(data) {
		$('#userData').append(data);
	};


	//EDIT BUTTON FUNCTION
	$('body').delegate('.edit','click',function() {
		$('#submit').hide();
		$('#update').show();
		var idEdit = $(this).attr('ide'); 	
		$.ajax({
			url: './main.php',
			type: 'POST',
			datatype: 'JSON',
			data: {
				edituser: 1,
				id : idEdit
			},
			success: function(show) {
				console.log(show);
				$('#id').val(show.user.id);
				$('#name').val(show.user.name);
				$('#email').val(show.user.email);
				$('#pwd').val(show.user.password);
			}
		});
	});

	//DELETE USER DATA
	$('body').delegate('.delete','click',function() {
		var iddelete = $(this).attr('idd'); 	
		$.ajax({
			url: './main.php',
			type: 'POST',
			data: {
				deleteuser: 1,
				id : iddelete
			},
			success: function(res) {
				console.log(res);
				$('#userData').empty();
				show();
			}
		});
	});

	//UPDATE USER DATA
	$('#update').click(function() {
		$('#submit').show();
		$('#update').hide();
		var id = $('#id').val();
		var name = $('input[name="name"]').val();
		var email = $('input[name="email"]').val();
		var password = $('input[name="password"]').val();
		var data= {
				updateuser: 1,
				id: id,
				name: name,
				email: email,
				password: password
			};
		$.ajax({
			url: './main.php',
			type: 'POST',
			data: data,
			success: function(update) {
				console.log(update);
				$('#userData').empty();
				show();
			}
		});
	});

	//UPLOAD IMAGE
	$("form[name='frmupload']").submit(function(e){
		e.preventDefault();
	    var postData = new FormData($("#frmupload")[0]);
	    // uploadFormData(postData);
	});


  	function uploadFormData(formData) {
  		var data = {
	      		image: 1,
	      		formData: formData
	      	};
	    $.ajax({
	      	url: './main.php',
	      	type: 'POST',
	      	datatype : "JSON",
	      	data: data,
	      	success: function(data) {
	        	console.log(data);
	      	}
    	});
  	}
});