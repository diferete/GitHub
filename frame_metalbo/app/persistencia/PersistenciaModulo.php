<?php

class PersistenciaModulo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmodulo');

        $this->adicionaRelacionamento('modcod', 'modcod', true, true, true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');

        $this->adicionaOrderBy('modcod', 1);
    }

    public function insereGrupo() {

        $sSqlCod = "select procod from tbqualNovoProjeto where procod is not null and subcod is null and famcod is null and famsub is null";
        $result = $this->getObjetoSql($sSqlCod);
        $aProCod = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            array_push($aProCod, $row->procod);
        }

        foreach ($aProCod as $key => $value) {
            $sSql = "update tbqualNovoProjeto set grucod = (select grucod from widl.PROD01 where procod = " . $value . " ),
                    subcod = (select subcod from widl.PROD01 where procod = " . $value . " ),
                    famcod = (select famcod from widl.PROD01 where procod = " . $value . " ),
                    famsub = (select famsub from widl.PROD01 where procod = " . $value . " ) where procod = " . $value . "";
            $aRetorno = $this->executaSql($sSql);

            $i = mt_rand(00, 9999999999);
            $LogNome = date('d-m-Y H-i-s' . $i);
            if ($aRetorno[0] == true) {
                $meuArquivo = $LogNome . '-PdoLogGrupoProd.txt';
                $data = $LogNome . '-> grupo item ' . $value . ' concluida com sucesso';
            } else {
                $meuArquivo = $LogNome . '-PdoLogERRO.txt';
                $data = $aRetorno[1] . $value;
            }
            $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'GitHub/frame_metalbo/LOGS/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
            fwrite($gerenciaArquivo, $data);
            fclose($gerenciaArquivo);
        }
        return;
    }

}
