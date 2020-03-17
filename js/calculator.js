$(document).ready(function(){

	//When user click on field in the table
	$(".container table tr td").on("click",function(){
		var task = $(this).text().split("x"); 
		//Split field text based on 'x'
		//If we didn't complete the task we will have array with 2 members
		//We do that to avoid multiple click at the same field in the table
		//If we have array with 2 members send AJAX call
		if(task.length == 2) $(this).load("index.php","task="+$(this).text());
	})

	//If you want to see logs from database,hit CTRL+A (open/close logs)
	//Every time will update logs without reloading page
	document.addEventListener('keyup',function(e){
		if (e.ctrlKey && e.keyCode == 65) {
	       	$(".logs").slideToggle("normal");
	       	$(".logs table").load("index.php","action=showMeLogs");
	    }
	}, false);
});