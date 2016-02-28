<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.02.16
 * Time: 9:12
 */
class ModelModuleNews extends Model
{
    public function install()
    {
        $this->db->query("
        CREATE TABLE " . DB_PREFIX . "news (
            id INT(11) NOT NULL AUTO_INCREMENT,
            title VARCHAR(255),
            description TEXT,
            PRIMARY KEY(id)
            )
            ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
            ");
    }

    public function uninstall()
    {
        $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "news");
    }

    public function getValueTableNews()
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "news ORDER BY id DESC";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function addNews($data)
    {
        $this->db->query("INSERT INTO  " . DB_PREFIX . "news (title, description) VALUES('" . $this->db->escape($data['add-news-title']) ."', '" . $this->db->escape($data['add-news-description']) . "')");
    }

    public function getValueEditNews($get_array)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "news WHERE id='" . $get_array['news_id'] . "'";
        $query = $this->db->query($sql);

        return $query->rows;

    }

    public function editNews($dat, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "news SET title='" . $this->db->escape($data['edit-news-title']) . "', description='" . $this->db->escape($data['edit-news-description']) . "' WHERE id='" . (int)$dat . "'");
    }

    public function deleteNews($code)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "news WHERE id='" . (int)$code . "'");
    }
}