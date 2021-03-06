<?php
namespace Kurio\HttpClient;

use Illuminate\Support\ServiceProvider;
use Ivory\HttpAdapter\Event\Subscriber\RedirectSubscriber;
use Ivory\HttpAdapter\EventDispatcherHttpAdapter;
use Ivory\HttpAdapter\HttpAdapterFactory;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\PsrHttpAdapterInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $http_adapter = $this->getHttpAdapter();
        $event_dispatcher = $this->getEventDispatcher();

        $this->app->bind(HttpAdapterInterface::class, function () use ($http_adapter, $event_dispatcher) {
            return new EventDispatcherHttpAdapter($http_adapter, $event_dispatcher);
        });

        $this->app->bind('http', HttpAdapterInterface::class);
    }

    /**
     * @return PsrHttpAdapterInterface
     */
    protected function getHttpAdapter()
    {
        $preferred_library = [
            HttpAdapterFactory::GUZZLE6,
            HttpAdapterFactory::GUZZLE5,
        ];
        return HttpAdapterFactory::guess($preferred_library);
    }

    /**
     * @return EventDispatcher
     */
    protected function getEventDispatcher()
    {
        $dispatcher = new EventDispatcher;

        $redirect_subsciber = new RedirectSubscriber;
        $dispatcher->addSubscriber($redirect_subsciber);

        return $dispatcher;
    }
}