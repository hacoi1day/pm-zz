<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    private $department;

    public function __construct(Department $department) {
        $this->department = $department;
    }

    public function paginate()
    {
        $paginate = $this->department->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->manager;
            return $item;
        });
        return $paginate;
    }

    public function create($params)
    {
        $department = $this->department->create($params);
        return $department;
    }

    public function get($id)
    {
        $department = $this->department->findOrFail($id);
        return $department;
    }

    public function update($params, $id)
    {
        $department = $this->get($id);
        $department->update($params);
        return $department;
    }

    public function delete($id)
    {
        $department = $this->get($id);
        $department->delete();
        return true;
    }

    public function dropdown()
    {
        $departments = $this->department->all();
        $result = [];
        foreach ($departments as $department) {
            array_push($result, [
                'id' => $department->id,
                'name' => $department->name,
            ]);
        }
        return $result;
    }
}
