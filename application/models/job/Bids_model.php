<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of bids_model
 *
 * @author Hermannovich <donfack.hermann@gmail.com>
 */
class Bids_model extends CI_Model {
    
    public function load_informations( $bid_id )
    {
        $query = $this->db->select('*')
                    ->from('job_bids')
                    ->where('id', $bid_id)
                    ->get();
        
        return $query->row();
    }
    
    public function load($job_id, $fuser_id){
        
        $this->db->select('*');
        $this->db->from('job_bids');
        $this->db->where('user_id', $fuser_id);
        $this->db->where('job_id', $job_id);

        $query = $this->db->get();
        return $query->row(); 
    }
   
    public function remaing_to_pay($job_id, $fuser_id) {
        
        $bid = $this->load($job_id, $fuser_id);
        $remaining = $bid->bid_amount - $bid->fixedpay_amount ;
        
        if($remaining < 0)
            return 0;
        
        return $remaining;
    }
    
    public function update_fixedpay_amount($job_id, $fuser_id, $amount){
        
        $bid = $this->load($job_id, $fuser_id);
        $updated_data['fixedpay_amount'] = $bid->fixedpay_amount + (int) $amount;
        
        $this->db->where('user_id', $fuser_id);
        $this->db->where('job_id', $job_id);
        $this->db->update('job_bids', $updated_data);
    }
    
    public function update_field($bid_id, $field, $value)
    {
        $this->db->where('id', $bid_id);
        $this->db->update('job_bids', array($field => $value));
    }
    
    
    public function hire_on($job_id, $applier_id, $budget)
    {
        return $this->db->where('job_id', $job_id)
                    ->where('user_id', $applier_id)
                    ->update('job_bids', array('hired_on' => $budget));
    }
    
    public function update($data, $conditions)
    {
		
        foreach($conditions as $field =>  $value)
        {
            $this->db->where($field, $value);
        }
        
        return $this->db->update('job_bids', $data);
    }
        
    public function insert_bid($data){
        $this->db->insert('job_bids', $data);
        return $this->db->insert_id();
    }
    
    public function add_bid_attachment($dataAttach){
        return $this->db->insert('job_bid_attachments', $dataAttach);
    }
	
	/**
	 * @param array|object $bid
	 *
	 * @return bool
	 */
    public function isOffer($bid)
	{
		$bid = (object) $bid;

		return $bid->job_progres_status == 2
			&& is_null($bid->withdrawn)
			&& $bid->hired == 1;
	}
	
	/**
	 * @param array|object $bid
	 *
	 * @return bool
	 */
    public function isWithdrawn($bid)
	{
		$bid = (object) $bid;

		return $bid->hired == 0
			&& $bid->withdrawn == 1;
	}
	
	/**
	 * @param array|object $bid
	 *
	 * @return bool
	 */
    public function isRejected($bid)
	{
		$bid = (object) $bid;

		return $bid->hired == 0
			&& $bid->bid_reject == 1;
	}
	
	/**
	 * @param array|object $bid
	 * @param array|object $job
	 *
	 * @return bool
	 */
    public function isExpired($bid, $job)
	{
		$bid = (object) $bid;
		$job = (object) $job;

		$expire_job_date = \Carbon\Carbon::now(new DateTimeZone('UTC'));

		return $bid->status == 0
			&& $bid->bid_reject == 0
			&& is_null($bid->withdrawn)
			&& strtotime($job->created) < $expire_job_date->subDays(POSTED_JOB_VALID_DURATION)->timestamp;
	}
}
