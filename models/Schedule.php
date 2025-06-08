<?php
class Schedule {
    public $id;
    public $show_name;
    public $start_time;

    public function __construct($id, $show_name, $start_time) {
        $this->id = $id;
        $this->show_name = $show_name;
        $this->start_time = $start_time;
    }
}
?>
