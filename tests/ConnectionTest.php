<?php

use Stomp\SimpleStomp;
use Stomp\Broker\ActiveMq\ActiveMq;

class ConnectionTest extends PHPUnit_Framework_TestCase {

  /**
   * @var SimpleStomp
   */
  private $simpleStomp;
  /**
   * @var Client
   */
  private $Stomp;

  private $queue = '/queue/test';
  private $topic = '/topic/test';


  public function testConnect()
  {
      // make a connection
      $statefulStomp = new \Stomp\StatefulStomp($this->Stomp);

      $client = $statefulStomp->getClient();

      $this->assertFalse($client->isConnected());

      $client->connect();

      $this->assertTrue($client->isConnected());
      $this->assertNotNull($client->getSessionId());

      $client->disconnect();
  }

  public function testInitialStateIsProducer()
  {
      $stateful = new \Stomp\StatefulStomp(new \Stomp\Client('tcp://127.0.0.1:61613'));
      $this->assertInstanceOf(\Stomp\States\ProducerState::class, $stateful->getState());
  }

  protected function setUp(){
    parent::setUp();
    $this->Stomp = ClientProvider::getClient();
    $this->simpleStomp = new SimpleStomp($this->Stomp);
  }

  public function testActiveMQ()
  {

    if (! $this->Stomp->isConnected()) {
        $this->Stomp->setSync(false);
        $this->Stomp->connect();
    }

    $this->assertInstanceOf(ActiveMq::class, $this->Stomp->getProtocol(), 'Expected an ActiveMq Broker.');

    $this->Stomp->send($this->topic, "hello",  ['persistent' => 'true']);

    $this->Stomp->disconnect();

  }

  protected function tearDown()
  {
      $this->Stomp = null;
      parent::tearDown();
  }

  /*public function testConsume()
  {
      // make a connection
      $con = new \FuseSource\Stomp\Stomp("tcp://localhost:61613");

      $con->connect();

      $this->assertTrue($con->isConnected());
      $this->assertNotNull($con->getSessionId());

      $con->subscribe("teste");

      $msg = $con->readFrame();

      if ( $msg != null) {
          echo "Received message with body '$msg->body'\n";
          // mark the message as received in the queue
          $con->ack($msg);
      } else {
          echo "Failed to receive a message\n";
      }

      $con->disconnect();
  }*/
}
