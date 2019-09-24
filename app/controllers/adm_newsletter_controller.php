<?php declare(strict_types=1);

final class Controller
{
    static function index(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        $smarty = new AdHocSmarty();

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Newsletter");

        $smarty->assign(
            'newsletters', Newsletter::getNewsletters(
                [
                    'sens' => 'DESC',
                    'limit' => 50,
                ]
            )
        );
        $smarty->assign('nb_sub', Newsletter::getSubscribersCount());

        return $smarty->fetch('adm/newsletter/index.tpl');
    }

    static function create(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-create')) {
            $data = [
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            Newsletter::init()
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->save();

            Tools::redirect('/adm/newsletter/?create=1');
        }

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/codemirror.min.css');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/codemirror.min.js');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/mode/xml/xml.min.js');
        $smarty->enqueue_script('/js/adm/newsletter.js');

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Newsletter", "/adm/newsletter/")
            ->addStep("Ajout");

        $data = [
            'title' => '',
            'content' => '',
        ];

        $smarty->assign('data', $data);

        return $smarty->fetch('adm/newsletter/create.tpl');
    }

    static function edit(): string
    {
        Tools::auth(Membre::TYPE_INTERNE);

        if (Tools::isSubmit('form-newsletter-edit')) {
            $data = [
                'id'      => (int) Route::params('id'),
                'title'   => trim((string) Route::params('title')),
                'content' => trim((string) Route::params('content')),
            ];

            // dépendance à mjml via npm
            $mjmlBin = ADHOC_ROOT_PATH . '/node_modules/.bin/mjml';
            $html = shell_exec($mjmlBin . " -i <<EOF\n" . $data['content'] . "\nEOF");

            Newsletter::getInstance($data['id'])
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setHtml($html)
                ->save();

            Tools::redirect('/adm/newsletter/edit/' . (int) Route::params('id') . '?edit=1');
        }

        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        $smarty->enqueue_style('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/codemirror.min.css');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/codemirror.min.js');
        $smarty->enqueue_script('https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.40.2/mode/xml/xml.min.js');
        $smarty->enqueue_script('/js/adm/newsletter.js');

        Trail::getInstance()
            ->addStep("Privé", "/adm/")
            ->addStep("Newsletter", "/adm/newsletter/")
            ->addStep("Edition");

        $smarty->assign('newsletter', Newsletter::getInstance($id));

        return $smarty->fetch('adm/newsletter/edit.tpl');
    }

    /**
     * Upload fichier pour newsletter
     * il est stocké dans le répertoire dédié sans traitement particulier
     */
    static function upload(): string
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
