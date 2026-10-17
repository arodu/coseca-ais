<?php

declare(strict_types=1);

use Cake\Utility\Text;

/**
 * Tutores del demo, repartidos por tenant según la huella.
 */
class TutorSeed extends DemoSeedBase
{
    /**
     * @return void
     */
    public function run(): void
    {
        $targets = $this->profile()['targets'];
        $used = [];
        $usedNames = [];

        foreach ($targets['tutors_per_tenant'] as $tenantId => $count) {
            for ($i = 0; $i < $count; $i++) {
                [$first, $last, $name] = $this->uniqueName($usedNames);

                $this->fetchTable('Tutors')->saveOrFail(
                    $this->fetchTable('Tutors')->newEntity([
                        'name' => $name,
                        'dni' => (string)$this->rng->intBetween(10000000, 33000000),
                        'phone' => $this->phone(),
                        'email' => $this->emailFor($first, $last, $used),
                        'tenant_id' => $tenantId,
                    ]),
                );
            }
        }
    }

    /**
     * Nombre y apellido únicos dentro del demo.
     *
     * @param array<string, bool> $usedNames Nombres ya usados (por referencia).
     * @return array{0: string, 1: string, 2: string} [nombre, apellido, nombre completo]
     */
    private function uniqueName(array &$usedNames): array
    {
        for ($attempt = 0; $attempt < 50; $attempt++) {
            $first = $this->firstName();
            $last = $this->lastName();
            $name = $first . ' ' . $last;
            if (!isset($usedNames[$name])) {
                $usedNames[$name] = true;

                return [$first, $last, $name];
            }
        }

        $usedNames[$name] = true;

        return [$first, $last, $name];
    }

    /**
     * Email único `nombre.apellido@dominio`.
     *
     * @param string $first Nombre.
     * @param string $last Apellido.
     * @param array<string, bool> $used Emails usados (por referencia).
     * @return string
     */
    private function emailFor(string $first, string $last, array &$used): string
    {
        $base = Text::slug(strtolower($first . '.' . $last), '');
        $domain = $this->weighted(['gmail.com' => 7, 'hotmail.com' => 2, 'unerg.edu.ve' => 1]);

        $email = $base . '@' . $domain;
        $suffix = 1;
        while (isset($used[$email])) {
            $email = $base . $suffix++ . '@' . $domain;
        }
        $used[$email] = true;

        return $email;
    }

    /**
     * Teléfono venezolano (11 dígitos).
     *
     * @return string
     */
    private function phone(): string
    {
        return '04' . $this->rng->digits(9);
    }
}
