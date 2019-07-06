<?php
class Model_Timesheet extends Zend_Db_Table {
    protected $_name = 'timesheet';
    protected $_primary = ['id', 'date'];
    //Phương thức fetchAll() lấy ra tất cả dữ liệu
    public function listItem() {
        echo '<br>' . __METHOD__ . '<br>';
        //$result = $this->fetchAll($where, $order, $count, $offset);
        //$result = $this->fetchAll();
        //$where = 'id= 612036 ';
        $result = $this->fetchAll()->toArray();
        return $result;
    }

    public function getStartTime($data) {
        $info_id = $data['id'];//$auth->getIdentity()->id;
        $currendDate = date("Y-m-d");//$data['date']; //date("Y-m-d");
        $currentTime = date('H:i:s');        

        // //select with id and currentDate, if NULL --> init new object -->insert (or else -->update)
        $where = "id=".$info_id." and date='".$currendDate."'";
        echo $where;
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectQuerry = $db->select()
                            ->from('timesheet',array('*'))
                            ->where($where);
        $result = $db->query($selectQuerry)->fetchAll();

        if (empty($result)) {
            $newRecord = array(
                "id" => $info_id,
                "date" => $currendDate,
                "start" => $currentTime,
                "end" => NULL,
            );
            $this->insert($newRecord);
        } else {

            $newCol = ["start"=>$currentTime];
            $where = "id=".$info_id." and date='".$currendDate."'";
            $this->update($newCol, $where);
        }
        return $currentTime;
    }

    public function getEndTime($data) {
        $info_id = $data['id'];//$auth->getIdentity()->id;
        $currendDate = date("Y-m-d");//$data['date']; //date("Y-m-d");
        $currentTime = date('H:i:s');        

        // //select with id and currentDate, if NULL --> init new object -->insert (or else -->update)
        $where = "id=".$info_id." and date='".$currendDate."'";
        echo $where;
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectQuerry = $db->select()
                            ->from('timesheet',array('*'))
                            ->where($where);
        $result = $db->query($selectQuerry)->fetchAll();

        if (empty($result)) {
            $newRecord = array(
                "id" => $info_id,
                "date" => $currendDate,
                "start" => NULL,
                "end" => $currentTime,
            );
            $this->insert($newRecord);
        } else {
            $newCol = ["end"=>$currentTime];
            $where = "id=".$info_id." and date='".$currendDate."'";
            $this->update($newCol, $where);
        }
        return $currentTime;
    }

    public function getAllRecord_IdUser() {
        $auth = Zend_Auth::getInstance();
        $info_id = $auth->getIdentity()->id;
        $where = "id=".$info_id;
        $db = Zend_Db_Table::getDefaultAdapter();
        $selectQuerry = $db->select()
                            ->from('timesheet',array('*'))
                            ->where($where);
        $data = $db->query($selectQuerry)->fetchAll();
        return $data;
    }
}