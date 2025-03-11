<?php
namespace mod_uploadfiles\event;

defined('MOODLE_INTERNAL') || die();

class course_module_viewed extends \core\event\course_module_viewed {
        /**
     * Initialize event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'uploadfiles'; // Set the object table name
        parent::init();
    }
}