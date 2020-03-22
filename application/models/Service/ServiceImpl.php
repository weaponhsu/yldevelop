<?php

namespace models\Service;

interface ServiceImpl
{
    public function create();

    public function update();

    public function delete();
/*
    public function getResult();

    public function batchDelete();

    public function batchInsert();*/

    public function getList();

    /*public function getOne();*/

}