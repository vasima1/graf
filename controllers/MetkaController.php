<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\tables\Arrow;
use app\models\tables\Vertex;

/**
 * Description of MetkaController
 *
 * @author user
 */

/**
 * Отобразить массив на клиент
 * @param type $arr
 */
function debug($arr) 
{
    echo '<pre class="on">' . print_r($arr, TRUE) . '</pre>';
}

/**
 * Устновка меток веса для связей со стартовой вершины
 */
class MetkaController extends Controller
{

    public $vertex = []; // Вершины
    public $arrow = []; // Направление стрелок из "А" в "Б"
    public $arrowGroups = []; // Сгруппированный массив по связям
    public $group = []; // Индексы к слудующей вершине

    public function actionIndex()
    {
        $index = 6; // Стартовая точка

        $this->vertex = Vertex::find()
                ->select('name, chk, metka')
                ->indexBy('name')
                ->asArray()
                ->all();
        $this->arrow = Arrow::find()
                ->select('id, a, b, w')
                ->indexBy('id')
                ->asArray()
                ->all();

        $this->vertex[$index]['metka'] = 0;

        foreach ($this->arrow as $key => $value) {
            $this->arrowGroups[$value['a']][] = $value;
        }

        $i = 1;
        
        /**
         * Проход по вершинам или стоп при отсутствии связей
         */
        while ($i <= count($this->vertex)) {
            $index = $this->setMetka($index);
            
            if ($index == 0) {
                break;
            }
            $i++;
        }
        echo 'i = ' .$i;
        
        debug($this->vertex);
//        debug($this->arrowGroups);
//        debug($this->arrow);
    }

    /**
     * Установка меток группе связей от просматриваемой вершины "А" и возврат индекса к следующей ближайшей вершине
     * @param int $index текущая просматриваемая вершина
     * @return int индекс к следующей ближайщей вершине
     */
    function setMetka($index)
    {
        $group = [];

        foreach ($this->arrowGroups[$index] as $key => $value) {
            $this->vertex[$value['b']]['chk'] == 0 ? $this->vertex[$value['b']]['metka'] = $this->checkMin($this->vertex[$value['b']]['metka'], $this->vertex[$index]['metka'], $value['w']) : false;
            $this->vertex[$value['b']]['chk'] == 0 && !in_array($value['b'], $this->group) ? $group[$value['b']] = $value['w'] : false;
        }
        $this->vertex[$index]['chk'] = 1;
        $nextIndex = $this->getNextIndex($group);
        return $nextIndex;
    }

    /**
     * Сравнение значение метки вершины "Б" и предлагаемого на замену значений
     * @param int $target текущее значение вершины "Б"
     * @param int $indexM текущее значение вершины "А"
     * @param ind $indexW Вес от "А" к "Б"
     * @return int конечное значение после сравнения
     */
    function checkMin($target, $indexM, $indexW)
    {
        $target > ($indexM + $indexW) ? $target = ($indexM + $indexW) : false;
        return $target;
    }

    /**
     * Получение индекса для слудующей ближайшей вершины
     * @param array $group новые поступающие элементы связей
     * @return int
     */
    function getNextIndex($group)
    {

        if (empty($this->group) and empty($group)) {
            return 0;
        } elseif (empty($this->group)) {
            $this->group = $group;
        }

        $min = min($this->group);
        $key = array_search($min, $this->group);

        if ($this->vertex[$key]['chk'] == 0) {
            $this->group += $group;
            return $key;
        } else {
            unset($this->group[$key]);
            return $this->getNextIndex($group);
        }
    }

}
