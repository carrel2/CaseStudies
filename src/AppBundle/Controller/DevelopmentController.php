<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DevelopmentController extends Controller
{
  /**
   * @Route("/development", name="development")
   */
  public function developmentAction()
  {
    return $this->render('Development/devel.html.twig');
  }

  /**
   * @Route("/run/{command}", name="developmentRunCommand", requirements={"command": "docs|schema|entities|update|clear"})
   */
  public function runAction($command)
  {
    $docs = 'phpdoc -d /var/www/project/src/AppBundle/ -f /var/www/project/vendor/doctrine/collections/lib/Doctrine/Common/Collections/ArrayCollection.php -t /var/www/project/web/files/docs/';
    $schema = 'java -jar ~/schemaspy.jar -t mysql -o /var/www/project/web/files/schema -host localhost -db project -u brandon -p password -dp /usr/share/java/mysql-connector-java.jar';
    $entities = 'php /var/www/project/bin/console doctrine:generate:entities AppBundle';
    $update = 'php /var/www/project/bin/console doctrine:schema:update --force';
    $clear = 'php /var/www/project/bin/console cache:clear';
    $stdout = [];
    $stderr = [];

    $process = new Process($$command);
    $process->start();

    foreach ($process as $type => $data) {
      if( $process::OUT === $type ) {
        $stdout[] = $data;
      } else {
        $stderr[] = $data;
      }
    }

    return $this->render('Development/output.html.twig', array(
      'command' => $command,
      'stdout' => $stdout,
      'stderr' => $stderr,
    ));
  }
}