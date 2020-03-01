<?php
    class TeamPlayer {
    private $name;
    private $id;
    private $rankScore;
    private $timesRanked;
    private $haveAvatar;
    private $avatarLocation;

    function set_name($name) {
        $this->name = $name;
    }

    function set_id($id) {
        $this->id = $id;
    }

    function set_rankScore($rankScore) {
        $this->rankScore = $rankScore;
    }

    function set_timesRanked($timesRanked) {
        $this->timesRanked = $timesRanked;
    }

    function set_haveAvatar($haveAvatar) {
        $this->haveAvatar = $haveAvatar;
    }

    function set_avatarLocation($avatarLocation) {
        $this->avatarLocation = $avatarLocation;
    }

    function get_name() {
        return $this->name;
    }

    function get_id() {
        return $this->id ;
    }

    function get_rankScore() {
        return $this->rankScore;
    }

    function get_timesRanked() {
        return $this->timesRanked;
    }

    function get_haveAvatar() {
        return $this->haveAvatar;
    }

    function get_avatarLocation() {
        return $this->avatarLocation;
    }
}
?>