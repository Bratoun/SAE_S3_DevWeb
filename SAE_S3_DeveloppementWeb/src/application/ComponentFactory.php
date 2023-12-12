<?php
/*
 * yasmf - Yet Another Simple MVC Framework (Pour PHP)
 *     Droits d'auteur (C) 2023   Franck SILVESTRE
 *
 *     Ce programme est un logiciel libre : vous pouvez le redistribuer et/ou le modifier
 *     selon les termes de la Licence publique générale Affero GNU telle que publiée
 *     par la Free Software Foundation, soit la version 3 de la Licence, soit
 *     (à votre choix) toute version ultérieure.
 *
 *     Ce programme est distribué dans l'espoir qu'il sera utile,
 *     mais SANS AUCUNE GARANTIE, même sans la garantie implicite de
 *     COMMERCIALISATION ou D'ADAPTATION À UN USAGE PARTICULIER. Voir la
 *     Licence publique générale Affero GNU pour plus de détails.
 *
 *     Vous devriez avoir reçu une copie de la Licence publique générale Affero GNU
 *     en même temps que ce programme. Sinon, consultez <https://www.gnu.org/licenses/>.
 */

namespace src\application;

/**
 * Interface décrivant la fabrique capable de fournir à l'application ses composants
 */
interface FabriqueComposants
{
    
    /**
     * @param string $controller_name le nom du contrôleur à instancier
     * @return mixed le contrôleur
     * @throws NoControllerAvailableForNameException lorsque le contrôleur n'est pas trouvé
     */
    public function buildControllerByName(string $controller_name): mixed;
    
    /**
     * @param string $service_name le nom du service
     * @return mixed le service créé
     * @throws NoServiceAvailableForNameException lorsque le service n'est pas trouvé
     */
    public function buildServiceByName(string $service_name): mixed;
}