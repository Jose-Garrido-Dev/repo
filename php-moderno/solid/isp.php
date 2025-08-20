<?php
// el principio de interface segregation principle 

interface CrudBaseInterface{
    public function add();
    public function get();
}

interface UpdateCrudInterface{
    public function update();
}

interface DeleteCrudInterface{
    public function delete();
}

interface GeneralCrud extends CrudBaseInterface, UpdateCrudInterface, DeleteCrudInterface {
}


class UserCrud implements GeneralCrud {
    public function add() {
        echo "Se agrega";
    }
    public function get() {
        echo "Se obtiene";
    }
    public function update() {
        echo "Se modifica";
    }
    public function delete() {
        echo "Se elimina";
    }
}

class SaleCrud implements CrudBaseInterface, DeleteCrudInterface {
    public function add() {
        echo "Se agrega";
    }
    public function get() {
        echo "Se obtiene";
    }
    public function delete() {
        echo "Se elimina";
    }
}

function general(GeneralCrud $crud){
    $crud->add();
    $crud->update();
    $crud->delete();
    $crud->get();
}

function get(CrudBaseInterface $crud){
    $crud->get();
}


function update(UpdateCrudInterface $crud){
    $crud->update();
}

//update(new SaleCrud());

// general(new SaleCrud());
general(new UserCrud());
// general(new SaleCrud()); // Esto causaría un error porque SaleCrud no implementa GeneralCrud
