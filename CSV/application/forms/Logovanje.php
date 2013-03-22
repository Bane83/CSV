<?php

class Application_Form_Logovanje extends Zend_Form
{

    public function __construct($options = null){
        parent::__construct($options);
        
        $this->setName('logovanje');
        $this->setMethod('post');
        $this->setAction('login');
        
        $username=new Zend_Form_Element_Text('username');
        $username->setLabel('Username:')
                 ->setRequired(true);
        
        $password=new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
                 ->setRequired(true);
        
        $submit=new Zend_Form_Element_Submit('login');
        $submit->setLabel('Uloguj se');
        
        $this->addElements(array($username,$password,$submit));
        
    }
    
    public function init()
    {
       
    }


}

