<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helpers
{
    /**
     * Render pagination
     *
     * $return string
     */
    public static function paginate($path, $query, $total, $per_page)
    {
        if ($total > $per_page) {
            parse_str($query, $query_arr);
            if (!empty($query_arr['page'])) {
                $page = $query_arr['page'];
                unset($query_arr['page']);
            } else {
                $page = 1;
            }
            $query_string = http_build_query($query_arr);
            $total_pages = intval($total / $per_page);
            $min_page = $page < 3 ? 1 : $page - 3;
            $max_page = $page == $total_pages ? $total_pages : $page + 3;
            $to_display = range($min_page, $max_page);
            $pages = collect($to_display);
            $pages->each(
                function ($item, $key) use ($to_display) {
                    if (in_array($item, $to_display)) {
                        return $item;
                    }
                }
            );
            $prev_number = $page != 1 ? $page - 1 : 0;
            $next_number = $page != $total_pages ? $page + 1 : 0;
            $url = $path."?".$query_string."&page=";
            return view('pagination', compact('prev_number', 'next_number', 'page', 'pages', 'path', 'url'));
        }
    }
}
