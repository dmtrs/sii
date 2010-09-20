<?php
require_once('/home/dmtrsslvdr/public_html/FirePHPCore/fb.php');

/**
 * SiiModule class file.
 * This code is copy of the CConsoleApplication code.
 *
 */
class SiiModule extends CWebModule
{
    private $yiic;
    private $config;

    public $commandMap=array();
    private $_runner;
    private $_commandPath;

    public function init()
    {
        // this method is called when the module is being created
	// you may place code here to customize the module or the application

	// import the module-level models and components
        //public $commandMap=
        //        array(
        //    "shell"=>"/home/dmtrsslvdr/public_html/yii3/framework/cli/commands/ShellCommand.php",
        //);
	$this->setImport(array(
	    'sii.models.*',
	    'sii.components.*',
	));
        //$this->yiic = dirname(__FILE__).'/../../yii3/framework/yiic.php';
        $this->yiic = dirname(__FILE__).'/../../yii3/framework/';
        $this->config = dirname(__FILE__).'/config/console.php';
        $this->_runner = new CConsoleCommandRunner;
        $this->_runner->commands=$this->commandMap;
        $this->_runner->addCommands(YII_PATH.'/cli/commands');
    }

    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
	{
	    // this method is called before any module controller action is performed
	    // you may place customized code here
	    return true;
	}
	else {
       	    return false;
        }
    }
    /**
     * Creates the command runner instance.
     * @return CConsoleCommandRunner the command runner
     */
    protected function createCommandRunner()
    {
        return new CConsoleCommandRunner;
    }

    public function processRequest()
    {
        //NOTE: remove this method to see what's going on
        // /home/dmtrsslvdr/public_html/yii3/framework/cli/commands/ShellCommand.php
	//If i try to run this i get endless looop in the above
	$this->_runner->run(array("./yiic","shell","../../index.php"));
        //what i think really must happen is 
        // ShellCommand::runShell()
       
    }
}
