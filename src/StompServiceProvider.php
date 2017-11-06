<?php

namespace Perezale\L5StompQueue;

use Illuminate\Support\ServiceProvider;

class StompServiceProvider extends ServiceProvider {

  protected $defer = true;

	public function boot() {

	}

  public function register() {

      $this->app->singleton('StompService', function($app) {
          $config = $app->make('config');

          $uri = 'tcp://localhost:61613';
          $queue = 'default';
          $driverOptions = 'stomp';
          /*
          $uri = $config->get('mongo.uri');
          $uriOptions = $config->get('mongo.uriOptions');
          $driverOptions = $config->get('mongo.driverOptions');
          */

          return new StompService($uri, $queue, $driverOptions);
      });
  }

  public function provides() {
       return ['stomp'];
   }

}
