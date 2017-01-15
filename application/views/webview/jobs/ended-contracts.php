<section id="big_header"
	style="margin-top: 50px; margin-bottom: 50px; height: auto;">

	<div class="container">
		<div class="row ">
			<div class="col-md-3">


				<div class="row">

					<div class="col-md-10 borderedx white-box nopadding "
						style="padding: 3px 15px !important">
						<div class="search-icon blue-text">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>

						<div class="search-txt-field">
							<input type="text" class="" value=""
								placeholder="Search for freelancers..." />
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-10 nopadding">
						<nav class="staff-navbar">
							<ul>
								<li><a  href="<?php echo site_url("jobs/activecontracts") ?>"><b>Active Contracts</b></a></li>
								<li><a class="active" href="<?php echo site_url("jobs/endedcontracts") ?>"><b>Ended Contracts</b></a></li> 
							</ul>
						</nav>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="row">
					<div class="col-md-12 bordered-alert text-center ack-box">
						<?php if($past_hire){ ?>
					<h4>! You have ended <?=$past_hire;?> contract</h4>
					<?php } else{?>
						<h4>! You have no ended contact</h4>
					<?php } ?>
					</div>


				</div>
	<?php foreach($messages as $message){
		$username =$message->webuser_fname . '&nbsp;'.$message->webuser_lname;
		$title = $message->hire_title;
		
		?>
				<div class="row margin-top-2">
					<div class="col-md-12 bordered white-box" style="padding: 20px">
						<div class="row">
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-5">
										<?php if($message->webuser_picture !=""){ ?>
										<img src="<?php echo base_url().$message->webuser_picture; ?>" width="90" height="68">
										<?php }else{?>
											
										<?php } ?>
									</div>
									<div class="col-md-7 nopadding" style="padding-left: 25px !important">
										<div class="user_name">
										    <h5><?=$message->webuser_fname?> <?=$message->webuser_lname?> <br></h5>
							<span><?=$message->country_name?></span>
										</div>
									</div>
								</div>

							</div>

							<div class="col-md-4 text-center">
							</div>

							<div class="col-md-4">
								<div class="row">
								<div class="col-md-3 col-md-offset-2">
								   <div class="">
								       <input type="button" class="btn btn-primary form-btn"  onclick="loadmessage(<?=$message->bid_id?>,<?=$message->fuser_id?>,<?=$message->job_id?>,'<?=$username?>','<?=$title?>')" value="Message">
									<!--<a href="<?php echo base_url() ?>interview?user_id=<?=base64_encode($message->fuser_id)?>&job_id=<?=base64_encode($message->job_id)?>&bid_id=<?=base64_encode($message->bid_id)?>">
											<input type="button" class="btn btn-primary transparent-btn" value="Message" />
									</a>--> 
								   </div>
								</div>
									<div class="col-md-5 text-right">
                                        <div class="msg_btnx">
										    <input type="button" class="btn btn-primary form-btn" value="Rehire" />
										</div>
									</div>

									<div class="col-md-2">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button"
												data-toggle="dropdown">
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu">
<!--												<li><a href="#">Message</a></li>-->
<!--												<li><a href="#">Milestone</a></li>-->
<!--												<li><a href="#">View Profile</a></li>-->
<!--												<li><a href="#">View contact</a></li>-->
												<li><a href="#">View Ended contract</a></li>

											</ul>
										</div>
									</div>
								</div>


							</div>
						</div>

						<div class="row">
							<div class="col-md-10 margin-left-10">
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
							    <div class="pro_view">
							        <span>View Profile</span>
							    </div>
							</div>
							<div class="col-md-8">
								<div class="col-md-8">
								<div class="job_detaisx">
								    <?php if($message->hire_title !=""){
									$job_title = $message->hire_title;
								}else{
									$job_title = $message->title;
								}
								if($message->job_type == "hourly"){ ?>
								<a href="<?php echo base_url() ?>feedback/hourly_client?fmJob=<?php echo base64_encode($message->job_id);?>&fuser=<?php echo base64_encode($message->fuser_id);?>">
								<?php }else { ?>
								<a href="<?php echo base_url() ?>feedback/fixed_client?fmJob=<?php echo base64_encode($message->job_id);?>&fuser=<?php echo base64_encode($message->fuser_id);?>">	
								<?php }  ?>
								
								Job Details- </a><b><?=$job_title;?></b>
								</div>
							</div>
							</div>
						</div>
					</div>


				</div>
			<?php } ?>
			
			</div>
		</div>
	</div>

</section>

</div>

</section>
<!-- big_header-->


<!-- Modal -->
<div id="message_convertionModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" onclick="hidemessagepopup();">&times;</button>
			<h4 class="modal-title">Message</h4>
			<div class="col-lg-12 col-md-12 col-sm-12 chat-screen">
				<div class="chat-details-topbar">
					<h3 class="user_name"></h3>
					<h5 class="job_title"></h5>
									
				</div>
			</div>
      </div>
      <div class="modal-body">
		<div class="message_lists chat-details form-group" ></div>
        <form name="message" action="" method="post" id="conversion_message">
             <textarea name="usermsg"  id="usermsg"></textarea>
               <input name="job_id" type="hidden" id="job_id"  value="" />
               <input name="bid_id" type="hidden" id="bid_id"  value=""  />
               <input name="sender_id" type="hidden" id="sender_id"  value="<?php echo $this->session->userdata('id');?>"  />
               <input name="receiver_id" type="hidden" id="receiver_id"  value=""  />
             <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
         </form>
        </div>
    </div>
 </div>
</div>

<script>
    function loadmessage( b_id, u_id, j_id, u_name, j_title){
			$('.user_name').html(u_name);
			$('.job_title').html(j_title);

		var modal = document.getElementById('message_convertionModal');
        $.post("<?php echo site_url('jobconvrsation/message_from_superhero');?>", { job_bid_id:b_id, user_id : u_id, job_id : j_id },  function(data) {
			$('.message_lists').html(data.html);
            $('#job_id').val( j_id );
            $('#bid_id').val( b_id );
            $('#receiver_id').val( u_id );
            // $('#message_convertionModal').modal('show');
			modal.style.display = "block";
           // $('.message_lists').animate({scrollTop: $('.message_lists').prop("scrollHeight")}, 500);
            autoloading();
		}, 'json');
       
    }
	 function hidemessagepopup(){
        var modal = document.getElementById('message_convertionModal');
        modal.style.display = "none";
    }
	 
    $("#conversion_message").on("submit", function(e) {
          e.preventDefault();
          var $form = $("#conversion_message");
          if ( $('#usermsg').val().trim().length > 0 ) {
                $.post("<?php echo site_url('jobconvrsation/add_conversetion');?>", { form: $form.serialize() },  function(data) {
                    if(data.success){
                        $form[0].reset();
                        loadmessage( $('#bid_id').val(), $('#receiver_id').val(), $('#job_id').val() );
                         
                    }
                    else{
                        alert('Opps!! Something went wrong.');
                    }
                   
                }, 'json');
          }
         
    });
    
      function loadmessage_auto( ){
        
        var auto_job_id = $('#job_id').val();
        var auto_bid_id = $('#bid_id').val();
        var auto_receiver_id = $('#receiver_id').val();
        
		var modal = document.getElementById('message_convertionModal');
        $.post("<?php echo site_url('jobconvrsation/message_from_superhero');?>", { job_bid_id:auto_bid_id, user_id : auto_receiver_id, job_id : auto_job_id },  function(data) {
			$('.message_lists').html(data.html);
           
            //$('.message_lists').animate({scrollTop: $('.message_lists').prop("scrollHeight")}, 500);
		}, 'json');
    }
    
    function autoloading() {
        //alert('hi');
        var auto_job_id = $('#job_id').val();
        var auto_bid_id = $('#bid_id').val();
        var auto_receiver_id = $('#receiver_id').val();
       
        if (auto_job_id) { auto_job_id = auto_job_id;}else{auto_job_id = 0;}
        if (auto_bid_id) { auto_bid_id = auto_bid_id;}else{auto_bid_id = 0;}
        if (auto_receiver_id) { auto_receiver_id = auto_receiver_id;}else{auto_receiver_id = 0;}
       
        if (auto_job_id && auto_bid_id && auto_receiver_id) {
            setInterval('loadmessage_auto()', 5000);
        }
    }
  autoloading();
</script>
<style>
.message_lists{
    max-height: 250px;
    overflow-y: scroll;
    overflow-x: hidden;
}
.m_list.scroll-ul > li {
  display: block;
  margin: 10px 0 21px 5px;
  overflow: hidden;
  width: 100%;
  border-bottom: 1px solid #dddddf;
  padding-bottom: 4px;
}
.chat-identity .img-circle {
  float: left;
  margin-right: 14px;
}
#conversion_message > input {
  background: rgb(28, 167, 219) none repeat scroll 0 0;
  float: right;
  font-size: 21px;
  height: 50px;
  margin-top: 4%;
  vertical-align: middle;
  width: 19%;
}
#conversion_message textarea {
  float: left;
  height: 100px;
  width: 80%;
}
.modal-body {
  overflow: hidden;
}
</style>
