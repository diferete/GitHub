<?php

/**
 * Class responsável pela acao de Controller  
 * 
 * @autho Avanei Martendal
 * 
 * @since 10/07/2017
 * 
 */


class ControllerQualAqPlanEf extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('QualAqPlanEf');
    }
}