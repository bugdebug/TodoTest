<?
class View_Index extends Smartme {
    /**
     * @var string
     */
    protected $template = "index.tpl";

    public function __construct(Data_ResultSet $data) {
        parent::__construct();

        $this->assign(array(
            'rows' => $data->ToArrayRecursive(),
        ));
    }

}