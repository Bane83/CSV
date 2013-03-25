<?php

class LogovanjeController extends Zend_Controller_Action
{

    
    
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {        
        
        
    }

    public function loginAction()
    {
        
        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('Logovanje/opcije');
        }
        
        $form = new Application_Form_Logovanje();
                $this->view->form=$form;
        
        $request=$this->getRequest();
        if($request->isPost()){
            if($form->isValid($this->_request->getPost())){
                
                

                $authAdapter = $this->getAuthAdapter();

                $username=$form->getValue('username');
                $password=$form->getValue('password');
                

                $authAdapter->setIdentity($username)
                            ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $rezultat = $auth->authenticate($authAdapter);

                if($rezultat->isValid()){

                    $korisnik_podaci= $authAdapter->getResultRowObject();

                    $authStorage = $auth->getStorage();
                    $authStorage->write($korisnik_podaci);

                    $this->_redirect('Logovanje/opcije');
            
                   
                    
                 }else{
                     $this->view->greska = "Pogresno ste uneli username ili password!";
                 }
                
            }
            
        }
        
        
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('Logovanje/login');
    }

    private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('korisnici')
                    ->setIdentityColumn('username')
                    ->setCredentialColumn('password');
        
        return $authAdapter;
        
    }

    public function opcijeAction()
    {
        $identify=  Zend_Auth::getInstance()->getStorage()->read();
        $uloga=$identify->uloga;
        
        $this->view->Uloga=$uloga;
        
        
        
        
    }

    public function izlistavanjeAction()
    {
        // action body
    }

    public function unosAction()
    {
        
        
        $upload_form=new Application_Form_Upload();
        
        //U koliko je unet .csv fajl pronalazi se u tmp folderu, cita se prvi red s nazivom kolona i prosledjuju u view.
        
        $request=$this->getRequest();
        
        if($request->isPost()){            
            
            if($upload_form->isValid($this->_request->getPost())){
                
            $file=$_FILES['file']['tmp_name'];
            $file_name=$_FILES['file']['name'];
            
            $folder="C:/xampp/htdocs/Zend/CSV/application/files/";
            
            
            
            //echo $file_name;
               
                if (($handle = fopen($file, "r")) !== FALSE) {
                       
                       if(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                           
                           
                           //Prosledjivanje prvog reda iz CSV fajla (red koji sadrzi nazive kolona)
                           $this->view->data=$data;
                           //Prosledjivanje imena fajla koji treba da se uploaduje
                           $this->view->file=$file_name;
                           //Upload fajla
                           move_uploaded_file($file,$folder.$file_name);
                                      
                               
                           }
                           

                       }
                }    
            
            
            
        }else{
   
        //U koliko nije kliknuto na dugme unos prikazuje se forma za unos.
            
        $this->view->upload_form=$upload_form;
        
        }
        
        
        
    }

    public function countAction()
    {
        $request=$this->getRequest();
        
        $post=$request->getPost();
        
        if(isset($post['submit'])){
            
               //Dohvatanja svih vrednosti iz dropdown (koje su prethodno mapirane)
               $op=$request->getParam('kolone');
               
               //Dohvatanje naziva fajla iz hidden polja
               $file=$request->getParam('file');
               
               $folder="C:/xampp/htdocs/Zend/CSV/application/files/";
               
               //Kreiranje stringa iz niza uz odvajanje clanova niza zarezom
               $kol=implode(',', $op);
               
                             
               $db = Zend_Db_Table_Abstract::getDefaultAdapter();
               
               //Unos podataka iz CSV fajla u tabelu prodaja po zadatom redu kolona (izvrseno mapiranje)                     
               $sql="LOAD DATA INFILE '".$folder.$file."' INTO TABLE prodaja FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n' IGNORE 1 LINES (".$kol.")" ;
               
               $db->query($sql);
               
               //$this->view->op=$op;
               //$this->view->kol=$kol;
               //$this->view->file=$file;
               
              
                       
               
               
                
            }
            
           
            
        
            
         
    }


}








