<?php

namespace Perezale\L5StompQueue;

//use MongoDB\Client;

class StompService {
    private $stomp;

    public function __construct($uri, $queue, $driverOptions) {
  		$mUri = $this->validate($uri, null);
  		$mQueue = $this->validate($queue, [], true);
  		$mDriverOptions = $this->validate($driverOptions, [], true);

      $this->stomp = new StdClass;
    }

	private function validate($val, $default, $json = false) {
		if (!empty($val) && is_string($val)) {
			if ($json) {
				return json_decode($val, true);
			}

			return $val;
		}

		return $default;
	}

    public function get() {
        return $this->stomp;
    }
}
