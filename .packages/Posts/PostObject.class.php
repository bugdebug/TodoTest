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
        $months = array(
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
            12 => 'декабря'
        );

        $time = strtotime($this->getDeadline());
        if (!$time) return false;

        return date("j", $time) . " " . $months[date("n", $time)];
    }


    /**
     * @return array
     */
    public function toArrayOut() {
        $data = parent::toArray();
        $data['deadlineFormatted'] = $this->getDeadlineFormatted();
        $data['timedOut'] = time() > strtotime($this->getDeadline()) ? 1 : 0;
        return $data;
    }
}