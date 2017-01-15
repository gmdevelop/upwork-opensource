
<section id="mid_content">
	<div class="container">
		<div class="row">
				<div class="col-md-9 col-sm-12 margin-top-3">
					<div id="wrapper" class="white-box margin-bottom-3 ">
						<div class="wrap-top">
						<div class="row">
							<div class="col-md-4 col-sm-4 tohead">
								<h4>Ended <?php  echo date(' F j, Y ', strtotime($job->end_date)); ?> </h4>
							</div>
							<div class="col-md-4 col-sm-4 col-md-offset-4 toheadone">
								<h4> Contract ID <?=$job->contact_id ?>  </h4>
							</div>
						</div>
						<div style="clear:both"></div>
						<div class="row">
							<div class="col-md-1 col-sm-1 col-md-offset-1 firshired">
								<h4>Hired</h4>
							</div>
							<div style="clear:both"></div>
							<div class="col-md-5 col-sm-5 col-md-offset-1 imageheading">
								<div class="image">
									<?php  if($job->webuser_picture !=""){ ?>
										<img src="<?php echo base_url().$job->webuser_picture ?>" width="64" height="64" />
									<?php }else{ ?>
										<img src="<?php echo base_url()?>assets/img/man.png"/>
									<?php  } ?>
									
								</div>
								<h4><?=$job->webuser_fname ?> <?=$job->webuser_lname ?> </h4>
								<h3><?=$job->webuser_company ?></h3>
							</div>
							<div class="col-md-4 col-sm-4 imglast">
								<h3>Status: Ended </h3>
							</div>
							<div class="col-md-2 col-sm-2">
								
								
								<h3><button type="button" id="massagebuton" class="btn btn-danger" onclick="loadmessage(<?=$job->bid_id?>,<?=$job->buser_id?>,<?=$job->job_id?>)"> Message</button></h3>
							</div>
						</div>
						
						</div>
						<div class="mid-wrop">
						<div class="row">
							<div class="col-md-10 col-sm-10 col-md-offset-1 seoranking">
								<?php if($job->hire_title !=""){
									$job_title = $job->hire_title;
								}else{
									$job_title = $job->title;
								}?>
								<h4><?=$job_title;?></h4>
								<h3><a href="<?php echo base_url() ?>jobs/view/<?php echo url_title($job->title) ?>/<?php echo base64_encode($job->job_id);?>">View original job post</a></h3>
							</div>
							<div style="clear:both"></div>
							
						</div>
						<div class="row hourlcontact">
							<div class="col-md-3 col-sm-3 col-md-offset-1">
								<h4>Paid Since Start</h4>
							</div>
							<div class="col-md-2 col-sm-2 col-md-offset-1">
								<h4> <?php
								$amount = 0.00;
								if(!empty($job_end)){
									foreach($job_end as $End){
										$amount +=  $End->fixedpay_amount;
									}
								}
								$totalpaid =  ($amount +  $job->fixedpay_amount);
								
								echo "$".round($totalpaid,2);
								
								
								
								?> </h4>
							</div>
							<div class="col-md-2 col-sm-2 col-md-offset-1">
								<h4><span>Give Refund</span></h4>
							</div>
							<div style="clear:both"></div>
							<div class="col-md-3 col-sm-3 col-md-offset-1">
								<h4>Budget</h4>
							</div>
							<div class="col-md-2 col-sm-2 col-md-offset-1">
								<h4>$<?= $job->hired_on;?></h4>
							</div>
							<div style="clear:both"></div>
							</div>
							</div>
						<div class="row">
							
						</div>
							<div class="row">
								<div class="col-md-4 col-sm-4 feedback">
									<h4>Feedback to Freelancer</h4>
								</div>
								<?php if(!empty($freelancerfeedback)) { ?>
										<div class="col-md-4 col-sm-4" id="feedbackbutton">
											<button type="button" id="butcancel" class="btn btn-danger"><?=$freelancerfeedback->feedback_score;?></button>
											<?php  $rating_result = ($freelancerfeedback->feedback_score/5)*100; ?>
											<h4>
												<div title="Rated <?=$freelancerfeedback->feedback_score;?> out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
											<span style="width:<?=$rating_result;?>%">
												<strong itemprop="ratingValue">5</strong> out of 5
											</span>
											</div>
											</h4>
											
										</div>
										<div class="col-md-12 col-sm-12 wdwarfhead wdwarfheadone">
											<h3><?=$freelancerfeedback->feedback_comment;?> </h3>
										</div>
								<?php }else{?>
										<div class="col-md-4 col-sm-4" id="feedbackbutton">
											<div class="col-md-12 col-sm-12 wdwarfhead wdwarfheadone">
												<a href="<?php echo base_url() ?>endhourlyfixed/fixed_freelancer?fmJob=<?php echo base64_encode($job->job_id);?>&buser=<?php echo base64_encode($job->buser_id);?>">
													<input type="button" class="btn btn-primary form-btn" value="Give feedback" />
												</a>
											</div>
													
										</div>
										<div class="col-md-12 col-sm-12 wdwarfhead wdwarfheadone">
											<h3>Waiting For feedback </h3>
										</div>
								<?php } ?>
								<div style="clear:both"></div>
							</div>
							
							<div class="row">
								<div class="col-md-4 col-sm-4 feedback">
									<h4>Feedback to Client</h4>
								</div>
								
								<?php if(!empty($clientfeedback)) { ?>
										<div class="col-md-4 col-sm-4" id="feedbackbutton">
											<button type="button" id="butcancel" class="btn btn-danger"><?=$clientfeedback->feedback_score;?></button>
											<?php  $rating_result = ($clientfeedback->feedback_score/5)*100; ?>
											<h4>
												<div title="Rated <?=$clientfeedback->feedback_score;?> out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
											<span style="width:<?=$rating_result;?>%">
												<strong itemprop="ratingValue">5</strong> out of 5
											</span>
											</div>
											</h4>
											
										</div>
										<div class="col-md-12 col-sm-12 wdwarfhead wdwarfheadone">
											<h3><?=$clientfeedback->feedback_comment;?> </h3>
										</div>
								<?php }else{?>
										<div class="col-md-4 col-sm-4" id="feedbackbutton">
											<button type="button" id="butcancel" class="btn btn-danger">0.00</button>
											<h4>
												<div title="Rated 0 out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
											<span style="width:0%">
												<strong itemprop="ratingValue">5</strong> out of 5
											</span>
											</div>
											</h4>
											
										</div>
										<div class="col-md-12 col-sm-12 wdwarfhead wdwarfheadone">
											<h3>Waiting For feedback </h3>
										</div>
								<?php } ?>
								<div style="clear:both"></div>
							</div>
					</div>
				</div>
			</div>
	</div>
</section>

<!-- Modal -->
<div id="message_convertionModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" onclick="hidemessagepopup();">&times;</button>
			<h4 class="modal-title">Message</h4>
			<div class="col-lg-12 col-md-12 col-sm-12 chat-screen">
				<div class="chat-details-topbar">
					<h3><?=$job->webuser_fname ?> <?=$job->webuser_lname ?></h3>
					<h5><?=$job_title;?> </h5>
									
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
    function loadmessage( b_id, u_id, j_id ){
        
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