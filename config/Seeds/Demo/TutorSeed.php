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
        $lexicon = $this->data('people');
        $used = [];

        foreach ($targets['tutors_per_tenant'] as $tenantId => $count) {
            for ($i = 0; $i < $count; $i++) {
                $gender = $this->faker->boolean(60) ? 'm' : 'f';
                $first = $this->faker->randomElement($lexicon[$gender === 'm' ? 'first_names_m' : 'first_names_f']);
                $last = $this->faker->randomElement($lexicon['last_names']);
                $name = $first . ' ' . $last;

                $this->fetchTable('Tutors')->saveOrFail(
                    $this->fetchTable('Tutors')->newEntity([
                        'name' => $name,
                        'dni' => (string)$this->faker->numberBetween(10000000, 33000000),
                        'phone' => $this->phone(),
                        'email' => $this->emailFor($first, $last, $used),
                        'tenant_id' => $tenantId,
                    ]),
                );
            }
        }
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
        return '04' . $this->faker->numerify('#########');
    }
}
