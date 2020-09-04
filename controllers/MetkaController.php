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
function debug($arr)
{
    echo '<pre class="on">' . print_r($arr, TRUE) . '</pre>';
}

class MetkaController extends Controller
{

    public $vertex = []; // Вершины
    public $arrow = []; // Направление стрелок из "А" в "Б"
    public $arrowGroups = []; // Сгруппированный массив по связям
    public $group = []; // Индексы к слудующей вершине

    public function actionIndex()
    {
        $index = 2; // Стартовая точка

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
        
        while ($i <= count($this->vertex)) {
            $index = $this->setMetka($index);
            $i++;
        }
        
//        $index = $this->setMetka($index);
//        $index = $this->setMetka($index);
//        $index = $this->setMetka($index);
//        $index = $this->setMetka($index);
//        $index = $this->setMetka($index);
//        $index = $this->setMetka($index);


//        debug($this->group);
//        echo 'index ' . $index . '<br>';
        debug($this->vertex);
        debug($this->arrowGroups);
//        debug($this->arrow);
    }

    function setMetka($index)
    {
        $group = [];

        foreach ($this->arrowGroups[$index] as $key => $value) {
            $this->vertex[$value['b']]['chk'] == 0 ? $this->vertex[$value['b']]['metka'] = $this->checkMin($this->vertex[$value['b']]['metka'], $this->vertex[$index]['metka'], $value['w']) : false;
            $this->vertex[$value['b']]['chk'] == 0 && !in_array($value['b'], $this->group) ? $group[$value['b']] = $value['w'] : false;
        }
        $this->vertex[$index]['chk'] = 1;
        $nextIndex = $this->getNextIndex($index, $group);
        return $nextIndex;
    }

    function checkMin($target, $indexM, $indexW)
    {
        $target > ($indexM + $indexW) ? $target = ($indexM + $indexW) : false;
        return $target;
    }

    function getNextIndex($index, $group)
    {

        if (empty($this->group) and empty($group)) {

            foreach ($this->vertex as $key => $value) {

                if ($value['chk'] == 0) {
                    $index = $key;
                    break;
                }
            }
            return $index;
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
            return $this->getNextIndex($index, $group);
        }
    }

}
