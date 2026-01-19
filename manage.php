<?php
/**
 * Скрипт управления достижениями студента в ЭИОС
 * Реализует функции добавления и просмотра записей портфолио.
 */

// 1. Подключение ядра Moodle и библиотек плагина
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/portfolio_form.php'); // Класс формы на базе moodleform

// 2. Параметры страницы
$courseid = optional_param('courseid', SITEID, PARAM_INT);
$action   = optional_param('action', 'view', PARAM_ALPHA);

// 3. Проверка прав доступа и аутентификация (ФЗ-152)
require_login($courseid);
$context = context_system::instance();
require_capability('local/portfolio:viewown', $context);

// 4. Настройка интерфейса страницы
$PAGE->set_url(new moodle_url('/local/portfolio/manage.php'));
$PAGE->set_context($context);
$PAGE->set_title(get_string('portfolio_title', 'local_portfolio'));
$PAGE->set_heading(get_string('portfolio_heading', 'local_portfolio'));

// 5. Обработка логики формы (Добавление достижения)
$mform = new portfolio_entry_form();

if ($mform->is_cancelled()) {
    // Возврат на главную страницу портфолио
    redirect(new moodle_url('/local/portfolio/index.php'));
} else if ($data = $mform->get_data()) {
    // Сохранение данных в БД PostgreSQL через Moodle DB API
    $record = new stdClass();
    $record->userid       = $USER->id;
    $record->title        = $data->title;
    $record->catid        = $data->catid;
    $record->description  = $data->description;
    $record->status       = 0; // На модерации
    $record->timecreated  = time();
    $record->timemodified = time();

    // Безопасная вставка в таблицу mdl_local_portfolio_items
    $itemid = $DB->insert_record('local_portfolio_items', $record);

    // Логирование цифрового следа (Event API)
    $event = \local_portfolio\event\entry_created::create(array(
        'objectid' => $itemid,
        'context'  => $context,
    ));
    $event->trigger();

    redirect(new moodle_url('/local/portfolio/index.php'), get_string('save_success', 'local_portfolio'));
}

// 6. Вывод интерфейса
echo $OUTPUT->header();

if ($action == 'add') {
    echo $OUTPUT->heading(get_string('add_achievement', 'local_portfolio'));
    $mform->display();
} else {
    // Вывод списка достижений текущего пользователя
    $achievements = $DB->get_records('local_portfolio_items', ['userid' => $USER->id]);
    
    $renderdata = [
        'items' => array_values($achievements),
        'has_items' => !empty($achievements)
    ];
    
    // Рендеринг через Mustache шаблон
    echo $OUTPUT->render_from_template('local_portfolio/items_list', $renderdata);
}

echo $OUTPUT->footer();
