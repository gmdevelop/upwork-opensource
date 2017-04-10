<p class="result-msg"></p>
<section id="big_header">
    <div class="container">
        <div class="row">
             <?php
           $this->db->select('*');
$this->db->from('job_accepted');
$this->db->join('job_bids', 'job_bids.id=job_accepted.bid_id', 'inner');
$this->db->join('jobs', 'jobs.id=job_bids.job_id', 'inner');
$this->db->join('webuser', 'webuser.webuser_id=jobs.user_id', 'left');
$this->db->where('job_accepted.buser_id',$value->user_id);

$query=$this->db->get();

$accepted_jobs = $query->result();
  $total_feedbackScore=0 ;
    $total_budget=0 ;
 if(!empty($accepted_jobs)){
    foreach($accepted_jobs as $job_data){
        $this->db->select('*');
        $this->db->from('job_feedback');
        $this->db->where('job_feedback.feedback_userid',$job_data->fuser_id);
        $this->db->where('job_feedback.sender_id !=',$job_data->fuser_id);
        $this->db->where('job_feedback.feedback_job_id',$job_data->job_id);
        $query=$this->db->get();
        $jobfeedback= $query->row();
        
        if($job_data->jobstatus == 1){
            if(!empty($jobfeedback)){
                if($job_data->job_type == "fixed"){
                    $total_price_fixed=$job_data->fixedpay_amount;
                    $total_feedbackScore += ($jobfeedback->feedback_score *$total_price_fixed);
                    $total_budget += $total_price_fixed;
                }else{
                    $this->db->select('*');
                    $this->db->from('job_workdairy');
                    $this->db->where('fuser_id',$job_data->fuser_id);
                    $this->db->where('jobid',$job_data->job_id);
                    $query_done = $this->db->get();
                    $job_done = $query_done->result();
                    $total_work = 0;
                    foreach($job_done as $work){
                        $total_work +=$work->total_hour;
                    }
                    
                    if($job_data->offer_bid_amount) {
                    $amount = $job_data->offer_bid_amount;
                    } else {$amount =  $job_data->bid_amount;} 
                     $total_price= $total_work *$amount;
                    $total_budget += $total_price ;
                    $total_feedbackScore += ($jobfeedback->feedback_score *$total_price);
                }
            }
        }
    }
 }
            
            if($value->status=='0'){?>
            
                <div class="alert alert-warning">
                    <strong>Warning!</strong> The job does not exist.
                </div>
                <?php }
                ?>
            <div class="col-md-9 col-md-offset-0 white-box job-cont">
                <?php
                $marginClass = '';
                if ($this->session->userdata('type') == '1')
                {
                    ?>
                    <?php
                    $marginClass = 'margin-top';
                }
                ?>
                <?php if($value->user_id == $this->session->userdata('id')){ ?>
                <div class="col-md-3 col-sm-6 col-xs-6" style="float: right; font-size: 11px; width: 300px;">
                            <div class="row"> 
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <label class="gray-text">
                                        <span class="hidden-xs hidden-sm margin-10-left">&nbsp;</span>
                                        <a href='<?= site_url('jobs/edit/' . base64_encode($job_id)); ?>'style="color: #37A000">Edit Posting <span class='glyphicon custom_client_icon glyphicon-edit co'></span>
                                        </a>
                                    </label>
                                </div>

                                <div class="col-md-5 col-sm-4 col-xs-12">
                                    <label class="gray-text"> 
                                        <a href="javascript:void(0)" id="endpost" onclick="Confirmremove(<?= base64_encode($job_id) ?>);" class="co">
                                            Remove Posting
                                            <span class='glyphicon custom_client_icon glyphicon-remove co'></span>
                                        </a>
                                    </label>
                                </div>                    
                            </div>
                        </div>
                <?php } ?>
                <div class="row <?php echo $marginClass; ?>">
                    <div class="col-md-10 col-xs-6 page-label">
                        <h1 class="job-title cos_job-title"><?php echo ucfirst($value->title) ?></h1>
                    </div>
                    
                    <div class="col-md-2 col-xs-6 page-label">
                        
                        <span class="pull-right marg-top-neg"><?php
                       // date_default_timezone_set("Asia/Bangkok");
                        $timeDate = strtotime($value->created);
                        $dateInLocal = date("Y-m-d H:i:s", $timeDate);

                        echo \DatetimeHelper::timeElapsedString(strtotime($dateInLocal)); ?></span>
                    </div>
                </div>
                <div class="jobdes-bordered-wrapper">
                <div class="row jobdes-bordered page-label">
                     
                    <div class="col-md-3 text-center">
                        <label class="lab-res">Job Type</label> <br /> <span><?php echo ucfirst($value->job_type) ?></span>
                    </div>
                    <div class="col-md-3 text-center page-label">
                        <label class="lab-res">  
                            <?php
                            if ($value->job_type == 'hourly')
                            {
                                echo "Hourly Per week";
                            } else
                            {
                                echo 'Budget $';
                            }
                            ?>
                        </label><br /><span><?php
                            if ($value->job_type == 'hourly')
                            {
                                echo $value->hours_per_week;
                            } else
                            {
                                echo '$' . round($value->budget, 2);
                            }
                            ?></span>
                    </div>

                    <div class="col-md-3 text-center page-label">
                        <label class="lab-res">Job Duration</label><br /> <span><?php echo str_replace('_', '-', $value->job_duration) ?></span>
                    </div>

                    <div class="col-md-3 last-div text-center page-label">
                        <label class="lab-res">Experience Level</label><br /> <span><?php echo ucfirst($value->experience_level); ?></span>
                    </div>
                   
                </div>
                </div>    
                <div class="row margin-top margin-top-15">
                    <div class="col-md-2">
                        <label class="job-cat">Job Category</label>
                    </div>
                    <div class="col-md-10 margin-top-4">
                       <?php 
                        $this->db->select('*');
                        $this->db->from('job_subcategories'); 
                        $this->db->where('subcat_id',$value->category);
                        $query_done = $this->db->get();
                        $result= $query_done->row();
                        echo $result->subcategory_name;
                       ?>
                    </div>
                    </div>
                <div class="row req-skills margin-top page-label margin-top-1">
                    <div class="col-md-2">
                        <label class="lab-skills">Skills</label>
                    </div>

                    <div class="col-md-10 skills page-label">
						<div class="custom_user_skills">
							<?php
							if (isset($value->job_skills) && !empty($value->job_skills))
							{
								$skills =$value->job_skills;
							 
								if(count($skills)<=1){
									echo "<span> ".$skills[0]['skill_name']."</span> ";
								}else{
									foreach ($skills as $skill)
										echo "<span> ".$skill['skill_name']."</span> ";
								}
								
							}
							?>
						</div>
                    </div>
                </div>

                <div class="row margin-top page-label margin-top-5">
                    <div class="col-md-9">
                        <label class="lab-details">Details</label>
                    </div>
                    <div class="col-md-12 text-justify page-label div-details"><?php echo ucfirst($value->job_description) ?></div>
                </div>
                <?php if($value->tid != 0){ ?>
                <div class="row margin-top page-label margin-top-5">
                    <div class="col-md-9">
                        <label class="lab-details">Attachments</label>
                    </div>
                    <div class="col-md-12 text-justify page-label div-details">
                    <?php 
                    $attachments = explode(",", $value->userfile);
                    foreach($attachments AS $attachment){
                        echo '<a href="'.site_url().'jobs/download?dir='.$value->user_id.'/'.$value->tid.'&file='.str_replace('"','', $attachment).' ">'.str_replace('"','', $attachment).'</a><br>'; 
                    }
                    ?>
                </div>
                </div>
                <?php } ?>
                <div class="jobdes-bordered-wrapper">
                    <div class="row jobdes-bordered page-label">
                        <div class="col-md-4 text-center">
                            <label class="lab-res">Proposals</label> <br /> <span>
                                <?=$applicants;?>
                            </span>
                        </div>

                        <div class="col-md-4 text-center page-label">
                            <label class="lab-res">Interviewing</label><br /> <span><?=$interviews;?> </span>
                        </div>

                        <div class=" last-div col-md-4 text-center page-label">
                            <label class="lab-res">Hired</label><br /> <span>
                                <?php echo $hires ;?>
                            </span>
                        </div>

                    </div> 
                </div>
                <?php /*?>
				<div class="">
					<div class="col-lg-12 col-md-12 col-sm-12 chat-screen">
						<div class="chat-details-topbar">
							<h3><?=$value->webuser_fname?>  <?=$value->webuser_lname?></h3>
							<h5><?=$value->title?></h5>
							<p></p>
						</div>
						<div class="chat-details form-group" style="margin:0;">
							<ul id="scroll-ul">
							<?php
							//$chat_details = array_reverse($chat_details);
							$group_time = false;
							$current_date = strtotime(date("d-m-Y"));
							$date ='';$temp_date ='';
							
							if(!empty($conversations)){
							foreach($conversations as $chat_data) {
							
							if(($chat_data->webuser_picture) == "") { 
								$src = site_url("assets/user.png");
							 } else { 
								$src = base_url().$chat_data->webuser_picture;
							 } 
							
							$temp_date = date("d-m-Y", strtotime($chat_data->created));
							if($date != strtotime($temp_date)){
								$date = strtotime($temp_date);
								$group_time = true;
							}
							else {
								$group_time = false;
							}
							
							if($group_time){
								
							?>
							<li><span class="group-date"><?php if($date == $current_date) { echo "Today";} else { echo date("l, F j, Y", $date);}?></span></li>
							
							<?php } ?>
								<li>							
									<span class="name"><img src="<?=$src?>"><?=$chat_data->webuser_fname?> <?=$chat_data->webuser_lname?></span> <span class="chat-date"><?=date("g:i a", strtotime($chat_data->created))?></span>
									<span id="scroll" class="details"><?=$chat_data->message_conversation?></span>
								</li>
							<?php } }?>

							</ul>
						</div>
						<div class="chat-bar">
							<form id="chat_form" action="">										
							<input type="hidden" id="bid_id" name="bid_id" value="<?=$bid_details->id?>">
							<input type="hidden" name="job_id" id="job_id" value="<?=$value->id?>">
							<input type="hidden" name="user_id" id="user_id" value="<?=$this->session->userdata('id')?>">
							<div style="width:80%;float: left;height: 100px;"><textarea name="chat-input" id="chat-input"></textarea></div>
							<div style="width:20%;float: left;height: 100px;"><a href="javascript:void(0);" id="submit">SEND</a></div>
							</form>
							<span id="error_span" style="color:red;padding: 0 0 0 15px;display:none;"></span>
							<span id="success_span" style="color:green;padding: 0 0 0 15px;display:none;"></span>
						</div>
						
					</div>
				</div>
            <?php */?>
                
            
            
            
                <div class="buttonsidethree">
                    <div class="row margin-top page-label">
                        <div class="col-md-6 col-sm-6">
                            <div class="buttonsidethreeleft">
                                <h2 class="job-his">Job History</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
										
                if(!empty($accepted_jobs)) { 
                    foreach($accepted_jobs as $job_data) {
                        $this->db->select('*');
                        $this->db->from('job_feedback');
                        $this->db->where('job_feedback.feedback_userid',$job_data->fuser_id);
                        $this->db->where('job_feedback.sender_id !=',$job_data->fuser_id);
                        $this->db->where('job_feedback.feedback_job_id',$job_data->job_id);
                        $query=$this->db->get();
                        $jobfeedback= $query->row();
                ?>
                <div class="buttonsidethree">
                    <div class="row  page-label">
                        <div class="col-md-8 col-sm-6">
                            <div class="buttonsidethreeleft">
                                 <p class="title-job-p"><?=$job_data->hire_title?></p>
                                 <h3 class="job-det">
                                 <?php  
                                 
                                 echo date(' M j, Y ', strtotime($job_data->start_date)); ?> 
                                  
                                 <?php if($job_data->jobstatus == 1){  echo " - ". date(' M j, Y ', strtotime($job_data->end_date));  } ?>
                                 </h3>
                                 <p class="job-comment">
                                    <?php
										if($job_data->jobstatus == 1){
                                        if(!empty($jobfeedback)){
                                        echo $jobfeedback->feedback_comment;
									?>
								</p>
											 
											 <p class="job-feedback">
											 <?php
                                            $rating_result = ($jobfeedback->feedback_score/5)*100;
                                        }
                                   }else{
                                         echo "Job in progress";
                                   }
                                    ?>
                              
                                 </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6  text-right pull-right">
                            <?php  if($job_data->jobstatus == 1){ ?>
                                    <div class="buttonsidethreeright margin-right-none">
                            <?php }else{ ?>
                            <div class="buttonsidethreeright pull-right pad-0-margin-0">
                            <?php } ?>
                        
                        <?php if($job_data->job_type == "fixed"){ 
                                 if($job_data->jobstatus == 1){ 
                                     if(!empty($jobfeedback)){ ?>
                                    
                                        <div title="Rated <?=$jobfeedback->feedback_score;?> out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                                        <span style="width:<?=$rating_result;?>%">
                                            <strong itemprop="ratingValue"><?=$jobfeedback->feedback_score;?></strong> out of 5
                                        </span>
                                        </div>
                                        <span class="rate pull-right"><?=$jobfeedback->feedback_score;?></span>
                                    <?php }else{ ?>
                                        <div title="Rated 0 out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                                        <span class="width0">
                                            <strong itemprop="ratingValue">0</strong> out of 5
                                        </span>
                                        </div>
                                        <span class="rate pull-right rate-amount">0.00</span>
                                    <?php }  }?>
                                    
                                         <h3 style='' class="paid">Paid $<?=$job_data->fixedpay_amount?></h3>
                                         <h4></h4>
                                    
                        <?php } else { 
                             if($job_data->jobstatus == 1){
                                     if(!empty($jobfeedback)){ ?>
                                    <div title="Rated <?=$jobfeedback->feedback_score;?> out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                                    <span style="width:<?=$rating_result;?>%">
                                        <strong itemprop="ratingValue"><?=$jobfeedback->feedback_score;?></strong> out of 5
                                    </span>
                                    </div>
                                    <span class="rate pull-right"><?=$jobfeedback->feedback_score;?></span>
                                <?php }else{ ?>
                                    <div title="Rated 0 out of 5" class="star-rating pull-right" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                                    <span class="width0">
                                        <strong itemprop="ratingValue">0</strong> out of 5
                                    </span>
                                    </div>
                                    <span class="rate pull-right">0.00</span>
                                <?php } }?>
                                    
                                     <h6 class="margin-top-8">
                                     <?php
                                     $this->db->select('*');
                                    $this->db->from('job_workdairy');
                                    $this->db->where('fuser_id',$job_data->fuser_id);
                                    $this->db->where('jobid',$job_data->job_id);
                                    $query_done = $this->db->get();
                                    $job_done = $query_done->result();
                                      $total_work = 0;
                                        if(!empty($job_done)){
                                            foreach($job_done as $work){
                                                $total_work +=$work->total_hour;
                                            }
                                            echo $total_work." hours";
                                        }else{
                                            echo "0.00 hours";
                                        }
                                    ?>
                                     
                                     </h6>
                                     <h3 class="job-data">
                                        <?php if($job_data->offer_bid_amount) {
        $amount = $job_data->offer_bid_amount;
        } else {$amount =  $job_data->bid_amount;} ?>
                                        <?php $total_price= $total_work *$amount;?>
                                        $<?=$total_price?> 
                                     </h3>

                        <?php } ?>
                        </div>
                        </div>
                    </div>
                </div>

                <?php } } else { ?>	
                    
                <div class="margin-top page-label">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="buttonsidethreeleft">
                                Yet more Jobs to Go 
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>	
            
          
            </div>
            <?php
            //echo "<pre>";
            //print_r($bids_details);
            ?>   
            <div class="col-md-3 no-pad">
                <?php
                if ($this->session->userdata('type') == '2')
                {
                    if ($applied)
                    {
                        ?>
						
                       <div class="row">
                            <div class="col-md-10 col-md-offset-2">
                                <div class="alert alert-warning">
                                    <strong>You have already applied for this job.</strong>
                                    <?php /*
                                    if ($conversation_count)
                                    {
                                    ?>
                                    <button type="button" class="btn btn-primary form-btn" id="start_chat"  onclick="loadmessage(<?=$bid_details->id?>,<?=$value->user_id?>,<?=$value->id?>)">Message</button>
                                    <?php
                                    } */
                                    ?>
                                </div>
                            </div>
                        </div>
						
                    <?php  } else {  ?>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-2">
								<?php if($ststus->isactive==0){ ?>
										<a class="pad-left" href="javascript:void(0)"><button type="button" class="btn btn-primary">Proposal is in Hold</button></a>
									<?php }elseif ($proposals >= 30){ ?>
                                    <div class="alert alert-warning">
                                        <strong>Warning!</strong> You reach your monthly proposals limit.
                                    </div>
                                    <?php } else { ?>
                                    <a style="padding-left: 0;" href="<?php echo site_url("jobs/apply/" . url_title($value->title) . '/' . base64_encode($value->id)); ?>"><button type="button" class="btn btn-primary custon_send_pro send-pro">Send a Proposal</button></a>
									<?php }?>
                               
								
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
                <div class="row client-activity">
                    <div style="" class="col-md-10 col-md-offset-2 right-section">
                        <div class="row margin-top-2">
                            <div class="col-md-12">
                                
                                <?php
if ($value->isactive && $payment_set) {
    ?>
										<i style="" class="fa fa-check-circle circ-check"></i>
                                        <?php
                                    } else {
                                        ?>
                                        <i style="" class="fa fa-minus-circle circ-min"></i>
                                        <?php
                                    }
                                    ?>
                                <label class="pad-25"><?php echo ucfirst($value->webuser_fname) ?></label>
                                
                                
                            </div>
                        </div>
                        <div style="" class="row margin-top-2 border-bottom right-cont">
                            <div class="col-md-8 ">
								<?php if($total_feedbackScore !=0 && $total_budget!=0){
                                $totalscore = ($total_feedbackScore / $total_budget);
                                $rating_feedback = ($totalscore/5)*100;
                               ?>
                                <button style="" class="totscore" id="buttonfirst"><?=number_format((float)$totalscore,1,'.','');?></button>
								<div title="Rated <?=$totalscore;?> out of 5" class="star-rating revrat" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
								<span style="width:<?=$rating_feedback;?>%">
									<strong itemprop="ratingValue"><?=$totalscore;?></strong> out of 5
								</span>
								</div>
							<?php  }else{ ?>
                             <button style="" class="totscore"  id="buttonfirst">0.0</button>
								<div style="" title="Rated 0 out of 5" class="star-rating revrat" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
								<span class="width0">
									<strong itemprop="ratingValue">0</strong> out of 5
								</span>
								</div>
                          <?php   } ?>
                               
                            </div>
                        </div>
                        <div style="" class="row margin-top-2 border-bottom job-posted">
                            <div class="col-md-12">
                                <label style="" class="label-side">
                                   <?php if(!empty($record_sidebar)){
                                        echo count($record_sidebar);
                                    }else{
                                        echo "0";
                                    } ?>
								<span class="span-side">Jobs Posted</span>
								</label>
                            </div>
                        </div>
                        <div class="row margin-top-2 border-bottom hired">
                            <div class="col-md-12">
                                <label style="" class="label-side">
								<?=$hire;?> 
								<span class="span-side">Hired</span>
								</label>
                            </div>
                        </div>
                        <div style="" class="row margin-top-2 border-bottom total-work">
                            <div class="col-md-12">
                                <label style="" class="label-side">
								<?php $total_work = 0;
                                    if(!empty($workedhours)){
                                        foreach($workedhours as $work){
                                            $total_work +=$work->total_hour;
                                        }
                                        echo $total_work." <span class='total-works'>Hours</span>";
                                    }else{
                                        echo " 0 <span class='total-works'>Hours Worked</span>";
                                    }?>
								</label>
                            </div>
                        </div>

                        <div class="row margin-top-2 border-bottom hired">
                            <div class="col-md-12">
                                <label style="" class="label-side">
								$<?php echo round($total_spent,0);?>
								<span class="span-side">Spent</span>
								</label>
                            </div>
                        </div>
                        <div class="row margin-top-2 border-bottom">
                            <div style="" class="maste">
								
								<i class="fa fa-map-marker"></i>
								
								<label style="" class="label-side">
								<span class="span-side"><?php
                                $this->db->where('country_id', $value->webuser_country);
                                $q = $this->db->get('country');
                                $record = $q->row();
                                echo ucfirst($record->country_name);
                                ?></span>
								</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

</section>

</div>

</section>
<!-- big_header-->

<hr>

</div>

 

<script src="<?php echo base_url() ?>assets/js/dropzone.js"></script>
<script>

</script>

                      
<!-- Modal -->
<div id="message_convertionModal" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="hidemessagepopup()">&times;</button>
        <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body">
        <div class="job_details">
            <h3><?php echo $value->webuser_fname;?> <?php echo $value->webuser_lname;?>
            <span class="job_create" style="font-size: 13px;"><?php  echo date(' F j, Y g:i A', strtotime($value->created)); ?></span></h3>
           <span><?php echo $value->title;?></span>
        </div>
        <hr>
       <div class="message_lists" ></div>
       <hr>
      
           
           <form name="message" action="" method="post" id="conversion_message">
             <textarea name="usermsg"  id="usermsg"></textarea>
               <input name="job_id" type="hidden" id="job_id"  value="<?php echo $value->id;?>" />
               <input name="bid_id" type="hidden" id="bid_id"  value="<?php echo $bid_details->id;?>"  />
               <input name="sender_id" type="hidden" id="sender_id"  value="<?php echo $this->session->userdata('id');?>"  />
               <input name="receiver_id" type="hidden" id="receiver_id"  value="<?php echo $value->user_id;?>"  />
             <input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
         </form>
       </div>
    </div>
 </div>
</div>
            


 <script>
    $( document ).ready(function() {
        
    //	$("#submitmsg").on("click", function(e) {
    //       e.preventDefault();
    //       var usermsg = $("#usermsg").val();
    //       if( usermsg === ''){
    //            return false;
    //        }
    //        	var fd = new FormData(document.querySelector("form#conversion_message"));
    //         $.ajax({
    //            url: "<?php echo site_url('jobconvrsation/add_conversetion');?>",
    //            type: "POST",
    //            data: fd,
    //            processData: false, 
    //            contentType: false,   
    //            success     : function(data){
    //                $("#usermsg").val("");
    //                $.ajax({
    //                    url: "<?php echo site_url('jobconvrsation/current_conversetion?lastid=');?>"+data,
    //                    type: "POST",
    //                    processData: false, 
    //                    contentType: false,   
    //                        success     : function(result){
    //                            $("#chatbox").css('display','block');
    //                           $("#chatbox_details ul").append(result);
    //                           $('#mylist').animate({scrollTop: $('#mylist').prop("scrollHeight")}, 500);
    //                        }
    //                    });
    //            }
    //         });
    //        });

//var modal = document.getElementById('message_convertionModal');
//var btn = document.getElementById("start_chat");
//var span = document.getElementsByClassName("close")[0];
//btn.onclick = function() {
//    modal.style.display = "block";
//    $('#mylist').animate({scrollTop: $('#mylist').prop("scrollHeight")}, 500);
//}
//span.onclick = function() {
//    modal.style.display = "none";
//}
//
//window.onclick = function(event) {
//    if (event.target == modal) {
//        modal.style.display = "none";
//    }
//}
//            
//            
            
        });
    
    
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
                        alert('Opps!! Something went wrong.')
                    }
                   
                }, 'json');
          }
         
    });
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
		}, 'json');
    }
    
    function loadmessage_auto( b_id, u_id, j_id ){
		var modal = document.getElementById('message_convertionModal');
        $.post("<?php echo site_url('jobconvrsation/message_from_superhero');?>", { job_bid_id:b_id, user_id : u_id, job_id : j_id },  function(data) {
			$('.message_lists').html(data.html);
           
          //  $('.message_lists').animate({scrollTop: $('.message_lists').prop("scrollHeight")}, 500);
		}, 'json');
    }
    
    function hidemessagepopup(){
        var modal = document.getElementById('message_convertionModal');
        modal.style.display = "none";
    }
    
    var auto_job_id = $('#job_id').val();
    var auto_bid_id = $('#bid_id').val();
    var auto_receiver_id = $('#receiver_id').val();
   
    if (auto_job_id) { auto_job_id = auto_job_id;}else{auto_job_id = 0}
    if (auto_bid_id) { auto_bid_id = auto_bid_id;}else{auto_bid_id = 0}
    if (auto_receiver_id) { auto_receiver_id = auto_receiver_id;}else{auto_receiver_id = 0}
    
    if (auto_job_id && auto_bid_id && auto_receiver_id) {
       setInterval('loadmessage_auto( '+auto_bid_id+', '+auto_receiver_id+', '+auto_job_id+' )', 5000);
    }
    
    
function Confirmremove(id) {

	var x = confirm("Are you sure you want to Remove the post?");
	
	if (x){
		$.post("<?php echo site_url('jobs/removepost');?>", { form : id },  function(data) {
			if(data.success){
				$('.result-msg').html('You have successfully Remove the Post');
					$(".result-msg").show().delay(5000).fadeOut();
					$('html, body').animate({    scrollTop: $(".result-msg").offset().top}, 2000);
					setTimeout(function(){ window.location = "<?php echo base_url();?>jobs-home"; }, 5000);
					
			} else{
					alert('Opps!! Something went wrong.');
			}
		   
		}, 'json');
	}
}     
    
    
  </script>