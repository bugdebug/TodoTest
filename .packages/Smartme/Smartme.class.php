<?
class Smartme extends Smarty {
    /**
     * @var string
     */
    protected $template = '';

    /**
     *
     */
    function __construct() {
        parent::__construct();

        $this->setConfigDir(SMARTY_CONFIG_DIR);
        $this->setTemplateDir(SMARTY_TEMPLATES_DIR);
        $this->setCompileDir(SMARTY_TEMPLATES_C_DIR);
        $this->setCacheDir(SMARTY_CACHE_DIR);

        //$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        $this->assign('app_name', 'Guest Book');
    }

    /**
     *
     */
    public function display() {
        parent::display($this->template);
    }
}
