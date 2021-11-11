<?php
namespace Invoice\Providers;

use Illuminate\Support\ServiceProvider;
use Invoice\Entities\Item;
use Invoice\Repositories\ItemRepositoryInterface;
use LaravelDoctrine\ORM\IlluminateRegistry;

class InvoiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class, function () {
            return app(IlluminateRegistry::class)->getRepository(Item::class, null);
        });
    }
}
