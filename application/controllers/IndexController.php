<?php 
class IndexController extends Zend_Controller_Action{ 
    public function indexAction(){
        // $tbModel = new Model_User();
        // $items = $tbModel->listDb();
        // echo '<pre>';
        // print_r($items);
        // echo '<pre>';

        
        $db = Zend_Registry::get('connectDb');
        $auth = Zend_Auth::getInstance();
        $authApdater = new Zend_Auth_Adapter_DbTable($db);
        $authApdater->setTableName('users')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');

        if (isset($_POST['submit'])) {
            $username = $_POST['userId'];
            $pass = $_POST['userPass'];

            $authApdater->setIdentity($username);
            $authApdater->setCredential($pass);

            $result = $auth->authenticate($authApdater);

            if (!$result->isValid()) {
                $error = $result->getMessages();
                echo current($error);
            }else {
                echo "Dang nhap thanh cong";
                $omitColums = array('password');
                $data = $authApdater->getResultRowObject(null, $omitColums);
                $auth->getStorage()->write($data);
                $this->_redirect('user/index');
            }
        }
    }

    public function loginAction() {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            echo 'ban da login';
        }else {
            echo 'chua login';
        }
        //$this->_helper->viewRenderer->setNoRender();
    }
    
    public function logoutAction() {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_redirect('/zend1/public/index/index');
        $this->_helper->viewRenderer->setNoRender();
    }
}
?>