<?
class View_AddItem extends Smartme {
    protected $template = "additem.tpl";

    /**
     * @param $res
     */
    public function __construct($res) {
        parent::__construct();

        $this->assign(array(
            'text' => $res,
        ));
    }
}