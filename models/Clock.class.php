<?php

/**
 * classe pour bencher un script
 */
class Clock
{
    /**
     * tableau des points
     *
     * @var array
     */
    protected $_marks = array();
    protected $_timeline = array();
    protected $_step = 0;

    protected static $_instance = null;

    /**
     * démarrage de l'horloge
     */
    public function __construct()
    {
        $this->setMark('start');
        static::$_instance = $this;
    }

    /**
     *
     */
    public static function getInstance()
    {
        if (is_null(static::$_instance)) {
            // pas du tout d'instance: on en crée une, le constructeur ira s'enregistrer
            // dans la variable statique.
            return new static();
        } else {
            // tout est ok
        }
        return static::$_instance;
    }

    /**
     *
     */
    public static function deleteInstance()
    {
        if (isset(static::$_instance)) {
            static::$_instance = null;
            return true;
        }
        return false;
    }

    /**
     * ajoute un point de marquage
     *
     * @param string nom à donner au point
     */
    public function setMark($name)
    {
        $this->_step++;
        $this->_marks[$this->_step] = array('name' => $name, 'time' => microtime(), 'elapsed' => 0.000, 'total_elapsed' => 0.000);
        if($this->_step > 1) {
            $this->_marks[$this->_step]['elapsed'] = $this->elapsed($this->_step - 1, $this->_step);
            $this->_marks[$this->_step]['total_elapsed'] = $this->elapsed(1, $this->_step);
        }
        //$this->_timeline[microtime()] = $name;
    }

    /**
     * calcule la durée entre 2 marques
     *
     * @param string point 1
     * @param string point 2
     * @return float
     */
    public function elapsed($stepA, $stepB)
    {
        list($start_usec, $start_sec) = explode(" ", $this->_marks[$stepA]['time']);
        list($end_usec, $end_sec) = explode(" ", $this->_marks[$stepB]['time']);
        $diff_sec = (int) $end_sec - (int) $start_sec;
        $diff_usec = (float) $end_usec - (float) $start_usec;
        $usec = (float) $diff_sec + $diff_usec;
        return round($usec, 3);
    }

    public function getReport()
    {
        $o = '<table class="benchmark">'
           . '<tr><th>n°</th><th>Nom</th><th>Temps</th><th>Ecoulé</th><th>Total écoulé</th>';

        foreach($this->_marks as $step => $mark)
        {
            $o .= '<tr><td>'.$step.'</td><td>'.$mark['name'].'</td><td>'.$mark['time'].'</td><td>'.$mark['elapsed'].'</td><td>'.$mark['total_elapsed'].'</tr>';
        }
        $o .= '</table>';
        return $o;
    }
}
