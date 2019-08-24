<?php

/**
 * Gestion d'une pagination
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
    function __construct($nb_items, $nb_items_per_page, $selected_page)
    {
        $this->_nb_items = (int) $nb_items;
        $this->_nb_items_per_page = (int) $nb_items_per_page;
        $this->_nb_pages = ceil($this->_nb_items / $this->_nb_items_per_page);
        $this->_selected_page = (int) $selected_page;
    }

    /**
     * @return int
     */
    function getNbItems()
    {
        return (int) $this->_nb_items;
    }

    /**
     * @param int $nb
     */
    function setNbItems($nb)
    {
        $this->_nb_items = (int) $nb;
    }

    /**
     * @return int
     */
    function getNbItemsPerPage()
    {
        return (int) $this->_nb_items_per_page;
    }

    /**
     * @param int $nb
     */
    function setNbItemsPerPage($nb)
    {
        $this->_nb_items_per_page = (int) $nb;
    }

    /**
     * @return int
     */
    function getSelectedPage()
    {
        return (int) $this->_selected_page;
    }

    /**
     * @return int
     */
    function getSelectedPageNum()
    {
        return (int) ($this->getSelectedPage() + 1);
    }

    /**
     * @param int
     */
    function setSelectedPage($nb)
    {
        if (($nb >= $this->getFirstPage()) && ($nb <= $this->getLastPage())) {
            $this->_selected_page = (int) $nb;
        }
    }

    /**
     * @return int
     */
    function getNbLinks()
    {
        return (int) $this->_nb_links;
    }

    /**
     * @param int $nb
     */
    function setNbLinks($nb)
    {
        $this->_nb_links = (int) $nb;
    }

    /**
     * @return int
     */
    function getCurrentPage()
    {
        return (int) $this->_current_page;
    }

    /**
     * @return int
     */
    function getCurrentPageNum()
    {
        return (int) ($this->getCurrentPage() + 1);
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
     * @return int|bool
     */
    function getNextPage()
    {
        return (int) ($this->getCurrentPage() + 1);
    }

    /**
     * @return int|false
     */
    function getPrevPage()
    {
        return (int) ($this->getCurrentPage() - 1);
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
        return (int) ($this->getFirstPage() + 1);
    }

    /**
     * @return int
     */
    function getLastPage(): int
    {
        if ($this->hasPagination()) {
            return floor(($this->getNbItems() - 1) / $this->getNbItemsPerPage());
        }
        return 0;
    }

    /**
     * @return int
     */
    function getLastPageNum(): int
    {
        return (int) ($this->getLastPage() + 1);
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
        return (bool) ($this->getNbItems() > $this->getNbItemsPerPage());
    }

    /**
     * @return bool
     */
    function hasItems(): bool
    {
        return (bool) ($this->getNbItems() > 0);
    }

    /**
     * classe css a utiliser
     *
     * @return string
     */
    function getClass(): string
    {
        return ($this->getSelectedPage() === $this->getCurrentPage()) ? 'selected' : '';
    }
}
