<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Locator\LocatorAwareTrait;
use Faker\Factory;

/**
 * TrackingTest command.
 */
class TrackingTestCommand extends Command
{
    use LocatorAwareTrait;

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        $parser->addOption('adscription_id', [
            'short' => 'a',
            'help' => 'The id of the adscription to be processed',
            'required' => true,
        ]);

        $parser->addOption('records', [
            'short' => 'r',
            'help' => 'Cantidad de actividades a generar',
            'default' => 30,

        ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io): void
    {
        $faker = Factory::create();
        $adscriptionId = $args->getOption('adscription_id');
        $records = (int)$args->getOption('records') ?? 30;

        $trackingTable = $this->fetchTable('StudentTracking');

        for ($i = 0; $i < $records; $i++) {
            $tracking = $trackingTable->newEmptyEntity();
            $tracking->student_adscription_id = $adscriptionId;
            $tracking->description = $faker->text(100);
            $tracking->hours = $faker->numberBetween(1, 10);
            $tracking->date = $faker->dateTimeBetween('-1 month', 'now');

            $trackingTable->saveOrFail($tracking);
        }
    }
}
