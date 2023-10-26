<?php

namespace Tests;

use app\models\Appointment;
use app\models\Employee;
use PHPUnit\Framework\TestCase;
use app\service\AppointmentService;

class AppointmentServiceTest extends TestCase {

    public function testListAppointments() {

        // id", "seq", "create_date", "update_date", "start_date", "end_date", "total_time", "id_employee", "enabled", "description_work
        $appointments = [
            [
                'id' => 1,
                'seq' => 1,
                'create_date' => '2020-01-01 01:00:00',
                'update_date' => '2020-01-01 02:00:00',
                'start_date' => '2020-01-01 03:00:00',
                'end_date' => '2020-01-01 04:00:00',
                'total_time' => 3600,
                'id_employee' => 1,
                'enabled' => 1,
                'description_work' => 'description_work1',
            ],
            [
                'id' => 2,
                'seq' => 2,
                'create_date' => '2020-01-01 01:00:00',
                'update_date' => '2020-01-01 02:00:00',
                'start_date' => '2020-01-01 03:00:00',
                'end_date' => '2020-01-01 04:00:00',
                'total_time' => 100,
                'id_employee' => 1,
                'enabled' => 1,
                'description_work' => 'description_work1',
            ],
        ];

        $employee = [
            'id' => 1,
            'name' => 'João Beleño',
            'code' => '1',
        ];

        // Mock da classe Appointment
        $appointmentMock = $this->createMock(Appointment::class);

        // Definir o valor de retorno esperado para o método 'where'
        $appointmentMock->expects($this->once())
            ->method('where')
            ->willReturn($appointments);

        $appointmentMock->expects($this->once())
            ->method('count')
            ->willReturn(2);

        // Mock da classe Employee
        $employeeMock = $this->createMock(Employee::class);

        // Definir o valor de retorno esperado para o método 'find'
        $employeeMock->expects($this->once())
            ->method('find')
            ->willReturn($employee);

        $appointmentService = new AppointmentService($appointmentMock, $employeeMock);

        $result = $appointmentService->listAppointments(1, 1);

        $expectedData = [
            'employee' => [
                'id' => 1,
                'name' => 'João Beleño',
                'code' => '1',
            ],
            'range' => 0,
            'total_appointments' => 2,
            'appointments' => [
                [
                    'id' => 1,
                    'seq' => 1,
                    'create_date' => '01/01/2020 01:00:00',
                    'update_date' => '01/01/2020 02:00:00',
                    'start_date' => '2020-01-01 03:00:00',
                    'end_date' => '01/01/2020 04:00:00',
                    'total_time' => '01:00:00',
                    'id_employee' => 1,
                    'enabled' => 1,
                    'description_work' => 'description_work1',
                    'start_date_format' => '01/01/2020 03:00:00',
                ],
                [
                    'id' => 2,
                    'seq' => 2,
                    'create_date' => '01/01/2020 01:00:00',
                    'update_date' => '01/01/2020 02:00:00',
                    'start_date' => '2020-01-01 03:00:00',
                    'end_date' => '01/01/2020 04:00:00',
                    'total_time' => '00:01:40',
                    'id_employee' => 1,
                    'enabled' => 1,
                    'description_work' => 'description_work1',
                    'start_date_format' => '01/01/2020 03:00:00',
                ],
            ],
            'page' => 1,
        ];

        
        $this->assertEquals($expectedData, $result);
    }
}
