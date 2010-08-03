<?php
/**
 * SiiModule class file.
 * This code is copy of the CConsoleApplication code.
 *
 */
class SiiModule extends CWebModule
{
    private $_runner;
    private $commandMap = array();
    private $_commandPath;
    public function init()
    {
        // this method is called when the module is being created
	// you may place code here to customize the module or the application

	// import the module-level models and components
	$this->setImport(array(
	    'sii.models.*',
	    'sii.components.*',
	));
	$this->_runner=$this->createCommandRunner();
	$this->_runner->commands=$this->commandMap;
        $this->_runner->addCommands($this->getCommandPath());
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
     * Processes the user request.
     * This method creates a console command runner to handle the particular user command.
     */
    public function processRequest()
    {
         $this->_runner->run($_SERVER['argv']);
    }

    /**
     * Creates the command runner instance.
     * @return CConsoleCommandRunner the command runner
     */
    protected function createCommandRunner()
    {
        return new CConsoleCommandRunner;
    }

    /**
     * Displays the captured PHP error.
     * This method displays the error in console mode when there is
     * no active error handler.
     * @param integer error code
     * @param string error message
     * @param string error file
     * @param string error line
     */
     public function displayError($code,$message,$file,$line)
     {
         echo "PHP Error[$code]: $message\n";
         echo "in file $file at line $line\n";
         debug_print_backtrace();
     }

     /**
      * Displays the uncaught PHP exception.
      * This method displays the exception in console mode when there is
      * no active error handler.
      * @param Exception the uncaught exception
      */
     public function displayException($exception)
     {
         echo $exception;
     }

    /**
     * @return string the directory that contains the command classes. Defaults to 'protected/commands'.
     */
    public function getCommandPath()
    {
	if($this->_commandPath===null)
	    $this->setCommandPath(Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'commands');
        return $this->_commandPath;
    }

    /**
     * @param string the directory that contains the command classes.
     * @throws CException if the directory is invalid.
     */
    public function setCommandPath($value)
    {
        if(($this->_commandPath=realpath($value))===false || !is_dir($this->_commandPath))
	    throw new CException(Yii::t('yii','The command path "{path}" is not a valid directory.',
	      array('{path}'=>$value)));
    }

    /**
     * Returns the command runner.
     * @return CConsoleCommandRunner the command runner.
     */
    public function getCommandRunner()
    {
        return $this->_runner;
    }
}
