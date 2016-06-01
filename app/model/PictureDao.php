<?php
require_once __DIR__."../../../vendor/autoload.php";

class PictureDao {

    private $picturesCollection;

    function __construct(\MongoDB\Database $db) {
        $this->picturesCollection = $db->selectCollection("pictures");
    }

    function getById($id) {
        $picture = $this->picturesCollection->findOne(["id" => intval($id)]);
        return $picture;
    }

    /**
     * Возвращает записи о добавленных картинках c $from по $to включительно, учитывая
     * обратный порядок.
     * Нумерация начинается с 0.
     * @throws InvalidArgumentException если количество картинок для возврата <= 0.
     * @param $from int с какой записи, учитывая обратный порядок.
     * @param $to int по какую заапись, включительно.
     * @return array массив записей.
     */
    function getLast($from, $to) {
        $picturesNumber = ($to - $from) + 1;

        if ($picturesNumber <= 0) {
            throw new InvalidArgumentException("Required pictures number <= 0.");
        }

        $lastPictures = $this->picturesCollection->find(
            [],
            ["skip" => $from, "limit" => $picturesNumber, "sort" => ["added" => -1]]);

        $result = [];
        foreach ($lastPictures as $picture) {
            $result[] = $picture;
        }

        return $result;
    }

    /**
     * Сохраняет данные о картинке в БД.
     * @param $picture array готовый для вставки BSON документ.
     */
    function save($picture) {
        $picture["id"] = $this->generateNextId();
        $this->picturesCollection->insertOne($picture);
    }

    /**
     * Возвращает следующий свободный id в коллекции pictures.
     */
    private function generateNextId() {
        $lastId = $this->picturesCollection->findOne([], ["sort" => ["id" => -1]]);
        if ($lastId !== null) {
            $nextId = (int)$lastId["id"] + 1;
            return $nextId;
        } else {
            return 1;
        }
    }

}