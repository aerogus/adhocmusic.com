<?php

declare(strict_types=1);

namespace Adhoc\Model;

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
    protected int $selected_page = 0;

    /**
     * Page courante (pour boucles internes uniquement)
     *
     * @var int
     */
    protected int $current_page = 0;

    /**
     * Nombre total d'élements
     *
     * @var int
     */
    protected int $nb_items = 0;

    /**
     * Nombre d'éléments par page
     *
     * @var int
     */
    protected int $nb_items_per_page = 20;

    /**
     * Nombre de liens
     *
     * @var int
     */
    protected int $nb_links = 5;

    /**
     * Nombre de pages
     *
     * @var int
     */
    protected int $nb_pages = 0;

    /**
     *
     */
    public function __construct(int $nb_items = 0, int $nb_items_per_page = 50, int $selected_page = 0)
    {
        $this->nb_items = $nb_items;
        $this->nb_items_per_page = $nb_items_per_page;
        $this->nb_pages = intval($this->nb_items / $this->nb_items_per_page) + 1;
        $this->selected_page = $selected_page;
    }

    /**
     * @return int
     */
    public function getNbItems(): int
    {
        return $this->nb_items;
    }

    /**
     * @param int $nb nb
     */
    public function setNbItems(int $nb): void
    {
        $this->nb_items = $nb;
    }

    /**
     * @return int
     */
    public function getNbItemsPerPage(): int
    {
        return $this->nb_items_per_page;
    }

    /**
     * @param int $nb nb
     */
    public function setNbItemsPerPage(int $nb): void
    {
        $this->nb_items_per_page = $nb;
    }

    /**
     * @return int
     */
    public function getSelectedPage(): int
    {
        return $this->selected_page;
    }

    /**
     * @return int
     */
    public function getSelectedPageNum(): int
    {
        return ($this->getSelectedPage() + 1);
    }

    /**
     * @param int $nb nb
     *
     * @return void
     */
    public function setSelectedPage(int $nb): void
    {
        if (($nb >= $this->getFirstPage()) && ($nb <= $this->getLastPage())) {
            $this->selected_page = $nb;
        }
    }

    /**
     * @return int
     */
    public function getNbLinks(): int
    {
        return $this->nb_links;
    }

    /**
     * @param int $nb nb
     *
     * @return void
     */
    public function setNbLinks(int $nb): void
    {
        $this->nb_links = $nb;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->current_page;
    }

    /**
     * @return int
     */
    public function getCurrentPageNum(): int
    {
        return ($this->getCurrentPage() + 1);
    }

    /**
     * @param int $pageNumber pageNumber
     *
     * @return void
     */
    public function setCurrentPage(int $pageNumber): void
    {
        if (($pageNumber >= $this->getFirstPage()) && ($pageNumber <= $this->getLastPage())) {
            $this->current_page = $pageNumber;
        }
    }

    /**
     * @return int
     */
    public function getNbPages(): int
    {
        return $this->nb_pages;
    }

    /**
     * @return ?int
     */
    public function getNextPage(): ?int
    {
        if ($this->hasNextPage()) {
            return ($this->getCurrentPage() + 1);
        }
        return null;
    }

    /**
     * @return ?int
     */
    public function getPrevPage(): ?int
    {
        if ($this->hasPrevPage()) {
            return ($this->getCurrentPage() - 1);
        }
        return null;
    }

    /**
     * @return int
     */
    public function getFirstPage(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getFirstPageNum(): int
    {
        return ($this->getFirstPage() + 1);
    }

    /**
     * Retourne l'index de la dernière page
     *
     * @return int
     */
    public function getLastPage(): int
    {
        if ($this->hasPagination()) {
            return intval(($this->getNbItems() - 1) / $this->getNbItemsPerPage());
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getLastPageNum(): int
    {
        return ($this->getLastPage() + 1);
    }

    /**
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return ($this->hasPagination() && ($this->getCurrentPage() < $this->getLastPage()));
    }

    /**
     * @return bool
     */
    public function hasPrevPage(): bool
    {
        return ($this->hasPagination() && ($this->getCurrentPage() > $this->getFirstPage()));
    }

    /**
     * @return bool
     */
    public function hasPagination(): bool
    {
        return ($this->getNbItems() > $this->getNbItemsPerPage());
    }

    /**
     * @return bool
     */
    public function hasItems(): bool
    {
        return ($this->getNbItems() > 0);
    }

    /**
     * Classe css a utiliser
     *
     * @return string
     */
    public function getClass(): string
    {
        return ($this->getSelectedPage() === $this->getCurrentPage()) ? 'selected' : '';
    }
}
