<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){
		parent::__construct();

		if($this->session->userdata('is_logged_in')==0){
			redirect('/'); 
		}
		$this->load->model('AdminModel');
        // ============= Loading Language ==================
        if (empty($this->session->userdata('site_lang'))) {
            $language = "english";
            $siteLang = $this->session->set_userdata('site_lang', $language);
            $lang = 'en';
            $this->lang->load('homecont', $language);
        }
        if ($this->session->userdata('site_lang') == 'en') {
			$language = "english";
            $lang = 'en';
            $this->lang->load('homecont', $language);
        }
		if ($this->session->userdata('site_lang') == 'zu') {
			$language = "zulu";
            $lang = 'zu';
            $this->lang->load('homecont', $language);
        }
		if ($this->session->userdata('site_lang') == 'xh') {
			$language = "xhosa";
            $lang = 'xh';
            $this->lang->load('homecont', $language);
        }
	}

	public function index($term=null)
	{
        if($term=='requests')
        {
            $btype = '';
        }
        if($term=='calls')
        {
            $btype = 2;
        }
        if($term=='consultations')
        {
            $btype = 3;
        }
        
		$data['booking_info'] = $this->AdminModel->get_booking_info($btype);
        $data['term'] = $term;
		$this->load->view('admin/booking/bookinglist', $data);
	}

    public function getbookinginfo()
    {
        $bid = $this->input->post('bid');
        $bookingdata = $this->AdminModel->getbookinginfo($bid);
        // echo "<pre>";
        // print_r($bookingdata);
        // echo "</pre>";
        $btm = explode(":", $bookingdata->booking_time);
        
        ?>
        <form class="row g-3" method="post" action="<?php echo base_url('BookingController/updatebooking');?>">
            <input type="hidden" name="bid" value="<?php echo $bookingdata->id;?>">
            <input type="hidden" name="uid" value="<?php echo $bookingdata->user_id;?>">
            <input type="hidden" name="cid" value="<?php echo $bookingdata->centre_id;?>">
            <input type="hidden" name="bdt" value="<?php echo $bookingdata->booking_date;?>">
            <div class="col-md-12">
                <strong>Booking For: <h2 style="color:#1d9397;"><?php echo centre_info('centre_name', $bookingdata->centre_id)->centre_name;?></h2>
                On: <span style="color:#f38446;"><?php echo date("D jS M, Y", strtotime($bookingdata->booking_date));?></span>
                </strong>
            </div>
            <div class="col-md-12">
                
                    <?php
                        $userdata = getuserdata($bookingdata->user_id);
                        //print_r($userdata);
                    ?>
                    User Name: <h5><span style="color:#1d9397;"><?php echo $userdata->userfname;?></span></h5>
                    User Email: <h5><span style="color:#1d9397;"><?php echo $userdata->usermail;?></span></h5>
                    User Phone: <h5><span style="color:#1d9397;"><?php echo $userdata->userphone;?></span></h5>
                
            </div>
            
            <div class="col-md-12">
                <label for="cat_name_en" class="form-label">Booking Type </label><br>
                <strong><?php 
                if($bookingdata->booking_type=='1')
                {
                    echo "Booked Appointment";
                }
                if($bookingdata->booking_type=='2')
                {
                    echo "Requested A Call";
                }
                if($bookingdata->booking_type=='3')
                {
                    echo "Requested Tele-Consultation";
                }
                ?></strong>
            </div>
            <div class="col-md-6">
                <label for="cat_name_zu" class="form-label">Assign Booking Status</label>
                <select name="book_status" class="form-control">
                    <option value="0" <?php if($bookingdata->status==0){ echo 'selected';}?>>Received</option>
                    <option value="1" <?php if($bookingdata->status==1){ echo 'selected';}?>>On Process</option>
                    <option value="2" <?php if($bookingdata->status==2){ echo 'selected';}?>>Booked Slot</option>
                    <option value="3" <?php if($bookingdata->status==3){ echo 'selected';}?>>Reschedule</option>
                    <option value="4" <?php if($bookingdata->status==4){ echo 'selected';}?>>Cancel</option>
                </select>
                <label></label>
            </div>
            <div class="col-md-6">
                <label for="cat_name_st" class="form-label">If Reschedule</label>
                <?php
                if($bookingdata->schedule_date)
                {
                    ?><input type="date" class="form-control" name="reschedule_date" value="<?php echo date("Y-m-d", strtotime($bookingdata->schedule_date));?>"><?php
                }
                else
                {
                    ?><input type="date" class="form-control" name="reschedule_date" value="<?php echo date("Y-m-d", strtotime($bookingdata->booking_date));?>"><?php
                }
                ?>
                <label></label>
            </div>
            <div class="row col-md-6">
                <label for="cat_name_zu" class="form-label">Assign Booking Time</label>
                    <div class="col-md-6">
                        <select name="book_hour" class="form-control">
                            <?php
                                for($tm=0; $tm<24; $tm++)
                                {
                                    if($btm[0]==$tm)
                                    {
                                        printf("<option value='%02d' selected>%02d</option>", $tm, $tm);
                                    }
                                    else
                                    {
                                        printf("<option value='%02d'>%02d</option>", $tm, $tm);
                                    }
                                }
                            ?>
                        </select>&nbsp;Hr(s)
                    </div>
                    <div class="col-md-6">
                        <select name="book_min" class="form-control">
                            <?php
                                for($tmm=0; $tmm<60; $tmm++)
                                {
                                    if($btm[1]==$tmm)
                                    {
                                        printf("<option value='%02d' selected>%02d</option>", $tmm, $tmm);
                                    }
                                    else
                                    {
                                        printf("<option value='%02d'>%02d</option>", $tmm, $tmm);
                                    }
                                }
                            ?>
                        </select>&nbsp;Min(s)
                    </div>
                <label></label>
            </div>
            <div class="col-md-12">
                <textarea class="form-control" name="admin_remark" id="admin_remark"><?php echo $bookingdata->admin_remark;?></textarea>
            </div>
            <div class="col-12">
                <input type="submit" class="btn btn-primary px-5" value="Update Booking" name="addcat">
            </div>
        </form>
        <?php
    }

    public function updatebooking()
    {
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";

        $bid = $this->input->post('bid');
        $bookingdata = $this->AdminModel->getbookinginfo($bid);
        // echo "<pre>";
        // print_r($bookingdata);
        // echo "</pre>";

        // die();

        // $bid = $this->input->post('bid');
        $uid = $this->input->post('uid');
        $cid = $this->input->post('cid');
        $bdt = $this->input->post('bdt');
        $sdt = $this->input->post('reschedule_date');
        $bt = $this->input->post('book_hour').":".$this->input->post('book_min');

        $udata = getuserdata($uid);
        $lang = $bookingdata->booking_lang;
        // echo "<pre>";
        // print_r($udata);
        // echo "</pre>";
        // die();

        $bookstatus = $this->input->post('book_status');

        $val = array("status"=>$bookstatus, "schedule_date"=>$this->input->post('reschedule_date'), "admin_remark" => $this->input->post('admin_remark'), "booking_time" => $bt);
        $id = $this->AdminModel->update_booking($val, $bid);
        if($id)
        {
            if($bookstatus==0 || $bookstatus==1)
            {
                $usermail = getusermail($uid)->usermail;
                $cntname = centre_info('centre_name',$cid);
                $status = sendbookingacceptmail($usermail, $cntname->centre_name, $bdt);
            }
            if($bookstatus==2)
            {
                $usermail = getusermail($uid)->usermail;
                $cntname = centre_info('centre_name',$cid);
                $status = sendbookingconfirmmail($usermail, $cntname->centre_name, $bdt, $bt);
                
                if($udata->deviceid)
                {
                    $dtype = get_device_type($udata->deviceid);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_booking_push($udata->deviceid, "Booking confirmed for ".$cntname->centre_name."", "On ".date("dS M,Y", strtotime($bdt))." - ".$bt.". Please check your email (including junk) for further information.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_booking_push($udata->deviceid, "Ukubhukha kuqinisekisiwe kwe-".$cntname->centre_name."", "Vuliwe ".date("dS M,Y", strtotime($bdt))." - ".$bt.". Sicela uhlole i-imeyili yakho (kuhlanganise nodoti) ukuze uthole ulwazi olwengeziwe.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_booking_push($udata->deviceid, "Booking e netefalitsoe bakeng sa ".$cntname->centre_name."", "E butsoe ".date("dS M,Y", strtotime($bdt))." - ".$bt.". Ka kopo, sheba lengolo-tsoibila la hau (ho kenyeletsoa le litšila) bakeng sa lintlha tse ling.", "individual", 0, $dtype->devicetype);
                    }
                }
            }
            if($bookstatus==3)
            {
                $usermail = getusermail($uid)->usermail;
                $cntname = centre_info('centre_name',$cid);
                $status = sendbookingreschedulemail($usermail, $cntname->centre_name, $bdt, $sdt, $bt);

                if($udata->deviceid)
                {
                    $dtype = get_device_type($udata->deviceid);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_booking_push($udata->deviceid, "Booking rescheduled for ".$cntname->centre_name."", "On ".date("dS M,Y", strtotime($sdt))." - ".$bt.". Please check your email (including junk) for further information.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_booking_push($udata->deviceid, "Ukubhukha kuhlehliselwe kabusha ".$cntname->centre_name."", "Vuliwe ".date("dS M,Y", strtotime($sdt))." - ".$bt.". Sicela uhlole i-imeyili yakho (kuhlanganise nodoti) ukuze uthole ulwazi olwengeziwe.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_booking_push($udata->deviceid, "Peeletso e hlophisitsoe bocha bakeng sa ".$cntname->centre_name."", "E butsoe ".date("dS M,Y", strtotime($sdt))." - ".$bt.". Ka kopo, sheba lengolo-tsoibila la hau (ho kenyeletsoa le litšila) bakeng sa lintlha tse ling.", "individual", 0, $dtype->devicetype);
                    }
                }
            }
            if($bookstatus==4)
            {
                $usermail = getusermail($uid)->usermail;
                $cntname = centre_info('centre_name',$cid);
                $status = sendbookingcancelledmail($usermail, $cntname->centre_name, $bdt);

                if($udata->deviceid)
                {
                    $dtype = get_device_type($udata->deviceid);
                    // $dtype->devicetype
                    if($lang=='en')
                    {
                        send_booking_push($udata->deviceid, "Booking cancelled for ".$cntname->centre_name."", "On ".date("dS M,Y", strtotime($bdt)).". Please check your email (including junk) for further information.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='zu')
                    {
                        send_booking_push($udata->deviceid, "Ukubhukha kukhanseliwe ".$cntname->centre_name."", "Vuliwe ".date("dS M,Y", strtotime($bdt)).". Sicela uhlole i-imeyili yakho (kuhlanganise nodoti) ukuze uthole ulwazi olwengeziwe.", "individual", 0, $dtype->devicetype);
                    }
                    if($lang=='st')
                    {
                        send_booking_push($udata->deviceid, "Pehelo e hlakotsoe ".$cntname->centre_name."", "E butsoe ".date("dS M,Y", strtotime($bdt)).". Ka kopo, sheba lengolo-tsoibila la hau (ho kenyeletsoa le litšila) bakeng sa lintlha tse ling.", "individual", 0, $dtype->devicetype);
                    }
                }
            }

            $this->session->set_flashdata('success', 'Booking Updated successfully!');
            redirect('booking/requests');
        }
        else
        {
            $this->session->set_flashdata('error', 'Booking not updated. Please try again!');
            redirect('booking/requests');
        }
    }
}
