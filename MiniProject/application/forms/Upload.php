<?php

class Application_Form_Upload extends Zend_Form
{

    public function __construct($options = null) {
        parent::__construct($options);
        
        
        $this->setName('up');
        $this->setAction('unos');
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');
        
        $file_upload=new Zend_Form_Element_File('file');
        $file_upload->setLabel('Unesite .CSV file:')
                    ->setRequired(true)
                    ->addValidator('Extension',false,'csv');
        
        $submit=new Zend_Form_Element_Submit('upload');
        $submit->setLabel('Unesi');
        
        $this->addElements(array($file_upload, $submit));
        
              
    }
    
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }


}

