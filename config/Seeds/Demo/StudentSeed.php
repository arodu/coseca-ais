<?php

declare(strict_types=1);

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use Cake\Utility\Text;

/**
 * Estudiantes del demo.
 *
 * Importante: `AppUsersTable::afterSave()` ya crea el `Student` y su etapa
 * `register` al guardar un usuario con rol `student`. Por eso aquí NO se llama
 * `StudentsTable::newRegularStudent()` de nuevo: se recupera el `Student`
 * auto-generado y solo se completan sus datos (lapse, `student_data`).
 */
class StudentSeed extends DemoSeedBase
{
    /**
     * @return void
     */
    public function run(): void
    {
        $targets = $this->profile()['targets'];
        $lexicon = $this->data('people');

        $areaIds = array_column(
            $this->fetchTable('InterestAreas')
                ->find()
                ->select(['id'])
                ->where(['program_id' => 1])
                ->disableHydration()
                ->all()
                ->toArray(),
            'id',
        );

        $usedDni = [];
        $usedEmail = [];

        foreach ($targets['students_per_tenant'] as $tenantId => $count) {
            $lapseId = (int)$this->fetchTable('Lapses')
                ->find()
                ->where(['tenant_id' => $tenantId])
                ->order(['id' => 'DESC'])
                ->firstOrFail()
                ->id;

            for ($i = 0; $i < $count; $i++) {
                $user = $this->createUser($tenantId, $lexicon, $usedDni, $usedEmail);
                $student = $this->fetchTable('Students')
                    ->find()
                    ->where(['user_id' => $user->id])
                    ->firstOrFail();

                $student = $this->fetchTable('Students')->patchEntity($student, ['lapse_id' => $lapseId]);
                $this->fetchTable('Students')->saveOrFail($student);

                $this->fetchTable('StudentData')->saveOrFail(
                    $this->fetchTable('StudentData')->newEntity([
                        'student_id' => $student->id,
                        'gender' => $this->weighted($targets['gender_ratio']),
                        'phone' => '04' . $this->faker->numerify('#########'),
                        'address' => $this->faker->randomElement($lexicon['addresses']),
                        'current_semester' => (int)$this->weighted(
                            array_map(
                                fn ($w) => $w * 100,
                                $targets['semester']['weights'],
                            ),
                        ),
                        'uc' => $this->faker->numberBetween($targets['uc']['min'], $targets['uc']['max']),
                        'interest_area_id' => $this->faker->randomElement($areaIds),
                        'observations' => null,
                    ]),
                );
            }
        }
    }

    /**
     * Crea el `AppUser` estudiante (el `Student` se genera vía `afterSave`).
     *
     * @param int $tenantId Tenant del usuario.
     * @param array $lexicon Léxico de personas.
     * @param array<int, bool> $usedDni DNI usados (por referencia).
     * @param array<string, bool> $usedEmail Emails usados (por referencia).
     * @return \App\Model\Entity\AppUser
     */
    private function createUser(int $tenantId, array $lexicon, array &$usedDni, array &$usedEmail): AppUser
    {
        do {
            $dni = $this->faker->numberBetween(20000000, 33708425);
        } while (isset($usedDni[$dni]));
        $usedDni[$dni] = true;

        $first = $this->faker->randomElement(
            $this->faker->boolean(78) ? $lexicon['first_names_m'] : $lexicon['first_names_f'],
        );
        $last = $this->faker->randomElement($lexicon['last_names']);

        $data = [
            'email' => $this->emailFor($first, $last, $usedEmail),
            'password' => '1234',
            'dni' => (string)$dni,
            'first_name' => $first,
            'last_name' => $last,
            'role' => UserRole::STUDENT->value,
            'active' => true,
            'tenant_filters' => [['tenant_id' => $tenantId]],
        ];

        $user = $this->fetchTable('AppUsers')->newEntity($data);
        $user->set('role', UserRole::STUDENT->value);
        $this->fetchTable('AppUsers')->saveOrFail($user);

        return $user;
    }

    /**
     * Email único para el estudiante.
     *
     * @param string $first Nombre.
     * @param string $last Apellido.
     * @param array<string, bool> $used Emails usados (por referencia).
     * @return string
     */
    private function emailFor(string $first, string $last, array &$used): string
    {
        $base = Text::slug(strtolower($first . '.' . $last), '');
        $domain = $this->weighted(['gmail.com' => 97, 'hotmail.com' => 2, 'unerg.edu.ve' => 1]);

        $email = $base . $this->faker->numberBetween(1, 99) . '@' . $domain;
        $suffix = 1;
        while (isset($used[$email])) {
            $email = $base . $this->faker->numberBetween(100, 9999) . $suffix++ . '@' . $domain;
        }
        $used[$email] = true;

        return $email;
    }
}
