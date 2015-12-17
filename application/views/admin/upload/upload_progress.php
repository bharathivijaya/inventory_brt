<h2>Update Progress (Do not close this window until progress 100%)</h2>
<span><h4><span id="progress_text">0</span> complete</h4></span>
<div class="progress">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress_bar">
    <span class="sr-only">0</span><span id="sr">0</span>% Complete
  </div>
  
</div>
<p><h4><span id="progress_count">0</span> of <?php echo $total_count;?> processed.</h4></p>

<script type="application/javascript">
	function updateprogress(percentage){
		percentage = Math.round(percentage * 100) / 100;
		document.getElementById('progress_bar').style.width = percentage+'%';
		$('#progress_text').html(percentage+'%');
		$('#sr').html(percentage);
	}
	
	function updatecount(count){
		$('#progress_count').html(count);
	}
	
	//updateprogress(40);
	//updatecount(100);

	for(record = 0; record <= <?php echo $total_count;?>; record += 100){
		(function(record) {
			setTimeout(function(){
					$.ajax({
				        type: 'POST',
				        url: '<?php echo base_url()."admin/ajax_update"?>',
				        /*async:true,*/
				        async: false,
				        data: {
				            id: record
				    }
				    }).done(function(return_count) {  
					    /*alert(return_count);  */  
					    if(return_count > <?php echo $total_count;?>)
					    {
					    	return_count = <?php echo $total_count;?>;
					    }
					     
				    	updateprogress((return_count/<?php echo $total_count;?>)*100);
				    	updatecount(return_count);
				        if(return_count!=0){
				            //logSuccess(ipToCheck);
				        }
				    });
		
				 }, 8000);
		})(record);	 

	}

	/*for (var i = 0, len = list.length; i < len; i += 1) {
	    (function(i) {
	        setInterval(function() {
	            list[i] += 10;
	            console.log(i + "=>" + list[i] + "\n");
	        }, 5000)
	    })(i);
	}*/
	
</script>
