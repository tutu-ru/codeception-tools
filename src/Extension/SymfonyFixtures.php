<?php
declare(strict_types=1);

namespace TutuRu\CodeceptionTools\Extension;

use \Codeception\Events;

class SymfonyFixtures extends \Codeception\Extension
{
    public static $events = [
        Events::SUITE_BEFORE => 'beforeSuite',
    ];

    public function beforeSuite()
    {
        try {
            /** @var \Codeception\Module\Cli $cli */
            $cli = $this->getModule('Cli');

            $this->writeln('Loading fixtures...');
            $cli->runShellCommand('bin/console doctrine:fixtures:load --no-interaction');
            $cli->seeResultCodeIs(0);
            $this->writeln('Fixtures loaded');
        } catch (\Exception $e) {
            $this->writeln(
                sprintf(
                    'An error occurred whilst seeding the test database: %s',
                    $e->getMessage()
                )
            );
        }
    }
}