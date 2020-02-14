<?php

class ViewSTEEL_PCP_histEmailcert extends View{
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setBTela(true);
        
        $aDadosCert = $this->getAParametrosExtras();
        
        
        $oGridHist = new Campo('Históricos','estoque', Campo::TIPO_GRIDVIEW,12,12,12,12);
        
        $oGridHist->addCabGridView('Cert.');
        $oGridHist->addCabGridView('Usuário');
        $oGridHist->addCabGridView('Data');
        $oGridHist->addCabGridView('Hora');
        $oGridHist->addCabGridView('Sit');
        $oGridHist->addCabGridView('Destinatário');
        
        foreach ($aDadosCert as $key => $oCertObj) {
           $oGridHist->addLinhasGridView($key,$oCertObj->getNrcert());
           $oGridHist->addLinhasGridView($key,$oCertObj->getUserEmail()); 
           $sData = date('d/m/Y',  strtotime($oCertObj->getData())) ;
           $oGridHist->addLinhasGridView($key,$sData); 
           $sTime = substr($oCertObj->getHora(), 0, -8);
           $oGridHist->addLinhasGridView($key,$sTime);
           $oGridHist->addLinhasGridView($key,$oCertObj->getSitenv());
           $oGridHist->addLinhasGridView($key,$oCertObj->getDestinatario());
           
        }
       
        $this->addCampos($oGridHist);
    }
    
    
}

