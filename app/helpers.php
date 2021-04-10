<?php

function estimateReadingTime($text)
{
    return ceil(str_word_count($text) / 200);
}

function timeToAgo($timestamp){
    $diff = time() - $timestamp;
    if ($diff < 60)
        return "همین الآن";
    if ($diff < 120)
        return "یک دقیقه پیش";
    if ($diff < 60 * 60)
        return floor($diff/60) . " دقیقه پیش";
    if ($diff < 2 * 60 * 60)
        return "یک ساعت پیش";
    if ($diff < 24 * 60 * 60)
        return floor($diff/(60*60)) . " ساعت پیش";
    if ($diff < 2 * 24 * 60 * 60)
        return "دیروز";
    if ($diff < 7 * 24 * 60 * 60)
        return floor($diff/(60*60*24)) . " روز قبل";
    if ($diff < 2 * 7 * 24 * 60 * 60)
        return "یک هفته پیش";
    if ($diff < 30 * 24 * 60 * 60)
        return floor($diff/(60*60*24*7)) . " هفته پیش";
    if ($diff < 2 * 30 * 24 * 60 * 60)
        return "یک ماه پیش";
    if ($diff < 365 * 24 * 60 * 60)
        return floor($diff/(30 * 24 * 60 * 60)) . " ماه پیش";
    if ($diff < 2 * 365 * 24 * 60 * 60)
        return "یک سال پیش";
    return floor($diff/(365 * 24 * 60 * 60)) . " سال پیش";
}

function getPaginationButtons($total_items, $per_page, $current_page)
{
    $pages_count = ceil($total_items / $per_page);
    $pages = [];
    if ($pages_count > 1 && $current_page != 1) {
        $pages[] = ['text' => 'prev', 'number' => ($current_page - 1)];
    }
    if ($pages_count <= 5) {
        for ($i = 1; $i <= $pages_count; ++$i) {
            $pages[] = ['text' => $i, 'number' => $i];
        }
    }
    else {
        $pages[] = ['text' => 1, 'number' => 1];
        if ($current_page > 5) {
            $pages[] = ['text' => '...'];
        } elseif ($current_page == 5) {
            $pages[] = ['text' => 2, 'number' => 2];
        }
        for ($i = $current_page - 2; $i <= $current_page + 2 && $i <= $pages_count; ++$i) {
            if ($i <= 1) {
                continue;
            }
            $pages[] = ['text' => $i, 'number' => $i];
        }
        if ($pages_count > $current_page + 2) {
            if ($current_page < $pages_count - 4) {
                $pages[] = ['text' => '...'];
            }
            elseif ($current_page == $pages_count - 4) {
                $pages[] = ['text' => $current_page + 3, 'number' => $current_page + 3];
            }
            $pages[] = ['text' => $pages_count, 'number' => $pages_count];
        }
    }
    if ($pages_count > 1 && $current_page != $pages_count) {
        $pages[] = ['text' => 'next', 'number' => ($current_page + 1)];
    }

    return $pages;
}

function renderPagination($total_items, $per_page, $current_page, $base_url)
{
    $pages = getPaginationButtons($total_items, $per_page, $current_page);
    $html = '';
    foreach ($pages as $page) {
        $page['text'] = str_replace(['prev', 'next'], ['&laquo;', '&raquo;'], $page['text']);
        if (in_array($page['text'], ['&laquo;', '...', '&raquo;'])) {
            $html .= '<li class="page-item">
              <a class="page-link" href="' . (isset($page['number']) ? $base_url . digitsToPersian($page['number']) : '#') . '">
                <span aria-hidden="true">' . $page['text'] . '</span>
              </a>
            </li>';
        } else {
            $html .= '<li class="page-item' . ($page['number'] == $current_page ? ' active' : '') . '"><a class="page-link" href="' . $base_url . $page['number'] . '">' . digitsToPersian($page['number']) . '</a></li>';
        }
    }

    return $html;
}

function digitsToPersian($str) {
    return str_replace(
        ['0','1','2','3','4','5','6','7','8','9'],
        ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'],
        $str
    );
}
