<?php declare(strict_types=1);

/**
 * Gestion d'une pagination
 *
 * @package AdHoc
 * @author  Guillaume Seznec <guillaume@seznec.fr>
 */
class Pagination
{
    /**
     * Page selectionnée
     *
     * @var int
     */
    protected $_selected_page = 0;

    /**
     * Page courante (pour boucles internes uniquement)
     *
     * @var int
     */
    protected $_current_page = 0;

    /**
     * Nombre total d'élements
     *
     * @var int
     */
    protected $_nb_items = 0;

    /**
     * Nombre d'éléments par page
     *
     * @var int
     */
    protected $_nb_items_per_page = 20;

    /**
     * Nombre de liens
     *
     * @var int
     */
    protected $_nb_links = 5;

    /**
     * Nombre de pages
     *
     * @var int
     */
    protected $_nb_pages = 0;

    /**
     *
     */
    function __construct(int $nb_items, int $nb_items_per_page, int $selected_page)
    {
        $this->_nb_items = (int) $nb_items;
        $this->_nb_items_per_page = (int) $nb_items_per_page;
        $this->_nb_pages = intval($this->_nb_items / $this->_nb_items_per_page) + 1;
        $this->_selected_page = (int) $selected_page;
    }

    /**
     * @return int
     */
    function getNbItems(): int
    {
        return $this->_nb_items;
    }

    /**
     * @param int $nb
     */
    function setNbItems(int $nb)
    {
        $this->_nb_items = $nb;
    }

    /**
     * @return int
     */
    function getNbItemsPerPage(): int
    {
        return $this->_nb_items_per_page;
    }

    /**
     * @param int $nb nb
     */
    function setNbItemsPerPage(int $nb)
    {
        $this->_nb_items_per_page = $nb;
    }

    /**
     * @return int
     */
    function getSelectedPage(): int
    {
        return $this->_selected_page;
    }

    /**
     * @return int
     */
    function getSelectedPageNum(): int
    {
        return ($this->getSelectedPage() + 1);
    }

    /**
     * @param int
     */
    function setSelectedPage(int $nb)
    {
        if (($nb >= $this->getFirstPage()) && ($nb <= $this->getLastPage())) {
            $this->_selected_page = $nb;
        }
    }

    /**
     * @return int
     */
    function getNbLinks(): int
    {
        return $this->_nb_links;
    }

    /**
     * @param int $nb
     */
    function setNbLinks(int $nb)
    {
        $this->_nb_links = $nb;
    }

    /**
     * @return int
     */
    function getCurrentPage(): int
    {
        return $this->_current_page;
    }

    /**
     * @return int
     */
    function getCurrentPageNum(): int
    {
        return ($this->getCurrentPage() + 1);
    }

    /**
     * @param int $pageNumber
     */
    function setCurrentPage(int $pageNumber)
    {
        if (($pageNumber >= $this->getFirstPage()) && ($pageNumber <= $this->getLastPage())) {
            $this->_current_page = $pageNumber;
        }
    }

    /**
     * @return int
     */
    function getNbPages(): int
    {
        return $this->_nb_pages;
    }

    /**
     * @return int|null
     */
    function getNextPage(): ?int
    {
        if ($this->hasNextPage()) {
            return ($this->getCurrentPage() + 1);
        }
        return null;
    }

    /**
     * @return int|null
     */
    function getPrevPage(): ?int
    {
        if ($this->hasPrevPage()) {
            return ($this->getCurrentPage() - 1);
        }
        return null;
    }

    /**
     * @return int
     */
    function getFirstPage(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    function getFirstPageNum(): int
    {
        return ($this->getFirstPage() + 1);
    }

    /**
     * Retourne l'index de la dernière page
     *
     * @return int
     */
    function getLastPage(): int
    {
        if ($this->hasPagination()) {
            return intval(($this->getNbItems() - 1) / $this->getNbItemsPerPage());
        }
        return 0;
    }

    /**
     * @return int
     */
    function getLastPageNum(): int
    {
        return ($this->getLastPage() + 1);
    }

    /**
     * @return bool
     */
    function hasNextPage(): bool
    {
        return ($this->hasPagination() && ($this->getCurrentPage() < $this->getLastPage()));
    }

    /**
     * @return bool
     */
    function hasPrevPage(): bool
    {
        return ($this->hasPagination() && ($this->getCurrentPage() > $this->getFirstPage()));
    }

    /**
     * @return bool
     */
    function hasPagination(): bool
    {
        return ($this->getNbItems() > $this->getNbItemsPerPage());
    }

    /**
     * @return bool
     */
    function hasItems(): bool
    {
        return ($this->getNbItems() > 0);
    }

    /**
     * Classe css a utiliser
     *
     * @return string
     */
    function getClass(): string
    {
        return ($this->getSelectedPage() === $this->getCurrentPage()) ? 'selected' : '';
    }
}
