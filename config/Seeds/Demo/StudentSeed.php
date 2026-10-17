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
        $usedNames = [];

        foreach ($targets['students_per_tenant'] as $tenantId => $count) {
            $lapseId = (int)$this->fetchTable('Lapses')
                ->find()
                ->where(['tenant_id' => $tenantId])
                ->order(['id' => 'DESC'])
                ->firstOrFail()
                ->id;

            for ($i = 0; $i < $count; $i++) {
                $user = $this->createUser($tenantId, $lexicon, $usedDni, $usedEmail, $usedNames);
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
                        'phone' => '04' . $this->rng->digits(9),
                        'address' => $this->rng->pick($lexicon['addresses']),
                        'current_semester' => (int)$this->weighted(
                            array_map(
                                fn ($w) => $w * 100,
                                $targets['semester']['weights'],
                            ),
                        ),
                        'uc' => $this->rng->intBetween($targets['uc']['min'], $targets['uc']['max']),
                        'interest_area_id' => $this->rng->pick($areaIds),
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
     * @param array<string, bool> $usedNames Nombres completos usados (por referencia).
     * @return \App\Model\Entity\AppUser
     */
    private function createUser(int $tenantId, array $lexicon, array &$usedDni, array &$usedEmail, array &$usedNames): AppUser
    {
        do {
            $dni = $this->rng->intBetween(20000000, 33708425);
        } while (isset($usedDni[$dni]));
        $usedDni[$dni] = true;

        do {
            $first = $this->rng->pick($this->rng->chance(78) ? $lexicon['first_names_m'] : $lexicon['first_names_f']);
            $last = $this->rng->pick($lexicon['last_names']);
            $fullName = $first . ' ' . $last;
        } while (isset($usedNames[$fullName]));
        $usedNames[$fullName] = true;

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

        $email = $base . $this->rng->intBetween(1, 99) . '@' . $domain;
        $suffix = 1;
        while (isset($used[$email])) {
            $email = $base . $this->rng->intBetween(100, 9999) . $suffix++ . '@' . $domain;
        }
        $used[$email] = true;

        return $email;
    }
}
