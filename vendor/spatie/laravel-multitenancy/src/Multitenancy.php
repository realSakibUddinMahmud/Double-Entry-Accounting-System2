<?php

namespace Spatie\Multitenancy;

use Illuminate\Contracts\Foundation\Application;
use Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction;
use Spatie\Multitenancy\Concerns\UsesMultitenancyConfig;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Events\TenantNotFoundForRequestEvent;
use Spatie\Multitenancy\Tasks\TasksCollection;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class Multitenancy
{
    use UsesMultitenancyConfig;

    public function __construct(public Application $app)
    {
    }

    public function start(): void
    {
        $this
            ->registerTenantFinder()
            ->registerTasksCollection()
            ->configureRequests()
            ->configureQueue();
    }

    public function end(): void
    {
        app(IsTenant::class)::forgetCurrent();
    }

    protected function determineCurrentTenant(): void
    {
        if (! $this->app['config']->get('multitenancy.tenant_finder')) {
            return;
        }

        /** @var \Spatie\Multitenancy\TenantFinder\TenantFinder $tenantFinder */
        $tenantFinder = $this->app[TenantFinder::class];

        $tenant = $tenantFinder->findForRequest($this->app['request']);

        if ($tenant instanceof IsTenant) {
            $tenant->makeCurrent();
        } else {
            event(new TenantNotFoundForRequestEvent($this->app['request']));
        }
    }

    protected function registerTasksCollection(): static
    {
        $this->app->singleton(TasksCollection::class, function () {
            $taskClassNames = $this->app['config']->get('multitenancy.switch_tenant_tasks');

            return new TasksCollection($taskClassNames);
        });

        return $this;
    }

    protected function registerTenantFinder(): static
    {
        $tenantFinderConfig = $this->app['config']->get('multitenancy.tenant_finder');

        if ($tenantFinderConfig) {
            $this->app->bind(TenantFinder::class, $tenantFinderConfig);
        }

        return $this;
    }

    protected function configureRequests(): static
    {
        if (! $this->app->runningInConsole()) {
            $this->determineCurrentTenant();
        }

        return $this;
    }

    protected function configureQueue(): static
    {
        $this
            ->getMultitenancyActionClass(
                actionName: 'make_queue_tenant_aware_action',
                actionClass: MakeQueueTenantAwareAction::class
            )
            ->execute();

        return $this;
    }
}
