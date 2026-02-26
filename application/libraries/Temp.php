<?php class Temp{
    protected $_ci;

    function __construct() {
        $this->_ci =&get_instance(); 
    }
    
    function display($admin,$data=null) {
        $data['__header']=$this->_ci->load->view('backend/layout/header',$data, true);
        $data['__menu']=$this->_ci->load->view('backend/layout/menu',$data, true);
        // $data['__content'] = $this->_ci->load->view($data['content'], $data, true);
        $data['__content']=$this->_ci->load->view('backend/layout/content',$data, true);
        $data['__footer']=$this->_ci->load->view('backend/layout/footer',$data, true);
        $this->_ci->load->view('backend/layout/main',$data);
    }
}
?>