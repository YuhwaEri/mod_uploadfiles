<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Prints an instance of mod_uploadfiles.
 *
 * @package     mod_uploadfiles
 * @copyright   2025 Tim Ou
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('uploadfiles', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);

require_login($course, true, $cm);

$event = \mod_uploadfiles\event\course_module_viewed::create([
    'context' => $context,
    'objectid' => $cm->instance
]);
$event->add_record_snapshot('course_modules', $cm);
$event->add_record_snapshot('course', $course);
$event->trigger();

$PAGE->set_url('/mod/uploadfiles/view.php', ['id' => $cm->id]);
$PAGE->set_title(format_string($cm->name));
$PAGE->set_heading(format_string($course->fullname));

$url = "https://trilms.tri-sim.com/mod/folder/uploadFileFromServer.php?course_id={$course->id}";

echo $OUTPUT->header();
echo html_writer::link($url, get_string('clickhere', 'mod_uploadfiles'), ['target' => '_blank']);
echo $OUTPUT->footer();

