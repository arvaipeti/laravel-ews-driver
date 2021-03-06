<?php

namespace Adeboyed\LaravelExchangeDriver;

use Illuminate\Mail\MailManager;
use Illuminate\Support\ServiceProvider;
use \jamesiarmes\PhpEws\Enumeration\MessageDispositionType;

use Adeboyed\LaravelExchangeDriver\Transport\ExchangeTransport;


class ExchangeAddedServiceProvider extends ServiceProvider
{
    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(MailManager::class, function (MailManager $mail_manager) {
            $mail_manager->extend("exchange", function ($config) {
                $config = $this->app['config']->get('mail.mailers.exchange', []);
                $host = $config['host'];
                $username = $config['username'];
                $password = $config['password'];
                $version = $config['version'];
                $fromName = $config['fromName'];
                $fromEmailAddress = $config['fromEmailAddress'];
                $messageDispositionType = $config['messageDispositionType'];

                return new ExchangeTransport($host, $fromName, $fromEmailAddress, $username, $password, $version, $messageDispositionType);
            });
        });
    }
}
