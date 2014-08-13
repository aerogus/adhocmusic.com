
#script de copie massive de documents vers des clés usb
#Bon, je devrais mettre un shebang, mais... Je sais pas quel shell j'utilise, et /bin/sh marche pas des masses bien...

#on parcourt la liste des supports branchés (virer toute autre clé USB)
for fic in `ls -1 /media/gilles`
do
    #On copie les documents sur les clés (-p pour le cas où on se trompe de clé, pour copier les fichiers seulement si mise à jour)
    cp -p /home/gilles/Documents/clé/* /media/gilles/$fic
    #On affiche qu'on a finit avec une clé
    echo "clé $fic done"
    #On démonte la clé pour l'étape suivante
    sudo umount /media/gilles/$fic
done

#on parcourt une liste alphabétique pour pouvoir renommer les /dev/sdX
for n in $(echo {b..f})
do
    #on affiche la clé sur laquelle on travaille
    echo /dev/sd$n
    #on la renomme (marche seulement pour les clés en VFAT)
    sudo mlabel -i /dev/sd${n}1 ::AdHoc
done