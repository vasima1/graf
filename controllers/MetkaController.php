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

    public function actionIndex()
    {
        $index = 1; // Стартовая точка

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

        while ($index <= count($this->vertex)) {
            $this->setMetka($index);
            $index++;
        }
//
        debug($this->vertex);
//        debug($arrowGroups);
//        debug($this->arrow);
    }

    function setMetka($index)
    {
        foreach ($this->arrowGroups[$index] as $key => $value) {
            $value['a'] == $index ? $this->vertex[$value['b']]['metka'] = $this->checkMin($this->vertex[$value['b']]['metka'], $this->vertex[$index]['metka'], $value['w']) : false;
        }
        $this->vertex[$index]['chk'] = 1;
    }

    function checkMin($target, $indexM, $indexW)
    {
        $target > ($indexM + $indexW) ? $target = ($indexM + $indexW) : false;
        return $target;
    }

}
