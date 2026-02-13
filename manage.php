<?php
/**
 * Управление электронным портфолио
 *
 * @package    local_portfolio
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once(__DIR__ . '/portfolio_form.php');

// Получение параметров
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$action = optional_param('action', 'view', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT); // ID записи для редактирования/удаления

// Проверка авторизации и прав доступа
require_login($courseid);
$context = context_course::instance($courseid);
require_capability('local/portfolio:manage', $context);

// Проверка существования пользователя
if (empty($USER->id)) {
    throw new moodle_exception('errornotloggedin', 'local_portfolio');
}

// Настройка страницы
$PAGE->set_url('/local/portfolio/manage.php', array('courseid' => $courseid));
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_portfolio'));
$PAGE->set_heading(get_string('pluginname', 'local_portfolio'));

// Обработка различных действий
switch ($action) {
    case 'add':
        handle_add_action($context, $courseid);
        break;
        
    case 'edit':
        handle_edit_action($id, $context, $courseid);
        break;
        
    case 'delete':
        handle_delete_action($id, $context, $courseid);
        break;
        
    case 'view':
    default:
        handle_view_action($context, $courseid);
        break;
}

/**
 * Обработка действия добавления записи
 *
 * @param context $context контекст курса
 * @param int $courseid ID курса
 */
function handle_add_action($context, $courseid) {
    global $PAGE, $OUTPUT, $DB, $USER;
    
    $PAGE->set_title(get_string('addachievement', 'local_portfolio'));
    $PAGE->set_heading(get_string('addachievement', 'local_portfolio'));
    
    // Создание формы
    $mform = new portfolio_entry_form(null, array('courseid' => $courseid));
    
    // Обработка отмены формы
    if ($mform->is_cancelled()) {
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
    
    // Обработка отправки данных формы
    if ($data = $mform->get_data()) {
        try {
            // Подготовка данных для сохранения
            $record = new stdClass();
            $record->userid = $USER->id;
            $record->title = trim($data->title);
            $record->catid = $data->catid;
            $record->description = $data->description['text'];
            $record->descriptionformat = $data->description['format'];
            $record->status = $data->status;
            $record->timecreated = time();
            $record->timemodified = time();
            
            // Вставка записи в базу данных
            $transaction = $DB->start_delegated_transaction();
            $newid = $DB->insert_record('local_portfolio_items', $record);
            
            if (!$newid) {
                throw new moodle_exception('errordatabase', 'local_portfolio');
            }
            
            // Создание события
            $event = \local_portfolio\event\entry_created::create(array(
                'context' => $context,
                'objectid' => $newid,
                'userid' => $USER->id
            ));
            $event->trigger();
            
            $transaction->allow_commit();
            
            // Перенаправление с сообщением об успехе
            redirect(
                new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)),
                get_string('achievementadded', 'local_portfolio'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            
        } catch (Exception $e) {
            if (isset($transaction)) {
                $transaction->rollback($e);
            }
            
            // Отображение ошибки
            \core\notification::error($e->getMessage());
        }
    }
    
    // Вывод формы
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('addachievement', 'local_portfolio'));
    $mform->display();
    echo $OUTPUT->footer();
}

/**
 * Обработка действия редактирования записи
 *
 * @param int $id ID записи
 * @param context $context контекст курса
 * @param int $courseid ID курса
 */
function handle_edit_action($id, $context, $courseid) {
    global $PAGE, $OUTPUT, $DB, $USER;
    
    if (!$id) {
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
    
    // Получение записи
    $record = $DB->get_record('local_portfolio_items', array('id' => $id, 'userid' => $USER->id));
    
    if (!$record) {
        \core\notification::error(get_string('errornotfound', 'local_portfolio'));
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
    
    $PAGE->set_title(get_string('editachievement', 'local_portfolio'));
    $PAGE->set_heading(get_string('editachievement', 'local_portfolio'));
    
    // Подготовка данных для формы
    $data = new stdClass();
    $data->id = $record->id;
    $data->title = $record->title;
    $data->catid = $record->catid;
    $data->description = array(
        'text' => $record->description,
        'format' => $record->descriptionformat
    );
    $data->status = $record->status;
    
    // Создание формы
    $mform = new portfolio_entry_form(null, array('courseid' => $courseid, 'edit' => true));
    $mform->set_data($data);
    
    // Обработка отмены формы
    if ($mform->is_cancelled()) {
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
    
    // Обработка отправки данных формы
    if ($formdata = $mform->get_data()) {
        try {
            // Обновление записи
            $record->title = trim($formdata->title);
            $record->catid = $formdata->catid;
            $record->description = $formdata->description['text'];
            $record->descriptionformat = $formdata->description['format'];
            $record->status = $formdata->status;
            $record->timemodified = time();
            
            $transaction = $DB->start_delegated_transaction();
            $success = $DB->update_record('local_portfolio_items', $record);
            
            if (!$success) {
                throw new moodle_exception('errordatabase', 'local_portfolio');
            }
            
            // Создание события
            $event = \local_portfolio\event\entry_updated::create(array(
                'context' => $context,
                'objectid' => $record->id,
                'userid' => $USER->id
            ));
            $event->trigger();
            
            $transaction->allow_commit();
            
            // Перенаправление с сообщением об успехе
            redirect(
                new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)),
                get_string('achievementupdated', 'local_portfolio'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            
        } catch (Exception $e) {
            if (isset($transaction)) {
                $transaction->rollback($e);
            }
            
            \core\notification::error($e->getMessage());
        }
    }
    
    // Вывод формы
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('editachievement', 'local_portfolio'));
    $mform->display();
    echo $OUTPUT->footer();
}

/**
 * Обработка действия удаления записи
 *
 * @param int $id ID записи
 * @param context $context контекст курса
 * @param int $courseid ID курса
 */
function handle_delete_action($id, $context, $courseid) {
    global $DB, $USER, $OUTPUT;
    
    if (!$id) {
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
    
    // Проверка подтверждения
    $confirm = optional_param('confirm', 0, PARAM_BOOL);
    
    if (!$confirm) {
        // Запрос подтверждения
        echo $OUTPUT->header();
        echo $OUTPUT->heading(get_string('delete', 'local_portfolio'));
        
        $message = get_string('confirmdelete', 'local_portfolio');
        $continueurl = new moodle_url('/local/portfolio/manage.php', array(
            'action' => 'delete',
            'id' => $id,
            'courseid' => $courseid,
            'confirm' => 1
        ));
        $cancelurl = new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid));
        
        echo $OUTPUT->confirm($message, $continueurl, $cancelurl);
        echo $OUTPUT->footer();
        exit;
    }
    
    try {
        // Получение и удаление записи
        $record = $DB->get_record('local_portfolio_items', array('id' => $id, 'userid' => $USER->id));
        
        if (!$record) {
            throw new moodle_exception('errornotfound', 'local_portfolio');
        }
        
        $transaction = $DB->start_delegated_transaction();
        
        // Создание события перед удалением
        $event = \local_portfolio\event\entry_deleted::create(array(
            'context' => $context,
            'objectid' => $record->id,
            'userid' => $USER->id,
            'other' => array(
                'title' => $record->title
            )
        ));
        $event->add_record_snapshot('local_portfolio_items', $record);
        $event->trigger();
        
        // Удаление записи
        $success = $DB->delete_records('local_portfolio_items', array('id' => $id, 'userid' => $USER->id));
        
        if (!$success) {
            throw new moodle_exception('errordatabase', 'local_portfolio');
        }
        
        $transaction->allow_commit();
        
        // Перенаправление с сообщением об успехе
        redirect(
            new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)),
            get_string('achievementdeleted', 'local_portfolio'),
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
        
    } catch (Exception $e) {
        if (isset($transaction)) {
            $transaction->rollback($e);
        }
        
        \core\notification::error($e->getMessage());
        redirect(new moodle_url('/local/portfolio/manage.php', array('courseid' => $courseid)));
    }
}

/**
 * Обработка действия просмотра списка записей
 *
 * @param context $context контекст курса
 * @param int $courseid ID курса
 */
function handle_view_action($context, $courseid) {
    global $PAGE, $OUTPUT, $DB, $USER;
    
    $PAGE->set_title(get_string('myachievements', 'local_portfolio'));
    $PAGE->set_heading(get_string('myachievements', 'local_portfolio'));
    
    // Получение достижений пользователя
    $achievements = $DB->get_records('local_portfolio_items', 
        array('userid' => $USER->id), 
        'timecreated DESC'
    );
    
    // Подготовка данных для шаблона
    $renderdata = array(
        'has_items' => !empty($achievements),
        'addurl' => new moodle_url('/local/portfolio/manage.php', array(
            'action' => 'add',
            'courseid' => $courseid
        )),
        'achievements' => array()
    );
    
    if (!empty($achievements)) {
        foreach ($achievements as $achievement) {
            // Получение названия категории
            $category_name = '';
            if ($achievement->catid) {
                $category = $DB->get_record('local_portfolio_categories', 
                    array('id' => $achievement->catid));
                if ($category) {
                    $category_name = format_string($category->name);
                }
            }
            
            // Форматирование даты
            $timecreated_formatted = userdate($achievement->timecreated, 
                get_string('strftimedatefullshort', 'langconfig'));
            
            $renderdata['achievements'][] = array(
                'id' => $achievement->id,
                'title' => format_string($achievement->title),
                'description' => format_text($achievement->description, $achievement->descriptionformat),
                'category_name' => $category_name ?: get_string('uncategorized', 'local_portfolio'),
                'status_published' => (bool)$achievement->status,
                'timecreated_formatted' => $timecreated_formatted,
                'editurl' => new moodle_url('/local/portfolio/manage.php', array(
                    'action' => 'edit',
                    'id' => $achievement->id,
                    'courseid' => $courseid
                )),
                'deleteurl' => new moodle_url('/local/portfolio/manage.php', array(
                    'action' => 'delete',
                    'id' => $achievement->id,
                    'courseid' => $courseid
                )),
                'viewurl' => new moodle_url('/local/portfolio/view.php', array(
                    'id' => $achievement->id,
                    'courseid' => $courseid
                ))
            );
        }
    }
    
    // Вывод страницы
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('myachievements', 'local_portfolio'));
    echo $OUTPUT->render_from_template('local_portfolio/achievements_list', $renderdata);
    echo $OUTPUT->footer();
}