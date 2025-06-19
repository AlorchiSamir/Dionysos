<?php

namespace App\Repositories;

interface RepositoryInterface{

    public function save($datas);
    public function getById($id);

}