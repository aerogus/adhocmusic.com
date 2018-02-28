<?php

class Controller
{
    static function index()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter");

        $smarty->assign('newsletters', Newsletter::getNewsletters([
            'sens' => 'DESC',
            'limit' => 50,
        ]));
        $smarty->assign('nb_sub', Newsletter::getSubscribersCount());

        return $smarty->fetch('adm/newsletter/index.tpl');
    }

    static function create()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-create'))
        {
            $data = [
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            $newsletter = Newsletter::init();
            $newsletter->setTitle($data['title']);
            $newsletter->setContent($data['content']);
            $newsletter->save();

            Tools::redirect('/adm/newsletter/?create=1');
        }

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.css');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.js');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/mode/xml/xml.min.js');
        $smarty->enqueue_script('/js/adm/newsletter.js');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Ajout");

        $data = [
            'title' => '',
            'content' => '',
        ];

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/newsletter/create.tpl');
    }

    static function edit()
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-edit'))
        {
            $data = [
                'id'      => (int) Route::params('id'),
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            $newsletter = Newsletter::getInstance($data['id']);
            $newsletter->setTitle($data['title']);
            $newsletter->setContent($data['content']);

            // API MJML.IO
            $user = '0b7f9405-e21a-46ed-bc71-e5ae1b80081f'; // = App ID
            $pass = 'cda5e512-82cf-4c9f-b901-f478359d02b7'; // = Secret Key

            $mjml = $data['content'];

            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, 'https://api.mjml.io/v1/render');
            curl_setopt($c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($c, CURLOPT_USERPWD, "$user:$pass");
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, json_encode(['mjml' => $mjml]));

            $response = curl_exec($c);
            $json = json_decode($response);

            if (!$json->error) {
                $newsletter->setHtml($json->html);
            }

            $newsletter->save();

            Tools::redirect('/adm/newsletter/edit/' . (int) Route::params('id') . '?edit=1');
        }

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.css');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/codemirror.min.js');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.35.0/mode/xml/xml.min.js');
        $smarty->enqueue_script('/js/adm/newsletter.js');

        $trail = Trail::getInstance();
        $trail->addStep("Privé", "/adm/");
        $trail->addStep("Newsletter", "/adm/newsletter/");
        $trail->addStep("Edition");

        $smarty->assign('newsletter', Newsletter::getInstance($id));

        return $smarty->fetch('adm/newsletter/edit.tpl');
    }

    /**
     * upload fichier pour newsletter
     * il est stocké dans le répertoire dédié sans traitement particulier
     */
    static function upload()
    {
        $id = (int) Route::params('id');
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $n = Newsletter::getInstance($id);
            if (!file_exists($n->getFilePath())) {
                mkdir($n->getFilePath());
            }
            move_uploaded_file($_FILES['file']['tmp_name'], $n->getFilePath() . '/' . $_FILES['file']['name']);
            return 'OK';
        }
        return 'KO';
    }
}
