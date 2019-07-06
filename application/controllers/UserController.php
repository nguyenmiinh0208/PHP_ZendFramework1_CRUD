<?php 
class UserController extends Zend_Controller_Action{
    private $objectTime;

    public function indexAction() {
        $year = date("Y");
        $month = date("m");
        //echo date('w');
        if (isset($_POST['currentMonth']) && $_POST['currentMonth'] != "") {
            $currentMonth = $_POST['currentMonth'];
        } else {
            $currentMonth = $year."-".$month."-01";
        }
        // && $_POST['next_pre'] != ""  //$_POST['next_pre']
        if (isset($_POST['next_pre']) && $_POST['next_pre'] != "") {
            $strVal = $_POST['next_pre'].'1 month'; //+1 month Or -1 month
            $currentMonth = date('Y-m-d', strtotime($strVal, strtotime($currentMonth)));
        }

        $strTime = explode('-', $currentMonth);
        $month = $strTime[1];
        $year = $strTime[0];

        $dayOfweek = ["Monday"=>"月", "Tuesday"=>"火", "Wednesday"=>"水", 
                        "Thursday"=>"木", "Friday"=>"金", "Saturday"=>"土", "Sunday"=>"日"];
        
        
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);
        $end_time = strtotime("+1 month", $start_time);

        $results = [];
        for ($i = $start_time; $i < $end_time; $i += 86400) {
            //get day of week from $i
            $date = $year."-".date('m-d', $i);//2019-23-06
            $unixTimestamp = strtotime($date);//Convert the date string into a unix timestamp.
            $day = date("l", $unixTimestamp);
            $results[date('m/d', $i)] = ['day' => $dayOfweek[$day],
                                        'holiday' => ($day == "Saturday" || $day == "Sunday") ? "休" : "",
                                        ];
        }
    
        $this->objectTime = new Model_Timesheet();
        //find all record of user (id, date)
        $allRecord = $this->objectTime->getAllRecord_IdUser();
        foreach ($allRecord as $key=>$val) {
            //echo '<br>'.$key.'=>'.$val['id'].'=>'.$val['date'].'=>'.$val['start'].'=>'.$val['end'];
            $dy = date('m/d',strtotime($val['date'])); //$echo dy
            if (isset($results[$dy])) {
                $results[$dy]['start'] = $val['start'];
                $results[$dy]['end'] = $val['end'];
            }
        }

        if (isset($_POST['start'])) {
            $this->set_starttimeAction();
            $this->_redirect('user/index');
        }else if (isset($_POST['end'])) {
            $this->set_endtimeAction();
            $this->_redirect('user/index');
        }

        $this->view->yearmonth = $year."年".$month."月";
        $this->view->currentMonth = $year."-".$month."-01";
        $this->view->results = $results;
        $this->view->currentTime = date("H:i:s");
    }

    public function set_starttimeAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->objectTime = new Model_Timesheet();
        $auth = Zend_Auth::getInstance();
        $info_id = $auth->getIdentity()->id;
        $currendDate = date("Y-m-d");
        $data = ['id'=>$info_id, 
                'date'=>$currendDate];
        $this->objectTime->getStartTime($data);
    }

    public function set_endtimeAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->objectTime = new Model_Timesheet();
        $auth = Zend_Auth::getInstance();
        $info_id = $auth->getIdentity()->id;
        $currendDate = date("Y-m-d");
        $data = ['id'=>$info_id, 
                'date'=>$currendDate];
        $this->objectTime->getEndTime($data);
    }
}
?>