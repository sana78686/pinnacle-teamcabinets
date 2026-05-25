<?php

namespace Tests\Unit;

use App\Services\UserDoorFactorService;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class UserDoorFactorServiceTest extends TestCase
{
    public function test_selected_catalog_ids_from_json_style_payload(): void
    {
        $service = new UserDoorFactorService(
            $this->createMock(\App\Services\OrderPricingService::class)
        );

        $request = Request::create('/', 'POST', [
            'catalog_visibility' => [
                '1' => '1',
                '2' => '2',
            ],
            'door_factors' => [
                '1' => [
                    '10' => '0.22',
                ],
            ],
        ]);

        $method = new ReflectionMethod(UserDoorFactorService::class, 'selectedCatalogIds');

        $ids = $method->invoke($service, $request);

        $this->assertSame([1, 2], $ids);
    }
}
