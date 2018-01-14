<?php

class Pagination
{
    private $_DOMAIN = 'http://localhost/Covoiturage/';
    /*
     * Configuration
     * @var array
     */
    private $config = [
        'total' => 0,   // totale de message
        'limit' => 0,   // les messages sur page
        'full' => true, // true si toutes les pages affichent, false si non
        'querystring' => 'page' // GET id reçoit page
    ];

    /*
     * Initialize
     * @param array $config
     */
    public function __construct($config = []) {
        // vérifier si total et limit > 0
        if (isset($config['limit']) && $config['limit'] < 0 || isset($config['total']) && $config['total'] < 0) {
            die('limit et total doivent être supérieur à 0');
        }
        // vérifier si querystring existe
        if (!isset($config['querystring'])) {
            // Sinon mettre page à défault
            $config['querystring'] = 'page';
        }
        $this->config = $config;
    }

    /*
     * setter l'address du host
     */
    public function setDomain($url) {
        $this->_DOMAIN = $url;
    }

    /*
     * Accesseur le total de page
     * @return int
     */
    public function getTotalPage() {
        return ceil($this->config['total'] / $this->config['limit']);
    }

    /*
     * Accesseur la page courante
     * @return int
     */
    public function getCurrentPage() {
        // vérifier s'il existe Querystring et >= 1
        if(isset($_GET[$this->config['querystring']]) && (int)$_GET[$this->config['querystring']] >= 1){
            //Nếu có kiểm tra tiếp xem nó có lớn hơn tổn số trang không.
            if((int)$_GET[$this->config['querystring']] > $this->gettotalPage())
            {
                //nếu lớn hơn thì trả về tổng số page
                return (int)$this->gettotalPage();
            } else{
                //còn không thì trả về số trang
                return (int)$_GET[$this->config['querystring']];
            }
        } else {
            // S'il n'y a pas de querystring
            return 1;
        }
    }

    /*
     * Accesseur la page précédente
     * @return string
     */
    public function getPrevPage() {
        // Si la page courante est égale à 1, désactiver la page précédente
        if ($this->getCurrentPage() === 1) {
            return '
            <li class="page-item disabled">
                <a tabindex="-1" class="page-link" href="#">Previous</a>
            </li>';
        } else if (($this->getCurrentPage() - 1) === 1) {
            return '
            <li class="page-item">
                <a tabindex="-1" class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite">Previous</a>
            </li>';
        } else {
            // Si non, retourne code de HTML
            return '
            <li class="page-item">
                <a tabindex="-1" class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite/page-'.($this->getCurrentPage() - 1).'">Previous</a>
            </li>';
        }
    }

    /*
     * Accesseur la page suivante
     * @return string
     */
    public function getNextPage() {
        // Si la page courante est supérieur ou égale à le total de page,
        if ($this->getCurrentPage() >= $this->getTotalPage()) {
            return '
            <li class="page-item disabled">
                <a class="page-link" href="#">Next</a>
            </li>
            ';
        } else {
            return '
            <li class="page-item">
                <a class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite/page-'.($this->getCurrentPage() + 1).'">Next</a>
            </li>
            ';
        }
    }

    /*
     * Afficher code HTML de pagination
     * @return string
     */
    public function getPagination() {
        $html = '';
        // Vérifier que l'utilisateur veut full page
        if (isset($this->config['full']) && $this->config['full'] === false) {
            // s'il veut pas
            for ($i = (($this->getCurrentPage() - 2) > 0 ? ($this->getCurrentPage() - 2) : 1);
                 $i <= (($this->getCurrentPage() + 2) > $this->getTotalPage() ? $this->getTotalPage() : ($this->getCurrentPage() + 2));
                 $i++) {
                if ($i === $this->getCurrentPage()) {
                    $html .= '
                    <li class="page-item active">
                        <span class="page-link">'.$i.'<span class="sr-only">(current)</span></span>
                    </li>
                    ';
                } else {
                    if ($i === 1) {
                        $html .= '
                        <li class="page-item">
                            <a class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite">'.$i.'</a>
                        </li>
                        ';
                    } else {
                        $html .= '
                        <li class="page-item">
                            <a class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite/page-'.$i.'">'.$i.'</a>
                        </li>
                        ';
                    }
                }
            }
        } else {
            // S'il veut afficher full page
            for ($i = 1; $i <= $this->getTotalPage(); $i++) {
                if ($i === $this->getCurrentPage()) {
                    $html .= '
                    <li class="page-item active"><span class="page-link">'.$i.'<span class="sr-only">(current)</span></span></li>
                    ';
                } else {
                    if ($i === 1) {
                        $html .= '
                        <li class="page-item">
                            <a class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite">'.$i.'</a>
                        </li>
                        ';
                    } else {
                        $html .= '
                        <li class="page-item">
                            <a class="page-link" href="'.$this->_DOMAIN.'mes-messages/boite/page-'.$i.'">'.$i.'</a>
                        </li>
                        ';
                    }
                }
            }
        }
        return '
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">'.
                $this->getPrevPage().$html.$this->getNextPage().'
            </ul>
        </nav>
        ';
    }
}