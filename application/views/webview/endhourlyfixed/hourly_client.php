<script src="<?php echo base_url()?>assets/js/star-rating.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<style>
.rating span{ background: none; color: #eba705 !important;	}
.clear-rating {  display: none !important;}
.rating-container .empty-stars span.star {  color: #aaa !important;}
.information_area #Comment {  padding-top: 0px !important;}
.rating-container .filled-stars {  top: 2px;}
</style>
<div class="container">
<section class="information_area">
		<!--
		<a href="<?php echo base_url() ?>feedback/hourly_client?fmJob=<?php echo base64_encode($job->job_id);?>&fuser=<?php echo base64_encode($job->fuser_id);?>">
		<input type="button" class="btn btn-primary form-btn" value="See Feeedback" style="float: right;" />
	</a>-->
 <form class="form-horizontal" method="post" id="end_contact_from">
	<div class="form-group">   
	  <label for="" class="col-sm-4 control-label"><span>Confirm your End Contact</span></label>
	</div>
	<div class="form-group">   
		<label for="" class="col-sm-3 control-label"></label>
	   <div class="col-sm-1">
						<?php  if($job->webuser_picture !=""){ ?>
									<img src="<?php echo base_url().$job->webuser_picture ?>" width="64" height="64" />
								<?php }else{ ?>
								<img src="<?php echo base_url()?>assets/img/Untitled-1.png">
								<?php  } ?>
		</div>
		<div class="col-sm-3" id="name">
			<h3><a href="<?php echo base_url()."interview?user_id=".base64_encode($job->webuser_id)."&job_id=".base64_encode($job->job_id)."&bid_id=".base64_encode($job->bid_id);?>">
								<label class="blue-text"><?=$job->webuser_fname ?> <?=$job->webuser_lname ?></label>
								</a></h3>
		<h4> <?=$job->webuser_company ?>		</h4>
		</div>
	</div>
  <div class="form-group">   
	  <label for="" class="col-sm-3 control-label" id="leftname">Job Title  </label>
	   <div class="col-sm-5" id="righttext">
		<h3><span><?php if($job->hire_title !=""){
							$job_title = $job->hire_title;
						}else{
							$job_title = $job->title;
						}?>
						<?=$job_title;?> </span>
		</h3>
		</div>
	</div>
  
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Contact id</label>
    <div class="col-sm-4" id="righttext">
      <h3><?=$job->contact_id ?></h3>
    </div>
  </div> 
  
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Hourly rate</label>
    <div class="col-sm-2" id="righttext">
					<?php if($job->offer_bid_amount !=""){
							$job_price = $job->offer_bid_amount;
						}else{
							$job_price = $job->bid_amount;
						}?>
		
					
      <h3>$<?=$job_price;?>/hr</h3>
    </div>
  </div>
  
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Since Start</label>
    <div class="col-sm-5" id="righttextone">
        <?php
			 
			
									$this->db->select('*');
								   $this->db->from('job_workdairy');
								   $this->db->where('fuser_id',$job->fuser_id);
								   $this->db->where('jobid',$job->job_id); 
								   $query_done = $this->db->get();
								   $job_done = $query_done->result();
									 $total_work_cweek = 0;
									   if(!empty($job_done)){
										   foreach($job_done as $work){
											   $total_work_cweek +=$work->total_hour;
										   }
										    $total_work_cweek." hrs this week";
									   }
								?>
		<h3><?php echo $total_work_cweek; ?> hrs  ,<?php echo $total_work_cweek*$job->bid_amount;?>$ &nbsp; &nbsp;<span>View work diary</span></h3>
    </div>
  </div> 
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Start Date</label>
    <div class="col-sm-4" id="righttext">
  <h3><?php  echo date(' F j, Y ', strtotime($job->start_date)); ?></h3>
    </div>
  </div>  
  
  <!--<div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">End Date</label>
    <div class="col-sm-4" id="righttext">
      <h3><?php echo date(' F j, Y ',strtotime(' + 5 day', strtotime($job->start_date)));?></h3>
    </div>
  </div> -->
  
   <div class="form-group">
    <label for="" class="col-sm-3 control-label" ><span>Feedback to contactor</span></label>
  </div> 
  
   <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Skills</label>
    <div class="col-sm-9" id="righttextstar">
     <input id="skills" value="0" type="number" class="rating" name="skills" min=0 max=5 step=0.5 data-size="xs" >
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Quality</label>
    <div class="col-sm-4" id="righttextstar">
       <input id="quality" value="0" type="number" class="rating" name="quality" min=0 max=5 step=0.5 data-size="xs" >
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname"> Ability </label>
    <div class="col-sm-4" id="righttextstar">
      <input id="ability" value="0" type="number" class="rating" name="ability" min=0 max=5 step=0.5 data-size="xs" >
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Deadline</label>
    <div class="col-sm-4" id="righttextstar">
       <input id="deadline" value="0" type="number" class="rating" name="deadline" min=0 max=5 step=0.5 data-size="xs" >
    </div>
  </div>
    <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">communication </label>
    <div class="col-sm-4" id="righttextstar">
       <input id="communication" value="0" type="number" class="rating" name="communication" min=0 max=5 step=0.5 data-size="xs" >
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-3 control-label" id="leftname">Score</label>
    <div class="col-sm-4" id="righttextstar">
       <input id="score" value="0.00" type="text" name="score" readonly >
    </div>
  </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="Comm" id="leftname">Feedback Comment
        </label>
      <div class="col-sm-4">
        <textarea  class="form-control" id="Comment" placeholder="" name="Comment"></textarea>
								<div class="error"></div>
      </div>
    </div>
  
  <div class="form-group btn_center">
    <div class="col-sm-offset-3 col-xs-12 col-sm-2">
						<input name="job_id" type="hidden" id="job_id"  value="<?=$job->job_id ?>"  />
							<input name="user_id" type="hidden" id="user_id"  value="<?=$job->fuser_id ?>"  />
						<input name="clientid" type="hidden" id="clientid"  value="<?=$job->buser_id ?>"  />
						<input name="sender_id" type="hidden" id="sender_id"  value="<?=$job->buser_id ?>"  />
						
      <button type="button" class="btn btn-default" id="end_contact">
		<?php if($job->jobstatus ==1){
			echo "Give Feedback";
		}else{
			echo "End contact";
		}
		?>
	  </button>
	  
	  
						<img src='/assets/img/version1/loader.gif' class="form-loader" style="display:none">
    </div>
	<div class="col-xs-12 col-sm-1">
      <button type="button" class="btn btn-default btn_background">Cancel</button>
    </div>
	<p class="result-msg" style="text-align: center;color: green;font-size: 20px;display: none;"></p>
  </div>
</form>
</section><!-- End form_area-->
</div>
<script>
    //jQuery(document).ready(function () {
    //    $('#input-21e').on('rating.change', function() {
    //        alert($('#input-21e').val());
    //    });
    //});
</script>
<script>
	$(document).ready(function () {
		$('#end_contact').on('click', function(e) {
			e.preventDefault;
			
			var $form = $("#end_contact_from");
			var confo_notes = $('#Comment').val();
			if(confo_notes===""){
				$('.error').text("enter some value");
				return false;
			}
			$('.form-loader').show();
			
			
			
			$.post("<?php echo site_url('endhourlyfixed/end_contactfromSubmit');?>", { form: $form.serialize() },  function(data) {

					if(data.success){
							$form[0].reset();
							$('.form-loader').hide();
							$('.result-msg').html('You have successfully complete the offer the offer');
							$(".result-msg").show().delay(5000).fadeOut();
							setTimeout(function(){ window.location = "<?php echo base_url();?>jobs/pasthire"; }, 5000);
					}
					else{
							alert('Opps!! Something went wrong.');
					}
			   
			}, 'json');
			
			
			
			
		});
	});
	
	

</script>
<script>
var deadline = 0;
var skills = 0;
var quality = 0;
var communication = 0;
var ability = 0;

$('#deadline').on('rating.change', function(event, value, caption) {
	deadline = parseFloat($('#deadline').val());
	skills = parseFloat($('#skills').val());
	quality = parseFloat($('#quality').val());
	communication = parseFloat($('#communication').val());
	ability = parseFloat($('#ability').val());
	var total = deadline + skills + quality + communication + ability;
	var score = total/5;
	$('#score').val(score);
});

$('#skills').on('rating.change', function(event, value, caption) {
	deadline = parseFloat($('#deadline').val());
	skills = parseFloat($('#skills').val());
	quality = parseFloat($('#quality').val());
	communication = parseFloat($('#communication').val());
	ability = parseFloat($('#ability').val());
	var total = deadline + skills + quality + communication + ability;
	var score = total/5;
	$('#score').val(score);
});

$('#quality').on('rating.change', function(event, value, caption) {
	deadline = parseFloat($('#deadline').val());
	skills = parseFloat($('#skills').val());
	quality = parseFloat($('#quality').val());
	communication = parseFloat($('#communication').val());
	ability = parseFloat($('#ability').val());
	var total = deadline + skills + quality + communication + ability;
	var score = total/5;
	$('#score').val(score);
});

$('#communication').on('rating.change', function(event, value, caption) {
	deadline = parseFloat($('#deadline').val());
	skills = parseFloat($('#skills').val());
	quality = parseFloat($('#quality').val());
	communication = parseFloat($('#communication').val());
	ability = parseFloat($('#ability').val());
	var total = deadline + skills + quality + communication + ability;
	var score = total/5;
	$('#score').val(score);
});

$('#ability').on('rating.change', function(event, value, caption) {
	deadline = parseFloat($('#deadline').val());
	skills = parseFloat($('#skills').val());
	quality = parseFloat($('#quality').val());
	communication = parseFloat($('#communication').val());
	ability = parseFloat($('#ability').val());
	var total = deadline + skills + quality + communication + ability;
	var score = total/5;
	$('#score').val(score);
});
</script>