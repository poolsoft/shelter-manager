<?php

namespace App\Repositories\Interfaces;

interface IFostersRepository {

    public function all();
    public function allPaginated($perPage);
    public function addFromInput($request);
    //public function updateFromInput($id, $request);
    public function get($id);
    public function getByPerson($personId);
    public function delete($id);
}