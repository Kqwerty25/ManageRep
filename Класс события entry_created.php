<?php
/**
 * Событие создания записи портфолио
 *
 * @package    local_portfolio
 * @copyright  2024
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_portfolio\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Событие создания записи портфолио
 */
class entry_created extends \core\event\base {

    /**
     * Инициализация события
     */
    protected function init() {
        $this->data['objecttable'] = 'local_portfolio_items';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Возвращает локализованное название события
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententrycreated', 'local_portfolio');
    }

    /**
     * Возвращает описание события
     *
     * @return string
     */
    public function get_description() {
        $userid = $this->data['userid'];
        $objectid = $this->data['objectid'];
        
        return "Пользователь с id '$userid' создал запись портфолио с id '$objectid'.";
    }

    /**
     * Возвращает URL, связанный с событием
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/portfolio/manage.php', array(
            'id' => $this->data['objectid'],
            'courseid' => $this->contextinstanceid
        ));
    }

    /**
     * Возвращает массив для сериализации
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'portfolio', 'add', 
            'manage.php?id=' . $this->data['objectid'], 
            $this->data['objectid'], $this->contextinstanceid);
    }

    /**
     * Настраивает данные события перед сохранением
     */
    protected function validate_data() {
        parent::validate_data();
        
        if (!isset($this->data['objectid'])) {
            throw new \coding_exception('Поле objectid должно быть установлено в данных события.');
        }
        
        if (!isset($this->contextid)) {
            throw new \coding_exception('Поле contextid должно быть установлено в данных события.');
        }
    }

    /**
     * Возвращает маппинг для сериализации
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return array('db' => 'local_portfolio_items', 'restore' => 'portfolio_item');
    }

    /**
     * Возвращает маппинг для других полей
     *
     * @return array
     */
    public static function get_other_mapping() {
        return array();
    }
}

/**
 * Событие обновления записи портфолио
 */
class entry_updated extends \core\event\base {

    /**
     * Инициализация события
     */
    protected function init() {
        $this->data['objecttable'] = 'local_portfolio_items';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Возвращает локализованное название события
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententryupdated', 'local_portfolio');
    }

    /**
     * Возвращает описание события
     *
     * @return string
     */
    public function get_description() {
        $userid = $this->data['userid'];
        $objectid = $this->data['objectid'];
        
        return "Пользователь с id '$userid' обновил запись портфолио с id '$objectid'.";
    }

    /**
     * Возвращает URL, связанный с событием
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/portfolio/manage.php', array(
            'id' => $this->data['objectid'],
            'courseid' => $this->contextinstanceid
        ));
    }

    /**
     * Возвращает массив для сериализации
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'portfolio', 'update', 
            'manage.php?id=' . $this->data['objectid'], 
            $this->data['objectid'], $this->contextinstanceid);
    }
}

/**
 * Событие удаления записи портфолио
 */
class entry_deleted extends \core\event\base {

    /**
     * Инициализация события
     */
    protected function init() {
        $this->data['objecttable'] = 'local_portfolio_items';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Возвращает локализованное название события
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententrydeleted', 'local_portfolio');
    }

    /**
     * Возвращает описание события
     *
     * @return string
     */
    public function get_description() {
        $userid = $this->data['userid'];
        $objectid = $this->data['objectid'];
        
        return "Пользователь с id '$userid' удалил запись портфолио с id '$objectid'.";
    }

    /**
     * Возвращает URL, связанный с событием
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/portfolio/manage.php', array(
            'courseid' => $this->contextinstanceid
        ));
    }

    /**
     * Возвращает массив для сериализации
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'portfolio', 'delete', 
            'manage.php', 
            $this->data['objectid'], $this->contextinstanceid);
    }
}

/**
 * Событие просмотра записи портфолио
 */
class entry_viewed extends \core\event\base {

    /**
     * Инициализация события
     */
    protected function init() {
        $this->data['objecttable'] = 'local_portfolio_items';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Возвращает локализованное название события
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententryviewed', 'local_portfolio');
    }

    /**
     * Возвращает описание события
     *
     * @return string
     */
    public function get_description() {
        $userid = $this->data['userid'];
        $objectid = $this->data['objectid'];
        
        return "Пользователь с id '$userid' просмотрел запись портфолио с id '$objectid'.";
    }

    /**
     * Возвращает URL, связанный с событием
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/local/portfolio/manage.php', array(
            'id' => $this->data['objectid'],
            'courseid' => $this->contextinstanceid
        ));
    }

    /**
     * Возвращает массив для сериализации
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'portfolio', 'view', 
            'manage.php?id=' . $this->data['objectid'], 
            $this->data['objectid'], $this->contextinstanceid);
    }
}