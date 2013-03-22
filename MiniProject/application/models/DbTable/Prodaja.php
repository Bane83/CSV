<?php

class Application_Model_DbTable_Prodaja extends Zend_Db_Table_Abstract
{

    protected $_name = 'prodaja';
    
    //Ovo je samo neki primer koji sam radio...
    public static function proba(){
        
        $prodaja = new Application_Model_DbTable_Prodaja();
        
        //$upit="SELECT naziv_proizvoda FROM prodaja WHERE id=".$id;
        
        //$rezultat=$db->query($upit);
        
        $select = $prodaja->select();
        
        $rezultat=$prodaja->fetchAll($select);
        
        return $rezultat;
        
            
        
    }
        
    
    
    
    
    
    


}

