<?php
/**
 * planch_creator
 *
 * @package adhoc
 * @author Taddei Gilles <gilles.taddei@gmail.com>
 */

$image = resize_no_file("badge.png");
$event = "Fet'Estival";
$date = "29/06/2013";
/**
 * @function create_planch
 * @param[in] tab_grp le tableau des groupes
 * @param[in] tab_name le tableau des noms
 * @param[in] begin l'index de début des tableaux
 * @param[in] end l'index de fin des tableaux
 * @brief This function checks where to start writing the text.
 */
function create_planch($tab_grp, $tab_name, $begin, $end, $num_rows, $num_cols, $gray, $box, $ecart_x, $ecart_y, $cont, $bright, $red, $green, $blue, $conso=0)
{
    //On récupère l'image du badge et on la sauvegarde dans une autre variable
    global $image;
    $img = $image;
    //On récupère le nbr de colonnes/lignes.
    $num_rows = isset($num_rows) ? $num_rows : 4;
    $num_cols = isset($num_cols) ? $num_cols : 4;
    $font_num = imageloadfont('verdana.gdf');
    //On crée un badge bateau pour  avoir ses dimension, image détruite après
    $im = create_badge("toto", "toto", $cont, $bright, 0, 0, 0, 0, 0, $font_num);
    $im_x = imagesx($im);
    $im_y = imagesy($im);
    imagedestroy($im);
    
    $dest = imagecreatetruecolor(2480, 3508);
    //$dest = imagecreatetruecolor($im_x * $num_cols + $ecart_x * $num_cols, $im_y * $num_rows + $ecart_y * $num_rows);
    //On crée le fond blanc de la planche
    $bg = imagecolorallocate($dest, 255, 255, 255);
    imagefill ($dest, 0, 0, $bg);

    $largeur_destination = imagesx($dest);
    $hauteur_destination = imagesy($dest);
    $destination_x = 0;
    $destination_y = 0;
    $k = $begin;
    
    // On met le badge (source) dans l'image de destination (la planche)
    for ($i = 0; $i < $num_rows; $i++)
        {
            for ($j = 0; $j < $num_cols; $j++)
                {
                    // On charge d'abord les images
                    if ($k < $end)
                        {
                            if (strlen($tab_grp[$k]) != 0)
                                {
                                    $source = create_badge($tab_grp[$k],$tab_name[$k], $cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);
                                }
                            else
                                {
                                    if($box == 0)
                                        {
                                            $source = create_badge("", "", $cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);
                                        }
                                    else if ($box == 1)
                                        {
                                            $source = create_badge_case($cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);
                                        }
                                }
                        }
                    else
                        {
                            if($box == 0)
                                {
                                    $source = create_badge("", "", $cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);
                                }
                            else if ($box == 1)
                                {
                                    $source = create_badge_case($cont, $bright, $red, $green, $blue, $gray, $conso, $font_num);
                                }
                        }
                    $offset_x = $destination_x + $j * ($im_x + $ecart_x) + $ecart_x/2;
                    $offset_y = $destination_y + $i * ($im_y + $ecart_y) + $ecart_y/2;
                    imagecopymerge($dest, $source, $offset_x, $offset_y, 0, 0, $im_x, $im_y, 100);
                    $k++;
                }
        }
    $watermark_color = imagecolorallocate($dest, 220, 220, 220);
    $dest = add_text_no_return($dest, "Scripts et planches crees par Gillex d'Ad'Hoc", imagesy($dest) - 150, $watermark_color, $font_num);

    return $dest;
}

/**
 * @function resize
 * @brief this scripts resizes the input file in the size wanted to create a badge.
 * @param[in] input the input picture's name we want to resize
 * @param[in] output the output picture's name.
 */
function resize($input, $output)
{
    $source = imagecreatefrompng($input); // La photo est la source
    $destination = imagecreatetruecolor(450, 750); // On crée la miniature vide
    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);
    // On crée la miniature
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
    // On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
    imagepng($destination, $output);
}

/**
 * @function resize_no_file
 * @param[in] input the input picture's name we want to resize
 * @brief this scripts resizes the input file in the size wanted to create a badge.
 */
function resize_no_file($input)
{
    $source = imagecreatefrompng($input); // La photo est la source
    $destination = imagecreatetruecolor(450, 750); // On crée la miniature vide
    // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
    $largeur_source = imagesx($source);
    $hauteur_source = imagesy($source);
    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);
    // On crée la miniature
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
    //on retourne l'image créée
    return ($destination);
}


/**
 * @function centrage_texte
 * @param[in] str The string we want to print
 * @param[in] font The font used to print the string
 * @param[in] ing_width The width of the picture where we'll print the string
 * @brief This function checks where to start writing the text.
 */
function centrage_texte($str,$font, $img_width, $font_num)
{
    // Je calcule le nombre de caractères dans la chaine
    $str_size = strlen($str);
    // Je calcule la taille d'un caractère par rapport à la taille de la police
    //$font_num2 = imageloadfont($font);
    $free_space = $img_width - ($str_size * imagefontwidth($font_num));
    // Je recherche l'emplacement où débutera ma chaine de caractères
    $begin_str = $free_space/2;
    // La chaine commencera ... à cet emplacement
    return $begin_str;
}



/**
 * @function create_badge
 * @param[in] group the group's personne
 * @param[in] name the name's personne (obvious, isn't it ?)
 * @param [in] cont the contrast value
 * @param [in] bright the brightness value
 * @param [in] red the red componant value
 * @param [in] green the green componant value
 * @param [in] blue the blue componant value
 * @param [in] gray a boolean specifying if the badge has or not to be in gray scale
 * @param [in] conso the amount of drinks allowed to each musician
 * @brief This script creates one unique badge. It is called by gen_planch
 */

function create_badge($group, $name, $cont, $bright, $red, $green, $blue, $gray, $conso, $font_num)
{
    // Définition de la variable d'environnement pour GD
    putenv('GDFONTPATH=' . realpath('.'));
    // Création de l'image
    global $image;
    $im = imagecreatetruecolor(imagesx($image), imagesy($image));
    // Création de quelques couleurs
    $color = imagecolorallocate($im, $red, $green, $blue);
    $white = imagecolorallocate($im, 255, 255, 255);
    imagecopy($im, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    // Remplacez le chemin par votre propre chemin de police
    $tab_group = explode(' ', $group);
    $count_group = count($tab_group);
    $tab_name = explode(' ', $name);
    $count_name = count($tab_name);
    $im = apply_filter($im, $cont, $bright, $gray);
    $im = add_case($im, 0, $count_group, $count_name);
    // Ajout du texte
    $im = add_text($im, $group, 0, $color, $font_num);
    $im = add_text($im, $name, imagesy($im) - 50 - 40*$count_name, $color, $font_num);
    $im = add_conso($im, $conso, $white);
    $im = add_date_event($im, $color, $font_num);
    return $im;
}

/**
 * @function create_badge_case
 * @param [in] cont the contrast value
 * @param [in] bright the brightness value
 * @param [in] red the red componant value
 * @param [in] green the green componant value
 * @param [in] blue the blue componant value
 * @param [in] gray a boolean specifying if the badge has or not to be in gray scale
 * @param [in] conso the amount of drinks allowed to each musician
 * @brief This function creates one unique badge with a white space. It is called by gen_planch
 */
function create_badge_case($cont, $bright, $red, $green, $blue, $gray, $conso, $font_num)
{
    // Création de l'image
    global $image;
    // Définition de la variable d'environnement pour GD
    $im = imagecreatetruecolor(imagesx($image), imagesy($image));
    $im_white = imagecreate(350, 100);
    $color = imagecolorallocate($im, $red, $green, $blue);
    $white_deux = imagecolorallocate($im_white, 255, 255, 255);
    imagecopy($im, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    $im = apply_filter($im, $cont, $bright, $gray);
    $im = add_conso($im, $conso, $color);
    $im = add_date_event($im, $color, $font_num);
    imagecopy($im, $im_white, imagesx($im)/2 - imagesx($im_white)/2, 40, 0, 0, imagesx($im_white), imagesy($im_white));
    imagecopy($im, $im_white, imagesx($im)/2 - imagesx($im_white)/2, imagesy($im) - (imagesy($im_white) + 40), 0, 0, imagesx($im_white), imagesy($im_white));
    return $im;
}

/**
 * @function apply_filter
 * @param [in] im the badge
 * @param [in] cont the contrast value
 * @param [in] bright the brightness value
 * @param [in] gray a boolean specifying if the badge has or not to be in gray scale
 * @brief this function applies filters with the values specified in the interface
 */
function apply_filter($im, $cont, $bright, $gray)
{
    imagefilter($im, IMG_FILTER_CONTRAST, $cont);
    imagefilter($im, IMG_FILTER_BRIGHTNESS, $bright);
    if ($gray == 1)
        {
            imagefilter($im, IMG_FILTER_GRAYSCALE);
        }
    return $im;
}

/**
 * @function add_conso
 * @param [in] im the badge
 * @param [in] conso the amount of drinks allowed
 * @param [in] color the color of the dot(s)
 * @brief this functions add several dots to the badge, according to the number of drinks allowed for the musicians
 */
function add_conso($im, $conso, $color)
{
    for ($i = 0; $i < $conso; $i++)
        {
            imagefilledellipse($im, imagesx($im) - 28, imagesy($im) - ($conso - $i) * 50, 40, 40, $color);
        }
    return $im;
}


/**
 * @function add_date_event
 * @param [in] im the badge
 * @param [in] color the color of the text
 * @param [in] font_num the font used 
 * @brief This function adds the name and the date of the event (both are global variables)
 */
function add_date_event($im, $color, $font_num)
{
    global $event;
    global $date;
    $im = add_text($im, $event, imagesy($im)/2 - 75,$color, $font_num);
    $tab_txt = explode(' ', $event);
    $count = count($tab_txt);
    $im = add_text($im, $date, imagesy($im)/2 - 75 + (50 * $count),$color, $font_num);
    return $im;
}

/**
 * @function add_text
 * @param[in] im the image we adds the text to
 * @param[in] text the text to add
 * @param[in] begin_y the first line position
 * @param[in] color the color of the text
 * @param[in] font_num the font used
 * @brief This function adds the specified text at the specified y location, center in the pic.
 */
function add_text($im, $text, $begin_y, $color, $font_num)
{
    $font_verdana = 'verdana.gdf';
    $tab_txt = explode(' ', $text);
    $count = count($tab_txt);
    $i = 0;
    while ($i < $count)
        {
            $begin_y = (($count == 1) ? ($begin_y - 15 <= 9 ? 10 : $begin_y) : $begin_y);
            imagestring($im, $font_num, centrage_texte($tab_txt[$i], $font_verdana, imagesx($im), $font_num), $begin_y + $i * 50, $tab_txt[$i], $color);
            $i++;
        }
    return $im;
}

function add_case($im, $begin_y, $nb_l, $nb_g)
{
    // Définition de la variable d'environnement pour GD
  $case1 = imagecreate(400, 10 + 50*$nb_l);
  $case2 = imagecreate(400, 10 + 50*$nb_g);
  $color = imagecolorallocate($case1, 0, 0, 0);
  $color2 = imagecolorallocate($case2, 0, 0, 0);
  imagecopy($im, $case1, 25, $begin_y + 10, 0, 0, imagesx($case1), imagesy($case1));
  imagecopy($im, $case2, 25, imagesy($im) - 40 - (40 * $nb_g), 0, 0, imagesx($case2), imagesy($case2));
  return $im;
  
}

function add_text_no_return($im, $text, $begin_y, $color, $font_num)
{
    $font_verdana = 'verdana.gdf';
     $i = 0;
     imagestring($im, $font_num, centrage_texte($text, $font_verdana, imagesx($im), $font_num), $begin_y + $i * 50, $text, $color);
     $i++;
     return $im;
}