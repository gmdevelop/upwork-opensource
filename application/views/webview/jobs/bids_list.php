<?php
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array(365 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );
    $a_plural = array('year' => 'years',
        'month' => 'months',
        'day' => 'days',
        'hour' => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

$this->db->select('*');
$this->db->from('job_bids');
$this->db->where(array('bid_reject' => 0, 'status!=1' => null));
$this->db->where('user_id', $this->session->userdata(USER_ID));
$this->db->where('job_progres_status', 0);
$this->db->where(array('withdrawn' => NULL)); 

$query_totalApplication = $this->db->get();
$Application_count = $query_totalApplication->num_rows();
if ($Application_count) {
    $totalApplication = $Application_count;
} else {
    $totalApplication = 0;
}


$this->db->select('*');
$this->db->from('job_bids');
$this->db->where('user_id', $this->session->userdata(USER_ID));
$this->db->where('job_bids.status', '1');
$this->db->where("(withdrawn=1 OR bid_reject=1)", NULL, FALSE);

$query_totalreject = $this->db->get();
$reject_count = $query_totalreject->num_rows();
if ($reject_count) {
    $totalrejact = $reject_count;
} else {
    $totalrejact = 0;
}



?>
<section id="big_header" class="custom_bids_list">
    <div class="white-box-feed">
        <?php if ($this->session->flashdata('msg'))
        { ?>
            <div class="row alert alert-success"><?php echo $this->session->flashdata('msg'); ?></div>
<?php } ?>
        <div class="row">
            <div class="col-md-12 bottom-blue-border  padding-2">
                <span><a href="<?php echo site_url('jobs/bids_list'); ?>"><b>My Bids (<?= $totalApplication ?>) </b></a></span>
                <span class="margin-left-15"><a href="<?php echo site_url('jobs/archived_bids_list'); ?>"><b>Archived (<?= $totalrejact ?>)</b></a></span>
            </div>
        </div>
            <div class="row margin-top-1" >
			<div class="col-md-9 bordered-alert text-center ack-box">
                            <h4>! You have sent  <?= $totalApplication; ?> proposals</h4>
			 </div>
		</div>
        <div class="row margin-top-3 margin-top-15">
            <div class="col-md-2 col-sm-6 col-xs-6">
                <label>Applied Date</label>
            </div>
            <div class="col-md-10 col-sm-6 col-xs-6 marg-38">
                <label>Job Title</label>
            </div>
        </div>
<?php if(empty($records)) {?>
        <div class="row">
            <div style="text-align: center;margin-top: 12px;" class="col-md-9 custom_bids_list_border">
                No Bids Available
            </div>
        </div>
<?php } else {?>

        <div class="row">
            <div class="col-md-12 margin-top-15 no-pad">
                <?php foreach($records as $value) { ?>
                    <div class="custom_bids_list_border">
                        <div class="row">
                            <div class="col-md-2 col-sm-6 col-xs-6"><?php echo date('M d, Y',  strtotime($value->created));?></div>
                            <div class="col-md-10 col-sm-6 col-xs-6 blue-text">
                                <a href='<?php echo site_url("jobs/withdraw_system/".  base64_encode($value->id))?>'>
                                    <?php echo ucfirst($value->title); ?>
                                </a>
                            </div>
                        </div>

                        <div class="row margin-top-1">
                            <div class="col-md-2 col-sm-6 col-xs-6"><?php
                            
                            $timeDate = strtotime($value->created);
                            $dateInLocal = date("Y-m-d H:i:s", $timeDate);
                            
                            echo time_elapsed_string(strtotime($dateInLocal)); ?></div>
                            <div class="col-md-10 col-lg-10 col-sm-6 col-xs-6">
                                <?php echo ucfirst($value->company); ?><br/>
                                
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php } ?>
    </div>
</section>