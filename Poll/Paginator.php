<?php namespace Poll;

use stdClass;

class Paginator {

    private $limit;
    private $query;
    private $page;
    private $total;
    private $queryParameters;

    protected $db;

    function __construct($query, $queryParameters)
    {
        $this->query = $query;
        $this->queryParameters = $queryParameters;

        $this->db = new Db;
        $this->db->query($this->query, $this->queryParameters);

        $this->total = $this->db->getNumRows();
    }

    public function getData( $limit = 10, $page = 1 ) {

        $this->limit   = $limit;
        $this->page    = $page;

        if ( $this->limit == 'all' ) {
            $query = $this->query;
        } else {
            $query = $this->query . " LIMIT " . ( ( $this->page - 1 ) * $this->limit ) . ", $this->limit";
        }

        $results = $this->db->query($query, $this->queryParameters);

        $result         = new stdClass();
        $result->page   = $this->page;
        $result->limit  = $this->limit;
        $result->total  = $this->total;
        $result->data   = $results;

        return $result;
    }

    public function createLinks( $links, $list_class )
    {
        if ($this->limit == 'all') {
            return '';
        }

        $last = ceil($this->total / $this->limit);

        $start = (($this->page - $links) > 0) ? $this->page - $links : 1;
        $end = (($this->page + $links) < $last) ? $this->page + $links : $last;

        $html = '<ul class="' . $list_class . '">';

        $class = ($this->page == 1) ? "disabled" : "";

        if ($start > 1) {
            $html .= '<li><a href="?limit=' . $this->limit . '&position=1">1</a></li>';
            $html .= '<li class="disabled"><span>...</span></li>';
        }

        for ($i = $start; $i <= $end; $i++) {
            $class = ($this->page == $i) ? "active" : "";
            $html .= '<li class="' . $class . '"><a href="?limit=' . $this->limit . '&position=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html .= '<li class="disabled"><span>...</span></li>';
            $html .= '<li><a href="?limit=' . $this->limit . '&position=' . $last . '">' . $last . '</a></li>';
        }

        $class = ($this->page == $last) ? "disabled" : "";

        if($end == 1 && $last == 1)
            return "";

        $html .= '</ul>';

        return $html;
    }

} 