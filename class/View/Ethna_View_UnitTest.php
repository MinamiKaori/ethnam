<?php
/**
 *  Ethna_View_UnitTest.php
 *
 *  @author     Takuya Ookubo <sfio@sakura.ai.to>
 *  @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 *  @package    Ethna
 *  @version    $Id$
 */

/**
 *  __ethna_unittest__�ӥ塼�μ���
 *
 *  @author     Takuya Ookubo <sfio@sakura.ai.to>
 *  @access     public
 *  @package    Ethna
 */
class Ethna_View_UnitTest extends Ethna_ViewClass
{
    /**
     *  ����������
     *
     *  @access public
     */
    function preforward()
    {
        // �����ॢ���Ȥ��ʤ��褦���ѹ�
        $max_execution_time = ini_get('max_execution_time');
        set_time_limit(0);

        if (!headers_sent()) {
            // ����å��夷�ʤ�
            header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s \G\M\T"));
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
        }

        $ctl =& Ethna_Controller::getInstance();

        // cores
        $this->af->setApp('app_id', $ctl->getAppId());
        $this->af->setApp('ethna_version', ETHNA_VERSION);

        // include
        $inc = sprintf("%s/%s_UnitTestManager.php",
            $ctl->getDirectory('app'),
            $ctl->getAppId());
        @include_once "{$inc}";

        // run
        $r = sprintf("%s_UnitTestManager", $ctl->getAppId());
        $ut =& new $r($this->backend);
        list($report, $result) = $ut->run();
        
        // result
        $this->af->setApp('report', $report);
        $this->af->setApp('result', $result);

        // �����ॢ���Ȥ򸵤��᤹
        set_time_limit($max_execution_time);
    }
}
?>