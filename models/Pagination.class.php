<?php

/**
 * classe générique de gestion d'une pagination
 */
class Pagination
{
    /**
     * Page selectionnée
     * @param int
     */
    protected $_selected_page = 0;

    /**
     * Page courante (pour boucles internes uniquement)
     * @param int
     */
    protected $_current_page = 0;

    /**
     * Nombre total d'élements
     * @param int
     */
    protected $_nb_items = null;

    /**
     * Nombre d'éléments par page
     * @param int
     */
    protected $_nb_items_per_page = 20;

    /**
     * Nombre de liens
     * @param int
     */
    protected $_nb_links = 5;

    /**
     * Nombre de pages
     * @param int
     */
    protected $_nb_pages = 0;

    /**
     *
     */
    public function __construct($nb_items, $nb_items_per_page, $selected_page)
    {
        $this->_nb_items = (int) $nb_items;
        $this->_nb_items_per_page = (int) $nb_items_per_page;
        $this->_nb_pages = ceil($this->_nb_items / $this->_nb_items_per_page);
        $this->_selected_page = (int) $selected_page;
    }

    /**
     * @return int
     */
    public function getNbItems()
    {
        return (int) $this->_nb_items;
    }

    /**
     * @param int $nb
     */
    public function setNbItems($nb)
    {
        $this->_nb_items = (int) $nb;
    }

    /**
     * @return int
     */
    public function getNbItemsPerPage()
    {
        return (int) $this->_nb_items_per_page;
    }

    /**
     * @param int $nb
     */
    public function setNbItemsPerPage($nb)
    {
        $this->_nb_items_per_page = (int) $nb;
    }

    /**
     * @return int
     */
    public function getSelectedPage()
    {
        return (int) $this->_selected_page;
    }

    /**
     * @return int
     */
    public function getSelectedPageNum()
    {
        return (int) ($this->getSelectedPage() + 1);
    }

    /**
     * @param int
     */
    public function setSelectedPage($nb)
    {
        if(($nb >= $this->getFirstPage()) && ($nb <= $this->getLastPage())) {
            $this->_selected_page = (int) $nb;
        }
    }

    /**
     * @return int
     */
    public function getNbLinks()
    {
        return (int) $this->_nb_links;
    }

    /**
     * @param int $nb
     */
    public function setNbLinks($nb)
    {
        $this->_nb_links = (int) $nb;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return (int) $this->_current_page;
    }

    /**
     * @return int
     */
    public function getCurrentPageNum()
    {
        return (int) ($this->getCurrentPage() + 1);
    }

    /**
     * @param int
     */
    public function setCurrentPage($nb)
    {
        if(($nb >= $this->getFirstPage()) && ($nb <= $this->getLastPage())) {
            $this->_current_page = (int) $nb;
        }
    }

    /**
     * @return int
     */
    public function getNbPages()
    {
        return $this->_nb_pages;
    }

    /**
     * @return int ou bool
     */
    public function getNextPage()
    {
        return (int) ($this->getCurrentPage() + 1);
    }

    /**
     * @return int ou false
     */
    public function getPrevPage()
    {
        return (int) ($this->getCurrentPage() - 1);
    }

    /**
     * @return int
     */
    public function getFirstPage()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getFirstPageNum()
    {
        return (int) ($this->getFirstPage() + 1);
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        if($this->hasPagination()) {
            return floor(($this->getNbItems() - 1) / $this->getNbItemsPerPage());
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getLastPageNum()
    {
        return (int) ($this->getLastPage() + 1);
    }

    /**
     * @return bool
     */
    public function hasNextPage()
    {
        return ($this->hasPagination() && ($this->getCurrentPage() < $this->getLastPage()));
    }

    /**
     * @return bool
     */
    public function hasPrevPage()
    {
        return ($this->hasPagination() && ($this->getCurrentPage() > $this->getFirstPage()));
    }

    /**
     * @return bool
     */
    public function hasPagination()
    {
        return (bool) ($this->getNbItems() > $this->getNbItemsPerPage());
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return (bool) ($this->getNbItems() > 0);
    }

    /**
     * classe css a utiliser
     *
     * @return string
     */
    public function getClass()
    {
        if($this->getSelectedPage() == $this->getCurrentPage()) {
            return 'selectedpage';
        }
        return 'unselectedpage';
    }
}