<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class PaginateComponent extends Component
{
    public function paginate($page = 1, $count_page = 0, $key_search = "")
    {
        $MAX = (int)ceil($count_page/LIMIT);
        $param = "?";
        if (!empty($key_search)){
            $param .= "key_search={$key_search}&";
        }

        $open = '<div class="container mt-5">
                    <nav aria-label="Page navigation example">
                        <span class="pagination justify-content-center"> Showing '. ($page - 1) * LIMIT + 1 . ' to '. min($page * LIMIT + 1, $count_page). ' of '. $count_page.' records</span>
                        <ul class="pagination justify-content-center">';

        $last = "<li class='page-item'><a class='page-link'" . ($page > 1 ? "href='{$param}page=".(1)."'" : "" ) . "aria-label='Last'> << </a></li>";
        $prev = "<li class='page-item'><a class='page-link'" . ($page > 1 ? "href='{$param}page=".($page - 1)."'" : "" ) . "aria-label='Previous'> < </a></li>";
        $next = "<li class='page-item'><a class='page-link'" . ($page < $MAX ? "href='{$param}page=".($page + 1)."'" : "" ) . "aria-label='Next'> > </a></li>";
        $end = "<li class='page-item'><a class='page-link'" . ($page < $MAX ? "href='{$param}page=".($MAX)."'" : "" ) . "aria-label='End'> >> </a></li>";

        $close = "<ul></nav></div>";


        $paginate = "";

        if ($page > 1 && $MAX > 4){
            $paginate .= "<li class='page-item'><a class='page-link'>...</a></li>";
        }
        if ($MAX - $page <= 3){

            for($i = max($MAX - 3, 1); $i <= $MAX; ++$i){
                $active = $i == $page ? 'active' : '';
                $paginate .= "<li class='page-item {$active}'><a class='page-link' href='{$param}page={$i}'>{$i}</a></li>";
            }
        }else{
            for($i = $page; $i <=  $page + 3 && $i <= $MAX; ++$i){
                $active = $i == $page ? 'active' : '';
                $paginate .= "<li class='page-item {$active}'><a class='page-link' href='{$param}page={$i}'>{$i}</a></li>";
            }
        }

        if ($i - 1 < $MAX){
            $paginate .= "<li class='page-item'><a class='page-link'>...</a></li>";
        }

        return $count_page > LIMIT ? $open . $last . $prev . $paginate . $next . $end . $close : "";
    }
}
