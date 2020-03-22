<?php

namespace models\Cache;


interface SortedSetCacheImpl
{
    public function genSortedSet($key = '', $value = [], $expire = 86400);
    public function getSortedSet($key = '', $start_pos = 0, $end_pos = -1, $order='asc');
    public function modifyScoreByMember($key = '', $member = '');
    public function deleteSortedSetItem($key = '', $member = '');
    public function deleteSortedSet($key = '');
    public function getSortedSetLength($key = '');
    public function setExpire($key, $expire = 86400);

}