<?php
class Model_User extends Zend_Db_Table {
    protected $_name = 'timesheet';
    protected $_primary = 'id';

    //Phương thức fetchAll() lấy ra tất cả dữ liệu
    public function listDb() {
        //echo '<br>' . __METHOD__ . '<br>';
        //$result = $this->fetchAll($where, $order, $count, $offset);
        //$result = $this->fetchAll();
        //$where = 'id= 612036 ';
        $result = $this->fetchAll()->toArray();
        return $result; 
    }

    
}