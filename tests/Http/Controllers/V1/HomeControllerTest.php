<?php

namespace Tests\Http\Controllers\V1;

use Tests\TestCase;

class HomeControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get(route("welcome"));
        $response->assertStatus(200);
    }

    public function testStore()
    {

    }

    public function testCreate()
    {

    }

    public function testShow()
    {

    }

    public function testUpdate()
    {

    }

    public function testDestroy()
    {

    }

    public function testEdit()
    {

    }
}
