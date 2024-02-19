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
use Adhoc\Model\Reference\Departement;
use Adhoc\Utils\AdHocSmarty;
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

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

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

        if ($_SESSION['membre']->getId() === 1) {
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
                    'id_contact' => $_SESSION['membre']->getId(),
                    'order_by' => 'id_audio',
                    'sort' => 'ASC',
                    'start' => $page * NB_AUDIOS_PER_PAGE,
                    'limit' => NB_AUDIOS_PER_PAGE,
                ]
            );
            $nb_audios = Audio::countMy();
        }
        $smarty->assign('audios', $audios);

        $smarty->assign('del', Route::params('del'));

        // pagination
        $smarty->assign('nb_items', $nb_audios);
        $smarty->assign('nb_items_per_page', NB_AUDIOS_PER_PAGE);
        $smarty->assign('page', $page);

        return $smarty->fetch('audios/my.tpl');
    }

    /**
     * @return string
     */
    public static function show(): string
    {
        $id = (int) Route::params('id');

        $smarty = new AdHocSmarty();

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/show.tpl');
        }

        $meta_description = "Titre : " . $audio->getName();

        if ($audio->getIdGroupe()) {
            $groupe = Groupe::getInstance($audio->getIdGroupe());
            $smarty->assign('groupe', $groupe);
            $smarty->assign('title', $audio->getName() . ' - ' . $groupe->getName());
            $meta_description .= " | Groupe : " . $groupe->getName();
            Trail::getInstance()
                ->addStep("Groupes", "/groupes")
                ->addStep($groupe->getName(), $groupe->getUrl());
            $smarty->assign('og_image', $groupe->getMiniPhoto());
            $smarty->assign(
                'og_audio',
                [
                    'url' => $audio->getDirectMp3Url(),
                    'title' => $audio->getName(),
                    'artist' => $groupe->getName(),
                    'type' => "application/mp3",
                ]
            );
        } else {
            Trail::getInstance()
                ->addStep("Média", "/medias");
        }

        if ($audio->getIdEvent()) {
            $event = Event::getInstance($audio->getIdEvent());
            $smarty->assign('event', $event);
            $meta_description .= " | Evénement : " . $event->getName() . " (" . Date::mysqlDatetime($event->getDate(), "d/m/Y") . ")";
            $smarty->assign(
                'photos',
                Photo::find(
                    [
                        'id_event' => $event->getIdEvent(),
                        'id_groupe' => $audio->getIdGroupe(),
                        'online' => true,
                        'order_by' => 'random',
                        'limit' => 100,
                    ]
                )
            );
            $smarty->assign(
                'videos',
                Video::find(
                    [
                        'id_event' => $event->getIdEvent(),
                        'id_groupe' => $audio->getIdGroupe(),
                        'online' => true,
                        'order_by' => 'random',
                        'limit' => 100,
                    ]
                )
            );
        }

        if ($audio->getIdLieu()) {
            $lieu = Lieu::getInstance($audio->getIdLieu());
            $meta_description .= " | Lieu : " . $lieu->getName() . " (" . $lieu->getIdDepartement() . " - " . $lieu->getCity()->getName() . ")";
            $smarty->assign('lieu', $lieu);
        }

        Trail::getInstance()
            ->addStep($audio->getName());

        $smarty->assign('description', $meta_description);

        $smarty->assign('audio', $audio);

        $smarty->assign(
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

        return $smarty->fetch('audios/show.tpl');
    }

    /**
     * @return string
     */
    public static function create(): string
    {
        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/audios/create.js');

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
                'id_contact' => (int) $_SESSION['membre']->getId(),
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
                        move_uploaded_file($uploaded_audio_path, Audio::getBasePath() . '/' . $audio->getId() . '.mp3');
                    } else {
                        mail(DEBUG_EMAIL, 'bug audio create', 'bug audio create');
                    }
                    Log::action(Log::ACTION_AUDIO_CREATE, $audio->getId());
                    Tools::redirect('/audios/my');
                } else {
                    $smarty->assign('error_generic', true);
                }
            } else {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
                $smarty->assign('data', $data);
            }
        }

        $id_groupe = (int) Route::params('id_groupe');
        if ($id_groupe) {
            $groupe = Groupe::getInstance($id_groupe);
            $smarty->assign('groupe', $groupe);
        } else {
            $smarty->assign(
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
            $smarty->assign('lieu', $lieu);
            $smarty->assign(
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
            $smarty->assign('deps', Departement::findAll());
            $smarty->assign('lieux', Lieu::getLieuxByDep());
        }

        $id_event = (int) Route::params('id_event');
        if ($id_event) {
            $event = Event::getInstance($id_event);
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        $smarty->assign('id_lieu', $id_lieu);

        return $smarty->fetch('audios/create.tpl');
    }

    /**
     * @return string
     */
    public static function edit(): string
    {
        $id = (int) Route::params('id');
        $page = (int) Route::params('page');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/audios/edit.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques', '/audios/my')
            ->addStep('Éditer une musique');

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/edit.tpl');
        }

        $smarty->assign('audio', $audio);

        if (Tools::isSubmit('form-audio-edit')) {
            set_time_limit(0); // l'upload peut prendre du temps !

            $data = [
                'name' => (string) Route::params('name'),
                'id_groupe'  => Route::params('id_groupe') ? (int) Route::params('id_groupe') : null,
                'id_lieu'    => Route::params('id_lieu') ? (int) Route::params('id_lieu') : null,
                'id_event'   => Route::params('id_event') ? (int) Route::params('id_event') : null,
                'id_contact' => (int) $_SESSION['membre']->getId(),
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
                    Log::action(Log::ACTION_AUDIO_EDIT, $audio->getId());
                    Tools::redirect('/audios/my');
                } else {
                    $smarty->assign('error_generic', true);
                }
            } else {
                foreach ($errors as $k => $v) {
                    $smarty->assign('error_' . $k, $v);
                }
            }
        }

        $smarty->assign(
            'groupes',
            Groupe::find(
                [
                    'online' => true,
                    'order_by' => 'name',
                    'sort' => 'ASC',
                ]
            )
        );

        $smarty->assign('deps', Departement::findAll());
        $smarty->assign('lieux', Lieu::getLieuxByDep());

        $smarty->assign('page', $page);

        if ($audio->getIdEvent()) {
            $event = Event::getInstance($audio->getIdEvent());
            $smarty->assign('event', $event);
            $lieu = Lieu::getInstance($event->getIdLieu());
            $smarty->assign('lieu', $lieu);
        }

        if ($audio->getIdContact()) {
            $smarty->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $smarty->fetch('audios/edit.tpl');
    }

    /**
     * @return string
     */
    public static function delete(): string
    {
        $id = (int) Route::params('id');

        Tools::auth(Membre::TYPE_STANDARD);

        $smarty = new AdHocSmarty();

        $smarty->assign('robots', 'noindex,nofollow');

        $smarty->enqueueScript('/js/audios/delete.js');

        Trail::getInstance()
            ->addStep('Tableau de bord', '/membres/tableau-de-bord')
            ->addStep('Mes musiques', '/audios/my')
            ->addStep('Supprimer une musique');

        try {
            $audio = Audio::getInstance($id);
        } catch (\Exception $e) {
            Route::setHttpCode(404);
            $smarty->assign('unknown_audio', true);
            return $smarty->fetch('audios/delete.tpl');
        }

        if (Tools::isSubmit('form-audio-delete')) {
            if ($audio->delete()) {
                Log::action(Log::ACTION_AUDIO_DELETE, $audio->getId());
                Tools::redirect('/audios/my');
            } else {
                $errors['generic'] = true;
            }
        }

        $smarty->assign('audio', $audio);
        if ($audio->getIdGroupe()) {
            try {
                $smarty->assign('groupe', Groupe::getInstance($audio->getIdGroupe()));
            } catch (\Exception $e) {
            }
        }
        if ($audio->getIdEvent()) {
            $smarty->assign('event', Event::getInstance($audio->getIdEvent()));
        }
        if ($audio->getIdLieu()) {
            $smarty->assign('lieu', Lieu::getInstance($audio->getIdLieu()));
        }
        if ($audio->getIdContact()) {
            $smarty->assign('membre', Membre::getInstance($audio->getIdContact()));
        }

        return $smarty->fetch('audios/delete.tpl');
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

        if (empty($data['name'])) {
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
