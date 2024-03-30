<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * CreateManagerUser command.
 */
class CreateUserCommand extends Command
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = $this->fetchTable('AppUsers');
    }

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

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        try {
            $dni = $io->ask('Cedula: ');
            $firstName = $io->ask('Primer Nombre: ');
            $lastName = $io->ask('Primer Apellido: ');
            $email = $io->ask('email: ');
            $password = $io->ask('Contraseña: ');
            $active = $io->askChoice('usuario activo?', ['yes', 'no'], 'yes');
            $role = $io->askChoice('Permisos:', ['student', 'admin', 'assistant', 'tutor', 'manager', 'root'], 'manager');

            $user = $this->Users->newEntity([
                'dni' => $dni,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'username' => $email,
                'active' => $active === 'yes',
                'password' => $password,
            ]);

            $user->set('role', $role);

            $this->Users->saveOrFail($user);

            $io->success('Usuario creado con exito');

            return static::CODE_SUCCESS;
        } catch (\Throwable $th) {
            $io->error($th->getMessage());

            return static::CODE_ERROR;
        }
    }
}
