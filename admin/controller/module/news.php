<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 20.02.16
 * Time: 9:10
 */
class ControllerModuleNews extends Controller
{
    private $error = array();

    public function install()
    {
        $this->load->model('module/news');

        $this->model_module_news->install();
    }

    public function uninstall()
    {
        $this->load->model('module/news');

        $this->model_module_news->uninstall();
    }

    public function index()
    {
        $this->load->language('module/news');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/news');

       $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_title'] = $this->language->get('text_title');
        $data['text_description'] = $this->language->get('text_description');
        $data['text_confirm'] = $this->language->get('text_confirm');
        $data['text_delete'] = $this->language->get('text_delete');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_add'] = $this->language->get('button_add');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['add'] = $this->url->link('module/news/add', 'token=' . $this->session->data['token'], 'SSL');
        $data['delete'] = $this->url->link('module/news/delete', 'token=' . $this->session->data['token'], 'SSL');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $news_data = array();

        $data_table = $this->model_module_news->getValueTableNews();
        foreach ($data_table as $data_news) {
            $news_data[] = array(
                'news_id' => $data_news['id'],
                'title' => $data_news['title'],
                'description' => $data_news['description'],
                'edit' => $this->url->link('module/news/edit', 'token=' . $this->session->data['token'] . '&news_id=' . $data_news['id'], 'SSL'),
                'delete' => $this->url->link('module/news/delete', 'token=' . $this->session->data['token'] . '&news_id=' . $data_news['id'], 'SSL')
            );
        }

        $data['all_news'] = $news_data;

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $this->response->setOutput($this->load->view('module/news.tpl', $data));

    }

    public function add()
    {
        $this->load->language('module/news');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/news');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_module_news->addNews($this->request->post);

            $this->session->data['text_success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['text_addnews'] = $this->language->get('text_addnews');
        $data['text_add_news'] = $this->language->get('text_add_news');
        $data['text_add'] = $this->language->get('text_add');
        $data['text_title'] = $this->language->get('text_title');
        $data['text_please_title'] = $this->language->get('text_please_title');
        $data['text_please_description'] = $this->language->get('text_please_description');
        $data['text_description'] = $this->language->get('text_description');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_add_news'),
            'href' => $this->url->link('module/news/add', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['cancel'] = $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL');
        $data['add'] = $this->url->link('module/news/add', 'token=' . $this->session->data['token'], 'SSL');

        $this->response->setOutput($this->load->view('module/addnews.tpl', $data));

    }

    public function edit()
    {
        $this->load->language('module/news');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/news');


        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_module_news->editNews($this->request->get['news_id'], $this->request->post);

            $this->session->data['text_success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL'));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $value_form = array();

        $value_table = $this->model_module_news->getValueEditNews($this->request->get);
        foreach ($value_table as $value) {
            $value_form[] = array(
                'title' => $value['title'],
                'description' => $value['description']
            );
        }

        $data['all_value'] = $value_form;

        $data['heading_title'] = $this->language->get('heading_title');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['text_addnews'] = $this->language->get('text_addnews');
        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_title'] = $this->language->get('text_title');
        $data['text_description'] = $this->language->get('text_description');

        $data['cancel'] = $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL');
        $data['edit'] = $this->url->link('module/news/edit', 'token=' . $this->session->data['token']. '&news_id=' . $this->request->get['news_id'], 'SSL');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_edit'),
            'href' => $this->url->link('module/news/edit', 'token=' . $this->session->data['token'], 'SSL')
        );

        $this->response->setOutput($this->load->view('module/editnews.tpl', $data));

    }

    public function delete() {
        $this->load->language('module/news');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/news');

        $data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->request->post['selected']) && $this->validate()) {
            foreach ($this->request->post['selected'] as $id) {
                $this->model_module_news->deleteNews($id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL'));
        } else {
            $this->response->redirect($this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL'));
        }

    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'module/news')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

}