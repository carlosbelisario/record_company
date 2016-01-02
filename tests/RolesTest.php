<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RolesTest extends TestCase
{
    /**
     * test list
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->call('GET', '/roles/list');
        $this->assertJson($response->getContent());
    }

    /**
     * test add success
     */
    public function testAddSuccess()
    {
        $this->post('/roles/create', $this->getFormData())->seeJson([
            'status' => 'success'
        ]);
    }

    /**
     * test add invalid
     */
    public function testAddInvalid()
    {
        $expectedErrors = new \stdClass();
        $expectedErrors->rol[] = 'El campo Rol es obligatorio';
        $this->post('/roles/create', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    /**
     * test edit success
     */
    public function testEditSuccess()
    {
        $this->put('/roles/edit/1', $this->getFormData())->seeJson([
                'status' => 'success'
        ]);
    }

    /**
     * test edit not found
     */
    public function testEditNotFound()
    {
        $this->put('/roles/edit/1000000', $this->getFormData())->seeJson([
            'status' => 'error',
            'message' => 'rol no encontrado',
        ]);
    }

    /**
     * test edit invalid
     */
    public function testEditInvalid()
    {
        $expectedErrors = new \stdClass();
        $expectedErrors->name[] = 'El campo Título es obligatorio';
        $this->put('/roles/edit/1', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    public function testDetail()
    {
        $response = $this->call('GET', '/roles/detail/1');
        $data = $this->parseJson($response);
        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('rol', $data);
    }

    /**
     * @param \Illuminate\Http\JsonResponse $response
     * @return mixed
     */
    protected function parseJson(Illuminate\Http\JsonResponse $response)
    {
        return json_decode($response->getContent());
    }

    /**
     *
     * @param $data
     */
    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }

    protected function getFormData()
    {
        return ['rol' => 'test role'];
    }

    protected function getFormDataIvalid()
    {
        return ['rol' => ''];
    }

}
