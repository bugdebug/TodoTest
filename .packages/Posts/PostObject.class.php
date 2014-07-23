<?
/**
 * @method setId($id)
 * @method getId()
 * @method setText($text)
 * @method getText()
 * @method setDeadline($date)
 * @method getDeadline()
 * @method setFinished($flag)
 * @method getFinished()
 */
class Posts_PostObject extends Data_Object {
    protected $properties = array(
        "id" => 0,
        "text" => "",
        "deadline" => '',
        "finished" => false,
    );

    public function getDeadlineFormatted() {
        $months = array (
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря');
        //$format = str_replace("%m",$months[(int)date('m',$timestamp)],$format);
        return $this->getDeadline();
    }
}