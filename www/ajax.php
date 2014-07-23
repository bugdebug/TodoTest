<?
require("../init.php");

$action = Vars::get('action');

if ($action == 'add') {
    add();
}

if ($action == 'check') {
    check();
}

function check() {
    $id = (int)Vars::get('id');

    $object = Posts_PostMapper::getInstance()->getById($id);
    if (!$object) {
        return json_encode(false);
    }

    $object->setFinished(true);
    $res = Posts_PostMapper::getInstance()->update($object);

    echo json_encode($res);
}

function add() {
    $monthes = array(
        'январь' => 'january',
        'января' => 'january',
        'февраля' => 'february',
        'февраль' => 'february',
        'марта' => 'march',
        'март' => 'march',
        'апрель' => 'april',
        'апреля' => 'april',
        'май' => 'may',
        'мая' => 'may',
        'июнь' => 'june',
        'июня' => 'june',
        'июль' => 'july',
        'июля' => 'july',
        'августа' => 'august',
        'август' => 'august',
        'сентября' => 'september',
        'сентябрь' => 'september',
        'октября' => 'october',
        'октябрь' => 'october',
        'ноября' => 'november',
        'ноябрь' => 'november',
        'декабря' => 'december',
        'декабрь' => 'december',
    );

    $res = 0;

    $text = Vars::get('text');

    if (!empty($text)) {
        $post = new Posts_PostObject();
        $post->setText($text);

        if (preg_match("/сегодня|today|завтра|tomorrow|послезавтра/", $text, $matches)) {
            $time = time();
            switch ($matches[0]) {
                case 'завтра':
                case 'tomorrow':
                    $time = time() + 86400;
                    break;
                case 'послезавтра':
                    $time = time() + 86400*2;
                    break;
            }
            $date = date("Y-m-d", $time);
        } elseif (preg_match("/[0-9]{1,2}\s+("
            . implode('|', array_keys($monthes))
            . '|'
            . implode('|', array_values($monthes))
            . ")/", $text, $matches)
        ) {
            $match = str_replace(array_keys($monthes), array_values($monthes), $matches[0]);
            $possibleDate = strtotime($match);
            $date = $possibleDate ? date("Y-m-d", $possibleDate) : false;
        } else {
            $date = date("Y-m-d");
        }

        $post->setDeadline($date);

        $res = Posts_PostMapper::getInstance()->insert($post);
        if ($res) {
            $post->setId($res);
            $res = $post->toArrayOut();
            $res['text'] = isset($res['text']) ? htmlspecialchars($res['text']) : "";
        }
    }

    echo json_encode($res);
}