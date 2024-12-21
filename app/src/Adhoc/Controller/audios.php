<?php

declare(strict_types=1);

namespace Adhoc\Controller;

use Adhoc\Model\Audio;
use Adhoc\Model\Comment;
use Adhoc\Model\Event;
use Adhoc\Model\Groupe;
use Adhoc\Model\Lieu;
use Adhoc\Model\Membre;
use Adhoc\Model\Photo;
use Adhoc\Model\Departement;
use Adhoc\Utils\AdHocTwig;
use Adhoc\Utils\Date;
use Adhoc\Utils\Log;
use Adhoc\Utils\Route;
use Adhoc\Utils\Trail;
use Adhoc\Utils\Tools;
use Adhoc\Model\Video;

// Note : on retire liens vers events, structures et lieux du formulaire
// pour plus de lisibilité, temporairement !

define('NB_AUDIOS_PER_PAGE', 80);

final class Controller
{
    /**
     * @return string
     */
    public static function my(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques');

        $page = (int) Route::params('page');
        $id = (int) Route::params('id');
        $online = (bool) Route::params('online');

        if ($id) {
            $audio = Audio::getInstance($id);
            $audio->setOnline($online);
            $audio->save();
        }

        if ($_SESSION['membre']->getIdContact() === 1) {
            $audios = Audio::find(
                [
                    'order_by' => 'id_audio',
                    'sort' => 'ASC',
                    'start' => $page * NB_AUDIOS_PER_PAGE,
                    'limit' => NB_AUDIOS_PER_PAGE,
                ]
            );
            $nb_audios = Audio::count();
        } else {
            $audios = Audio::find(
                [
                    'id_contact' => $_SESSION['membre']->getIdContact(),
                    'order_by' => 'id_audio',
                    'sort' => 'ASC',
                    'start' => $page * NB_AUDIOS_PER_PAGE,
                    'limit' => NB_AUDIOS_PER_PAGE,
                ]
            );
            $nb_audios = Audio::countMy();
        }
        $twig->assign('audios', $audios);

        $twig->assign('del', Route::params('del'));

        // pagination
        $twig->assign('nb_items', $nb_audios);
        $twig->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $twig->assign('page', $page);

        return $twig->render('audios/my.twig');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $twig = new AdHocTwig();

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_audio', true);
            return $twig->render('audios/show.twig');
        }

        $meta_description = "Titre : " . $audio->getName();

        if ($audio->getIdGroupe()) {
            $twig->assign('title', $audio->getName() . ' - ' . $audio->getGroupe()->getName());
            $meta_description .= " | Groupe : " . $audio->getGroupe()->getName();
            Trail::getInstance()
                ->addStep("Groupes", "/groupes")
                ->addStep($audio->getGroupe()->getName(), $audio->getGroupe()->getUrl());
            $twig->assign('og_image', $audio->getGroupe()->getMiniPhoto());
            $twig->assign(
                'og_audio',
                [
                    'url' => $audio->getDirectMp3Url(),
                    'title' => $audio->getName(),
                    'artist' => $audio->getGroupe()->getName(),
                    'type' => "application/mp3",
                ]
            );
        } else {
            Trail::getInstance()
                ->addStep("Média", "/medias");
        }

        if ($audio->getIdEvent()) {
            $meta_description .= " | Evénement : " . $audio->getEvent()->getName() . " (" . Date::mysqlDatetime($audio->getEvent()->getDate(), "d/m/Y") . ")";
            $twig->assign(
                'photos',
                Photo::find(
                    [
                        'id_event' => $audio->getIdEvent(),
                        'id_groupe' => $audio->getIdGroupe(),
                        'online' => true,
                        'order_by' => 'random',
                        'limit' => 100,
                    ]
                )
            );
            $twig->assign(
                'videos',
                Video::find(
                    [
                        'id_event' => $audio->getIdEvent(),
                        'id_groupe' => $audio->getIdGroupe(),
                        'online' => true,
                        'order_by' => 'random',
                        'limit' => 100,
                    ]
                )
            );
        }

        if ($audio->getIdLieu()) {
            $meta_description .= " | Lieu : " . $audio->getLieu()->getName() . " (" . $audio->getLieu()->getIdDepartement() . " - " . $audio->getLieu()->getCity()->getName() . ")";
        }

        Trail::getInstance()
            ->addStep($audio->getName());

        $twig->assign('description', $meta_description);

        $twig->assign('audio', $audio);

        $twig->assign(
            'comments',
            Comment::find(
                [
                    'id_type' => 's',
                    'id_content' => $audio->getIdAudio(),
                    'online' => true,
                    'order_by' => 'created_at',
                    'sort' => 'ASC',
                ]
            )
        );

        return $twig->render('audios/show.twig');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/audios/create.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques', '/audios/my')
            ->addStep('Ajouter une musique');

        if (Tools::isSubmit('form-audio-create')) {
            set_time_limit(0); // l'upload peut prendre du temps !

            $data = [
                'name'       => trim((string) Route::params('name')),
                'id_groupe'  => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu'    => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event'   => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => (int) $_SESSION['membre']->getIdContact(),
                'online'     => (bool) Route::params('online'),
            ];

            $errors = self::validateAudioForm($data);
            if (count($errors) === 0) {
                $audio = (new Audio())
                    ->setName($data['name'])
                    ->setIdGroupe($data['id_groupe'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdEvent($data['id_event'])
                    ->setIdContact($data['id_contact'])
                    ->setOnline($data['online']);

                if ($audio->save()) {
                    $uploaded_audio_path = $_FILES['file']['tmp_name'];
                    if (is_uploaded_file($uploaded_audio_path)) {
                        if (!is_dir(Audio::getBasePath())) {
                            mkdir(Audio::getBasePath(), 0755, true);
                        }
                        move_uploaded_file($uploaded_audio_path, Audio::getBasePath() . '/' . $audio->getIdAudio() . '.mp3');
                    } else {
                        mail(DEBUG_EMAIL, 'bug audio create', 'bug audio create');
                    }
                    Log::info("Audio create " . $audio->getIdAudio());
                    Tools::redirect('/audios/my');
                } else {
                    $twig->assign('error_generic', true);
                }
            } else {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
                $twig->assign('data', $data);
            }
        }

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $twig->assign('groupe', $groupe);
        } else {
            $twig->assign(
                'groupes',
                Groupe::find(
                    [
                        'online' => true,
                        'order_by' => 'name',
                        'sort' => 'ASC',
                    ]
                )
            );
        }

        $id_lieu = (int) Route::params('id_lieu');
        if ($id_lieu) {
            $lieu = Lieu::getInstance($id_lieu);
            $twig->assign('lieu', $lieu);
            $twig->assign(
                'events',
                Event::find(
                    [
                        'online' => true,
                        'datfin' => date('Y-m-d H:i:s'),
                        'id_lieu' => $lieu->getIdLieu(),
                        'order_by' => 'date',
                        'sort' => 'ASC',
                        'limit' => 100,
                    ]
                )
            );
        } else {
            $twig->assign('deps', Departement::findAll());
            $twig->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if ($id_event) {
            $event = Event::getInstance($id_event);
            $twig->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $twig->assign('lieu', $lieu);
        }

        $twig->assign('id_lieu', $id_lieu);

        return $twig->render('audios/create.twig');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/audios/edit.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques', '/audios/my')
            ->addStep('Éditer une musique');

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_audio', true);
            return $twig->render('audios/edit.twig');
        }

        $twig->assign('audio', $audio);

        if (Tools::isSubmit('form-audio-edit')) {
            set_time_limit(0); // l'upload peut prendre du temps !

            $data = [
                'name' => (string) Route::params('name'),
                'id_groupe'  => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu'    => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event'   => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => (int) $_SESSION['membre']->getIdContact(),
                'online' => (bool) Route::params('online'),
            ];

            $errors = self::validateAudioForm($data);
            if (count($errors) === 0) {
                $audio->setName($data['name'])
                    ->setIdLieu($data['id_lieu'])
                    ->setIdContact($data['id_contact'])
                    ->setIdEvent($data['id_event'])
                    ->setIdGroupe($data['id_groupe'])
                    ->setOnline($data['online']);

                if ($audio->save()) {
                    Log::info("Audio edit " . $audio->getIdAudio());
                    Tools::redirect('/audios/my');
                } else {
                    $twig->assign('error_generic', true);
                }
            } else {
                foreach ($errors as $k => $v) {
                    $twig->assign('error_' . $k, $v);
                }
            }
        }

        $twig->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $twig->assign('deps', Departement::findAll());
        $twig->assign('lieux', Lieu::getLieuxByDep());

        $twig->assign('page', $page);

        if ($audio->getIdEvent()) {
            $event = Event::getInstance($audio->getIdEvent());
            $twig->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $twig->assign('lieu', $lieu);
        }

        if ($audio->getIdContact()) {
            $twig->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $twig->render('audios/edit.twig');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $twig = new AdHocTwig();

        $twig->assign('robots', 'noindex,nofollow');

        $twig->enqueueScript('/js/audios/delete.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques', '/audios/my')
            ->addStep('Supprimer une musique');

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $twig->assign('unknown_audio', true);
            return $twig->render('audios/delete.twig');
        }

        if (Tools::isSubmit('form-audio-delete')) {
            if ($audio->delete()) {
                Log::info("Audio delete " . $audio->getIdAudio());
                Tools::redirect('/audios/my');
            } else {
                $errors['generic'] = true;
            }
        }

        $twig->assign('audio', $audio);
        if ($audio->getIdGroupe()) {
            try {
                $twig->assign('groupe', Groupe::getInstance($audio->getIdGroupe()));
            } catch (\Exception $e) {
            }
        }
        if ($audio->getIdEvent()) {
            $twig->assign('event', Event::getInstance($audio->getIdEvent()));
        }
        if ($audio->getIdLieu()) {
            $twig->assign('lieu', Lieu::getInstance($audio->getIdLieu()));
        }
        if ($audio->getIdContact()) {
            $twig->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $twig->render('audios/delete.twig');
    }

    /**
     * Validation du formulaire création/édition audio
     *
     * @param array<string,mixed> $data tableau des données
     *
     * @return array<string,true>
     */
    private static function validateAudioForm($data): array
    {
        $errors = [];

        if (!isset($data['name'])) {
            $errors['name'] = true;
        } elseif (strlen($data['name']) === 0) {
            $errors['name'] = true;
        }

        if (($data['id_groupe'] === 0) && ($data['id_event'] === 0) && ($data['id_lieu'] === 0)) {
            $errors['id_groupe'] = true;
            $errors['id_event'] = true;
            $errors['id_lieu'] = true;
        }

        return $errors;
    }
}
